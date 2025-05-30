<?php
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Gets the site's base URL
 *
 * @uses get_bloginfo()
 *
 * @return string $url the site URL
 */
if ( ! function_exists( 'codesigner_site_url' ) ) :
	function codesigner_site_url() {
		$url = get_bloginfo( 'url' );

		return $url;
	}
endif;

/**
 * List of CoDesigner widgets
 *
 * @icons https://elementor.github.io/elementor-icons/
 *
 * @since 1.0
 */
if ( ! function_exists( 'codesigner_widgets' ) ) :
	function codesigner_widgets() {

		$branding_class     = ' wlbi';
		$demo_base          = wcd_home_link();
		$single_product_url = 'single-product';

		$widgets = array(
			/**
			 * Shop widgets
			 */
			'shop-classic'                   => array(
				'title'      => 'Shop Classic',
				'icon'       => 'eicon-gallery-grid' . $branding_class,
				'categories' => array( 'codesigner-shop' ),
				'demo'       => "{$demo_base}/shop-classic/",
				'keywords'   => array( 'cart', 'store', 'products', 'shop', 'grid', 'regular' ),
			),
			'shop-standard'                  => array(
				'title'      => 'Shop Standard',
				'icon'       => 'eicon-apps' . $branding_class,
				'categories' => array( 'codesigner-shop' ),
				'demo'       => "{$demo_base}/shop-standard/",
				'keywords'   => array( 'cart', 'store', 'products', 'shop', 'grid', 'regular' ),
			),
			'shop-flip'                      => array(
				'title'       => 'Shop Flip',
				'icon'        => 'eicon-flip-box' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-flip/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-trendy'                    => array(
				'title'       => 'Shop Trendy',
				'icon'        => 'eicon-products' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-trendy/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-curvy'                     => array(
				'title'      => 'Shop Curvy',
				'icon'       => 'eicon-posts-grid' . $branding_class,
				'categories' => array( 'codesigner-shop' ),
				'demo'       => "{$demo_base}/shop-curvy/",
				'keywords'   => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant' ),
			),
			'shop-curvy-horizontal'          => array(
				'title'       => 'Shop Curvy Horizontal',
				'icon'        => 'eicon-posts-group' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-curvy-horizontal/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-slider'                    => array(
				'title'      => 'Shop Slider',
				'icon'       => 'eicon-slider-device' . $branding_class,
				'categories' => array( 'codesigner-shop' ),
				'demo'       => "{$demo_base}/shop-slider/",
				'keywords'   => array( 'cart', 'store', 'products', 'shop', 'grid', 'slider' ),
			),
			'shop-accordion'                 => array(
				'title'       => 'Shop Accordion',
				'icon'        => 'eicon-accordion' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-accordion/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'accordion' ),
				'pro_feature' => true,
			),
			'shop-table'                     => array(
				'title'       => 'Shop Table',
				'icon'        => 'eicon-table' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-table/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-beauty'                    => array(
				'title'       => 'Shop Beauty',
				'icon'        => 'eicon-thumbnails-half' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-beauty/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-smart'                     => array(
				'title'       => 'Shop Smart',
				'icon'        => 'eicon-thumbnails-half' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-smart/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-minimal'                   => array(
				'title'       => 'Shop Minimal',
				'icon'        => 'eicon-thumbnails-half' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-minimal/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-wix'                       => array(
				'title'       => 'Shop Wix',
				'icon'        => 'eicon-thumbnails-half' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-wix/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),
			'shop-shopify'                   => array(
				'title'       => 'Shop Shopify',
				'icon'        => 'eicon-thumbnails-half' . $branding_class,
				'categories'  => array( 'codesigner-shop' ),
				'demo'        => "{$demo_base}/shop-shopify/",
				'keywords'    => array( 'cart', 'store', 'products', 'shop', 'grid', 'elegant-horizontal' ),
				'pro_feature' => true,
			),

			/**
			 * Shop filter
			 */
			'filter-horizontal'              => array(
				'title'      => 'Filter Horizontal',
				'icon'       => 'eicon-ellipsis-h' . $branding_class,
				'categories' => array( 'codesigner-filter' ),
				'demo'       => "{$demo_base}/filter-horizontal/",
				'keywords'   => array( 'cart', 'store', 'products', 'product', 'single', 'single-product', 'filter', 'horizontal' ),
			),
			'filter-vertical'                => array(
				'title'       => 'Filter Vertical',
				'icon'        => 'eicon-ellipsis-v' . $branding_class,
				'categories'  => array( 'codesigner-filter' ),
				'demo'        => "{$demo_base}/filter-vertical/",
				'keywords'    => array( 'cart', 'store', 'products', 'product', 'single', 'single-product', 'filter', 'vertical' ),
				'pro_feature' => true,
			),
			'filter-advance'                 => array(
				'title'       => 'Filter Advance',
				'icon'        => 'eicon-filter' . $branding_class,
				'categories'  => array( 'codesigner-filter' ),
				'demo'        => "{$demo_base}/filter-advance/",
				'keywords'    => array( 'cart', 'store', 'products', 'product', 'single', 'single-product', 'filter', 'horizontal', 'advance' ),
				'pro_feature' => true,
			),

			/*
			* Single Product
			*/
			'product-title'                  => array(
				'title'      => 'Product Title',
				'icon'       => 'eicon-post-title' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'store', 'products', 'product-title', 'single', 'single-product' ),
			),
			'product-price'                  => array(
				'title'      => 'Product Price',
				'icon'       => 'eicon-product-price' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'store', 'products', 'product-price', 'single', 'single-product' ),
			),
			'product-rating'                 => array(
				'title'      => 'Product Rating',
				'icon'       => 'eicon-product-rating' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'store', 'products', 'product-rating', 'single', 'single-product' ),
			),
			'product-breadcrumbs'            => array(
				'title'      => 'Breadcrumbs',
				'icon'       => 'eicon-post-navigation' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'breadcrumbs', 'single', 'product' ),
			),
			'product-short-description'      => array(
				'title'      => 'Product Short Description',
				'icon'       => 'eicon-product-description' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'products', 'product', 'short', 'description', 'single', 'product' ),
			),
			'product-variations'             => array(
				'title'      => 'Product Variations',
				'icon'       => 'eicon-product-related' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'store', 'products', 'product-title', 'single', 'single-product' ),
			),
			'product-add-to-cart'            => array(
				'title'      => 'Add to Cart',
				'icon'       => 'eicon-cart' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'add-to-cart', 'short', 'single', 'product' ),
			),
			'product-sku'                    => array(
				'title'      => 'Product SKU',
				'icon'       => 'eicon-anchor' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'sku', 'short', 'single', 'product' ),
			),
			'product-stock'                  => array(
				'title'      => 'Product Stock',
				'icon'       => 'eicon-product-stock' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'product-stock', 'short', 'single', 'product' ),
			),
			'product-additional-information' => array(
				'title'      => 'Additional Information',
				'icon'       => 'eicon-product-info' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'product-additional-information', 'short', 'single', 'product' ),
			),
			'product-tabs'                   => array(
				'title'      => 'Product Tabs',
				'icon'       => 'eicon-product-tabs' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'product-tabs', 'short', 'single', 'product' ),
			),
			'product-dynamic-tabs'           => array(
				'title'       => 'Product Dynamic Tabs',
				'icon'        => 'eicon-product-tabs' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/{$single_product_url}/",
				'pro_feature' => true,
				'keywords'    => array( 'cart', 'add to cart', 'product-dynamic-tabs', 'short', 'single', 'product' ),
			),
			'product-meta'                   => array(
				'title'      => 'Product Meta',
				'icon'       => 'eicon-product-tabs' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'product-meta', 'short', 'single', 'product' ),
			),
			'product-categories'             => array(
				'title'      => 'Product Categories',
				'icon'       => 'eicon-flow' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'category', 'categories', 'short', 'single', 'product' ),
			),
			'product-tags'                   => array(
				'title'      => 'Product Tags',
				'icon'       => 'eicon-tags' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}/",
				'keywords'   => array( 'cart', 'add to cart', 'tags', 'short', 'single', 'product' ),
			),
			'product-thumbnail'              => array(
				'title'      => 'Product Thumbnail',
				'icon'       => 'eicon-featured-image' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}",
				'keywords'   => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-thumbnail' ),
			),
			'product-gallery'                => array(
				'title'      => 'Product Gallery',
				'icon'       => 'eicon-featured-image' . $branding_class,
				'categories' => array( 'codesigner-single' ),
				'demo'       => "{$demo_base}/{$single_product_url}",
				'keywords'   => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-gallery' ),
			),
			'product-add-to-wishlist'        => array(
				'title'       => 'Add to Wishlist',
				'icon'        => 'eicon-tags' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/{$single_product_url}/",
				'pro_feature' => true,
				'keywords'    => array( 'cart', 'add to cart', 'add to wishlist', 'tags', 'short', 'single', 'product' ),
			),
			'product-comparison-button'      => array(
				'title'       => 'Add to Compare',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/{$single_product_url}",
				'keywords'    => array( 'products', 'single', 'single-product', 'product-comparison-button' ),
				'pro_feature' => true,
			),
			'ask-for-price'                  => array(
				'title'       => 'Ask for Price',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/{$single_product_url}",
				'keywords'    => array( 'products', 'single', 'single-product', 'ask-for-price' ),
				'pro_feature' => true,
			),
			'quick-checkout-button'          => array(
				'title'       => 'Quick Checkout Button',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/{$single_product_url}",
				'keywords'    => array( 'products', 'single', 'single-product', 'ask-for-price' ),
				'pro_feature' => true,
			),
			'product-barcode'                => array(
				'title'       => 'Product Barcode',
				'icon'        => 'eicon-barcode' . $branding_class,
				'categories'  => array( 'codesigner-single' ),
				'demo'        => "{$demo_base}/product-comparison",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-comparison' ),
				'pro_feature' => true,
			),

			/**
			 * Pricing tables
			 */
			'pricing-table-advanced'         => array(
				'title'      => 'Pricing Table Advanced',
				'icon'       => 'eicon-price-table' . $branding_class,
				'categories' => array( 'codesigner-pricing' ),
				'demo'       => "{$demo_base}/pricing-table-advanced/",
				'keywords'   => array( 'cart', 'single', 'pricing-table', 'pricing' ),
			),
			'pricing-table-basic'            => array(
				'title'      => 'Pricing Table Basic',
				'icon'       => 'eicon-price-table' . $branding_class,
				'categories' => array( 'codesigner-pricing' ),
				'demo'       => "{$demo_base}/pricing-table-basic/",
				'keywords'   => array( 'cart', 'single', 'pricing-table', 'pricing' ),
			),
			'pricing-table-regular'          => array(
				'title'       => 'Pricing Table Regular',
				'icon'        => 'eicon-price-table' . $branding_class,
				'categories'  => array( 'codesigner-pricing' ),
				'demo'        => "{$demo_base}/pricing-table-regular/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing' ),
				'pro_feature' => true,
			),
			'pricing-table-smart'            => array(
				'title'       => 'Pricing Table Smart',
				'icon'        => 'eicon-price-table' . $branding_class,
				'categories'  => array( 'codesigner-pricing' ),
				'demo'        => "{$demo_base}/pricing-table-smart/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing' ),
				'pro_feature' => true,
			),
			'pricing-table-fancy'            => array(
				'title'       => 'Pricing Table Fancy',
				'icon'        => 'eicon-price-table' . $branding_class,
				'categories'  => array( 'codesigner-pricing' ),
				'demo'        => "{$demo_base}/pricing-table-fancy/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing' ),
				'pro_feature' => true,
			),

			/**
			 * Related Products
			 */
			'related-products-classic'       => array(
				'title'      => 'Related Products Classic',
				'icon'       => 'eicon-gallery-grid' . $branding_class,
				'categories' => array( 'codesigner-related' ),
				'demo'       => "{$demo_base}/related-products-classic/",
				'keywords'   => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-classic' ),
			),
			'related-products-standard'      => array(
				'title'      => 'Related Products Standard',
				'icon'       => 'eicon-apps' . $branding_class,
				'categories' => array( 'codesigner-related' ),
				'demo'       => "{$demo_base}/related-products-standard/",
				'keywords'   => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-standard' ),
			),
			'related-products-flip'          => array(
				'title'       => 'Related Products Flip',
				'icon'        => 'eicon-flip-box' . $branding_class,
				'categories'  => array( 'codesigner-related' ),
				'demo'        => "{$demo_base}/related-products-flip/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-flip' ),
				'pro_feature' => true,
			),
			'related-products-trendy'        => array(
				'title'       => 'Related Products Trendy',
				'icon'        => 'eicon-products' . $branding_class,
				'categories'  => array( 'codesigner-related' ),
				'demo'        => "{$demo_base}/related-products-trendy/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-trendy' ),
				'pro_feature' => true,
			),
			'related-products-curvy'         => array(
				'title'      => 'Related Products Curvy',
				'icon'       => 'eicon-posts-grid' . $branding_class,
				'categories' => array( 'codesigner-related' ),
				'demo'       => "{$demo_base}/related-products-curvy/",
				'keywords'   => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-curvy' ),
			),
			'related-products-accordion'     => array(
				'title'       => 'Related Products Accordion',
				'icon'        => 'eicon-accordion' . $branding_class,
				'categories'  => array( 'codesigner-related' ),
				'demo'        => "{$demo_base}/related-products-accordion/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-accordion' ),
				'pro_feature' => true,
			),
			'related-products-table'         => array(
				'title'       => 'Related Products Table',
				'icon'        => 'eicon-table' . $branding_class,
				'categories'  => array( 'codesigner-related' ),
				'demo'        => "{$demo_base}/related-products-table/",
				'keywords'    => array( 'cart', 'single', 'pricing-table', 'pricing', 'related-products-table' ),
				'pro_feature' => true,
			),

			/**
			 * Photo gallery
			 */
			'gallery-fancybox'               => array(
				'title'      => 'Gallery Fancybox',
				'icon'       => 'eicon-slider-push' . $branding_class,
				'categories' => array( 'codesigner-gallery' ),
				'demo'       => "{$demo_base}",
				'keywords'   => array( 'cart', 'single', 'product-gallery-fancybox' ),
			),
			'gallery-lc-lightbox'            => array(
				'title'      => 'Gallery LC Lightbox',
				'icon'       => 'eicon-gallery-group' . $branding_class,
				'categories' => array( 'codesigner-gallery' ),
				'demo'       => "{$demo_base}/",
				'keywords'   => array( 'cart', 'single', 'product-gallery-lightbox' ),
			),
			'gallery-box-slider'             => array(
				'title'      => 'Gallery Box Slider',
				'icon'       => 'eicon-slider-album' . $branding_class,
				'categories' => array( 'codesigner-gallery' ),
				'demo'       => "{$demo_base}/",
				'keywords'   => array( 'cart', 'single', 'product-gallery-adaptor' ),
			),

			/**
			 * Cart widgets
			 */
			'cart-items'                     => array(
				'title'      => 'Cart Items',
				'icon'       => 'eicon-products' . $branding_class,
				'categories' => array( 'codesigner-cart' ),
				'demo'       => "{$demo_base}/cart/",
				'keywords'   => array( 'cart', 'store', 'products', 'cart-items-standard' ),
			),
			'cart-items-classic'             => array(
				'title'      => 'Cart Items Classic',
				'icon'       => 'eicon-products' . $branding_class,
				'categories' => array( 'codesigner-cart' ),
				'demo'       => "{$demo_base}/cart/",
				'keywords'   => array( 'cart', 'store', 'products', 'cart-items-standard' ),
			),
			'cart-overview'                  => array(
				'title'      => 'Cart Overview',
				'icon'       => 'eicon-product-price' . $branding_class,
				'categories' => array( 'codesigner-cart' ),
				'demo'       => "{$demo_base}/cart/",
				'keywords'   => array( 'cart', 'store', 'products', 'cart-overview-standard' ),
			),
			'coupon-form'                    => array(
				'title'      => 'Coupon Form',
				'icon'       => 'eicon-product-meta' . $branding_class,
				'categories' => array( 'codesigner-cart' ),
				'demo'       => "{$demo_base}/cart/",
				'keywords'   => array( 'cart', 'store', 'products', 'coupon-form-standard' ),
			),
			'floating-cart'                  => array(
				'title'       => 'Floating Cart',
				'icon'        => 'eicon-product-meta' . $branding_class,
				'categories'  => array( 'codesigner-cart' ),
				'demo'        => "{$demo_base}/cart/",
				'keywords'    => array( 'cart', 'checkout', 'products', 'coupon-form-standard' ),
				'pro_feature' => true,
			),

			/*
			*Checkout Page items
			*/
			'billing-address'                => array(
				'title'       => 'Billing Address',
				'icon'        => 'eicon-google-maps' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'billing', 'address', 'form' ),
				'pro_feature' => true,
			),
			'shipping-address'               => array(
				'title'       => 'Shipping Address',
				'icon'        => 'eicon-google-maps' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form' ),
				'pro_feature' => true,
			),
			'order-notes'                    => array(
				'title'       => 'Order Notes',
				'icon'        => 'eicon-table-of-contents' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes' ),
				'pro_feature' => true,
			),
			'order-review'                   => array(
				'title'       => 'Order Review',
				'icon'        => 'eicon-product-info' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review' ),
				'pro_feature' => true,
			),
			'order-pay'                      => array(
				'title'       => 'Order Pay',
				'icon'        => 'eicon-product-info' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'pay' ),
				'pro_feature' => true,
			),
			'payment-methods'                => array(
				'title'       => 'Payment Methods',
				'icon'        => 'eicon-product-upsell' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'payment', 'methods' ),
				'pro_feature' => true,
			),
			'thankyou'                       => array(
				'title'       => 'Thank You',
				'icon'        => 'eicon-nerd' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'thank', 'you', 'thankyou' ),
				'pro_feature' => true,
			),
			'checkout-login'                 => array(
				'title'       => 'Checkout Login',
				'icon'        => 'eicon-lock-user' . $branding_class,
				'categories'  => array( 'codesigner-checkout' ),
				'demo'        => "{$demo_base}/checkout/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'thank', 'you', 'thankyou' ),
				'pro_feature' => true,
			),

			/*
			* Email Widgets
			*/
			'email-header'                   => array(
				'title'       => 'Email Header',
				'icon'        => 'eicon-header' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-header' ),
				'pro_feature' => true,
			),
			'email-footer'                   => array(
				'title'       => 'Email Footer',
				'icon'        => 'eicon-footer' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-footer' ),
				'pro_feature' => true,
			),
			'email-item-details'             => array(
				'title'       => 'Email Item Details',
				'icon'        => 'eicon-kit-details' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-item-details' ),
				'pro_feature' => true,
			),
			'email-billing-addresses'        => array(
				'title'       => 'Email Billing Addresses',
				'icon'        => 'eicon-table-of-contents' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-billing-addresses' ),
				'pro_feature' => true,
			),
			'email-shipping-addresses'       => array(
				'title'       => 'Email Shipping Addresses',
				'icon'        => 'eicon-purchase-summary' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-shipping-addresses' ),
				'pro_feature' => true,
			),
			'email-customer-note'            => array(
				'title'       => 'Email Customer Note',
				'icon'        => 'eicon-document-file' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-customer-note' ),
				'pro_feature' => true,
			),
			'email-order-note'               => array(
				'title'       => 'Email Order Note',
				'icon'        => 'eicon-document-file' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-customer-note', 'email-order-note' ),
				'pro_feature' => true,
			),
			'email-description'              => array(
				'title'       => 'Email Description',
				'icon'        => 'eicon-menu-toggle' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-description' ),
				'pro_feature' => true,
			),
			'email-reminder'                 => array(
				'title'       => 'Email Reminder',
				'icon'        => 'eicon-menu-toggle' . $branding_class,
				'categories'  => array( 'codesigner-email' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'email', 'email-reminder' ),
				'pro_feature' => true,
			),

			/*
			* Others Widgets
			*/
			'my-account'                     => array(
				'title'      => 'My Account',
				'icon'       => 'eicon-call-to-action' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/my-account/",
				'keywords'   => array( 'my', 'account', 'cart', 'customer' ),
			),
			'my-account-advanced'            => array(
				'title'       => 'My Account Advanced',
				'icon'        => 'eicon-call-to-action' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/my-account/",
				'keywords'    => array( 'my', 'account', 'cart', 'customer' ),
				'pro_feature' => true,
			),
			'wishlist'                       => array(
				'title'       => 'Wishlist',
				'icon'        => 'eicon-heart-o' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/wishlist/",
				'keywords'    => array( 'cart', 'store', 'products', 'coupon-form-standard', 'wish', 'list' ),
				'pro_feature' => true,
			),
			'customer-reviews-classic'       => array(
				'title'      => 'Customer Reviews Classic',
				'icon'       => 'eicon-product-rating' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/customer-reviews-classic/",
				'keywords'   => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'customer-reviews-vertical', 'customer-reviews', 'vertical' ),
			),
			'customer-reviews-standard'      => array(
				'title'       => 'Customer Reviews Standard',
				'icon'        => 'eicon-review' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/customer-reviews-standard/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'customer-reviews-horizontal', 'customer-reviews', 'horizontal' ),
				'pro_feature' => true,
			),
			'customer-reviews-trendy'        => array(
				'title'       => 'Customer Reviews Trendy',
				'icon'        => 'eicon-rating' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/customer-reviews-trendy/",
				'keywords'    => array( 'cart', 'single', 'shipping', 'address', 'form', 'order', 'notes', 'review', 'customer-reviews-horizontal', 'customer-reviews', 'horizontal' ),
				'pro_feature' => true,
			),
			'faqs-accordion'                 => array(
				'title'       => 'FAQs Accordion',
				'icon'        => 'eicon-accordion' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/faqs-accordion",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ),
				'pro_feature' => true,
			),
			'tabs-basic'                     => array(
				'title'      => 'Tabs Basic',
				'icon'       => 'eicon-tabs' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/tabs-basic/",
				'keywords'   => array( 'tab', 'tabs', 'content tab', 'menu', 'tabs basic' ),
			),
			'tabs-classic'                   => array(
				'title'      => 'Tabs Classic',
				'icon'       => 'eicon-tabs' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/tabs-classic",
				'keywords'   => array( 'tab', 'tabs', 'content tab', 'menu', 'tabs classic' ),
			),
			'tabs-fancy'                     => array(
				'title'      => 'Tabs Fancy',
				'icon'       => 'eicon-tabs' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/tabs-fancy",
				'keywords'   => array( 'tab', 'tabs', 'content tab', 'menu', 'tabs fancy' ),
			),
			'tabs-beauty'                    => array(
				'title'      => 'Tabs Beauty',
				'icon'       => 'eicon-tabs' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/tabs-beauty",
				'keywords'   => array( 'tab', 'tabs', 'content tab', 'menu', 'tabs beauty' ),
			),
			'gradient-button'                => array(
				'title'      => 'Gradient Button',
				'icon'       => 'eicon-button' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/gradient-button",
				'keywords'   => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ),
			),
			'sales-notification'             => array(
				'title'       => 'Sales Notification',
				'icon'        => 'eicon-posts-ticker' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/sales-notification",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product' ),
				'pro_feature' => true,
			),
			'category'                       => array(
				'title'       => 'Shop Categories',
				'icon'        => 'eicon-flow' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/shop-categories",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category' ),
				'pro_feature' => true,
			),
			'basic-menu'                     => array(
				'title'       => 'Basic Menu',
				'icon'        => 'eicon-nav-menu' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/basic-menu",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'basic-menu' ),
				'pro_feature' => true,
			),
			'dynamic-tabs'                   => array(
				'title'       => 'Dynamic Tabs',
				'icon'        => 'eicon-tabs' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'dynamic-tabs' ),
				'pro_feature' => true,
			),
			// 'google-review'      => [
			// 'title'         => 'Google Review',
			// 'icon'          => 'eicon-review' . $branding_class,
			// 'categories'    => [ 'codesigner' ],
			// 'demo'          => "{$demo_base}/google-review",
			// 'keywords'      => [ 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'google-review' ],
			// 'pro_feature'   => true,
			// ],
			'menu-cart'                      => array(
				'title'       => 'Menu Cart',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/menu-cart",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'menu-cart' ),
				'pro_feature' => true,
			),
			'product-comparison'             => array(
				'title'       => 'Product Comparison',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/product-comparison",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-comparison' ),
				'pro_feature' => true,
			),
			'product-barcode'                => array(
				'title'       => 'Product Barcode',
				'icon'        => 'eicon-cart' . $branding_class,
				'categories'  => array( 'codesigner' ),
				'demo'        => "{$demo_base}/product-comparison",
				'keywords'    => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-comparison' ),
				'pro_feature' => true,
			),
			'image-comparison'               => array(
				'title'      => 'Image Comparison',
				'icon'       => 'eicon-cart' . $branding_class,
				'categories' => array( 'codesigner' ),
				'demo'       => "{$demo_base}/product-comparison",
				'keywords'   => array( 'cart', 'store', 'products', 'tabs-beauty', 'single', 'single-product', 'category', 'product-comparison' ),
			),
		);

		return apply_filters( 'codesigner_widgets', $widgets );
	}
endif;

if ( ! function_exists( 'codesigner_modules' ) ) :
	function codesigner_modules() {
		$modules = array(

			'email-templates'        => array(
				'id'    => 'email-templates',
				'title' => 'Email Designer',
				'desc'  => 'This module is a great tool to improve the look and feel of your WooCommerce emails. With this module, you can create WooCommerce emails that are more engaging and more likely to get attention from your users.',
				'class' => 'Email_Templates',
				'pro'   => true,
			),

			'invoice-builder'        => array(
				'id'    => 'invoice-builder',
				'title' => 'Invoice Builder',
				'desc'  => 'The WooCommerce Invoice Builder module allows you to create custom invoices for your WooCommerce store easily. You can also change the design of your invoices. It provides you with the option to add styles and information to make the invoice more personalized.',
				'class' => 'Invoice_Builder',
				'pro'   => true,
			),

			'product-brands'         => array(
				'id'    => 'product-brands',
				'title' => 'Product Brands',
				'desc'  => 'Let the buyers get the sense of the brand with CoDesigner’s Product Brand Module. This module seamlessly categorizes and showcases your products along with their brand names making it easy for shoppers to discover what they love.',
				'class' => 'Product_Brands',
				'pro'   => false,
			),

			'cart-button-text'       => array(
				'id'    => 'cart-button-text',
				'title' => 'Add To Cart Text',
				'desc'  => 'Tired of the generic "Add to Cart"? With CoDesginer, your "Add to Cart" button becomes a powerful conversion tool. Personalize the add to cart button for your WooCommerce shop and single product page with custom text.',
				'class' => 'Add_To_Cart_Text',
				'pro'   => false,
			),

			'checkout-builder'       => array(
				'id'    => 'checkout-builder',
				'title' => 'Checkout Builder',
				'desc'  => 'Offer the best user experience by customizing the WooCommerce checkout page using CoDesigner. And, break down the checkout page to make it more manageable with the multistep checkout template.',
				'class' => 'Checkout_Builder',
				'pro'   => true,
			),

			'skip-cart-page'         => array(
				'id'    => 'skip-cart-page',
				'title' => 'Skip Cart Page',
				'desc'  => 'Let your buyers skip the WooCommerce cart page and seamlessly redirect them straight to checkout for a faster, frictionless buying experience. This powerful module streamlines the customer journey by encouraging purchases and maximizing conversions.',
				'class' => 'Skip_Cart_Page',
				'pro'   => false,
			),

			'variation-swatches'     => array(
				'id'    => 'variation-swatches',
				'title' => 'Variation Swatches',
				'desc'  => 'CoDesigner variation swatches ensure a refreshing user experience. This module provides an alternative to the default WooCommerce dropdown fields. The variations on your products can be their actual colors, images, labels, etc.',
				'class' => 'variation_swatches',
				'pro'   => false,
			),

			'flash-sale'             => array(
				'id'    => 'flash-sale',
				'title' => 'Flash Sale',
				'desc'  => 'The flash sale module helps to create buzz and anticipation. You can engage customers to purchase products at a discount rate by showing a Flash Sale timer. This creates a sense of urgency among the shoppers to purchase products as fast as possible.',
				'class' => 'Flash_Sale',
				'pro'   => false,
			),

			'partial-payment'        => array(
				'id'    => 'partial-payment',
				'title' => 'Partial Payment',
				'desc'  => 'CoDesginer\'s "Partial Payment" module helps your customers break down the costs. This makes the larger purchases more attainable. You will be able to get more conversions by providing users this flexibility to make partial payments on your WooCommerce store.',
				'class' => 'Partial_Payment',
				'pro'   => false,
			),

			'backorder'              => array(
				'id'    => 'backorder',
				'title' => 'Backorder',
				'desc'  => 'This module lets you confidently sell products even when out of stock. Add an extra capability to set a backorder availability date for your WooCommerce products. Accept orders now, deliver later, and keep conversions going.',
				'class' => 'Backorder',
				'pro'   => false,
			),

			'preorder'               => array(
				'id'    => 'preorder',
				'title' => 'Preorder',
				'desc'  => 'With this module, you can create buzz and secure sales before products even launch. Set the pre-order availability date and specific release dates for your products in WooCommerce product management dashboard. Build anticipation, drive engagement, and manage releases effortlessly.',
				'class' => 'Preorder',
				'pro'   => false,
			),

			'bulk-purchase-discount' => array(
				'id'    => 'bulk-purchase-discount',
				'title' => 'Bulk Purchase Discount',
				'desc'  => 'Turn casual shoppers into bulk buyers with CoDesginer\'s "Bulk Purchase Discount" module. Set compelling tiered discounts that make it irresistible to stock up. Great technique for driving conversions and exceeding expectations.',
				'class' => 'Bulk_Purchase_Discount',
				'pro'   => false,
			),

			'single-product-ajax'    => array(
				'id'    => 'single-product-ajax',
				'title' => 'Single Product Ajax Add To Cart',
				'desc'  => 'CoDesginer\'s "Single Product Ajax Add To Cart" module creates a frictionless shopping experience. Let users instantly add their products to the cart without any page reload. This helps to guide customers smoothly towards checkout and drive sales.',
				'class' => 'Single_Product_Ajax',
				'pro'   => false,
			),

			'badges'                 => array(
				'id'    => 'badges',
				'title' => 'Badges',
				'desc'  => 'Highlight your most popular items, new releases, or unique offerings with eye-catching badges that instantly capture attention. Using this module you can use images, icons, or text as product badges to highlight a product on a shop page.',
				'class' => 'Badges',
				'pro'   => false,
			),

			'currency-switcher'      => array(
				'id'    => 'currency-switcher',
				'title' => 'Currency Switcher',
				'desc'  => 'Show customers you value their preferences with CoDesigner’s "Currency Switcher". Let customers view prices in their familiar currencies on all WooCommerce pages including the shop, cart, product, and checkout page. This helps to create a seamless shopping experience that drives international sales.',
				'class' => 'Currency_Switcher',
				'pro'   => false,
			),
		);

		return $modules;
	}
endif;

/**
 *
 * Home Url Link
 */
if ( ! function_exists( 'wcd_home_link' ) ) :
	function wcd_home_link() {
		return 'https://codexpert.io/codesigner';
	}
endif;


/**
 * List widgets enabled by the admin
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_active_widgets' ) ) :
	function wcd_active_widgets() {
		$active_widgets = get_option( 'codesigner_widgets' ) ? : array();

		return apply_filters( 'wcd_active_widgets', array_keys( $active_widgets ) );
	}
endif;

/**
 * List of CoDesigner widget categories
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_widget_categories' ) ) :
	function wcd_widget_categories() {
		$categories = array(
			'codesigner-shop'     => array(
				'title' => __( 'CoDesigner - Shop', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-filter'   => array(
				'title' => __( 'CoDesigner - Filter', 'codesigner' ),
				'icon'  => 'eicon-search',
			),
			'codesigner-single'   => array(
				'title' => __( 'CoDesigner - Single Product', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-pricing'  => array(
				'title' => __( 'CoDesigner - Pricing Table', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-related'  => array(
				'title' => __( 'CoDesigner - Related Products', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-gallery'  => array(
				'title' => __( 'CoDesigner - Image Gallery', 'codesigner' ),
				'icon'  => 'eicon-photo-library',
			),
			'codesigner-cart'     => array(
				'title' => __( 'CoDesigner - Cart', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-checkout' => array(
				'title' => __( 'CoDesigner - Checkout', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner-email'    => array(
				'title' => __( 'CoDesigner - Email', 'codesigner' ),
				'icon'  => 'eicon-cart',
			),
			'codesigner'          => array(
				'title' => __( 'CoDesigner - Others', 'codesigner' ),
				'icon'  => 'eicon-skill-bar',
			),
		);

		return apply_filters( 'wcd_widget_categories', $categories );
	}
endif;

/**
 * Determines if the pro version is activated
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_pro_activated' ) ) :
	function wcd_is_pro_activated() {
		global $codesigner_pro;
		return isset( $codesigner_pro['license'] ) && $codesigner_pro['license']->_is_activated();
	}
endif;

/**
 * Wc Help Link
 *
 * @since 1.0
 */

if ( ! function_exists( 'wcd_help_link' ) ) :
	function wcd_help_link() {
		if ( wcd_is_pro() ) {
			return 'https://codexpert.io/codesigner/docs/general/';
		}

		return 'https://wordpress.org/support/plugin/codesigner';
	}
endif;

/**
 * Determines if the pro version is installed
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_pro' ) ) :
	function wcd_is_pro() {
		return apply_filters( 'codesigner-is_pro', false );
	}
endif;

/**
 * Determines if a widget is a pro feature or not
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_pro_feature' ) ) :
	function wcd_is_pro_feature( $id ) {
		$widgets = codesigner_widgets();
		return isset( $widgets[ $id ]['pro_feature'] ) && $widgets[ $id ]['pro_feature'];
	}
endif;

/**
 * Get widget $id from __CLASS__ name
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_get_widget_id' ) ) :
	function wcd_get_widget_id( $__CLASS__ ) {

		// if it's under a namespace
		if ( strpos( $__CLASS__, '\\' ) !== false ) {
			$path      = explode( '\\', $__CLASS__ );
			$__CLASS__ = array_pop( $path );
		}

		return strtolower( str_replace( '_', '-', $__CLASS__ ) );
	}
endif;

/**
 * Get a widget data by $id or __CLASS__
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_get_widget' ) ) :
	function wcd_get_widget( $id ) {
		$widgets = codesigner_widgets();

		// if a __CLASS__ name was supplied as $id
		$id = wcd_get_widget_id( $id );

		return isset( $widgets[ $id ] ) ? $widgets[ $id ] : false;
	}
endif;

/**
 * Checks either we're in the preview mode
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_preview_mode' ) ) :
	function wcd_is_preview_mode( $post_id = 0 ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		if ( ! isset( $_GET['preview_id'] ) || $post_id !== (int) $_GET['preview_id'] ) {
			return false;
		}

		return true;
	}
endif;

/**
 * Checks either we're in the edit mode
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_edit_mode' ) ) :
	function wcd_is_edit_mode( $post_id = 0 ) {
		return \Elementor\Plugin::$instance->editor->is_edit_mode( $post_id );
	}
endif;

/**
 * Query products based on input
 *
 * @since 1.0
 *
 * @return []
 */
if ( ! function_exists( 'wcd_query_products' ) ) :
	function wcd_query_products( $query ) {

		extract( $query );

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		if ( is_front_page() ) {
			global $wp_query;
			if ( is_array( $wp_query->query ) && count( $wp_query->query ) > 0 && isset( $wp_query->query['paged'] ) ) {
				$paged = $wp_query->query['paged'];
			}
		}

		if ( ! empty( $_GET['q'] ) ) {
			$paged = 1;
		}

		$args = array(
			'post_type'      => 'product',
			'post_status '   => 'publish',
			'posts_per_page' => ( isset( $number ) ? $number : 10 ),
			'paged'          => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				),
			),
		);

		/**
		 * Are we going to use a custom query?
		 *
		 * @since 1.2
		 */
		if ( 'yes' == $custom_query ) {
			if ( ! empty( $categories ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $categories,
				);
			}
			if ( ! empty( $out_of_stock ) && $out_of_stock == 'yes' ) {
				$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'outofstock',
					'compare' => 'NOT IN',
				);
			}

			if ( ! empty( $exclude_categories ) ) {
				$args['tax_query'][] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $exclude_categories,
						'operator' => 'NOT IN',
					),
				);
			}

			if ( ! empty( $offset ) ) {
				$args['offset'] = $offset;
			}

			if ( in_array( $orderby, array( '_price', 'total_sales', '_wc_average_rating' ) ) ) {
				$args['meta_key'] = $orderby;
				$args['orderby']  = 'meta_value_num';
			}
		}

		/**
		 * Is this a taxonomy archive page? e.g. category or tag
		 *
		 * @since 1.2
		 */
		elseif ( is_tax() ) {
			$term                = get_queried_object();
			$term_id             = $term->term_id;
			$args['tax_query'][] = array(
				'taxonomy' => $term->taxonomy,
				'field'    => 'id',
				'terms'    => $term_id,
			);
		}

		/**
		 * query by author
		 *
		 * @author Jakaria Istauk <jakariamd35@gmail.com>
		 *
		 * @since 3.0
		 */
		if ( isset( $author ) && $author != '' ) {
			$author_id      = (int) sanitize_text_field( $author );
			$args['author'] = $author_id;
		}

		/**
		 * Query related products, cross sells, upsells, cart cross sells
		 *
		 * @author Jakaria Istauk <jakariamd35@gmail.com>
		 *
		 * @since 3.0
		 */

		if ( $product_source == 'related-products' ) {
			if ( 'current_product' == $content_source ) {
				$main_product_id = get_the_ID();
			}

			$type = get_post_type( $main_product_id );

			$_exclude_products   = explode( ',', $ns_exclude_products );
			$related_product_ids = wc_get_related_products( $main_product_id, $product_limit, $_exclude_products );
			$include_products    = $type == 'product' ? implode( ',', $related_product_ids ) : '-1';
		} elseif ( $product_source == 'upsells' ) {
			if ( 'current_product' == $content_source ) {
				$main_product_id = get_the_ID();
			}

			$type        = get_post_type( $main_product_id );
			$product_ids = array( -1 );
			if ( $type == 'product' ) {
				$product     = wc_get_product( $main_product_id );
				$product_ids = $product->get_upsell_ids();
				shuffle( $product_ids );
				$product_ids = $product_limit > 0 ? array_slice( $product_ids, 0, $product_limit ) : $product_ids;
				$product_ids = empty( $product_ids ) ? array( -1 ) : $product_ids;
			}

			$include_products = implode( ',', $product_ids );
		} elseif ( $product_source == 'cross-sells' ) {
			if ( 'current_product' == $content_source ) {
				$main_product_id = get_the_ID();
			}

			$type        = get_post_type( $main_product_id );
			$product_ids = array( -1 );
			if ( $type == 'product' ) {
				$product     = wc_get_product( $main_product_id );
				$product_ids = $product->get_cross_sell_ids();
				shuffle( $product_ids );
				$product_ids = $product_limit > 0 ? array_slice( $product_ids, 0, $product_limit ) : $product_ids;
				$product_ids = empty( $product_ids ) ? array( -1 ) : $product_ids;
			}

			$include_products = implode( ',', $product_ids );
		} elseif ( in_array( $product_source, array( 'cart-cross-sells', 'cart-upsells', 'cart-related-products' ) ) ) {
			$product_ids       = array( -1 );
			$relation_type     = str_replace( 'cart-', '', $product_source );
			$_exclude_products = explode( ',', $ns_exclude_products );
			$_product_ids      = wcd_get_cart_related_products( $product_limit, $relation_type, $_exclude_products );
			$product_ids       = ! empty( $_product_ids ) ? $_product_ids : $product_ids;
			$include_products  = implode( ',', $product_ids );
		} elseif ( $product_source == 'recently-viewed' ) {
			$include_products = isset( $_COOKIE['woocommerce_recently_viewed'] ) ? implode( ',', (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) ) : '';
		} elseif ( $product_source == 'recently-sold' ) {
			$product_ids      = count( wcd_recently_sold_products( $product_limit ) ) > 0 ? wcd_recently_sold_products( $product_limit ) : array( -1 );
			$include_products = implode( ',', $product_ids );
		}

		if ( is_woocommerce_activated() ) {
			$_sale_products = wc_get_product_ids_on_sale();
		} else {
			$_sale_products = array();
		}

		$sale_products = implode( ',', $_sale_products );

		if ( 'yes' == $sale_products_show_hide ) {
			$include_products = $sale_products . ',' . $include_products;
		}

		// $_include_products  = explode( ',', $include_products );
		// $inc_products       = array_map( 'trim', $_include_products );

		// $_exclude_products  = explode( ',', $exclude_products );
		// $exc_products       = array_map( 'trim', $_exclude_products );
		if ( $include_products !== null ) {
			$_include_products = explode( ',', $include_products );
			$inc_products      = array_map( 'trim', $_include_products );
		} else {
			$inc_products = array();
		}

		if ( $exclude_products !== null ) {
			$_exclude_products = explode( ',', $exclude_products );
			$exc_products      = array_map( 'trim', $_exclude_products );
		} else {
			$exc_products = array();
		}

		if ( 'yes' == $sale_products_show_hide ) {
			$inc_products = array_diff( $inc_products, $exc_products );
		}

		if ( ! empty( $include_products ) ) {
			$args['post__in'] = $inc_products;
		}

		if ( ! empty( $exclude_products ) ) {
			$args['post__not_in'] = $exc_products;
		}

		if ( isset( $product_limit ) && ! empty( $product_limit ) ) {
			$args['posts_per_page'] = $product_limit;
		}

		$products = new \WP_Query( apply_filters( 'codesigner-product_query_params', $args ) );

		return apply_filters( 'codesigner-queried_products', $products, $query );
	}
endif;

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false; }
	}
}

/**
 * Return recently sold products
 *
 * @since 3.0
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if ( ! function_exists( 'wcd_recently_sold_products' ) ) :
	function wcd_recently_sold_products( $product_limit ) {
		$product_ids = array();

		$args = array(
			'post_type'   => 'shop_order',
			'post_status' => 'wc-completed',
			'numberposts' => -1,
		);

		$posts = get_posts( $args );

		$count = 1;
		foreach ( $posts as $post ) {
			$order = new WC_Order( $post->ID );
			$items = $order->get_items();

			foreach ( $items as $item ) {
				if ( $count > $product_limit ) {
					break;
				}

				$product       = $item->get_product();
				$product_ids[] = $product->get_id();
				++$count;
			}
		}

		return apply_filters( 'wcd_recently_sold_products', $product_ids );
	}
endif;

/**
 * CoDesigner pagination
 *
 * @var wp_query $products
 * @var string $left_icon and $right_icon
 */
if ( ! function_exists( 'wcd_pagination' ) ) :
	function wcd_pagination( $products, $left_icon, $right_icon ) {

		$total_pages = $products->max_num_pages;
		$big         = 999999999;

		if ( $total_pages > 1 ) {

			$paged = get_query_var( 'paged' );

			if ( is_front_page() ) {
				global $wp_query;
				if ( is_array( $wp_query->query ) && count( $wp_query->query ) > 0 && isset( $wp_query->query['paged'] ) ) {
					$paged = $wp_query->query['paged'];
				}
			}

			$current_page = max( 1, $paged );

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				if ( isset( $_POST['action'] ) && $_POST['action'] == 'ajax-filter' ) {
					if ( isset( $_POST['paged'] ) ) {
						$url = parse_url( sanitize_text_field( $_POST['paged'] ), PHP_URL_QUERY );
						parse_str( $url, $paged );
						$current_page = isset( $paged['paged'] ) ? $paged['paged'] : 1;
					}
				}
			}

			echo wp_kses_post(
				paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big, false ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $total_pages,
						'prev_text' => '<i class="' . esc_attr( $left_icon['value'] ) . '"></i>',
						'next_text' => '<i class="' . esc_attr( $right_icon['value'] ) . '"></i>',
					)
				)
			);
		}
	}
endif;

/**
 * Return product source type
 *
 * @since 3.0
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if ( ! function_exists( 'wcd_product_source_type' ) ) :
	function wcd_product_source_type() {
		$options = array(
			'shop'                  => __( 'Shop', 'codesigner' ),
			'related-products'      => __( 'Related Products', 'codesigner' ),
			'upsells'               => __( 'Up Sells', 'codesigner' ),
			'cross-sells'           => __( 'Cross Sells', 'codesigner' ),
			'cart-upsells'          => __( 'Cart Up Sells', 'codesigner' ),
			'cart-cross-sells'      => __( 'Cart Cross Sells', 'codesigner' ),
			'cart-related-products' => __( 'Cart Related Products', 'codesigner' ),
		);

		return apply_filters( 'wcd_product_source_type', $options );
	}
endif;

/**
 * Order options used for product query
 *
 * @since 1.0
 *
 * @return []
 */
if ( ! function_exists( 'wcd_order_options' ) ) :
	function wcd_order_options() {
		$options = array(
			'none'               => __( 'None', 'codesigner' ),
			'ID'                 => __( 'ID', 'codesigner' ),
			'title'              => __( 'Title', 'codesigner' ),
			'name'               => __( 'Name', 'codesigner' ),
			'date'               => __( 'Date', 'codesigner' ),
			'rand'               => __( 'Random', 'codesigner' ),
			'menu_order'         => __( 'Menu Order', 'codesigner' ),
			'_price'             => __( 'Product Price', 'codesigner' ),
			'total_sales'        => __( 'Top Seller', 'codesigner' ),
			'comment_count'      => __( 'Most Reviewed', 'codesigner' ),
			'_wc_average_rating' => __( 'Top Rated', 'codesigner' ),
		);

		return apply_filters( 'codesigner-order_options', $options );
	}
endif;

/**
 * List product categories
 *
 * @since 1.0
 *
 * @return array
 */
if ( ! function_exists( 'wcd_get_terms' ) ) :
	function wcd_get_terms( $taxonomy = 'product_cat' ) {

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);
		$cats  = array();
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( isset( $term->term_id ) ) {
					$cats[ $term->term_id ] = $term->name;
				}
			}
		}
		return $cats;
	}
endif;

/**
 * Returns the text (Pro) if pro version is not activated.
 *
 * @return boolean
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_pro_text' ) ) :
	function wcd_pro_text() {
		return ( wcd_is_pro_activated() ? '' : '<span class="wl-pro-text"> (' . __( 'PRO', 'codesigner' ) . ')</span>' );
	}
endif;

/**
 * Get wishlist of the user
 *
 * @var int $user_id user ID
 *
 * @since 1.0
 *
 * @return array
 */
if ( ! function_exists( 'wcd_get_wishlist' ) ) :
	function wcd_get_wishlist( $user_id = 0 ) {
		$_wishlist_key = 'codesigner-wishlist';
		$_wishlist     = array();
		if ( $user_id != 0 ) {
			$_wishlist = get_user_meta( $user_id, $_wishlist_key, true ) ? : array();
		} elseif ( isset( $_COOKIE[ $_wishlist_key ] ) ) {
			$_wishlist = json_decode( stripslashes( sanitize_text_field( $_COOKIE[ $_wishlist_key ] ) ), ARRAY_N );
		}

		if ( is_null( $_wishlist ) ) {
			$_wishlist = array();
		}

		$_wishlist = array_unique( $_wishlist );

		return apply_filters( 'codesigner-wishlist', $_wishlist );
	}
endif;

/**
 * Get list of taxonomies
 *
 * @return []
 */
if ( ! function_exists( 'wcd_get_taxonomies' ) ) :
	function wcd_get_taxonomies() {
		$_taxonomies = get_object_taxonomies( 'product' );
		$taxonomies  = array();
		foreach ( $_taxonomies as $_taxonomy ) {
			$taxonomy = get_taxonomy( $_taxonomy );
			if ( $taxonomy->show_ui ) {
				$taxonomies[ $_taxonomy ] = $taxonomy->label;
			}
		}

		return $taxonomies;
	}
endif;

/**
 * Min or Max value from the entire store
 *
 * @var string $limit min or max
 * @var bool $intval do we need an integer "formatted" value?
 *
 * @return mix
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_price_limit' ) ) :

	// function wcd_price_limit( $limit = 'max', $intval = true ) {
	// if( !in_array( $limit, [ 'min', 'max' ] ) ) return 0;
	// global $wpdb;
	// $meta_key = '_price';
	// $meta_type = 'DECIMAL';
	// $query_args = array(
	// 'meta_key'   => $meta_key,
	// 'meta_type'  => $meta_type,
	// 'fields'     => "MIN(CAST(meta_value AS {$meta_type})) AS min_price, MAX(CAST(meta_value AS {$meta_type})) AS max_price",
	// );
	// $results = get_posts( $query_args );
	// $value = ( $limit == 'min' ) ? $results[0]->min_price : $results[0]->max_price;
	// return $intval ? (int) $value : $value;
	// }

	function wcd_price_limit( $limit = 'max', $intval = true ) {
		if ( ! in_array( $limit, array( 'min', 'max' ) ) ) {
			return 0;
		}
		global $wpdb;
		$meta_key  = '_price';
		$meta_type = 'DECIMAL(10,2)';
		$sql       = "
	        SELECT MIN(CAST(meta_value AS $meta_type)) AS min_price, 
	               MAX(CAST(meta_value AS $meta_type)) AS max_price 
	        FROM $wpdb->postmeta 
	        WHERE meta_key = %s";
		$results   = $wpdb->get_row( $wpdb->prepare( $sql, sanitize_key( $meta_key ) ) );

		if ( null === $results ) {
			return 0;
		}

		$value = ( $limit == 'min' ) ? $results->min_price : $results->max_price;
		return $intval ? (int) $value : $value;
	}

endif;

/**
 * Return the template types
 *
 * @since 3.0
 * @param $args, give array value. unset field
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if ( ! function_exists( 'wcd_get_shop_options' ) ) :
	function wcd_get_shop_options( $args = array() ) {
		$widgets = codesigner_widgets_by_category();

		$options = array( '' => __( 'Select a shop', 'codesigner' ) );
		foreach ( $widgets as $key => $widget ) {
			$options[ $key ] = $widget['title'];
		}
		return $options;
	}
endif;

/**
 * List of CoDesigner widget of a single category
 *
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 *
 * @since 3.0
 */
if ( ! function_exists( 'codesigner_widgets_by_category' ) ) :
	function codesigner_widgets_by_category( $category = 'codesigner-shop' ) {
		$all_widgets      = codesigner_widgets();
		$category_widgets = array();
		foreach ( $all_widgets as $name => $widget ) {
			if ( in_array( $category, $widget['categories'] ) ) {
				$category_widgets[ $name ] = $widget;
			}
		}

		return $category_widgets;
	}
endif;

/**
 * Get meta keys
 *
 * @return array
 */
if ( ! function_exists( 'wcd_get_product_id' ) ) :
	function wcd_get_product_id( $type = '' ) {

		global $post;
		if ( ! is_woocommerce_activated() ) {
			return;
		}
		if ( $post->post_type == 'product' ) {
			return $post->ID;
		}

		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'order'          => 'DESC',
			'orderby'        => 'rand',
		);

		if ( $type != '' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => $type,
				),
			);
		}

		$result = new \WP_Query( $args );

		return $result->post->ID;
	}
endif;

/**
 * Get the attributes which are not in variations
 *
 * @var int $attachment_id
 *
 * @return []
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_attrs_notin_variations' ) ) :
	function wcd_attrs_notin_variations( $attributes, $product ) {

		if ( count( $attributes ) < 1 ) {
			return;
		}

		$extra_attrs = array();
		foreach ( $attributes as $vkey => $variation_attr ) {
			if ( $attributes[ $vkey ] == '' ) {
				$term_key             = explode( 'attribute_', $vkey );
				$get_attrs            = $product->get_attribute( $term_key[1] );
				$attrs                = explode( '|', $get_attrs );
				$extra_attrs[ $vkey ] = $attrs;
			}
		}

		return $extra_attrs;
	}
endif;

/**
 * Sanitize number input
 *
 * @param mix $value the value
 *
 * @uses sanitize_text_field()
 *
 * @return int The sanitized value
 */
if ( ! function_exists( 'codesigner_sanitize_number' ) ) :
	function codesigner_sanitize_number( $value, $type = 'int' ) {
		if ( $type == 'float' ) {
			return (float) sanitize_text_field( $value );
		} else {
			return (int) sanitize_text_field( $value );
		}
	}
endif;

/**
 * Get meta keys
 *
 * @return array
 */
if ( ! function_exists( 'wcd_get_meta_keys' ) ) :
	function wcd_get_meta_keys() {
		global $wpdb;
		$sql       = "SELECT distinct meta_key FROM {$wpdb->postmeta}";
		$result    = $wpdb->get_results( $sql );
		$meta_keys = array();

		foreach ( $result as $row ) {
			$meta_keys[ $row->meta_key ] = $row->meta_key;
		}

		return $meta_keys;
	}
endif;

/**
 * Gets list of gallery images from a product
 *
 * @var int $product_id
 *
 * @return []
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_product_gallery_images' ) ) :
	function wcd_product_gallery_images( $product_id ) {

		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		if ( get_post_type( $product_id ) !== 'product' ) {
			return;
		}

		$product   = wc_get_product( $product_id );
		$image_ids = $product->get_gallery_image_ids();

		$images = array();
		foreach ( $image_ids as $image_id ) {
			$images[] = array(
				'id'  => $image_id,
				'url' => wp_get_attachment_url( $image_id ),
			);
		}

		return $images;
	}
endif;

/**
 * Get an attachment with additional data
 *
 * @var int $attachment_id
 *
 * @return []
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_get_attachment' ) ) :
	function wcd_get_attachment( $attachment_id ) {

		$attachment = get_post( $attachment_id );

		if ( ! $attachment ) {
			return false;
		}

		return array(
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href'        => get_permalink( $attachment->ID ),
			'src'         => $attachment->guid,
			'title'       => $attachment->post_title,
		);
	}
endif;

/**
 * Checkout form fields
 *
 * @var string $section billing, shipping or order
 *
 * @return []
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_checkout_fields' ) ) :
	function wcd_checkout_fields( $section = 'billing' ) {
		if ( ! function_exists( 'WC' ) ) {
			return array();
		}

		if ( is_admin() ) {
			WC()->session = new \WC_Session_Handler();
			WC()->session->init();
		}

		$get_fields = WC()->checkout->get_checkout_fields();

		$fields = array();
		foreach ( $get_fields[ $section ] as $key => $field ) {
			if ( isset( $field['label'] ) ) {
				$fields[] = array(
					"{$section}_input_label"        => $field['label'],
					"{$section}_input_name"         => $key,
					"{$section}_input_required"     => isset( $field['required'] ) ? $field['required'] : false,
					"{$section}_input_type"         => isset( $field['type'] ) ? $field['type'] : 'text',
					"{$section}_input_class"        => $field['class'],
					"{$section}_input_autocomplete" => isset( $field['autocomplete'] ) ? $field['autocomplete'] : '',
					"{$section}_input_placeholder"  => isset( $field['placeholder'] ) ? $field['placeholder'] : '',
				);
			}
		}

		return $fields;
	}
endif;

/**
 * Populates a notice
 *
 * @var string $text the text to show
 * @var string $heading the heading
 * @var array $modes available screens [ live, preview, edit ]
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_notice' ) ) :
	function wcd_notice( $text, $heading = null, $modes = array( 'edit', 'preview' ) ) {
		if (
		wcd_is_preview_mode() && ! in_array( 'preview', $modes ) ||
		wcd_is_edit_mode() && ! in_array( 'edit', $modes ) ||
		wcd_is_live_mode() && ! in_array( 'live', $modes )
		) {
			return;
		}

		if ( is_null( $heading ) ) {
			$heading = '<i class="eicon-warning"></i> ' . __( 'Admin Notice', 'codesigner' );
		}

		$notice = "
	<div class='wl-notice'>
		<h3>{$heading}</h3>
		<p>{$text}</p>
	</div>";

		return $notice;
	}
endif;

/**
 * Checks either we're in the live mode
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_is_live_mode' ) ) :
	function wcd_is_live_mode( $post_id = 0 ) {
		return ! wcd_is_edit_mode( $post_id ) && ! wcd_is_preview_mode( $post_id );
	}
endif;

/**
 * Return elementor template library list
 *
 * @param string $template_type ex: 'wl-tab'
 */
if ( ! function_exists( 'wcd_get_template_list' ) ) :
	function wcd_get_template_list( $template_type = 'wl-tab' ) {

		$args = array(
			'post_type'      => 'elementor_library',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'order'          => 'DESC',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => '_elementor_template_type',
					'value' => $template_type,
				),
			),
		);

		$result = new \WP_Query( $args );
		$_tabs  = $result->posts;

		$tabs = array();
		foreach ( $_tabs as $tab ) {
			$tabs[ $tab->ID ] = $tab->post_title;
		}

		return $tabs;
	}
endif;

/**
 * Return the template types
 *
 * @since 3.0
 * @param $args, give array value. unset field
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if ( ! function_exists( 'wcd_get_meta_fields' ) ) :
	function wcd_get_meta_fields( $args = array() ) {
		global $wpdb;

		$all_ids = get_posts(
			array(
				'post_type'   => 'product',
				'numberposts' => -1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			)
		);

		$table_name = $wpdb->prefix . 'postmeta';

		$ids = implode( ',', $all_ids );

		$sql = "SELECT DISTINCT `meta_key` FROM `{$wpdb->prefix}postmeta` WHERE `post_id` IN( {$ids} )";

		$results = $wpdb->get_results( $sql );

		$meta_fields = array();
		foreach ( $results as $result ) {
			if ( ! in_array( $result->meta_key, $args ) ) {
				$meta_fields[ $result->meta_key ] = ucwords( str_replace( '_', ' ', $result->meta_key ) );
			}
		}

		return $meta_fields;
	}
endif;

/**
 * Get CoDesigner logo
 *
 * @param boolean $img either we want to return an <img /> tag
 *
 * @since 1.0
 *
 * @return string image url or tag
 */
if ( ! function_exists( 'wcd_get_icon' ) ) :
	function wcd_get_icon( $img = false ) {
		$url = CODESIGNER_ASSETS . '/img/icon.png';

		if ( $img ) {
			return "<img src='{$url}'>";
		}

		return $url;
	}
endif;

/**
 * Set wishlist of the user
 *
 * @var array $wishlist a set of product IDs
 * @var int $user_id user ID
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_set_wishlist' ) ) :
	function wcd_set_wishlist( $wishlist, $user_id = 0 ) {
		$_wishlist_key = 'codesigner-wishlist';
		$_wishlist     = array();

		if ( $user_id != 0 ) {
			update_user_meta( $user_id, sanitize_key( $_wishlist_key ), $wishlist );
		} else {
			setcookie( sanitize_key( $_wishlist_key ), json_encode( $wishlist ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		}
	}
endif;

/**
 * Gets a random order ID
 *
 * @return int
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_get_random_order_id' ) ) :
	function wcd_get_random_order_id() {
		if ( ! function_exists( 'WC' ) ) {
			return false;
		}

		$query  = new \WC_Order_Query(
			array(
				'limit'   => 1,
				'orderby' => 'rand',
				'order'   => 'DESC',
				'return'  => 'ids',
			)
		);
		$orders = $query->get_orders();

		if ( count( $orders ) > 0 ) {
			return $orders[0];
		}

		return false;
	}
endif;

/**
 * Default checkout fields
 *
 * @param string $section form section billing|shipping|order
 *
 * @since 1.0
 */
if ( ! function_exists( 'wcd_wc_fields' ) ) :
	function wcd_wc_fields( $section = '' ) {
		$fields = array(
			'billing'  => array( 'billing_first_name', 'billing_last_name', 'billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_phone', 'billing_email' ),
			'shipping' => array( 'shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_country', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_postcode' ),
			'order'    => array( 'order_comments' ),
		);

		if ( $section != '' && isset( $fields[ $section ] ) ) {
			return apply_filters( 'wcd_wc_fields', $fields[ $section ] );
		}

		return apply_filters( 'wcd_wc_fields', $fields );
	}
endif;

/**
 * Get related_product_ids in cart
 *
 * @return array
 */
if ( ! function_exists( 'wcd_get_cart_related_products' ) ) :
	function wcd_get_cart_related_products( $product_limit, $relation_type = 'related-products', $exclude_products = array() ) {

		$product_ids = array();
		if ( is_null( WC()->cart ) ) {
			include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
			include_once WC_ABSPATH . 'includes/class-wc-cart.php';
			wc_load_cart();
		}

		if ( WC()->cart->is_empty() ) {
			return $product_ids;
		}

		if ( $relation_type == 'cross-sells' ) {
			$product_ids = WC()->cart->get_cross_sells();
		} else {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product_ids = array();
				if ( $relation_type == 'upsells' ) {
					$product      = wc_get_product( $cart_item['product_id'] );
					$_product_ids = $product->get_upsell_ids();
				} else {
					$_product_ids = wc_get_related_products( $cart_item['product_id'] );
				}
				$product_ids = array_merge( $product_ids, $_product_ids );
			}
		}
		$related_product_ids = array_unique( $product_ids );
		if ( ! empty( $exclude_products ) ) {
			foreach ( $exclude_products as $key => $pid ) {
				if ( in_array( $pid, $related_product_ids ) ) {
					unset( $related_product_ids[ array_search( $pid, $related_product_ids ) ] );
				}
			}
		}

		shuffle( $related_product_ids );
		$related_product_ids = array_slice( $related_product_ids, 0, $product_limit );
		return $related_product_ids;
	}
endif;

/**
 * Populates rating html with start icons.
 *
 * @var int|float $rating the rating value
 * @return html
 *
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 * @since 3.0
 */
if ( ! function_exists( 'wcd_rating_html' ) ) :
	function wcd_rating_html( $rating ) {

		$half_rating = $rating - floor( $rating );
		$rating_html = '';

		for ( $i = 0; $i < (int) $rating; $i++ ) {
			$rating_html .= "<span class='dashicons dashicons-star-filled'></span>";
		}

		if ( $half_rating > 0 ) {
			$rating      += 1;
			$rating_html .= "<span class='dashicons dashicons-star-half'></span>";
		}

		for ( $i = 0; $i < 5 - (int) $rating; $i++ ) {
			$rating_html .= "<span class='dashicons dashicons-star-empty'></span>";
		}

		return $rating_html;
	}
endif;


/**
 * Product Compare Cookie Key
 *
 * @uses wcd_compare_cookie_key()
 *
 * @return string the cookie key
 *
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 * @since 3.0.1
 */
if ( ! function_exists( 'wcd_compare_cookie_key' ) ) :
	function wcd_compare_cookie_key() {
		return '_codesigner-compare';
	}
endif;

/**
 * set product id to comparison cookie
 *
 * @since 3.0.1
 * @param $product_ids int|array array or single product ids
 * @author Jakaria Istauk <jakariamd35@gmail.com>
 */
if ( ! function_exists( 'wcd_add_to_compare' ) ) :
	function wcd_add_to_compare( $product_ids ) {

		$compare_key  = wcd_compare_cookie_key();
		$all_products = array();
		if ( isset( $_COOKIE[ $compare_key ] ) ) {
			$_products    = sanitize_text_field( $_COOKIE[ $compare_key ] );
			$all_products = $_products ? unserialize( $_products ) : array();
		}

		if ( is_array( $product_ids ) && count( $product_ids ) > 0 ) {
			foreach ( $product_ids as $product_id ) {
				$_product_id = codesigner_sanitize_number( $product_id );
				if ( $_product_id ) {
					$all_products[] = $_product_id;
				}
			}
		} else {
			$all_products[] = codesigner_sanitize_number( $product_ids );
		}

		$products = array_unique( $all_products );
		setcookie( $compare_key, serialize( $products ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}
endif;

/**
 * Return the template types
 *
 * @since 3.0
 * @param $args, give array value. unset field
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
if ( ! function_exists( 'wcd_hextorgb' ) ) :
	function wcd_hextorgb( $hex = '#000000' ) {
		list($r, $g, $b) = sscanf( $hex, '#%02x%02x%02x' );
		$rgb             = "$r, $g, $b";
		return $rgb;
	}
endif;

/**
 *
 * @return string sale text with discount percentage
 *
 * @author Tanvir <naymulhasantanvir10@gmail.com>
 * @since 3.0.1
 */
if ( ! function_exists( 'codesigner_get_sale_text_with_discount_percentage' ) ) :
	function codesigner_get_sale_text_with_discount_percentage( $product, $sale_text ) {

		if ( 'simple' == $product->get_type() ) {
			$regular_price       = $product->get_regular_price();
			$sale_price          = $product->get_sale_price();
			$discount_percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) . '%';
			$sale_text           = str_replace( '%%discount_percentage%%', $discount_percentage, $sale_text );
		} else {
			$sale_text = str_replace( '%%discount_percentage%%', '', $sale_text );
		}

		return $sale_text;
	}
endif;

/**
 *
 * @return Return true if start date & end date are match
 *
 * @author Mahbub <mahbubmr500@@gmail.com>
 * @since 4.3.3.1
 */
if ( ! function_exists( 'mothers_day_promo_start_and_end_time' ) ) :
	function mothers_day_promo_start_and_end_time( $current_time ) {
		$nextSunday  = new \DateTime( '2024-08-27' );
		$nextFriday  = new \DateTime( '2024-08-28' );
		$next_sunday = $nextSunday->getTimestamp();
		$next_friday = $nextFriday->getTimestamp();

		return $current_time >= $next_sunday && $current_time <= $next_friday;
	}
endif;


/**
 *
 *
 * @author Soikut <shadekur.rahman60@gmail.com>
 * @since 4.5.6
 */

if ( ! function_exists( 'codesigner_notices_values' ) ) :
	function codesigner_notices_values() {
		$current_time = date_i18n( 'U' );

		return array(
			'codesigner_promotional_campain' => array(
				'from'   => $current_time,
				'to'     => strtotime( '2025-01-20 00:00:00' ),
				'button' => __( 'Grab Now', 'codesigner' ),
				'url'    => 'https://codexpert.io/codesigner/pricing?utm_source=in+plugin&utm_medium=notice&utm_campaign=new-year-2025',
			),
		);
	}
endif;

if ( ! function_exists( 'get_codesigner_countdown_html' ) ) :
	function get_codesigner_countdown_html( $from, $to ) {
		$to = date_i18n( 'Y/m/d H:i:s', $to );
		return '
		<div class="codesigner-countdown" id="codesigner-countdown" data-countdown-end="' . $to . '">
			<div class="cx-count">
				<span id="days"></span>
				<label>DAYS</label>
			</div>
			<div class="cx-count">
				<span id="hours"></span>
				<label>HRS</label>
			</div>
			<div class="cx-count">
				<span id="minutes"></span>
				<label>MINS</label>
			</div>
			<div class="cx-count">
				<span id="seconds"></span>
				<label>SEC</label>
			</div>
		</div>';
	}

endif;


/**
 *
 *
 * @author Soikut <shadekur.rahman60@gmail.com>
 * @since 4.7.1
 */

if ( ! function_exists( 'promotional_widgets' ) ) :
	function promotional_widgets() {
		$wlbi_promo = 'wlbi-promo';
		return array(
			array(
				'name'     => 'codesigner-shop-flip',
				'title'    => __( 'Shop Flip', 'codesigner' ),
				'icon'     => 'eicon-flip-box' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-shopify',
				'title'    => __( 'Shop Shopify', 'codesigner' ),
				'icon'     => 'eicon-thumbnails-half' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-trendy',
				'title'    => __( 'Shop Trendy', 'codesigner' ),
				'icon'     => 'eicon-products' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-curvy-horizontal',
				'title'    => __( 'Shop Curvy Horizontal' . ' ' . $wlbi_promo, 'codesigner' ),
				'icon'     => 'eicon-posts-group',
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-accordion',
				'title'    => __( 'Shop Accordion', 'codesigner' ),
				'icon'     => 'eicon-accordion' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-table',
				'title'    => __( 'Shop Table', 'codesigner' ),
				'icon'     => 'eicon-table' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-beauty',
				'title'    => __( 'Shop Beauty', 'codesigner' ),
				'icon'     => 'eicon-thumbnails-half' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop' . ' ' . $wlbi_promo,
			),
			array(
				'name'     => 'codesigner-shop-smart',
				'title'    => __( 'Shop Smart', 'codesigner' ),
				'icon'     => 'eicon-thumbnails-half' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-minimal',
				'title'    => __( 'Shop Minimal', 'codesigner' ),
				'icon'     => 'eicon-thumbnails-half' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			array(
				'name'     => 'codesigner-shop-wix',
				'title'    => __( 'Shop Wix', 'codesigner' ),
				'icon'     => 'eicon-thumbnails-half' . ' ' . $wlbi_promo,
				'category' => 'codesigner-shop',
			),
			// [
			// 'name'       => 'codesigner-shop-shopify',
			// 'title'      => __( 'Shop Shopify', 'codesigner' ),
			// 'icon'       => 'eicon-thumbnails-half',
			// 'category'   => 'codesigner-shop',
			// ],
			array(
				'name'     => 'codesigner-filter-vertical',
				'title'    => __( 'Filter Vertical', 'codesigner' ),
				'icon'     => 'eicon-ellipsis-v' . ' ' . $wlbi_promo,
				'category' => 'codesigner-filter',
			),
			array(
				'name'     => 'codesigner-filter-advance',
				'title'    => __( 'Filter Advance', 'codesigner' ),
				'icon'     => 'eicon-filter' . ' ' . $wlbi_promo,
				'category' => 'codesigner-filter',
			),
			array(
				'name'     => 'codesigner-product-dynamic-tabs',
				'title'    => __( 'Product Dynamic Tabs', 'codesigner' ),
				'icon'     => 'eicon-product-tabs' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
			array(
				'name'     => 'codesigner-product-comparison-button',
				'title'    => __( 'Add to Compare', 'codesigner' ),
				'icon'     => 'eicon-cart' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
			array(
				'name'     => 'codesigner-ask-for-price',
				'title'    => __( 'Ask for Price', 'codesigner' ),
				'icon'     => 'eicon-cart' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
			array(
				'name'     => 'codesigner-quick-checkout-button',
				'title'    => __( 'Quick Checkout Button', 'codesigner' ),
				'icon'     => 'eicon-cart' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
			array(
				'name'     => 'codesigner-product-barcode',
				'title'    => __( 'Product Barcode', 'codesigner' ),
				'icon'     => 'eicon-barcode' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
			array(
				'name'     => 'codesigner-pricing-table-regular',
				'title'    => __( 'Pricing Table Regular', 'codesigner' ),
				'icon'     => 'eicon-price-table' . ' ' . $wlbi_promo,
				'category' => 'codesigner-pricing',
			),
			array(
				'name'     => 'codesigner-pricing-table-smart',
				'title'    => __( 'Pricing Table Smart', 'codesigner' ),
				'icon'     => 'eicon-price-table' . ' ' . $wlbi_promo,
				'category' => 'codesigner-pricing',
			),
			array(
				'name'     => 'codesigner-pricing-table-fancy',
				'title'    => __( 'Pricing Table Fancy', 'codesigner' ),
				'icon'     => 'eicon-price-table' . ' ' . $wlbi_promo,
				'category' => 'codesigner-pricing',
			),
			array(
				'name'     => 'codesigner-related-products-flip',
				'title'    => __( 'Related Products Flip', 'codesigner' ),
				'icon'     => 'eicon-flip-box' . ' ' . $wlbi_promo,
				'category' => 'codesigner-related',
			),
			array(
				'name'     => 'codesigner-related-products-trendy',
				'title'    => __( 'Related Products Trendy', 'codesigner' ),
				'icon'     => 'eicon-products' . ' ' . $wlbi_promo,
				'category' => 'codesigner-related',
			),
			array(
				'name'     => 'codesigner-related-products-accordion',
				'title'    => __( 'Related Products Accordion', 'codesigner' ),
				'icon'     => 'eicon-accordion' . ' ' . $wlbi_promo,
				'category' => 'codesigner-related',
			),
			array(
				'name'     => 'codesigner-related-products-table',
				'title'    => __( 'Related Products Table', 'codesigner' ),
				'icon'     => 'eicon-accordion' . ' ' . $wlbi_promo,
				'category' => 'codesigner-related',
			),
			array(
				'name'     => 'codesigner-floating-cart',
				'title'    => __( 'Floating Cart', 'codesigner' ),
				'icon'     => 'eicon-product-meta ' . ' ' . $wlbi_promo,
				'category' => 'codesigner-cart',
			),
			array(
				'name'     => 'codesigner-billing-address',
				'title'    => __( 'Billing Address', 'codesigner' ),
				'icon'     => 'eicon-google-maps' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-shipping-address',
				'title'    => __( 'Shipping Address', 'codesigner' ),
				'icon'     => 'eicon-google-maps' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-order-notes',
				'title'    => __( 'Order Notes', 'codesigner' ),
				'icon'     => 'eicon-table-of-contents' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-order-review',
				'title'    => __( 'Order Review', 'codesigner' ),
				'icon'     => 'eicon-product-info' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-order-pay',
				'title'    => __( 'Order Pay', 'codesigner' ),
				'icon'     => 'eicon-product-info' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-payment-methods',
				'title'    => __( 'Payment Methods', 'codesigner' ),
				'icon'     => 'eicon-product-upsell' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-thankyou',
				'title'    => __( 'Thank You', 'codesigner' ),
				'icon'     => 'eicon-nerd' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-checkout-login',
				'title'    => __( 'Checkout Login', 'codesigner' ),
				'icon'     => 'eicon-lock-user' . ' ' . $wlbi_promo,
				'category' => 'codesigner-checkout',
			),
			array(
				'name'     => 'codesigner-email-header',
				'title'    => __( 'Email Header', 'codesigner' ),
				'icon'     => 'eicon-header' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-footer',
				'title'    => __( 'Email Footer', 'codesigner' ),
				'icon'     => 'eicon-footer' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-item-details',
				'title'    => __( 'Email Item Details', 'codesigner' ),
				'icon'     => 'eicon-kit-details' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-billing-addresses',
				'title'    => __( 'Email Billing Addresses', 'codesigner' ),
				'icon'     => 'eicon-table-of-contents' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-shipping-addresses',
				'title'    => __( 'Email Shipping Addresses', 'codesigner' ),
				'icon'     => 'eicon-purchase-summary' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-customer-note',
				'title'    => __( 'Email Customer Note', 'codesigner' ),
				'icon'     => 'eicon-document-file' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-order-note',
				'title'    => __( 'Email Order Note', 'codesigner' ),
				'icon'     => 'eicon-document-file' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-description',
				'title'    => __( 'Email Description', 'codesigner' ),
				'icon'     => 'eicon-menu-toggle' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-email-reminder',
				'title'    => __( 'Email Reminder', 'codesigner' ),
				'icon'     => 'eicon-menu-toggle' . ' ' . $wlbi_promo,
				'category' => 'codesigner-email',
			),
			array(
				'name'     => 'codesigner-my-account-advanced',
				'title'    => __( 'My Account Advanced', 'codesigner' ),
				'icon'     => 'eicon-call-to-action' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-wishlist',
				'title'    => __( 'Wishlist', 'codesigner' ),
				'icon'     => 'eicon-heart-o' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-customer-reviews-standard',
				'title'    => __( 'Customer Reviews Standard', 'codesigner' ),
				'icon'     => 'eicon-review' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-customer-reviews-trendy',
				'title'    => __( 'Customer Reviews Trendy', 'codesigner' ),
				'icon'     => 'eicon-rating' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-faqs-accordion',
				'title'    => __( 'FAQs Accordion', 'codesigner' ),
				'icon'     => 'eicon-accordion' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-sales-notification',
				'title'    => __( 'Sales Notification', 'codesigner' ),
				'icon'     => 'eicon-posts-ticker' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-category',
				'title'    => __( 'Shop Categories', 'codesigner' ),
				'icon'     => 'eicon-flow' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-basic-menu',
				'title'    => __( 'Basic Menu', 'codesigner' ),
				'icon'     => 'eicon-nav-menu' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-dynamic-tabs',
				'title'    => __( 'Dynamic Tabs', 'codesigner' ),
				'icon'     => 'eicon-tabs' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-menu-cart',
				'title'    => __( 'Menu Cart', 'codesigner' ),
				'icon'     => 'eicon-cart' . ' ' . $wlbi_promo,
				'category' => 'codesigner',
			),
			array(
				'name'     => 'codesigner-product-add-to-wishlist',
				'title'    => __( 'Add to Wishlist', 'codesigner' ),
				'icon'     => 'eicon-tags' . ' ' . $wlbi_promo,
				'category' => 'codesigner-single',
			),
		);
	}
endif;
