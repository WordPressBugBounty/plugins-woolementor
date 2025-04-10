<?php
namespace codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class Product_Variations extends Widget_Base {

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
		 * Item Manager
		 */
		$this->start_controls_section(
			'_variation_items',
			array(
				'label' => __( 'Show Items', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'content_source',
			array(
				'label'       => __( 'Content Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'current_product' => __( 'Current Product', 'codesigner' ),
					'custom'          => __( 'Custom', 'codesigner' ),
				),
				'default'     => 'current_product',
				'label_block' => true,
			)
		);

		$this->add_control(
			'main_product_id',
			array(
				'label'       => __( 'Product ID', 'codesigner' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
				'description' => __( 'Input the base product ID', 'codesigner' ),
				'separator'   => 'after',
				'condition'   => array(
					'content_source' => 'custom',
				),
			)
		);

		$this->add_control(
			'variation_desc_show_hide',
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
			'product_desc_words_count',
			array(
				'label'     => __( 'Words Count', 'codesigner' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'separator' => 'after',
				'condition' => array(
					'variation_desc_show_hide' => 'yes',
				),
			)
		);

		$this->add_control(
			'variation_attr_show_hide',
			array(
				'label'        => __( 'Show Attributes', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'variation_qty_show_hide',
			array(
				'label'        => __( 'Show Quantity field', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'variation_price_show_hide',
			array(
				'label'        => __( 'Show Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'variation_old_price_show_hide',
			array(
				'label'        => __( 'Show Sale Price', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'your-plugin' ),
				'label_off'    => __( 'Hide', 'your-plugin' ),
				'return_value' => 'block',
				'default'      => 'block',
				'separator'    => 'after',
				'condition'    => array(
					'variation_price_show_hide' => 'yes',
				),
				'selectors'    => array(
					'{{WRAPPER}} .wl-pl-item-total span del' => 'display: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Cart Button Text
		 */
		$this->start_controls_section(
			'_cart_button',
			array(
				'label' => __( 'Cart Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'atc_btn_text',
			array(
				'label'   => __( 'Button Text', 'codesigner' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Add to Cart', 'codesigner' ),
			)
		);

		$this->end_controls_section();

		/**
		 * card Style
		 */
		$this->start_controls_section(
			'card_style',
			array(
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-pricelist-single',
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pl-pricelist-single ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'Border Types' );

		$this->start_controls_tab(
			'card_regular_border',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pl-pricelist-single',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_checked_border',
			array(
				'label' => __( 'Checkd', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border_checked',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pl-pricelist-single.wl-pl-checked',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'card_Check_box',
			array(
				'label' => __( 'Checkbox', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_checkbox_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_checkbox_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_checkbox_border',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_checkbox_border_color',
			array(
				'label'     => __( 'Border Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'card_checkbox_bg_color',
			array(
				'label'     => __( 'Checked Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .checkbox-custom:checked + .wl-pl-checkbox-label::before' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'card_checkbox_color',
			array(
				'label'     => __( 'Checked Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .checkbox-custom:checked + .wl-pl-checkbox-label::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * card title Style
		 */
		$this->start_controls_section(
			'card_title_style',
			array(
				'label' => __( 'Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-item-name h4',
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_title_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-name h4',
			)
		);

		$this->end_controls_section();

		/**
		 * card description Style
		 */
		$this->start_controls_section(
			'card_desc_style',
			array(
				'label'     => __( 'Description', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'variation_desc_show_hide' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_desc_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-item-name .wl-pl-item-desc-text',
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_desc_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-name .wl-pl-item-desc-text',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_desc_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-name span',
			)
		);

		$this->end_controls_section();

		/**
		 * card attributes Style
		 */
		$this->start_controls_section(
			'card_attributes_style',
			array(
				'label'     => __( 'Attributes', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'variation_attr_show_hide' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_attributes_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-item-details',
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_attributes_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-details',
			)
		);

		$this->add_control(
			'card_attributes_separator',
			array(
				'label'     => __( 'Separator color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .pl-item-attr' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * card Price Section Style
		 */
		$this->start_controls_section(
			'card_price_style',
			array(
				'label'     => __( 'Price Area', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'variation_price_show_hide' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_price_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-item-total',
			)
		);

		$this->add_control(
			'card_price_height',
			array(
				'label'      => __( 'Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 34,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pl-item-total' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_price_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wl-pl-item-total' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'card price' );

		$this->start_controls_tab(
			'card_price',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_price_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-total span',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_price_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-total',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_price_cheked',
			array(
				'label' => __( 'Checked', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_checked_price_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-total.wl-pl-it-checked span',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_checked_price_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-item-total.wl-pl-it-checked',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * card total Style
		 */
		$this->start_controls_section(
			'card_total_price_style',
			array(
				'label'     => __( 'Total Price', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'variation_price_show_hide' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_total_price_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-total',
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_total_price_color',
				'selector' => '{{WRAPPER}} .wl-pl-total',
			)
		);
		$this->end_controls_section();

		/**
		 * add to cart button Style
		 */
		$this->start_controls_section(
			'card_cart_btn_style',
			array(
				'label' => __( 'Cart Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_cart_btn_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-pl-btn ',
			)
		);

		$this->add_control(
			'border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .wl-pl-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'cart button' );

		$this->start_controls_tab(
			'card_cart_btn',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_cart_btn_color',
				'selector' => '{{WRAPPER}} .wl-pl-btn .wl-pl-btn-text, {{WRAPPER}} .wl-pl-btn a',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_cart_btn_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_cart_btn_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pl-btn',
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'card_cart_btn_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'card_cart_btn_hover_color',
				'selector' => '{{WRAPPER}} .wl-pl-btn:hover .wl-pl-btn-text, {{WRAPPER}} .wl-pl-btn:hover a',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_cart_btn_hover_bg_color',
				'selector' => '{{WRAPPER}} .wl-pl-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_cart_btn_hover_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-pl-btn:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings   = $this->get_settings_for_display();
		$product_id = $settings['main_product_id'];

		if ( 'current_product' == $settings['content_source'] ) {
			$product_id = get_the_ID();
			if ( wcd_is_edit_mode() || wcd_is_preview_mode() ) {
				$product_id = wcd_get_product_id( 'variable' );
			}

			if ( isset( $_POST['product_id'] ) ) {
				$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			}
		}

		if ( 'product' != get_post_type( $product_id ) ) {
			echo wp_kses_post( wcd_notice( 'This is not a product.' ) );
			return;
		}

		$currency      = get_woocommerce_currency_symbol();
		$product       = wc_get_product( $product_id );
		$variable      = new \WC_Product_Variable( $product_id );
		$variation_ids = $variable->get_children();

		if ( count( $variation_ids ) < 1 ) {
			echo wp_kses_post( wcd_notice( 'No Variation Found. May be this is not a variable product.' ) );
			return;
		}
		?>

		<div class="wl-pl-pricelist-area">
			<form class="wl-pl-pricelist-form" method="post">
				<input type="hidden" name="action" value="add-variations-to-cart">
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
				<?php
				wp_nonce_field( 'codesigner' );

				foreach ( $variation_ids as $variation_id ) :
					$variation   = new \WC_Product_Variation( $variation_id );
					$attributes  = $variation->get_variation_attributes();
					$price       = $variation->get_price_html();
					$price_int   = $variation->get_price();
					$stock       = $variation->get_stock_quantity();
					$description = get_post_meta( $variation_id, '_variation_description', true );
					$extra_attrs = wcd_attrs_notin_variations( $attributes, $product );
					?>

					<div class="wl-pl-pricelist-single" data-id="<?php echo esc_attr( $variation_id ); ?>">
						<input id="variation_<?php echo esc_attr( $variation_id ); ?>" class="checkbox-custom" name="variation_checked[<?php echo esc_attr( $variation_id ); ?>]" type="checkbox">
						<label for="variation_<?php echo esc_attr( $variation_id ); ?>" class="wl-pl-checkbox-label">
							<div class="wl-pl-item-name">
								<h4><?php echo esc_html( $product->get_name() ); ?></h4>
								<?php if ( 'yes' == $settings['variation_desc_show_hide'] && $description != '' ) : ?>
									<span class="wl-pl-item-desc"><span class="wl-pl-item-desc-text"><?php echo wp_kses_post( wp_trim_words( $description, codesigner_sanitize_number( $settings['product_desc_words_count'] ) ) ); ?></span></span>
								<?php endif; ?>
							</div>

							<div class="wl-pl-pricelist-right">

								<?php if ( 'yes' == $settings['variation_attr_show_hide'] ) : ?>
									<div class="wl-pl-item-details">

										<?php
										foreach ( $attributes as $attribute ) :
											if ( $attribute != '' ) :
												?>
												<span class="pl-item-attr"><?php echo esc_html( ucfirst( $attribute ) ); ?></span>
												<?php
											endif;
										endforeach;
										?>

									</div>
								<?php endif; ?>

								<div class="wl-pl-inputes">
									<?php if ( count( $extra_attrs ) > 0 ) : ?>
										<div class="wl-pl-select">
											<table class="wl-pl-select-tbl">
												<?php
												foreach ( $extra_attrs as $key => $attributes ) :
													$name = str_replace( 'attribute_', '', $key );
													$name = str_replace( 'pa_', '', $name );
													$name = str_replace( '_', ' ', $name );

													if ( count( $attributes ) == 1 ) {
														$attributes = explode( ',', $attributes[0] );
													}
													?>
													<tr>
														<td>
															<select name="attributes[<?php echo esc_attr( $variation_id ); ?>][<?php echo esc_attr( $key ); ?>]" class="wl-pl-variation-select" required="true">
																	<option value="<?php esc_attr_e( 'Not Selected', 'codesigner' ); ?>">
																									<?php
																										esc_html_e( 'Select ', 'codesigner' );
																										echo esc_html( ucfirst( $name ) );
																									?>
																	</option>
																<?php foreach ( $attributes as $attribute ) : ?>
																	<option value="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $attribute ); ?></option>
																<?php endforeach; ?>
															</select>
														</td>
													</tr>
												<?php endforeach; ?>
											</table>
										</div>
									<?php endif; ?>
									<div style="display: <?php echo esc_attr( 'yes' == $settings['variation_qty_show_hide'] ? '' : 'none' ); ?>" class="wl-pl-item-quantity-div">
										<div class="wl-pl-item-quantity">
											<input type="number" name="variation[<?php echo esc_attr( $variation_id ); ?>]" min="0" max="<?php echo esc_attr( $stock ); ?>" value=1>
										</div>
									</div>								
								</div>
								<?php if ( 'yes' == $settings['variation_price_show_hide'] ) : ?>
									<div class="wl-pl-item-total">
										<input type="hidden" name="price[<?php echo esc_attr( $variation_id ); ?>]" value="<?php echo esc_attr( $price_int ); ?>">
										<span><?php echo wp_kses_post( $price ); ?></span>
									</div>
								<?php endif; ?>
							</div>					
						</label>
					</div><!-- pricelist-single -->
				<?php endforeach; ?>

				<!-- pricelist bottom -->
				<div class="wl-pl-pricelist-bottom">
					<?php if ( 'yes' == $settings['variation_price_show_hide'] ) : ?>
						<strong class="wl-pl-total"><?php echo esc_html( $currency ); ?> <span class="wl-pl-<?php echo esc_attr( $product_id ); ?>-total-price"><?php esc_html_e( '00.00', 'codesigner' ); ?></span></strong>
					<?php endif; ?>
					<button class="wl-pl-btn add-variations-to-cart" type="submit"><span class="wl-pl-btn-text"><?php echo esc_html( $settings['atc_btn_text'] ); ?></span></button>
				</div>
			</form>
		</div>
		<?php
			do_action( 'codesigner_after_main_content', $this );
		?>
		<script type="text/javascript">
			jQuery(function($){
				var $prices = {};
				$('.wl-pl-item-quantity').hide()
				$('.wl-pl-pricelist-single').on('click',function(e){

					var $sum 	= 0;
					var $par 	= $(this)
					var $id 	= $par.data( 'id' );
					var $qty 	= $('.wl-pl-item-quantity input', $par).val();
					<?php if ( 'yes' != $settings['variation_qty_show_hide'] ) : ?>
						var $qty = 1;
					<?php endif; ?>
					var price 	= $('.wl-pl-item-total input', $par).val()

					if( $('.checkbox-custom', $par).is(":checked") ) {
						$('.wl-pl-item-quantity', $par).show()
						$('.wl-pl-item-total', $par).addClass('wl-pl-it-checked')
						$par.addClass('wl-pl-checked').siblings().removeClass('wl-pl-checked')
						$prices[ $id ] = parseFloat( price ) * parseInt( $qty )
					}

					$.each( $prices,function(){ $sum+=parseFloat(this) || 0; } );
					$('.wl-pl-<?php esc_html_e( $product_id ); ?>-total-price').html( parseFloat($sum).toFixed(2) )
				})
			})
		</script>
		<?php
	}
}

