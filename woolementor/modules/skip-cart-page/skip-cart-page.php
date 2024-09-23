<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\CoDesigner\Helper;

use Codexpert\Plugin\Base;

class Skip_Cart_Page extends Base {

	/**
	 * Constructor
	 */
	public function __construct() {
        $this->filter( 'woocommerce_add_to_cart_redirect', 'redirect_to_checkout' );
	}

	public function redirect_to_checkout( $default_url ) {

		$priv_val 	= Helper::get_option( 'codesigner_tools', 'redirect_to_checkout' );
		$new_val 	= Helper::get_option( 'codesigner_modules', 'skip-cart-page' );
		if ( $priv_val || $new_val ) {
			return wc_get_checkout_url();
		}
		else {
			return $default_url;
		}
	}
}