<?php
/**
 * Currency switcher helpers.
 *
 * Every read of the visitor's chosen currency goes through
 * codesigner_get_selected_currency(), so a code can never reach WooCommerce
 * without having been checked against the list the store owner configured.
 *
 * @since 3.16
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */

/**
 * The configured currencies, as a code => rate map.
 *
 * A row only counts when it carries both a currency code and a usable rate,
 * so a half-saved row is ignored rather than silently converting at 1.
 * Cached for the request: the option does not change while prices render.
 *
 * @return array Uppercase currency code => positive float rate.
 */
if ( ! function_exists( 'codesigner_get_configured_currencies' ) ) :
	function codesigner_get_configured_currencies() {

		static $currencies = null;

		if ( null !== $currencies ) {
			return $currencies;
		}

		$currencies = array();
		$settings   = get_option( 'codesigner_currency_switcher' );

		if ( ! is_array( $settings ) || ! isset( $settings['cd_currency'] ) || ! is_array( $settings['cd_currency'] ) ) {
			return $currencies;
		}

		$known = function_exists( 'get_woocommerce_currencies' ) ? get_woocommerce_currencies() : array();

		foreach ( $settings['cd_currency'] as $row ) {

			// Both halves must be present. A row holding only a name or only a rate is not a currency.
			if ( ! is_array( $row ) || ! isset( $row['cd_cs_name'], $row['cd_cs_rate'] ) ) {
				continue;
			}

			$code = strtoupper( trim( (string) $row['cd_cs_name'] ) );
			$rate = (float) $row['cd_cs_rate'];

			// 'none' is the placeholder entry on the settings screen.
			if ( '' === $code || 'NONE' === $code ) {
				continue;
			}

			// Must be a currency WooCommerce actually knows about.
			if ( ! empty( $known ) && ! isset( $known[ $code ] ) ) {
				continue;
			}

			if ( $rate <= 0 ) {
				continue;
			}

			$currencies[ $code ] = $rate;
		}

		return $currencies;
	}
endif;

/**
 * Whether a currency code is one the store owner configured.
 *
 * @param string $code Currency code, any case.
 * @return bool
 */
if ( ! function_exists( 'codesigner_is_valid_currency' ) ) :
	function codesigner_is_valid_currency( $code ) {

		$currencies = codesigner_get_configured_currencies();
		$code       = strtoupper( trim( (string) $code ) );

		return '' !== $code && isset( $currencies[ $code ] );
	}
endif;

/**
 * The visitor's chosen currency, or '' when there is no valid choice.
 *
 * The only place that reads the user meta and the cookie. Callers get back
 * either a configured currency code or nothing at all.
 *
 * @return string
 */
if ( ! function_exists( 'codesigner_get_selected_currency' ) ) :
	function codesigner_get_selected_currency() {

		$code    = '';
		$user_id = get_current_user_id();

		if ( $user_id ) {
			$code = (string) get_user_meta( $user_id, 'cd_currency_code', true );
		}

		if ( '' === $code && isset( $_COOKIE['cd_currency_code'] ) ) {
			$code = sanitize_text_field( wp_unslash( $_COOKIE['cd_currency_code'] ) );
		}

		$code = strtoupper( trim( $code ) );

		return codesigner_is_valid_currency( $code ) ? $code : '';
	}
endif;

/**
 * Conversion rate for the visitor's chosen currency.
 *
 * @since 3.16
 * @return float|int Configured rate, or 1 when there is no valid choice.
 */
if ( ! function_exists( 'codesigner_currency_rate' ) ) :
	function codesigner_currency_rate() {

		$code = codesigner_get_selected_currency();

		if ( '' === $code ) {
			return 1;
		}

		$currencies = codesigner_get_configured_currencies();

		return $currencies[ $code ];
	}
endif;

/**
 * The currency code to present to the visitor.
 *
 * Reads the base currency from the option rather than through
 * get_woocommerce_currency(), so it does not re-enter the
 * woocommerce_currency filter this module registers.
 *
 * @since 3.16
 * @return string
 */
if ( ! function_exists( 'codesigner_get_currency_code' ) ) :
	function codesigner_get_currency_code() {

		$code = codesigner_get_selected_currency();

		return '' !== $code ? $code : get_option( 'woocommerce_currency' );
	}
endif;
