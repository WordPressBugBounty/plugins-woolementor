<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class Pricing_Table_Smart extends Widget_Base {

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

		/**
		 * General controls
		 */
		$this->start_controls_section(
			'_section_general',
			array(
				'label' => __( 'General', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'is_featured',
			array(
				'label'        => __( 'Is Featured?', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'codesigner' ),
				'label_off'    => __( 'No', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'is_featured_text',
			array(
				'label'       => __( 'Badge Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Featured', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'is_featured' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		* Pricing Content control
		*/

		$this->start_controls_section(
			'_section_pricing',
			array(
				'label' => __( 'Price', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'pricing_table_currency',
			array(
				'label'   => __( 'Currency', 'codesigner' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'pricing_table_currency_alignment',
			array(
				'label'     => __( 'Currency Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => true,
				'separator' => 'after',
			)
		);

		$this->add_control(
			'pricing_table_price',
			array(
				'label'   => __( 'Amount', 'codesigner' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '11.99',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'pricing_table_period',
			array(
				'label'   => __( 'Period', 'codesigner' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'PER MONTH', 'codesigner' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'show_sale_price',
			array(
				'label'        => __( 'Show sale Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'pricing_table_sale_price',
			array(
				'label'     => __( 'sale Amount', 'codesigner' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '9.99',
				'condition' => array(
					'show_sale_price' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title & description content control
		 */
		$this->start_controls_section(
			'_section_header',
			array(
				'label' => __( 'Title & Description', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'pricing_table_title',
			array(
				'label'       => __( 'Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Smart Plan', 'codesigner' ),
			)
		);

		$this->add_control(
			'show_plan_desc',
			array(
				'label'        => __( 'Show Description', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'pricing_table_desc',
			array(
				'label'     => __( 'Description', 'codesigner' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod', 'codesigner' ),
				'condition' => array(
					'show_plan_desc' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		/**
		* Features content control
		*/

		$this->start_controls_section(
			'_section_features',
			array(
				'label' => __( 'Features', 'codesigner' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pricing_table_features_text',
			array(
				'label'       => __( 'Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Exciting Feature', 'codesigner' ),
				'label_block' => 'true',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'pricing_table_features_icon',
			array(
				'label'            => __( 'Icon', 'codesigner' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'recommended'      => array(
					'fa-regular' => array(
						'check-square',
						'window-close',
					),
					'fa-solid'   => array(
						'check',
						'times',
					),
				),
			)
		);

		$repeater->add_control(
			'icon_color',
			array(
				'label'   => __( 'Icon Color', 'codesigner' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#000',
			)
		);

		$repeater->add_control(
			'icon_hover_color',
			array(
				'label'   => __( 'Icon Hover Color', 'codesigner' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#fff',
			)
		);

		$this->add_control(
			'pricing_table_features',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'show_label'  => false,
				'default'     => array(
					array(
						'pricing_table_features_text' => __( 'Standard Feature', 'codesigner' ),
						'pricing_table_features_icon' => 'fas fa-check',
					),
					array(
						'pricing_table_features_text' => __( 'Another Great Feature', 'codesigner' ),
						'pricing_table_features_icon' => 'fas fa-check',
					),
					array(
						'pricing_table_features_text' => __( 'Obsolete Feature', 'codesigner' ),
						'pricing_table_features_icon' => 'fas fa-times',
					),
					array(
						'pricing_table_features_text' => __( 'Extended Free Trial', 'codesigner' ),
						'pricing_table_features_icon' => 'fas fa-check',
					),
				),
				'title_field' => '{{{pricing_table_features_text}}}',
			)
		);

		$this->end_controls_section();

		/**
		* Button content control
		*/

		$this->start_controls_section(
			'_section_footer',
			array(
				'label' => __( 'Footer Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_purchase_btn',
			array(
				'label'        => __( 'Show Button', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'pricing_table_btn_text',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Purchase', 'codesigner' ),
				'placeholder' => __( 'Type button text here', 'codesigner' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					'show_purchase_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'pricing_table_btn_link',
			array(
				'label'       => __( 'Link', 'codesigner' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://codexpert.io/codesigner/',
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					'show_purchase_btn' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		*Full card styling
		*/

		$this->start_controls_section(
			'_section_style_card',
			array(
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'pricing_table_card' );

		$this->start_controls_tab(
			'pricing_table_card_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_box_bg',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_card_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_box_bg_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'pricing_table_box_border',
				'label'     => __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pricing-table-smart',
			)
		);

		$this->add_responsive_control(
			'pricing_table_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'pricing_table_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart',
			)
		);

		$this->add_responsive_control(
			'pricing_table_box_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		* Pricing area styling
		*/

		$this->start_controls_section(
			'_section_style_pricing_area',
			array(
				'label' => __( 'Pricing Area', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pricing_area_box_alignment',
			array(
				'label'   => __( 'Box Alignment', 'codesigner' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default' => 'left',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'pricing_area_text_align',
			array(
				'label'     => __( 'Test Align', 'codesigner' ),
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
				'default'   => 'left',
				'separator' => 'before',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pricing_area_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pricing_table_pricing_area_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pricing_table_pricing_area_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pricing_table_pricing_area_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_pricing_area_tab' );

		$this->start_controls_tab(
			'pricing_table_pricing_area_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_pricing_area_bg',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_pricing_area_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_pricing_area_bg_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-area',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Regular Price styling
		*/

		$this->start_controls_section(
			'_section_style_price',
			array(
				'label' => __( 'Price', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
			)
		);

		$this->start_controls_tabs( 'pricing_table_price_tab' );

		$this->start_controls_tab(
			'pricing_table_price_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'      => 'price_gradient_color',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_price_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'      => 'price_gradient_color_hover',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-regular-price ',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Sale Price styling
		*/

		$this->start_controls_section(
			'_section_style_sale_price',
			array(
				'label'     => __( 'Sale Price', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_sale_price' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
			)
		);

		$this->start_controls_tabs( 'pricing_table_sale_price_tab' );

		$this->start_controls_tab(
			'pricing_table_sale_price_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'sale_price_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sale_pricing_table_price_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'sale_price_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-sale-price ',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Is featured styling
		*/

		$this->start_controls_section(
			'_section_style_featured',
			array(
				'label'     => __( 'Featured', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'is_featured' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'featured_offset_y',
			array(
				'label'      => __( 'Offset Top', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured' => 'top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'featured_offset_x_r',
			array(
				'label'      => __( 'Offset Right', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'pricing_area_box_alignment' => 'left',
				),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured.right' => 'right: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_responsive_control(
			'featured_offset_x_l',
			array(
				'label'      => __( 'Offset Left', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'pricing_area_box_alignment' => 'right',
				),
				'range'      => array(
					'px' => array(
						'min' => -1000,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured.left' => 'left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'featured_rotation',
			array(
				'label'      => __( 'Rotation', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 360,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured' => 'transform: rotate({{SIZE}}deg)',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_featured' );

		$this->start_controls_tab(
			'pricing_table_featured_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'featured_text_color',
			array(
				'label'     => __( 'Text Color', 'plugin-domain' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .wl-pt-featured' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_featured_bg',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pt-featured',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_featured_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'featured_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'plugin-domain' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .wl-pt-featured:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'pricing_table_featured_bg_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-pt-featured:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'pricing_table_featured_border',
				'label'     => __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pt-featured',
			)
		);

		$this->add_responsive_control(
			'pricing_table_featured_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'pricing_table_featured_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pt-featured',
			)
		);

		$this->add_responsive_control(
			'pricing_table_featured_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pt-featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		*Period Price styling
		*/

		$this->start_controls_section(
			'_section_style_period',
			array(
				'label' => __( 'Period', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'period_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
			)
		);

		$this->start_controls_tabs( 'pricing_table_period_tab' );

		$this->start_controls_tab(
			'pricing_table_period_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'period_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_period_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'period_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-period',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Title styling
		*/

		$this->start_controls_section(
			'_section_style_title',
			array(
				'label' => __( 'Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
			)
		);

		$this->add_control(
			'title_align',
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
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_title_tab' );

		$this->start_controls_tab(
			'pricing_table_title_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'title_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_title_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'title_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-title',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Description styling
		*/

		$this->start_controls_section(
			'_section_style_description',
			array(
				'label'     => __( 'Description', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_plan_desc' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
			)
		);

		$this->add_control(
			'description_align',
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
						'title' => __( 'Justify', 'codesigner' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right'   => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_description_tab' );

		$this->start_controls_tab(
			'pricing_table_description_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'description_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_description_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'description_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-description',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Feature list styling
		*/

		$this->start_controls_section(
			'_section_style_features',
			array(
				'label' => __( 'Features', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'features_align',
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
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-feature-list' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'space_btn_items',
			array(
				'label'      => __( 'Space Between Features', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-featute' => 'margin: {{SIZE}}{{UNIT}} 0{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_features_tab' );

		$this->start_controls_tab(
			'pricing_table_features_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'features_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_features_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'features_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-ptsf-desc',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		*Button styling
		*/

		$this->start_controls_section(
			'_section_style_btn',
			array(
				'label' => __( 'Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
			)
		);

		$this->add_responsive_control(
			'pricing_table_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'pricing_table_btn_tab' );

		$this->start_controls_tab(
			'pricing_table_btn_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'btn_gradient_color',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'pricing_table_btn_bg',
				'label'     => __( 'Background', 'codesigner' ),
				'types'     => array( 'classic', 'gradient' ),
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pricing_table_btn_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pricing_table_btn_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'btn_gradient_color_hover',
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'pricing_table_btn_bg_hover',
				'label'     => __( 'Background', 'codesigner' ),
				'types'     => array( 'classic', 'gradient' ),
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pricing_table_btn_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pricing_table_btn_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pricing_table_btn_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		echo wp_kses_post( wcd_notice( sprintf( __( 'This beautiful widget, <strong>%1$s</strong> is a premium widget. Please upgrade to <strong>%2$s</strong> or activate your license if you already have upgraded!' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) ) );

		if ( file_exists( __DIR__ . '/assets/img/screenshot.png' ) ) {
			?>
				<img src='<?php echo esc_url( plugins_url( 'assets/img/screenshot.png', __FILE__ ) ); ?>' />
			<?php
		}
	}
}