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

class Pricing_Table_Basic extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
        
        // Are we in debug mode?
        $min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "codesigner-{$this->id}" ];
	}

	public function get_style_depends() {
		return [ "codesigner-{$this->id}" ];
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
		 * Header controls
		 */
		$this->start_controls_section(
			'_section_header',
			[
				'label' 		=> __( 'Header Section', 'codesigner' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'pricing_table_title',
            [
                'label' 		=> __( 'Title', 'codesigner' ),
                'type' 			=> Controls_Manager::TEXT,
                'label_block' 	=> true,
                'default' 		=> __( 'Basic', 'codesigner' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            '_section_pricing',
            [
                'label' 		=> __( 'Price', 'codesigner' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
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
                'label' 		=> __( 'Amount', 'codesigner' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> '11.99',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_period',
            [
                'label' 		=> __( 'Period', 'codesigner' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( '/month', 'codesigner' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );      
        
        $this->add_control(
            'show_sale_price',
            [
                'label' => __( 'Show sale Price', 'plugin-domain' ),
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

        $this->start_controls_section(
            '_section_features',
            [
                'label'			 => __( 'Features', 'codesigner' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'pricing_table_features_text',
            [
                'label' 		=> __( 'Text', 'codesigner' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Exciting Feature', 'codesigner' ),
                'label_block'   => 'true',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $repeater->add_control(
            'pricing_table_features_icon',
            [
                'label' 		=> __( 'Icon', 'codesigner' ),
                'type' 			=> Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' 		=> [
                    'value' 	=> 'fas fa-check',
                    'library' 	=> 'fa-solid',
                ],
                'recommended' 	=> [
                    'fa-regular' => [
                        'check-square',
                        'window-close',
                    ],
                    'fa-solid' 	=> [
                        'check',
                        'times'
                    ]
                ]
            ]
        );

        $this->add_control(
            'pricing_table_features_list',
            [
                'type' 			=> Controls_Manager::REPEATER,
                'fields' 		=> $repeater->get_controls(),
                'show_label' 	=> false,
                'default' 		=> [
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
                'title_field' 	=> '{{{pricing_table_features_text}}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_footer',
            [
                'label' 		=> __( 'Footer Button', 'codesigner' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_footer_button_text',
            [
                'label' 		=> __( 'Button Text', 'codesigner' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Buy This', 'codesigner' ),
                'placeholder' 	=> __( 'Type button text here', 'codesigner' ),
                'label_block' 	=> true,
                'dynamic' 		=> [
                    'active' 	=> true
                ],
            ]
        );

        $this->add_control(
            'pricing_table_footer_button_link',
            [
                'label' 		=> __( 'Link', 'codesigner' ),
                'type' 			=> Controls_Manager::URL,
                'label_block' 	=> true,
                'placeholder' 	=> 'https://codexpert.io/codesigner/',
                'dynamic' 		=> [
                    'active' => true,
                ],                
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_card',
            [
                'label' => __( 'Card', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_box_bg',
            [
                'label' => __( 'Background Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_margin',
            [
                'label'         => __( 'Margin', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-table-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_box_border',
                'label' => __( 'Border', 'codesigner' ),
                'selector' => '.wl {{WRAPPER}} .wl-ptb-single-pricing',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_header',
            [
                'label' => __( 'Header Section', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_header_bg_color',
            [
                'label' => __( 'Background Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-box' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_icon_box_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'pricing_table_icon_box_margin',
            [
                'label'         => __( 'Margin', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_separator',
            [
                'label'     => __( 'Separator', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'separator' => 'before',
                'size_units'    => [ 'px' ],
                'range'         => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 50,
                        'step' => .5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-box' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_separator_color',
            [
                'label' => __( 'Separator Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-box' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'pricing_table_header_title',
            [
                'label' => __( 'Title', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_header_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-single-pricing .wl-ptb-pricing-name',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->add_control(
            'pricing_table_header_color',
            [
                'label' => __( 'Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing .wl-ptb-pricing-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        //sale price
        $this->start_controls_section(
            '_section_style_sale_pricing',
            [
                'label' => __( 'Price', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_sale_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_price_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_price_space',
            [
                'label' => __( 'Bottom Space', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
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
                    '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_price_normal_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_price_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_price_color',
            [
                'label' => __( 'Font Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing .wl-ptb-pricing-price-full .wl-ptb-regular-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_price_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_price_color_hover',
            [
                'label' => __( 'Font Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-pricing-price-full .wl-ptb-regular-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_price_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-pricing-price-full .wl-ptb-regular-price' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_sale_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_currency_spacing',
            [
                'label' => __( 'Side Spacing', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price sup' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_currency_position',
            [
                'label' => __( 'Currency Position', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price sup' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_currency_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price sup',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_currency_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_currency_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_currency_color',
            [
                'label' => __( 'Icon Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-regular-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_currency_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_currency_hover_color',
            [
                'label' => __( 'Icon Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-pricing-price-full .wl-ptb-regular-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_currency_hover_color_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-pricing-price-full .wl-ptb-regular-price sup' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'pricing_table_heading_sale_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Period', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_period_spacing',
            [
                'label' => __( 'Side Spacing', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-regular-price .wl-ptb-pricing-period' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_period_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-pricing-period',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_period_color_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_period_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_period_color',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-regular-price .wl-ptb-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_period_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_period_color_hover',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-regular-price .wl-ptb-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_period_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-regular-price .wl-ptb-pricing-period' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); ///sale price

        //regular Price
        $this->start_controls_section(
            '_section_style_pricing',
            [
                'label' => __( 'Sale Price', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
            ]
        );

        $this->add_control(
            '_heading_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price', 'codesigner' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_price_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-pricing-price-full .wl-ptb-current-price',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_price_normal_tabs' );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_price_color',
            [
                'label' => __( 'Font Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing .wl-ptb-current-price' => 'color: {{VALUE}};',
                ],
                'default' => 'var(--wl-black)'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_price_color_hover',
            [
                'label' => __( 'Font Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-current-price ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_price_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-current-price ' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_spacing',
            [
                'label' => __( 'Side Spacing', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-current-price sup' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_position',
            [
                'label' => __( 'Currency Position', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-current-price sup' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_currency_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-current-price sup',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_currency_tabs' );

        $this->start_controls_tab(
            'pricing_table_currency_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_currency_color',
            [
                'label' => __( 'Icon Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-current-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_currency_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_currency_hover_color',
            [
                'label' => __( 'Icon Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-current-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_currency_hover_color_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-current-price sup' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'pricing_table_heading_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Period', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_period_spacing',
            [
                'label' => __( 'Side Spacing', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-current-price .wl-ptb-pricing-period' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_period_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-current-price .wl-ptb-pricing-period',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_period_color_tabs' );

        $this->start_controls_tab(
            'pricing_table_period_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_period_color',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-current-price .wl-ptb-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_period_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_period_color_hover',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-current-price .wl-ptb-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_period_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing:hover .wl-ptb-pricing-period' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_features_default_style',
            [
                'label' => __( 'View', 'codesigner' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list .wl-ptb-pricing-icon-svg' => 'width:20px',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_content_heading',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Features Content', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_content_spacing_x',
            [
                'label' => __( 'Content Position X', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_content_spacing_y',
            [
                'label' => __( 'Content Position Y', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_content_align',
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
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_heading_features_list',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'List', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_list_spacing',
            [
                'label' => __( 'Spacing Between', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_list_color',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li' => 'color: {{VALUE}};',
                ],
                'default' => '#212121'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_features_list_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 13 ] ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->add_control(
            'pricing_table_heading_features_icon',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Icon', 'codesigner' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_icon_spacing',
            [
                'label' => __( 'Side Spacing', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li .wl-ptb-pricing-icon-svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_icon_size',
            [
                'label' => __( 'Size', 'codesigner' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li .wl-ptb-pricing-icon-svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_icon_color',
            [
                'label' => __( 'Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-pricing-list ul li i' => 'color: {{VALUE}};',
                ],
                'default' => 'var(--wl-black)'
            ]
        );

        $this->end_controls_section();

        /*Button styling*/
        $this->start_controls_section(
            '_footer_button_styling',
            [
                'label' => __( 'Button', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_family'   => [ 'default' => 'Nunito' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'default'       => [
                    'unit'  => 'px',
                    'top'   => 10,
                    'right'   => 35,
                    'bottom'   => 10,
                    'left'   => 35,
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_btn_styling' );

        $this->start_controls_tab(
            'pricing_table_btn_normal',
            [
                'label' => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_control(
            'pricing_table_btn_color',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_bg',
            [
                'label' => __( 'Background Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border',
                'label' => __( 'Border', 'codesigner' ),
                'selector' => '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_btn_hover',
            [
                'label' => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_control(
            'pricing_table_btn_color_hover',
            [
                'label' => __( 'Text Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_bg_color_hover',
            [
                'label' => __( 'Background Color', 'codesigner' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border_hover',
                'label' => __( 'Border', 'codesigner' ),
                'selector' => '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_border_radius_hover',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ptb-single-pricing a.wl-price-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        extract( $settings );

        $this->render_editing_attributes();

        // Helper::pri( $settings['pricing_table_features_list'] );

        $del_start = '';
        $del_close = '';
        $sale_price_on = '';
        if ( $show_sale_price == 'yes' ) {
            $del_start = '<del>';
            $del_close = '</del>';
            $sale_price_on = 'wl-ptb-sale-on';
        }
        ?>

		<div class="wl-ptb-pricing-table-area">
			<div class="wl-ptb-single-pricing">
				<div class="wl-ptb-pricing-box">
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_title' ) ); ?> ><?php echo esc_html( $pricing_table_title ); ?></div>
					<div class="wl-ptb-pricing-price-full <?php echo esc_attr( $sale_price_on ); ?>">

                        <?php if ( 'left' == $pricing_table_currency_alignment ): ?>

                            <span class="wl-ptb-regular-price">
                                <sup><?php echo esc_html( $pricing_table_currency ); ?></sup><?php echo wp_kses_post( $del_start ); ?><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_price' ) ); ?> ><?php echo esc_html( $pricing_table_price ); ?></span><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_period' ) ); ?> ><?php echo esc_html( $pricing_table_period ); ?></span><?php echo wp_kses_post( $del_close ); ?>
                            </span>

                            <?php if( 'yes' == $show_sale_price ): ?>
                                <span class="wl-ptb-current-price">
                                    <sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_price' ) ); ?> ><?php echo esc_html( $pricing_table_sale_price ); ?></span><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_period' ) ); ?> ><?php echo esc_html( $pricing_table_period ); ?></span>
                                </span>
                            <?php endif;
                        endif;

                        if ( 'right' == $pricing_table_currency_alignment ): ?>
                            <span class="wl-ptb-regular-price">
                                <?php echo wp_kses_post( $del_start ); ?><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_price' ) ); ?> ><?php echo esc_html( $pricing_table_price ); ?></span><?php echo wp_kses_post( $del_close ); ?><sup><?php echo esc_html( $pricing_table_currency ); ?></sup><?php echo wp_kses_post( $del_start ); ?><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_period' ) ); ?> ><?php echo esc_html( $pricing_table_period ); ?></span><?php echo wp_kses_post( $del_close ); ?>
                            </span>

                            <?php if( 'yes' == $show_sale_price ): ?>
                            <span class="wl-ptb-current-price">
                                <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_sale_price' ) ); ?> ><?php echo esc_html( $pricing_table_price ); ?></span><sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing_table_period' ) ); ?> ><?php echo esc_html( $pricing_table_period ); ?></span>
                            </span>
                            <?php endif;
                        endif; ?>
                        
                    </div>
				</div>
				<div class="wl-ptb-pricing-list">
					<ul>
						<?php foreach ( $settings['pricing_table_features_list'] as $feature ): ?>
							<li>
                                <?php 
                                    if ( $feature['pricing_table_features_icon']['library'] == 'svg' ) {
                                        ?>
                                            <img class='wl-ptb-pricing-icon-svg' src='<?php echo esc_url( $feature['pricing_table_features_icon']['value']['url'] ); ?>' />
                                        <?php
                                    }
                                    else {
                                        ?>
                                            <i class='<?php echo esc_attr( $feature['pricing_table_features_icon']['value'] ); ?>'></i>
                                        <?php
                                    }
                                 ?><span><?php echo esc_html( $feature['pricing_table_features_text'] ) ?></span></li>
						<?php endforeach; ?>
					</ul>
				</div>

                <?php 
                    printf( '<a %s>%s</a>',
                        wp_kses_post( $this->get_render_attribute_string( 'pricing_table_footer_button_text' ) ),
                        esc_html( $pricing_table_footer_button_text )
                    );
                ?>
			</div>
		</div>

		<?php

        do_action( 'codesigner_after_main_content', $this );
	}

    private function render_editing_attributes() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        $btn_url    = esc_url( $pricing_table_footer_button_link['url'] );
        $target     = $pricing_table_footer_button_link['is_external'] ? '_blank' : '';
        $nofollow   = $pricing_table_footer_button_link['nofollow'] ? 'nofollow' : '';

        $this->add_inline_editing_attributes( 'pricing_table_title', 'basic' );
        $this->add_render_attribute( 'pricing_table_title', 'class', 'wl-ptb-pricing-name' );

        $this->add_inline_editing_attributes( 'pricing_table_price', 'basic' );
        $this->add_render_attribute( 'pricing_table_price', 'class', 'wl-ptb-pricing-price' );

        $this->add_inline_editing_attributes( 'pricing_table_period', 'basic' );
        $this->add_render_attribute( 'pricing_table_period', 'class', 'wl-ptb-pricing-period' );

        $this->add_inline_editing_attributes( 'pricing_table_footer_button_text', 'none' );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'class', 'wl-price-btn' );

        $this->add_render_attribute( 'pricing_table_footer_button_text', 'href', $btn_url );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'target', $target );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'rel', $nofollow );
    }
}