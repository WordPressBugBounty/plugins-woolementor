<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Codexpert\CoDesigner\Helper;
use \Elementor\Plugin as Elementor_Plugin;
use \Elementor\Controls_Manager;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Widgets
 * @author Codexpert <hi@codexpert.io>
 */
class Widgets extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $version;

	public $widgets;

	public $active_widgets;

	public $active_controls;
	
	public $assets;

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 */
	public function __construct( $plugin ) {
		$this->plugin   = $plugin;
        $this->slug     = $this->plugin['TextDomain'];
        $this->name     = $this->plugin['Name'];
        $this->version  = $this->plugin['Version'];
		$this->widgets 	= codesigner_widgets();
		$this->active_widgets 	= wcd_active_widgets();
		$this->active_controls 	= $this->active_widgets;
		$this->assets 	= CODESIGNER_ASSETS;
	}

	public function enqueue_styles() {

		// Are we in debug mode?
		$min 	= defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( "{$this->slug}-editor", "{$this->assets}/css/editor{$min}.css", '', $this->version, 'all' );
		wp_enqueue_style( 'codesigner-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0', 'all' );
		wp_enqueue_style( 'font-awesome-free', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', '', $this->version, 'all' );

		$enable = Helper::get_option( 'codesigner_tools', 'cross_domain_copy_paste' );
		if ( $enable == 'on' ) {
			/**
			 * Using for cross domain copy-paste
			 * @source https://cdn.jsdelivr.net/npm/xdlocalstorage@2.0.5/dist/scripts/xdLocalStorage.min.js
			 */
			wp_enqueue_script( "{$this->slug}-xdLocalStorage", "{$this->assets}/third-party/xdLocalStorage/xdLocalStorage.min.js", [], $this->version, true );
			wp_enqueue_script( "{$this->slug}-xd-copy-paste", "{$this->assets}/js/xd-copy-paste.js", [], $this->version, true );
		}

		wp_enqueue_script( "{$this->slug}-editor", "{$this->assets}/js/editor.js", [], $this->version, true );
		
		// theme compatibilty
		if( file_exists( CODESIGNER_DIR . '/assets/css/themes/' . ( $template = get_stylesheet() ) . "{$min}.css" ) ) {
			wp_enqueue_style( "{$this->slug}-{$template}", "{$this->assets}/css/themes/{$template}{$min}.css", '', $this->version, 'all' );
		}
	}

	/**
	 * Registers categories for widgets
	 *
	 * @since 1.0
	 */
	public function register_category( $elements_manager ) {
		foreach ( wcd_widget_categories() as $id => $data ) {
			$elements_manager->add_category(
				$id,
				[
					'title'	=> $data['title'],
					'icon'	=> $data['icon'],
				]
			);
		}
	}

	/**
	 * Registers THE widgets
	 *
	 * @since 1.0
	 */
	public function register_widgets() {

		$widgets_manager = Elementor_Plugin::instance()->widgets_manager;

		foreach( $this->active_widgets as $active_widget ) {
			
			if( ! apply_filters( 'wcd_register_widget', true, $active_widget ) ) continue;
			
			$class	= str_replace( ' ', '_', ucwords( str_replace( array( '-', '.php' ), array( ' ', '' ), $active_widget ) ) );
			$widget	= '';

			if(
				wcd_is_pro_feature( $active_widget ) &&
				defined( 'CODESIGNER_PRO_DIR' ) &&
				wcd_is_pro_activated() &&
				file_exists( $file = CODESIGNER_PRO_DIR . "/widgets/{$active_widget}/{$active_widget}.php" )
			) {
				require_once( $file );
				$widget = "Codexpert\\CoDesigner_Pro\\{$class}";

			}
			elseif( file_exists( $file = CODESIGNER_DIR . "/widgets/{$active_widget}/{$active_widget}.php" ) ) {
				require_once( $file );
				$widget = "Codexpert\\CoDesigner\\{$class}";
			}

			if( class_exists( $widget ) ) {

				/**
				  * Elementor 3.5.0 compat
				  * @since 3.16
				  */
				$register = method_exists( $widgets_manager, 'register' ) ? 'register' : 'register_widget_type';
				$widgets_manager->$register( new $widget() );
			}
		}
	}

	/**
	 * Registers additional controls for widgets
	 *
	 * @since 1.0
	 */
	public function register_controls() {
		include_once( CODESIGNER_DIR . '/controls/gradient-text.php' );
        $gradient_text = __NAMESPACE__ . '\Controls\Group_Control_Gradient_Text';
        Elementor_Plugin::instance()->controls_manager->add_group_control( $gradient_text::get_type(), new $gradient_text() );
		
		include_once( CODESIGNER_DIR . '/controls/sortable-select.php' );
		$sortable_select = __NAMESPACE__ . '\Controls\Sortable_Select';
		Elementor_Plugin::instance()->controls_manager->register( new $sortable_select() );
		
		include_once( CODESIGNER_DIR . '/controls/sortable-taxonomy.php' );
		$sortable_taxonomy = __NAMESPACE__ . '\Controls\Sortable_Taxonomy';
		Elementor_Plugin::instance()->controls_manager->register( new $sortable_taxonomy() );
	}

	/**
	 * Enables Codesigner's place in the default content
	 *
	 * @since 1.0
	 *
	 * @TODO: use a better hook to add this
	 */
	public function the_content( $content ) {
		$content_start = apply_filters( 'codesigner-content_start', '' );
		$content_close = apply_filters( 'codesigner-content_close', '' );

		return $content_start . $content . $content_close;
	}

	public function add_source_type( $options ) {
		$options[ 'recently-viewed' ]	= __( 'Recently Viewed', 'codesigner' );
		$options[ 'recently-sold' ]		= __( 'Recently Sold', 'codesigner' );

		return $options;
	}

	public function set_filter_query( $wp_query ) {

		if ( ! isset( $wp_query->query ) || ! isset( $wp_query->query['post_type'] ) || $wp_query->query['post_type'] != 'product' ) return;
			
		if ( ! isset( $_GET['filter'] ) || empty( $_GET['filter'] ) ) return;

		if( ! empty( $_GET['filter']['taxonomies'] ) ) {
			$taxonomies = [];
			foreach ( $_GET['filter']['taxonomies'] as $key => $term ) {
		        $taxonomies[] = array(
		          'taxonomy' => sanitize_text_field( $key ),
		          'field'    => 'slug',
		          'terms'    => array_map( 'sanitize_text_field', $term )
		        );
			}

			$wp_query->set( 'tax_query', $taxonomies );
		}

		if ( isset( $_GET['filter']['max_price'] ) && $_GET['filter']['max_price'] != '' && isset( $_GET['filter']['min_price'] ) && $_GET['filter']['min_price'] != '' ) {
			$max_price = codesigner_sanitize_number( $_GET['filter']['max_price'] );
			$min_price = codesigner_sanitize_number( $_GET['filter']['min_price'] );

	       	$meta_query[] = array(
		          'key' 	=> '_price',
	              'value' 	=> [ $min_price, $max_price ],
	              'compare' => 'BETWEEN',
	              'type' 	=> 'NUMERIC'
	        );

	        $default_metaq = $wp_query->meta_query ? $wp_query->meta_query : [];
			$wp_query->set( 'meta_query', array_merge( $default_metaq, $meta_query ) );
		}

		if ( isset( $_GET['filter']['orderby'] ) ) {					
			$orderby = sanitize_text_field( $_GET['filter']['orderby'] );
			$args['orderby']	= $orderby;
			$wp_query->set( 'orderby', $orderby );

		    if( in_array( $orderby, [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
		    	$args['meta_key']	= $orderby;
		    	$args['orderby'] 	= 'meta_value_num';
				$wp_query->set( 'meta_key', $orderby );
				$wp_query->set( 'orderby', 'meta_value_num' );
		    }
		}
		
		if( isset( $_GET['filter']['order'] ) ){
	        $order	= sanitize_text_field( $_GET['filter']['order'] );
			$wp_query->set( 'order', $order );
	    }

	    if( isset( $_GET['filter']['q'] ) ){
	        $q		= sanitize_text_field( $_GET['filter']['q'] );
			$wp_query->set( 's', $q );
	    }

	    if( isset( $_GET['filter']['reviews'] ) ){
	        $reviews		= sanitize_text_field( $_GET['filter']['reviews'] );
	        
	       	$meta_query[] = array(
		          'key' 	=> '_wc_average_rating',
	              'value' 	=> [ $reviews, 5 ],
	              'compare' => 'BETWEEN',
	              'type' 	=> 'NUMERIC'
	        );
			$wp_query->set( 'meta_query', $meta_query );
	    }
	}

	public function shop_query_controls( $element ) {
		
		/**
		 * Product Source
		 */
		$element->start_controls_section(
		    'product_source_control',
		    [
		        'label' => __( 'Product Source', 'codesigner-pro' ),
		        'tab'   => Controls_Manager::TAB_CONTENT,
		    ]
		);


		$element->add_control(
		    'product_source',
		    [
		        'label'     => __( 'Source Type', 'codesigner-pro' ),
		        'type'      => Controls_Manager::SELECT,
		        'default'   => 'shop',
		        'options'   => wcd_product_source_type(),
		        'label_block' => true
		    ]
		);

		/**
		 * Query non shop types
		 */
		$element->start_controls_tabs(
		    'non_shop_souce_section',
		    [
		        'separator' => 'before',
		        'condition' => [
		            'product_source!' => 'shop'
		        ],
		    ]
		);

		$element->start_controls_tab(
		    'non_shop_souce_tab',
		    [
		        'label'     => __( '', 'codesigner-pro' ),
		    ]
		);

		$element->add_control(
		    'content_source',
		    [
		        'label' => __( 'Content Source', 'codesigner-pro' ),
		        'type' => Controls_Manager::SELECT,
		        'options' => [
		            'current_product'   => __( 'Current Product', 'codesigner-pro' ),
		            'different_product' => __( 'Custom', 'codesigner-pro' ),
		        ],
		        'default' => 'current_product' ,
		        'label_block' => true,
		        'conditions'  => [
		            'relation' => 'or',
		            'terms' => [
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'related-products',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cross-sells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'upsells',
		                ],
		            ] 
		        ],
		    ]
		);

		$element->add_control(
		    'main_product_id',
		    [
		        'label'     => __( 'Product ID', 'codesigner-pro' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
		        'description'  => __( 'Input the base product ID', 'codesigner-pro' ),
		        'separator' => 'after',
		        'conditions'  => [
		            'terms' => [
		                [
		                    'name' => 'content_source',
		                    'operator' => '==',
		                    'value' => 'different_product',
		                ],
		                [
		                	'relation' => 'or',
		                	'terms' => [
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'cross-sells',
		                		],
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'upsells',
		                		],
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'related-products',
		                		],
		                	]
		                ]
		            ] 
		        ],
		    ]
		);

		$element->add_control(
		    'product_limit',
		    [
		        'label'     => __( 'Products Limit', 'codesigner-pro' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => 3,
		        'min'   	=> 0,
		        'description'  => __( 'Number of products to show', 'codesigner-pro' ),
		    ]
		);

		$element->add_control(
		    'ns_exclude_products',
		    [
		        'label'     => __( 'Exclude Products', 'codesigner-pro' ),
		        'type'      => Controls_Manager::TEXT,
		        'separator' => 'before',
		        'description'  => __( "Comma separated ID's of products that should be excluded", 'codesigner-pro' ),
		        'conditions'     => [
		            'relation' => 'or',
		            'terms' => [
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'related-products',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-cross-sells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-upsells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-related-products',
		                ],
		            ]
		        ],
		    ]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();

		/**
		 * Query controls
		 */
		$element->add_control(
		    'custom_query',
		    [
		        'label'         => __( 'Custom Query', 'codesigner-pro' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'codesigner-pro' ),
		        'label_off'     => __( 'No', 'codesigner-pro' ),
		        'return_value'  => 'yes',
		        'default'       => 'no',
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'number',
		    [
		        'label'     => __( 'Products per page', 'codesigner-pro' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => 6,
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'order',
		    [
		        'label'         => __( 'Order', 'codesigner-pro' ),
		        'type'          => Controls_Manager::SELECT,
		        'default'       => 'ASC',
		        'options'       => [
		            'ASC'       => __( 'ASC', 'codesigner-pro' ),
		            'DESC'      => __( 'DESC', 'codesigner-pro' ),
		        ],
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'orderby',
		    [
		        'label'         => __( 'Order By', 'codesigner-pro' ),
		        'type'          => Controls_Manager::SELECT,
		        'default'       => 'ID',
		        'options'       => wcd_order_options(),
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->start_controls_tabs(
		    'custom_query_section_separator',
		    [
		        'separator' => 'before',
		        'condition' => [
		            'custom_query' => 'yes',
		            'product_source' => 'shop'
		        ],
		    ]
		);

		$element->start_controls_tab(
		    'custom_query_section_normal',
		    [
		        'label'     => __( 'Custom Query', 'codesigner-pro' ),
		    ]
		);

		/**
		 * query by author
		 * 
		 * @author Jakaria Istauk <jakariamd35@gmail.com>
		 * 
		 * @since 3.0
		 */
		$element->add_control(
		    'author',
		    [
		        'label'     => __( 'Author ID', 'codesigner-pro' ),
		        'type'      => Controls_Manager::NUMBER,
		    ]
		);

		$element->add_control(
		    'categories',
		    [
		        'label'     => __( 'Include Category', 'codesigner-pro' ),
		        'type'      => Controls_Manager::SELECT2,
		        'options'   => wcd_get_terms(),
		        'multiple'  => true,
		        'label_block' => true,
		    ]
		);

		$element->add_control(
		    'exclude_categories',
		    [
		        'label'     => __( 'Exclude Categories', 'codesigner-pro' ),
		        'type'      => Controls_Manager::SELECT2,
		        'options'   => wcd_get_terms(),
		        'multiple'  => true,
		        'label_block' => true,
		    ]
		);

		$element->add_control(
		    'include_products',
		    [
		        'label'         => __( 'Include Products', 'codesigner-pro' ),
		        'type'          => Controls_Manager::TEXT,
		        'label_block'   => 'block',
		        'description'   => __( 'Separate product ID\'s with comma delimiter', 'codesigner-pro' ),
		    ]
		);

		$element->add_control(
		    'exclude_products',
		    [
		        'label'         => __( 'Exclude Products', 'codesigner-pro' ),
		        'type'          => Controls_Manager::TEXT,
		        'label_block'   => 'block',
		        'description'   => __( 'Separate product ID\'s with comma delimiter', 'codesigner-pro' ),
		    ]
		);

		$element->add_control(
		    'sale_products_show_hide',
		    [
		        'label'         => __( "'On Sale' Products Only", 'codesigner-pro' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'codesigner-pro' ),
		        'label_off'     => __( 'No', 'codesigner-pro' ),
		        'return_value'  => 'yes',
		        'default'       => 'no',
		    ]
		);

		$element->add_control(
		    'out_of_stock',
		    [
		        'label'         => __( "Hide Stock out products", 'codesigner-pro' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'codesigner-pro' ),
		        'label_off'     => __( 'No', 'codesigner-pro' ),
		        'return_value'  => 'yes',
		        'default'       => '',
		    ]
		);

		$element->add_control(
		    'offset',
		    [
		        'label'         => __( 'Offset', 'codesigner-pro' ),
		        'type'          => Controls_Manager::NUMBER,
		    ]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();
		$element->end_controls_section();
	}
}