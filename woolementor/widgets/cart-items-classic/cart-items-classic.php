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

class Cart_Items_Classic extends Widget_Base {

	public $id;

	public $slug;
	
	public $version;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id 		= wcd_get_widget_id( __CLASS__ );
	    $this->widget 	= wcd_get_widget( $this->id );

	    // $this->action( 'init', 'init_plugin' );
	    
		$min 			= defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';
		$qty_btn_fix 	= Helper::get_option('codesigner_tools','quantity_input');

		if ( $qty_btn_fix != 'on' ) {
			wp_register_script( "codesigner-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), ['jquery'], $this->version, true );
		}

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], $this->version );
	}

	/**
     * Form WP version 6.7.0 Need to loade some 
     * Data like TextDomain and other in init hook 
     */

    // public function init_plugin(){
    //     $this->plugin   = get_plugin_data( CODESIGNER );
    //     $this->slug     = $this->plugin['TextDomain'];
    //     $this->version  = $this->plugin['Version'];
    // }

	public function get_script_depends() {
		$troubleshoot = Helper::get_option( 'wcd_troubleshoot', 'quantity_input' );

		if ( $troubleshoot != 'on' ) {
			return [ "codesigner-{$this->id}", 'fancybox' ];
		}
		else {
			return [ 'fancybox' ];
		}
	}

	public function get_style_depends() {
		return [ "codesigner-{$this->id}", 'fancybox' ];
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
		 * Bottom Sections
		 */
		$this->start_controls_section(
			'section_content_bottom_sections',
			[
				'label' => __( 'Bottom Sections', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'coupon_show_hide',
			[
				'label' 		=> __( 'Coupon Area', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'coupon_btn_text',
			[
				'label' 		=> __( 'Button Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Apply coupon', 'codesigner' ),
				'placeholder' 	=> __( 'Type your title here', 'codesigner' ),
				'condition' 	=> [
					'coupon_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'coupon_placeholder',
			[
				'label' 		=> __( 'Placeholder Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Coupon code', 'codesigner' ),
				'placeholder' 	=> __( 'Type your title here', 'codesigner' ),
				'condition' 	=> [
					'coupon_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'update_cart_show_hide',
			[
				'label' 		=> __( 'Update Button', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'update_cart_btn_text',
			[
				'label' 		=> __( 'Button Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Update Cart', 'codesigner' ),
				'placeholder' 	=> __( 'Type your title here', 'codesigner' ),
				'condition' 	=> [
					'update_cart_show_hide' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Empty Cart Content
		 */
		$this->start_controls_section(
			'action_when_cart_empty',
			[
				'label' => __( 'Empty Cart Notice', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'action_notice',
	 			[
					'label' => __( '', 'codesigner' ),
					'type' 	=> Controls_Manager::RAW_HTML,
					'raw' 	=> __( 'This section is only visible when the cart is empty.', 'codesigner' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
	 			]
	 		);

		$this->add_control(
			'tab_content_source',
			[
				'label' 		=> __( 'Content Source', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'show_nothing'	=> __( 'Show Nothing', 'codesigner' ),
					'static_texts'	=> __( 'Static Texts', 'codesigner' ),
					'template'  	=> __( 'Template', 'codesigner' ),
				],
				'default' 		=> 'show_nothing',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'codesigner' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'codesigner' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
				'show_label' 	=> false,
			]
		);

		$this->add_control(
			'tab_template',
			[
				'label' 		=> __( 'Select a Template', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_template_list( 'section' ),
				'condition' 	=> [
                    'tab_content_source' => 'template'
                ],
                'description'	=> __( 'This is a list of section type template. Select a template to show as empty cart notice', 'codesigner' ),
				'label_block' 	=> true,
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table
		 */
		$this->start_controls_section(
			'style_section_cart_table',
			[
				'label' => __( 'Table', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'cart_table_background',
				'label' 	=> __( 'Background', 'codesigner' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'cart_table_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table td,
								.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table th',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'cart_table_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table',
			]
		);

		$this->add_responsive_control(
			'cart_table_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'cart_table_shadow_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic table.wl-cic-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * cart-heading
		 */
		$this->start_controls_section(
			'section_cart_heading',
			[
				'label' => __( 'Table Heading', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cart_heading_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic thead tr.wl-cic-heading-nav th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'cart_heading_typography',
				'label'     => __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '.wl {{WRAPPER}} .wl-cart-items-classic thead tr.wl-cic-heading-nav th',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		); 

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'cart_heading_background',
				'label' 	=> __( 'Background', 'codesigner' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic thead tr.wl-cic-heading-nav',
			]
		);

		$this->add_responsive_control(
			'cart_heading_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic thead tr.wl-cic-heading-nav th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Product Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 250
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
				'default' => [
					'unit' => 'px',
					'size'	=> 100
				]
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' 	=> __( 'Image Height', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img' => 'height: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 250
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_box_height',
			[
				'label' 	=> __( 'Image Box Height', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img',
			]
		);

		$this->start_controls_tabs(
			'image_effects',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'image_effects_normal',
			[
				'label' 	=> __( 'Normal', 'codesigner' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' 	=> __( 'Opacity', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'image_hover',
			[
				'label' 	=> __( 'Hover', 'codesigner' ),
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' 	=> __( 'Opacity', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img:hover',
			]
		);

		$this->add_control(
			'image_hover_transition',
			[
				'label' 	=> __( 'Transition Duration', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 3,
						'step' 	=> 0.1,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-thumbnail img:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Product Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-cart-items-classic td.product-name > a',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-name > a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->end_controls_section();


		/**
		 * Product Price
		 */
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => __( 'Product Price', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-price .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_size_typography',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-price .woocommerce-Price-amount.amount',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Quantity
		 */
		$this->start_controls_section(
			'section_style_quantity',
			[
				'label' => __( 'Quantity', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quantity_default_style',
			[
				'label' => __( 'View', 'codesigner' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .quantity' => 'display: flex;gap:10px;',
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .quantity input' => 'display: none;',
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .quantity input.input-text.qty.text' => 'display: block;',
				],
			]
		);

		$this->add_control(
			'quantity_font_color',
			[
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .input-text.qty.text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'quantity_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .input-text.qty.text',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'quantity_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .input-text.qty.text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'quantity_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-quantity .input-text.qty.text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Subtotal
		 */
		$this->start_controls_section(
			'section_style_subtotal',
			[
				'label' => __( 'Subtotal', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtotal_color',
			[
				'label'     => __( 'Font Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-subtotal .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'Subtotal_typography',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-subtotal .woocommerce-Price-amount.amount',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Remove
		 */
		$this->start_controls_section(
			'section_product_remove_button',
			[
				'label' => __( 'Remove Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_product_remove_color',
			[
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'remove_icon',
			[
				'label' 	=> __( 'Icon', 'codesigner' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'eicon-close',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_control(
			'section_product_remove_bg',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'section_product_remove_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove',
			]
		);

		$this->add_responsive_control(
			'section_product_remove_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'section_product_remove_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove',
			]
		);

		$this->add_responsive_control(
			'section_product_remove_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'section_product_remove_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic td.product-remove a.remove' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Coupon Button
		 */
		$this->start_controls_section(
			'section_coupon_button',
			[
				'label' => __( 'Coupon Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'coupon_show_hide' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'coupon_button_typography',
				'label'     => __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_responsive_control(
			'coupon_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'coupon_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button',
			]
		);

		$this->add_responsive_control(
			'coupon_button_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'coupon_button_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'coupon-button-tab',
			[

				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'coupon-button-tab-active',
			[
				'label' => __( 'Normal', 'codesigner' ),
			]
		);

		$this->add_control(
			'coupon_button_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'coupon_button_bg',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'coupon_button_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'coupon-button-tab-hover',
			[
				'label' => __( 'Hover', 'codesigner' ),
			]
		);

		$this->add_control(
			'coupon_button_color_hover',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'coupon_button_bg_hover',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'coupon_button_border_hover',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-coupon-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();

		/**
		 * coupon form
		 */
		$this->start_controls_section(
			'section_coupon_form',
			[
				'label' => __( 'Coupon Form', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'coupon_show_hide' => 'yes'
				]
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'coupon_form_typography',
				'label'     => __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'coupon_form_bg',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'coupon_form_color',
			[
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'coupon_form_border_hover',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]',
			]
		);

		$this->add_responsive_control(
			'coupon_form_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'coupon_form_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]',
			]
		);

		$this->add_responsive_control(
			'coupon_form_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'coupon_form_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .coupon input[name="coupon_code"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Update Cart Button
		 */
		$this->start_controls_section(
			'section_update_cart_button',
			[
				'label' => __( 'Update Cart Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'update_cart_show_hide' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'update_cart_button_typography',
				'label'     => __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					'line_height' 	=> [ 'default' => [ 'size' => 26 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_responsive_control(
			'update_cart_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'update_cart_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button',
			]
		);

		$this->add_responsive_control(
			'update_cart_button_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'update_cart_button_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'update-cart-button-tab',
			[
				
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'update-cart-button-tab-active',
			[
				'label' => __( 'Normal', 'codesigner' ),
			]
		);

		$this->add_control(
			'update_cart_button_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'update_cart_button_bg',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'update_cart_button_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'update-cart-button-tab-hover',
			[
				'label' => __( 'Hover', 'codesigner' ),
			]
		);

		$this->add_control(
			'update_cart_button_color_hover',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'update_cart_button_bg_hover',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'update_cart_button_border_hover',
				'label' 	=> __( 'Border', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-cart-items-classic .button.wl-cic-update-cart-button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();


		/**
		 * Empty cart notice
		 */
		$this->start_controls_section(
			'empty_cart_notice_style',
			[
				'label' => __( 'Empty Cart Notice', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tab_content_source' => 'static_texts'
				]
			]
		);

		$this->add_responsive_control(
			'empty_cart_notice_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .wl-cic-empty-cart-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'empty_cart_notice_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-cart-items-classic .wl-cic-empty-cart-notice' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

	}

	protected function render() {
			
		if( ! is_woocommerce_activated() ) return;
		if( is_order_received_page() ) return;

		if( is_null( WC()->cart ) ) {
			include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
			include_once WC_ABSPATH . 'includes/class-wc-cart.php';
			wc_load_cart();
		}

		$settings = $this->get_settings_for_display();

        do_action( 'woocommerce_before_cart' ); ?>

		<div class="wl-cart-items-classic">
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' );

				if ( !empty( WC()->cart->get_cart() ) ) : ?>
				<table class="wl-cic-table shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
					<thead>
						<tr class="wl-cic-heading-nav">
							<th class="product-remove">&nbsp;</th>
							<th class="product-thumbnail"><?php esc_html_e( 'Thumbnail', 'woocommerce' ); ?></th>
							<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
							<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
							<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
							<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php do_action( 'woocommerce_before_cart_contents' ); 

						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<td class="product-remove">
										<?php
											$remove_icon = esc_attr( $settings['remove_icon']['value'] );
											echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="'. $remove_icon .'"></i></a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													esc_html__( 'Remove this item', 'woocommerce' ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
										?>
									</td>

									<td class="product-thumbnail">
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
									);

									if ( ! $product_permalink ) {									
										echo wp_kses( $thumbnail, $allowed_html ); // PHPCS: XSS ok.
									} 
									else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses( $thumbnail, $allowed_html ) ); // PHPCS: XSS ok.
									}
									?>
									</td>

									<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
									<?php

									if ( ! $product_permalink ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
									} 
									else {
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
									</td>

									<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
										<?php
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ); // PHPCS: XSS ok.
										?>
									</td>

									<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
									<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} 
									else {
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

									$allowed_tags = [
										'div' => [
											'class' => true,
										],
										'input' => [
											'type'        => true,
											'value'       => true,
											'class'       => true,
											'id'          => true,
											'name'        => true,
											'aria-label'  => true,
											'min'         => true,
											'max'         => true,
											'step'        => true,
											'placeholder' => true,
											'inputmode'   => true,
											'autocomplete'=> true,
										],
										'label' => [
											'class' => true,
											'for'   => true,
										],
									];
									

									echo wp_kses( apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ), $allowed_tags ); // PHPCS: XSS ok.
									?>
									</td>

									<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
										<?php
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) ); // PHPCS: XSS ok.
										?>
									</td>
								</tr>
								<?php
							}
						}

						do_action( 'woocommerce_cart_contents' ); ?>

						<tr>
							<td colspan="6" class="actions">
								<div class="wl-cic-actions">
									<div class="coupon">
									<?php if ( wc_coupons_enabled() && $settings['coupon_show_hide'] == 'yes' ) { ?>
										<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( $settings['coupon_placeholder'] ); ?>" /> <button type="submit" class="button wl-cic-coupon-button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( $settings['coupon_btn_text'] ); ?></button>
											<?php do_action( 'woocommerce_cart_coupon' ); ?>
									<?php } ?>
										</div>

									<?php if( $settings['update_cart_show_hide'] == 'yes' ): ?>
									<button type="submit" class="button wl-cic-update-cart-button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( $settings['update_cart_btn_text'] ); ?></button>

									<?php 
									endif;
									do_action( 'woocommerce_cart_actions' );

									wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
								</div>
							</td>
						</tr>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>

					</tbody>
				</table>
				<?php do_action( 'woocommerce_after_cart_table' ); 
				else:
					if ( !did_action( 'woocommerce_cart_is_empty' ) ) {
						do_action( 'woocommerce_cart_is_empty' );
					}
					if ( $settings['tab_content_source'] == 'template' ) {
						$template_id = $settings['tab_template'];
						$elementor_instance = \Elementor\Plugin::instance();
						echo wp_kses_post( $elementor_instance->frontend->get_builder_content_for_display( $template_id ) );
					}
					else {
						echo wp_kses_post( $this->parse_text_editor( $settings['tab_content'] ) );
					}
				endif;

				if( !empty( WC()->cart->get_cart() ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() )  ){
					if ( $settings['tab_content_source'] == 'template' ) {
						$template_id = $settings['tab_template'];
						$elementor_instance = \Elementor\Plugin::instance();
						echo wp_kses_post( $elementor_instance->frontend->get_builder_content_for_display( $template_id ) );
					}
					else {
						?>
							<div class='wl-cic-empty-cart-notice'>
								<?php echo wp_kses_post( $this->parse_text_editor( $settings['tab_content'] ) ); ?>
							</div>
						<?php
					}
				}
				?>
			</form>
		</div>
		<?php 
		do_action( 'codesigner_after_main_content', $this );
	}
}
