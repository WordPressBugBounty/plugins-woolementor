<?php 
	$check	   	= CODESIGNER_ASSETS . '/img/general/get-started/check-mark.png';
	$hand	   	= CODESIGNER_ASSETS . '/img/general/get-started/hand.png';
	$hero	   	= CODESIGNER_ASSETS . '/img/general/get-started/hero-image.png';
	$checkL	   	= CODESIGNER_ASSETS . '/img/general/get-started/check-light.png';
	$danger	   	= CODESIGNER_ASSETS . '/img/general/get-started/danger.png';
	$easycommerce	= CODESIGNER_ASSETS . '/img/general/get-started/easycommerce.png';
	$thumbpress		= CODESIGNER_ASSETS . '/img/general/get-started/thumbpress.png';
	$wcaffiliate	= CODESIGNER_ASSETS . '/img/general/get-started/wc-affiliate.png';

	$easycommerce_features = [
		'Unoptimized+Checkout' => [
			'title' 	=> 'Unoptimized Checkout',
			'desc' 		=> 'Your hard-earned store visitors are abandoning their carts due to a unoptimized checkout page. Equip your online store with all the essentials of an easy checkout.',
			'fix_link' 	=> 'https://codexpert.io/customize-checkout-page-in-woocommerce/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=customize+checkout+page',
			'active' 	=> false
		],
		'Basic+Shop+Page' => [
			'title' 	=> 'Basic Shop Page',
			'desc' 		=> 'Your shop page feels very basic and poorly designed, causing your store visitors to leave without purchasing. Update it with lucrative shop designs to boost conversions.',
			'fix_link' 	=> 'https://codexpert.io/customize-shop-page-in-woocommerce/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=customize+shop+page',
			'active' 	=> false
		],
		'No+Wishlist+Option' => [
			'title' 	=> 'No Wishlist Option',
			'desc' 		=> 'Your product pages are lacking a wishlist option. Add this feature to let visitors bookmark their favorites to increase the likelihood of a return purchase.',
			'fix_link' 	=> 'https://codexpert.io/create-wishlist-for-woocommerce-store/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=create+wishlist',
			'active' 	=> false
		],
		'Missing+Related+Products' => [
			'title' 	=> 'Missing Related Products',
			'desc' 		=> 'You\'re missing potential sales due to not showing related products. Add this option to your WooCommerce store, increase upsells and ensure a positive revenue growth.',
			'fix_link' 	=> 'https://codexpert.io/how-to-add-related-products-in-woocommerce/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=add+related+products',
			'active' 	=> false
		],
		'Outdated+Email' => [
			'title' 	=> 'Outdated Email',
			'desc' 		=> 'WooCommerce\'s default outdated email layout causes your audience to ignore emails. Use CoDesigner to refresh the design with stunning templates & customization.',
			'fix_link' 	=> 'https://codexpert.io/design-woocommerce-email-elementor-codesigner/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=customize+woocommerce+email',
			'active' 	=> false
		],
		'Missed+Sales+Notifications' => [
			'title' 	=> 'Missed Sales Notifications',
			'desc' 		=> 'Your store doesn\'t have any sales notification system. Implement sales alert in your website with CoDesigner to increase authenticity and conversions.',
			'fix_link' 	=> 'https://codexpert.io/live-sales-notification-on-woocommerce/?utm_source=in-pluign&utm_medium=getting+started&utm_campaign=add+live+sales+notification',
			'active' 	=> false
		],
	];

	$recommeded_plugins = [
		[
			'title' => 'Easycommerce',
			'logo'	=> $easycommerce,
			'desc'	=> 'you designed, competing with WooCommerce and SureCart.',
			'url' 	=> '#'
		],
		[
			'title' => 'WC Affiliate',
			'logo'	=> $wcaffiliate,
			'desc'	=> 'you designed, competing with and SureCart. WooCommerce and SureCart. ',
			'url' 	=> '#'
		],
		[
			'title' => 'ThumbPress',
			'logo'	=> $thumbpress,
			'desc'	=> 'you designed, competing with WooCommerce and SureCart.',
			'url' 	=> '#'
		]
	];

?>
<div class="cd-general-wrapper cd-started-page-wrapper">
		

	<div class="cd-started-page-content-wrapper">
		<main class="cd-started-page-main-wrapper">
			<!-- Hero section -->
			<section class="cd-hero-section-wrapper">
				<div class="cd-hero-content-section">
					<span><?php printf( esc_html__( 'Hello, %1$s', 'codesigner' ), esc_html( get_userdata( get_current_user_id() )->display_name ) ); ?></span>

					<h1><?php esc_html_e( 'Welcome to CoDesigner', 'codesigner' ); ?> 🥳</h1>
					<p><?php esc_html_e( 'Take your ecommerce store to the next level with CoDesigner. Add, customize, and enhance your WooCommerce store’s appearance and functionality to drive more sales and revenues.', 'codesigner' ); ?></p>
					<div class="cd-btn-wrapper">
						<a href="https://help.codexpert.io/docs/codesigner" class="cd-btn active"><?php esc_html_e( 'Documentation', 'codesigner' ); ?></a>
						<a href="https://help.pluggable.io/" class="cd-btn"><?php esc_html_e( 'Get Support', 'codesigner' ); ?></a>
					</div>
				</div>
				<div class="cd-hero-image-section">
					<img src="<?php esc_attr_e( $hero ); ?>" alt="">
				</div>
			</section>

			<!-- Easycommerce section -->
			<section class="cd-easycommerce-section-wrapper">
				<h2>🚨 <?php esc_html_e( 'Sales at Risk: Critical Problems Identified', 'codesigner' ); ?></h2>
				<div class="cd-grid">
					<?php 
						foreach ( $easycommerce_features as $id => $easycommerce_feature ) {
							$is_active = $easycommerce_feature['active'];
							?>
							<div class="cd-easycommerce-content <?php echo $is_active ? 'cd-success' : 'cd-danger'; ?>">
								<div class="cd-grid-header">
									<h3><?php esc_html_e( $easycommerce_feature['title'] ); ?></h3>
									<img src="<?php esc_attr_e( $is_active ? $checkL : $danger ); ?>" >
								</div>
								<div class="cd-grid-content">
									<p><?php esc_html_e( $easycommerce_feature['desc'] ); ?></p>
									<?php if( ! $is_active ) {
										?>
										<a href="<?php echo esc_attr( $easycommerce_feature['fix_link'] ); ?>" target="_blank"><?php esc_html_e( 'Fix Now', 'codesigner' ); ?></a>
										<?php
									} ?>
								</div>
							</div>
							<?php
						}
					?>
				</div>
			</section>

			<!-- Recommended Plugins -->
			<?php if( false ) : ?>
			<section class="cd-recommended-section">
				<h2><?php esc_html_e( 'Our Plugin Recommendations', 'codesigner' ); ?></h2>
				<div class="cd-recommeded-grids">
					<?php 
						foreach ( $recommeded_plugins as $recommeded_plugin ) {
							?>
								<div class="cd-recommeded-grid-item">
									<div class="cd-recommeded-item-header">
										<img src="<?php esc_attr_e( $recommeded_plugin['logo'] ) ?>">
										<h4><?php esc_html_e( $recommeded_plugin['title'] ); ?></h4>
									</div>
									<div class="cd-recommeded-item-content">
										<p><?php esc_html_e( $recommeded_plugin['desc'] ); ?></p>
										<a href="<?php echo esc_url( $recommeded_plugin['url'] ); ?>"><?php esc_html_e( 'Install Now', 'codesigner' ); ?></a>
									</div>
								</div>
							<?php
						}
						
					?>
				</div>
			</section>
			<?php endif; ?>

		</main>
<!-- 		<aside class="cd-started-page-sidebar-wrapper">
			<h2><?php esc_html_e( 'Optimize Your Store For More Sales & Revenues', 'codesigner' ); ?></h2>
			<p><?php esc_html_e( 'CoDesigner gives you complete freedom to get the exact look and feel you desire for your store.', 'codesigner' ); ?></p>
			<ul>
				<?php 
					$sidebar_lists = [
						'<strong>94+</strong> Widgets',
						'<strong>14+</strong> Modules',
						'<strong>24+</strong> Page Templates',
						'<strong>130+</strong> Section Templates'
					];
					foreach ( $sidebar_lists as $list ) {
						printf( '<li><img src="%1$s" alt="%2$s">%3$s</li>', esc_html( $check ), 'check', esc_html( $list ) );
					}
				?>
			</ul>
			<a href="https://codexpert.io/codesigner/pricing?utm_source=in+plugin&utm_medium=getting+started&utm_campaign=get+pro">
				<?php esc_html_e( 'Get Pro Now', 'codesigner' ); ?>
			</a>
		</aside> -->
	</div>

</div>