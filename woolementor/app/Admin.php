<?php

namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Codexpert\CoDesigner\Helper;

/**
 * if accessed directly, exit.
 */
if (! defined('ABSPATH')) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Codexpert <hi@codexpert.io>
 */
class Admin extends Base {

	public $plugin;
	public $slug;
	public $name;
	public $server;
	public $version;

	/**
	 * Constructor function
	 */
	public function __construct($plugin){
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install(){

		if (! get_option('codesigner_version')) {
			update_option('codesigner_version', $this->version);
		}

		if (! get_option('codesigner_install_time')) {
			update_option('codesigner_install_time', date_i18n('U'));
		}
	}

	/**
	 * Internationalization
	 */
	public function i18n(){
		load_plugin_textdomain('codesigner', false, CODESIGNER_DIR . '/languages/');
	}

	public function upgrade(){
		$current_time = date_i18n('U');
		if( ! get_option('codesigner_black_notice') ){
			foreach ( codesigner_notices_values() as $id => $notice ) {
				$data = [
					'from' => $notice['from'],
					'to' => $notice['to']
				];
				$expiration_duration 	= $notice['to'] - $current_time; 
				set_transient( $id, $data,  $expiration_duration );
			}
			update_option( 'codesigner_black_notice', 1 );
		}
		
		if (get_option('codesigner_install_time') == '') {
			update_option('codesigner_install_time', date_i18n('U'));
		}
		if ($this->version == ($old_version = get_option("{$this->slug}_db-version"))) return;

		update_option("{$this->slug}_db-version", $this->version, false);
		update_option('codesigner_update_time', date_i18n('U'));

		do_action("{$this->slug}_upgraded", $this->version, $old_version);
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts(){

		/**
		 * Start Admin notice With Pointers
		 */

		if (current_user_can('administrator')) {

			wp_enqueue_style("{$this->slug}-admin-notice", plugins_url("/assets/css/notice.css", CODESIGNER), '', $this->version, 'all');

			wp_enqueue_script('codesigner-admin-notice', CODESIGNER_ASSETS . '/js/notice.js', ['jquery'], $this->version, true);
			wp_enqueue_style('wp-pointer');

			$pointers = [
				'ajaxurl'		=> admin_url('admin-ajax.php'),
				'_wpnonce'		=> wp_create_nonce(),
			];

			wp_localize_script('codesigner-admin-notice', 'CODESIGNER_NOTICE', $pointers);
		}

		$min = defined('CODESIGNER_DEBUG') && CODESIGNER_DEBUG ? '' : '.min';

		global $current_screen;

		/**
		 * Common Admin Dashboard CSS file
		 */
		wp_enqueue_style("{$this->slug}-dashboard", plugins_url("/assets/css/dashboard{$min}.css", CODESIGNER), '', $this->version, 'all');

		if (strpos($current_screen->base, $this->slug) === false) return;

		/**
		 * CSS files
		 */		
		wp_enqueue_style($this->slug, plugins_url("/assets/css/admin{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style("{$this->slug}-email-designer", plugins_url("/assets/css/email-designer{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style("{$this->slug}-pro-features", plugins_url("/assets/css/pro-features{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style("{$this->slug}-widgets-settings", plugins_url("/assets/css/widgets-settings{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style("{$this->slug}-library", plugins_url("/assets/css/library{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style("{$this->slug}-free-pro", plugins_url("/assets/css/free-pro{$min}.css", CODESIGNER), '', $this->version, 'all');
		wp_enqueue_style('wp-pointer');


		/**
		 * JS files
		 */
		wp_enqueue_script($this->slug, plugins_url("/assets/js/admin{$min}.js", CODESIGNER), ['jquery'], $this->version, true);
		wp_enqueue_script("{$this->slug}-widgets-settings", plugins_url("/assets/js/widgets-settings{$min}.js", CODESIGNER), ['jquery'], $this->version, true);

		wp_enqueue_script('wp-pointer');
		$localized = [
			'homeurl'		=> get_bloginfo('url'),
			'adminurl'		=> admin_url(),
			'asseturl'		=> CODESIGNER_ASSETS,
			'ajaxurl'		=> admin_url('admin-ajax.php'),
			'_wpnonce'		=> wp_create_nonce(),
			'api_base'		=> get_rest_url(),
			'rest_nonce'	=> wp_create_nonce('wp_rest'),
			'cd_welcome'	=> $this->get_pointers(),
		];

		wp_localize_script($this->slug, 'CODESIGNER', apply_filters("{$this->slug}-localized", $localized));
	}

	public function add_menus(){
		add_menu_page(__('CoDesigner', 'codesigner'), __('CoDesigner', 'codesigner'), 'manage_options', $this->slug, '', CODESIGNER_ASSETS . '/img/icon.png', 58);
	}

	public function action_links($links){
		$this->admin_url = admin_url('admin.php');
		$url = add_query_arg( 'page', $this->slug, 'https://help.codexpert.io/docs/codesigner/' );

		$new_links = [
			'settings'	=> sprintf('<a href="%1$s">' . __('Docs', 'codesigner') . '</a>', $url),
		];
		$support = [
			'support'	=> sprintf('<a href="%1$s">' . __('Support', 'codesigner') . '</a>', 'https://help.codexpert.io/add-ticket/'),
		];
		if ( !defined( 'CODESIGNER_PRO' ) ) {
			$new_links['codesigner-get-pro'] = '<a href="https://codexpert.io/codesigner/pricing/?utm_source=website&utm_medium=floating+bar&utm_campaign=black+friday+2024">' . __('Black Friday Sale (Up to 80% OFF)', 'cx-plugin') . '</a>';
		}

		return array_merge( $support, $new_links, $links);
	}

	public function plugin_row_meta($plugin_meta, $plugin_file){

		if ($this->plugin['basename'] === $plugin_file) {
			$plugin_meta['help'] = '<a href="https://help.codexpert.io/" target="_blank" class="cx-help">' . __('Help', 'codesigner') . '</a>';
		}

		return $plugin_meta;
	}

	public function footer_text($text){
		if (get_current_screen()->parent_base != $this->slug) return $text;

		// Translators: %1$s represents the plugin name, %2$s represents the URL to leave a rating, and %3$s represents the rating stars.
		return sprintf(__('If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'codesigner'), $this->name, "https://wordpress.org/support/plugin/woolementor/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐');
	}

	/**
	 * Setup the instance
	 *
	 * @since 1.0
	 */
	public function setup(){
		add_image_size('codesigner-thumb', 400, 400, true);
	}

	/**
	 * Redirect
	 *
	 * @since 1.0
	 */
	public function settings_page_redirect(){
		if (get_option('codesigner-activated') != 1) {
			update_option('codesigner-activated', 1);
			wp_safe_redirect(admin_url('admin.php?page=codesigner'));
			exit();
		}
	}

	public function admin_notices(){

		if ( !defined( 'CODESIGNER_PRO' ) && current_user_can( 'manage_options' ) ) {
			
			$current_screen = get_current_screen()->base;
			if ( $current_screen == 'dashboard' || $current_screen == 'toplevel_page_codesigner' ) {
				if( isset( $_GET['dismiss'] ) && array_key_exists( $_GET['dismiss'], codesigner_notices_values() ) ) {
					delete_transient( sanitize_text_field( $_GET['dismiss'] ) );
				}
				foreach ( codesigner_notices_values() as $id => $notice ) {
					$transient 		= get_transient( $id );
					$current_time 	= date_i18n( 'U' );
					if ( $transient && $transient[ 'from' ] < $current_time && $current_time < $transient[ 'to' ] ) {
						printf(
							'<div class="notice notice-info is-dismissible codesigner-dismissible-notice">
								<p>
									<a class="notice-dismiss" href="%1$s"></a>
								</p>
								<div class="codesigner-dismissible-notice-content">
									%5$s
									<div class="button-wrapper">
										<a href="%4$s" class="codesigner-dismissible-notice-button" data-id="%2$s">%3$s</a>
									</div>
								</div>
							</div>',
							esc_url( add_query_arg( 'dismiss', $id ) ),
							esc_attr( $id ),
							esc_html( $notice[ 'button' ] ),
							esc_url( $notice[ 'url' ] ),
							
							get_codesigner_countdown_html( $notice[ 'from' ],  $notice[ 'countdown_to' ]  )
						);
						break;	
					}
				}
			}			
		}

	}

	public function setting_navs_add_item($settings) {
		$utm			= ['utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab'];
		$pro_link		= add_query_arg($utm, 'https://codexpert.io/codesigner/#pricing');

		if (! wcd_is_pro_activated() && $settings->config['id'] == 'codesigner') {
			echo '<li><a href="' . esc_url($pro_link) . '">Get Pro</a></li>';
		}
	}

	public function admin_body_class($classes){

		if (defined('CODESIGNER_PRO')) {
			$classes .= ' wl-has_pro';
		} else {
			$classes .= ' wl-no_pro';
		}

		return $classes;
	}

	public function modal()	{
		echo '
		<div id="codesigner-modal" style="display: none">
			<img id="codesigner-modal-loader" alt="Loader" src="' . esc_attr(CODESIGNER_ASSETS . '/img/loader.gif') . '" />
		</div>';
	}
	/**
	 * Returns all WP pointers
	 *
	 * @return array
	 */
	public function get_pointers(){

		$mother_day_notice 	= get_option('mother_day_pointer_dismiss');
		$current_screen 	= get_current_screen()->base;
		$current_user_can 	= current_user_can('manage_options');
		$current_time 		= wp_date('U');
		$start_and_end_time = mothers_day_promo_start_and_end_time($current_time);

		$pointers = '';

		if (
			(! $mother_day_notice)
			&& ($start_and_end_time)
			&& ! defined('CODESIGNER_PRO')
		) {

			$pointers = array(
				'target' 	=> '#toplevel_page_codesigner',
				'edge' 		=> 'left',
				'align' 	=> 'right',
				'content' 	=> ' <input type="hidden" class="cx-nonce" value="' . wp_create_nonce() . '" name=""> <h3>A Mother\'s Day Gift for You🎁</h3><p> 🚀Enjoy up to <b> 50% OFF </b> Pro Plans! Limited Time Only⌛ <a  class="cd-notice_ahref" href="' . esc_url('https://codexpert.io/codesigner/mothers-day-sale/') . '" target="_blank"> <button class="cx-dismiss-popup" >Grab Now</button></a></p> </p>',
				'action' 	=> 'codesigner_admin_notice',
			);
		}


		return $pointers;
	}
	/**
	 * Get all dismissed notices, or check for one specific notice
	 *
	 * @param string  $notice_name  Optional. Check if specified notice is dismissed.
	 *
	 * @return bool|array
	 */
	function get_dismissed_notices($notice_name = ''){
		$notices = $this->options['dismissed_notices'];

		if (empty($notice_name)) {
			return $notices;
		} else {
			if (empty($notices[$notice_name])) {
				return false;
			} else {
				return true;
			}
		}
	}

	// Turn on all widgets while activation
	public function codesigner_widgets_activation() {

		if ( ! get_option( 'codesigner_widgets' ) ) {

			$codesigner_widgets = array(
			    'shop-classic' 						=> 'on',
			    'shop-standard' 					=> 'on',
			    'shop-flip' 						=> 'on',
			    'shop-trendy' 						=> 'on',
			    'shop-curvy' 						=> 'on',
			    'shop-curvy-horizontal'				=> 'on',
			    'shop-slider' 						=> 'on',
			    'shop-accordion'					=> 'on',
			    'shop-table' 						=> 'on',
			    'shop-beauty' 						=> 'on',
			    'shop-smart' 						=> 'on',
			    'shop-minimal' 						=> 'on',
			    'shop-wix' 							=> 'on',
			    'shop-shopify' 						=> 'on',
			    'filter-horizontal'					=> 'on',
			    'filter-vertical'					=> 'on',
			    'filter-advance'					=> 'on',
			    'product-title'						=> 'on',
			    'product-price'						=> 'on',
			    'product-rating'					=> 'on',
			    'product-breadcrumbs'				=> 'on',
			    'product-short-description'			=> 'on',
			    'product-variations'				=> 'on',
			    'product-add-to-cart'				=> 'on',
			    'product-sku'						=> 'on',
			    'product-stock'						=> 'on',
			    'product-additional-information'	=> 'on',
			    'product-tabs'						=> 'on',
			    'product-dynamic-tabs'				=> 'on',
			    'product-meta'						=> 'on',
			    'product-categories'				=> 'on',
			    'product-tags'						=> 'on',
			    'product-thumbnail'					=> 'on',
			    'product-gallery'					=> 'on',
			    'product-add-to-wishlist'			=> 'on',
			    'product-comparison-button'			=> 'on',
			    'ask-for-price'						=> 'on',
			    'quick-checkout-button'				=> 'on',
			    'product-barcode'					=> 'on',
			    'my-account'						=> 'on',
			    'my-account-advanced'				=> 'on',
			    'wishlist'							=> 'on',
			    'customer-reviews-classic'			=> 'on',
			    'customer-reviews-standard'			=> 'on',
			    'customer-reviews-trendy'			=> 'on',
			    'faqs-accordion'					=> 'on',
			    'tabs-basic'						=> 'on',
			    'tabs-classic'						=> 'on',
			    'tabs-fancy'						=> 'on',
			    'tabs-beauty'						=> 'on',
			    'gradient-button'					=> 'on',
			    'sales-notification'				=> 'on',
			    'category'							=> 'on',
			    'basic-menu'						=> 'on',
			    'dynamic-tabs'						=> 'on',
			    'menu-cart'							=> 'on',
			    'product-comparison'				=> 'on',
			    'image-comparison'					=> 'on',
			    'pricing-table-advanced'			=> 'on',
			    'pricing-table-basic'				=> 'on',
			    'pricing-table-regular'				=> 'on',
			    'pricing-table-smart'				=> 'on',
			    'pricing-table-fancy'				=> 'on',
			    'related-products-classic'			=> 'on',
			    'related-products-standard'			=> 'on',
			    'related-products-flip'				=> 'on',
			    'related-products-trendy'			=> 'on',
			    'related-products-curvy'			=> 'on',
			    'related-products-accordion'		=> 'on',
			    'related-products-table'			=> 'on',
			    'gallery-fancybox'					=> 'on',
			    'gallery-lc-lightbox'				=> 'on',
			    'gallery-box-slider'				=> 'on',
			    'cart-items'						=> 'on',
			    'cart-items-classic'				=> 'on',
			    'cart-overview'						=> 'on',
			    'coupon-form'						=> 'on',
			    'floating-cart'						=> 'on',
			    'billing-address'					=> 'on',
			    'shipping-address'					=> 'on',
			    'order-notes'						=> 'on',
			    'order-review'						=> 'on',
			    'order-pay'							=> 'on',
			    'payment-methods'					=> 'on',
			    'thankyou'							=> 'on',
			    'checkout-login'					=> 'on',
			    'email-header'						=> 'on',
			    'email-footer'						=> 'on',
			    'email-item-details'				=> 'on',
			    'email-billing-addresses'			=> 'on',
			    'email-shipping-addresses'			=> 'on',
			    'email-customer-note'				=> 'on',
			    'email-order-note'					=> 'on',
			    'email-description'					=> 'on',
			    'email-reminder'					=> 'on',
		    );

	    	add_option( 'codesigner_widgets', $codesigner_widgets );
	    }
	}

	// Turn on all modules while activation
	public function codesigner_modules_activation() {

		if ( ! get_option( 'codesigner_modules' ) ) {

			$codesigner_modules = array(
				'product-brands' => 'on',
				'cart-button-text' => 'on',
				'skip-cart-page' => 'on',
				'variation-swatches' => 'on',
				'flash-sale' => 'on',
				'partial-payment' => 'on',
				'backorder' => 'on',
				'preorder' => 'on',
				'bulk-purchase-discount' => 'on',
				'single-product-ajax' => 'on',
				'badges' => 'on',
				'currency-switcher' => 'on',
			);

	        add_option( 'codesigner_modules', $codesigner_modules );
	    }
	}
}
