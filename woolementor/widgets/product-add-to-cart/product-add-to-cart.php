<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Product_Add_To_Cart extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), '1.1' );
	}

	public function get_script_depends() {
		return array( 'fancybox' );
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

		/**
		 * Cart Content
		 */
		$this->start_controls_section(
			'add_to_cart_section',
			array(
				'label' => __( 'Add to Cart', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'add_to_cart_text',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Add to Cart', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
			)
		);

		$this->add_control(
			'_product_type',
			array(
				'label'         => __( 'Product Type', 'codesigner' ),
				'type'          => Controls_Manager::HIDDEN,
				'show_external' => false,
				'default'       => $this->wcd_get_product_type(),
			)
		);

		$this->add_control(
			'cd_hide_default_vs_table',
			array(
				'label'        => esc_html__( 'Hide Default Variation Table', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'codesigner' ),
				'label_off'    => esc_html__( 'Show', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();

		if ( $this->is_wl_single() ) :
			/**
			 * Preview Mode
			 */
			$this->start_controls_section(
				'_preview_mode_section',
				array(
					'label' => __( 'Preview Mode', 'codesigner' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'_preview_important_note',
				array(
					'label'           => __( '', 'codesigner' ),
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Choose a product type to show preview for. Applicable for the edit and preview modes only. The live mode will show the appropriate components. (e.g. Quantity input field for Simple products, Variations\' selection for Variable products etc)', 'codesigner' ),
					'content_classes' => 'elementor-alert _preview_important_note',
				)
			);

			$this->add_control(
				'_preview_type',
				array(
					'label'   => __( 'Show Preview For', 'codesigner' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'simple'   => __( 'Simple', 'codesigner' ),
						'variable' => __( 'Variable', 'codesigner' ),
						'grouped'  => __( 'Grouped', 'codesigner' ),
					),
					'default' => 'simple',
				)
			);

			$this->end_controls_section();

		endif;

		/**
		 * add to cart button
		 */
		$this->start_controls_section(
			'add_to_cart_style',
			array(
				'label' => __( 'Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'add_to_cart_typographyrs',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_responsive_control(
			'add_to_cart_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => 15,
					'right'  => 15,
					'bottom' => 15,
					'left'   => 15,
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'add_to_cart_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'add_to_cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'add_to_cart_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			)
		);

		$this->start_controls_tabs(
			'add_to_cart_button',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'add_to_cart_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'add_to_cart_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'add_to_cart_bg',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'add_to_cart_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'add_to_cart_hover_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'add_to_cart_hover_bg',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'add_to_cart_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			)
		);

		$this->add_control(
			'add_to_cart_hover_transition',
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
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * quantity Input
		 */
		$this->start_controls_section(
			'qty_input',
			array(
				'label'     => __( 'Quantity Input', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'_product_type!' => 'external',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'qty_input_typographyrs',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-atc-button-area .quantity input,
								.wl {{WRAPPER}} .wl-atc-button-area .quantity input.qty',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_control(
			'qty_input_align',
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
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'qty_input_width',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 110,
				),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity' => 'width: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'width: 100%',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'qty_input_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .quantity input',
			)
		);

		$this->add_responsive_control(
			'qty_input_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'qty_input_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'qty_input_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => 17,
					'right'    => 17,
					'bottom'   => 17,
					'left'     => 17,
					'isLinked' => true,
				),
			)
		);

		$this->end_controls_section();

		do_action( 'cd_after_add_to_cart_style', $this );
		/**
		 * Table Design
		 */
		$this->start_controls_section(
			'table_design',
			array(
				'label'      => __( 'Table Design', 'codesigner' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => '_product_type',
							'operator' => '==',
							'value'    => 'variable',
						),
						array(
							'name'     => '_product_type',
							'operator' => '==',
							'value'    => 'grouped',
						),
						array(
							'name'     => '_preview_type',
							'operator' => '==',
							'value'    => 'variable',
						),
						array(
							'name'     => '_preview_type',
							'operator' => '==',
							'value'    => 'grouped',
						),
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'table_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table',
			)
		);

		$this->end_controls_section();

		/**
		 * Table row Design
		 */
		$this->start_controls_section(
			'table_row_design',
			array(
				'label'      => __( 'Table Row Design', 'codesigner' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => '_product_type',
							'operator' => '==',
							'value'    => 'variable',
						),
						array(
							'name'     => '_product_type',
							'operator' => '==',
							'value'    => 'grouped',
						),
						array(
							'name'     => '_preview_type',
							'operator' => '==',
							'value'    => 'variable',
						),
						array(
							'name'     => '_preview_type',
							'operator' => '==',
							'value'    => 'grouped',
						),
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'table_content',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr td',
			)
		);

		$this->add_control(
			'table_content_align',
			array(
				'label'     => __( 'Vertical Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'top'    => array(
						'title' => __( 'Top', 'codesigner' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => __( 'Middle', 'codesigner' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __( 'Bottom', 'codesigner' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'   => 'top',
				'toggle'    => true,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area table tr td' => 'vertical-align: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'table_row_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr td',
			)
		);

		$this->start_controls_tabs(
			'table_content_design',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'table_row_odd',
			array(
				'label' => __( 'ODD Row', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_row_background_odd',
				'label'    => __( 'Background 2', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td',
			)
		);

		$this->add_control(
			'table_row_text_odd',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td a' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_row_even',
			array(
				'label' => __( 'Even Row', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_row_background_even',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td',
			)
		);

		$this->add_control(
			'table_row_text_even',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td a' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_row_hover',
			array(
				'label' => __( 'Hover Row', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_row_background_hover',
				'label'    => __( 'Background 2', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td',
			)
		);

		$this->add_control(
			'table_row_text_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td a' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function is_wl_single() {
		if ( ! isset( $_GET['post'] ) || get_post_type( codesigner_sanitize_number( $_GET['post'] ) ) != 'elementor_library' ) {
			return false;
		}

		$template_type = get_post_meta( codesigner_sanitize_number( $_GET['post'] ), '_elementor_template_type', true );

		if ( $template_type == 'wl-single' ) {
			return true;
		}

		return false;
	}

	protected function wcd_get_product_type() {

		$product_id = get_the_ID();

		if ( ! function_exists( 'wc_get_product' ) ) {
			return false;
		}

		$product = wc_get_product( $product_id );

		if ( $product ) {
			return $product->get_type();
		}

		return false;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->render_editing_attributes();

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		$product_id = get_the_ID();
		$product    = wc_get_product( $product_id );

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$type        = isset( $settings['_preview_type'] ) ? $settings['_preview_type'] : '';
			$product_id  = wcd_get_product_id( $type );
			$product     = wc_get_product( $product_id );
			$the_product = $product;
			global $product;

			if ( is_null( $product ) ) {
				$product = $the_product;
			}
		}

		if ( ! $product ) {
			esc_html_e( 'This is not a product or an invalid ID is provided.', 'codesigner' );
			return;
		}

		if ( wcd_is_live_mode() ) {
			wc_print_notices();
		}

		$product_type = $product->get_type();
		$button_text  = $settings['add_to_cart_text'];
		$product_url  = get_post_meta( $product_id, '_product_url', true );

		?>
		<div class="wl-atc-button-area">
			<?php
			$template = 'simple.php';

			if ( 'external' == $product_type ) {
				$template = 'external.php';
			} elseif ( 'grouped' == $product_type ) {
				$post             = get_post( $product_id );
				$grouped_products = $product->get_children();
				$template         = 'grouped.php';
			} elseif ( 'simple' == $product_type || 'subscription' == $product_type ) {
				$template = 'simple.php';
			} elseif ( 'variable' == $product_type || 'variable-subscription' == $product_type ) {
				if ( $settings['cd_hide_default_vs_table'] ) {
					$template = 'simple.php';
				} else {
					$template = 'variable.php';
				}
			}

			include __DIR__ . "/templates/{$template}";
			?>
		</div>

		<?php

		do_action( 'codesigner_after_main_content', $this );
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'add_to_cart_text', 'basic' );
		$this->add_render_attribute( 'add_to_cart_text', 'class', 'single_add_to_cart_button button al' );
	}
}
