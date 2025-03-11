<?php
/**
 * Plugin Name: CoDesigner
 * Description: <strong>CoDesigner (Formerly Woolementor)</strong> connects the #1 page builder plugin on the earth, <strong>Elementor</strong> with the most popular eCommerce plugin, <strong>WooCommerce</strong>.
 * Plugin URI: https://codexpert.io/codesigner/?utm_source=dashboard&utm_medium=plugins&utm_campaign=plugin-uri
 * Author: Codexpert, Inc
 * Version: 4.8.6.1
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Author URI: https://codexpert.io/?utm_source=dashboard&utm_medium=plugins&utm_campaign=author-uri
 * Text Domain: codesigner
 * Domain Path: /languages
 *
 * CoDesigner is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * CoDesigner is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace Codexpert\CoDesigner;

use Codexpert\Plugin\Widget;
use Codexpert\Plugin\Wizard;
use Codexpert\Plugin\Notice;
use Pluggable\Marketing\Survey;
use Pluggable\Marketing\Feature;
use Pluggable\Marketing\Deactivator;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 *
 * @package Plugin
 * @author Codexpert <hi@codexpert.io>
 */
final class Plugin {

	public $plugin;

	/**
	 * Plugin instance
	 *
	 * @access private
	 *
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * The constructor method
	 *
	 * @access private
	 *
	 * @since 0.9
	 */
	private function __construct() {

		/**
		 * Includes require_onced files
		 */
		$this->include();

		/**
		 * Defines constants
		 */
		$this->define();

		/**
		 * Runs actual hooks
		 */
		$this->hook();
	}

	/**
	 * Includes files
	 *
	 * @access private
	 *
	 * @uses composer
	 * @uses psr-4
	 */
	private function include() {
		require_once __DIR__ . '/inc/functions.php';
		require_once __DIR__ . '/vendor/autoload.php';
	}

	/**
	 * Define variables and constants
	 *
	 * @access private
	 *
	 * @uses get_plugin_data
	 * @uses plugin_basename
	 */
	private function define() {

		/**
		 * Define some constants
		 *
		 * @since 0.9
		 */
		define( 'CODESIGNER', __FILE__ );
		define( 'CODESIGNER_DIR', dirname( CODESIGNER ) );
		define( 'CODESIGNER_ASSETS', plugins_url( 'assets', CODESIGNER ) );
		define( 'CODESIGNER_DEBUG', apply_filters( 'codesigner_debug', true ) );
		define( 'CODESIGNER_LIB_URL', 'https://codexpert.io/codesigner-library/wp-json/templates/v3' );

		/**
		 * The plugin data
		 *
		 * @since 0.9
		 * @var $plugin
		 */
		$this->plugin               = array();
		$this->plugin['basename']   = plugin_basename( CODESIGNER );
		$this->plugin['file']       = CODESIGNER;
		$this->plugin['TextDomain'] = 'codesigner';
		$this->plugin['Version']    = '4.8.6.1';
		$this->plugin['Name']       = 'CoDesigner';
		$this->plugin['server']     = apply_filters( 'codesigner_server', 'https://my.pluggable.io' );
		$this->plugin['doc_id']     = 1960;
		$this->plugin['icon']       = CODESIGNER_ASSETS . '/img/icon-128.png';
		// $this->plugin['depends']    = array(
		// 	'woocommerce/woocommerce.php' => __( 'WooCommerce', 'codesigner' ),
		// 	'elementor/elementor.php'     => __( 'Elementor', 'codesigner' ),
		// );
	}

	/**
	 * Hooks
	 *
	 * @access private
	 *
	 * Executes main plugin features
	 *
	 * To add an action, use $instance->action()
	 * To apply a filter, use $instance->filter()
	 * To register a shortcode, use $instance->register()
	 * To add a hook for logged in users, use $instance->priv()
	 * To add a hook for non-logged in users, use $instance->nopriv()
	 *
	 * @return void
	 */
	private function hook() {

		if ( is_admin() ) :

			/**
			 * Admin facing hooks
			 */
			$admin = new App\Admin( $this->plugin );
			$admin->activate( 'install' );
			$admin->action( 'admin_footer', 'modal' );
			$admin->action( 'init', 'i18n' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->action( 'admin_menu', 'add_menus' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->action( 'admin_footer_text', 'footer_text' );
			$admin->action( 'after_setup_theme', 'setup' );
			$admin->action( 'plugins_loaded', 'settings_page_redirect' );
			$admin->filter( 'http_request_host_is_external', '__return_true', 10, 3 );
			$admin->action( 'plugins_loaded', 'admin_notices' );
			$admin->action( 'cx-plugin_after-nav-items', 'setting_navs_add_item' );
			$admin->action( 'cx-settings-heading', 'settings_heading' );
			$admin->filter( 'admin_body_class', 'admin_body_class' );
			$admin->activate( 'codesigner_widgets_activation' );
			$admin->activate( 'codesigner_modules_activation' );

			/**
			 * Settings related hooks
			 */
			$settings = new App\Settings( $this->plugin );
			$settings->action( 'plugins_loaded', 'init_menu', 11 );
			$settings->action( 'cx-settings-saved', 'reset', 10, 2 );
			$settings->action( 'admin_init', 'redirect_specific_admin_page' );
			$settings->action( "{$this->plugin['TextDomain']}_upgraded", 'migrate_settings', 10, 2 );

			/**
			 * Renders different notices
			 *
			 * @package Codexpert\Plugin
			 *
			 * @author Codexpert <hi@codexpert.io>
			 */
			$notice = new Notice( $this->plugin );

			/**
			 * Shows a popup window asking why a user is deactivating the plugin
			 *
			 * @package Pluggable\Marketing
			 *
			 * @version 3.12
			 *
			 * @author Codexpert <hi@codexpert.io>
			 */
			$deactivator = new Deactivator( $this->plugin );

			/**
			 * Alters featured plugins
			 *
			 * @package Pluggable\Marketing
			 *
			 * @version 3.12
			 *
			 * @author Codexpert <hi@codexpert.io>
			 */
			$feature = new Feature( $this->plugin, [ 'reserved' => [] ] );

			/**
			 * Asks to participate in a survey
			 *
			 * @package Pluggable\Marketing
			 *
			 * @version 3.12
			 *
			 * @author Codexpert <hi@codexpert.io>
			 */
			$survey = new Survey( $this->plugin );

		else : // ! is_admin() ?

			/**
			 * Front facing hooks
			 */
			$front = new App\Front( $this->plugin );
			$front->action( 'wp_footer', 'modal' );
			$front->action( 'wp_head', 'head' );
			$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
			$front->action( 'after_setup_theme', 'setup' );
			$front->action( 'admin_bar_menu', 'add_admin_bar', 70 );
			$front->filter( 'body_class', 'body_class' );
			$front->filter( 'woocommerce_checkout_fields', 'regenerate_fields' );
			$front->filter( 'woocommerce_product_add_to_cart_text', 'add_to_cart_text' );
			$front->filter( 'woocommerce_product_single_add_to_cart_text', 'add_to_cart_text' );
			$front->filter( 'woocommerce_add_to_cart_redirect', 'redirect_to_checkout' );
			$front->action( 'codesigner_after_main_content', 'collect_usage' );

		endif;

		/**
		 * Templates and library
		 */
		$library = new App\Library( $this->plugin );
		$library->action( 'elementor/ajax/register_actions', 'register_ajax_actions', 20 );
		$library->action( 'elementor/editor/before_enqueue_scripts', 'enqueue_scripts' );
		$library->action( 'elementor/preview/enqueue_styles', 'enqueue_scripts' );
		$library->action( 'elementor/editor/footer', 'print_template_views' );

		/**
		 * Widgets related hooks
		 */
		$widgets = new App\Widgets( $this->plugin );
		$widgets->action( 'elementor/widgets/widgets_registered', 'register_widgets' ); // for Elementor < 3.5.0
		$widgets->action( 'elementor/widgets/register', 'register_widgets' );
		$widgets->action( 'elementor/controls/controls_registered', 'register_controls' );
		$widgets->action( 'elementor/elements/categories_registered', 'register_category' );
		$widgets->action( 'elementor/editor/after_enqueue_scripts', 'enqueue_styles' );
		$widgets->action( 'elementor/frontend/the_content', 'the_content' );
		$widgets->action( 'pre_get_posts', 'set_filter_query' );
		$widgets->action( 'codesigner_shop_query_controls', 'shop_query_controls' );
		$widgets->filter( 'wcd_product_source_type', 'add_source_type' );
		// $widgets->filter('elementor/editor/localize_settings', 'promote_pro_elements');

		/**
		 * Modules related hooks
		 */
		$modules = new App\Modules( $this->plugin );
		$modules->action( 'plugins_loaded', 'init' );

		/**
		 * The setup wizard
		 */
		$wizard = new App\Wizard( $this->plugin );
		$wizard->action( 'admin_print_styles', 'enqueue_styles' );
		$wizard->action( 'admin_print_scripts', 'enqueue_scripts' );
		$wizard->action( 'plugins_loaded', 'render' );
		$wizard->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );

		/**
		 * Cron facing hooks
		 */
		$cron = new App\Cron( $this->plugin );
		$cron->activate( 'install' );
		$cron->deactivate( 'uninstall' );

		/**
		 * AJAX related hooks
		 */
		$ajax = new App\AJAX( $this->plugin );
		$ajax->priv( 'codesigner-docs_json', 'fetch_docs' );
		$ajax->all( 'add-to-wish', 'add_to_wish' );
		$ajax->all( 'add-variations-to-cart', 'add_variations_to_cart' );
		$ajax->all( 'multiple-product-add-to-cart', 'multiple_product_add_to_cart' );
		$ajax->priv( 'wcd-template-sync', 'template_sync' );
		$ajax->all( 'wl_single_insert_to_cart', 'wl_single_cart' );
		$ajax->all( 'codesigner_admin_notice', 'admin_notice' );
		$ajax->all( 'complete-setting-close', 'complete_setting_close' );
		$ajax->all( 'dismiss_notice_checkout', 'dismiss_notice_checkout' );
		$ajax->all( 'dismiss_notice_email', 'dismiss_notice_email' );
		$ajax->all( 'dismiss_notice_invoice', 'dismiss_notice_invoice' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @access public
	 */
	public function __clone() {}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @access public
	 */
	public function __wakeup() {}

	/**
	 * Instantiate the plugin
	 *
	 * @access public
	 *
	 * @return $_instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();
