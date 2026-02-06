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

class Shop_Standard extends Widget_Base {

	public $id;
	public $widget;

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

		do_action( 'codesigner_before_shop_content_controls', $this );

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
				),
				'desktop_default' => 2,
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
					'wl-ss-left'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'wl-ss-right' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'wl-ss-left',
				'toggle'  => false,
			)
		);

		$this->end_controls_section();

		do_action( 'codesigner_shop_query_controls', $this );

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
				'label'       => __( 'On Sale', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '%%discount_percentage%% off', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'sale_ribbon_show_hide' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Stock Ribbon controls
		 */
		$this->start_controls_section(
			'section_content_stock',
			array(
				'label' => __( 'Stock text', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'stock_show_hide',
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
			'stock_ribbon_text',
			array(
				'label'       => __( 'Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Out Of Stock', 'codesigner' ),
				'placeholder' => __( 'Type your text here', 'codesigner' ),
				'condition'   => array(
					'stock_show_hide' => 'yes',
				),
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
		 * Pagination controls
		 */
		$this->start_controls_section(
			'section_content_pagination',
			array(
				'label'     => __( 'Pagination', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'product_source' => 'shop',
				),
			)
		);

		$this->add_control(
			'pagination_show_hide',
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

		do_action( 'codesigner_after_shop_content_controls', $this );
		do_action( 'codesigner_before_shop_style_controls', $this );

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
			'widget_box_height',
			array(
				'label'           => __( 'Box Height', 'codesigner' ),
				'type'            => Controls_Manager::SLIDER,
				'size_units'      => array( 'px', '%', 'em' ),
				'selectors'       => array(
					'{{WRAPPER}} .wl-ss-single-widget'  => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wl-ss-single-product' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'           => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'desktop_default' => array(
					'size' => '',
					'unit' => 'px',
				),
				'tablet_default'  => array(
					'size' => 202,
					'unit' => 'px',
				),
				'mobile_default'  => array(
					'size' => 100,
					'unit' => '%',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'widget_box_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-ss-single-widget',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'widget_box_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-ss-single-widget',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'widget_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-single-widget',
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
				'name'     => 'title_gradient_color',
				'selector' => '{{WRAPPER}} .wl-gradient-heading',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-product-name a',
			)
		);

		$this->end_controls_section();

		/**
		 * Product Short Description
		 */
		$this->start_controls_section(
			'section_short_description',
			array(
				'label' => __( 'Short Description', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'short_description_show_hide',
			array(
				'label'        => __( 'Show Content', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'short_description_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-product-info .wl-ss-product-desc p',
			)
		);

		$this->add_control(
			'short_description_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-info .wl-ss-product-desc p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'product_desc_words_count',
			array(
				'label'   => __( 'Words Count', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 20,
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
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price h2 .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price ins .amount' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price > .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_size_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-info-icons .wl-ss-price ins, {{WRAPPER}} .wl-ss-info-icons .wl-ss-price h2 > .amount',
			)
		);

		$this->add_control(
			'sale_price_show_hide',
			array(
				'label'        => __( 'Show Sale Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'block',
				'default'      => 'none',
				'separator'    => 'before',
				'selectors'    => array(
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price del' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sale_price_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-info-icons .wl-ss-price h2 del .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
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
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-info-icons .wl-ss-price h2 del',
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
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .woocommerce-Price-currencySymbol',
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'image_thumbnail',
				'exclude' => array( 'custom' ),
				'include' => array(),
				'default' => 'large',
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ss-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ss-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
				'selector' => '{{WRAPPER}} .wl-ss-product-img img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-product-img img',
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
					'{{WRAPPER}} .wl-ss-product-img img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '{{WRAPPER}} .wl-ss-product-img img',
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
					'{{WRAPPER}} .wl-ss-product-img img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .wl-ss-product-img img:hover',
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
					'{{WRAPPER}} .wl-ss-product-img img:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		* Sale Ribbon Styling
		*/
		$this->start_controls_section(
			'section_style_sale_ribbon',
			array(
				'label'     => __( 'Sale Ribbon', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'sale_ribbon_show_hide' => 'yes',
				),
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
				'size_units'  => array( 'px', '%' ),
				'condition'   => array(
					'sale_ribbon_offset_toggle' => 'yes',
				),
				'range'       => array(
					'px' => array(
						'min'  => -500,
						'max'  => 700,
						'step' => 1,
					),
					'%'  => array(
						'min'  => -100,
						'max'  => 150,
						'step' => 1,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}',
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'media_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'sale_ribbon_offset_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min'  => -500,
						'max'  => 700,
						'step' => 1,
					),
					'%'  => array(
						'min'  => -100,
						'max'  => 150,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ss-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-corner-ribbon',
			)
		);

		$this->add_control(
			'sale_ribbon_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '2',
					'right'  => '12',
					'bottom' => '2',
					'left'   => '12',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'sale_ribbon_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-ss-corner-ribbon',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		* Stock Ribbon Styling
		*/

		$this->start_controls_section(
			'section_style_stock_ribbon',
			array(
				'label'     => __( 'Stock Ribbon', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'stock_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'stock_offset_toggle',
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
			'stock_media_offset_x',
			array(
				'label'       => __( 'Offset Left', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'condition'   => array(
					'stock_offset_toggle' => 'yes',
				),
				'range'       => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .wl-ss-stock' => 'left: {{SIZE}}{{UNIT}}',
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'stock_media_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'stock_offset_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-stock' => 'top: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->end_popover();

		$this->add_responsive_control(
			'stock_ribbon_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-stock' => 'width: {{SIZE}}{{UNIT}}',
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
			'stock_ribbon_transform',
			array(
				'label'     => __( 'Transform', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
			'stock_ribbon_font_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-stock' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'stock_content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ss-stock',
			)
		);

		$this->add_control(
			'stock_ribbon_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-stock' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'stock_ribbon_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'stock_ribbon_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-stock',
			)
		);

		$this->add_responsive_control(
			'stock_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'            => __( 'Icon', 'codesigner' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				),
				'recommended'      => array(
					'fa-regular' => array(
						'luggage-cart',
						'opencart',
					),
					'fa-solid'   => array(
						'shopping-cart',
						'cart-arrow-down',
						'cart-plus',
						'luggage-cart',
					),
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
					'{{WRAPPER}} .wl-ss-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ss-product-cart i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-cart i' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-product-cart i',
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
					'{{WRAPPER}} .wl-ss-product-cart i:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-cart i:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-product-cart i:hover',
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

		$this->add_responsive_control(
			'cart_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wl-ss-product-cart .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

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
				'label'            => __( 'Icon', 'codesigner' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'eicon-heart',
					'library' => 'fa-solid',
				),
				'recommended'      => array(
					'fa-regular' => array(
						'heart',
					),
					'fa-solid'   => array(
						'heart',
						'heart-broken',
						'heartbeat',
					),
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
					'{{WRAPPER}} .wl-ss-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs(
			'wishlist_style_tabs',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'regular_wishlist_color',
			array(
				'label' => __( 'Regular', 'codesigner' ),
			)
		);

		$this->add_control(
			'wishlist_icon_regular_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-fav i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_regular_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-fav i' => 'background: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'active_wishlist_color',
			array(
				'label' => __( 'Active', 'codesigner' ),
			)
		);

		$this->add_control(
			'wishlist_icon_active_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-fav .ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_active_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-product-fav .ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wishlist_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-product-fav i',
			)
		);

		$this->add_responsive_control(
			'wishlist_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Pagination
		 */
		$this->start_controls_section(
			'section_style_pagination',
			array(
				'label'     => __( 'Pagination', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'pagination_show_hide' => 'yes',
					'product_source'       => 'shop',
				),
			)
		);

		$this->add_control(
			'pagination_alignment',
			array(
				'label'     => __( 'Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_gap',
			array(
				'label'      => __( 'Gap with shop', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ss-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
			)
		);

		$this->add_control(
			'pagination_left_icon',
			array(
				'label'     => __( 'Left Icon', 'codesigner' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-chevron-left',
					'library' => 'solid',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'pagination_right_icon',
			array(
				'label'   => __( 'Right Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-chevron-right',
					'library' => 'solid',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_icon_size',
			array(
				'label'      => __( 'Font Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_area',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ss-pagination .page-numbers' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_line_height',
			array(
				'label'      => __( 'Line Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-ss-pagination .page-numbers' => 'line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_item_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_item_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'pagination_separator',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'pagination_normal_item',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-pagination .page-numbers',
			)
		);

		$this->add_responsive_control(
			'pagination_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_current_item',
			array(
				'label' => __( 'Active', 'codesigner' ),
			)
		);

		$this->add_control(
			'pagination_current_item_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers.current' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_current_item_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers.current' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_current_item_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-pagination .page-numbers.current',
			)
		);

		$this->add_responsive_control(
			'pagination_current_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'pagination_hover_item_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_hover_item_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers:hover' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_hover_item_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ss-pagination .page-numbers:hover',
			)
		);

		$this->add_responsive_control(
			'pagination_hover_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ss-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'pagination_hover_transition',
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
					'{{WRAPPER}} .wl-ss-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		do_action( 'codesigner_after_shop_style_controls', $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		// update_option( 'test_settings', $settings );
		$widget_id = $this->id;
		extract( $settings );

		if ( ! wcd_is_pro_activated() && ! wcd_is_preview_mode() && ! wcd_is_edit_mode() ) {
			$wishlist_show_hide = 'no';
		}

		$data = array();

		if ( wcd_is_pro_activated() ) {
			$data = array(
				'sale_ribbon_text'            => $sale_ribbon_text,
				'stock_ribbon_text'           => $stock_ribbon_text,
				'codesigner_condition_list'   => $codesigner_condition_list,
				'custom_query'                => $custom_query,
				'columns'                     => $columns,
				'alignment'                   => $alignment,
				'product_source'              => $product_source,
				'short_description_show_hide' => $short_description_show_hide,
				'product_desc_words_count'    => $product_desc_words_count,
				'content_source'              => $content_source,
				'main_product_id'             => $main_product_id,
				'product_limit'               => $product_limit,
				'ns_exclude_products'         => $ns_exclude_products,
				'number'                      => $number,
				'order'                       => $order,
				'orderby'                     => $orderby,
				'author'                      => $author,
				'categories'                  => $categories,
				'exclude_categories'          => $exclude_categories,
				'include_products'            => $include_products,
				'exclude_products'            => $exclude_products,
				'sale_products_show_hide'     => $sale_products_show_hide,
				'out_of_stock'                => $out_of_stock,
				'offset'                      => $offset,
				'image_on_click'              => $image_on_click,
				'sale_ribbon_show_hide'       => $sale_ribbon_show_hide,
				'stock_show_hide'             => $stock_show_hide,
				'cart_show_hide'              => $cart_show_hide,
				'wishlist_show_hide'          => $wishlist_show_hide,
				'pagination_show_hide'        => $pagination_show_hide,
				'image_thumbnail_size'        => $image_thumbnail_size,
				'quick_view_show_hide'        => $quick_view_show_hide,
				'wishlist_icon'               => $wishlist_icon,
				'cart_icon'                   => $cart_icon,
				'pagination_left_icon'        => $pagination_left_icon,
				'pagination_right_icon'       => $pagination_right_icon,
			);
		}

		if ( ! wcd_is_pro_activated() && ! wcd_is_preview_mode() && ! wcd_is_edit_mode() ) {
			$wishlist_show_hide = 'no';
		}

		do_action( 'codesigner_before_main_content' );

		?>

		<div class="wl-shop wl-<?php echo esc_attr( $widget_id ); ?>" data-settings="<?php echo esc_attr( serialize( $data ) ); ?>">
		<?php
		Helper::get_template(
			'template',
			"widgets/{$this->id}",
			array(
				'widget_id' => $widget_id,
				'settings'  => $settings,
			),
			false
		);
		?>
		</div>

		<?php

		update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 0 );
		if ( wcd_is_pro_activated() && 'yes' == $quick_checkout_show_hide ) {
			$config = array(
				'active_mode' => $quick_checkout_modal_active_mode,
			);
			do_action( 'codesigner_quick_checkout', $config );

			update_post_meta( get_the_ID(), 'codesigner_quick_checkout', 1 );
		}

		do_action( 'codesigner_after_main_content', $this );
	}
}