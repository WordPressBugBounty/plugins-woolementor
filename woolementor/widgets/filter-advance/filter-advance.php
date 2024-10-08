<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Filter_Advance extends Widget_Base {

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
		 * Settings controls
		 */
		$this->start_controls_section(
			'fv_general',
			[
				'label' 		=> __( 'Components', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'wcd_taxonomies',
            [
                'label'     => __( 'Filter Items', 'codesigner' ),
                'type' 	    => Controls_Manager::SELECT2,
                'options'   => wcd_get_taxonomies(),
                'separator' 		=> 'before',
                'multiple'          => true,
                'style_transfer' 	=> true,
                'label_block' 		=> true,
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'fv_section_header',
			[
				'label' 		=> __( 'Header', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fv_header_show_hide',
			[
				'label'         => __( 'Show Header', 'codesigner' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'codesigner' ),
				'label_off'     => __( 'Hide', 'codesigner' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'fv_section_header_text',
			[
				'label' => __( 'Heading Text', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Filter',
				'condition' => [
                    'fv_header_show_hide' => 'yes'
                ],
				'placeholder' => __( 'Type Section title here', 'codesigner' ),
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'fv_section_form_action',
			[
				'label' 		=> __( 'Form Action', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'form_action_show',
			[
				'label' 		=> __( 'Custom Form Action', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
            'form_action',
            [
                'label'     => __( 'Action Url', 'codesigner' ),
                'type' 	    => Controls_Manager::TEXT,
                'placeholder' => 'http://example.com/',
				'condition' => [
                    'form_action_show' => 'yes'
                ],
            ]
        );

		$this->end_controls_section();

		/*
		*sort_by_show_hide
		*/

		$this->start_controls_section(
			'fv__search',
			[
				'label' 		=> __( 'Search Form', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'filter_vertical_search',
			[
				'label' 		=> __( 'Search', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'fv_search_text',
			[
				'label' 	  => __( 'Search Text', 'codesigner' ),
				'type' 		  => Controls_Manager::TEXT,
				'placeholder' => __( 'Type Section title here', 'codesigner' ),
				'default' 	  => 'Search',
				'condition'   => [
                    'filter_vertical_search' => 'yes'
                ],
			]
		);

		$this->add_control(
			'search_box_icon',
			[
				'label' 	=> __( 'Search Icon', 'codesigner' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' => 'eicon-search-bold',
					'library' => 'solid',
				],
				'condition'   => [
                    'filter_vertical_search' => 'yes'
                ],
				'separator'		=> 'before'
			]
		);

		$this->end_controls_section();

		
		/*
		*price_by_show_hide
		*/

		$this->start_controls_section(
			'fv_price_by',
			[
				'label' 		=> __( 'Price', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fv_price_by_show_hide',
			[
				'label'         => __( 'Show Price filter', 'codesigner' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'codesigner' ),
				'label_off'     => __( 'Hide', 'codesigner' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'fv_price_text',
			[
				'label' 	  => __( 'Price Text', 'codesigner' ),
				'type' 		  => Controls_Manager::TEXT,
				'placeholder' => __( 'Type Section title here', 'codesigner' ),
				'default' 	  => 'Price',
				'condition'   => [
                    'fv_price_by_show_hide' => 'yes'
                ],
			]
		);

		$this->end_controls_section();
		
		/*
		*sort_by_show_hide
		*/

		$this->start_controls_section(
			'fv_sort_by',
			[
				'label' 		=> __( 'Sort By', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fv_sort_by_show_hide',
			[
				'label'         => __( 'Show Sort By filter', 'codesigner' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'codesigner' ),
				'label_off'     => __( 'Hide', 'codesigner' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'fv_sort_text',
			[
				'label' 	  => __( 'Sort Text', 'codesigner' ),
				'type' 		  => Controls_Manager::TEXT,
				'rows' 		  => 10,
				'placeholder' => __( 'Type Section title here', 'codesigner' ),
				'default' 	  => 'Sort By',
				'condition'   => [
                    'fv_sort_by_show_hide' => 'yes'
                ],
			]
		);

		$this->add_control(
			'fv_sort_items',
			[
				'label' 		=> __( 'Sort Items', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'multiple' 		=> true,
				'options'		=> wcd_order_options(),
				'default' 		=> [ 'title', 'name', '_price', 'total_sales' ],
				'label_block' 	=> true,
				'condition' 	=> [
                    'fv_sort_by_show_hide' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		/*
		*Order_by_show_hide
		*/

		$this->start_controls_section(
			'fv_order',
			[
				'label' 		=> __( 'Order', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fv_order_show_hide',
			[
				'label'         => __( 'Show order filter', 'codesigner' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'codesigner' ),
				'label_off'     => __( 'Hide', 'codesigner' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'fv_order_text',
			[
				'label' 	  => __( 'Order Text', 'codesigner' ),
				'type' 		  => Controls_Manager::TEXT,
				'rows' 		  => 10,
				'placeholder' => __( 'Type Section title here', 'codesigner' ),
				'default' 	  => 'Order',
				'condition'   => [
                    'fv_order_show_hide' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		/*
		*Button show hide and text
		*/

		$this->start_controls_section(
			'_buttons',
			[
				'label' 		=> __( 'Buttons', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'filter_verticle_clear',
			[
				'label' 		=> __( 'Clear Button', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
                'separator' 		=> 'before',
			]
		);

		$this->add_control(
			'clear_btn_text',
			[
				'label' 		=> __( 'Clear Button Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Clear All', 'codesigner' ),
				'placeholder' 	=> __( 'Type your text here', 'codesigner' ),
				'condition' => [
                    'filter_verticle_clear' => 'yes'
                ],
                'separator' 		=> 'after',
			]
		);

        $this->add_control(
			'filter_verticle_apply',
			[
				'label' 		=> __( 'Apply Button', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner' ),
				'label_off' 	=> __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'apply_btn_text',
			[
				'label' 		=> __( 'Apply Button Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Apply', 'codesigner' ),
				'placeholder' 	=> __( 'Type your text here', 'codesigner' ),
				'condition' => [
                    'filter_verticle_apply' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		/**
		 * Description style Section
		 */
		$this->start_controls_section(
			'fv_header_style',
			[
				'label'			=> __( 'Section Title', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'fv_header_text_align',
			[
				'label' 		=> __( 'Alignment', 'codesigner' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left'	=> [
						'title'	=> __( 'Left', 'codesigner' ),
						'icon'	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'codesigner' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'codesigner' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default' 		=> 'left',
				'toggle' 		=> true,
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-fv-filter-heading' => 'text-align: {{VALUE}}',
				],
				'separator'		=>	'after'
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'filter_verticle_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-fv-filter-heading h3',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_verticle_ypography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-filter-heading h3',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'filter_verticle_border',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '.wl {{WRAPPER}} .wl-fv-filter-heading h3',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'filter_verticle_border_radius',
			[
				'label'         => __( 'Border Radius', 'codesigner' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-fv-filter-heading h3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'filter_verticle_background',
						'label' => __( 'Background', 'codesigner' ),
						'types' => [ 'classic', 'gradient'],
						'selector' => '.wl {{WRAPPER}} .wl-fv-filter-heading',
					]
				);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'filter_verticle_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-filter-heading',
			]
		);

		$this->add_responsive_control(
			'fv_field_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-filter-heading h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'fv_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-filter-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Search Box
		 */
		$this->start_controls_section(
			'filter_vertical_search_box',
			[
				'label'			=> __( 'Search Box', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'filter_vertical_search' => 'yes'
                ],
			]
		);

        $this->add_control(
			'search_box_text_color',
			[
				'label' 	=> __( 'Text Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-fv-filter-search input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'search_box_background',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-fv-filter-search input',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'search_box_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-filter-search input',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 12 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

        $this->add_control(
			'search_box_icon_color',
			[
				'label' 	=> __( 'Icon Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-fv-search-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'search_box_border',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '.wl {{WRAPPER}} .wl-fv-filter-search input',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'search_box_border_radius',
			[
				'label'         => __( 'Border Radius', 'codesigner' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-fv-filter-search input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_box_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-filter-search input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'search_box_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-filter-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Components style Section
		 */
		$this->start_controls_section(
			'fv_component_style',
			[
				'label'			=> __( 'Components', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'filter_component_dropdown_tabs' );

        $this->start_controls_tab(
            'filter_component_dropdown_title',
            [
                'label' => __( 'Dropdown Title', 'codesigner' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'component_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-tab-label, .wl-fv-range-value div',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);


		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'filter_verticle_comp_gradient_color',
                'selector' => '.wl {{WRAPPER}} .wl-fv-tab-label, {{WRAPPER}} .wl-fv-range-value div span',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_component_dropdown_items',
            [
                'label' => __( 'Dropdown Items', 'codesigner' ),
            ]
        );

        $this->add_control(
			'filter_component_item_color',
			[
				'label' 		=> __( 'Text Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-radio-custom-label span' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-fv-checkbox-custom-label span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_component_item_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-radio-custom-label span, .wl-fv-checkbox-custom-label span',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
            'filter_component_check_icon_size',
            [
                'label'     	=> __( 'Check Icon Size', 'codesigner' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-fv-checkbox-custom + .wl-fv-checkbox-custom-label::before, .wl-fv-radio-custom + .wl-fv-radio-custom-label::before' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
        	'fv_label_padding',
        	[
        		'label' 		=> __( 'Padding', 'codesigner' ),
        		'type' 			=> Controls_Manager::DIMENSIONS,
        		'size_units' 	=> [ 'px', '%', 'em' ],
        		'selectors' 	=> [
        			'.wl {{WRAPPER}} .wl-fv-tab-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        		'separator'		=> 'before',
        	]
        );

        $this->add_responsive_control(
        	'fv_label_margin',
        	[
        		'label' 		=> __( 'Margin', 'codesigner' ),
        		'type' 			=> Controls_Manager::DIMENSIONS,
        		'size_units' 	=> [ 'px', '%', 'em' ],
        		'selectors' 	=> [
        			'.wl {{WRAPPER}} .wl-fv-tab-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		/**
		 * Button style Section wl-fv-btn-checkout
		 */
		$this->start_controls_section(
			'filter_horizontal_apply_button',
			[
				'label'			=> __( 'Apply Button', 'codesigner' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'apply_button_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-btn-checkout',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'apply_button_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fv-btn-checkout',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'apply_button_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'apply_button_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'apply_normal_separator',
            [
                'separator' => 'before'
            ]
        );
        $this->start_controls_tab(
            'apply_btn_normal',
            [
                'label'     => __( 'Normal', 'codesigner' ),
            ]
        );

        $this->add_control(
			'apply_button_text_color',
			[
				'label' 	=> __( 'Text Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'apply_button_background',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-fv-btn-checkout',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'apply_button_border',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '.wl {{WRAPPER}} .wl-fv-btn-checkout',				
			]
		);

		$this->add_responsive_control(
			'apply_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'codesigner' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

        $this->start_controls_tab(
            'apply_btn_hover',
            [
                'label'     => __( 'Hover', 'codesigner' ),
            ]
        );

        $this->add_control(
			'apply_button_text_color_hover',
			[
				'label' 	=> __( 'Text Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'apply_button_background_hover',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '.wl {{WRAPPER}} .wl-fv-btn-checkout:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'apply_button_border_hover',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '.wl {{WRAPPER}} .wl-fv-btn-checkout:hover',				
			]
		);

		$this->add_responsive_control(
			'apply_button_border_radius_hover',
			[
				'label'         => __( 'Border Radius', 'codesigner' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-fv-btn-checkout:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        // Translators: 1: Widget name, 2: CoDesigner Pro link.
        echo wp_kses_post( wcd_notice( sprintf( __( 'This beautiful widget, <strong>%1$s</strong> is a premium widget. Please upgrade to <strong>%2$s</strong> or activate your license if you already have upgraded!', 'codesigner' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . esc_url( plugins_url( 'assets/img/screenshot.png', __FILE__ ) ) . "' />";
        }
    }
}