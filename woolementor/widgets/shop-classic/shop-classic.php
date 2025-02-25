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

class Shop_Classic extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), time() );
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

		do_action( 'codesigner_before_shop_content_controls', $this, $this->id );

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
					'wl-sc-left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'wl-sc-center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'wl-sc-right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'wl-sc-left',
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
				'label'     => __( 'On Click', 'codesigner' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'         => __( 'None', 'codesigner' ),
					'zoom'         => __( 'Zoom', 'codesigner' ),
					'product_page' => __( 'Product Page', 'codesigner' ),
				),
				'default'   => 'none',
				'condition' => array(
					'image_show_hide' => 'yes',
				),
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
				'label' => __( 'Stock Ribbon', 'codesigner' ),
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

		do_action( 'codesigner_after_shop_content_controls', $this, $this->id );
		do_action( 'codesigner_before_shop_style_controls', $this, $this->id );

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

		$this->add_control(
			'widget_card_default_styles',
			array(
				'label'     => __( 'Default', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-style .button' => 'background: transparent;padding: 0px;',
					'.wl {{WRAPPER}} .wl-sc-product-style' => 'display: flex;justify-content: center; flex-wrap: wrap;',
					'.wl {{WRAPPER}} .wl-sc-single-widget' => 'text-align: center;margin: auto;position: relative;overflow: hidden;border-radius: 0;',
					'.wl {{WRAPPER}} .wl-sc-single-product' => 'float: left;width: 100%;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_responsive_control(
			'widget_card_height',
			array(
				'label'      => __( 'Card Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-single-widget' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'widget_card_background',
				'label'          => __( 'Background', 'codesigner' ),
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-single-widget',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#fff',
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'widget_card_border',
				'label'          => __( 'Border', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-single-widget',
				'separator'      => 'before',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'default' => 'var(--wl-light-gray)',
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'           => 'widget_card_shadow',
				'label'          => __( 'Box Shadow', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-single-widget',
				'fields_options' =>
				array(
					'box_shadow_type' =>
					array(
						'default' => 'yes',
					),
					'box_shadow'      => array(
						'default' =>
							array(
								'horizontal' => 2,
								'vertical'   => 7,
								'blur'       => 8,
								'spread'     => -12,
								'color'      => 'rgb(175 175 175 / 60%)',
							),
					),
				),
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
					'size' => 25,
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
					'size' => 25,
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

		$this->add_control(
			'title_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-name a' => 'letter-spacing: 1.3px; margin-bottom: 10px;display: inline-block;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'           => 'title_color',
				'selector'       => '.wl {{WRAPPER}} .wl-gradient-heading',

				'fields_options' => array(
					'color' => array( 'default' => 'var(--wl-black)' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-product-name a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
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
			'price_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins' => 'background: transparent;text-decoration: none;',
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del' => 'display: none;padding-right: 10px;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins .amount' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price > .amount' => 'color: {{VALUE}}',
				),
				'default'   => 'color: var(--wl-gray);',
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
				'selector'       => '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins,
                                .wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price > .amount',
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
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sale_price_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del .amount' => 'color: {{VALUE}}',
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
				'selector'       => '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
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
					'.wl {{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
				'default'   => 'color: var(--wl-gray);',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_currency_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
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

		$this->add_control(
			'mage_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-img' => 'overflow: hidden; height: auto; display: flex; align-items: center; justify-content: center;',
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'max-width: 100%;',
				),
				'default'   => 'traditional',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-img img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-img img',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-img img',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-img img:hover',
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
					'.wl {{WRAPPER}} .wl-sc-product-img img:hover' => 'transition-duration: {{SIZE}}s',
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
				'label' => __( 'Sale Ribbon', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ribbon_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'position: absolute;text-align: center;letter-spacing: 1px;z-index: 100;top:27px',
					'.wl {{WRAPPER}} .wl-sc-right .wl-sc-corner-ribbon' => 'right: 0;',
					'.wl {{WRAPPER}} .wl-sc-left .wl-sc-corner-ribbon' => 'left: 0;',
				),
				'default'   => 'traditional',
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
				'default'      => 'yes',
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
					'.wl {{WRAPPER}} .wl-sc-left .wl-sc-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-sc-right .wl-sc-corner-ribbon' => 'right: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 27,
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
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
				'default'   => '#ffffff',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-corner-ribbon',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 12 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
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
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'background: {{VALUE}}',
				),
				'default'   => 'var(--wl-black)',
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '.wl {{WRAPPER}} .wl-sc-corner-ribbon',
			)
		);

		$this->add_responsive_control(
			'sale_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'stock_ribbon_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-stock' => 'position: absolute;text-align: center;letter-spacing: 1px;z-index: 100;top:53px',
					'.wl {{WRAPPER}} .wl-sc-right .wl-sc-stock' => 'right: 0;',
					'.wl {{WRAPPER}} .wl-sc-left .wl-sc-stock' => 'left: 0;',
				),
				'default'   => 'traditional',
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
				'default'      => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'stock_media_offset_x',
			array(
				'label'       => __( 'Offset Left', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
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
					'.wl {{WRAPPER}} .wl-sc-right .wl-sc-stock' => 'right: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-sc-left .wl-sc-stock' => 'left: {{SIZE}}{{UNIT}}',
				),
				'default'     => array(
					'unit' => 'px',
					'size' => 0,
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'stock_media_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'stock_offset_toggle' => 'yes',
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
					'.wl {{WRAPPER}} .wl-sc-stock' => 'top: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-stock' => 'width: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
					'.wl {{WRAPPER}} .wl-sc-stock' => 'color: {{VALUE}}',
				),
				'default'   => '#fff',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'stock_content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-sc-stock',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 12 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
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
					'.wl {{WRAPPER}} .wl-sc-stock' => 'background: {{VALUE}}',
				),
				'default'   => '#ccc',
			)
		);

		$this->add_responsive_control(
			'stock_ribbon_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'stock_ribbon_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-stock',
			)
		);

		$this->add_responsive_control(
			'stock_ribbon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-cart i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-cart i' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-cart i',
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
					'.wl {{WRAPPER}} .wl-sc-product-cart i:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-cart i:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-cart i:hover',
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
					'.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cart_icon_bg_view_cart',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
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
					'.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_border_view_cart',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .added_to_cart.wc-forward::after',
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
				'label'            => __( 'Icon', 'codesigner' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-heart',
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
					'.wl {{WRAPPER}} .wl-sc-product-fav' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'.wl {{WRAPPER}} .wl-sc-product-fav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-fav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-product-fav' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-fav' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-fav',
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
					'.wl {{WRAPPER}} .wl-sc-product-fav:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'wishlist_icon_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-product-fav:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'wishlist_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-product-fav:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
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
					'product_source'       => 'shop',
					'pagination_show_hide' => 'yes',
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
					'.wl {{WRAPPER}} .wl-sc-pagination' => 'text-align: {{VALUE}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
					'value'   => 'eicon-chevron-left',
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
					'value'   => 'eicon-chevron-right',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_icon_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers',
			)
		);

		$this->add_responsive_control(
			'pagination_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_current_item_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_current_item_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current',
			)
		);

		$this->add_responsive_control(
			'pagination_current_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_hover_item_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_hover_item_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover',
			)
		);

		$this->add_responsive_control(
			'pagination_hover_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		do_action( 'codesigner_after_shop_style_controls', $this );
	}

	protected function render() {

		$settings  = $this->get_settings_for_display();
		$widget_id = $this->id;

		extract( $settings );

		// print_r($alignment);

		$data = array();

		if ( wcd_is_pro_activated() ) {
			$data = array(
				'sale_ribbon_text'          => $sale_ribbon_text,
				'stock_ribbon_text'         => $stock_ribbon_text,
				'codesigner_condition_list' => $codesigner_condition_list,
				'custom_query'              => $custom_query,
				'columns'                   => $columns,
				'alignment'                 => $alignment,
				'product_source'            => $product_source,
				'content_source'            => $content_source,
				'main_product_id'           => $main_product_id,
				'product_limit'             => $product_limit,
				'ns_exclude_products'       => $ns_exclude_products,
				'number'                    => $number,
				'order'                     => $order,
				'orderby'                   => $orderby,
				'author'                    => $author,
				'categories'                => $categories,
				'exclude_categories'        => $exclude_categories,
				'include_products'          => $include_products,
				'exclude_products'          => $exclude_products,
				'sale_products_show_hide'   => $sale_products_show_hide,
				'out_of_stock'              => $out_of_stock,
				'offset'                    => $offset,
				'image_show_hide'           => $image_show_hide,
				'image_on_click'            => $image_on_click,
				'sale_ribbon_show_hide'     => $sale_ribbon_show_hide,
				'stock_show_hide'           => $stock_show_hide,
				'cart_show_hide'            => $cart_show_hide,
				'wishlist_show_hide'        => $wishlist_show_hide,
				'pagination_show_hide'      => $pagination_show_hide,
				'image_thumbnail_size'      => $image_thumbnail_size,
				'quick_view_show_hide'      => $quick_view_show_hide,
				'wishlist_icon'             => $wishlist_icon,
				'cart_icon'                 => $cart_icon,
				'pagination_left_icon'      => $pagination_left_icon,
				'pagination_right_icon'     => $pagination_right_icon,
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