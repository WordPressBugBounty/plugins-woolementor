<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Settings
 * @author Codexpert <hi@codexpert.io>
 */
class Settings extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin  = $plugin;
		$this->slug    = $this->plugin['TextDomain'];
		$this->name    = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
	}

	public function init_menu() {
		global $codesigner, $codesigner_pro;

		if( ! defined( 'CODESIGNER_PRO' ) ) {
			/**
			 * Main admin menu
			 */
			$dashboard_settings = array(
				'id'       => $this->slug,
				'parent'   => $this->slug,
				// 'label'          => $this->name,
				'label'    => __( 'Getting Started', 'codesigner' ),
				'title'    => $this->name,
				'header'   => $this->name,
				'icon'     => CODESIGNER_ASSETS . '/img/icon.png',
				'position' => 58,
				'topnav'   => 'top',
				'sections' => array(
					'codesigner_general' => array(
						'id'        => 'codesigner_general',
						'label'     => __( 'General', 'codesigner' ),
						'icon'      => 'dashicons dashicons-admin-generic',
						'hide_form' => true,
						'template'  => CODESIGNER_DIR . '/views/settings/general.php',
					),
				),
			);

			new Settings_API( apply_filters( 'codesigner-dashboard_settings_args', $dashboard_settings ) );
		}

		/**
		 * Widgets menu
		 */
		$widgets_settings = array(
			'id'       => defined( 'CODESIGNER_PRO' ) ? $this->slug : "{$this->slug}-widgets",
			'parent'   => $this->slug,
			'label'    => __( 'Widgets', 'codesigner' ),
			'title'    => __( 'Widgets', 'codesigner' ),
			'header'   => __( 'Widgets', 'codesigner' ),
			'sections' => array(
				'codesigner_widgets' => array(
					'id'       => 'codesigner_widgets',
					'label'    => __( 'Widgets', 'codesigner' ),
					'icon'     => 'dashicons-screenoptions',
					'sticky'   => false,
					'template' => CODESIGNER_DIR . '/views/settings/widgets.php',
				),
			),
		);

		new Settings_API( apply_filters( 'codesigner-widgets_settings_args', $widgets_settings ) );

		/**
		 * Modules menu
		 */
		$modules_settings = array(
			'id'       => "{$this->slug}-modules",
			'parent'   => $this->slug,
			'label'    => __( 'Modules', 'codesigner' ),
			'title'    => __( 'Modules', 'codesigner' ),
			'header'   => __( 'Modules', 'codesigner' ),
			'sections' => array(
				'codesigner_modules' => array(
					'id'        => 'codesigner_modules',
					'label'     => __( 'Modules', 'codesigner' ),
					'icon'      => 'dashicons-image-filter',
					'sticky'    => false,
					'page_load' => true,
					'fields'    => array_map(
						function ( $_module ) {
							$module = array(
								'id'    => $_module['id'],
								'label' => $_module['title'],
								'desc'  => $_module['desc'],
								'type'  => 'switch',
							);

							return $module;
						},
						codesigner_modules()
					),
					'template'  => CODESIGNER_DIR . '/views/settings/modules.php',
				),
			),
		);

		new Settings_API( apply_filters( 'codesigner-modules_settings_args', $modules_settings ) );

		if ( ! defined( 'CODESIGNER_PRO' ) ) :

			/**
			 * Email Designer menu
			 */
			$email_designer_settings = array(
				'id'       => "{$this->slug}-email_designer",
				'parent'   => $this->slug,
				'label'    => __( 'Email Designer', 'codesigner' ),
				'title'    => __( 'Email Designer', 'codesigner' ),
				'header'   => __( 'Email Designer', 'codesigner' ),
				'sections' => array(
					'codesigner_email_designer' => array(
						'id'        => 'codesigner_email_designer',
						'label'     => __( 'Email Designer', 'codesigner' ),
						'icon'      => 'dashicons-email-alt',
						'hide_form' => true,
						'template'  => CODESIGNER_DIR . '/views/settings/email-designer.php',
					),
				),
			);

			// new Settings_API( apply_filters( 'codesigner-email_designer_settings_args', $email_designer_settings ) );

		endif;

		if ( ! defined( 'CODESIGNER_PRO' ) ) :

			/**
			 * Invoice Builder
			 */
			$invoice_builder_settings = array(
				'id'       => "{$this->slug}-invoice_builder",
				'parent'   => $this->slug,
				'label'    => __( 'Invoice Builder', 'codesigner' ),
				'title'    => __( 'Invoice Builder', 'codesigner' ),
				'header'   => __( 'Invoice Builder', 'codesigner' ),
				'sections' => array(
					'codesigner_invoice_designer' => array(
						'id'        => 'codesigner_invoice_designer',
						'label'     => __( 'Invoice Builder', 'codesigner' ),
						'icon'      => 'dashicons-email-alt',
						'hide_form' => true,
						'template'  => CODESIGNER_DIR . '/views/settings/invoice.php',
					),
				),
			);

			// new Settings_API( apply_filters( 'codesigner-invoice_builder_settings_args', $invoice_builder_settings ) );

		endif;

		if ( ! defined( 'CODESIGNER_PRO' ) ) :

			/**
			 * Checkout Builder
			 */
			$checkout_builder_settings = array(
				'id'       => "{$this->slug}-checkout_builder",
				'parent'   => $this->slug,
				'label'    => __( 'Checkout Builder', 'codesigner' ),
				'title'    => __( 'Checkout Builder', 'codesigner' ),
				'header'   => __( 'Checkout Builder', 'codesigner' ),
				'sections' => array(
					'codesigner_invoice_designer' => array(
						'id'        => 'codesigner_invoice_designer',
						'label'     => __( 'Checkout Builder', 'codesigner' ),
						'icon'      => 'dashicons-email-alt',
						'hide_form' => true,
						'template'  => CODESIGNER_DIR . '/views/settings/checkout.php',
					),
				),
			);

			// new Settings_API( apply_filters( 'codesigner-checkout_builder_settings_args', $checkout_builder_settings ) );

			endif;

		/**
		 * Templates menu
		 */
		$templates_settings = array(
			'id'       => "{$this->slug}-templates",
			'parent'   => $this->slug,
			'label'    => __( 'Templates', 'codesigner' ),
			'title'    => __( 'Templates', 'codesigner' ),
			'header'   => __( 'Templates', 'codesigner' ),
			'sections' => array(
				'wcd_templates' => array(
					'id'        => 'wcd_templates',
					'label'     => __( 'Template Library', 'codesigner' ),
					'icon'      => 'dashicons-download',
					'hide_form' => true,
					'template'  => CODESIGNER_DIR . '/views/settings/templates.php',
				),
			),
		);

		new Settings_API( apply_filters( 'codesigner-templates_settings_args', $templates_settings ) );

		/**
		 * Tools menu
		 */
		$site_config = array(
			'PHP Version'            => PHP_VERSION,
			'WordPress Version'      => get_bloginfo( 'version' ),
			'WooCommerce Version'    => is_plugin_active( 'woocommerce/woocommerce.php' ) ? get_option( 'woocommerce_version' ) : 'Not Active',
			'Elementor Version'      => is_plugin_active( 'elementor/elementor.php' ) ? get_option( 'elementor_version' ) : 'Not Active',
			'Elementor Pro Version'  => is_plugin_active( 'elementor-pro/elementor-pro.php' ) ? get_option( 'elementor_pro_version' ) : 'Not Active',
			'CoDesigner Version'     => $this->version,
			'CoDesigner Pro Version' => defined( 'CODESIGNER_PRO' ) ? $codesigner_pro['Version'] : 'Not Active',
			'CoDesigner Pro License' => defined( 'CODESIGNER_PRO' ) && wcd_is_pro_activated() ? 'Activated' : 'Not Activated',
			'Memory Limit'           => defined( 'WP_MEMORY_LIMIT' ) && WP_MEMORY_LIMIT ? WP_MEMORY_LIMIT : 'Not Defined',
			'Debug Mode'             => defined( 'WP_DEBUG' ) && WP_DEBUG ? 'Enabled' : 'Disabled',
			'Active Plugins'         => get_option( 'active_plugins' ),
			'Checkout Page ID'       => get_option( 'woocommerce_checkout_page_id' ),
			'Enable Debug'           => get_option( 'wl_enable_debug' ),
			'Enabled Widgets'        => wcd_active_widgets(),
			'Checkout Fields'        => defined( 'CODESIGNER_PRO' ) ? get_option( '_wcd_checkout_fields' ) : array(),
		);

		$tools_settings = array(
			'id'       => "{$this->slug}-tools",
			'parent'   => $this->slug,
			'label'    => __( 'Tools', 'codesigner' ),
			'title'    => __( 'Tools', 'codesigner' ),
			'header'   => __( 'Tools', 'codesigner' ),
			'sections' => array(
				'codesigner_tools' => array(
					'id'        => 'codesigner_tools',
					'label'     => __( 'Tools', 'codesigner' ),
					'icon'      => 'dashicons-admin-tools',
					'page_load' => true,
					'sticky'    => false,
					'fields'    => array(
						'enable_debug'            => array(
							'id'       => 'enable_debug',
							'label'    => __( 'Enable Debug', 'codesigner' ),
							'type'     => 'switch',
							'desc'     => __( 'Enable this if you face any CSS or JS related issues.', 'codesigner' ),
							'disabled' => false,
						),
						'quantity_input'          => array(
							'id'       => 'quantity_input',
							'label'    => __( 'Fix Quantity Button', 'codesigner' ),
							'type'     => 'switch',
							// Translators: 1: The "+" button, 2: The "-" button
							'desc'     => sprintf( __( 'Check this if you see the %1$s and %2$s buttons twice in the cart.', 'codesigner' ), '<button type="button">+</button>', '<button type="button">-</button>' ),
							'disabled' => false,
						),
						'cross_domain_copy_paste' => array(
							'id'    => 'cross_domain_copy_paste',
							'label' => __( 'Cross-domain Copy Paste', 'codesigner' ),
							'type'  => 'switch',
							'desc'  => __( 'Enable this if you want to enable cross-domain copy &amp; paste feature.', 'codesigner' ),
						),
						'reset'        => array(
							'id'       => 'reset',
							'label'    => __( 'Reset Settings', 'codesigner' ),
							'type'     => 'switch',
							'desc'     => __( 'This will reset every changes you\'ve made. Don\'t do this unless you know what you\'re doing.', 'codesigner' ),
							'disabled' => false,
						),
						'report'       => array(
							'id'       => 'report',
							'label'    => __( 'Report', 'codesigner' ),
							'type'     => 'textarea',
							'desc'     => '<button id="wl-report-copy" class="button button-primary"><span class="dashicons dashicons-admin-page"></span></button>',
							'columns'  => 24,
							'rows'     => 10,
							'default'  => json_encode( $site_config, JSON_PRETTY_PRINT ),
							'readonly' => true,
						),
					),
				),
			),
		);

		new Settings_API( apply_filters( 'codesigner-tools_settings_args', $tools_settings ) );

		/**
		 * Help & Support menu
		 */
		$help_settings = array(
			'id'       => "{$this->slug}-help",
			'parent'   => $this->slug,
			'label'    => __( 'Help &amp; Support', 'codesigner' ),
			'title'    => __( 'Help &amp; Support', 'codesigner' ),
			'header'   => __( 'Help &amp; Support', 'codesigner' ),
			'sections' => array(
				'wcd_help' => array(
					'id'        => 'wcd_help',
					'label'     => __( 'Help &amp; Support', 'codesigner' ),
					'icon'      => 'dashicons-sos',
					'template'  => CODESIGNER_DIR . '/views/settings/help.php',
					'hide_form' => true,
				),
			),
		);

		// new Settings_API( apply_filters( 'codesigner-help_settings_args', $help_settings ) );

		if ( ! defined( 'CODESIGNER_PRO' ) ) {

			$pro_settings = array(
				'id'     => "{$this->slug}-get-pro",
				'parent' => $this->slug,
				'label'  => __( ' <span style="font-weight: bold"> Celebrate Year-End with 50% Off </span>', 'codesigner' ),
				'title'  => '',
				'header' => '',
			);

			new Settings_API( apply_filters( 'codesigner-pro_settings_args', $pro_settings ) );
		}
	}

	public function redirect_specific_admin_page() {
		global $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'codesigner-get-pro' && ! defined( 'CODESIGNER_PRO' ) ) {
			wp_redirect( 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=button&utm_campaign=year-end' );
			exit;
		}
	}

	public function reset( $option_name, $posted ) {

		if ( isset( $posted['reset'] ) && $posted['reset'] == 'on' ) {
			delete_option( $option_name );
			delete_option( 'codesigner_widgets' );
			delete_option( 'codesigner_tools' );
			delete_option( 'wcd_email_designer' );
			delete_option( 'codesigner_email_designer' );
		}
	}

	public function migrate_settings( $current_version, $old_version ) {
		// templates option name changed fix
		if ( get_option( 'wcd_templates' ) ) {
			$old_data = get_option( 'wcd_templates' );
			update_option( 'codesigner_templates', $old_data );
			delete_option( 'wcd_templates' );
		}

		// library cache option name changed fix
		if ( get_option( 'wl_library_cache' ) ) {
			$old_data = get_option( 'wl_library_cache' );
			update_option( 'codesigner_library_cache', $old_data );
			delete_option( 'wl_library_cache' );
		}

		// checkout fields option name changed fix
		if ( get_option( '_wcd_checkout_fields' ) ) {
			$old_data = get_option( '_wcd_checkout_fields' );
			update_option( 'codesigner_checkout_fields', $old_data );
			delete_option( '_wcd_checkout_fields' );
		}

		// help option name changed fix
		if ( get_option( 'wcd_help' ) ) {
			$old_data = get_option( 'wcd_help' );
			update_option( 'codesigner_help', $old_data );
			delete_option( 'wcd_help' );
		}

		// email designer module option name changed fix
		if ( get_option( 'wcd_email_designer' ) ) {
			$priv_data = get_option( 'wcd_email_designer' );
			update_option( 'codesigner_email_designer', $priv_data );
			delete_option( 'wcd_email_designer' );
		}

		// add to cart module and redirect checkout data
		if ( get_option( 'codesigner_tools' ) ) {
			$cart_text      = Helper::get_option( 'codesigner_tools', 'add-to-cart-text', '' );
			$redirect       = Helper::get_option( 'codesigner_tools', 'redirect_to_checkout', '' );
			$modules        = get_option( 'codesigner_modules', array() );
			$cart_text_data = array();

			if ( $cart_text ) {
				$tools                              = get_option( 'codesigner_tools', array() );
				$modules['cart-button-text']        = 'on';
				$cart_text_data['add-to-cart-text'] = $cart_text;

				update_option( 'codesigner_modules', $modules );
				update_option( 'codesigner_add_to_cart_text', $cart_text_data );
				unset( $tools['add-to-cart-text'] );
				update_option( 'codesigner_tools', $tools );
			}
			if ( $redirect ) {
				$tools                     = get_option( 'codesigner_tools', array() );
				$modules['skip-cart-page'] = 'on';

				update_option( 'codesigner_modules', $modules );
				unset( $tools['redirect_to_checkout'] );
				update_option( 'codesigner_tools', $tools );
			}
		}
	}
}
