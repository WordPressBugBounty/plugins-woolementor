<?php

$congratulations = CODESIGNER_ASSETS . '/img/congratulations.png';

?>
<div class="setup-wizard-complete-panel">
	<div class="setup-wizard-complete-content">
		<!-- <img src="<?php echo esc_url( $congratulations ); ?>"> -->
		<h2 id="congrats">Congratulations! 🥳</h2>
		<p class="cx-wizard-sub">
			<?php 
			$allowed_html = [
				'strong' => []
			];
			echo wp_kses( __( 'You are all set now. Start building your next-level WooCommerce store with <strong>CoDesigner</strong>!', 'codesigner' ), $allowed_html ); 
			?>
		🚀</p>
		<!-- p class="cx-wizard-sub"> 
			<?php 
			echo wp_kses( __( 'As a token of appreciation for installing <strong>CoDesigner</strong>, we\'ve reserved a special mystery deal for you that <strong>expires in 6 hours!</strong>', 'codesigner' ), $allowed_html ); 
			?> <a target="_blank"  href="<?php echo esc_url( 'https://codesigner.dev/special-new-user-pricing/?utm_source=wp+dashboard&utm_medium=setup+wizard&utm_campaign=appreciation+deal' ); ?>">
				<?php echo esc_html__( 'Unveil Now..', 'codesigner' ); ?>
			</a>⏳
		</p -->
	</div>
	<div class="cd-more-codexpert">
		<?php wp_nonce_field( 'codesigner_wizard_install', 'codesigner_wizard_nonce' ); ?>
		<h3><?php esc_html_e( 'More from Codexpert', 'codesigner' ); ?></h3>
		<p class="cd-more-sub"><?php esc_html_e( 'Optional. Ticked plugins install when you click Finish.', 'codesigner' ); ?></p>
		<div class="cd-more-grid">
			<label class="cd-more-card">
				<span class="cd-more-head"><img src="<?php echo esc_url( \Codexpert\CoDesigner\Promo::logo_url( 'nirohelp' ) ); ?>" alt="" width="24" height="24"><strong>NiroHelp</strong><em><?php esc_html_e( 'Free', 'codesigner' ); ?></em></span>
				<span class="cd-more-desc"><?php esc_html_e( 'Help desk with knowledge base and AI replies', 'codesigner' ); ?></span>
				<span class="cd-more-pick"><input type="checkbox" name="install_nirohelp"> <?php esc_html_e( 'Automate your support', 'codesigner' ); ?></span>
			</label>
			<label class="cd-more-card">
			    <span class="cd-more-head"><img src="<?php echo esc_url( \Codexpert\CoDesigner\Promo::logo_url( 'thumbpress' ) ); ?>" alt="" width="24" height="24"><strong>Thumbpress</strong><em><?php esc_html_e( 'Free', 'codesigner' ); ?></em></span>
				<span class="cd-more-desc"><?php esc_html_e( 'Compress images and convert to WebP, AVIF', 'codesigner' ); ?></span>
				<span class="cd-more-pick"><input type="checkbox" name="install_thumbpress"> <?php esc_html_e( 'Speed up your site', 'codesigner' ); ?></span>
			</label>
			<label class="cd-more-card">
                <span class="cd-more-head"><img src="<?php echo esc_url( \Codexpert\CoDesigner\Promo::logo_url( 'wcaffiliate' ) ); ?>" alt="" width="24" height="24"><strong>WC Affiliate</strong><em><?php esc_html_e( 'Free', 'codesigner' ); ?></em></span>
				<span class="cd-more-desc"><?php esc_html_e( 'Run your own affiliate program in WooCommerce', 'codesigner' ); ?></span>
				<span class="cd-more-pick"><input type="checkbox" name="install_wc_affiliate"> <?php esc_html_e( 'Grow with affiliates', 'codesigner' ); ?></span>
			</label>
			<label class="cd-more-card">
			    <span class="cd-more-head"><img src="<?php echo esc_url( \Codexpert\CoDesigner\Promo::logo_url( 'easycommerce' ) ); ?>" alt="" width="24" height="24"><strong>Easycommerce</strong><em><?php esc_html_e( 'Free', 'codesigner' ); ?></em></span>
				<span class="cd-more-desc"><?php esc_html_e( 'AI-powered ecommerce, faster and smarter than WooCommerce', 'codesigner' ); ?></span>
				<span class="cd-more-pick"><input type="checkbox" name="install_easycommerce"> <?php esc_html_e( 'Sell with AI', 'codesigner' ); ?></span>
			</label>
		</div>
	</div>
</div>

<div id="loader_div" class="loader_div"></div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#complete-btn').on('click', function(event) {        
		$(".loader_div").show();   
	});
});
</script>
