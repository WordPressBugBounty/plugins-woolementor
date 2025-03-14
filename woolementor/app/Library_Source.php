<?php
namespace Codexpert\CoDesigner\App;

use Elementor\TemplateLibrary\Source_Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

/**
 * @package Plugin
 * @subpackage Library_Source
 * @author Codexpert <hi@codexpert.io>
 */
class Library_Source extends Source_Base {

	/**
	 * Template library data cache
	 */
	const LIBRARY_CACHE_KEY = 'wl_library_cache';

	/**
	 * Template info api url
	 *
	 * Updated api to v2 in version 2.15.0
	 */
	const API_CATEGORIES_INFO_URL = CODESIGNER_LIB_URL . '/categories/';

	/**
	 * Template info api url
	 *
	 * Updated api to v2 in version 2.15.0
	 */
	const API_TEMPLATES_INFO_URL = CODESIGNER_LIB_URL . '/list/';

	/**
	 * Template data api url
	 */
	const API_TEMPLATE_DATA_URL = CODESIGNER_LIB_URL . '/get/';

	public function get_id() {
		return 'codesigner-library';
	}

	public function get_title() {
		return __( 'CoDesigner Library', 'CoDesigner' );
	}

	public function register_data() {}

	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a CoDesigner library' );
	}

	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a CoDesigner library' );
	}

	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a CoDesigner library' );
	}

	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a CoDesigner library' );
	}

	public function get_items( $args = array() ) {
		$library_data = self::get_library_data();

		$templates = array();

		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}

		return $templates;
	}

	public function get_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['tags'] ) ? $library_data['tags'] : array() );
	}

	public function get_type_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['type_tags'] ) ? $library_data['type_tags'] : array() );
	}

	/**
	 * Prepare template items to match model
	 *
	 * @param array $template_data
	 * @return array
	 */
	private function prepare_template( array $template_data ) {
		return array(
			'template_id' => $template_data['id'],
			'title'       => $template_data['title'],
			'type'        => $template_data['type'],
			'thumbnail'   => $template_data['thumbnail'],
			'date'        => $template_data['created_at'],
			'tags'        => $template_data['tags'],
			'isPro'       => $template_data['is_pro'],
			'url'         => $template_data['url'],
		);
	}

	/**
	 * Get library data from remote source and cache
	 *
	 * @param boolean $force_update
	 * @return array
	 */
	private static function request_library_data( $force_update = false ) {
		$data = get_option( self::LIBRARY_CACHE_KEY );

		if ( $force_update || false === $data ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$data = array(
				'code'    => 'success',
				'message' => '',
			);

			$categories_response = wp_remote_get(
				self::API_CATEGORIES_INFO_URL,
				array(
					'timeout' => $timeout,
				)
			);

			if ( is_wp_error( $categories_response ) || 200 !== (int) wp_remote_retrieve_response_code( $categories_response ) ) {
				update_option( self::LIBRARY_CACHE_KEY, array() );
				return false;
			}

			/**
			 * Library categories
			 */
			$categories_data = json_decode( wp_remote_retrieve_body( $categories_response ), true );

			$data['categories'] = $categories_data['data'];

			/**
			 * Pages
			 */
			$page_response = wp_remote_get(
				self::API_TEMPLATES_INFO_URL . '?type=page',
				array(
					'timeout' => $timeout,
				)
			);

			if ( is_wp_error( $page_response ) || 200 !== (int) wp_remote_retrieve_response_code( $page_response ) ) {
				update_option( self::LIBRARY_CACHE_KEY, array() );
				return false;
			}

			$pages_data = json_decode( wp_remote_retrieve_body( $page_response ), true );

			// $data['pages'] = $pages_data['data'];

			/**
			 * Pages
			 */
			$product_response = wp_remote_get(
				self::API_TEMPLATES_INFO_URL . '?type=product',
				array(
					'timeout' => $timeout,
				)
			);

			if ( is_wp_error( $product_response ) || 200 !== (int) wp_remote_retrieve_response_code( $product_response ) ) {
				update_option( self::LIBRARY_CACHE_KEY, array() );
				return false;
			}

			$products_data = json_decode( wp_remote_retrieve_body( $product_response ), true );

			// $data['pages'] = $products_data['data'];

			$data['pages'] = array_merge( $pages_data['data'], $products_data['data'] );

			/**
			 * Blocks
			 */
			$blocks_response = wp_remote_get(
				self::API_TEMPLATES_INFO_URL . '?type=block',
				array(
					'timeout' => $timeout,
				)
			);

			if ( is_wp_error( $blocks_response ) || 200 !== (int) wp_remote_retrieve_response_code( $blocks_response ) ) {
				update_option( self::LIBRARY_CACHE_KEY, array() );
				return false;
			}

			$blocks_data = json_decode( wp_remote_retrieve_body( $blocks_response ), true );

			$data['blocks'] = $blocks_data['data'];

			if ( empty( $data ) || ! is_array( $data ) ) {
				update_option( self::LIBRARY_CACHE_KEY, array() );
				return false;
			}

			update_option( self::LIBRARY_CACHE_KEY, $data, 'no' );
		}

		return $data;
	}

	/**
	 * Get library data
	 *
	 * @param boolean $force_update
	 * @return array
	 */
	public static function get_library_data( $force_update = false ) {
		// false
		self::request_library_data( $force_update );

		$data = get_option( self::LIBRARY_CACHE_KEY );

		if ( empty( $data ) ) {
			return array();
		}

		return $data;
	}

	/**
	 * Get remote template.
	 *
	 * Retrieve a single remote template from Elementor.com servers.
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	public static function request_template_data( $template_id ) {
		if ( empty( $template_id ) ) {
			return;
		}

		$body = array(
			'home_url' => trailingslashit( home_url() ),
			'version'  => '3.0.0',
		);

		// if ( ha_has_pro() ) {
		// $body['has_pro'] = 1;
		// $body['pro_version'] = false;
		// }

		$response = wp_remote_get(
			self::API_TEMPLATE_DATA_URL . $template_id,
			array(
				'body'    => $body,
				'timeout' => 25,
			)
		);

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Get remote template data.
	 *
	 * Retrieve the data of a single remote template from Elementor.com servers.
	 *
	 * @return array|\WP_Error Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = self::request_template_data( $args['template_id'] );

		$data = json_decode( $data, true );

		if ( empty( $data ) || empty( $data['content'] ) ) {
			throw new \Exception( esc_attr( __( 'Template does not have any content', 'codesigner' ) ) );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id   = $args['editor_post_id'];
		$elementor = \Elementor\Plugin::instance();
		$document  = $elementor->documents->get( $post_id );

		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}
}
