<?php
use Codexpert\CoDesigner\Promo;
?>
<div class="cd-campaign-content nirohelp-campaign">
	<div class="cd-campaign-header">
		<a target="_blank" rel="noopener" href="<?php echo esc_url( Promo::url( 'sidebar' ) ); ?>" class="cd-nirohelp-brand">
			<img src="<?php echo esc_url( Promo::logo_url( 'nirohelp' ) ); ?>" alt="" width="28" height="28">
			<span>NiroHelp</span>
		</a>
		<h4><?php esc_html_e( 'Stop answering the same store questions twice', 'codesigner' ); ?></h4>
	</div>
	<div class="cd-campaign-content-body">
		<p><?php esc_html_e( 'Docs, tickets, and AI replies in one WordPress help desk. Shoppers get answers from your docs; you only see what needs a human.', 'codesigner' ); ?></p>
	</div>
	<div class="cd-nirohelp-cta">
		<a class="cd-nirohelp-cta-btn" href="<?php echo esc_url( Promo::url( 'sidebar' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Try NiroHelp Free', 'codesigner' ); ?></a>
	</div>
	<p class="cd-nirohelp-foot"><?php esc_html_e( 'Free on WordPress.org · Unlimited agents', 'codesigner' ); ?></p>
</div>
