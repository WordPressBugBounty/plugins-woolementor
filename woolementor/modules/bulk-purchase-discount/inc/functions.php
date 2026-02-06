<?php
/**
 * Return Bulk purchase discount amount
 *
 * @since 3.16
 * @param $product_id or $variation id
 * @author NH Tanvir <naymulhasantanvir10@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'cd_bulk_discount_amount' ) ) :
	function cd_bulk_discount_amount( $id, $quantity ) {
		$product = wc_get_product( $id );

		// If variation, use parent product ID for discount rules
		if ( $product && $product->is_type( 'variation' ) ) {
			$id = $product->get_parent_id();
		}

		$closest_amount = null;

		$condition_array = get_post_meta( $id, 'cd_bpd_rules', true );

		if ( is_array( $condition_array ) ) {
			$closest_difference = PHP_INT_MAX;

			foreach ( $condition_array as $item ) {
				if ( isset( $item['cd_bpd_quantatity'], $item['cd_bpd_amount'] ) ) {
					if ( $item['cd_bpd_quantatity'] <= $quantity ) {
						$difference = abs( intval( $quantity ) - intval( $item['cd_bpd_quantatity'] ) );
						if ( $difference < $closest_difference ) {
							$closest_difference = $difference;
							$closest_amount     = $item['cd_bpd_amount'];
						}
					}
				}
			}
		}

		return $closest_amount;
	}
endif;

