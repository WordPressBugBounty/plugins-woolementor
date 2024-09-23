<?php
/**
 * Return attribute_type
 *
 * @since 3.16.1
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if( !function_exists( 'codesigner_get_attribute_type_by_id' ) ) :
function codesigner_get_attribute_type_by_id( $attribute_id ) {
    global $wpdb;

    $table_name     = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
    $attribute_type = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT `attribute_type` FROM $table_name WHERE `attribute_id` = %d",
            $attribute_id
        )
    );
    return $attribute_type;
}
endif;
/**
 * Return template
 *
 * @since 3.16.1
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if( ! function_exists( 'codesigner_get_variation_swatches_view' ) ) :
function codesigner_get_variation_swatches_view( $name, $settings = null ) {
    // default template directory
    $variation_swatches_dir   = dirname( CODESIGNER ) . "/modules/variation-swatches/views/";
    $variation_swatches_path  = $variation_swatches_dir. $name .'.php';

    if ( file_exists( $variation_swatches_path ) ) {
        ob_start();
        include $variation_swatches_path;
        return ob_get_clean();
    }
    else return;
}
endif;
/**
 * Return product with most attributes
 *
 * @since 3.16.1
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if( ! function_exists( 'codesigner_get_product_with_most_attributes' ) ) :
function codesigner_get_product_with_most_attributes() {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'product_type' => 'variable',
    );

    $products = get_posts( $args );

    if ( empty( $products ) ) {
        return false;
    }

    $max_attributes              = 0;
    $product_with_max_attributes = null;

    foreach ( $products as $product ) {
        $attributes         = wc_get_product( $product );
        $attribute_count     = count( $attributes->get_attributes() );

        if ( $attribute_count > $max_attributes ) {
            $max_attributes                 = $attribute_count;
            $product_with_max_attributes    = $product;
        }
    }

    return $product_with_max_attributes->ID;
}
endif;
