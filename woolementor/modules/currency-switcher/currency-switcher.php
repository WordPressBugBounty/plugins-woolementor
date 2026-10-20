<?php
namespace Codexpert\CoDesigner\Modules;

use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;

class Currency_Switcher extends Base {

	public $id = 'codesigner_currency_switcher';

	public $slug;

	public $version;

	/**
	 * Constructor
	 */
	public function __construct() {
		require_once __DIR__ . '/inc/functions.php';

		$this->action( 'init', 'init_plugin' );
		$this->action( 'cx-settings-saved', 'settings_saved', 10, 2 );
		$this->action( 'elementor/widgets/register', 'register_widget' );
		$this->action( 'admin_enqueue_scripts', 'admin_enqueue_script' );
		$this->action( 'wp_enqueue_scripts', 'front_enqueue_script' );
		$this->filter( 'woocommerce_currency', 'change_currency', 10, 2 );
		$this->filter( 'raw_woocommerce_price', 'change_price', 10, 2 );
		$this->action( 'wp_ajax_cd-change-currency', 'save_user_currency' );
		$this->action( 'wp_ajax_nopriv_cd-change-currency', 'save_user_currency' );
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

	public function __settings( $settings ) {
		$settings['sections'][ $this->id ] = array(
			'id'      => $this->id,
			'label'   => __( 'Currency Switcher', 'codesigner' ),
			'icon'    => 'dashicons-update-alt',
			'sticky'  => false,
			'content' => Helper::get_template( 'settings', 'modules/currency-switcher/template' ),
		);

		return $settings;
	}

	public function settings_saved( $option_name, $posted_data ) {
		if ( $option_name == 'codesigner_currency_switcher' ) {
			if ( isset( $posted_data['cd_currency'] ) ) {
				$cd_currency = array();
				foreach ( $posted_data['cd_currency'] as $values ) {
					$cd_cs_name = sanitize_text_field( $values['cd_cs_name'] );
					$cd_cs_rate = sanitize_text_field( $values['cd_cs_rate'] );
					$cd_cs_img  = sanitize_text_field( $values['cd_cs_img'] );
					if ( ! empty( $cd_cs_name ) || ! empty( $cd_cs_rate ) ) {
						$cd_currency[] = array(
							'cd_cs_name' => $cd_cs_name,
							'cd_cs_rate' => $cd_cs_rate,
							'cd_cs_img'  => $cd_cs_img,
						);
					}
				}
			}
		}
	}

	public function register_widget( $widgets_manager ) {
		require_once __DIR__ . '/widgets/currency-switcher-widget.php';
		$widgets_manager->register( new \Currency_Switcher_Widget() );
	}

	public function admin_enqueue_script() {
		wp_enqueue_script( 'cd-currency-switcher-js', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'cd-currency-switcher-css', plugins_url( 'css/admin.css', __FILE__ ), '', $this->version, 'all' );
		wp_enqueue_media();
	}

	public function front_enqueue_script() {
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
		wp_enqueue_script( 'cd-currency-switcher-js', plugins_url( 'js/front.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'cd-currency-switcher-css', plugins_url( 'css/front.css', __FILE__ ), '', $this->version, 'all' );
	}

	/**
	 * Swap the store currency for the visitor's choice.
	 *
	 * Only a currency from the configured list is allowed through. Anything
	 * else keeps the store's base currency, so a crafted cookie cannot
	 * relabel an order in a currency the store owner never set up.
	 *
	 * @param string $currency_code Base currency code.
	 * @return string
	 */
	public function change_currency( $currency_code ) {

		$selected = codesigner_get_selected_currency();

		return '' !== $selected ? $selected : $currency_code;
	}

	public function change_price( $price, $original_price ) {
		$rate = codesigner_currency_rate();
		return $price * $rate;
	}

	/**
	 * Store the visitor's currency choice.
	 *
	 * @return void
	 */
	public function save_user_currency() {

		$response = array(
			'status'  => 0,
			'message' => __( 'Unauthorized!', 'codesigner' ),
		);

		$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, $this->slug ) ) {
			wp_send_json( $response );
		}

		$currency_code = isset( $_POST['currency'] ) ? sanitize_text_field( wp_unslash( $_POST['currency'] ) ) : '';
		$currency_code = strtoupper( trim( $currency_code ) );

		if ( ! codesigner_is_valid_currency( $currency_code ) ) {
			$response['message'] = __( 'Invalid currency!', 'codesigner' );
			wp_send_json( $response );
		}

		$user_id = get_current_user_id();

		if ( $user_id ) {
			update_user_meta( $user_id, 'cd_currency_code', $currency_code );
		} else {
			setcookie( 'cd_currency_code', $currency_code, time() + DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
		}

		$response['status']  = 1;
		$response['message'] = __( 'Currency Changed', 'codesigner' );
		wp_send_json( $response );
	}
}
