<?php
/**
 * Return Bulk purchase discount amount
 *
 * @since 3.16
 * @param $product_id or $variation id
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if( !function_exists( 'cd_bulk_discount_amount' ) ) :
function cd_bulk_discount_amount( $id, $quantity ) {
    $closest_amount      = null;
    if ( get_post_meta( $id, 'cd_bpd_rules' ) ) {
        $condition_array     = get_post_meta( $id, 'cd_bpd_rules', true );
        $closest_difference  = PHP_INT_MAX;
        foreach ( $condition_array as $item ) {
            if ( $item['cd_bpd_quantatity'] <= $quantity ) {
                $difference = abs( $quantity - $item['cd_bpd_quantatity'] );
                if ( $difference < $closest_difference ) {
                    $closest_difference  = $difference;
                    $closest_amount      = $item['cd_bpd_amount'];
                }
            }
        }
    }
    if ( $closest_amount ) return $closest_amount; 
}
endif;