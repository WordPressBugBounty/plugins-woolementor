<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Codexpert\Plugin\Setup;
use WP_Ajax_Upgrader_Skin as Skin;
use Plugin_Upgrader as Upgrader;

require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Wizard
 * @author Codexpert <hi@codexpert.io>
 */
class Wizard extends Base {

	public $plugin;

	public $slug;

	public $name;
	
	public $version;

	public $assets;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
		$this->assets 	= CODESIGNER_ASSETS;
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'wizard'	=> sprintf( '<a href="%1$s">%2$s</a>', add_query_arg( [ 'page' => "{$this->slug}_setup" ], $this->admin_url ), __( 'Setup Wizard', 'codesigner' ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function enqueue_styles() {

		if( ! isset( $_GET['page'] ) || $_GET['page'] != 'codesigner_setup' ) return;

		wp_enqueue_style( $this->slug, "{$this->assets}/css/wizard.css", '', $this->version, 'all' );
		wp_enqueue_style( 'setting', "{$this->assets}/css/widgets-settings.css", '', $this->version, 'all' );
		wp_enqueue_style( 'font-awesome-free', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', '', $this->version, 'all' );

	}

	public function enqueue_scripts() {

		if( ! isset( $_GET['page'] ) || $_GET['page'] != 'codesigner_setup' ) return;

		wp_enqueue_script( $this->slug . '-js', "{$this->assets}/js/wizard.js", ['jquery'], $this->version, true );
	}

	public function render() {
		
		error_reporting( E_ERROR | E_PARSE );

		$back = __( '<i class="fas fa-long-arrow-alt-left"></i> Back', 'codesigner' );

		$this->plugin['steps'] = [
			'welcome'		=> [
				'label'			=> __( 'Welcome', 'codesigner' ),
				'template'		=> CODESIGNER_DIR . '/views/wizard/welcome.php',
				'action'		=> [ $this, 'save_welcome' ],
				'prev_text'		=> __( '<i class="fas fa-long-arrow-alt-left"></i> Skip Setup & Go to Dashboard', 'codesigner' ),
				'prev_url'		=> add_query_arg( [ 'page' => 'codesigner' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'codesigner' ),
			],
			'widgets'		=> [
				'label'			=> __( 'Widgets', 'codesigner' ),
				'template'		=> CODESIGNER_DIR . '/views/wizard/widgets.php',
				'action'		=> [ $this, 'save_widgets' ],
				'prev_text'		=> $back,
				'prev_url'		=> add_query_arg( [ 'page' => 'codesigner_setup', 'step' => 'welcome' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'codesigner' ),
			],
			'modules'		=> [
				'label'			=> __( 'Modules', 'codesigner' ),
				'template'		=> CODESIGNER_DIR . '/views/wizard/modules.php',
				'action'		=> [ $this, 'save_modules' ],
				'prev_text'		=> $back,
				'prev_url'		=> add_query_arg( [ 'page' => 'codesigner_setup', 'step' => 'widgets' ], admin_url( 'admin.php' ) ),
				'next_text'		=> __( 'Next Step', 'codesigner' ),
			],
			// 'pro-features'	=> [
			// 	'label'			=> __( 'More Features', 'codesigner' ),
			// 	'template'		=> CODESIGNER_DIR . '/views/wizard/pro-features.php',
			// 	'action'		=> [ $this, 'save_pro_features' ],
			// 	'prev_text'		=> $back,
			// 	'prev_url'		=> add_query_arg( [ 'page' => 'codesigner_setup', 'step' => 'modules' ], admin_url( 'admin.php' ) ),
			// 	'next_text'		=> __( 'Next Step', 'codesigner' ),
			// ],
			'complete'		=> [
				'label'			=> __( 'Complete', 'codesigner' ),
				'template'		=> CODESIGNER_DIR . '/views/wizard/complete.php',
				'action'		=> [ $this, 'install_plugin' ],
				'prev_text'		=> $back,
				'redirect'		=> add_query_arg( [ 'page' => 'codesigner' ], admin_url( 'admin.php' ) )
			],
		];

		if( defined( 'CODESIGNER_PRO' ) ) {
			unset( $this->plugin['steps']['pro-features'] );
		}

		new Setup( $this->plugin );
	}

	public function save_welcome() {
		if ( isset( $_POST['email'] ) && $_POST['email'] != '' ) {
			$response = wp_remote_post(
				'https://codexpert.io/dashboard/?fluentcrm=1&route=contact&hash=c47e9db6-1e4d-4691-ad68-975623d0a942',
				[
					'body'	=> [
						'email'			=> sanitize_text_field( $_POST['email'] ),
						'first_name'	=> $user->first_name,
						'last_name'		=> $user->last_name,
						'site_url'		=> codesigner_site_url(),
						'plugin'		=> 'codesigner',
					]
				]
			);
		}
	}

	public function save_widgets() {
		$this->save( 'codesigner_widgets' );
	}

	public function save_modules() {
		$this->save( 'codesigner_modules' );
	}

	public function save( $option_name ) {
		$request = isset( $_REQUEST ) ? $_REQUEST : null;

		// check if form is submitted
		if ( isset( $_POST ) && $request['saved'] ) {
			update_option( $option_name, $_POST );
		}
	}

	public function save_pro_features() {
		if ( isset( $_POST['enable_remind'] ) ) {
			update_option( 'codesigner_remind_upgrade_pro', time() );
		}
	}

	public function install_plugin() {

		$skin     = new Skin();
		$upgrader = new Upgrader( $skin );

		if ( isset( $_POST['image-sizes'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/image-sizes.latest-stable.zip' );
			update_option( 'image-sizes_setup_done', 1 );
			activate_plugin( 'image-sizes/image-sizes.php' );
		}

		if ( isset( $_POST['wc-affiliate'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/wc-affiliate.latest-stable.zip' );
			update_option( 'wc-affiliate_setup', 1 );
			activate_plugin( 'wc-affiliate/wc-affiliate.php' );
		}

		if ( isset( $_POST['restrict-elementor-widgets'] ) ) {
			$upgrader->install( 'https://downloads.wordpress.org/plugin/restrict-elementor-widgets.latest-stable.zip' );
			activate_plugin( 'restrict-elementor-widgets/restrict-elementor-widgets.php' );
		}
	
	}

}
