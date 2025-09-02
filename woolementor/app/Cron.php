<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use WP_Ajax_Upgrader_Skin as Skin;
use Plugin_Upgrader as Upgrader;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Cron
 * @author Codexpert <hi@codexpert.io>
 */
class Cron extends Base {

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

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {
		/**
		 * Schedule an event to sync help docs
		 */
		if ( ! wp_next_scheduled( 'codexpert-daily' ) ) {
			wp_schedule_event( time(), 'daily', 'codexpert-daily' );
		}
	}

	/**
	 * Uninstaller. Runs once when the plugin in deactivated.
	 *
	 * @since 1.0
	 */
	public function uninstall() {
		/**
		 * Remove scheduled hooks
		 */
		wp_clear_scheduled_hook( 'codexpert-daily' );
	}

	public function install_plugins( $plugins ) {
	    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	    require_once ABSPATH . 'wp-admin/includes/plugin.php';
	    require_once ABSPATH . 'wp-admin/includes/file.php';
	    require_once ABSPATH . 'wp-admin/includes/misc.php';

	    global $wp_filesystem;
	    if ( ! $wp_filesystem ) {
	        WP_Filesystem();
	    }

	    $skin     = new Skin();
	    $upgrader = new Upgrader( $skin );

	    foreach ( $plugins as $plugin => $file ) {
	        // Install
	        $result = $upgrader->install(
	            "https://downloads.wordpress.org/plugin/{$plugin}.latest-stable.zip"
	        );

	        if ( is_wp_error( $result ) ) {
	            error_log( "Install error for {$plugin}: " . $result->get_error_message() );
	            continue;
	        }

	        // Check if installed properly
	        if ( $result !== true ) {
	            error_log( "Unexpected result for {$plugin}: " . maybe_serialize( $result ) );
	        }

	        // Activate
	        $activate = activate_plugin( $file );
	        if ( is_wp_error( $activate ) ) {
	            error_log( "Activation error for {$plugin}: " . $activate->get_error_message() );
	        }
	    }
	}

}
