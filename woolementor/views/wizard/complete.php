<?php

$congratulations = CODESIGNER_ASSETS . '/img/congratulations.png';

?>
<div class="setup-wizard-complete-panel">
	<div class="setup-wizard-complete-content">
		<img src="<?php echo esc_url( $congratulations ); ?>">
		<p class="cx-wizard-sub">
			<?php 
			$allowed_html = [
				'strong' => []
			];
			echo wp_kses( __( 'You are all set now. Start building your next-level WooCommerce store with <strong>CoDesigner</strong>!', 'codesigner' ), $allowed_html ); 
			?>
		🚀</p>
		<p class="cx-wizard-sub">🎁 
			<?php 
			echo wp_kses( __( 'As a token of appreciation for installing <strong>CoDesigner</strong>, we\'ve reserved a special mystery deal for you that <strong>expires in 6 hours..</strong>', 'codesigner' ), $allowed_html ); 
			?> 
		⏳</p>
		<p class="cx-wizard-grab" >
			<a target="_blank"  href="https://codexpert.io/codesigner/special-new-user-pricing/?utm_source=wp+dashboard&utm_medium=setup+wizard&utm_campaign=appreciation+deal">
				<?php echo esc_html__( 'Unveil Now', 'codesigner' ); ?>
			</a>
		</p>
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