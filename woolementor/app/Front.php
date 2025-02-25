<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Codexpert\CoDesigner\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author Codexpert <hi@codexpert.io>
 */
class Front extends Base {

	public $plugin;

	public $slug;

	public $name;

	public $version;

	public $assets;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin  = $plugin;
		$this->slug    = $this->plugin['TextDomain'];
		$this->name    = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
		$this->assets  = CODESIGNER_ASSETS;
	}

	public function head() {}

	public function add_admin_bar( $admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$admin_bar->add_menu(
			array(
				'id'    => $this->slug,
				'title' => $this->name,
				'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
				'meta'  => array(
					'title' => $this->name,
				),
			)
		);
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_enqueue_style( $this->slug, "{$this->assets}/css/front{$min}.css", '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, "{$this->assets}/js/front{$min}.js", array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'codesigner-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0', 'all' );
		wp_enqueue_style( 'font-awesome-free', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', '', $this->version, 'all' );

		// slick
		wp_register_style( 'slick', "{$this->assets}/third-party/slick/slick.css", '', '1.8.1', 'all' );
		wp_register_script( 'slick', "{$this->assets}/third-party/slick/slick.min.js", array( 'jquery' ), '1.8.1', true );

		// box-slider
		wp_register_script( 'modernizr', "{$this->assets}/third-party/box-slider/modernizr.min.js", array( 'jquery' ), $this->version, true );
		wp_register_script( 'box-slider', "{$this->assets}/third-party/box-slider/box-slider-all.jquery.min.js", array( 'jquery' ), $this->version, true );

		// lc_lightbox
		wp_register_style( 'lc_lightbox', "{$this->assets}/third-party/lc_lightbox/lc_lightbox.min.css", '', $this->version, 'all' );
		wp_register_style( 'minimal', "{$this->assets}/third-party/lc_lightbox/minimal.min.css", '', $this->version, 'all' );
		wp_register_script( 'lc_lightbox', "{$this->assets}/third-party/lc_lightbox/lc_lightbox.lite.min.js", array( 'jquery' ), $this->version, true );

		// fancybox
		wp_register_style( 'fancybox', "{$this->assets}/third-party/fancybox/jquery.fancybox.min.css", '', '3.5.7', 'all' );
		wp_register_script( 'fancybox', "{$this->assets}/third-party/fancybox/jquery.fancybox.min.js", array( 'jquery' ), '3.5.7', true );

		// DataTables
		wp_register_style( 'dataTables', "{$this->assets}/third-party/dataTables/jquery.dataTables.min.css", '', '1.10.20', 'all' );
		wp_register_script( 'dataTables', "{$this->assets}/third-party/dataTables/jquery.dataTables.min.js", array( 'jquery' ), '1.10.20', true );

		// chosen
		wp_register_style( 'chosen', "{$this->assets}/third-party/chosen/chosen.min.css", '', '1.8.7', 'all' );
		wp_register_script( 'chosen', "{$this->assets}/third-party/chosen/chosen.jquery.min.js", array( 'jquery' ), '1.8.7', true );

		// enqueue stylesheet
		wp_enqueue_style( "{$this->slug}-grid-system", "{$this->assets}/css/cx-grid{$min}.css", '', $this->version, 'all' );

		// theme compatibilty
		if ( file_exists( CODESIGNER_DIR . '/assets/css/themes/' . ( $template = get_stylesheet() ) . "{$min}.css" ) ) {
			wp_enqueue_style( "{$this->slug}-{$template}", "{$this->assets}/css/themes/{$template}{$min}.css", '', $this->version, 'all' );
		}

		$localized = array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'_wpnonce'      => wp_create_nonce( $this->slug ),
			'rest_nonce'    => wp_create_nonce( 'wp_rest' ),
			'widgets'       => wcd_active_widgets(),
			'min_price'     => floor( $min_price = wcd_price_limit( 'min' ) ),
			'max_price'     => ceil( $max_price = wcd_price_limit( 'max' ) ),
			'cart_url'      => function_exists( 'WC' ) ? wc_get_cart_url() : '',
			'crnt_min'      => isset( $_GET['filter']['min_price'] ) ? sanitize_text_field( $_GET['filter']['min_price'] ) : floor( $min_price ),
			'crnt_max'      => isset( $_GET['filter']['max_price'] ) ? sanitize_text_field( $_GET['filter']['max_price'] ) : ceil( $max_price ),
			'pro_installed' => wcd_is_pro(),
			'pro_activated' => wcd_is_pro_activated(),
		);

		wp_localize_script( $this->slug, 'CODESIGNER', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function modal() {
		?>
			<div id="codesigner-modal" style="display: none">
				<img id="codesigner-modal-loader" alt="Loader" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/loader.gif' ); ?>" />
			</div>
		<?php
	}

	/**
	 * Adds a class to the <body> tag
	 *
	 * @since 1.0
	 */
	public function body_class( $classes ) {
		$classes[] = $this->slug;
		$classes[] = 'wl';

		if ( wp_is_mobile() ) {
			$classes[] = 'wl-mobile';
		}

		if ( ! in_array( 'woocommerce', $classes ) ) {
			$classes[] = 'woocommerce';
		}

		/**
		 * @since 3.15.4
		 */
		if ( ! in_array( ( $template = get_stylesheet() ), $classes ) ) {
			$classes[] = $template;
		}

		return $classes;
	}

	/**
	 * Re-generate checkout fields
	 *
	 * @since 1.0
	 */
	public function regenerate_fields( $fields ) {

		if ( ! wcd_is_pro() ) {
			return $fields;
		}

		/**
		 * If it contains the WooCommerce shortcode, exit
		 *
		 * @since 3.0.0
		 */
		global $post;
		if ( has_shortcode( $post->post_content, 'woocommerce_checkout' ) ) {
			return $fields;
		}

		/**
		 * @since 1.3.2
		 */
		$_checkout_fields = get_option( '_wcd_checkout_fields', array() );

		foreach ( $_checkout_fields as $section => $_fields ) {
			if ( count( $_fields ) > 0 ) {
				foreach ( $_fields as $_field ) {
					$fields[ $section ][ $_field[ "{$section}_input_name" ] ] = array(
						'label'        => $_field[ "{$section}_input_label" ],
						'required'     => $_field[ "{$section}_input_required" ],
						'class'        => $_field[ "{$section}_input_class" ],
						'autocomplete' => $_field[ "{$section}_input_autocomplete" ],
						'type'         => $_field[ "{$section}_input_type" ],
					);
				}
			}
		}

		return $fields;
	}

	public function add_to_cart_text( $default_text ) {
		global $product;

		$text = Helper::get_option( 'codesigner_tools', 'add-to-cart-text' );
		if ( $text == '' ) {
			return $default_text;
		}
		return $text;
	}

	public function redirect_to_checkout( $url ) {
		$enable = Helper::get_option( 'codesigner_tools', 'redirect_to_checkout' );
		if ( $enable != 'on' ) {
			return $url;
		}

		return wc_get_checkout_url();
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
	 * Collect usage data
	 *
	 * @since 3.15
	 */
	public function collect_usage( $widget ) {

		$usage = get_option( '_codesigner-widget-usage', array() );
		if ( ! isset( $widget->id ) ) {
			return;
		}
		if ( in_array( $widget->id, $usage ) ) {
			return;
		}

		$usage[] = $widget->id;

		update_option( '_codesigner-widget-usage', $usage, false );
	}
}