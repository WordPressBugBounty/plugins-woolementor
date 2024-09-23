<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;

class Add_To_Cart_Text extends Base {

	public $id = 'codesigner_add_to_cart_text';

	/**
	 * Constructor
	 */
	public function __construct() {
        $this->filter( 'woocommerce_product_add_to_cart_text', 'add_to_cart_text' );
        $this->filter( 'woocommerce_product_single_add_to_cart_text', 'add_to_cart_text' );
	}

	public function add_to_cart_text( $default_text ) {
		$priv_text 	= Helper::get_option( 'codesigner_tools', 'add-to-cart-text' );
		$new_text 	= Helper::get_option( 'codesigner_add_to_cart_text', 'add-to-cart-text' );
		if ( $priv_text ) {
			return $priv_text;
		}
		elseif ( $new_text ) {
			return $new_text;
		}
		else{
			return $default_text;
		}
	}

	public function __settings ( $settings ) {
		
		$settings['sections'][ $this->id ] = [
			'id'        => $this->id,
			'label'     => __( 'Add to Cart', 'codesigner' ),
			'icon'      => 'dashicons-text',
			'sticky'	=> false,
			'fields'	=> [
				[
					'id'      	=> 'add-to-cart-text',
					'label'     => __( 'Add to Cart Text', 'codesigner' ),
					'type'      => 'text',
					'default'   => __( 'Add to Cart', 'codesigner' ),
					'desc'   	=> __( 'Enable this if you want to change the default text of the \'Add to Cart\' button.', 'codesigner' )
				]
			]
		];

		return $settings;
	}
}