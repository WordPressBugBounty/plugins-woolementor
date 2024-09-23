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

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
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
            [
                'label'         => __( 'General', 'codesigner' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'is_featured',
            [
                'label'         => __( 'Is Featured?', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'codesigner' ),
                'label_off'     => __( 'No', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'is_featured_text',
            [
                'label'         => __( 'Badge Text', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Featured', 'codesigner' ),
                'placeholder'   => __( 'Type your title here', 'codesigner' ),
                'condition' => [
                    'is_featured' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * Pricing Content control
        */ 

        $this->start_controls_section(
            '_section_pricing',
            [
                'label'         => __( 'Price', 'codesigner' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_currency',
            [
                'label'         => __( 'Currency', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '$',
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_currency_alignment',
            [
                'label' => __( 'Currency Alignment', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'separator'=> 'after'
            ]
        );

        $this->add_control(
            'pricing_table_price',
            [
                'label'         => __( 'Amount', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '11.99',
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_period',
            [
                'label'         => __( 'Period', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'PER MONTH', 'codesigner' ),
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );      
        
        $this->add_control(
            'show_sale_price',
            [
                'label' => __( 'Show sale Price', 'codesigner' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'codesigner' ),
                'label_off' => __( 'Hide', 'codesigner' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'pricing_table_sale_price',
            [
                'label'         => __( 'sale Amount', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '9.99',
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Title & description content control
         */
        $this->start_controls_section(
            '_section_header',
            [
                'label'         => __( 'Title & Description', 'codesigner' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_title',
            [
                'label'         => __( 'Title', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'Smart Plan', 'codesigner' ),
            ]
        );

        $this->add_control(
            'show_plan_desc',
            [
                'label' => __( 'Show Description', 'codesigner' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'codesigner' ),
                'label_off' => __( 'Hide', 'codesigner' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_desc',
            [
                'label'         => __( 'Description', 'codesigner' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod', 'codesigner' ),
                'condition' => [
                    'show_plan_desc' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        /**
        * Features content control
        */

        $this->start_controls_section(
            '_section_features',
            [
                'label'          => __( 'Features', 'codesigner' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'pricing_table_features_text',
            [
                'label'         => __( 'Text', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Exciting Feature', 'codesigner' ),
                'label_block'   => 'true',
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $repeater->add_control(
            'pricing_table_features_icon',
            [
                'label'         => __( 'Icon', 'codesigner' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fas fa-check',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'check-square',
                        'window-close',
                    ],
                    'fa-solid'  => [
                        'check',
                        'times'
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
            ]
        );

        $repeater->add_control(
            'icon_hover_color',
            [
                'label' => __( 'Icon Hover Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
            ]
        );

        $this->add_control(
            'pricing_table_features',
            [
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'show_label'    => false,
                'default'       => [
                    [
                        'pricing_table_features_text' => __( 'Standard Feature', 'codesigner' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Another Great Feature', 'codesigner' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Obsolete Feature', 'codesigner' ),
                        'pricing_table_features_icon' => 'fas fa-times',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Extended Free Trial', 'codesigner' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                ],
                'title_field'   => '{{{pricing_table_features_text}}}',
            ]
        );

        $this->end_controls_section();

        /**
        * Button content control
        */

        $this->start_controls_section(
            '_section_footer',
            [
                'label'         => __( 'Footer Button', 'codesigner' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_purchase_btn',
            [
                'label' => __( 'Show Button', 'codesigner' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'codesigner' ),
                'label_off' => __( 'Hide', 'codesigner' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_btn_text',
            [
                'label'         => __( 'Button Text', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase', 'codesigner' ),
                'placeholder'   => __( 'Type button text here', 'codesigner' ),
                'label_block'   => true,
                'dynamic'       => [
                    'active'    => true
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_link',
            [
                'label'         => __( 'Link', 'codesigner' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'placeholder'   => 'https://codexpert.io/codesigner/',
                'dynamic'       => [
                    'active' => true,
                ], 
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],               
            ]
        );

        $this->end_controls_section();

        /**
        *Full card styling
        */

        $this->start_controls_section(
            '_section_style_card',
            [
                'label' => __( 'Card', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_card' );

        $this->start_controls_tab(
            'pricing_table_card_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_card_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg_hover',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_box_border',
                'label' => __( 'Border', 'codesigner' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_box_shadow',
                'label' => __( 'Box Shadow', 'codesigner' ),
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart',
            ]
        );


        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * Pricing area styling
        */

        $this->start_controls_section(
            '_section_style_pricing_area',
            [
                'label' => __( 'Pricing Area', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_area_box_alignment',
            [
                'label' => __( 'Box Alignment', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'pricing_area_text_align',
            [
                'label' => __( 'Test Align', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'codesigner' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'separator'    => 'before',
                'toggle' => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_area_width',
            [
                'label' => __( 'Width', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'    => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_pricing_area_margin',
            [
                'label'         => __( 'Margin', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'    => 'after',
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_pricing_area_tab' );

        $this->start_controls_tab(
            'pricing_table_pricing_area_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_pricing_area_bg',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-area',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_pricing_area_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_pricing_area_bg_hover',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-area',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Regular Price styling
        */

        $this->start_controls_section(
            '_section_style_price',
            [
                'label' => __( 'Price', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_price_tab' );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-regular-price ',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color_hover',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-regular-price ',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Sale Price styling
        */

        $this->start_controls_section(
            '_section_style_sale_price',
            [
                'label' => __( 'Sale Price', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sale_price_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_price_tab' );

        $this->start_controls_tab(
            'pricing_table_sale_price_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-sale-price ',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sale_pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-sale-price ',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Is featured styling
        */

        $this->start_controls_section(
            '_section_style_featured',
            [
                'label' => __( 'Featured', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'is_featured' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_offset_y',
            [
                'label'         => __( 'Offset Top', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured' => 'top: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_offset_x_r',
            [
                'label'         => __( 'Offset Right', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'pricing_area_box_alignment' => 'left'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured.right' => 'right: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_responsive_control(
            'featured_offset_x_l',
            [
                'label'         => __( 'Offset Left', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'pricing_area_box_alignment' => 'right'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured.left' => 'left: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'featured_rotation',
            [
                'label'         => __( 'Rotation', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 360,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured' => 'transform: rotate({{SIZE}}deg)'
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_featured' );

        $this->start_controls_tab(
            'pricing_table_featured_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_control(
            'featured_text_color',
            [
                'label' => __( 'Text Color', 'plugin-domain' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-featured' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_featured_bg',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-featured',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_featured_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_control(
            'featured_text_color_hover',
            [
                'label' => __( 'Text Color', 'plugin-domain' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-featured:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_featured_bg_hover',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-featured:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_featured_border',
                'label' => __( 'Border', 'codesigner' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pt-featured',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_featured_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_featured_shadow',
                'label' => __( 'Box Shadow', 'codesigner' ),
                'selector' => '{{WRAPPER}} .wl-pt-featured',
            ]
        );


        $this->add_responsive_control(
            'pricing_table_featured_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        *Period Price styling
        */

        $this->start_controls_section(
            '_section_style_period',
            [
                'label' => __( 'Period', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_period_tab' );

        $this->start_controls_tab(
            'pricing_table_period_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-pricing-period',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_period_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-pricing-period',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Title styling
        */

        $this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
            ]
        );


        $this->add_control(
            'title_align',
            [
                'label' => __( 'Alignment', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'codesigner' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_title_tab' );

        $this->start_controls_tab(
            'pricing_table_title_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_title_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-title',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Description styling
        */

        $this->start_controls_section(
            '_section_style_description',
            [
                'label' => __( 'Description', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_plan_desc' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
            ]
        );

        $this->add_control(
            'description_align',
            [
                'label' => __( 'Alignment', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'codesigner' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'codesigner' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_description_tab' );

        $this->start_controls_tab(
            'pricing_table_description_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'description_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-description',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_description_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'description_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-description',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Feature list styling
        */

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'features_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'features_align',
            [
                'label' => __( 'Alignment', 'codesigner' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'codesigner' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'codesigner' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'codesigner' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-feature-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'space_btn_items',
            [
                'label' => __( 'Space Between Features', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-featute' => 'margin: {{SIZE}}{{UNIT}} 0{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_features_tab' );

        $this->start_controls_tab(
            'pricing_table_features_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-ptsf-desc',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_features_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-ptsf-desc',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
        *Button styling
        */

        $this->start_controls_section(
            '_section_style_btn',
            [
                'label' => __( 'Button', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector'  => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_btn_tab' );

        $this->start_controls_tab(
            'pricing_table_btn_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
            ]
        );

         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border',
                'label' => __( 'Border', 'codesigner' ),
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_btn_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg_hover',
                'label' => __( 'Background', 'codesigner' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border_hover',
                'label' => __( 'Border', 'codesigner' ),                
                'selector' => '{{WRAPPER}} .wl-pricing-table-smart:hover .wl-pts-purchase',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pricing_table_btn_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator' => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_margin',
            [
                'label'         => __( 'Margin', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-smart .wl-pts-purchase' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}