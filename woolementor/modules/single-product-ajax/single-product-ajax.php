<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\Plugin\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
*  Single product Ajax add to cart
*/
class Single_Product_Ajax extends Base{

	public $slug;
	
	public $version;

    public function __construct(){
        $this->action( 'init', 'init_plugin' );
        $this->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
    }

    /**
     * Form WP version 6.7.0 Need to loade some 
     * Data like TextDomain and other in init hook 
     */

    public function init_plugin(){
        $this->plugin   = get_plugin_data( CODESIGNER );
        $this->slug     = $this->plugin['TextDomain'];
        $this->version  = $this->plugin['Version'];
    }

    public function enqueue_scripts(){
        global $post;
        if( function_exists( 'is_product' ) && is_product() ){
            $product = wc_get_product( $post->ID );
            if ( ( $product->is_type( 'simple' ) || $product->is_type( 'variable' ) ) ) {
                wp_enqueue_script('single-product-ajax-cart', plugins_url( 'js/front.js', __FILE__), array( 'jquery' ), $this->version, true );
            }
        }
    }

}