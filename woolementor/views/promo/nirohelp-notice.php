<?php
use Codexpert\CoDesigner\Promo;

$nonce = wp_create_nonce( 'codesigner_nirohelp_notice' );
?>
<div class="notice notice-info is-dismissible cd-nirohelp-notice">
	<img class="cd-nirohelp-notice-logo" src="<?php echo esc_url( Promo::logo_url( 'nirohelp' ) ); ?>" alt="" width="32" height="32">
	<div class="cd-nirohelp-notice-text">
		<strong><?php esc_html_e( 'Shoppers asking the same questions again and again?', 'codesigner' ); ?></strong>
		<span><?php esc_html_e( 'NiroHelp turns your docs into instant answers and turns the rest into tickets, all inside WordPress. Free on WordPress.org.', 'codesigner' ); ?></span>
	</div>
	<div class="cd-nirohelp-notice-actions">
		<a class="cd-nirohelp-btn" href="<?php echo esc_url( Promo::url( 'notice' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'See how it works', 'codesigner' ); ?></a>
		<a href="#" class="cd-nirohelp-later"><?php esc_html_e( 'Maybe later', 'codesigner' ); ?></a>
	</div>
</div>
<script>
jQuery( function( $ ) {
	var $notice = $( '.cd-nirohelp-notice' );
	var send = function( extra ) {
		$.post( ajaxurl, $.extend( { action: 'dismiss_nirohelp_notice', _wpnonce: '<?php echo esc_js( $nonce ); ?>' }, extra ) );
	};
	$notice.on( 'click', '.notice-dismiss', function() { send( {} ); } );
	$notice.on( 'click', '.cd-nirohelp-later', function( e ) {
		e.preventDefault();
		send( { snooze: 1 } );
		$notice.fadeOut( 150 );
	} );
} );
</script>
