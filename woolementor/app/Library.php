<?php
namespace Codexpert\CoDesigner\App;

use Codexpert\Plugin\Base;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Library
 * @author Codexpert <hi@codexpert.io>
 */
class Library extends Base {

	protected static $source = null;

	public function enqueue_scripts() {

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_enqueue_script( 'codesigner-library', plugins_url( "/assets/js/library{$min}.js", CODESIGNER ), array( 'jquery' ), time(), false );
		wp_enqueue_style( 'codesigner-library', plugins_url( "/assets/css/library{$min}.css", CODESIGNER ), array( 'dashicons' ), time() );

		$library = Library_Source::get_library_data();

		wp_localize_script(
			'codesigner-library',
			'CODESIGNER_LIB',
			array(
				'url'        => CODESIGNER_LIB_URL,
				'categories' => isset( $library['categories'] ) ? $library['categories'] : '',
				'pages'      => isset( $library['pages'] ) ? $library['pages'] : '',
				'blocks'     => isset( $library['blocks'] ) ? $library['blocks'] : '',
			)
		);
	}

	public function print_template_views() {
		include_once trailingslashit( CODESIGNER_DIR ) . 'views/library/templates.php';
	}

	/**
	 * Undocumented function
	 *
	 * @return Library_Source
	 */
	public static function get_source() {
		if ( is_null( self::$source ) ) {
			self::$source = new Library_Source();
		}

		return self::$source;
	}

	public static function register_ajax_actions( Ajax $ajax ) {
		$ajax->register_ajax_action(
			'get_wl_library_data',
			function ( $data ) {
				$elementor = \Elementor\Plugin::instance();

				if ( ! current_user_can( 'edit_posts' ) ) {
					throw new \Exception( 'Access Denied' );
				}

				if ( ! empty( $data['editor_post_id'] ) ) {
					$editor_post_id = absint( $data['editor_post_id'] );

					if ( ! get_post( $editor_post_id ) ) {
						throw new \Exception( esc_attr( __( 'Post not found.', 'codesigner' ) ) );
					}

					$elementor->db->switch_to_post( $editor_post_id );
				}

				$result = self::get_library_data( $data );

				return $result;
			}
		);

		$ajax->register_ajax_action(
			'get_wl_template_data',
			function ( $data ) {
				$elementor = \Elementor\Plugin::instance();

				if ( ! current_user_can( 'edit_posts' ) ) {
					throw new \Exception( 'Access Denied' );
				}

				if ( ! empty( $data['editor_post_id'] ) ) {
					$editor_post_id = absint( $data['editor_post_id'] );

					if ( ! get_post( $editor_post_id ) ) {
						throw new \Exception( esc_attr( __( 'Post not found', 'codesigner' ) ) );
					}

					$elementor->db->switch_to_post( $editor_post_id );
				}

				if ( empty( $data['template_id'] ) ) {
					throw new \Exception( esc_attr( __( 'Template id missing', 'codesigner' ) ) );
				}

				$result = self::get_template_data( $data );

				return $result;
			}
		);

		$ajax->register_ajax_action(
			'get_wl_template_sync',
			function ( $data ) {
				$elementor = \Elementor\Plugin::instance();

				if ( ! current_user_can( 'edit_posts' ) ) {
					throw new \Exception( 'Access Denied' );
				}

				return Library_Source::get_library_data( true );
			}
		);
	}

	public static function get_template_data( array $args ) {
		$source = self::get_source();
		$data   = $source->get_data( $args );
		return $data;
	}

	/**
	 * Get library data from cache or remote
	 *
	 * type_tags has been added in version 2.15.0
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public static function get_library_data( array $args ) {
		$source = self::get_source();

		if ( ! empty( $args['sync'] ) ) {
			Library_Source::get_library_data( true );
		}

		return array(
			'templates' => $source->get_items(),
			'tags'      => $source->get_tags(),
			'type_tags' => $source->get_type_tags(),
		);
	}
}
