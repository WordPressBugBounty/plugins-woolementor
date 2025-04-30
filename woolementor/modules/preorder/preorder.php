<?php
namespace Codexpert\CoDesigner\Modules;

use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Preorder extends Base {

	public $id = 'codesigner_preorder';

	public $slug;

	public $version;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->filter( 'init', 'init_plugin' );
		$this->filter( 'woocommerce_product_stock_status_options', 'add_pre_order_status_to_product', 10, 2 );
		$this->filter( 'woocommerce_product_stock_status_use_radio', 'use_radio' );
		$this->action( 'woocommerce_product_options_stock_status', 'fields' );
		$this->action( 'woocommerce_process_product_meta', 'save_fields' );
		$this->action( 'woocommerce_before_add_to_cart_form', 'show_preorder_text' );
		$this->action( 'codesigner_after_shop_content_controls', 'widget_content_section' );
		$this->action( 'codesigner_after_shop_style_controls', 'widget_style_section' );
		$this->action( 'codesigner_shop_before_flash_sale', 'widget_render', 10, 2 );
		$this->action( 'admin_enqueue_scripts', 'admin_enqueue_script' );
		$this->action( 'wp_enqueue_scripts', 'front_enqueue_style' );
	}

	/**
	 * Form WP version 6.7.0 Need to loade some
	 * Data like TextDomain and other in init hook
	 */
	public function init_plugin() {
		$this->plugin  = get_plugin_data( CODESIGNER );
		$this->slug    = $this->plugin['TextDomain'];
		$this->version = $this->plugin['Version'];
	}

	public function __settings( $settings ) {
		$settings['sections'][ $this->id ] = array(
			'id'     => $this->id,
			'label'  => __( 'PreOrder', 'codesigner' ),
			'icon'   => 'dashicons-controls-forward',
			'sticky' => false,
			'fields' => array(
				array(
					'id'    => 'show-preorder-text',
					'label' => __( 'Show PreOrder', 'codesigner' ),
					'type'  => 'switch',
					'desc'  => __( 'Check this if you want to show PreOrder text on product.', 'codesigner' ),
				),
				array(
					'id'      => 'preorder-text',
					'label'   => __( 'PreOrder text', 'codesigner' ),
					'type'    => 'text',
					'default' => 'Available on Preorder Expected availability: %%available_date%%',
					'desc'    => __( 'Input your desired custom PreOrder text', 'codesigner' ),
				),
			),
		);

		return $settings;
	}

	public function add_pre_order_status_to_product( $status ) {

		$status['pre_order'] = esc_html__( 'Pre order', 'codesigner' );

		return $status;
	}

	public function use_radio( $true ) {
		return false;
	}

	public function fields() {

		?>
		<div class="show_if_simple">
			<?php
			woocommerce_wp_text_input(
				array(
					'id'    => 'cd_preorder_time',
					'label' => 'PreOrder Available Date',
					'type'  => 'date',
				)
			);
			?>

		</div>
		<?php
	}

	public function save_fields( $post_id ) {
		if ( isset( $_POST['cd_preorder_time'] ) ) {
			$cd_preorder_time = sanitize_text_field( $_POST['cd_preorder_time'] );
			update_post_meta( $post_id, 'cd_preorder_time', $cd_preorder_time );
		}
	}

	public function show_preorder_text() {
		global $product;

		$product       = wc_get_product( $product->get_id() );
		$show_preorder = Helper::get_option( 'codesigner_preorder', 'show-preorder-text' );
		$preorder_text = Helper::get_option( 'codesigner_preorder', 'preorder-text', 'Available on Preorder expected availability: %%available_date%%' );
		if ( $product->get_stock_status() == 'pre_order' && $product->get_meta( 'cd_preorder_time' ) && $show_preorder == 'on' && $preorder_text ) {
			$available_date = $product->get_meta( 'cd_preorder_time' );
			$final_text     = str_replace( '%%available_date%%', $available_date, $preorder_text );
			?>
				<p><span class='preorder-text'><?php echo esc_html( $final_text ); ?></span></p>
			<?php
		}
	}

	public function widget_content_section( $widget_class ) {

		if ( in_array( $widget_class->get_name(), array( 'shop-table', 'shop-flip' ) ) ) {
			return;
		}

		$widget_class->start_controls_section(
			'section_content_preorder',
			array(
				'label' => __( 'Preorder', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$widget_class->add_control(
			'preorder_show_hide',
			array(
				'label'        => __( 'Show/Hide', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$widget_class->add_control(
			'preorder_text',
			array(
				'label'     => __( 'Text', 'codesigner' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => Helper::get_option( 'codesigner_preorder', 'preorder-default-text' ),
				'condition' => array(
					'preorder_show_hide' => 'yes',
				),
			)
		);

		$widget_class->end_controls_section();
	}

	public function widget_style_section( $widget_class ) {
		$widget_class->start_controls_section(
			'section_style_preorder_ribbon',
			array(
				'label'     => __( 'Preorder Ribbon', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'preorder_show_hide' => 'yes',
				),
			)
		);

		$widget_class->add_control(
			'preorder_offset_toggle',
			array(
				'label'        => __( 'Offset', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$widget_class->start_popover();

		$widget_class->add_responsive_control(
			'preorder_media_offset_x',
			array(
				'label'       => __( 'Offset Left', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'condition'   => array(
					'preorder_offset_toggle' => 'yes',
				),
				'range'       => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'   => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'right: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-product-preorder' => 'left: {{SIZE}}{{UNIT}}',
				),
				'default'     => array(
					'unit' => 'px',
					'size' => 0,
				),
				'render_type' => 'ui',
			)
		);

		$widget_class->add_responsive_control(
			'preorder_media_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'preorder_offset_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 53,
				),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'top: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$widget_class->end_popover();

		$widget_class->add_responsive_control(
			'preorder_ribbon_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 500,
					),
				),
			)
		);

		$widget_class->add_responsive_control(
			'preorder_ribbon_transform',
			array(
				'label'     => __( 'Transform', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 360,
					),
				),
			)
		);

		$widget_class->add_control(
			'preorder_ribbon_font_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'color: {{VALUE}}',
				),
				'default'   => '#FCFCFC',
				'separator' => 'before',
			)
		);

		$widget_class->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'preorder_content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-product-preorder',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 12 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$widget_class->add_control(
			'preorder_ribbon_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'background: {{VALUE}}',
				),
				'default'   => '#15242F',
			)
		);

		$widget_class->add_responsive_control(
			'preorder_ribbon_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => 3,
					'right'    => 10,
					'bottom'   => 3,
					'left'     => 10,
					'isLinked' => false,
				),
				'separator'  => 'after',
			)
		);

		$widget_class->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'preorder_ribbon_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-preorder',
			)
		);

		$widget_class->add_responsive_control(
			'preorder_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-preorder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget_class->end_controls_section();
	}

	public function widget_render( $settings, $product ) {
		$preorder_text = $settings['preorder_text'];
		$stock_status  = $product->get_stock_status();

		if ( $stock_status == 'pre_order' && $preorder_text ) {
			$available_date = get_post_meta( $product->get_id(), 'cd_preorder_time', true );
			$text           = str_replace( '%%available_date%%', $available_date, $preorder_text );
			?>
			<div class='wl-product-preorder'>
				<?php
				echo esc_html( $text );
				?>
			</div>
			<?php
		}
	}

	public function admin_enqueue_script() {
		wp_enqueue_script( 'cd-preorder-modules-js', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version, true );
	}

	public function front_enqueue_style() {
		wp_enqueue_style( 'cd-preorder-modules-css', plugins_url( 'css/front.css', __FILE__ ), '', $this->version, 'all' );
	}
}