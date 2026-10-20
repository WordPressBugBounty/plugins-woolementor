<?php
namespace Codexpert\CoDesigner;

/**
 * NiroHelp cross-promotion helpers
 */
class Promo {

	public static function url( $placement ) {
		return add_query_arg(
			[
				'utm_source'   => 'codesigner',
				'utm_medium'   => $placement,
				'utm_campaign' => 'crosspromo',
			],
			'https://nirohelp.com/'
		);
	}

	/**
	 * Logo URL for a promoted plugin. Empty string when no logo file exists for it.
	 */
	public static function logo_url( $plugin = 'nirohelp' ) {
		switch ( $plugin ) {
			case 'nirohelp':
				return CODESIGNER_ASSETS . '/img/promo/plugins/nirohelp-logo.png';

			case 'easycommerce':
				return CODESIGNER_ASSETS . '/img/promo/plugins/easycommerce.png';

			case 'thumbpress':
				return CODESIGNER_ASSETS . '/img/promo/plugins/thumbpress.png';

			case 'wcaffiliate':
				return CODESIGNER_ASSETS . '/img/promo/plugins/wcaffiliate.png';

			default:
				return '';
		}
	}

	/**
	 * Whether the promo should be visible. Pro users with an activated license never see it.
	 */
	public static function is_visible() {
		return ! wcd_is_pro_activated();
	}

	/**
	 * Whether the admin notice should show for the current user right now.
	 */
	public static function notice_is_due( $user_id ) {
		$install_time = (int) get_option( 'codesigner_install_time' );

		if ( ! $install_time || time() < $install_time + WEEK_IN_SECONDS ) {
			return false;
		}

		if ( get_user_meta( $user_id, 'codesigner_nirohelp_notice_dismissed', true ) ) {
			return false;
		}

		return time() >= (int) get_user_meta( $user_id, 'codesigner_nirohelp_notice_snooze', true );
	}
}
