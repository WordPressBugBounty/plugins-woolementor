<?php

namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if (! defined('ABSPATH')) {
	exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Codexpert <hi@codexpert.io>
 */
class AJAX extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct($plugin){
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	public function fetch_docs(){
		if (! is_wp_error($_posts_data = wp_remote_get("https://help.codexpert.io/wp-json/wp/v2/docs/?parent={$this->plugin['doc_id']}&per_page=100")) && is_array($posts = json_decode($_posts_data['body'], true)) && count($posts) > 0) {
			update_option('codesigner-docs_json', $posts);
		}
	}

	/**
	 * Adds a product to the wishlist
	 * Removes a product from the wishlist
	 *
	 * @TODO: change method name 
	 *
	 * @since 1.0
	 */
	public function add_to_wish(){
		$response = [
			'status'	=> 0,
			'message'	=> __('Unauthorized!', 'codesigner')
		];

		if (!wp_verify_nonce($_POST['_wpnonce'], $this->slug)) {
			wp_send_json($response);
		}

		if (!isset($_POST['product_id'])) {
			$response['message'] = __('No product selected!', 'codesigner');
			wp_send_json($response);
		}

		extract($_POST);

		$user_id = get_current_user_id();
		$wishlist = wcd_get_wishlist($user_id);

		// if the product is already in the wishlist, remove
		if (($key = array_search($product_id, $wishlist)) !== false) {
			$response['action'] = 'removed';

			unset($wishlist[$key]);
		}

		// add to wishlist
		else {
			$response['action'] = 'added';
			$wishlist[] = $product_id;
		}

		$wishlist = array_unique($wishlist);

		// update wishlist
		wcd_set_wishlist($wishlist, $user_id);

		// send response
		$response['status'] = 1;
		// Translators: %s represents the action performed on the wishlist item
		$response['message'] = sprintf(__('Wishlist item %s!', 'codesigner'), $response['action']);
		wp_send_json($response);
	}

	public function add_variations_to_cart(){
		$response['status'] 	= 0;
		$response['message'] 	= __('Something is wrong!', 'codesigner');

		if (! wp_verify_nonce($_POST['_wpnonce'], 'codesigner')) {
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		$variations 		= isset($_POST['variation']) ? array_map('codesigner_sanitize_number', $_POST['variation']) : [];
		$product_id 		= isset($_POST['product_id']) ? codesigner_sanitize_number($_POST['product_id']) : 0;
		$attributes 		= isset($_POST['attributes']) ? $_POST['attributes'] : []; // sanitized later @L:110
		$variation_checked 	= isset($_POST['variation_checked']) ? array_map('sanitize_text_field',  $_POST['variation_checked']) : [];

		$checked_items 		= array_intersect_key($variations, $variation_checked);

		if (count($checked_items) < 1) {
			$response['message'] = __('No variations selected!', 'codesigner');
			wp_send_json($response);
		}

		foreach ($checked_items as $variation_id => $qty) {
			$_attribute = [];

			if (isset($attributes[$variation_id]) && !is_null($attributes[$variation_id])) {
				$_attribute = array_map('sanitize_text_field', $attributes[$variation_id]);
			}

			WC()->cart->add_to_cart($product_id, codesigner_sanitize_number($qty), codesigner_sanitize_number($variation_id), $_attribute);
		}

		$response['checked_items'] 	= $checked_items;
		$response['status'] 	= 1;
		$response['message'] 	= __('Product Added', 'codesigner');
		wp_send_json($response);
	}

	public function multiple_product_add_to_cart(){
		$response['status'] 	= 0;
		$response['message'] 	= __('Something is wrong!', 'codesigner');

		if (!wp_verify_nonce($_POST['_wpnonce'], 'codesigner')) {
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		$_checked_items = isset($_POST['cart_item_ids']) ? array_map('codesigner_sanitize_number', $_POST['cart_item_ids']) : [];
		$_multiple_qty 	= isset($_POST['multiple_qty']) ? array_map('codesigner_sanitize_number', $_POST['multiple_qty']) : [];

		if (count($_checked_items) < 1) {
			$response['message'] = __('No products selected!', 'codesigner');
			wp_send_json($response);
		}

		foreach ($checked_items as $key => $item) {
			$qty = is_null($multiple_qty) && !isset($multiple_qty[$item]) ? 1 : $multiple_qty[$item];
			WC()->cart->add_to_cart(codesigner_sanitize_number($item), codesigner_sanitize_number($qty));
		}

		$response['status'] 	= 1;
		$response['checked_items'] 	= $checked_items;
		$response['multiple_qty'] 	= $multiple_qty;

		$response['_checked_items'] = $_checked_items;
		$response['_multiple_qty'] 	= $_multiple_qty;
		$response['message'] 	= __('Product Added!', 'codesigner');
		wp_send_json($response);
	}

	public function template_sync(){
		$response['status'] 	= 0;
		$response['message'] 	= __('Something is wrong!', 'codesigner');

		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		if (! defined('ELEMENTOR_VERSION')) {
			$response['message'] = __('Elementor not installed!', 'codesigner');
			wp_send_json($response);
		}

		Library_Source::get_library_data(true);

		$response['status'] 	= 1;
		$response['message'] 	= __('Synchronization Complete', 'codesigner');
		wp_send_json($response);
	}

	public function wl_single_cart(){
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if (! isset($_POST['product_id'])) {
			return;
		}

		$product_id         = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
		$product            = wc_get_product($product_id);
		$quantity           = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
		$variation_id       = !empty($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
		$variations         = !empty($_POST['variations']) ? array_map('sanitize_text_field', json_decode(stripslashes($_POST['variations']), true)) : array();
		$passed_validation  = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations);
		$product_status     = get_post_status($product_id);

		$cart_item_data = $_POST['alldata'];

		if ($passed_validation && 'publish' === $product_status) {

			if (count($variations) == 0) {
				\WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations, $cart_item_data);
			}

			do_action('woocommerce_ajax_added_to_cart', $product_id);
			if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
				wc_add_to_cart_message([$product_id => $quantity], true);
			}
			\WC_AJAX::get_refreshed_fragments();
		} else {
			$data = [
				'error' 		=> true,
				'product_url' 	=> apply_filters('woocommerce_cart_redirect_after_error', esc_url(get_permalink($product_id)), $product_id),
			];
			wp_send_json($data);
		}
		wp_send_json_success();
	}

	public function admin_notice() {

		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		update_option('mother_day_pointer_dismiss', 1);

		$response['status'] 	= 1;
		$response['message'] 	= __('Notice Removed!', 'codesigner');
		wp_send_json($response);
	}

	public function complete_setting_close() {

		if (! wp_verify_nonce($_POST['_wpnonce'], 'admin_notice')) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		if ($_POST['data_key'] == 'setup-close') {
			update_option('complete_setting_close', 1);
		} elseif ($_POST['data_key'] == 'birthday-notice') {
			update_option('notice_BIRTHDAY04', 1);
		} elseif ($_POST['data_key'] == 'hide-banner') {
			$add_one_day 	= time() + DAY_IN_SECONDS;
			update_option('recurring_every_day_banner', $add_one_day);
		} else {
			$response['status'] 	= 0;
			$response['message'] 	= __('No Data key found!', 'codesigner');
			wp_send_json($response);
		}

		$response['status'] 	= 1;
		$response['message'] 	= $_POST['data_key'] . __('-Close', 'codesigner');
		wp_send_json($response);
	}

	// private function dismiss_notice_generic($notice_type) {

	// 	if (! wp_verify_nonce($_POST['_wpnonce'])) {
	// 		$response['status'] 	= 0;
	// 		$response['message'] = __('Unauthorized!', 'codesigner');
	// 		wp_send_json($response);
	// 	}

	// 	update_option($notice_type, true);

	// 	$response['status'] 	= 1;
	// 	$response['message'] 	= __('Notice Removed!', 'codesigner');
	// 	wp_send_json($response);
	// }

	// public function register_dismiss_notice_actions() {
	// 	$notice_types = ['checkout', 'email', 'invoice'];
	// 	foreach ($notice_types as $type) {
	// 		dismiss_notice_generic("codesigner_dismiss_notice_$type");
	// 	}
	// }

	public function dismiss_notice_checkout() {
		
		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		update_option( 'codesigner_dismiss_notice_checkout', true );

		$response['status'] 	= 1;
		$response['message'] 	= __('Notice Removed!', 'codesigner');
		wp_send_json($response);
	}

	public function dismiss_notice_email() {
		
		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		update_option( 'codesigner_dismiss_notice_email', true );

		$response['status'] 	= 1;
		$response['message'] 	= __('Notice Removed!', 'codesigner');
		wp_send_json($response);
	}

	public function dismiss_notice_invoice() {
		
		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}

		update_option( 'codesigner_dismiss_notice_invoice', true );

		$response['status'] 	= 1;
		$response['message'] 	= __('Notice Removed!', 'codesigner');
		wp_send_json($response);
	}

	public function codesigner_dismiss_notice_callback() {
		if (! wp_verify_nonce($_POST['_wpnonce'])) {
			$response['status'] 	= 0;
			$response['message'] = __('Unauthorized!', 'codesigner');
			wp_send_json($response);
		}
		$notice_type 	= sanitize_text_field( $_POST[ 'notice_type' ] );
		$url 			= codesigner_notices_values()[$notice_type]['url'];

		delete_transient( sanitize_text_field( $notice_type ) );

		$response['status'] 	= 1;
		$response['message'] 	= __('Notice Removed!', 'codesigner');
		$response['url'] 		= $url;
		wp_send_json($response);
	}
}