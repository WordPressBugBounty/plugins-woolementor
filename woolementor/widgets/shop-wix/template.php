<?php
$widget_id  = $args['widget_id'];

if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
    $wishlist_show_hide = 'no';
}

$settings   = $args['settings'];

$products   = wcd_query_products( $settings );     
$user_id    = get_current_user_id();
$wishlist   = wcd_get_wishlist( $user_id );

extract( $settings );
?>

<div class="wl-sm-product-style wl-shop-wrapper">
    <?php do_action( 'codesigner_before_shop_loop' ); ?>
	<div class="cx-container">
        <div class="cx-grid">
        <?php
        if( $products->have_posts()) : 
            while( $products->have_posts()) : $products->the_post();
                $product_id = get_the_ID();
                $product    = wc_get_product( $product_id );
                $thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
                $fav_product= in_array( $product_id, $wishlist );

                if ( !empty( $fav_product ) ) {
                    $fav_item = 'fav-item';
                }
                else {
                    $fav_item = '';
                }
                ?>

                <div class="wl-sm-single-product product <?php echo esc_attr( $alignment ); ?>">
                    <?php do_action( 'codesigner_before_shop_loop_item' );

					/**
					 * Hook: woocommerce_before_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_open - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item' );

					echo '<div class="wl-sm-product-iamge-cart-panel">';

					/**
					 * Hook: woocommerce_before_shop_loop_item_title.
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );

					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );

					?>
					<div class="wl-sm-product-view">
						<?php 
						do_action( 'codesigner_before_cart_button', $product, $widget_id, $settings );

						if ( 'yes' == $view_details_show_hide ): ?>
							<a class="wl-sm-quick-view" href="<?php the_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $view_details_icon['value'] ); ?>" ></i></a>
						<?php endif;

						if ( 'yes' == $wishlist_show_hide ): ?>
							<a href="#" class="ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                            </a>
						<?php endif;
						?>
					</div>
					<?php

					echo '</div>';

					echo '<div class="wl-sm-product-title-price-panel">';

					/**
					 * Hook: woocommerce_shop_loop_item_title.
					 *
					 * @hooked woocommerce_template_loop_product_title - 10
					 */
					do_action( 'woocommerce_shop_loop_item_title' );

					/**
					 * Hook: woocommerce_after_shop_loop_item_title.
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );

					echo '</div>';

					do_action( 'codesigner_after_shop_loop_item' ); ?>

                </div>

            <?php endwhile; wp_reset_query(); else: 

            echo "<p>" . __( 'No Product Found!', 'codesigner' ) . "</p>";

        endif;
        ?>
        </div>
	</div>
    <?php do_action( 'codesigner_after_shop_loop' ); ?>
</div>

<?php 
if ( 'yes' == $pagination_show_hide ):

    $class = '';
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $class = 'wl-ajax-filter-pagination';
    }

    echo "<div class='wl-sm-pagination {$class}'>";
    
    /**
    * codesigner pagination
    */
    wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

    echo '</div>';
endif;

?>
<script>
    jQuery(function($){
        $(".wl-sc-product-image-zoom").fancybox({
            arrows: true,
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false

        }).attr('data-fancybox', 'gallery');
    })
</script>