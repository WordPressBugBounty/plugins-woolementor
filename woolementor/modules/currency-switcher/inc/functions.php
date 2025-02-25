<?php
/**
 * Return currency rate
 *
 * @since 3.16
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if ( ! function_exists( 'codesigner_currency_rate' ) ) :
	function codesigner_currency_rate() {
		if ( get_option( 'codesigner_currency_switcher' ) ) {
			$currency_array = get_option( 'codesigner_currency_switcher', true )['cd_currency'];
			$user_id        = get_current_user_id();
			$currency_code  = '';
			if ( $user_id && get_user_meta( $user_id, 'cd_currency_code' ) ) {
				$currency_code = get_user_meta( $user_id, 'cd_currency_code', true );
			} elseif ( isset( $_COOKIE['cd_currency_code'] ) ) {
				$currency_code = sanitize_text_field( $_COOKIE['cd_currency_code'] );
			}
			if ( $currency_code ) {
				foreach ( $currency_array as $currency ) {
					if ( $currency['cd_cs_name'] === $currency_code ) {
						return $currency['cd_cs_rate'];
					}
				}
			}
		}
		return 1;
	}
endif;
/**
 * Return currency code
 *
 * @since 3.16
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if ( ! function_exists( 'codesigner_get_currency_code' ) ) :
	function codesigner_get_currency_code() {

		$user_id       = get_current_user_id();
		$currency_code = '';
		if ( $user_id && get_user_meta( $user_id, 'cd_currency_code' ) ) {
			$currency_code = get_user_meta( $user_id, 'cd_currency_code', true );
		} elseif ( isset( $_COOKIE['cd_currency_code'] ) ) {
			$currency_code = sanitize_text_field( $_COOKIE['cd_currency_code'] );
		} else {
			$currency_code = get_option( 'woocommerce_currency' );
		}

		return $currency_code;
	}
endif;
