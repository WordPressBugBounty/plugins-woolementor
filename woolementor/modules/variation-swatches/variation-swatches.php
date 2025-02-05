<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\Plugin\Base;
use Codexpert\CoDesigner\Helper;

class Variation_Swatches extends Base {

	public $slug;
	public $version;
	public $id = 'codesigner_variation_swatches';

    public function __construct() {
	
		require_once( __DIR__ . '/inc/functions.php' );


		$this->action( 'init', 'init_plugin' );

		/**
		 * Runs actual hooks
		 */
		$this->hook();

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

	private function hook() {

		$this->action( 'admin_enqueue_scripts', 'admin_script' );
		$this->action( 'wp_enqueue_scripts', 'front_script' );
		$this->action( 'create_term', 'update_term_meta', 10 , 3 );
		$this->action( 'edit_term', 'update_term_meta', 10, 3 );
		$this->filter( 'product_attributes_type_selector', 'add_term_type', 10, 1 );
		$this->action( 'admin_init', 'custom_attribute_field', 10, 3 );
		$this->action( 'codesigner_shop_before_flash_sale', 'swatches_on_archive', 10, 2 );
		$this->action( 'wp_ajax_cd-vs-add-to-cart', 'archive_add_to_cart' );
		$this->action( 'wp_ajax_nopriv_cd-vs-add-to-cart', 'archive_add_to_cart' );
		$this->action( 'elementor/widgets/register', 'register_widget' );
        $this->action( 'codesigner_after_shop_style_controls', 'widget_controls' );
	}

	public function __settings ( $settings ) {
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'Variation Swatches', 'codesigner' ),
            'icon'      => 'dashicons-image-rotate-right',
            'sticky'    => false,
            'fields'    => [
                [
                    'id'        => 'vs-single-product',
                    'label'     => __( 'Single Product Widget', 'codesigner' ),
                    'type'      => 'switch',
                    'default'   => 'on',
                    'desc'      => __( 'Select if you want to use variation swatches widget on single product Page.', 'codesigner' )
				],
                [
                    'id'        => 'vs-archive-widget',
                    'label'     => __( 'On Shop widgets', 'codesigner' ),
                    'type'      => 'switch',
                    'desc'      => __( 'Select if you want to use variation swatches on shop widgets', 'codesigner' )
                ]
            ]
        ];

        return $settings;
    }

    public function admin_script() {
		wp_enqueue_media();
		wp_enqueue_script( "variation-swatches-admin-js", plugins_url( 'js/admin.js', __FILE__), [ 'jquery' ], $this->version, true );
		wp_enqueue_style( "variation-swatches-admin-css", plugins_url( "css/admin.css", __FILE__ ), '', $this->version, 'all' );
	}
	
    public function front_script() {
		wp_enqueue_script( "variation-swatches-front-js", plugins_url( 'js/front.js', __FILE__), [ 'jquery' ], $this->version, true );
		wp_enqueue_style( "variation-swatches-front-css", plugins_url( "css/front.css", __FILE__ ), '', $this->version, 'all' );
	}

	public function update_term_meta( $term_id, $tt_id, $taxonomy_name ) {
   
		$attribute_id 	= wc_attribute_taxonomy_id_by_name( $taxonomy_name );
		$attribute 		= wc_get_attribute( $attribute_id );
		$attribute_type	= $attribute->type;

		if ( $attribute_type == 'color' ) {
			update_term_meta( $term_id,'codesigner-vs-color', sanitize_text_field( $_POST['codesigner-vs-color'] ) );
		}
		if ( $attribute_type == 'label' ) {
			update_term_meta( $term_id,'codesigner-taxonomy-label', sanitize_text_field( $_POST['codesigner-taxonomy-label'] ) );
		}
		if ( $attribute_type == 'image' ) {
			update_term_meta( $term_id,'codesigner-image_url', sanitize_text_field( $_POST['codesigner-image_url'] ) );
		}

		update_term_meta( $term_id, 'codesigner-texo_type', $attribute_type );
	}

    public function add_term_type( $array ) {
		if ( isset( $_GET['post_type'] ) && isset( $_GET['page'] ) ) {
			$param_post = $_GET['post_type'];
			$param_page = $_GET['page'];
			if ( 'product' == $param_post && 'product_attributes' == $param_page ) {
				$array = [
					'select'  	=> esc_html__( 'Select', 'codesigner' ),
					'color'  	=> esc_html__( 'Color', 'codesigner' ),
					'image'  	=> esc_html__( 'Image', 'codesigner' ),
					'label' 	=> esc_html__( 'Label', 'codesigner' ),
				];
			}
		}

		return $array;
	}

    public function custom_attribute_field() {

		$product_taxonomy = [];
		if ( function_exists( 'wcd_get_taxonomies' ) ) {
			$product_taxonomy = wcd_get_taxonomies();
		}

        foreach ( $product_taxonomy as $_taxonomy => $value ) {
        	
			add_filter( "manage_edit-{$_taxonomy}_columns", function( $columns ) use ( $_taxonomy ) {

				$attribute_id 	= wc_attribute_taxonomy_id_by_name( $_taxonomy );
				$attribute 		= wc_get_attribute( $attribute_id  );

				if ( 'label' == $attribute->type ) {
					$columns[ $attribute->type ]= esc_html__('Label', 'codesigner');
				}
				if ( 'image' == $attribute->type ) {
					$columns[ $attribute->type ]= esc_html__('Thumbnail', 'codesigner');
				}
				if ( 'color' == $attribute->type ) {
					$columns[ $attribute->type ] = esc_html__('Color', 'codesigner');
				}
				return $columns;
			} );

			add_filter( "manage_{$_taxonomy}_custom_column", function( $columns, $column, $term_id  ) {

				$term_type 	= get_term_meta( $term_id, 'codesigner-texo_type', true );

				if ( 'color' == $term_type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-vs-color', true );
					printf( '<div class="swatches_thumb swatch_color" ><input type="color" id="codesigner-vs-color" disabled name="codesigner-vs-color" value="%1s"></div>', esc_attr( $term_data ) );
				}				

				if ( 'image' == $term_type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-image_url', true );
					?>
					<div class="codesigner-swatch_color"> <img src="<?php echo esc_url( $term_data  ); ?> " style="max-width: 25%; height: 25%; "> </div>
					<?php 
				}

				if ( 'label' == $term_type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-taxonomy-label', true );
					printf( "<div class='swatches_thumb swatch_color' >%s</div>", esc_attr( $term_data ) );
				}

				return $columns;
			}, 10, 3);

            add_action( "{$_taxonomy}_add_form_fields", function( $taxonomy ) {	
				$attribute_id 	= wc_attribute_taxonomy_id_by_name( $taxonomy );
				$attribute 		= wc_get_attribute( $attribute_id  );
				?>
                <div class="form-field term-color-wrap"> 

                	<?php 
                	if ( 'label' == $attribute->type ) {
					?>
					<div id="codesigner-taxonomy_text" class="codesigner-taxonomy-hidden" >
						<label><?php esc_attr_e( 'Enter Your Label', 'codesigner' ) ?></label>
						<input type="text" id="codesigner-taxonomy-label" name="codesigner-taxonomy-label">
					</div>
					<?php
					};

					if ( 'color' == $attribute->type ) {
						?>
						<div id="codesigner-taxonomy_color" class="codesigner-taxonomy-hidden">
							<label for="tag-color"><b><?php esc_attr_e( 'Color', 'codesigner' ) ?></b></label>
							<input type="color" id="codesigner-vs-color" name="codesigner-vs-color" value="#ff0000">
							<p> 
								<?php esc_attr_e( 'Input color if you want to use this as color taxonomy for CoDesigner variation swatches module Widget', 'codesigner' ) ?>							
							</p>
						</div>
						<?php
					};

					if ( 'image' == $attribute->type ) {

					?>
					<div id="codesigner-taxonomy_image" class="codesigner-taxonomy-hidden" >
						<table class="form-table">
							<tr>
								<th>
									<button id="codesigner-texonomy-upload" class="button"><?php esc_attr_e( 'Upload Image', 'codesigner' ) ?></button>
								</th>
								<td>
									<img id="codesigner-texo-image-preview" name="codesigner-texo-image" src="" style="max-width: 25%; height: 25%;">
									<input type="hidden" id="codesigner-texo-image-url" name="codesigner-image_url">
								</td>
							</tr>
						</table>																		
					</div>
					<?php
					};
					?>
				</div>
                <?php
            } );

            add_action( "{$_taxonomy}_edit_form", function( $tag, $taxonomy ) {
				$attribute_id 	= wc_attribute_taxonomy_id_by_name( $taxonomy );
				$attribute 		= wc_get_attribute( $attribute_id  );
                $term_id    	= sanitize_text_field( $_GET['tag_ID'] );
                $term_type 		= get_term_meta( $term_id, 'codesigner-texo_type', true );
                $term_data 		= '';
				
				if ( 'color' == $attribute->type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-vs-color' ) ? get_term_meta( $term_id, 'codesigner-vs-color', true ) : '#ff0000';
				?>
				<div class="form-field term-color-wrap">
					<label for="tag-color" style="display: inline-block;width: 215px;"><b><?php esc_attr_e( 'Color', 'codesigner' ) ?></b></label>
					<input type="color" id="codesigner-vs-color" name="codesigner-vs-color" value="<?php esc_attr( $term_data ); ?>">
					<p style="margin-left: 27%;"> <?php esc_attr( $term_data ) ?> 
						<?php esc_attr_e( 'Input color if you want to use this as color taxonomy for CoDesigner variation swatches module Widget', 'codesigner' ) ?>
					</p>
				</div>
				<?php 
				} 

				if ( 'image' == $attribute->type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-image_url' ) ? get_term_meta( $term_id, 'codesigner-image_url', true ) : '#'; 
				?>
				<table class="form-table">
					<div id="codesigner-taxonomy_image" class="codesigner-taxonomy" >
						<tr>
							<th>
								<button id="codesigner-texonomy-update" class="button"><?php esc_attr_e( 'Update Image', 'codesigner' ) ?></button>
							</th>
							<td>
							<img id="codesigner-texo-image-preview" name="codesigner-texo-image" src="<?php echo esc_url( $term_data ); ?>" style="max-width: 25%; height: 25%;">
							<input type="hidden" id="codesigner-texo-image-url" name="codesigner-image_url">
						</td>
						</tr>
					</div>
				</table>
				<?php
				} 

				if ( 'label' == $attribute->type ) {
					$term_data 	= get_term_meta( $term_id, 'codesigner-taxonomy-label' ) ? get_term_meta( $term_id, 'codesigner-taxonomy-label', true ) : ''; 
					?>
					<table class="form-table">
						<tr>
							<th><?php esc_attr_e( 'Label', 'codesigner' ); ?></th>
							<td><input type="text" name="codesigner-taxonomy-label" value="<?php esc_attr( $term_data ); ?>" ></td>
						</tr>
					</table>
					<?php
				}
				
			} , 10, 2 );
        }
    }    

	public function register_widget( $widgets_manager ) {
		if( Helper::get_option( 'codesigner_variation_swatches', 'vs-single-product' ) ) {
			require_once( __DIR__ . '/widgets/variation-swatches-widget.php' );
			$widgets_manager->register( new \Variation_Swatches_Widget() );
		}
	}

	public function swatches_on_archive( $settings, $product ) {
		if ( $product->get_type() == 'variable' && Helper::get_option( 'codesigner_variation_swatches', 'vs-archive-widget' ) ) {
			codesigner_get_variation_swatches_view( 'swatches', $settings, false );
		}
	}

	public function archive_add_to_cart() {
		$response = [
			'status'	=> 0,
			'message'	=>__( 'Unauthorized!', 'codesigner' )
	   	];

	   	if( ! wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
		   wp_send_json( $response );
	   	}

	   	WC()->cart->add_to_cart( $_POST['product_id'], 1 );

	   	$response['status'] 	= 1;
	   	$response['message'] 	=  __( 'Added to cart', 'codesigner' );
	   	$response['html'] 		=  "<a href='". wc_get_cart_url() ."'>View Cart</a>";
	   	wp_send_json( $response );
	}

	public function widget_controls( $widget ) {
		if ( Helper::get_option( 'codesigner_variation_swatches', 'vs-archive-widget' ) == '' || $widget->id == 'shop-beauty' || $widget->id == 'shop-table' ||  $widget->id == 'shop-flip' ||  $widget->id == 'shop-minimal' ||  $widget->id == 'shop-smart' ) return;
		codesigner_get_variation_swatches_view( 'controls', $widget, false );
	}

}
