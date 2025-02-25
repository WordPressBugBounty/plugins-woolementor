<?php
$user = wp_get_current_user();
?>
<div class="setup-wizard-welcome-panel">
	<h1 class="cx-welcome"><?php echo esc_html__( 'Welcome to CoDesigner Family!', 'codesigner' ); ?></h1>
	<p class="cx-wizard-sub">
		<?php printf( esc_html__( 'Thanks for installing CoDesigner. We\'re so happy to have you with us.', 'codesigner' ) ); ?>
	</p>
	<p class="cx-wizard-sub">
		<?php printf( esc_html__( '10,000+ WooCommerce businesses around the world are transforming their online stores with CoDesigner.', 'codesigner' ) ); ?>
	</p>
	<div class="setup-wizard-subs">
		<p class="cx-wizard-sub-heading">
			<?php printf( esc_html__( 'This wizard will help you configure the basic things needed to get started.', 'codesigner' ) ); ?>
		</p>
		<p class="cx-wizard-sub-heading">
			<?php printf( esc_html__( "It won't take more than 1 minute!.", 'codesigner' ) ); ?>
		</p>
		<input id="setup-wizard-email" type="email" name="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="
																					<?php
																					echo esc_html__( 'Enter your email address to receive the coupon', 'codesigner' );
																					?>
		" />
		<p class="cx-wizard-desc">
			<?php printf( esc_html__( 'We will share the latest product updates, tutorials & deals with you. No spamming, Unsubscribe anytime..', 'codesigner' ) ); ?>
		</p>
	</div>
</div>

<?php
update_option( 'codesigner_setup_done', 1 );
update_option( 'complete_setting_close', 1 );