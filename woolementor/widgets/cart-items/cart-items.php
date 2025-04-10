<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Elementor\Products_Renderer;
use Elementor\Controls_Stack;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Cart_Items extends Widget_Base {

	public $id;

	public $slug;

	public $version;

	public $widget;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		$qty_btn_fix = Helper::get_option( 'codesigner_tools', 'quantity_input' );
		if ( $qty_btn_fix != 'on' ) {
			wp_register_script( "codesigner-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), array( 'jquery' ), $this->version, true );
		}

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), $this->version );
	}

	public function get_script_depends() {
		$troubleshoot = Helper::get_option( 'wcd_troubleshoot', 'quantity_input' );

		if ( $troubleshoot != 'on' ) {
			return array( "codesigner-{$this->id}", 'fancybox' );
		} else {
			return array( 'fancybox' );
		}
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

		/**
		 * Columns
		 */
		$this->start_controls_section(
			'section_content_columns',
			array(
				'label' => __( 'Columns', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'product_image_show_hide',
			array(
				'label'           => __( 'Thumbnail', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'block',
				'desktop_default' => 'block',
				'tablet_default'  => 'block',
				'mobile_default'  => 'block',
				'prefix_class'    => 'wl-product-image-show%s-',
				'selectors'       => array(
					'{{WRAPPER}} .wl-ci-product-thumbnail' => 'display: {{VALUE}}!important',
				),
			)
		);

		$this->add_control(
			'product_image_heading',
			array(
				'label'       => __( 'Heading', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Thumbnail', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				// 'condition'  => [
				// 'product_image_show_hide' => 'yes'
				// ],
			)
		);

		$this->add_control(
			'product_image_click',
			array(
				'label'   => __( 'On Click', 'codesigner' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => array(
					'none'         => __( 'None', 'codesigner' ),
					'zoom'         => __( 'Zoom', 'codesigner' ),
					'product_page' => __( 'Product Page', 'codesigner' ),
				),
				'default' => 'none',
				// 'condition'  => [
				// 'product_image_show_hide' => 'yes'
				// ],
			)
		);

		$this->add_responsive_control(
			'product_name_show_hide',
			array(
				'label'           => __( 'Product', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'yes',
				'prefix_class'    => 'wl-product-name-show%s-',
			)
		);

		$this->add_control(
			'product_name_heading',
			array(
				'label'       => __( 'Heading', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Product', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'product_name_show_hide' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_category_show_hide',
			array(
				'label'           => __( 'Category', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'default'         => 'yes',
				'condition'       => array(
					'product_name_show_hide' => 'yes',
				),
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'no',
				'prefix_class'    => 'wl-product-category-show%s-',
			)
		);

		$this->add_control(
			'product_category_heading',
			array(
				'label'       => __( 'Label', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Category: ', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'product_name_show_hide'     => 'yes',
					'product_category_show_hide' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_price_show_hide',
			array(
				'label'           => __( 'Price', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'yes',
				'prefix_class'    => 'wl-product-price-show%s-',
			)
		);

		$this->add_control(
			'product_price_heading',
			array(
				'label'       => __( 'Heading', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Price', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'product_price_show_hide' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_quantity_show_hide',
			array(
				'label'           => __( 'Quantity', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'yes',
				'prefix_class'    => 'wl-product-quantity-show%s-',
			)
		);

		$this->add_control(
			'product_quantity_heading',
			array(
				'label'       => __( 'Heading', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Quantity', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'product_quantity_show_hide' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_subtotal_show_hide',
			array(
				'label'           => __( 'Subtotal', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'yes',
				'prefix_class'    => 'wl-product-subtotal-show%s-',
			)
		);

		$this->add_control(
			'product_subtotal_heading',
			array(
				'label'       => __( 'Heading', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Subtotal', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'product_subtotal_show_hide' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_remove_btn_show_hide',
			array(
				'label'           => __( 'Remove Button', 'codesigner' ),
				'type'            => Controls_Manager::SWITCHER,
				'label_on'        => __( 'Show', 'codesigner' ),
				'label_off'       => __( 'Hide', 'codesigner' ),
				'return_value'    => 'yes',
				'separator'       => 'before',
				'desktop_default' => 'yes',
				'tablet_default'  => 'yes',
				'mobile_default'  => 'yes',
				'prefix_class'    => 'wl-product-remove-show%s-',
			)
		);

		$this->end_controls_section();

		/**
		 * Bottom Sections
		 */
		$this->start_controls_section(
			'section_content_bottom_sections',
			array(
				'label' => __( 'Bottom Sections', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'coupon_show_hide',
			array(
				'label'        => __( 'Coupon Area', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'Coupon_button_name',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Apply coupon', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'coupon_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'Coupon_button_placeholder',
			array(
				'label'       => __( 'Placeholder Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Coupon code', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'coupon_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'update_cart_show_hide',
			array(
				'label'        => __( 'Update Button', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'update_cart_button_name',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Update Cart', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'update_cart_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'checkout_show_hide',
			array(
				'label'        => __( 'Proceed to Checkout', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'checkout_button_name',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Proceed to Checkout', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'checkout_show_hide' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Empty Cart Content
		 */
		$this->start_controls_section(
			'action_when_cart_empty',
			array(
				'label' => __( 'Empty Cart Notice', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'action_notice',
			array(
				'label'           => __( '', 'codesigner' ),
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'This section is only visible when the cart is empty.', 'codesigner' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'tab_content_source',
			array(
				'label'       => __( 'Content Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'show_nothing' => __( 'Show Nothing', 'codesigner' ),
					'static_texts' => __( 'Static Texts', 'codesigner' ),
					'template'     => __( 'Template', 'codesigner' ),
				),
				'default'     => 'show_nothing',
				'label_block' => true,
			)
		);

		$this->add_control(
			'tab_content',
			array(
				'label'      => __( 'Content', 'codesigner' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'codesigner' ),
				'condition'  => array(
					'tab_content_source' => 'static_texts',
				),
				'show_label' => false,
			)
		);

		$this->add_control(
			'tab_template',
			array(
				'label'       => __( 'Select a Template', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => wcd_get_template_list( 'section' ),
				'condition'   => array(
					'tab_content_source' => 'template',
				),
				'description' => __( 'This is a list of section type template. Select a template to show as empty cart notice', 'codesigner' ),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		/**
		 * Cart Table
		 */
		$this->start_controls_section(
			'style_section_cart_table',
			array(
				'label' => __( 'Table', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cart_table_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} table.wl-ci-cart-table',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cart_table_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} table.wl-ci-cart-table',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'cart_table_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} table.wl-ci-cart-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cart_table_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} table.wl-ci-cart-table',
			)
		);

		$this->add_responsive_control(
			'cart_table_shadow_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} table.wl-ci-cart-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cart_table_shadow_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} table.wl-ci-cart-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * cart-heading
		 */
		$this->start_controls_section(
			'section_cart_heading',
			array(
				'label' => __( 'Table Heading', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cart_heading_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'cart_heading_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					'line_height' => array( 'default' => array( 'size' => 37 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cart_heading_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} thead tr.wl-ci-heading-nav',
			)
		);

		$this->add_responsive_control(
			'cart_heading_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => __( 'Product Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 250,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => __( 'Image Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 250,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_responsive_control(
			'image_box_height',
			array(
				'label'      => __( 'Image Box Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			)
		);

		$this->start_controls_tabs(
			'image_effects',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'image_effects_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'image_opacity',
			array(
				'label'     => __( 'Opacity', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'image_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'image_opacity_hover',
			array(
				'label'     => __( 'Opacity', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover',
			)
		);

		$this->add_control(
			'image_hover_transition',
			array(
				'label'     => __( 'Transition Duration', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'.wl {{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => __( 'Product Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'title_gradient_color',
				'selector' => '.wl {{WRAPPER}} .wl-ci-product-name.product-name > a',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-ci-product-name.product-name > a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product Category
		 */
		$this->start_controls_section(
			'section_style_category',
			array(
				'label' => __( 'Product Category', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs(
			'category_label_separator',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'category_label',
			array(
				'label' => __( 'Label', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'category_label_gradient_color',
				'selector' => '.wl {{WRAPPER}} .wl-ci-cart-category span',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'category_label_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-ci-cart-category span',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'category_text',
			array(
				'label' => __( 'Text', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'category_gradient_color',
				'selector' => '.wl {{WRAPPER}} .wl-ci-cart-category a',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'category_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-ci-cart-category a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Price
		 */
		$this->start_controls_section(
			'section_style_price',
			array(
				'label' => __( 'Product Price', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-price.wl-ci-product-price .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_size_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .product-price.wl-ci-product-price .woocommerce-Price-amount.amount',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Quantity
		 */
		$this->start_controls_section(
			'section_style_quantity',
			array(
				'label' => __( 'Quantity', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'quantity_font_color',
			array(
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity .input-text.qty.text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'quantity_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity .quantity.buttons_added',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'quantity_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity .quantity.buttons_added' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'quantity_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'quantity_icon_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'quantity_icon_bg_color',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'background: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Subtotal
		 */
		$this->start_controls_section(
			'section_style_subtotal',
			array(
				'label' => __( 'Subtotal', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'subtotal_color',
			array(
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-subtotal.wl-ci-product-subtotal .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'Subtotal_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .product-subtotal.wl-ci-product-subtotal .woocommerce-Price-amount.amount',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product Remove
		 */
		$this->start_controls_section(
			'section_product_remove_button',
			array(
				'label' => __( 'Remove Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'section_product_remove_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'section_product_remove_icon',
			array(
				'label'   => __( 'Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'eicon-close',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'section_product_remove_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'section_product_remove_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove',
			)
		);

		$this->add_responsive_control(
			'section_product_remove_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'section_product_remove_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove',
			)
		);

		$this->add_responsive_control(
			'section_product_remove_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'section_product_remove_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Coupon Button
		 */
		$this->start_controls_section(
			'section_coupon_button',
			array(
				'label' => __( 'Coupon Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'coupon_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .button.wl-ci-coupon-button',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_responsive_control(
			'coupon_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'coupon_button_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-coupon-button',
			)
		);

		$this->add_responsive_control(
			'coupon_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'coupon-button-tab',
			array(

				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'coupon-button-tab-active',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'coupon_button_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'coupon_button_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'coupon_button_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-coupon-button',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'coupon-button-tab-hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'coupon_button_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button:hover' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'coupon_button_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-coupon-button:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'coupon_button_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-coupon-button:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Update Cart Button
		 */
		$this->start_controls_section(
			'section_update_cart_button',
			array(
				'label' => __( 'Update Cart Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'update_cart_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .button.wl-ci-update-cart-button',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_responsive_control(
			'update_cart_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'update_cart_button_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-update-cart-button',
			)
		);

		$this->add_responsive_control(
			'update_cart_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'update_cart_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'update-cart-button-tab',
			array(

				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'update-cart-button-tab-active',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'update_cart_button_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'update_cart_button_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'update_cart_button_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-update-cart-button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'update-cart-button-tab-hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'update_cart_button_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button:hover' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'update_cart_button_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .button.wl-ci-update-cart-button:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'update_cart_button_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .button.wl-ci-update-cart-button:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Proceed to Checkout Button
		 */
		$this->start_controls_section(
			'section_checkout_button',
			array(
				'label' => __( 'Checkout Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'checkout_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'line_height' => array( 'default' => array( 'size' => 26 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_responsive_control(
			'checkout_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'checkout_button_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
			)
		);

		$this->add_responsive_control(
			'checkout_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'checkout_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'checkout-button-tab',
			array(

				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'checkout-button-tab-active',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'checkout_button_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'checkout_button_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'checkout_button_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'checkout-button-tab-hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'checkout_button_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'checkout_button_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'checkout_button_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Empty cart notice
		 */
		$this->start_controls_section(
			'empty_cart_notice_style',
			array(
				'label'     => __( 'Empty Cart Notice', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'tab_content_source' => 'static_texts',
				),
			)
		);

		$this->add_responsive_control(
			'empty_cart_notice_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ci-empty-cart-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'empty_cart_notice_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ci-empty-cart-notice' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		if ( is_order_received_page() ) {
			return;
		}

		if ( is_null( WC()->cart ) ) {
			include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
			include_once WC_ABSPATH . 'includes/class-wc-cart.php';
			wc_load_cart();
		}

		$settings = $this->get_settings_for_display();
		extract( $settings );

		$this->render_editing_attributes();

		do_action( 'woocommerce_before_cart' ); ?>

		<div class="wl-ci">
			<div class="wl-ci-product-style">
				<div class="cx-container">
					<div class="cx-row">
						<div class="cx-col-md-12 cx-col-sm-12">
							<div class="woocommerce">
								<form class="woocommerce-cart-form wl-ci-cart-form" action="<?php echo esc_url( get_permalink() ); ?>" method="post">
									<?php
									do_action( 'woocommerce_before_cart_table' );

									if ( ! empty( WC()->cart->get_cart() ) ) :
										?>

									<table class="shop_table cart woocommerce-cart-form__contents wl-ci-cart-table" cellspacing="0">
										<thead class="">
											<tr class="wl-ci-heading-nav">
											
												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_image_heading' ), array() ); ?> ><?php echo esc_html( $product_image_heading ); ?></th>

												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_name_heading' ), array() ); ?> ><?php echo esc_html( $product_name_heading ); ?></th>

												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_price_heading' ), array() ); ?> ><?php echo esc_html( $product_price_heading ); ?></th>

												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_quantity_heading' ), array() ); ?> ><?php echo esc_html( $product_quantity_heading ); ?></th>

												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_subtotal_heading' ), array() ); ?> ><?php echo esc_html( $product_subtotal_heading ); ?></th>												

												<th <?php echo wp_kses( $this->get_render_attribute_string( 'product_remove' ), array() ); ?>></th>
											</tr>
										</thead>
										<tbody>
											<?php
											do_action( 'woocommerce_before_cart_contents' );

											foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
												$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
												$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
												$image_url  = get_the_post_thumbnail_url( $product_id );

												if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
													$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
													?>
													<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

														<td class="product-thumbnail wl-ci-product-thumbnail" data-title="<?php esc_attr_e( 'Thumbnail', 'woocommerce' ); ?>">

														<?php

															$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

															$allowed_html = array(
																'img' => array(
																	'src'    => true,
																	'alt'    => true,
																	'width'  => true,
																	'height' => true,
																	'class'  => true,
																	'srcset' => true,
																	'sizes'  => true,
																),
																'a' => array(
																	'href' => array(),
																	'title' => array(),
																	'target' => array(),
																),
															);

															if ( $product_image_click == 'zoom' ) {
																?>
																<a id="wl-sgs-product-image-zoom" href="<?php echo esc_url( $image_url ); ?>">
																<?php echo wp_kses( $thumbnail, $allowed_html ); ?>
																</a>
																<?php
															} elseif ( $product_image_click == 'product_page' ) {
																?>
																	<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses( $thumbnail, $allowed_html ); ?></a>
																<?php
															} else {
																echo wp_kses( $thumbnail, $allowed_html );
															}

															?>

														</td>

														<td class="product-name wl-ci-product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">

														<?php
														if ( ! $product_permalink ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
														} else {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
														}

														do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

														// Meta data.
														echo wp_kses_post( wc_get_formatted_cart_item_data( $cart_item ) ); // PHPCS: XSS ok.

														// Backorder notification.
														if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
														}
														?>
															<div <?php echo wp_kses( $this->get_render_attribute_string( 'product_category_show_hide' ), array() ); ?>>
																<span>
																	<?php echo esc_html( $product_category_heading ); ?>
																</span>
																<?php echo wp_kses_post( wc_get_product_category_list( $product_id ) ); ?>
																
															</div>
														</td>

														<td class="product-price wl-ci-product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
															<?php
																echo wp_kses_post( apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ); // PHPCS: XSS ok.
															?>
														</td>

														<td class="product-quantity wl-ci-product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">

														<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input(
																array(
																	'input_name'   => "cart[{$cart_item_key}][qty]",
																	'input_value'  => $cart_item['quantity'],
																	'max_value'    => $_product->get_max_purchase_quantity(),
																	'min_value'    => '0',
																	'product_name' => $_product->get_name(),
																),
																$_product,
																false
															);
														}

														$allowed_tags = array(
															'div'    => array( 'class' => array() ),
															'input'  => array(
																'type'        => array(),
																'value'       => array(),
																'class'       => array(),
																'id'          => array(),
																'name'        => array(),
																'min'         => array(),
																'max'         => array(),
																'step'        => array(),
																'placeholder' => array(),
																'inputmode'   => array(),
																'autocomplete' => array(),
																'aria-label'  => array(),
															),
															'label'  => array(
																'class' => array(),
																'for'   => array(),
															),
														);

														echo wp_kses( apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ), $allowed_tags ); // PHPCS: XSS ok.
														?>
														</td>

														<td class="product-subtotal wl-ci-product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'codesigner' ); ?>">
															<?php
																echo wp_kses_post( apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) ); // PHPCS: XSS ok.
															?>
														</td>

														<td class="product-remove wl-ci-product-remove">
															<?php
																echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
																	'woocommerce_cart_item_remove_link',
																	sprintf(
																		'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="' . $section_product_remove_icon['value'] . '"></i></a>',
																		esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
																		esc_html__( 'Remove this item', 'codesigner' ),
																		esc_attr( $product_id ),
																		esc_attr( $_product->get_sku() )
																	),
																	$cart_item_key
																);
															?>
														</td>
													</tr>
													<?php
												}
											}

											do_action( 'woocommerce_cart_contents' );

											if ( ! ( empty( $coupon_show_hide ) && empty( $update_cart_show_hide ) && empty( $checkout_show_hide ) ) ) :
												?>
												<tr>
													<td colspan="6" class="actions wl-bottom-actions">

														<?php
														if ( 'yes' == $coupon_show_hide ) :
															if ( wc_coupons_enabled() ) {
																?>
																<div class="coupon wl-ci-coupon">
																	<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> 
																	<input type="text" name="coupon_code" class="wl-ci-coupon-field" id="coupon_code" value="" placeholder="<?php echo esc_attr( $Coupon_button_placeholder ); ?>" />

																	<?php
																	printf(
																		'<button %1$s type="submit" name="apply_coupon" value="%2$s">%2$s</button>',
																		wp_kses_post( $this->get_render_attribute_string( 'Coupon_button_name' ) ),
																		esc_html( $Coupon_button_name )
																	);
																	do_action( 'woocommerce_cart_coupon' );
																	?>

																</div>
																<?php
															}
															endif;
														?>

														<div class="wl-ci-btns">

														<?php
														if ( 'yes' == $update_cart_show_hide ) :
															echo wp_kses_post( '<div>' );
															printf(
																'<button %1$s type="submit" name="update_cart" value="%2$s">%2$s</button>',
																wp_kses_post( $this->get_render_attribute_string( 'update_cart_button_name' ) ),
																esc_html( $update_cart_button_name )
															);
															echo wp_kses_post( '</div>' );

														endif;

														if ( 'yes' == $checkout_show_hide ) :
															?>
															<div class="wl-ci-proceed-to-checkout">

																<?php
																printf(
																	'<a %s href="%s">%s</a>',
																	wp_kses_post( $this->get_render_attribute_string( 'checkout_button_name' ) ),
																	esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ),
																	esc_html( $checkout_button_name )
																);
																?>

															</div>
														<?php endif; ?>

														</div>

														<?php
															do_action( 'woocommerce_cart_actions' );
															wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' );
														?>
													</td>
												</tr>
												<?php
											endif;
											do_action( 'woocommerce_after_cart_contents' );
											?>

										</tbody>
									</table>

										<?php
										do_action( 'woocommerce_after_cart_table' );
									else :
										if ( ! did_action( 'woocommerce_cart_is_empty' ) ) {
											do_action( 'woocommerce_cart_is_empty' );
										}
										if ( $tab_content_source == 'template' ) {
											$template_id        = $tab_template;
											$elementor_instance = \Elementor\Plugin::instance();
											echo wp_kses_post( $elementor_instance->frontend->get_builder_content_for_display( $template_id ) );
										} else {
											echo wp_kses_post( $this->parse_text_editor( $tab_content ) );
										}
									endif;

									if ( ! empty( WC()->cart->get_cart() ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
										if ( $tab_content_source == 'template' ) {
											$template_id        = $tab_template;
											$elementor_instance = \Elementor\Plugin::instance();
											echo wp_kses_post( $elementor_instance->frontend->get_builder_content_for_display( $template_id ) );
										} else {
											?>
												<div class='wl-ci-empty-cart-notice'>
													<?php echo wp_kses_post( $this->parse_text_editor( $tab_content ) ); ?>											 
												</div>
											<?php
										}
									}
									?>
								</form>
							</div>
						</div>

						<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>					

					</div>
				</div>
			</div>
		</div>
		<?php
		do_action( 'codesigner_after_main_content', $this );
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'product_image_heading', 'basic' );
		$this->add_render_attribute( 'product_image_heading', 'class', 'product-thumbnail wl-product-thumbnail wl-ci-heading' );

		$this->add_inline_editing_attributes( 'product_name_heading', 'basic' );
		$this->add_render_attribute( 'product_name_heading', 'class', 'product-name wl-product-name wl-ci-heading' );

		$this->add_inline_editing_attributes( 'product_category_show_hide', 'basic' );
		$this->add_render_attribute( 'product_category_show_hide', 'class', 'product-category wl-ci-cart-category' );

		$this->add_inline_editing_attributes( 'product_price_heading', 'basic' );
		$this->add_render_attribute( 'product_price_heading', 'class', 'product-price wl-product-price wl-ci-heading' );

		$this->add_inline_editing_attributes( 'product_quantity_heading', 'basic' );
		$this->add_render_attribute( 'product_quantity_heading', 'class', 'product-quantity wl-product-quantity wl-ci-heading' );

		$this->add_inline_editing_attributes( 'product_subtotal_heading', 'basic' );
		$this->add_render_attribute( 'product_subtotal_heading', 'class', 'product-subtotal wl-product-subtotal wl-ci-heading' );

		$this->add_render_attribute( 'product_remove', 'class', 'product-remove wl-product-remove wl-ci-heading' );

		$this->add_inline_editing_attributes( 'Coupon_button_name', 'basic' );
		$this->add_render_attribute( 'Coupon_button_name', 'class', 'button wl-ci-coupon-button' );

		$this->add_inline_editing_attributes( 'update_cart_button_name', 'basic' );
		$this->add_render_attribute( 'update_cart_button_name', 'class', 'button wl-ci-update-cart-button' );

		$this->add_inline_editing_attributes( 'checkout_button_name', 'basic' );
		$this->add_render_attribute( 'checkout_button_name', 'class', 'button checkout-button alt wc-forward' );
	}
}