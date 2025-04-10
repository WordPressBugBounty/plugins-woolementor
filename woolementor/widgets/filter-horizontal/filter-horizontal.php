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

class Filter_Horizontal extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_script( "codesigner-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), array( 'jquery' ), '1.1', true );

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), '1.1' );
	}

	public function get_script_depends() {
		return array( "codesigner-{$this->id}", 'jquery-ui' );
	}

	public function get_style_depends() {
		return array( "codesigner-{$this->id}" );
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
			'filter_horizontal_general',
			array(
				'label' => __( 'General', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'filter_horizontal_switcher',
			array(
				'label'        => __( 'Filter', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'filter_horizontal_title',
			array(
				'label'       => __( 'Filter Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Filter', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'filter_horizontal_alignment',
			array(
				'label'          => __( 'Button Alignment', 'codesigner' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => array(
					'start'    => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'   => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'        => 'flex-end',
				'tablet_default' => 'flex-end',
				'mobile_default' => 'center',
				'toggle'         => true,
				'selectors'      => array(
					'.wl {{WRAPPER}} .wl-fh-flter-action-area' => 'justify-content: {{VALUE}}',
				),
				'separator'      => 'after',
			)
		);

		$this->add_control(
			'form_action_show',
			array(
				'label'        => __( 'Custom Form Action', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'form_action',
			array(
				'label'       => __( 'Action Url', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => get_the_permalink(),
				'placeholder' => 'http://example.com/',
				'label_block' => true,
				'condition'   => array(
					'form_action_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_price',
			array(
				'label'        => __( 'Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'fh_price_title',
			array(
				'label'       => __( 'Price Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Price', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_price' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_sort',
			array(
				'label'        => __( 'Sort', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'separator'    => 'before',
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'fh_sort_title',
			array(
				'label'       => __( 'Sort Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Sort', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_sort' => 'yes',
				),
			)
		);

		$this->add_control(
			'fh_sort_items',
			array(
				'label'       => __( 'Sort Items', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => wcd_order_options(),
				'default'     => array( 'title', 'name', '_price', 'total_sales' ),
				'label_block' => true,
				'condition'   => array(
					'filter_horizontal_sort' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_order',
			array(
				'label'        => __( 'Order', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'separator'    => 'before',
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'fh_order_title',
			array(
				'label'       => __( 'Order Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Order', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_order' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_search',
			array(
				'label'        => __( 'Search', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'separator'    => 'before',
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'fh_search_title',
			array(
				'label'       => __( 'Search Title', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Search', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
				'separator'   => 'after',
				'condition'   => array(
					'filter_horizontal_search' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_clear',
			array(
				'label'        => __( 'Clear Button', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'clear_btn_text',
			array(
				'label'       => __( 'Clear Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Clear All', 'codesigner' ),
				'placeholder' => __( 'Type your text here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_clear' => 'yes',
				),
				'separator'   => 'after',
			)
		);

		$this->add_control(
			'filter_horizontal_apply',
			array(
				'label'        => __( 'Apply Button', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'apply_btn_text',
			array(
				'label'       => __( 'Apply Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Apply', 'codesigner' ),
				'placeholder' => __( 'Type your text here', 'codesigner' ),
				'condition'   => array(
					'filter_horizontal_apply' => 'yes',
				),
			)
		);

		$this->add_control(
			'filter_horizontal_taxonomies',
			array(
				'label'          => __( 'Filter Items', 'codesigner' ),
				'type'           => Controls_Manager::SELECT2,
				'options'        => wcd_get_taxonomies(),
				'separator'      => 'before',
				'multiple'       => true,
				'style_transfer' => true,
				'label_block'    => true,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'min_price',
			array(
				'label'   => __( 'Min Price', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => floor( wcd_price_limit( 'min' ) ),
			)
		);

		$repeater->add_control(
			'max_price',
			array(
				'label'   => __( 'Max Price', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => floor( wcd_price_limit( 'max' ) ),
			)
		);

		$this->add_control(
			'price_list',
			array(
				'label'       => __( 'Price Range', 'codesigner' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'separator'   => 'before',
				'default'     => array(
					array(
						'min_price' => floor( wcd_price_limit( 'min' ) ),
						'max_price' => floor( wcd_price_limit( 'max' ) ),
					),
				),
				'title_field' => __( 'Price ( {{{ min_price }}} - {{{ max_price }}} )', 'codesigner' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'fv_ajax_filter',
			array(
				'label' => __( 'AJAX Filter', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'fv_enable_ajax_filter',
			array(
				'label'        => __( 'Enable', 'codesigner-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'codesigner-pro' ),
				'label_off'    => __( 'No', 'codesigner-pro' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'fv_ajax_filter_widget',
			array(
				'label'       => __( 'Shop Widget', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => false,
				'options'     => wcd_get_shop_options(),
				'label_block' => true,
				'default'     => '',
				'description' => __( 'What shop widget are you using with this filter?', 'codesigner' ),
				'condition'   => array(
					'fv_enable_ajax_filter' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Description style Section
		 */
		$this->start_controls_section(
			'filter_horizontal_header_style',
			array(
				'label' => __( 'Section Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'filter_horizontal_ypography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-filter-heading h3',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'filter_horizontal_gradient_color',
				'selector' => '.wl {{WRAPPER}} .wl-fh-filter-heading h3',
			)
		);

		$this->end_controls_section();

		/**
		 * Search Box
		 */
		$this->start_controls_section(
			'filter_horizontal_search_box',
			array(
				'label'     => __( 'Search Box', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'filter_horizontal_apply' => 'yes',
				),
			)
		);

		$this->add_control(
			'search_box_text_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-filter-search input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'search_box_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-filter-search input',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'search_box_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-filter-search input',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 12 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'search_box_icon',
			array(
				'label'     => __( 'Search Icon', 'text-domain' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'eicon-search-bold',
					'library' => 'solid',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'search_box_icon_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-search-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'search_box_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .wl-fh-filter-search input',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'search_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-filter-search input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'search_box_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-filter-search input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'search_box_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-filter-search input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Filter
		 */
		$this->start_controls_section(
			'filter_horizontal_style_section',
			array(
				'label' => __( 'Filter', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'filter_horizontal_dropdown_tabs' );

		$this->start_controls_tab(
			'filter_horizontal_dropdown_title',
			array(
				'label' => __( 'Dropdown Title', 'codesigner' ),
			)
		);

		$this->add_control(
			'filter_horizontal_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-tab-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'filter_horizontal_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-tab-label',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_horizontal_dropdown_items',
			array(
				'label' => __( 'Dropdown Items', 'codesigner' ),
			)
		);

		$this->add_control(
			'filter_horizontal_item_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-radio-custom-label span' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-fh-checkbox-custom-label span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'filter_horizontal_item_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-radio-custom-label span, .wl-fh-checkbox-custom-label span',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_responsive_control(
			'filter_horizontal_check_icon_size',
			array(
				'label'      => __( 'Check Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-checkbox-custom + .wl-fh-checkbox-custom-label::before, .wl-fh-radio-custom + .wl-fh-radio-custom-label::before' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrow_icon_size',
			array(
				'label'       => __( 'Icon Size', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'selectors'   => array(
					'.wl {{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'render_type' => 'ui',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'icon_offset_toggle',
			array(
				'label'        => __( 'Icon Position', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'icon_offset_left',
			array(
				'label'       => __( 'Offset Left', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'selectors'   => array(
					'.wl {{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'right: {{SIZE}}{{UNIT}}',
				),
				'range'       => array(
					'px' => array(
						'min' => -500,
						'max' => 500,
					),
				),
				'condition'   => array(
					'icon_offset_toggle' => 'yes',
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'icon_offset_top',
			array(
				'label'       => __( 'Offset Top', 'codesigner' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'selectors'   => array(
					'.wl {{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'top: {{SIZE}}{{UNIT}}',
				),
				'range'       => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'condition'   => array(
					'icon_offset_toggle' => 'yes',
				),
				'render_type' => 'ui',
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'filter_horizontal_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .wl-fh-single-filter-wrap',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'filter_horizontal_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-single-filter-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'filter_horizontal_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-tab-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'filter_horizontal_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-single-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Apply Button
		 */
		$this->start_controls_section(
			'filter_horizontal_apply_button',
			array(
				'label'     => __( 'Apply Button', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'filter_horizontal_apply' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'apply_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-btn-checkout',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'apply_button_box_shadow',
				'label'     => __( 'Box Shadow', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .wl-fh-btn-checkout',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'apply_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'apply_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'apply_normal_separator',
			array(
				'separator' => 'before',
			)
		);
		$this->start_controls_tab(
			'apply_btn_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'apply_button_text_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'apply_button_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-btn-checkout',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'apply_button_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-btn-checkout',
			)
		);

		$this->add_responsive_control(
			'apply_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'apply_btn_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'apply_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'apply_button_background_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-btn-checkout:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'apply_button_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-btn-checkout:hover',
			)
		);

		$this->add_responsive_control(
			'apply_button_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-btn-checkout:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Clear All Button
		 */
		$this->start_controls_section(
			'filter_horizontal_clear_all_button',
			array(
				'label'     => __( 'Clear All Button', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'filter_horizontal_clear' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'clear_all_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-fh-clear-btn',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'clear_all_button_box_shadow',
				'label'     => __( 'Box Shadow', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} .wl-fh-clear-btn',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'clear_all_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'clear_all_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'clear_all_normal_separator',
			array(
				'separator' => 'before',
			)
		);
		$this->start_controls_tab(
			'clear_all_btn_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'clear_all_button_text_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'clear_all_button_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-clear-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'clear_all_button_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-clear-btn',
			)
		);

		$this->add_responsive_control(
			'clear_all_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'clear_all_btn_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'clear_all_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'clear_all_button_background_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-clear-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'clear_all_button_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-fh-clear-btn:hover',
			)
		);

		$this->add_responsive_control(
			'clear_all_button_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-fh-clear-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		extract( $settings );
		$section_id = $this->get_id();
		$action     = $form_action_show == 'yes' ? $form_action : get_the_permalink();

		$this->render_editing_attributes();

		$form_id = '';
		if ( wcd_is_pro_activated() ) {
			if ( 'yes' == $fv_enable_ajax_filter ) {
				$form_id = 'wl-ajax-filter-form';
			}
		}
		?>
		
		<form class="<?php echo esc_attr( $form_id ); ?>" method="get" action="<?php echo esc_url( $action ); ?>">

			<?php
			if ( wcd_is_pro_activated() ) {
				if ( 'yes' == $fv_enable_ajax_filter ) {
					?>
						<input type="hidden" name="action" value="ajax-filter">
						<input type="hidden" name="widget_id" value="<?php echo esc_attr( $fv_ajax_filter_widget ); ?>">
					<?php
					wp_nonce_field( 'codesigner-shop' );
				}
			}
			?>

			<div class="wl-fh-filters-area wl-fh-hr">
				<div class="wl-fh-filter-heading-area">
					<div class="wl-fh-filter-heading">

						<?php
						printf(
							'<h3 %s>%s</h3>',
							wp_kses_post( $this->get_render_attribute_string( 'filter_horizontal_title' ) ),
							esc_html( $filter_horizontal_title )
						);
						?>
						
					</div>
					<div class="wl-fh-flter-action-area">
						<?php if ( 'yes' == $filter_horizontal_clear ) : ?>
							<div class="wl-fh-flter-action-left">

								<?php
								if ( wcd_is_pro_activated() && 'yes' == $fv_enable_ajax_filter ) {
									printf(
										'<button type="submit" class="wl-fh-clear-btn">%s</button>',
										esc_html( $clear_btn_text )
									);
								} else {
									global $wp;
									printf(
										'<a %s href="%s" class="wl-fh-clear-btn">%s</a>',
										wp_kses_post( $this->get_render_attribute_string( 'clear_btn_text' ) ),
										esc_url( home_url( $wp->request ) ),
										esc_html( $clear_btn_text )
									);
								}
								?>

							</div>
							<?php
						endif;

						if ( 'yes' == $filter_horizontal_apply ) :
							?>
							<div class="wl-fh-flter-action-right">
								
								<?php
								printf(
									'<button %s type="submit">%s</button>',
									wp_kses_post( $this->get_render_attribute_string( 'apply_btn_text' ) ),
									esc_html( $apply_btn_text )
								);
								?>

							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="wl-fh-filters">
					<div class="wl-fh-filters-inner">
						<?php if ( 'yes' == $filter_horizontal_price ) : ?>
							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo esc_attr( $section_id ); ?>"><?php echo esc_html( $fh_price_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>">
										<?php
										foreach ( $price_list as $key => $price ) :
											if ( isset( $_GET['filter']['min_price'] ) && $_GET['filter']['min_price'] != '' ) {
												$checked = checked( $price['min_price'], $_GET['filter']['min_price'], false );
											} else {
												$checked = '';
											}
											?>
											<div>
												<input id="<?php echo esc_attr( $price['_id'] ); ?>" 
												data-min_price="<?php echo esc_attr( $price['min_price'] ); ?>"
												data-max_price="<?php echo esc_attr( $price['max_price'] ); ?>"
												class="wl-fh-radio-custom wl-fh-price-range" 
												name="filter[price]" type="radio" <?php echo esc_attr( $checked ); ?> >
												<label for="<?php echo esc_attr( $price['_id'] ); ?>" class="wl-fh-radio-custom-label">
													<span><?php echo esc_html( $price['min_price'] ); ?> - <?php echo esc_html( $price['max_price'] ); ?></span>
												</label>
											</div>
										<?php endforeach ?>
										<div class="">
											<?php
											if ( isset( $_GET['filter']['min_price'] ) && $_GET['filter']['min_price'] != '' && isset( $_GET['filter']['max_price'] ) && $_GET['filter']['max_price'] != '' ) {
												$min_price = codesigner_sanitize_number( $_GET['filter']['min_price'], 'float' );
												$max_price = codesigner_sanitize_number( $_GET['filter']['max_price'], 'float' );
											} else {
												$min_price = '';
												$max_price = '';
											}
											?>
											<input class="wl-fh-min_price" type="hidden" name="filter[min_price]" value="<?php echo esc_attr( $min_price ); ?>">
											<input class="wl-fh-max_price" type="hidden" name="filter[max_price]" value="<?php echo esc_attr( $max_price ); ?>">
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' == $filter_horizontal_sort ) : ?>

							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo esc_attr( $section_id ); ?>"><?php echo esc_html( $fh_sort_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>">
										<?php
										$sort_options = wcd_order_options();
										foreach ( $sort_options as $key => $sort_option ) :
											if ( in_array( $key, $fh_sort_items ) ) {
												if ( isset( $_GET['filter']['orderby'] ) ) {
													$checked = checked( $key, $_GET['filter']['orderby'], false );
												} else {
													$checked = '';
												}
												?>
												<div>
													<input id="<?php echo esc_attr( $key ); ?>" 
													class="wl-fh-radio-custom" 
													name="filter[orderby]" type="radio" 
													value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $checked ); ?>>
													<label for="<?php echo esc_attr( $key ); ?>" class="wl-fh-radio-custom-label">
														<span><?php echo esc_html( $sort_option ); ?></span>
													</label>
												</div>
										<?php } endforeach; ?>

									</div>
								</div>
							</div>
							<?php
						endif;

						if ( 'yes' == $filter_horizontal_order ) :
							?>

							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo esc_attr( $section_id ); ?>"><?php echo esc_html( $fh_order_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>">
										<?php
										if ( ! empty( $_GET['filter']['order'] ) ) {
											$checked = sanitize_text_field( $_GET['filter']['order'] );

											if ( 'ASC' == $checked ) {
												$asc  = 'checked';
												$desc = '';
											} else {
												$desc = 'checked';
												$asc  = '';
											}
										} else {
											$asc  = '';
											$desc = '';
										}
										?>
										<div>
											<input id="order_asc" class="wl-fh-radio-custom" 
											name="filter[order]" type="radio" <?php echo esc_attr( $asc ); ?> 
											value="<?php esc_html_e( 'ASC', 'codesigner' ); ?>">
											<label for="order_asc" class="wl-fh-radio-custom-label">
												<span><?php esc_html_e( 'ASC', 'codesigner' ); ?></span>
											</label>
										</div>
										<div>
											<input id="order_desc" class="wl-fh-radio-custom" 
											name="filter[order]" type="radio" <?php echo esc_attr( $desc ); ?> 
											value="<?php esc_html_e( 'DESC', 'codesigner' ); ?>">
											<label for="order_desc" class="wl-fh-radio-custom-label">
												<span><?php esc_html_e( 'DESC', 'codesigner' ); ?></span>
											</label>
										</div>

									</div>
								</div>
							</div>
							<?php
						endif;

						if ( ! empty( $filter_horizontal_taxonomies ) ) :
							?>
							<?php
							foreach ( $filter_horizontal_taxonomies as $taxonomies ) :
								$taxonomy = get_taxonomy( $taxonomies );
								?>

								<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>">
									<div class="wl-fh-single-filter-wrap">
										<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo esc_attr( $section_id ); ?>"><?php echo esc_html( $taxonomy->labels->singular_name ); ?></div>
										<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>"> 
											<?php
											$terms = get_terms( $taxonomies );
											$i     = 0;
											foreach ( $terms as $term ) :
												$checked = '';
												if ( isset( $_GET['filter']['taxonomies'][ $taxonomy->name ] ) && in_array( $term->slug, $_GET['filter']['taxonomies'][ $taxonomy->name ] ) ) {
													$checked = 'checked';
												}

												?>
																								<div>
													<input id="<?php echo esc_attr( $taxonomies . '_' . $term->slug ); ?>" 
													class="wl-fh-checkbox-custom" 
													name="filter[taxonomies][<?php echo esc_attr( $taxonomy->name ); ?>][<?php echo esc_attr( $i ); ?>]" 
													type="checkbox" <?php echo esc_attr( $checked ); ?> 
													value="<?php echo esc_attr( $term->slug ); ?>" >
													<label for="<?php echo esc_attr( $taxonomies . '_' . $term->slug ); ?>" class="wl-fh-checkbox-custom-label">
														<span><?php echo esc_html( $term->name ); ?></span>
													</label>
												</div>
												<?php
												++$i;
endforeach;
											?>

										</div>
									</div>
								</div>
								<?php
							endforeach;
						endif;
						?>
					</div>

					<?php if ( 'yes' == $filter_horizontal_search ) : ?>
						<div class="wl-fh-single-filter-search">
							<div class="wl-fh-filter-search">
								<?php
								$search = isset( $_GET['filter']['q'] ) ? sanitize_text_field( $_GET['filter']['q'] ) : '';
								?>
								<input type="search" name="filter[q]" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php echo esc_html( $fh_search_title ); ?>">
								<button class="wl-fh-search-button"><i class="<?php echo esc_attr( $search_box_icon['value'] ); ?>"></i></button>
							</div>
						</div>
					<?php endif; ?>  

				</div>
			</form>

		<?php

		do_action( 'codesigner_after_main_content', $this );

		/**
		 * Load Script
		 */
		$this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'filter_horizontal_title', 'basic' );
		$this->add_inline_editing_attributes( 'clear_btn_text', 'basic' );

		$this->add_inline_editing_attributes( 'apply_btn_text', 'basic' );
		$this->add_render_attribute( 'apply_btn_text', 'class', 'wl-fh-btn-checkout' );
		$this->add_render_attribute( 'clear_btn_text', 'class', 'wl-fh-clear-btn' );
	}

	protected function render_script() {
		$settings = $this->get_settings_for_display();
		extract( $settings );
		$section_id = $this->get_raw_data()['id'];
		?>
		
		<script>
			jQuery(function($){ 
				var Accordion = function(el, multiple) {
					this.el = el || {};
					this.multiple = multiple || false;
	 
					var links = this.el.find('.wl-fh-item-<?php echo esc_attr( $section_id ); ?>');
					links.on('click', {
							el: this.el,
							multiple: this.multiple
					}, this.dropdown)
				}
		 
				Accordion.prototype.dropdown = function(e) {
					var $el = e.data.el;
					$this = $(this),
					$next = $this.next();
	 
					$next.slideToggle();
					$this.parent().toggleClass('open');
	 
					if (!e.data.multiple) {
							$el.find('.wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>').not($next).slideUp().parent().removeClass('open');
					};
				}
				var accordion = new Accordion($('.wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>'), false);
		 
				/*close all when click outside*/
				$(document).on('click', function (event) {
					if (!$(event.target).closest('.wl-fh-single-filter-<?php echo esc_attr( $section_id ); ?>').length) {
					$this.parent().removeClass('open');
					$('.wl-fh-item-data-<?php echo esc_attr( $section_id ); ?>').slideUp();
					}
				});

			});
				</script> 
		<?php
	}
}