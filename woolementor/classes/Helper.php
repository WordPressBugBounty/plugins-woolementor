<?php
/**
 * All helpers functions
 */
namespace Codexpert\CoDesigner;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Helper
 * @author Codexpert <hi@codexpert.io>
 */
class Helper {

	public static function pri( $data, $admin_only = true, $hide_adminbar = true ) {

		if ( $admin_only && ! current_user_can( 'manage_options' ) ) {
			return;
		}

		echo wp_kses_post( '<pre>' );
		if ( is_object( $data ) || is_array( $data ) ) {
			print_r( $data );
		} else {
			var_dump( $data );
		}
		echo wp_kses_post( '</pre>' );

		if ( is_admin() && $hide_adminbar ) {
			?>
				<style>#adminmenumain{display:none;}</style>
			<?php
		}
	}

	/**
	 * @param bool $show_cached either to use a cached list of posts or not. If enabled, make sure to wp_cache_delete() with the `save_post` hook
	 */
	public static function get_posts( $args = array(), $show_heading = false, $show_cached = false ) {

		$defaults = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$_args = wp_parse_args( $args, $defaults );

		// use cache
		if ( true === $show_cached && ( $cached_posts = wp_cache_get( "codesigner_{$_args['post_type']}", 'codesigner' ) ) ) {
			$posts = $cached_posts;
		}

		// don't use cache
		else {
			$queried = new \WP_Query( $_args );

			$posts = array();
			foreach ( $queried->posts as $post ) :
				$posts[ $post->ID ] = $post->post_title;
			endforeach;

			wp_cache_add( "codesigner_{$_args['post_type']}", $posts, 'codesigner', 3600 );
		}

		/* translators: %s: Post type name */
		$posts = $show_heading ? array( '' => sprintf( __( '- Choose a %s -', 'codesigner' ), $_args['post_type'] ) ) + $posts : $posts;

		return apply_filters( 'codesigner_get_posts', $posts, $_args );
	}

	public static function get_option( $key, $section, $default = '', $repeater = false ) {

		$options = get_option( $key );

		if ( isset( $options[ $section ] ) ) {
			$option = $options[ $section ];

			if ( $repeater === true ) {
				$_option = array();
				foreach ( $option as $key => $values ) {
					$index = 0;
					foreach ( $values as $value ) {
						$_option[ $index ][ $key ] = $value;
						++$index;
					}
				}

				return $_option;
			}

			return $option;
		}

		return $default;
	}

	/**
	 * Includes a template file resides in /views directory
	 *
	 * It'll look into /codesigner directory of your active theme
	 * first. if not found, default template will be used.
	 * can be overwritten with codesigner_template_overwrite_dir hook
	 *
	 * @param string $slug slug of template. Ex: template-slug.php
	 * @param string $sub_dir sub-directory under base directory
	 * @param array  $fields fields of the form
	 */
	public static function get_template( $slug, $base = 'views', $args = null, $is_return = true ) {

		// templates can be placed in this directory
		$overwrite_template_dir = apply_filters( 'codesigner_template_overwrite_dir', get_stylesheet_directory() . '/codesigner/', $slug, $base, $args );

		// default template directory
		$plugin_template_dir = dirname( CODESIGNER ) . "/{$base}/";

		// full path of a template file in plugin directory
		$plugin_template_path = $plugin_template_dir . $slug . '.php';

		// full path of a template file in overwrite directory
		$overwrite_template_path = $overwrite_template_dir . $slug . '.php';

		if ( ! $is_return ) {
			if ( file_exists( $overwrite_template_path ) ) {
				include $overwrite_template_path;
			}
			if ( file_exists( $plugin_template_path ) ) {
				include $plugin_template_path;
			}
			return;
		}

		// if template is found in overwrite directory
		if ( file_exists( $overwrite_template_path ) ) {
			ob_start();
			include $overwrite_template_path;
			return ob_get_clean();
		}
		// otherwise use default one
		elseif ( file_exists( $plugin_template_path ) ) {
			ob_start();
			include $plugin_template_path;
			return ob_get_clean();
		} else {
			return __( 'Template not found!', 'codesigner' );
		}
	}
}