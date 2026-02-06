<?php
    $easycommerce = CODESIGNER_ASSETS . '/img/general/get-started/new/easycommerce.svg';
    $hero_line    = CODESIGNER_ASSETS . '/img/general/get-started/new/lines.svg';
    $cta_bg       = CODESIGNER_ASSETS . '/img/general/get-started/new/upgrade-to-pro-cta-background.svg';
    $easy_bg      = CODESIGNER_ASSETS . '/img/general/get-started/new/easycommerce-campaign-background.svg';

	$premium_features = [
		[
			'title' => '10+ Customizable Premium Shop Widgets',
			'desc'  => 'Pre-designed widgets you can customize to match your brand, giving your store a modern look that sells. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/customizable-shop-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/shop-widgets/?utm_source=in+plugin&utm_medium=codesigner+shop&utm_campaign=dashboard#shop-flip',
		],
		[
			'title' => 'Lucrative Checkout Widgets and Templates',
			'desc' 	=> 'Boost sales with ready-made checkout templates that make buying easy and reduce cart abandonment. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/lucrative-checkout-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/checkout-widgets?utm_source=in+plugin&utm_medium=codesigner+checkout&utm_campaign=dashboard',
		],
		[
			'title' => 'Related Product Widgets for Smart Cross-sells',
			'desc' 	=> 'Automatically show personalized product suggestions to increase average order value and encourage repeat. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/related-product-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/related-product-widgets/?utm_source=in+plugin&utm_medium=codesigner+related+product&utm_campaign=dashboard#related-products-flip',
		],
		[
			'title' => 'Live Sales Notifications for real-time purchase alerts.',
			'desc' 	=> 'Build trust and urgency by displaying real-time sales popups, inspiring confidence, and making faster customer. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/live-sales-notifications-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/general-widgets/?utm_source=in+plugin&utm_medium=codesigner+sales+notification&utm_campaign=dashboard#sales-notification',
		],
		[
			'title' => 'Personalized Invoice Builder with Templates',
			'desc' 	=> 'Instantly create stylish, branded invoices designed for each customer to enhance your brand image and customer. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/personalized-invoice-builder-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/modules/?utm_source=in+plugin&utm_medium=codesigner+invoice&utm_campaign=dashboard',
		],
		[
			'title' => 'Single Product Widgets for Beautiful Stores',
			'desc' 	=> 'Highlight individual products with detail-rich widgets designed to maximize engagement and conversions. ',
            'img'   => CODESIGNER_ASSETS . '/img/general/get-started/new/single-product-widgets.svg',
			'link' 	=> 'https://codexpert.io/codesigner/single-product-widgets/?utm_source=in+plugin&utm_medium=codesigner+single+product&utm_campaign=dashboard',
		],
	];

?>

<div class="cd-general-wrapper cd-started-page-wrapper">
	<div class="cd-started-page-content-wrapper">
		<main class="cd-started-page-main-wrapper">
			<!-- Hero section -->
			<section class="cd-hero-section-wrapper">
				<div class="cd-hero-content-section">
					<h1><?php printf( esc_html__( 'Welcome to CoDesigner, %1$s!', 'codesigner' ), esc_html( get_userdata( get_current_user_id() )->display_name ) ); ?>🥳</h1>
					<p><?php esc_html_e( 'Take your eCommerce store to the next level with CoDesigner. Add, customize, and enhance your WooCommerce store\'s appearance and functionality.', 'codesigner' ); ?></p>
				</div>
			</section>

			<!-- Premium features and campaign sidebar -->
			<section class="cd-premium-section-wrapper">
				<h2>
                    <span class="cd-gradient-text"><?php esc_html_e( 'CoDesigner Pro', 'codesigner' ); ?></span>
                    <?php esc_html_e( 'Features', 'codesigner' ); ?>
                </h2>
                <div class="cd-premium-section-container">
                    <div class="cd-premium-features-wrapper">
                        <div class="cd-grid">
                            <?php foreach ( $premium_features as $id => $premium_feature ): ?>
                                <div class="cd-feature-content">
                                    <img src="<?php echo esc_url( $premium_feature['img'] ); ?>" alt="<?php echo esc_attr( $premium_feature['title'] ); ?>" class="cd-feature-icon">
                                    <div class="cd-grid-header">
                                        <h3 class="cd-gradient-text"><?php echo esc_html( $premium_feature['title'] ); ?></h3>
                                    </div>
                                    <div class="cd-grid-content">
                                        <p><?php echo esc_html( $premium_feature['desc'] ); ?></p>
                                        <a href="<?php echo esc_attr( $premium_feature['link'] ); ?>" target="_blank"><?php esc_html_e( 'Read More', 'codesigner' ); ?></a>
                                        
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- upgrade to pro cta -->
                        <div class="cd-upgrade-cta">
                            <h3><?php esc_html_e( 'Upgrade to CoDesigner Pro', 'codesigner' ); ?></h3>
                            <p><?php esc_html_e( 'Win more customers with better design, faster checkout, and smart widgets made just for your WooCommerce store.', 'codesigner' ); ?></p>

                            <div class="cd-btn-wrapper">
                                <a id="upgrade-now" target="_blank" href="<?php echo esc_url( 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=button&utm_campaign=year-end' ); ?>" class="cd-btn">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5254 8.68806L5.00092 9.66919C4.7218 10.3427 4.49916 11.0364 4.33509 11.7436L4.24119 12.1516L7.79014 15.5458L8.21696 15.4581C8.95691 15.3012 9.68265 15.0884 10.3873 14.8216L11.4138 17.1878C11.4239 17.2112 11.4398 17.2319 11.4603 17.248C11.4808 17.2641 11.5052 17.275 11.5312 17.2799C11.5573 17.2847 11.5841 17.2833 11.6095 17.2758C11.6348 17.2683 11.6577 17.2548 11.6763 17.2367L13.2278 15.7538C13.4809 15.5118 13.6782 15.2218 13.8069 14.9024C13.9355 14.5831 13.9927 14.2415 13.9747 13.8997L13.9192 12.9471C16.7916 10.9196 19.6982 7.36425 20.49 1.15927C20.5124 1.0037 20.497 0.845271 20.4449 0.696337C20.3928 0.547403 20.3054 0.411987 20.1895 0.300643C20.0736 0.189299 19.9324 0.105036 19.7769 0.0544211C19.6213 0.00380637 19.4557 -0.0117923 19.2928 0.00884084C12.8031 0.771715 9.08125 3.55192 6.95999 6.28929L5.96551 6.24034C5.6087 6.22178 5.25177 6.2748 4.91767 6.396C4.58358 6.5172 4.27973 6.70389 4.02565 6.94406L2.47418 8.42697C2.45268 8.44444 2.4364 8.46702 2.42698 8.49244C2.41756 8.51786 2.41533 8.54521 2.42053 8.57172C2.42573 8.59822 2.43817 8.62294 2.45659 8.64337C2.475 8.66381 2.49874 8.67922 2.5254 8.68806ZM12.4787 5.07359C12.7476 4.81749 13.0898 4.64328 13.4622 4.57296C13.8346 4.50264 14.2204 4.53937 14.571 4.6785C14.9216 4.81763 15.2211 5.05294 15.4319 5.35469C15.6426 5.65645 15.7551 6.01113 15.7551 6.37394C15.7551 6.73675 15.6426 7.09143 15.4319 7.39319C15.2211 7.69495 14.9216 7.93025 14.571 8.06938C14.2204 8.20851 13.8346 8.24524 13.4622 8.17492C13.0898 8.10461 12.7476 7.9304 12.4787 7.67429C12.2996 7.50374 12.1576 7.30108 12.0606 7.07794C11.9637 6.8548 11.9138 6.61556 11.9138 6.37394C11.9138 6.13232 11.9637 5.89309 12.0606 5.66994C12.1576 5.4468 12.2996 5.24414 12.4787 5.07359ZM2.0623 15.8171C1.6515 15.6793 1.21036 15.6455 0.781862 15.7191C0.743779 15.727 0.704229 15.7255 0.666908 15.7148C0.629588 15.7041 0.595715 15.6846 0.568455 15.658C0.534661 15.6258 0.512032 15.5845 0.503634 15.5396C0.495236 15.4947 0.501475 15.4484 0.521505 15.4071C0.976062 14.4728 2.18181 12.5942 4.36496 14.1118C4.37637 14.1216 4.38549 14.1335 4.39174 14.1469C4.39798 14.1602 4.40121 14.1747 4.40121 14.1893C4.40121 14.2039 4.39798 14.2184 4.39174 14.2318C4.38549 14.2451 4.37637 14.2571 4.36496 14.2668C4.07268 14.4868 3.83867 14.7695 3.68185 15.092C3.52503 15.4144 3.44981 15.7676 3.46225 16.123C3.46384 16.1647 3.48189 16.2043 3.51277 16.2338C3.54365 16.2633 3.58507 16.2806 3.62871 16.2821C3.99896 16.2963 4.36753 16.2274 4.70481 16.0807C5.04209 15.934 5.33867 15.7138 5.57071 15.4377C5.58092 15.4257 5.59378 15.4161 5.60836 15.4095C5.62294 15.4029 5.63887 15.3994 5.65501 15.3994C5.67114 15.3994 5.68708 15.4029 5.70166 15.4095C5.71624 15.4161 5.7291 15.4257 5.7393 15.4377C6.04234 15.7824 6.87676 16.9083 5.95271 17.9955C5.5493 18.459 4.97129 18.7521 4.34362 18.8114C3.44731 18.9032 1.79128 19.1827 1.11478 19.9211C1.08762 19.9518 1.05224 19.975 1.01241 19.988C0.972577 20.001 0.929788 20.0035 0.888606 19.9951C0.847424 19.9868 0.809392 19.9679 0.778566 19.9404C0.74774 19.913 0.725277 19.8781 0.713572 19.8395C0.474556 19.0603 0.103228 17.3183 2.0623 15.8171Z" fill="#1D1D1D"/>
                                    </svg>
                                    <?php esc_html_e( 'Upgrade to Pro', 'codesigner' ); ?>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="cd-campaign-sidebar">
                        <div class="cd-grid">
                            <!-- campaign 1: upgrade to pro -->
                            <div class="cd-campaign-content">
                                <div class="cd-campaign-header">
                                    <h4><?php esc_html_e('Optimize Your Store For More Sales', 'codesign' ) ?></h4>
                                </div>
                                <div class="cd-campaign-content-body">
                                    <p><?php esc_html_e( 'CoDesigner gives you complete freedom to get the exact look and feel you desire for', 'codesigner' ); ?></p>
                                    <ul class="cd-campaign-feature-list">
                                        <li>
                                            <?php echo sprintf(
                                                /* translators: 1: number of widgets, 2: link to widgets page */
                                                esc_html__( '%1$s+ Widgets', 'codesigner' ),
                                                '<strong>94</strong>'
                                            ); ?>
                                        </li>
                                        <li>
                                            <?php echo sprintf(
                                                /* translators: 1: number of modules, 2: link to modules page */
                                                esc_html__( '%1$s+ Modules', 'codesigner' ),
                                                '<strong>14</strong>'
                                            ); ?>
                                        </li>
                                        <li>
                                            <?php echo sprintf(
                                                /* translators: 1: number of page templates, 2: link to page templates */
                                                esc_html__( '%1$s+ Page Templates', 'codesigner' ),
                                                '<strong>24</strong>'
                                            ); ?>
                                        </li>
                                        <li>
                                            <?php echo sprintf(
                                                /* translators: 1: number of section templates, 2: link to section templates */
                                                esc_html__( '%1$s+ Section Templates', 'codesigner' ),
                                                '<strong>130</strong>'
                                            ); ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="cd-btn-wrapper">
                                    <a id="upgrade-now" target="_blank" href="<?php echo esc_url( 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=button&utm_campaign=year-end' ); ?>" class="cd-btn">
                                        <?php esc_html_e( 'Get Pro Now', 'codesigner' ); ?>
                                    </a>
                                </div>
                            </div>

                            <!-- campaign 2: easy commerce -->
                            <div class="cd-campaign-content easycommerce-campaign">
                                <div class="cd-campaign-header">
                                    <a target="_blank" href="<?php echo esc_url( 'https://easycommerce.dev/?utm_source=in+plugin&utm_medium=codesigner&utm_campaign=dashboard' ); ?>">
                                        <img src="<?php echo esc_url( $easycommerce ); ?>" alt="<?php esc_html_e( 'EasyCommerce', 'codesigner' ); ?>" class="cd-campaign-logo">
                                    </a>
                                    <h4><?php esc_html_e('AI-Powered WordPress Ecommcece Plugin', 'codesign' ) ?></h4>
                                </div>
                                <div class="cd-campaign-content-body">
                                    <p><?php esc_html_e( 'AI Content Writer, Image Generator, Template Builder, AI Smart Search and lot more..', 'codesigner' ); ?></p>
                                </div>
                                <div class="cd-btn-wrapper">
                                    <a href="<?php echo esc_url( 'https://easycommerce.dev/?utm_source=in+plugin&utm_medium=codesigner&utm_campaign=dashboard' ); ?>" target="_blank">
                                        <?php esc_html_e( 'Explore Now', 'codesigner' ); ?>
                                       <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.375 1.5L16.5 5.5M16.5 5.5L13.375 9.5M16.5 5.5H1.5" 
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</section>

		</main>
	</div>
</div>

