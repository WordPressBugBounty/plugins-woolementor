<?php 
$utm		= [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab' ];
$pro_link	= add_query_arg( $utm, 'https://codexpert.io/codesigner/#pricing' );

?>
<section class="codesigner-hero-section-wrapper">
	<div class="codesigner-container">
		<div class="codesigner-title-and-video-area">
			<div class="codesigner-title-btn-area">
				<div class="codesginer-hero-content-wrapper">
					<h1 class="codesigner-title codesigner-bg-style">
						<?php esc_html_e( 'CoDesigner', 'codesigner' ); ?>
					</h1>
					<h1 class="codesigner-title">
						<?php esc_html_e( 'WooCommerce', 'codesigner' ); ?>
					</h1>
					<h2 class="codesinger-email-designer">
						<?php esc_html_e( 'Email Designer', 'codesigner' ); ?>
					</h2>
					<p class="codesigner-hero-description">
						<?php esc_html_e( 'A beautifully designed email can bring peace of mind to your customers. 
							Don\'t you want to improve your customers\' experience? Take your decision right away..', 
							'codesigner' ); 
						?>
					</p>
					<div class="codesinger-get-start-btn-wrap">
						<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank" class="codesign-get-start-btn"><?php esc_html_e( 'Get Started', 'codesigner' ); ?></a>
						<a href="#">
							<?php esc_html_e( 'View Demo ', 'codesigner' ); ?>
							<img class="codesigner-btn-icon" src="<?php echo esc_url( plugins_url( "assets/img/email-designer/paly-icon.svg", CODESIGNER ) ); ?>" alt="icon"> 
							<img class="codesigner-btn-icon-light" src="<?php echo esc_url( plugins_url( "assets/img/email-designer/play-icon-light.svg", CODESIGNER ) ); ?>" alt="icon"> 
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

		<div class="codesigner-features-area">
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/No-coding-skills.svg", CODESIGNER ) ); ?>" alt="No-coding-skills"> 
				</div>
				<h3><?php esc_html_e( 'No coding skills', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/One-Click-Setup.svg", CODESIGNER ) ); ?>" alt="One-Click-Setup"> 
				</div>
				<h3><?php esc_html_e( 'One Click Setup', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/Drag-drop.svg", CODESIGNER ) ); ?>" alt="Drag-drop"> 
				</div>
				<h3><?php esc_html_e( 'Drag & drop', 'codesigner' ); ?></h3>
			</div>
			<div class="signle-featers">
				<div class="icon">
					<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/Preset-Templates.svg", CODESIGNER ) ); ?>" alt="Preset-Templates"> 
				</div>
				<h3><?php esc_html_e( 'Preset Templates', 'codesigner' ); ?></h3>
			</div>
		</div>

	</div>
</section>

<section class="codesigner-create-eamil-templte-wrapper">
	<div class="codesigner-container">
		<div class="codesigner-email-tempalte-image-area">
			<div class="codesigner-image-area">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-template.svg", CODESIGNER ) ); ?>" alt="email-template">
				<p class="codesigner-step">
					<?php esc_html_e( 'STEP : ', 'codesigner' ); ?><span><?php esc_html_e( '1', 'codesigner' ); ?></span>
				</p>
			</div>
		</div>
		<div class="codesigner-email-tempalte-content-area">
			<div class="codesigner-text-area">
				<p class="codesigner-email-editor-panel"><?php esc_html_e( 'Email Editor Panel', 'codesigner' ); ?></p>
				<h2><?php esc_html_e( 'Create email templates with Elementor', 'codesigner' ); ?></h2>
				<p class="codesigner-description">
					<?php esc_html_e( 'Create your own custom email template using Elementor and CoDesigner. 
						Here you have unlimited customization options. Add business logo and change layout, typography, 
						background color etc to reinforce your brand.', 'codesigner' ); 
					?>
				</p>
			</div>
		</div>		
	</div>
</section>

<section class="codesigner-create-eamil-templte-wrapper">
	<div class="codesigner-container codesigner-reverse-email-template">
		<div class="codesigner-email-tempalte-image-area">
			<div class="codesigner-image-area">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/eamil-setting.svg", CODESIGNER ) ); ?>" alt="eamil-setting">
				<p class="codesigner-step">
					<?php esc_html_e( 'STEP : ', 'codesigner' ); ?><span><?php esc_html_e( '2', 'codesigner' ); ?></span>
				</p>
			</div>
		</div>
		<div class="codesigner-email-tempalte-content-area">
			<div class="codesigner-text-area">
				<p class="codesigner-email-editor-panel"><?php esc_html_e( 'Email Editor Panel', 'codesigner' ); ?></p>
				<h2><?php esc_html_e( 'Create email templates with Elementor', 'codesigner' ); ?></h2>
				<p class="codesigner-description">
					<?php esc_html_e( 'Create your own custom email template using Elementor and CoDesigner. 
						Here you have unlimited customization options. Add business logo and change layout, typography, 
						background color etc to reinforce your brand.', 'codesigner' ); 
					?>
				</p>
			</div>
		</div>		
	</div>
</section>

<section class="codesigner-create-eamil-templte-wrapper">
	<div class="codesigner-container codesigner-beautiful-email">
		<div class="codesigner-email-tempalte-image-area">
			<div class="codesigner-image-area">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/send-email.svg", CODESIGNER ) ); ?>" alt="s">
				<p class="codesigner-step">
					<?php esc_html_e( 'STEP : ', 'codesigner' ); ?><span><?php esc_html_e( '3', 'codesigner' ); ?></span>
				</p>
			</div>
		</div>
		<div class="codesigner-email-tempalte-content-area">
			<div class="codesigner-text-area">
				<p class="codesigner-email-editor-panel"><?php esc_html_e( 'Send Beautiful Emails', 'codesigner' ); ?></p>
				<h2><?php esc_html_e( 'Bespoke branded WooCommerce emails', 'codesigner' ); ?></h2>
				<p class="codesigner-description">
					<?php esc_html_e( 'After doing the necessary set up, you are ready to send your custom branded emails. 
						Your customer gets exactly the same email you design.', 'codesigner' ); 
					?>
				</p>
			</div>
		</div>
	</div>
</section>

<section class="codesigner-email-builder-wrapper">
	<div class="codesigner-container">
		<p class="codesigner-eamil-builder-till"><?php esc_html_e( 'Send Beautiful Emails', 'codesigner' ); ?></p>
		<h2 class="codesigner-title-area">
			<?php esc_html_e( 'Email Customizer for Woocommerce with all-new and easy drag-and-drop', 'codesigner' ); ?>
		</h2>

		<div class="codesigner-widgets-grid">
			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/header.svg", CODESIGNER ) ); ?>" alt="header">
						<h2><?php esc_html_e( 'Header', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/footer.svg", CODESIGNER ) ); ?>" alt="email-build">
						<h2><?php esc_html_e( 'Footer', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/item-details.svg", CODESIGNER ) ); ?>" alt="item-details">
						<h2><?php esc_html_e( 'Item Details', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/billing-address.svg", CODESIGNER ) ); ?>" alt="billing-address">
						<h2><?php esc_html_e( 'Billing Address', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/billing-address.svg", CODESIGNER ) ); ?>" alt="billing-address">
						<h2><?php esc_html_e( 'Shipping Address', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/customer-note.svg", CODESIGNER ) ); ?>" alt="customer-note">
						<h2><?php esc_html_e( 'Customer Note', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/description.svg", CODESIGNER ) ); ?>" alt="description">
						<h2><?php esc_html_e( 'Description', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

			<div class="codesginer-single-widget codesigner-focus-widget">
				<div class="codesigner-single-widget-background"></div>
				<div class="codesigner-single-widget-forgrand">
					<div class="codesigner-widget-content">
						<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-build/readymade-templates.svg", CODESIGNER ) ); ?>" alt="readymade-templates">
						<h2><?php esc_html_e( 'Readymade templates', 'codesigner' ); ?></h2>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<section class="codesigner-lets-go-section-wrapper">
	<div class="codesigner-container">
		<p class="codesigner-lets-go-till"><?php esc_html_e( 'You have come to the right place', 'codesigner' ); ?></p>
		<h2 class="codesigner-let-go-header" >
			<?php esc_html_e( 'Let\'s Get Started With ', 'codesigner' ); ?>
			<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank"><?php esc_html_e( 'CoDesigner', 'codesigner' ); ?></a>
		</h2>
		<a class="codesigner-btn get-started" href="<?php echo esc_url( $pro_link ); ?>" target="_blank"><?php esc_html_e( 'Get Started', 'codesigner' ); ?></a>
	</div>
</section>