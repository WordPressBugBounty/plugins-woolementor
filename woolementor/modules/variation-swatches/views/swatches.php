<?php
use Codexpert\CoDesigner\Helper;

$product_id = get_the_ID();
$product 	= wc_get_product( $product_id );

if ( ! $product ) return;

$variations = $product->get_available_variations();

if ( ! $variations ) return;

if ( $settings['vs_show_hide'] == '' ) return;

$attributes 	 = $product->get_attributes();
$attribute_keys  = $used_terms = $terms_values = [];

foreach( $attributes as $attribute_key => $attribute ) {
    
    if ( ! $attribute->get_variation() ) continue;
    
    $attribute_terms 	= $attribute->get_options();
    $taxonomy_names[] 	= ucfirst( substr( $attribute->get_name(), 3 ) );
    $options 			= array();
    $meta_key 			= '';
    
    foreach ( $attribute_terms as $term_key => $term_id ) {
        $term 				= get_term( $term_id );
        $term_slug 			= $term->slug;
        $options[$term_key] = $term_slug;
        $taxonomy_type		= get_term_meta( $term_id, 'codesigner-texo_type', true );

        if ( $taxonomy_type == 'label' ) {
            $meta_key = 'codesigner-taxonomy-label';
        }
        if(  $taxonomy_type == 'image'  ) {
            $meta_key = 'codesigner-image_url';
        }
        if(  $taxonomy_type == 'color'  ) {
            $meta_key = 'codesigner-vs-color';
        }

        $terms_values[$term_slug] 	= [
            'name'	=> $term->name,
            'type'	=> get_term_meta( $term_id, 'codesigner-texo_type', true ),
            'value' => get_term_meta( $term_id, $meta_key, true ),
        ];

        foreach ( $variations as $variation ) {
            $term_slug = $variation['attributes']['attribute_' . $attribute_key];
    
            if ( !isset( $used_terms['attribute_' . $attribute_key] ) ) {
                $used_terms['attribute_' . $attribute_key] = [];
            }
        
            if ( ! in_array( $term_slug, $used_terms['attribute_' . $attribute_key] ) ) {
                $used_terms['attribute_' . $attribute_key][] = $term_slug;
            }
        }
    }

    array_push( $attribute_keys, 'attribute_' . $attribute_key );
}

foreach( $variations as $variation ) {
    $_variation         = wc_get_product( $variation['variation_id'] );
    $variation_price    = $_variation->get_price();

    $new_variations[$variation['variation_id']]['attributes'] = $variation['attributes'];
    $new_variations[$variation['variation_id']]['price_html'] = wc_price( $variation_price );
}

$variation_data = array(
    'attributes' 	=> array(
        'keys'  	=> $attribute_keys,
        'names'  	=> $taxonomy_names,
        'options' 	=> $used_terms,
    ),
    'variations' 	=> $new_variations,
);

?>
<div class="cd-variation-swatches-wrapper" data-product-id='<?php echo esc_attr( $product_id ); ?>' data-variations='<?php echo esc_attr( wp_json_encode( $variation_data ) ); ?>' >
    <?php
    do_action( 'cd_variation_swatches_archive_start' );
    ?>
    <form class="cd-variation-swatches-form">
        <?php
        foreach ( $used_terms as $attr_name => $values ) {
            $prefix = "attribute_pa_";
            $_name  = substr( $attr_name, strlen ( $prefix ) );
            $name   = $settings[$_name] ? $settings[$_name] : $_name;
            echo '<div class="' . esc_attr( $attr_name ) . ' codesigner-vs-wrapper">';
            echo '<p class="codesigner-tax-name">' . esc_html( ucfirst( $name ) ) . '</p>';
            
            foreach ( $values as $term_name ) {
                $data = '';
                if( ! empty( $terms_values[$term_name]['value'] ) ) {
                    $data = $terms_values[$term_name]['value'];
                }
                else {
                    /* translators: %1$s: Term name */
                    printf( esc_attr( __( '%1$s not configured', 'codesigner' ) ), esc_attr( $term_name ) );
                }

                if ( $terms_values[$term_name]['type'] == 'image' ) {
                    $content = '<img class="codesigner-vs-content" src="' . esc_attr( $data ) . '">';
                } 
                elseif ( $terms_values[$term_name]['type'] == 'color' ) {
                    $content = '<span class="codesigner-vs-color codesigner-vs-content" style="background-color:' . esc_attr( $data ) . ';"></span>';
                } 
                else {
                    $content = '<span class="codesigner-vs-label codesigner-vs-content">' . esc_attr( $data ) . '</span>';
                }
                
                echo '<label for="codesigner_vs_' . esc_attr( $term_name  ) .'_'. esc_attr( $product_id  ) . '">
                        <input type="checkbox"'
                        . ' name="' . esc_attr( $attr_name ) . '"'
                        . ' value="' . esc_attr( $term_name  ). '"'
                        . ' id="codesigner_vs_' . esc_attr( $term_name  ) .'_'. esc_attr( $product_id  ) . '"'
                        . ' data-product-id="' . esc_attr( $product_id ) . '"' 
                        . ' data-attribute_name="' . esc_attr( $attr_name ) . '"'
                        . ' class="codesigner-vs-radio "'
                        . '> '
                        . wp_kses_post( $content )
                    . '</label><br>';
            }
            
            echo '</div>';
        }
        ?>
        <input type="hidden" name="cd-vs-id" class="cd-vs-id" value="0" data-product-id="<?php echo esc_attr( $product_id ); ?>" >
        <div class='cd-vs-message' data-product-id="<?php echo esc_attr( $product_id ); ?>"></div>
    </form>
    <?php do_action( 'cd_variation_swatches_archive_end' ); ?>
</div>
