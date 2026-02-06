<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Product_Breadcrumbs extends Widget_Base {

	public $id;
	public $widget;

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
		 * Breadcrumbs
		 */
		$this->start_controls_section(
			'section_content_Breadcrumbs',
			array(
				'label' => __( 'Breadcrumbs', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'breadcrumbs_align',
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
					'.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'breadcrump_indicator_show_hide',
			array(
				'label'        => __( 'Use Custom Separator', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'breadcrump_indicator',
			array(
				'label'     => __( 'Select Separator Icon', 'codesigner' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'eicon-angle-right',
					'library' => 'solid',
				),
				'condition' => array(
					'breadcrump_indicator_show_hide' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Breadcrumbs
		 */
		$this->start_controls_section(
			'_breadcrumbs',
			array(
				'label' => __( 'Breadcrumbs Color', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'breadcrumbs_typographyrs',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
				),
			)
		);

		$this->add_responsive_control(
			'breadcrumbs_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'breadcrumbs_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => 0,
					'left'     => 0,
					'bottom'   => 0,
					'right'    => 0,
					'isLinked' => true,
				),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'breadcrumbs_tabs',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'breadcrumbs_home',
			array(
				'label' => __( 'Home', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'breadcrumbs_home_color',
				'selector' => '.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb a:first-child',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'breadcrumbs_category',
			array(
				'label' => __( 'Categories', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'breadcrumbs_category_color',
				'selector' => '.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb a',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'breadcrumbs_product_name',
			array(
				'label' => __( 'Product', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'breadcrumbs_product_name_color',
				'selector' => '.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*Separator Color
		*/
		$this->start_controls_section(
			'breadcrumbs_Separa',
			array(
				'label' => __( 'Breadcrumbs Separator', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'breadcrumbs_separatot_color',
				'selector' => '.wl {{WRAPPER}} .wl-bc .woocommerce-breadcrumb i',
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( 'yes' == $settings['breadcrump_indicator_show_hide'] ) {
			$breadcrump_indicator = $settings['breadcrump_indicator'];
			add_filter(
				'woocommerce_breadcrumb_defaults',
				function ( $defaults ) use ( $breadcrump_indicator ) {
					$defaults['delimiter'] = ' <i class="' . esc_attr( $breadcrump_indicator['value'] ) . '"></i> ';
					return $defaults;
				}
			);
		}

		?>

		<div class="wl-bc">
			<?php
			if ( function_exists( 'woocommerce_breadcrumb' ) ) {
				woocommerce_breadcrumb();
			}
			?>
		</div>

		<?php

		do_action( 'codesigner_after_main_content', $this );
	}
}
