<?php
/**
 * Setup wizard — Welcome step.
 *
 * @package CoDesigner
 */

// Community space URL (filterable so it can be overridden per-site/build).
$community_url = apply_filters( 'codesigner_community_url', 'https://community.codexpert.io/c/space/codesigner' );
?>
<div class="setup-wizard-welcome-panel">
	<h1 class="cx-welcome"><?php echo esc_html__( 'Welcome to CoDesigner Family!', 'codesigner' ); ?></h1>
	<p class="cx-wizard-sub">
		<?php echo esc_html__( 'Thanks for installing CoDesigner. We\'re so happy to have you with us.', 'codesigner' ); ?>
	</p>
	<p class="cx-wizard-sub">
		<?php echo esc_html__( '10,000+ WooCommerce businesses around the world are transforming their online stores with CoDesigner.', 'codesigner' ); ?>
	</p>

	<div class="cx-community">
		<div class="cx-community-card">
			<div class="cx-community-visual">
				<img class="cx-community-illustration" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/codesigner-community-illustration.png' ); ?>" alt="" width="800" height="600" />
			</div>

			<div class="cx-community-content">
				<h2 class="cx-community-title"><?php echo esc_html__( 'Join the CoDesigner Community', 'codesigner' ); ?></h2>
				<p class="cx-community-desc"><?php echo esc_html__( 'Get help, share ideas, discover useful tips, and connect with other CoDesigner users.', 'codesigner' ); ?></p>

				<a class="cx-community-cta" href="<?php echo esc_url( $community_url ); ?>" target="_blank" rel="noopener noreferrer">
					<svg class="cx-community-cta-icon" width="22" height="22" viewBox="0 0 24 24" fill="#fff" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
						<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
					</svg>
					<?php echo esc_html__( 'Join the Community', 'codesigner' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
update_option( 'codesigner_setup_done', 1 );
update_option( 'complete_setting_close', 1 );
