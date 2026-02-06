<?php

namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Codexpert\CoDesigner\Helper;
use Codexpert\CoDesigner\Notice;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
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
	public $admin_url;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin  = $plugin;
		$this->slug    = $this->plugin['TextDomain'];
		$this->name    = $this->plugin['Name'];
		$this->server  = $this->plugin['server'];
		$this->version = $this->plugin['Version'];
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {

		if ( ! get_option( 'codesigner_version' ) ) {
			update_option( 'codesigner_version', $this->version );
		}

		if ( ! get_option( 'codesigner_install_time' ) ) {
			update_option( 'codesigner_install_time', date_i18n( 'U' ) );
		}
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'codesigner', false, CODESIGNER_DIR . '/languages/' );
	}

	public function add_body_class( $classes ) {

		$classes .= ' codesigner';
		$classes .= defined( 'CODESIGNER_PRO' ) ? ' codesigner-pro' : '';

		return $classes;
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {

		/**
		 * Start Admin notice With Pointers
		 */

		if ( current_user_can( 'administrator' ) ) {

			wp_enqueue_style( "{$this->slug}-admin-notice", plugins_url( '/assets/css/notice.css', CODESIGNER ), '', $this->version, 'all' );

			wp_enqueue_script( 'codesigner-admin-notice', CODESIGNER_ASSETS . '/js/notice.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_style( 'wp-pointer' );

			$pointers = array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'_wpnonce' => wp_create_nonce(),
			);

			wp_localize_script( 'codesigner-admin-notice', 'CODESIGNER_NOTICE', $pointers );
		}

		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		global $current_screen;

		/**
		 * Common Admin Dashboard CSS file
		 */
		wp_enqueue_style( "{$this->slug}-dashboard", plugins_url( "/assets/css/dashboard{$min}.css", CODESIGNER ), '', $this->version, 'all' );

		if ( strpos( $current_screen->base, $this->slug ) === false ) {
			return;
		}

		/**
		 * CSS files
		 */
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-email-designer", plugins_url( "/assets/css/email-designer{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-pro-features", plugins_url( "/assets/css/pro-features{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-widgets-settings", plugins_url( "/assets/css/widgets-settings{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-library", plugins_url( "/assets/css/library{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( "{$this->slug}-free-pro", plugins_url( "/assets/css/free-pro{$min}.css", CODESIGNER ), '', $this->version, 'all' );
		wp_enqueue_style( 'wp-pointer' );

		/**
		 * JS files
		 */
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CODESIGNER ), array( 'jquery' ), $this->version, true );
		wp_enqueue_script( "{$this->slug}-widgets-settings", plugins_url( "/assets/js/widgets-settings{$min}.js", CODESIGNER ), array( 'jquery' ), $this->version, true );

		wp_enqueue_script( 'wp-pointer' );
		$localized = array(
			'homeurl'    => get_bloginfo( 'url' ),
			'adminurl'   => admin_url(),
			'asseturl'   => CODESIGNER_ASSETS,
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'_wpnonce'   => wp_create_nonce(),
			'api_base'   => get_rest_url(),
			'rest_nonce' => wp_create_nonce( 'wp_rest' ),
		);

		wp_localize_script( $this->slug, 'CODESIGNER', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function add_menus() {
		add_menu_page( __( 'CoDesigner', 'codesigner' ), __( 'CoDesigner', 'codesigner' ), 'manage_options', $this->slug, '', CODESIGNER_ASSETS . '/img/icon.png', 58 );
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );
		$url             = add_query_arg( 'page', $this->slug, 'https://help.codexpert.io/docs/codesigner/' );

		$new_links = array(
			'settings' => sprintf( '<a href="%1$s">' . __( 'Docs', 'codesigner' ) . '</a>', esc_url( $url ) ),
		);
		$support   = array(
			'support' => sprintf( '<a href="%1$s">' . __( 'Support', 'codesigner' ) . '</a>', esc_url( 'https://help.codexpert.io/add-ticket/' ) ),
		);
		// if ( !defined( 'CODESIGNER_PRO' ) ) {
		// $new_links['codesigner-get-pro'] = '<a href="https://codexpert.io/codesigner/pricing/?utm_source=website&utm_medium=floating+bar&utm_campaign=black+friday+2024">' . __('Black Friday Sale (Up to 80% OFF)', 'cx-plugin') . '</a>';
		// }

		return array_merge( $support, $new_links, $links );
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {

		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['help'] = '<a href="'. esc_url('https://help.codexpert.io/') . '" target="_blank" class="cx-help">' . __( 'Help', 'codesigner' ) . '</a>';
		}

		return $plugin_meta;
	}

	public function footer_text( $text ) {
		$screen = get_current_screen();
		if ( ! $screen || $screen->parent_base != $this->slug ) {
			return $text;
		}

		// Translators: %1$s represents the plugin name, %2$s represents the URL to leave a rating, and %3$s represents the rating stars.
		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'codesigner' ), $this->name, esc_url( 'https://wordpress.org/support/plugin/woolementor/reviews/?filter=5#new-post' ), '⭐⭐⭐⭐⭐' );
	}

	/**
	 * Setup the instance
	 *
	 * @since 1.0
	 */
	public function setup() {
		add_image_size( 'codesigner-thumb', 400, 400, true );
	}

	/**
	 * Redirect
	 *
	 * @since 1.0
	 */
	public function settings_page_redirect() {
		if ( get_option( 'codesigner-activated' ) != 1 ) {
			update_option( 'codesigner-activated', 1 );
			wp_safe_redirect( admin_url( 'admin.php?page=codesigner' ) );
			exit();
		}
	}

	public function admin_notices() {
		$is_year_end_campaign_active = apply_filters( 'is_year_end_campaign_active', false );
		
		if ( $is_year_end_campaign_active ) {
			return;
		}

		if ( ! defined( 'CODESIGNER_PRO' ) ) {
			$notice_id	 		= 'codesigner-year_end_deal_campaign-dec-21';
			$url        		= 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=dashboard&utm_campaign=year-end';
			$discount_img 		= CODESIGNER_ASSETS . '/img/sale-banner/discount.gif';

			$dismissed_time 	= get_option( 'codesigner-year_end_deal_campaign-dec-21_dismissed' );
			$current_time 		= date_i18n( 'U' );
			$five_days    		= 5 * DAY_IN_SECONDS;

			if( $dismissed_time !== false && $current_time <= ( $dismissed_time + $five_days ) ) {
				return;
			}

			$sale_notice = new Notice( $notice_id );
			$start_timestamp  = strtotime( '2025-12-20 23:59:59' );
			$expiry_timestamp = strtotime( '2026-1-10 23:59:00' );
			$sale_notice->set_start_time( $start_timestamp );
			$sale_notice->set_expiry( $expiry_timestamp );
            $sale_notice->set_screens( array( 'dashboard', 'codesigner' ) );

			$message = '
				<div class="codesigner-year-end-deals-notice">
					<div class="discount-image">
						<img src="' . esc_url( $discount_img ) . '" alt="Codesigner" class="wc-affiliate-notice-image" >
					</div>

					<div class="year-end-content">
						<p class="title">' . __( 'Celebrate Year-End with CoDesigner!', 'codesigner' ) . '</p>
						<p class="description">' . __( 'Get 50% OFF and design stunning WooCommerce stores effortlessly with Elementor+CoDesigner Pro!', 'codesigner' ) . '</p>
						<a href="' . esc_url( $url ) . '" class="notice-cta-button" data-id="' . esc_attr( $notice_id ) . '" target="_blank">
						' . __( 'Save 50% Now', 'codesigner' ) . '
						</a>
					</div>
				</div>
			';

			$sale_notice->set_message( $message );
			$sale_notice->set_screens( array( 'dashboard', 'toplevel_page_codesigner' ) );
			$sale_notice->render();

			add_filter( 'is_year_end_campaign_active', '__return_true' );
		}

		if( get_option( 'codesigner_setup_done' ) != 1 ) {
			/**
			 * Setup wizard notice
			 */
			$wizard_notice = new Notice( 'codesigner_setup_wizard' );

			$message = sprintf(
			    '<p>%1$s <strong>%2$s</strong>! 🎉<br>%3$s <a href="%4$s"><strong>%5$s</strong></a> %6$s 🚀</p>',
			    esc_html__( 'Congratulations on installing', 'codesigner' ),
			    esc_html__( 'CoDesigner', 'codesigner' ),
			    esc_html__( "You're just a few steps away from launching your store.", 'codesigner' ),
			    esc_url( add_query_arg( [ 'page' => 'codesigner_setup' ], admin_url( 'admin.php' ) ) ),
			    esc_html__( 'Click here', 'codesigner' ),
			    esc_html__( 'to start the setup wizard and bring your store to life!', 'codesigner' )
			);

			$wizard_notice->set_message( $message );
			$wizard_notice->render();
		}
	}

	public function setting_navs_add_item( $settings ) {
		$utm      = array(
			'utm_source'   => 'dashboard',
			'utm_medium'   => 'settings',
			'utm_campaign' => 'pro-tab',
		);
		$pro_link = add_query_arg( $utm, 'https://codesigner.dev/pricing?utm_source=inplugin&utm_medium=button&utm_campaign=bfcm' );

		if ( ! wcd_is_pro_activated() && $settings->config['id'] == 'codesigner' ) {
			echo '<li><a href="' . esc_url( $pro_link ) . '">Get Pro</a></li>';
		}
	}

	public function admin_body_class( $classes ) {

		if ( defined( 'CODESIGNER_PRO' ) ) {
			$classes .= ' wl-has_pro';
		} else {
			$classes .= ' wl-no_pro';
		}

		return $classes;
	}

	public function modal() {
		echo '
		<div id="codesigner-modal" style="display: none">
			<img id="codesigner-modal-loader" alt="Loader" src="' . esc_attr( CODESIGNER_ASSETS . '/img/loader.gif' ) . '" />
		</div>';
	}

	// Turn on all widgets while activation
	public function codesigner_widgets_activation() {

		if ( ! get_option( 'codesigner_widgets' ) ) {

			$codesigner_widgets = array(
				'shop-classic'                   => 'on',
				'shop-standard'                  => 'on',
				'shop-flip'                      => 'on',
				'shop-trendy'                    => 'on',
				'shop-curvy'                     => 'on',
				'shop-curvy-horizontal'          => 'on',
				'shop-slider'                    => 'on',
				'shop-accordion'                 => 'on',
				'shop-table'                     => 'on',
				'shop-beauty'                    => 'on',
				'shop-smart'                     => 'on',
				'shop-minimal'                   => 'on',
				'shop-wix'                       => 'on',
				'shop-shopify'                   => 'on',
				'filter-horizontal'              => 'on',
				'filter-vertical'                => 'on',
				'filter-advance'                 => 'on',
				'product-title'                  => 'on',
				'product-price'                  => 'on',
				'product-rating'                 => 'on',
				'product-breadcrumbs'            => 'on',
				'product-short-description'      => 'on',
				'product-variations'             => 'on',
				'product-add-to-cart'            => 'on',
				'product-sku'                    => 'on',
				'product-stock'                  => 'on',
				'product-additional-information' => 'on',
				'product-tabs'                   => 'on',
				'product-dynamic-tabs'           => 'on',
				'product-meta'                   => 'on',
				'product-categories'             => 'on',
				'product-tags'                   => 'on',
				'product-thumbnail'              => 'on',
				'product-gallery'                => 'on',
				'product-add-to-wishlist'        => 'on',
				'product-comparison-button'      => 'on',
				'ask-for-price'                  => 'on',
				'quick-checkout-button'          => 'on',
				'product-barcode'                => 'on',
				'my-account'                     => 'on',
				'my-account-advanced'            => 'on',
				'wishlist'                       => 'on',
				'customer-reviews-classic'       => 'on',
				'customer-reviews-standard'      => 'on',
				'customer-reviews-trendy'        => 'on',
				'faqs-accordion'                 => 'on',
				'tabs-basic'                     => 'on',
				'tabs-classic'                   => 'on',
				'tabs-fancy'                     => 'on',
				'tabs-beauty'                    => 'on',
				'gradient-button'                => 'on',
				'sales-notification'             => 'on',
				'category'                       => 'on',
				'basic-menu'                     => 'on',
				'dynamic-tabs'                   => 'on',
				'menu-cart'                      => 'on',
				'product-comparison'             => 'on',
				'image-comparison'               => 'on',
				'pricing-table-advanced'         => 'on',
				'pricing-table-basic'            => 'on',
				'pricing-table-regular'          => 'on',
				'pricing-table-smart'            => 'on',
				'pricing-table-fancy'            => 'on',
				'related-products-classic'       => 'on',
				'related-products-standard'      => 'on',
				'related-products-flip'          => 'on',
				'related-products-trendy'        => 'on',
				'related-products-curvy'         => 'on',
				'related-products-accordion'     => 'on',
				'related-products-table'         => 'on',
				'gallery-fancybox'               => 'on',
				'gallery-lc-lightbox'            => 'on',
				'gallery-box-slider'             => 'on',
				'cart-items'                     => 'on',
				'cart-items-classic'             => 'on',
				'cart-overview'                  => 'on',
				'coupon-form'                    => 'on',
				'floating-cart'                  => 'on',
				'billing-address'                => 'on',
				'shipping-address'               => 'on',
				'order-notes'                    => 'on',
				'order-review'                   => 'on',
				'order-pay'                      => 'on',
				'payment-methods'                => 'on',
				'thankyou'                       => 'on',
				'checkout-login'                 => 'on',
				'email-header'                   => 'on',
				'email-footer'                   => 'on',
				'email-item-details'             => 'on',
				'email-billing-addresses'        => 'on',
				'email-shipping-addresses'       => 'on',
				'email-customer-note'            => 'on',
				'email-order-note'               => 'on',
				'email-description'              => 'on',
				'email-reminder'                 => 'on',
			);

			add_option( 'codesigner_widgets', $codesigner_widgets );
		}
	}

	// Turn on all modules while activation
	public function codesigner_modules_activation() {

		if ( ! get_option( 'codesigner_modules' ) ) {

			$codesigner_modules = array(
				'product-brands'         => 'on',
				'cart-button-text'       => 'on',
				'skip-cart-page'         => 'on',
				'variation-swatches'     => 'on',
				'flash-sale'             => 'on',
				'partial-payment'        => 'on',
				'backorder'              => 'on',
				'preorder'               => 'on',
				'bulk-purchase-discount' => 'on',
				'single-product-ajax'    => 'on',
				'badges'                 => 'on',
				'currency-switcher'      => 'on',
			);

			add_option( 'codesigner_modules', $codesigner_modules );
		}
	}

	public function maybe_redirect() {
		if( get_option( 'codesigner_setup_done' ) != 1 ) {
			wp_safe_redirect( add_query_arg( [ 'page' => 'codesigner_setup' ], admin_url( 'admin.php' ) ) );
		}
	}

	public function settings_heading( $config ) {

		$screen = get_current_screen();
		$screen_ids = array( 'toplevel_page_codesigner', 'codesigner_page_codesigner-widgets', 'codesigner_page_codesigner-modules', 'codesigner_page_codesigner-templates', 'codesigner_page_codesigner-tools' );

		if( ! ( $screen && in_array( $screen->id, $screen_ids ) ) ) {
			return;
		}

		$banner 	= CODESIGNER_ASSETS . '/img/general/get-started/rockat-icon.png';
		$logo 		= CODESIGNER_ASSETS . '/img/icon.png';

		$current_page = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : 'codesigner';

		$tabs 		= [
			[
				'id'	=> 'codesigner',
				'label' => 'Getting Started'
			],
			[
				'id' 	=> defined( 'CODESIGNER_PRO' ) ? 'codesigner' : 'codesigner-widgets',
				'label' => 'Widgets',
			],
			[
				'id' 	=> 'codesigner-modules',
				'label' => 'Modules',
			],
			[
				'id' 	=> 'codesigner-templates',
				'label' => 'Templates',
			],
			[
				'id' 	=> 'codesigner-tools',
				'label' => 'Tools',
			]
		];

		if( defined( 'CODESIGNER_PRO' ) ) {
			array_shift( $tabs );

			$tabs[] = [
				'id'	=> 'codesigner-pro',
				'label' => 'License',
			];
		}

		?>
			<header class="cd-started-page-header">
				<div class="cd-logo-and-tabs">
					<!-- logo here -->
					<div class="cd-logo"><img src="<?php echo esc_url( $logo ); ?>" /><span><?php esc_html_e('CoDesigner', 'codesigner' ) ?></span></div>
					<!-- tab Item -->
					<ul>
						<?php
							foreach ( $tabs as $tab ) {
								printf( '<li class="%s"><a href="%s">%s</a></li>',
								$current_page == $tab['id'] ? 'active-tab' : '',
								esc_url( add_query_arg( 'page', $tab['id'], admin_url( 'admin.php' ) ) ),
								esc_html( $tab['label'] ) );
							}
						?>
					</ul>
				</div>

				<?php if( ! defined( 'CODESIGNER_PRO' ) ) : ?>
					<!-- Upgraded button -->

					<a class="cd-upgraded-btn" target="_blank" href="<?php echo esc_url( 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=button&utm_campaign=year-end' ); ?>"> <img src="<?php echo esc_url( $banner ); ?>" alt=""> <?php esc_html_e( 'Get Pro Now', 'codesigner' ); ?></a>
				<?php else: ?>
					<div class="cd-btn-wrapper">
						<a href="<?php echo esc_url( 'https://help.codexpert.io/docs/codesigner' ); ?>" class="cd-btn active"><?php esc_html_e( 'Documentation', 'codesigner' ); ?></a>
						<a href="<?php echo esc_url( 'https://help.pluggable.io/' ); ?>" class="cd-btn"><?php esc_html_e( 'Get Support', 'codesigner' ); ?></a>
					</div>
				<?php endif; ?>
			</header>
		<?php
	}
}
