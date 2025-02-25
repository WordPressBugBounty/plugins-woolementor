<?php

$congratulations = CODESIGNER_ASSETS . '/img/congratulations.png';

?>
<div class="setup-wizard-complete-panel">
	<div class="setup-wizard-complete-content">
		<img src="<?php echo esc_url( $congratulations ); ?>">
		<p class="cx-wizard-sub">
			<?php echo esc_html__( 'You are all set now. Start building your next-level WooCommerce store with CoDesigner!', 'codesigner' ); ?>
		</p>
		<ul class="cx-social-links">
			<li>
				<a target="_blank" href="https://help.codexpert.io/docs/codesigner">
					<?php echo esc_html__( 'Documentation', 'codesigner' ); ?>
				</a>
			</li>
			<li> | </li>
			<li>
				<a target="_blank" href="https://help.codexpert.io/new-ticket">
					<?php echo esc_html__( 'Help & Support', 'codesigner' ); ?>
				</a>
			</li>
			<li> | </li>
			<li>
				<a target="_blank" href="https://www.facebook.com/groups/codexpert.io/">
					<?php echo esc_html__( 'Facebook Community', 'codesigner' ); ?>
				</a>
			</li>
		</ul>
		<p class="cx-wizard-sub">
			<?php echo wp_kses_post( __( 'Get <b>CoDesigner Pro</b> at a <b>Special Price</b> and take your WooCommerce site-building experience to the next level.', 'codesigner' ) ); ?>
		</p>
		<p class="cx-wizard-grab" >
			<a target="_blank"  href="https://codexpert.io/codesigner/pricing/?utm_source=in-plugin&utm_medium=setup+wizard&utm_campaign=welcome+offer">
				<?php echo esc_html__( 'Grab Now', 'codesigner' ); ?>
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