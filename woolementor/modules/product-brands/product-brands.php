<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;

class Product_Brands extends Base {

	public $id = 'codesigner_product_brands';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->action( 'init', 'register_taxonomies' );
        $this->action( 'woocommerce_product_meta_start', 'add_custom_taxonomy_to_product_meta', 5 );
	}

	public function __settings ( $settings ) {
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'Product Brands', 'codesigner' ),
            'icon'      => 'dashicons-tide',
            'sticky'	=> false,
            'fields'	=> [
                [
                    'id'      	=> 'pb_name',
                    'label'     => __( 'Product Brands Name text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Brands',
                    'desc'   	=> __( 'Change this if you want to chnage brand name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_singular_name',
                    'label'     => __( 'Singular Name text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Brand',
                    'desc'   	=> __( 'Change this if you want to chnage singular name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_popular_items',
                    'label'     => __( 'Popular Items text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Popular Brands',
                    'desc'   	=> __( 'Change this if you want to chnage popular items', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_search_items',
                    'label'     => __( 'Search Items Text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Search Brands',
                    'desc'   	=> __( 'Change this if you want to chnage search items name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_all_items',
                    'label'     => __( 'All Items text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'All Brands',
                    'desc'   	=> __( 'Change this if you want to chnage all items name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_parent_item',
                    'label'     => __( 'Parent Item text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Parent Brand',
                    'desc'   	=> __( 'Change this if you want to chnage parent item name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_parent_item_colon',
                    'label'     => __( 'Parent Item Colon text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Parent Brand',
                    'desc'   	=> __( 'Change this if you want to chnage parent item colon name', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_edit_item',
                    'label'     => __( 'Edit Item text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Edit Brand',
                    'desc'   	=> __( 'Change this if you want to chnage edit item text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_update_item',
                    'label'     => __( 'Update Item text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Update Brand',
                    'desc'   	=> __( 'Change this if you want to chnage update item text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_add_new_item',
                    'label'     => __( 'Add New Item text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Add New Brand',
                    'desc'   	=> __( 'Change this if you want to chnage add new item text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_new_item_name',
                    'label'     => __( 'New Brand text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'New Brand Name',
                    'desc'   	=> __( 'Change this if you want to chnage new brand text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_add_or_remove_items',
                    'label'     => __( 'Add or remove text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Add or remove Brand',
                    'desc'   	=> __( 'Change this if you want to chnage add or remove text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_choose_from_most_used',
                    'label'     => __( 'Choose from most used brands text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Choose from most used Brands',
                    'desc'   	=> __( 'Change this if you want to chnage Choose from most used brands text', 'codesigner' )
				],
                [
                    'id'      	=> 'pb_menu_name',
                    'label'     => __( 'Menu text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Brands',
                    'desc'   	=> __( 'Change this if you want to chnage brands menu text', 'codesigner' )
				],
            ]
        ];

        return $settings;
    }

	public function register_taxonomies() {

		$labels = [
			'name'                  => _x( Helper::get_option( 'codesigner_product_brands', 'pb_name', 'Brands' ), 'Taxonomy plural name', 'codesigner' ),
			'singular_name'         => _x( Helper::get_option( 'codesigner_product_brands', 'pb_singular_name', 'Brand' ), 'Taxonomy singular name', 'codesigner' ),
			'search_items'          => __( Helper::get_option( 'codesigner_product_brands', 'pb_search_items', 'Search Brands' ), 'codesigner' ),
			'popular_items'         => __( Helper::get_option( 'codesigner_product_brands', 'pb_popular_items', 'Popular Brands' ) , 'codesigner' ),
			'all_items'             => __( Helper::get_option( 'codesigner_product_brands', 'pb_all_items', 'All Brands' ) , 'codesigner' ),
			'parent_item'           => __( Helper::get_option( 'codesigner_product_brands', 'pb_parent_item', 'Parent Brand' ) , 'codesigner' ),
			'parent_item_colon'     => __( Helper::get_option( 'codesigner_product_brands', 'pb_parent_item_colon', 'Parent Brand' ) , 'codesigner' ),
			'edit_item'             => __( Helper::get_option( 'codesigner_product_brands', 'pb_edit_item', 'Edit Brand' ) , 'codesigner' ),
			'update_item'           => __( Helper::get_option( 'codesigner_product_brands', 'pb_update_item', 'Update Brand' ) , 'codesigner' ),
			'add_new_item'          => __( Helper::get_option( 'codesigner_product_brands', 'pb_add_new_item', 'Add New Brand' ) , 'codesigner' ),
			'new_item_name'         => __( Helper::get_option( 'codesigner_product_brands', 'pb_new_item_name', 'New Brand Name' ) , 'codesigner' ),
			'add_or_remove_items'   => __( Helper::get_option( 'codesigner_product_brands', 'pb_add_or_remove_items', 'Add or remove Brand' ) , 'codesigner' ),
			'choose_from_most_used' => __( Helper::get_option( 'codesigner_product_brands', 'pb_choose_from_most_used', 'Choose from most used Brands' ) , 'codesigner' ),
			'menu_name'             => __( Helper::get_option( 'codesigner_product_brands', 'pb_menu_name', 'Brands' ), 'codesigner' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
			'capabilities'      => [],
		];

		register_taxonomy( 'brand' , [ 'product' ], $args );
	}

	public function add_custom_taxonomy_to_product_meta() {
    global $product;

    $terms = get_the_terms( $product->get_id(), 'brand' );
        if ( $terms ) {         
            ?>
            <span class="brand_wrapper">
                <?php
            echo esc_html_e( Helper::get_option( 'codesigner_product_brands', 'pb_singular_name' ) . ' : ', 'codesigner' );
            foreach ( $terms as $key => $term ) {
                $term_links[ esc_url( get_term_link( $term, Helper::get_option( 'codesigner_product_brands', 'pb_singular_name' ) ) ) ]  = esc_html( $term->name );                
            }
            $links = array();
            if ( ! is_wp_error( $term_links ) ) {
                foreach ( $term_links as $key => $value ) {
                    $links[] = '<a href="' . esc_url( $key ) . '">' . esc_html( $value ) . '</a>';
                }
            }
            echo wp_kses_post( implode( ', ', $links ) );
            ?>
                </span>
            <?php
        }
    }
}