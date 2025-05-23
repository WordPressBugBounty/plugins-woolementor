<?php
namespace Codexpert\CoDesigner\Modules;

use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Bulk_Purchase_Discount extends Base {

	public $id = 'codesigner_bulk_purchase_discount';

	public $slug;

	public $version;
	/**
	 * Constructor
	 */
	public function __construct() {

		require_once __DIR__ . '/inc/functions.php';

		$this->action( 'init', 'init_plugin' );
		$this->action( 'woocommerce_product_options_general_product_data', 'simple_product_content' );
		$this->action( 'woocommerce_product_after_variable_attributes', 'variable_product_content', 10, 3 );
		$this->action( 'save_post', 'save_data' );
		$this->action( 'woocommerce_save_product_variation', 'save_data', 10, 1 );
		$this->action( 'admin_enqueue_scripts', 'admin_enqueue_script' );
		$this->action( 'woocommerce_cart_calculate_fees', 'add_discount' );
		$this->action( 'woocommerce_before_add_to_cart_form', 'add_discount_text' );
		$this->action( 'cd_after_add_to_cart_style', 'elementor_controls' );
	}

	/**
	 * Form WP version 6.7.0 Need to loade some
	 * Data like TextDomain and other in init hook
	 */
	public function init_plugin() {
		$this->plugin  = get_plugin_data( CODESIGNER );
		$this->slug    = $this->plugin['TextDomain'];
		$this->version = $this->plugin['Version'];
	}

	public function simple_product_content() {

		$cd_bpd_rules = get_post_meta( get_the_ID(), 'cd_bpd_rules', true );

		if ( empty( $cd_bpd_rules ) || ! is_array( $cd_bpd_rules ) ) {
			$cd_bpd_rules = array(
				array(
					'cd_bpd_quantatity' => '',
					'cd_bpd_amount'     => '',
				),
			);
		}

		?>
		<div class="cd-bpd-wrapper">
			<h4>
				<?php esc_attr_e( 'CoDesigner bulk Purchase Discount Rules', 'codesigner' ); ?>
			</h4>
			<?php foreach ( $cd_bpd_rules as $index => $values ) { ?>
				<div class="cd-single-discount-rule">
					<input type="text" name="cd_bpd_rules[<?php echo esc_attr( $index ); ?>][cd_bpd_quantatity]" value="<?php echo esc_attr( $values['cd_bpd_quantatity'] ); ?>" placeholder="<?php esc_attr_e( 'Quantity', 'codesigner' ); ?>" />
					<input type="text" name="cd_bpd_rules[<?php echo esc_attr( $index ); ?>][cd_bpd_amount]" value="<?php echo esc_attr( $values['cd_bpd_amount'] ); ?>" placeholder="<?php esc_attr_e( 'Discount Amount', 'codesigner' ); ?>" />
					<a class="cd-add-row">+</a>
					<a class="cd-remove-row">-</a>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	public function variable_product_content( $loop, $variation_data, $variation ) {
		$cd_bpd_rules = get_post_meta( $variation->ID, 'cd_bpd_rules', true );

		if ( empty( $cd_bpd_rules ) || ! is_array( $cd_bpd_rules ) ) {
			$cd_bpd_rules = array(
				array(
					'cd_bpd_quantatity' => '',
					'cd_bpd_amount'     => '',
				),
			);
		}
		?>
	
		<div class="cd-bpd-wrapper">
		<h4><?php echo esc_attr( __( 'CoDesigner bulk Purchase Discount Rules', 'codesigner' ) ); ?></h4>

		<?php

		foreach ( $cd_bpd_rules as $index => $values ) {
			?>
				<div class="cd-single-discount-rule">
					<input type="text" name="cd_bpd_rules[' . esc_attr( $index ) . '][cd_bpd_quantatity]" value="' . esc_attr( $values['cd_bpd_quantatity'] ) . '" placeholder="'. esc_attr( 'Quantity' ) .'" />
					<input type="text" name="cd_bpd_rules[' . esc_attr( $index ) . '][cd_bpd_amount]" value="' . esc_attr( $values['cd_bpd_amount'] ) . '" placeholder="'. esc_attr( 'Discount Amount' ) .'" />
					<a class="cd-add-row">+</a>
					<a class="cd-remove-row">-</a>
				</div>
			<?php
		}

		echo wp_kses_post( '</div>' );
	}

	public function save_data( $post_id ) {

		if ( isset( $_POST['cd_bpd_rules'] ) ) {
			$cd_bpd_rules = array();
			foreach ( $_POST['cd_bpd_rules'] as $values ) {
				$cd_bpd_quantatity = sanitize_text_field( $values['cd_bpd_quantatity'] );
				$cd_bpd_amount     = sanitize_text_field( $values['cd_bpd_amount'] );
				if ( ! empty( $cd_bpd_quantatity ) || ! empty( $cd_bpd_amount ) ) {
					$cd_bpd_rules[] = array(
						'cd_bpd_quantatity' => $cd_bpd_quantatity,
						'cd_bpd_amount'     => $cd_bpd_amount,
					);
				}
			}
			update_post_meta( $post_id, 'cd_bpd_rules', $cd_bpd_rules );
		}
	}

	public function admin_enqueue_script() {
		wp_enqueue_script( 'cd-bulk-purchase-discount-js', plugins_url( 'js/bulk-purchase-discount.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'cd-bulk-purchase-discount-css', plugins_url( 'css/bulk-purchase-discount.css', __FILE__ ), '', $this->version, 'all' );
	}

	public function add_discount( $cart ) {

		$total_discount = 0;
		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {

			$product_id   = $cart_item['product_id'];
			$variation_id = $cart_item['variation_id'];
			$quantity     = $cart_item['quantity'];
			$id           = $variation_id ? $variation_id : $product_id;

			$total_discount += cd_bulk_discount_amount( $id, $quantity );
		}
		if ( $total_discount ) {
			$cart->add_fee( __( 'Bulk Purchase Discount', 'codesigner' ), -$total_discount );
		}
	}

	public function add_discount_text() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		if ( $product->get_meta( 'cd_bpd_rules' ) ) {

			$rules = $product->get_meta( 'cd_bpd_rules' );

			?>
						<table style='width: 350px;' class='codesigner-bpd-table'>
			<?php

			printf( "<tr style='background-color: #118ab2; color: #fff;'><th>%s</th><th>%s</th></tr>", esc_attr( __( 'Quantity', 'codesigner' ) ), esc_attr( __( 'Discount', 'codesigner' ) ) );

			foreach ( $rules as $key => $rule ) {
				$quantatity = $rule['cd_bpd_quantatity'];
				$amount     = $rule['cd_bpd_amount'];
				printf( "<tr style='text-align: center' class='col-item'><td>%s</td><td>$%s</td></tr>", esc_attr( $quantatity ), esc_attr( $amount ) );
			}

			echo wp_kses_post( '</table>' );
		}
	}

	public function __settings( $settings ) {

		$settings['sections'][ $this->id ] = array(
			'id'     => $this->id,
			'label'  => __( 'Bulk Discount', 'codesigner' ),
			'icon'   => 'dashicons-media-text',
			'sticky' => false,
			'fields' => array(
				array(
					'id'      => 'bulk-discount-text',
					'label'   => __( 'Discount Text', 'codesigner' ),
					'type'    => 'text',
					'default' => __( 'Purchase %%quantity%% and get %%amount%% Discount', 'codesigner' ),
					'desc'    => __( 'Change this if you want to change the discount text in single product page', 'codesigner' ),
				),
			),
		);

		return $settings;
	}

	public function elementor_controls( $widget_class ) {
		$widget_class->start_controls_section(
			'section_style_bulk_purchase_discount_ribbon',
			array(
				'label' => __( 'Bulk Purchase Discount', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$widget_class->add_control(
			'bulk_purchase_discount_font_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .codesigner-bpd-table' => 'color: {{VALUE}}',
				),
				'default'   => '#000000',
				'separator' => 'before',
			)
		);

		$widget_class->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'bulk_purchase_discount_content_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .codesigner-bpd-table',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 14 ) ),
					// 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$widget_class->add_control(
			'bulk_purchase_discount_background',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .codesigner-bpd-table' => 'background: {{VALUE}}',
				),
			)
		);

		$widget_class->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'bulk_purchase_discount_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .codesigner-bpd-table',
			)
		);

		$widget_class->add_responsive_control(
			'bulk_purchase_discount_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .codesigner-bpd-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget_class->add_responsive_control(
			'bulk_purchase_discount_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .codesigner-bpd-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget_class->add_responsive_control(
			'bulk_purchase_discount_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .codesigner-bpd-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget_class->end_controls_section();
	}
}