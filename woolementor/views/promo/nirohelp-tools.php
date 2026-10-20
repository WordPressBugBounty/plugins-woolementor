<?php
use Codexpert\CoDesigner\Promo;
?>
<div class="cd-nirohelp-tools">
	<img class="cd-nirohelp-tools-logo" src="<?php echo esc_url( Promo::logo_url( 'nirohelp' ) ); ?>" alt="<?php esc_attr_e( 'NiroHelp', 'codesigner' ); ?>" width="40" height="40">
	<div class="cd-nirohelp-tools-text">
		<strong><?php esc_html_e( 'Running a store? Give shoppers a place to get help.', 'codesigner' ); ?></strong>
		<span><?php esc_html_e( 'Publish your docs, take tickets, and let AI answer repeat questions with NiroHelp. Free on WordPress.org.', 'codesigner' ); ?></span>
	</div>
	<a class="cd-nirohelp-btn" href="<?php echo esc_url( Promo::url( 'tools' ) ); ?>" target="_blank" rel="noopener">
		<?php esc_html_e( 'Get NiroHelp', 'codesigner' ); ?>
	</a>
</div>
