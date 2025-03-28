<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Product_Short_Description extends Widget_Base {

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

		// global $post;

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
			'pd_settings',
			array(
				'label' => __( 'General', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'product_description_type',
			array(
				'label'       => __( 'Content Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'default_description' => __( 'Current Product', 'codesigner' ),
					'custom_description'  => __( 'Custom', 'codesigner' ),
				),
				'default'     => 'default_description',
				'label_block' => true,
			)
		);

		$this->add_control(
			'pd_product_description',
			array(
				'label'     => __( 'Custom Description', 'codesigner' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 10,
				'default'   => __( 'Type your description here', 'codesigner' ),
				'condition' => array(
					'product_description_type' => 'custom_description',
				),
			)
		);

		$this->add_control(
			'pd_alignment',
			array(
				'label'     => __( 'Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'justify' => array(
						'title' => __( 'Justified', 'codesigner' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right'   => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'justify',
				'toggle'    => true,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-description' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Description style Section
		 */
		$this->start_controls_section(
			'pd_style',
			array(
				'label' => __( 'Design', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'payment_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner-pro' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-description p' => 'display: inline-block;',
				),
				'default'   => 'traditional',
			)
		);
		// end default css

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'pd_title_gradient_color',
				'selector' => '.wl {{WRAPPER}} .wl-product-description p',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pd_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-product-description p',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'pd_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .wl-product-description p',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'pd_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-description p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'pd_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-description p',
			)
		);

		$this->add_responsive_control(
			'pd_field_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-description p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'pd_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'pd_product_description', 'basic' );

		$the_excerpt = get_the_excerpt();

		if ( isset( $_POST['product_id'] ) ) {
			$product_id  = codesigner_sanitize_number( $_POST['product_id'] );
			$the_excerpt = get_the_excerpt( $product_id );
		}

		if ( function_exists( 'wc_get_product' ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id  = wcd_get_product_id();
			$product     = wc_get_product( $product_id );
			$the_excerpt = $product->get_short_description();
		}
		?>
		<div class="wl-product-description">
			<?php
			if ( 'default_description' == $settings['product_description_type'] ) {
				printf(
					'<p>%s</p>',
					wp_kses_post( stripcslashes( wp_filter_post_kses( $the_excerpt ) ) )
				);
			} else {
				printf(
					'<p %s>%s</p>',
					wp_kses_post( $this->get_render_attribute_string( 'pd_product_description' ) ),
					esc_html( stripcslashes( wp_filter_post_kses( $settings['pd_product_description'] ) ) )
				);
			}
			?>
		</div>
		<?php

		do_action( 'codesigner_after_main_content', $this );
	}
}