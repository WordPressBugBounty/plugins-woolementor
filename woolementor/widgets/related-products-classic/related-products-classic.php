<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Related_Products_Classic extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), '1.1' );
	}

	public function get_script_depends() {
		return array( "codesigner-{$this->id}", 'fancybox' );
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
		 * Settings controls
		 */
		$this->start_controls_section(
			'_section_settings',
			array(
				'label' => __( 'Layout', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'           => __( 'Columns', 'codesigner' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => array(
					1 => __( '1 Column', 'codesigner' ),
					2 => __( '2 Columns', 'codesigner' ),
					3 => __( '3 Columns', 'codesigner' ),
					4 => __( '4 Columns', 'codesigner' ),
					5 => __( '5 Columns', 'codesigner' ),
					6 => __( '6 Columns', 'codesigner' ),
				),
				'desktop_default' => 3,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'style_transfer'  => true,
				'selectors'       => array(
					'.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(100px,1fr));',
				),
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'   => __( 'Content Alignment', 'codesigner' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'wl-rpc-left'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'wl-rpc-right' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'wl-rpc-left',
				'toggle'  => false,
			)
		);

		$this->end_controls_section();

		/**
		 * Query controls
		 */
		$this->start_controls_section(
			'query',
			array(
				'label' => __( 'Product Query', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'content_source',
			array(
				'label'       => __( 'Content Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'current_product'   => __( 'Current Product', 'codesigner' ),
					'cart_items'        => __( 'Cart Items', 'codesigner' ),
					'different_product' => __( 'Custom', 'codesigner' ),
				),
				'default'     => 'current_product',
				'label_block' => true,
			)
		);

		$this->add_control(
			'main_product_id',
			array(
				'label'       => __( 'Product ID', 'codesigner' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
				'description' => __( 'Input the base product ID', 'codesigner' ),
				'condition'   => array(
					'content_source' => 'different_product',
				),
			)
		);

		$this->add_control(
			'product_limit',
			array(
				'label'       => __( 'Products Limit', 'codesigner' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 3,
				'separator'   => 'before',
				'description' => __( 'Number of related products to show', 'codesigner' ),
			)
		);

		$this->add_control(
			'exclude_products',
			array(
				'label'       => __( 'Exclude Products', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'before',
				'description' => __( "Comma separated ID's of products that should be excluded", 'codesigner' ),
			)
		);

		$this->end_controls_section();

		/**
		 * Image controls
		 */
		$this->start_controls_section(
			'section_content_product_image',
			array(
				'label' => __( 'Product Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image_show_hide',
			array(
				'label'        => __( 'Show/Hide', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'image_on_click',
			array(
				'label'   => __( 'On Click', 'codesigner' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'         => __( 'None', 'codesigner' ),
					'zoom'         => __( 'Zoom', 'codesigner' ),
					'product_page' => __( 'Product Page', 'codesigner' ),
				),
				'default' => 'none',
			)
		);

		$this->end_controls_section();

		/**
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
			'section_content_sale_ribbon',
			array(
				'label' => __( 'Sale Ribbon', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sale_ribbon_show_hide',
			array(
				'label'        => __( 'Show/Hide', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'sale_ribbon_text',
			array(
				'label'       => __( 'On Sale Test', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Sale', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
			)
		);

		$this->end_controls_section();

		/**
		 * Cart controls
		 */
		$this->start_controls_section(
			'section_content_cart',
			array(
				'label' => __( 'Cart', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cart_show_hide',
			array(
				'label'        => __( 'Show/Hide', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * Wishlist controls
		 */
		$this->start_controls_section(
			'section_content_wishlist',
			array(
				'label' => __( 'Wishlist', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'wishlist_show_hide',
			array(
				'label'        => __( 'Show/Hide', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			array(
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'widget_card_height',
			array(
				'label'      => __( 'Card Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-single-widget' => 'height: {{SIZE}}{{UNIT}}',
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
			Group_Control_Background::get_type(),
			array(
				'name'     => 'widget_card_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-rpc-single-widget',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'widget_card_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-rpc-single-widget',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'widget_card_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-single-widget',
			)
		);

		$this->add_responsive_control(
			'gap',
			array(
				'label'      => __( 'Gap Row', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .cx-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 15,
				),
			)
		);

		$this->add_responsive_control(
			'gap_column',
			array(
				'label'      => __( 'Gap Column', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .cx-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 15,
				),
			)
		);

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
				'name'     => 'title_color',
				'selector' => '{{WRAPPER}} .wl-gradient-heading',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-rpc-product-name a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

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
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-info h2.wl-rpc-price ins, .wl-rpc-product-info h2.wl-rpc-price > .amount' => 'color: {{VALUE}}',
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
				'selector'       => '{{WRAPPER}} .wl-rpc-product-info h2.wl-rpc-price ins, .wl-rpc-product-info h2.wl-rpc-price > .amount',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'sale_price_show_hide',
			array(
				'label'        => __( 'Show Sale Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'your-plugin' ),
				'label_off'    => __( 'Hide', 'your-plugin' ),
				'return_value' => 'block',
				'default'      => 'none',
				'separator'    => 'before',
				'selectors'    => array(
					'{{WRAPPER}} .wl-rpc-product-info h2.wl-rpc-price del' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sale_price_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-info h2.wl-rpc-price del' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'sale_price_show_hide' => 'block',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'sale_price_size_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-rpc-product-info h2.wl-rpc-price del',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'condition'      => array(
					'sale_price_show_hide' => 'block',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product Currency Symbol
		 */
		$this->start_controls_section(
			'section_style_currency',
			array(
				'label' => __( 'Currency Symbol', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_currency',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_currency_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '{{WRAPPER}} .woocommerce-Price-currencySymbol',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
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
				'label'     => __( 'Product Image', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'image_show_hide' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'image_thumbnail',
				'exclude' => array(),
				'include' => array(),
				'default' => 'codesigner-thumb',
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => __( 'Image Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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

		$this->add_responsive_control(
			'image_box_height',
			array(
				'label'      => __( 'Image Box Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img' => 'height: {{SIZE}}{{UNIT}}',
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

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'image_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-img img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-img img',
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
					'{{WRAPPER}} .wl-rpc-product-img img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '{{WRAPPER}} .wl-rpc-product-img img',
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
					'{{WRAPPER}} .wl-rpc-product-img img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .wl-rpc-product-img img:hover',
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
					'{{WRAPPER}} .wl-rpc-product-img img:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sale_ribbon',
			array(
				'label' => __( 'Sale Ribbon', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'sale_ribbon_offset_toggle',
			array(
				'label'        => __( 'Offset', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'media_offset_x',
			array(
				'label'       => __( 'Offset Left', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'condition'   => array(
					'sale_ribbon_offset_toggle' => 'yes',
				),
				'range'       => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}',
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'media_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'sale_ribbon_offset_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->end_popover();

		$this->add_responsive_control(
			'sale_ribbon_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 500,
					),
				),
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_transform',
			array(
				'label'     => __( 'Transform', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 360,
					),
				),
			)
		);

		$this->add_control(
			'sale_ribbon_font_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-rpc-corner-ribbon',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'sale_ribbon_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '0',
					'right'  => '12',
					'bottom' => '0',
					'left'   => '12',
				),
				'separator'  => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sale_ribbon_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-corner-ribbon',
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Cart Button
		 */
		$this->start_controls_section(
			'section_style_cart',
			array(
				'label'     => __( 'Cart Button', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'cart_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'cart_icon',
			array(
				'label'   => __( 'Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'eicon-cart-solid',
					'library' => 'solid',
				),
			)
		);

		$this->add_responsive_control(
			'cart_icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} a.added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'cart_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} a.added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wl-rpc-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'cart_normal_separator',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'cart_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'cart_icon_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-cart i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-cart i' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-cart i',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'cart_icon_color_hover',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-cart i:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-cart i:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-cart i:hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_view_cart',
			array(
				'label' => __( 'View Cart', 'codesigner' ),
			)
		);

		$this->add_control(
			'cart_icon_color_view_cart',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_view_cart',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'cart_icon_view_cart_top',
			array(
				'label'      => __( 'Margin Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-info-icons .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_icon_view_cart_left',
			array(
				'label'      => __( 'Margin Left', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-info-icons .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_view_cart',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .added_to_cart.wc-forward::after',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Wishlist Button
		 */
		$this->start_controls_section(
			'section_style_wishlist',
			array(
				'label'     => __( 'Wishlist Button', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'wishlist_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'wishlist_icon',
			array(
				'label'   => __( 'Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'eicon-heart',
					'library' => 'solid',
				),
			)
		);

		$this->add_responsive_control(
			'wishlist_icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-fav' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'wishlist_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-fav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wishlist_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-rpc-product-fav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'wishlist__separator',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'wishlist_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'wishlist_icon_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-fav' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-fav' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-fav',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wishlist_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'wishlist_icon_color_hover',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-fav:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-rpc-product-fav:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-rpc-product-fav:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		$this->render_editing_attributes();

		if ( 'cart_items' == $content_source ) {
			$related_product_ids = wcd_get_cart_related_products( $product_limit );
		} else {
			if ( 'current_product' == $content_source ) {
				$main_product_id = get_the_ID();
			}

			$exclude_products_array = explode( ',', $exclude_products );
			$related_product_ids    = wc_get_related_products( $main_product_id, $product_limit, $exclude_products_array );
		}

		if ( ! wcd_is_pro_activated() && ! wcd_is_preview_mode() && ! wcd_is_edit_mode() ) {
			$wishlist_show_hide = 'no';
		}
		?>

		<div class="wl-rpc-product-style">
			<div class="cx-grid">

			<?php
			if ( count( $related_product_ids ) > 0 ) :
				foreach ( $related_product_ids as $product_id ) :
					$product     = wc_get_product( $product_id );
					$thumbnail   = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
					$user_id     = get_current_user_id();
					$fav_product = in_array( $product_id, wcd_get_wishlist( $user_id ) );

					if ( ! empty( $fav_product ) ) {
						$fav_item = 'fav-item';
					} else {
						$fav_item = '';
					}
					?>

					<div class="wl-rpc-single-product <?php echo esc_attr( $alignment ); ?>">
						<div class="wl-rpc-single-widget">

							<?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ) : ?>
								<div class="wl-rpc-corner-ribbon">
									<?php
									printf(
										'<span %1$s>%2$s</span>',
										wp_kses_post( $this->get_render_attribute_string( 'sale_ribbon_text' ) ),
										esc_html( $settings['sale_ribbon_text'] )
									);
									?>
								</div>
								<?php
							endif;

							if ( 'yes' == $image_show_hide ) :
								?>
								<div class="wl-rpc-product-img">

									<?php if ( 'none' == $image_on_click ) : ?>
										<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
									<?php elseif ( 'zoom' == $image_on_click ) : ?>
										<a class="wl-rpc-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
									<?php elseif ( 'product_page' == $image_on_click ) : ?>
										<a href="<?php the_permalink( $product_id ); ?>">
											<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
										</a>
									<?php endif ?>

								</div>
							<?php endif ?>

							<div class="wl-rpc-product-details">
								<div class="wl-rpc-product-info">
									<div class="wl-rpc-product-name"><a <?php echo wp_kses_post( $this->get_render_attribute_string( 'title_gradient_color' ) ); ?> href="<?php esc_url( the_permalink( $product_id ) ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></div>

									<h2 class="wl-rpc-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></h2>
								</div>
								<div class="wl-rpc-info-icons">
									<?php if ( 'yes' == $wishlist_show_hide ) : ?>
										<div class="wl-rpc-product-fav ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php esc_attr_e( $product_id ); ?>">
											<i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
										</div>
										<?php
									endif;

									if ( 'yes' == $cart_show_hide ) :

										if ( 'simple' == $product->get_type() ) :
											?>
											<div class="wl-cart-area">
												<a href="?add-to-cart=<?php esc_attr_e( $product_id ); ?>" data-quantity="1" class="wl-rpc-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php esc_attr_e( $product_id ); ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
											</div>
										<?php else : ?>
											<div class="wl-cart-area">
												<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" data-quantity="1" class="wl-rpc-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?>" data-product_id="<?php esc_attr_e( $product_id ); ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
											</div>
											<?php
										endif;
									endif
									?>
								</div>
							</div>
						</div>
					</div>

					<?php
				endforeach;
				elseif ( 'cart_items' != $content_source || ( wcd_is_preview_mode() || wcd_is_edit_mode() ) ) :

					?>
							<p><?php esc_html_e( 'No Related Product Found!', 'codesigner' ); ?></p>
						<?php

			endif;
				?>

			</div> 
		</div>

		<?php

		do_action( 'codesigner_after_main_content', $this );

		/**
		 * Load Script
		 */
		$this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'sale_ribbon_text', 'basic' );
		$this->add_render_attribute( 'title_gradient_color', 'class', 'wl-gradient-heading' );
	}

	protected function render_script() {
		?>
		<script>
			jQuery(function($){
				$(".wl-rpc-product-image-zoom").fancybox({
					arrows: true,
					'transitionIn'  :   'elastic',
					'transitionOut' :   'elastic',
					'speedIn'       :   600, 
					'speedOut'      :   200, 
					'overlayShow'   :   false

				}).attr('data-fancybox', 'gallery');
			})
		</script>
		<?php
	}
}