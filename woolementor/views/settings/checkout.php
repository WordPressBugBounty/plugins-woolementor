<?php
$utm      = array(
	'utm_source'   => 'dashboard',
	'utm_medium'   => 'settings',
	'utm_campaign' => 'pro-tab',
);
$pro_link = add_query_arg( $utm, 'https://codexpert.io/codesigner/#pricing' );

?>
<section class="codesigner-hero-section-wrapper">
	<div class="codesigner-container">
		<div class="codesigner-title-and-video-area codesigner-checkout-hero">
			<div class="codesigner-title-btn-area">
				<div class="codesginer-hero-content-wrapper">
					<h1 class="codesigner-title codesigner-bg-style">
						<?php esc_html_e( 'CoDesigner', 'codesigner' ); ?>
					</h1>
					<h1 class="codesigner-title">
						<?php esc_html_e( 'WooCommerce', 'codesigner' ); ?>
					</h1>
					<h2 class="codesinger-email-designer">
						<?php esc_html_e( 'Checkout Builder', 'codesigner' ); ?>
					</h2>
					<p class="codesigner-hero-description">
						<?php
						esc_html_e(
							'No more boring design of WooCommerce checkout page.
							With CoDesigner, you can add new billing, shipping, order fields, custom Thank You message, 
							and much more options to design your checkout page.',
							'codesigner'
						);
						?>
											</p>
					<div class="codesinger-get-start-btn-wrap codesigner-checkout-get-start">
						<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank" class="codesign-get-start-btn">
							<?php esc_html_e( 'Get Started', 'codesigner' ); ?>
						</a>
						<a href="#">
							<?php esc_html_e( 'View Demo ', 'codesigner' ); ?>
							<img class="codesigner-btn-icon" src="<?php echo esc_url( plugins_url( 'assets/img/checkout/paly-icon.svg', CODESIGNER ) ); ?>" alt="paly-icon"> 
							<img class="codesigner-btn-icon-light" src="<?php echo esc_url( plugins_url( 'assets/img/checkout/play-icon-light.svg', CODESIGNER ) ); ?>" alt="play-icon-light"> 
						</a>
					</div>
				</div>
			</div>
			<div class="codesigner-video-player-area">
				<div class="codesigner-iframe-area">
					<iframe src="https://www.youtube.com/embed/2lVDktWK-pc?si=ueBGtVAjoagU580z" title="<?php esc_html_e( 'YouTube video player', 'codesigner' ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
				</div>
			</div>
		</div>

		<div class="codesigner-features-area codesigner-checkout-page-features">
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/no-coding-skill.svg', CODESIGNER ) ); ?>" alt="no-coding-skill"> 
				</div>
				<h3><?php esc_html_e( 'No Coding Skills', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/one-click-setup.svg', CODESIGNER ) ); ?>" alt="one-click-setup"> 
				</div>
				<h3><?php esc_html_e( 'One Click Setup', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/drag-and-drop.svg', CODESIGNER ) ); ?>" alt="drag-and-drop"> 
				</div>
				<h3><?php esc_html_e( 'Drag & drop', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/preset-template.svg', CODESIGNER ) ); ?>" alt="preset-template"> 
				</div>
				<h3><?php esc_html_e( 'Preset Templates', 'codesigner' ); ?></h3>
			</div>
		</div>

	</div>
</section>

<section class="codesigner-create-eamil-templte-wrapper">
	<div class="codesigner-container codesigner-reverse-email-template codesigner-checkout-template">
		<div class="codesigner-email-tempalte-image-area">
			<div class="codesigner-image-area">
				<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/clean-and-fresh-checkout.svg', CODESIGNER ) ); ?>" alt="">
				<p class="codesigner-step">
					<?php esc_html_e( 'STEP : ', 'codesigner' ); ?><span><?php esc_html_e( '1', 'codesigner' ); ?></span>
				</p>
			</div>
		</div>
		<div class="codesigner-email-tempalte-content-area">
			<div class="codesigner-text-area codesigner-checkout-text-area">
				<p class="codesigner-email-editor-panel"><?php esc_html_e( 'Custom Checkout', 'codesigner' ); ?></p>
				<h2><?php esc_html_e( 'Get a clean and fresh checkout page with CoDesigner', 'codesigner' ); ?></h2>
				<p class="codesigner-description">
					<?php
					esc_html_e(
						'Create your own custom email template using Elementor and CoDesigner. Here you have unlimited 
						customization options. Add business logo and change layout, typography, background color etc to 
						reinforce your brand.',
						'codesigner'
					);
					?>
				</p>
			</div>
		</div>		
	</div>
</section>

<section class="codesigner-create-eamil-templte-wrapper">
	<div class="codesigner-container codesigner-beautiful-email codesigner-checkout-template-reserve">
		<div class="codesigner-email-tempalte-image-area">
			<div class="codesigner-image-area">
				<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/drag-and-drop-img.svg', CODESIGNER ) ); ?>" alt="">
				<p class="codesigner-step">
					<?php esc_html_e( 'STEP : ', 'codesigner' ); ?><span><?php esc_html_e( '2', 'codesigner' ); ?></span>
				</p>
			</div>
		</div>
		<div class="codesigner-email-tempalte-content-area">
			<div class="codesigner-text-area codesigner-checkout-text-area">
				<p class="codesigner-email-editor-panel"><?php esc_html_e( 'Drag and drop builder', 'codesigner' ); ?></p>
				<h2><?php esc_html_e( 'Drag & Drop Clean widgets', 'codesigner' ); ?></h2>
				<p class="codesigner-description">
					<?php
					esc_html_e(
						'Choose from the settings which email template to use for what event. You can set different email 
						templates for different events, e.g., one for new order, one for processing order and another for 
						completed.',
						'codesigner'
					);
					?>
									</p>
			</div>
		</div>
	</div>
</section>

<section class="codesigner-email-builder-wrapper">
	<div class="codesigner-container">
		<p class="codesigner-eamil-builder-till codesigner-checkout-email-builder-till"><?php esc_html_e( 'Send Beautiful Emails', 'codesigner' ); ?></p>
		<h2 class="codesigner-title-area"><?php esc_html_e( 'Email Customizer for Woocommerce with all-new and easy drag-and-drop', 'codesigner' ); ?></h2>
		<div class="codesigner-widgets-grid">
			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/billing-address.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Header', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/shipping-address.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Footer', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/order-note.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Item Details', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/order-review.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Billing Address', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/order-pay.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Shipping Address', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/payment.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Customer Note', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/checkout.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Description', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-checkout-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/checkout/email-build/thank-you.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Thank you', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-focus-widget codesigner-checkout-single-widget-focus">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( 'assets/img/email-designer/email-build/readymade-templates.svg', CODESIGNER ) ); ?>" alt="">
						<h2><?php esc_html_e( 'Readymade templates', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<section class="codesigner-lets-go-section-wrapper">
	<div class="codesigner-container">
		<p class="codesigner-lets-go-till codesigner-checkout-email-builder-till"><?php esc_html_e( 'You have come to the right place', 'codesigner' ); ?></p>
		<h2 class="codesigner-let-go-header codesigner-checkout-let-go-header" >
			<?php esc_html_e( 'Let\'s Get Started With ', 'codesigner' ); ?>
			<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank"><?php esc_html_e( 'CoDesigner', 'codesigner' ); ?></a>
		</h2>
		<a class="codesigner-btn codesigner-checkout-btn get-started" href="<?php echo esc_url( $pro_link ); ?>" target="_blank"><?php esc_html_e( 'Get Started', 'codesigner' ); ?></a>
	</div>
</section>