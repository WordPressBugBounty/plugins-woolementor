<?php 
$banner 			= CODESIGNER_ASSETS . '/img/settings-header-banner.gif';
$footer_banner 		= CODESIGNER_ASSETS . '/img/settings-footer-banner.png';
$support 			= CODESIGNER_ASSETS . '/img/customer-support.png';
$documentation 		= CODESIGNER_ASSETS . '/img/documentation.png';
$love 				= CODESIGNER_ASSETS . '/img/love.png';
$logo 				= CODESIGNER_ASSETS . '/img/codesigner-logo.png';
$contribute 		= CODESIGNER_ASSETS . '/img/contribute.png';
$video 				= CODESIGNER_ASSETS . '/img/codesigner_video.png';

$utm				= [ 'utm_source' => 'In-plugin', 'utm_medium' => 'In-plugin+overview', 'utm_campaign' => 'at+a+glance' ];
$pro_link			= add_query_arg( $utm, 'https://codexpert.io/codesigner' );

$home_url			= [ 'source' => 'dashboard', 'medium' => 'settings', 'url' => 'home-url' ];
$home_redirect		= add_query_arg( $home_url, 'https://codexpert.io/codesigner/' );

$pricing_url		= [ 'source' => 'dashboard', 'medium' => 'settings', 'url' => 'pricing-url' ];
$pricing_redirect	= add_query_arg( $pricing_url, 'https://codexpert.io/codesigner/pricing' );
?>
<div class="wl-content-panel">
	<div class="wl-header-banner">
		<a href="<?php echo esc_url( $home_redirect ); ?>" target="_blank"><img src="<?php echo esc_url( $banner ); ?>" alt=""></a>
	</div>
	<div class="wl-services-panel">
		<div class="wl-services-content">
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $love ); ?>" alt="">
				</div>
				<div class="wl-single-service-content red">
					<h4><?php esc_attr_e( 'Show your Love', 'codesigner' ); ?></h4>
					<p><?php esc_attr_e( 'Your reviews highly motivate us to improve and add exciting features on CoDesigner.', 'woocommerce' ); ?></p>
					<a target="_blank" href="<?php echo esc_url( 'https://wordpress.org/support/plugin/woolementor/reviews/?filter=5#new-post' ); ?>"><?php esc_attr_e( 'Leave a review', 'codesigner' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $documentation ); ?>" alt="">
				</div>
				<div class="wl-single-service-content pink">
					<h4><?php esc_attr_e( 'Documentation', 'codesigner' ); ?></h4>
					<p><?php esc_attr_e( 'Stuck with an issue? Our documentations will guide you through the solution.', 'woocommerce' ); ?></p>
					<a target="_blank" href="<?php echo esc_url( 'https://codexpert.io/codesigner/docs/general/' ); ?>"><?php esc_attr_e( 'Documentation', 'codesigner' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $support ); ?>" alt="">
				</div>
				<div class="wl-single-service-content yellow">
					<h4><?php esc_attr_e( 'Customer Support', 'woocommerce' ); ?></h4>
					<p><?php esc_attr_e( 'We have a super friendly support team to provide you with technical assistance and answers.', 'codesigner' )	; ?></p>
					<a target="_blank" href="<?php echo esc_url( 'https://help.codexpert.io/tickets/' ); ?>"><?php esc_attr_e( 'Support', 'codesigner' ); ?></a>
				</div>
			</div>
			<div class="wl-single-service">
				<div class="wl-single-service-logo">
					<img src="<?php echo esc_url( $contribute ); ?>" alt="">
				</div>
				<div class="wl-single-service-content blue">
					<h4><?php esc_attr_e( 'Blog', 'codesigner' ); ?></h4>
					<p><?php esc_attr_e( 'Learn more about CoDesigner and WooCommerce from our helpful blog posts and tutorials.', 'codesigner' ); ?></p>
					<a target="_blank" href="<?php echo esc_url( 'https://codexpert.io/blog/' ); ?>"><?php esc_attr_e( 'Visit', 'codesigner' ); ?></a>
				</div>
			</div>
		</div>
		<!-- <div class="wl-services-video">
			<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank">
				<img src="<?php echo esc_url( $video ); ?>" alt="">
			</a>
		</div> -->
	</div>
	<div class="wl-bottom-panel">
		<div class="wl-footer-banner" style="background-image: url(<?php echo esc_url( $footer_banner ); ?>);">
			<div class="wl-footer-banner-left">
				<img src="<?php echo esc_url( $logo ); ?>" alt="">
				<p><?php esc_attr_e( 'Customize your WooCommerce store with Elementor.', 'codesigner' ); ?></p>
			</div>
			<?php if ( ! wcd_is_pro_activated() ) : ?>
				<a target='_blank' class='wl-upgrade-btn' href='<?php echo esc_url( $pricing_redirect ); ?>'><?php esc_attr_e( 'Upgrade to Pro', 'codesigner' ); ?></a>
			<?php else : ?>
				<a target='_blank' class='wl-upgrade-btn' href='<?php echo esc_url( 'https://codexpert.io/codesigner?utm_source=In-plugin&utm_medium=In-plugin+overview&utm_campaign=at+a+glance' ); ?>'><?php esc_attr_e( 'Visit CoDesigner', 'codesigner' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>