<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Product_Additional_Information extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return array();
	}

	public function get_style_depends() {
		return array();
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
			'section_additional_info_style',
			array(
				'label' => __( 'General', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'additinal_info_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner-pro' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-additional-information.hide-wlpai-heading h2' => 'display: none;',
					'.wl {{WRAPPER}} .wl-product-additional-information table.woocommerce-product-attributes' => 'margin:0',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_control(
			'show_heading',
			array(
				'label'        => __( 'Heading', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-additional-information h2' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'heading_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-product-additional-information h2',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
				'condition'      => array(
					'show_heading' => 'yes',
				),
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-additional-information .shop_attributes' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-product-additional-information .shop_attributes tr th,
							  .wl {{WRAPPER}} .wl-product-additional-information .shop_attributes tr td',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		global $product;

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		$product = wc_get_product();

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id = wcd_get_product_id();
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		$_hide = isset( $settings['show_heading'] ) && $settings['show_heading'] != 'yes' ? 'hide-wlpai-heading' : '';
		?>
		
		<div class='wl-product-additional-information <?php echo esc_attr( $_hide ); ?>'>

		<?php
		wc_get_template( 'single-product/tabs/additional-information.php' );
		echo wp_kses_post( '</div>' );

		do_action( 'codesigner_after_main_content', $this );
	}
}

