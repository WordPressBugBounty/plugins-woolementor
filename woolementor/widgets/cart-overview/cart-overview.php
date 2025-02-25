<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Cart_Overview extends Widget_Base {

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
		return array( "codesigner-{$this->id}" );
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
		 * Heading controls
		 */
		$this->start_controls_section(
			'section_heading',
			array(
				'label' => __( 'Sections', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_heading_show_hide',
			array(
				'label'        => __( 'Show/Hide Heading', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'section_heading_text',
			array(
				'label'   => __( 'Heading', 'codesigner' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Cart totals', 'codesigner' ),
			)
		);

		$this->add_control(
			'section_heading_tag',
			array(
				'label'     => __( 'Heading Tag', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'h1' => array(
						'title' => __( 'H1', 'codesigner' ),
						'icon'  => 'eicon-editor-h1',
					),
					'h2' => array(
						'title' => __( 'H2', 'codesigner' ),
						'icon'  => 'eicon-editor-h2',
					),
					'h3' => array(
						'title' => __( 'H3', 'codesigner' ),
						'icon'  => 'eicon-editor-h3',
					),
					'h4' => array(
						'title' => __( 'H4', 'codesigner' ),
						'icon'  => 'eicon-editor-h4',
					),
					'h5' => array(
						'title' => __( 'H5', 'codesigner' ),
						'icon'  => 'eicon-editor-h5',
					),
					'h6' => array(
						'title' => __( 'H6', 'codesigner' ),
						'icon'  => 'eicon-editor-h6',
					),
				),
				'default'   => 'h2',
				'condition' => array(
					'section_heading_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'section_checkout_show_hide',
			array(
				'label'        => __( 'Proceed Button', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'block',
				'default'      => 'block',
				'selectors'    => array(
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'display: {{VALUE}}!important',
				),
				'separator'    => 'before',
			)
		);

		$this->end_controls_section();

		/**
		 * Cart overview section title
		 */
		$this->start_controls_section(
			'cart_table_title_style',
			array(
				'label'     => __( 'Section Title', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_heading_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'cart_table_title_alignment',
			array(
				'label'     => __( 'Title Alignment', 'codesigner' ),
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
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'cart_table_title_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'       => '{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title, {{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'cart_table_title_gradient_color',
				'selector' => '{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title, {{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing',
			)
		);

		$this->end_controls_section();

		/**
		 * Cart Table
		 */
		$this->start_controls_section(
			'style_cart_overview',
			array(
				'label' => __( 'Table', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'style_cart_overview_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-cart-overview table',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'style_cart_overview_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-cart-overview table tr td, {{WRAPPER}} .wl-cart-overview table tr th',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		/**
		 * Table Content controls
		 */
		$this->start_controls_section(
			'section_table_content',
			array(
				'label' => __( 'Table Content', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_alignment',
			array(
				'label'     => __( 'Content Alignment', 'codesigner' ),
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
				'default'   => 'right',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs(
			'table_content_tab',
			array()
		);

		$this->start_controls_tab(
			'table_content_label',
			array(
				'label' => __( 'Label', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'table_content_label_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-cart-overview table tr th',
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
			'table_content_label_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'table_content_label_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'_table_content_label_hover',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Hover', 'codesigner' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'table_content_label_hover_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr:hover th' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'table_content_label_hover_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr:hover th' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_content_value',
			array(
				'label' => __( 'Value', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'table_content_value_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-cart-overview table tr td',
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
			'table_content_value_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'table_content_value_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'_table_content_value_hover',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Hover', 'codesigner' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'table_content_value_hover_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr:hover td' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'table_content_value_hover_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview table tr:hover td' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Checkout Button
		 */
		$this->start_controls_section(
			'checkout_button',
			array(
				'label'     => __( 'Proceed Button', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'section_checkout_show_hide' => 'block',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'checkout_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'    => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_responsive_control(
			'checkout_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'checkout_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'cart_proceed_btn_tab',
			array( 'separator' => 'before' )
		);

		$this->start_controls_tab(
			'cart_proceed_btn',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'checkout_button_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_button_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'checkout_button_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'checkout_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_proceed_btn_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'checkout_button_color_hover',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_button_bg_hover',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button:hover' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'checkout_button_border_hover',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'checkout_button_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->render_editing_attributes();

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		if ( is_null( WC()->cart ) ) {
			include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
			include_once WC_ABSPATH . 'includes/class-wc-cart.php';
			wc_load_cart();
		}

		if ( ! empty( WC()->cart->get_cart() ) ) :

			do_action( 'woocommerce_before_cart_collaterals' ); ?>
			<div class="wl-cart-overview">
				<?php
				include plugin_dir_path( __FILE__ ) . '/assets/templates/cart-totals.php';
				return;
				?>
			</div>
			<?php
			do_action( 'woocommerce_after_cart' );

		elseif ( ! did_action( 'woocommerce_cart_is_empty' ) ) :
				do_action( 'woocommerce_cart_is_empty' );
		endif;

		do_action( 'codesigner_after_main_content', $this );
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'section_heading_text', 'basic' );
	}
}