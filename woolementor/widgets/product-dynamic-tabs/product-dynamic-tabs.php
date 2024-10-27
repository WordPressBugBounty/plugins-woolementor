<?php
namespace Codexpert\CoDesigner_Pro;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Product_Dynamic_Tabs extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id 		= wcd_get_widget_id( __CLASS__ );
	    $this->widget 	= wcd_get_widget( $this->id );
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

		// tabs list
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Tabs Manager', 'codesigner' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$_tabs = $this->default_tabs();
		$default_tabs = [];
		if ( empty( $_tabs ) ) {
			$default_tabs[] = [
				'tab_title' => __( 'Tab One', 'codesigner' ),
				'priority' 	=> 40,
			];
			$default_tabs[] = [
				'tab_title' => __( 'Tab Two', 'codesigner' ),
				'priority' 	=> 50,
			];
		}else{
			foreach( $_tabs as $key => $tab ){
				$default_tabs[] = [
					'tab_id' 	=> $key,
					'tab_title' => $tab['title'],
					'priority' 	=> $tab['priority'],
				];
			}
		}
		
		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title', [
				'label' => __( 'Tab Title', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab #1' , 'codesigner' ),
			]
		);

		$repeater->add_control(
			'tab_id', [
				'label' => __( 'Tab ID', 'codesigner' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'tab_' . wp_rand(),
			]
		);

		$repeater->add_control(
			'priority', [
				'label' => __( 'Priority', 'codesigner' ),
				'type' 	=> Controls_Manager::NUMBER,
				'default' => 50
			]
		);

		$repeater->add_control(
			'content_type', [
				'label' => __( 'Content Type', 'codesigner' ),
				'type' 	=> Controls_Manager::SELECT,
				'options' => [
					'plain_text' 	=> __( 'Plain Text', 'codesigner' ),
					'template' 		=> __( 'Template', 'codesigner' ),
				],
				'default' => 'plain_text',
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' => __( 'Tab Content', 'codesigner' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.' , 'codesigner' ),
				'condition' => [
					'content_type' => 'plain_text'
				]
			]
		);

		$repeater->add_control(
			'tab_template',
			[
				'label' 		=> __( 'Select a Template', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_template_list( 'section' ),
				'condition' 	=> [
                    'content_type' => 'template'
                ],
                'description'	=> __( 'This is a list of section type template. Select a template to show as tab content', 'codesigner' ),
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' => __( 'Product Tabs', 'codesigner' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_tabs,
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_tabs_style',
			[
				'label' => __( 'Tabs', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab( 'normal_tabs_style',
			[
				'label' => __( 'Normal', 'codesigner' ),
			]
		);

		$this->add_control(
			'tab_text_color',
			[
				'label' => __( 'Text Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_bg_color',
			[
				'label' => __( 'Background Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tabs_border_color',
			[
				'label' => __( 'Border Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-color: {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs::before' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'active_tabs_style',
			[
				'label' => __( 'Active', 'codesigner' ),
			]
		);

		$this->add_control(
			'default_design',
			[
				'label' => __( 'View', 'codesigner' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional','selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-bottom: none;',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-bottom: none;',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li::before' => 'border-bottom: none;',
					'.wl {{WRAPPER}} div.product .woocommerce-tabs ul.wc-tabs li::after,
					.wl {{WRAPPER}} div.product .woocommerce-tabs ul.wc-tabs li::before' => 'border-bottom: none;border-width:0;box-shadow:none;',
				],
			]
		);

		$this->add_control(
			'active_tab_text_color',
			[
				'label' => __( 'Text Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_tab_bg_color',
			[
				'label' => __( 'Background Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'background: {{VALUE}}; border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_tabs_border_color',
			[
				'label' => __( 'Border Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li:not(.active)' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'separator_tabs_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'tab_border_radius',
			[
				'label' => __( 'Border Radius', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_panel_style',
			[
				'label' => __( 'Panel', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-Tabs-panel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_panel_heading_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'codesigner' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_heading_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'panel_box_shadow',
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
			]
		);

		$this->end_controls_section();
	}

	protected function default_tabs() {

		$_tabs 		= apply_filters( 'woocommerce_default_product_tabs', array() );

		if ( isset( $_tabs['description'] ) ) {
			unset( $_tabs['description'] );
		}

		return $_tabs;
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        // Translators: 1: Widget title, 2: Link to CoDesigner Pro.
        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%1$s</strong> is a premium widget. Please upgrade to <strong>%2$s</strong> or activate your license if you already have upgraded!', 'codesigner' ), esc_html( $this->get_title() ), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}

