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

class Shop_Slider extends Widget_Base {

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
		return array( "codesigner-{$this->id}", 'fancybox', 'slick' );
	}

	public function get_style_depends() {
		return array( "codesigner-{$this->id}", 'fancybox', 'slick' );
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
			'_section_settings_slick',
			array(
				'label' => __( 'Settings', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'              => __( 'Animation Speed', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 10,
				'max'                => 10000,
				'default'            => 300,
				'description'        => __( 'Slide speed in milliseconds', 'codesigner' ),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'              => __( 'Autoplay?', 'codesigner' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'codesigner' ),
				'label_off'          => __( 'No', 'codesigner' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'              => __( 'Autoplay Speed', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 100,
				'max'                => 10000,
				'default'            => 3000,
				'description'        => __( 'Autoplay speed in milliseconds', 'codesigner' ),
				'condition'          => array(
					'autoplay' => 'yes',
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'infinite_loop',
			array(
				'label'              => __( 'Infinite Loop?', 'codesigner' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'codesigner' ),
				'label_off'          => __( 'No', 'codesigner' ),
				'return_value'       => true,
				'default'            => true,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'              => __( 'Navigation', 'codesigner' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'none'  => __( 'None', 'codesigner' ),
					'arrow' => __( 'Arrow', 'codesigner' ),
					'dots'  => __( 'Dots', 'codesigner' ),
					'both'  => __( 'Arrow & Dots', 'codesigner' ),
				),
				'default'            => 'arrow',
				'frontend_available' => true,
				'style_transfer'     => true,
			)
		);

		$this->add_control(
			'arrow_icon_left',
			array(
				'label'     => __( 'Arrow Icon Left', 'codesigner' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'eicon-chevron-left',
					'library' => 'solid',
				),
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
			)
		);

		$this->add_control(
			'arrow_icon_right',
			array(
				'label'     => __( 'Arrow Icon Right', 'codesigner' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'eicon-chevron-right',
					'library' => 'solid',
				),
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'slides_show',
			array(
				'label'              => __( 'Show at Once', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'max'                => 12,
				'min'                => 1,
				'desktop_default'    => 2,
				'tablet_default'     => 2,
				'mobile_default'     => 1,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'slider_alignment',
			array(
				'label'   => __( 'Slider Alignment', 'codesigner' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'false' => array(
						'title' => __( 'Horizontal', 'codesigner' ),
						'icon'  => 'fas fa-arrows-alt-h',
					),
					'true'  => array(
						'title' => __( 'Vertical', 'codesigner' ),
						'icon'  => 'fas fa-arrows-alt-v',
					),
				),
				'default' => 'false',
				'toggle'  => false,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_settings',
			array(
				'label' => __( 'Layout', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'   => __( 'Content Alignment', 'codesigner' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'wl-ssl-left'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'wl-ssl-right' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'wl-ssl-left',
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
				'label'       => __( 'On Sale Test', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '%%discount_percentage%% off', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
			)
		);

		$this->end_controls_section();

		/**
		 * Sale Ribbon controls
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
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			array(
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'widget_box_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-ssl-single-widget',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'widget_box_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-ssl-single-widget',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'widget_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-single-widget',
			)
		);

		$this->add_responsive_control(
			'widget_box_shadow_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-single-product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		do_action( 'codesigner_after_shop_content_controls', $this );
		do_action( 'codesigner_before_shop_style_controls', $this );

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
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ssl-product-name a',
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
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
				'selector'       => '{{WRAPPER}} .wl-ssl-product-info .wl-ssl-product-desc p',
			)
		);

		$this->add_control(
			'short_description_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-product-info .wl-ssl-product-desc p' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ins' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 > .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_size_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ins, {{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 > .amount',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
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
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price del' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sale_price_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 del .amount' => 'color: {{VALUE}}',
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
				'selector'       => '{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 del',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
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
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
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
					'{{WRAPPER}} .wl-ssl-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
				'selector' => '{{WRAPPER}} .wl-ssl-product-img img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-product-img img',
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
					'{{WRAPPER}} .wl-ssl-product-img img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '{{WRAPPER}} .wl-ssl-product-img img',
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
					'{{WRAPPER}} .wl-ssl-product-img img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .wl-ssl-product-img img:hover',
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
					'{{WRAPPER}} .wl-ssl-product-img img:hover' => 'transition-duration: {{SIZE}}s',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{SIZE}}deg);',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '{{WRAPPER}} .wl-ssl-corner-ribbon',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '0',
					'right'  => '12',
					'bottom' => '0',
					'left'   => '12',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'sale_ribbon_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-ssl-corner-ribbon',
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
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .wl-ssl-stock' => 'left: {{SIZE}}{{UNIT}}',
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
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-stock' => 'top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-stock' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
					'{{WRAPPER}} .wl-ssl-stock' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'stock_content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '{{WRAPPER}} .wl-ssl-stock',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'stock_ribbon_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-stock' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .wl-ssl-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'stock_ribbon_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-stock',
			)
		);

		$this->add_responsive_control(
			'stock_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'value'   => 'eicon-cart-solid',
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
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-product-cart i',
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
					'{{WRAPPER}} .wl-ssl-product-cart i:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-product-cart i:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-product-cart i:hover',
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
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_regular_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_active_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-ssl-product-fav i',
			)
		);

		$this->add_responsive_control(
			'wishlist_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Navigation - Arrow
		 */
		$this->start_controls_section(
			'_section_style_arrow',
			array(
				'label'     => __( 'Navigation - Arrow', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
			)
		);

		$this->add_control(
			'arrow_position_toggle',
			array(
				'label'        => __( 'Position', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'arrow_position_y',
			array(
				'label'      => __( 'Vertical', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'arrow_position_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_position_x',
			array(
				'label'      => __( 'Horizontal', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'arrow_position_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 250,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-next' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_popover();

		$this->add_responsive_control(
			'arrow_icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-slider .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wl-ssl-slider .slick-prev' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-slider .slick-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-ssl-slider .slick-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'arrow_border',
				'selector' => '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next',
			)
		);

		$this->add_responsive_control(
			'arrow_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				),
			)
		);

		$this->start_controls_tabs( '_tabs_arrow' );

		$this->start_controls_tab(
			'_tab_arrow_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_arrow_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'arrow_hover_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'arrow_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Navigation - Dots
		 */
		$this->start_controls_section(
			'_section_style_dots',
			array(
				'label'     => __( 'Navigation - Dots', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation' => array( 'dots', 'both' ),
				),
			)
		);

		$this->add_responsive_control(
			'arrow_dots_size',
			array(
				'label'      => __( 'Dots Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-ssl-slider .slick-dots li button::before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_position_y',
			array(
				'label'      => __( 'Vertical Position', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_spacing',
			array(
				'label'      => __( 'Spacing', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots li' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_align',
			array(
				'label'       => __( 'Alignment', 'codesigner' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'toggle'      => true,
				'selectors'   => array(
					'{{WRAPPER}} .slick-dots' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( '_tabs_dots' );
		$this->start_controls_tab(
			'_tab_dots_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_dots_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_hover_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li button:hover:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_dots_active',
			array(
				'label' => __( 'Active', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_active_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots .slick-active button:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		do_action( 'codesigner_after_shop_style_controls', $this );
	}

	protected function render() {

		$settings   = $this->get_settings_for_display();
		$widget_id  = $this->id;
		$section_id = $this->get_id();
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
				'alignment'                   => $alignment,
				'product_source'              => $product_source,
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
				'image_thumbnail_size'        => $image_thumbnail_size,
				'quick_view_show_hide'        => $quick_view_show_hide,
				'wishlist_icon'               => $wishlist_icon,
				'cart_icon'                   => $cart_icon,
				'autoplay'                    => $autoplay,
				'autoplay_speed'              => $autoplay_speed,
				'animation_speed'             => $animation_speed,
				'infinite_loop'               => $infinite_loop,
				'navigation'                  => $navigation,
				'slides_show'                 => $slides_show,
				'slides_show_mobile'          => $slides_show_mobile,
				'slides_show_tablet'          => $slides_show_tablet,
				'slider_alignment'            => $slider_alignment,
				'arrow_icon_left'             => $arrow_icon_left,
				'arrow_icon_right'            => $arrow_icon_right,
				'short_description_show_hide' => $short_description_show_hide,
				'product_desc_words_count'    => $product_desc_words_count,
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
				'widget_id'  => $widget_id,
				'section_id' => $section_id,
				'settings'   => $settings,
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