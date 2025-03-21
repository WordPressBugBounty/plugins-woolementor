<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Product_Gallery extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return array( "codesigner-{$this->id}", 'fancybox', 'wc-single-product' );
	}

	public function get_style_depends() {
		return array( "codesigner-{$this->id}", 'fancybox' );
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'payment_section_title',
			array(
				'label' => __( 'Sale', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sale_flash',
			array(
				'label'        => __( 'Sale Flash', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'render_type'  => 'template',
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_gallery_style',
			array(
				'label' => __( 'Thumbnail', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		// start default style
		$this->add_control(
			'product_gallery_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner-pro' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-gallery .woocommerce-product-gallery' => 'width: 100%;',
				),
				'default'   => 'traditional',
			)
		);
		// end default css

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'image_border',
				'selector'  => '.wl {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
				.wl {{WRAPPER}} .flex-viewport, .wl {{WRAPPER}} .flex-control-thumbs img',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
					.wl {{WRAPPER}} .flex-viewport' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'spacing',
			array(
				'label'      => __( 'Spacing', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .flex-viewport:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_thumbs_style',
			array(
				'label'     => __( 'Thumbnails', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'thumbs_border',
				'selector' => '.wl {{WRAPPER}} .flex-control-thumbs img',
			)
		);

		$this->add_responsive_control(
			'thumbs_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .flex-control-thumbs img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'spacing_thumbs',
			array(
				'label'      => __( 'Spacing', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .flex-control-thumbs li' => 'padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .flex-control-thumbs' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2)',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		global $product;

		$settings = $this->get_settings_for_display();

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		$product = wc_get_product();

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) ) {
			return;
		}

		wp_enqueue_style( 'woocommerce-general' );
		wp_enqueue_script( 'wc-single-product' );

		echo wp_kses_post( '<div class="wl-product-gallery product">' );

		if ( 'yes' === $settings['sale_flash'] ) {
			wc_get_template( 'loop/sale-flash.php' );
		}

		wc_get_template( 'single-product/product-image.php' );

		echo wp_kses_post( '</div>' );

		do_action( 'codesigner_after_main_content', $this );

		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		if ( wp_doing_ajax() ) {
			?>
			<script>
				jQuery(function($){
					$( '.woocommerce-product-gallery' ).each( function() {
						$(this).wc_product_gallery();
					} );
				})
			</script>
			<?php
		}
	}
}