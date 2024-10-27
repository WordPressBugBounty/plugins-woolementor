<?php 
$banner 			= CODESIGNER_ASSETS . '/img/general/banner.svg';
$item_1             = CODESIGNER_ASSETS . '/img/general/item-1.svg';
$item_2             = CODESIGNER_ASSETS . '/img/general/item-2.svg';
$item_3             = CODESIGNER_ASSETS . '/img/general/item-3.svg';
$acc_plus             = CODESIGNER_ASSETS . '/img/general/acc-plus.svg';
$acc_minus             = CODESIGNER_ASSETS . '/img/general/acc-minus.svg';
$tick_yes             = CODESIGNER_ASSETS . '/img/general/tick-yes.png';
$tick_no              = CODESIGNER_ASSETS . '/img/general/tick-no.png';
$arrow_right			= CODESIGNER_ASSETS . '/img/general/arrow.png';
$blog_1             = CODESIGNER_ASSETS . '/img/general/blog-1.png';
$blog_2             = CODESIGNER_ASSETS . '/img/general/blog-2.webp';
$blog_3             = CODESIGNER_ASSETS . '/img/general/blog-3.jpg';




$utm				= [ 'utm_source' => 'In-plugin', 'utm_medium' => 'In-plugin+overview', 'utm_campaign' => 'at+a+glance' ];
$pro_link			= add_query_arg( $utm, 'https://codexpert.io/codesigner' );

$home_url			= [ 'source' => 'dashboard', 'medium' => 'settings', 'url' => 'home-url' ];
$home_redirect		= add_query_arg( $home_url, 'https://codexpert.io/codesigner/' );

$pricing_url		= [ 'source' => 'dashboard', 'medium' => 'settings', 'url' => 'pricing-url' ];
$pricing_redirect	= add_query_arg( $pricing_url, 'https://codexpert.io/codesigner/pricing' );
?>

<div class="wl-general-content">

    <div class="wl-general-content-banner">

        <img src="<?php echo esc_url( $banner ); ?>" alt="CoDesigner Official Page">
    </div>

    <div class="wl-options">
        <a class="wl-item" href="https://help.codexpert.io/docs/codesigner" target="_blank">
            <img src="<?php echo esc_url( $item_1 ); ?>" alt="docs">
        </a>
        <a class="wl-item" href="https://help.codexpert.io/tickets/" target="_blank">
            <img src="<?php echo esc_url( $item_2 ); ?>" alt="support">
        </a>
        <a class="wl-item" href="https://wordpress.org/support/plugin/woolementor/reviews/?filter=5#new-post"
            target="_blank">
            <img src="<?php echo esc_url( $item_3 ); ?>" alt="review">
        </a>
    </div>

    <div class="wl-pricing-comp">
        <h1>Comparison Between <span>Free vs Pro</span></h1>
        <p>While CoDesigner free version comes with a wide range of awesome features, the Pro version gives you the
            limitless freedom to take your WooCommerce store to the next level.</p>

        <div class="wl-accordion">
            <div class="wl-accordion-item">
                <div class="wl-accordion-header">
                    <span class="wl-accordion-title">Overview</span>
                    <img src="<?php echo esc_url( $acc_plus ); ?>" alt="+" class="wl-accordion-icon wl-accordion-plus">
                    <img src="<?php echo esc_url( $acc_minus ); ?>" alt="-"
                        class="wl-accordion-icon wl-accordion-minus">
                </div>
                <div class="wl-accordion-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Overview</th>
                                <th class="wl-th-free">Free</th>
                                <th class="wl-th-pro">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Modules</td>
                                <td>12</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td>Widgets</td>
                                <td>41</td>
                                <td>95</td>
                            </tr>
                            <tr>
                                <td>Templates</td>
                                <td>42</td>
                                <td>159</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="wl-accordion-item">
                <div class="wl-accordion-header">
                    <span class="wl-accordion-title">Modules</span>
                    <img src="<?php echo esc_url( $acc_plus ); ?>" alt="+" class="wl-accordion-icon wl-accordion-plus">
                    <img src="<?php echo esc_url( $acc_minus ); ?>" alt="-"
                        class="wl-accordion-icon wl-accordion-minus">
                </div>
                <div class="wl-accordion-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Modules</th>
                                <th class="wl-th-free">Free</th>
                                <th class="wl-th-pro">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Checkout Builder</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Brands</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Currency Switcher</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Invoice Builder</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Variation Swatches</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Bulk Purchase Discount</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Templates</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Add To Cart Text</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Skip Cart Page</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Flash Sale</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Partial Payment</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Backorder</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Preorder</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Single Product Ajax Add To Cart</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Badges</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="wl-accordion-item">
                <div class="wl-accordion-header">
                    <span class="wl-accordion-title">Widgets</span>
                    <img src="<?php echo esc_url( $acc_plus ); ?>" alt="+" class="wl-accordion-icon wl-accordion-plus">
                    <img src="<?php echo esc_url( $acc_minus ); ?>" alt="-"
                        class="wl-accordion-icon wl-accordion-minus">
                </div>
                <div class="wl-accordion-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Widgets</th>
                                <th class="wl-th-free">Free</th>
                                <th class="wl-th-pro">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <th id="wl-subhead">General</th>
                            <tr>
                                <td>My Account</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>My Account Advanced</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Wishlist</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Customers Reviews Classic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Customer Reviews Standard</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Customer Reviews Trendy</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Menu Cart</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>FAQs Accordion</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Sales Notification</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Categories</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Gradient Button</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Tabs Classic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Tabs Beauty</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Tabs Basic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Tabs Fancy</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Basic Menu</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Image Comparison</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Barcode</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Comparison</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Dynamic Tabs</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>

                            <th id="wl-subhead">Checkout</th>
                            <tr>
                                <td>Billing Address</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shipping Address</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Order Notes</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Order Review</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Order Pay</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Payment Methods</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Thank You</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>

                            <th id="wl-subhead">Shop</th>
                            <tr>
                                <td>Shop Classic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Standard</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Curvy</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Slider</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Flip</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Trendy</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Curvy Horizontal</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Accordion</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Table</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Beauty</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Wix</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Shopify</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Smart</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Shop Minimal</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <th id="wl-subhead">Image Gallery</th>
                            <tr>
                                <td>Gallery Fancybox</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Gallery LC Lightbox</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Gallery Box Slider</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>

                            <th id="wl-subhead">Email</th>
                            <tr>
                                <td>Email Header</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Footer</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Item Details</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Billing Addresses</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Shipping Addresses</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Customer Note</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Order Note</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Description</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Email Reminder</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>

                            <th id="wl-subhead">Filter</th>
                            <tr>
                                <td>Filter Horizontal</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Filter Vertical</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Filter Advance</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <th id="wl-subhead">Single Product</th>
                            <tr>
                                <td>Product Title</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Price</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Rating</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Breadcrumbs</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Short Description</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Variations</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Add to Cart</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product SKU</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Stock</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Additional Information</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Tabs</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Dynamic Tabs</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Meta</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Categories</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Tags</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Thumbnail</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Product Gallery</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Add to Wishlist</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Add to Compare</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Ask for Price</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Quick Checkout Button</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <th id="wl-subhead">Pricing Table</th>
                            <tr>
                                <td>Pricing Table Advanced</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Pricing Table Basic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Pricing Table Smart</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Pricing Table Regular</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Pricing Table Fancy</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <th id="wl-subhead">Related Products</th>
                            <tr>
                                <td>Related Product Classic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Flip</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Standard</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Curvy</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Trendy</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Accordion</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Related Product Table</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <th id="wl-subhead">Cart</th>
                            <tr>
                                <td>Cart Items</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Cart Items Classic</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Cart Overview</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Coupon Form</td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>
                            <tr>
                                <td>Floating Cart</td>
                                <td><img src="<?php echo esc_url( $tick_no ); ?>" alt="no"></td>
                                <td><img src="<?php echo esc_url( $tick_yes ); ?>" alt="yes"></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="wl-cta-sec">
        <h1>Unlock all the features with CoDesigner Pro and design your dream WooCommerce store.</h1>
        <a href="https://codexpert.io/codesigner/pricing?utm_source=in+plugin&utm_medium=getting+started&utm_campaign=get+pro">Get Pro Now</a>
    </div>

    <div class="wl-blog-sec">
        <h1>Blogs & Resources</h1>
        <p>Read our in-depth blogs and resources to know everything about how to take your WooCommerce store sales and
            revenues to the next level.</p>
        <div class="wl-blog-content">
            <div class="wl-card-blog">
                <img src="<?php echo esc_url( $blog_1 ); ?>" alt="blog-img">
                <h2>Customize WooCommerce Emails With Elementor – A Step-by-Step Guide</h2>
                <p>Is your inbox overflowing with boring WooCommerce emails? Let’s face it, those default templates
                    don’t exactly scream brand personality...
                </p>
                <a class="wl-blogLink" href="https://codexpert.io/design-woocommerce-email-elementor-codesigner/"
                    target="_blank">Read
                    more &#x2192;</a>
            </div>
            <div class="wl-card-blog">
                <img src="<?php echo esc_url( $blog_2 ); ?>" alt="blog-img">
                <h2>How to Customize Checkout Page in WooCommerce</h2>

                <p>Shopping cart abandonment is a major problem for online stores. And more often than not, a clunky
                    checkout page can be the culprit...
                </p>

                <a class="wl-blogLink" href="https://codexpert.io/customize-checkout-page-in-woocommerce/"
                    target="_blank">Read more
                    &#x2192;</a>
            </div>
            <div class="wl-card-blog">
                <img src="<?php echo esc_url( $blog_3 ); ?>" alt="blog-img">
                <h2>WooCommerce Inventory Management – A Complete Guide</h2>

                <p>There’s nothing worse than seeing a customer’s excitement turn to frustration at checkout. Poor
                    inventory management can lead to a cycle of disappointment...
                </p>

                <a class="wl-blogLink" href="https://codexpert.io/woocommerce-inventory-management/"
                    target="_blank">Read more
                    &#x2192; </a>
            </div>
        </div>
        <div class="wl-cta-btn">
            <a href="https://codexpert.io/blog/?utm_source=in+plugin&utm_medium=getting+started&utm_campaign=read+all+blogs" target="_blank">Read all Blogs &nbsp;<img
                    src="<?php echo esc_url( $arrow_right ); ?>" alt="arrow_right"></a>
        </div>
    </div>
</div>