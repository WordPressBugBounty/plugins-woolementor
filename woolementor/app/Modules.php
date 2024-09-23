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
 * @subpackage Modules
 * @author Codexpert <hi@codexpert.io>
 */
class Modules extends Base {

	/**
	 * Loads modules
	 */
	public function init() {

		$modules = codesigner_modules();

		foreach ( array_keys( get_option( 'codesigner_modules', [] ) ) as $module ) {

			if( ! isset( $modules[ $module ] ) ) continue;

			$config = $modules[ $module ];

			if(
				( ! isset( $config['pro'] ) || $config['pro'] !== true )
				&& file_exists( $file = CODESIGNER_DIR . "/modules/{$module}/{$module}.php" )
			) {

				require_once $file;
				$class = "\\Codexpert\\CoDesigner\\Modules\\{$config['class']}"; 
				
				$obj = new $class;

				/**
				 * Settings filters
				 */
				if( method_exists( $obj, '__settings' ) ) {
					$obj->filter( 'codesigner-modules_settings_args', '__settings' );
				}
			}
			elseif(
				defined( 'CODESIGNER_PRO_DIR' )
				&& file_exists( $file = CODESIGNER_PRO_DIR . "/modules/{$module}/{$module}.php" )
			) {
				
				require_once $file;
				$class = "\\Codexpert\\CoDesigner_Pro\\Modules\\{$config['class']}";
				
				$obj = new $class;

				/**
				 * Settings filters
				 */
				if( method_exists( $obj, '__settings' ) ) {
					$obj->filter( 'codesigner-modules_settings_args', '__settings' );
				}
			}

		}
	}

// 	public function init() {
//     $modules = codesigner_modules();

//     foreach (array_keys(get_option('codesigner_modules', [])) as $module) {
//         $config = $modules[$module] ?? null;

//         if ($config &&
//             (!isset($config['pro']) || $config['pro'] !== true) &&
//             file_exists($file = CODESIGNER_DIR . "/modules/{$module}/{$module}.php")
//         ) {
//             require_once $file;
//             $class = "\\Codexpert\\CoDesigner\\Modules\\{$config['class']}";
//             new $class;
//         } elseif (
//             defined('CODESIGNER_PRO_DIR') &&
//             file_exists($file = CODESIGNER_PRO_DIR . "/modules/{$module}/{$module}.php")
//         ) {
//             require_once $file;
//             $class = "\\Codexpert\\CoDesigner_Pro\\Modules\\{$config['class']}";
//             new $class;
//         }
//     }
// }

}