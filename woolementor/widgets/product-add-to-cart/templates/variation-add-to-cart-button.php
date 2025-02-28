<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( codesigner_sanitize_number( wp_unslash( $_POST['quantity'] ) ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		),
		$product
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );

	printf(
		'<button type="submit" %s>%s</button>',
		wp_kses_post( $this->get_render_attribute_string( 'add_to_cart_text' ) ),
		esc_html( $button_text )
	);

	do_action( 'woocommerce_after_add_to_cart_button' );
	?>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( absint( $product->get_id() ) ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo esc_attr( absint( $product->get_id() ) ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
