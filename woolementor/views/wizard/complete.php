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
			?> <a target="_blank"  href="<?php echo esc_url( 'https://codexpert.io/codesigner/special-new-user-pricing/?utm_source=wp+dashboard&utm_medium=setup+wizard&utm_campaign=appreciation+deal' ); ?>">
				<?php echo esc_html__( 'Unveil Now..', 'codesigner' ); ?>
			</a>⏳
		</p -->
	</div>
	<div class="setup-wizard-complete-easycommerce">
		<h2>🔥 Next: Power Up Your Store with AI</h2>
		<p><strong>Want to simplify everything?</strong> Try <strong><a href="https://easycommerce.dev/?utm_source=codesigner&utm_medium=setup_wizard&utm_campaign=success_screen" target="_blank">EasyCommerce</a></strong> - the all-in-one AI-powered Ecommerce plugin, designed to be faster and smarter than WooCommerce.</p>

		<h4>🚀 With EasyCommerce, you get:</h4>

		<ul class="small">
			<li>✨ AI-generated content & product images</li>
			<li>⚡ Simplified dashboard & management</li>
			<li>🔍 Voice search & smart recommendations</li>
		</ul>

		<p><strong>Your WooCommerce data remains safe.</strong> Install now to try.</p>

		<div id="ec-cta-wrap">
			<label id="ec-cta">
			  <input type="checkbox" name="install_easycommerce">
			  <strong><span>👈</span> Be one of the first to try it</strong>
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