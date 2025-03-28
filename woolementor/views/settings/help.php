<?php

$base_url = wcd_home_link();
$buttons  = array(
	'roadmap'   => array(
		'url'   => "{$base_url}/roadmap/",
		'label' => __( 'Roadmap', 'codesigner' ),
	),
	'changelog' => array(
		'url'   => "{$base_url}/roadmap/",
		'label' => __( 'Changelog', 'codesigner' ),
	),
	'ideas'     => array(
		'url'   => "{$base_url}/roadmap/",
		'label' => __( 'Ideas', 'codesigner' ),
	),
	'support'   => array(
		'url'   => wcd_help_link(),
		'label' => __( 'Ask Support', 'codesigner' ),
	),
);
$buttons  = apply_filters( 'wcd_help_tab_link', $buttons );
?>

<div class="wcd-help-tab">
	<div class="wcd-documentation">
		<div class='wrap'>
			<div id='codesigner-helps'>
			<?php

			$helps = get_option( 'codesigner-docs_json', array() );
			$utm   = array(
				'utm_source'   => 'dashboard',
				'utm_medium'   => 'settings',
				'utm_campaign' => 'faq',
			);
			if ( is_array( $helps ) && count( $helps ) > 0 ) :
				foreach ( $helps as $help ) {
					$help_link = add_query_arg( $utm, $help['link'] );
					?>
				<div id='codesigner-help-<?php echo esc_attr( $help['id'] ); ?>' class='codesigner-help'>
					<h2 class='codesigner-help-heading' data-target='#codesigner-help-text-<?php echo esc_attr( $help['id'] ); ?>'>
						<a href='<?php echo esc_url( $help_link ); ?>' target='_blank'>
						<span class='dashicons dashicons-admin-links'></span></a>
						<span class="heading-text"><?php echo esc_html( $help['title']['rendered'] ); ?></span>
					</h2>
					<div id='codesigner-help-text-<?php echo esc_attr( $help['id'] ); ?>' class='codesigner-help-text' style='display:none'>
						<?php echo wp_kses_post( wpautop( esc_html( wp_trim_words( $help['content']['rendered'], 55 ) ) . " <a class='sc-more' href='" . esc_url( $help_link ) . "' target='_blank'>[more..]</a>" ) ); ?>
					</div>
				</div>
					<?php
				}
			else :
				?>
					<p><?php echo esc_attr__( 'Something is wrong! Refreshing the page might help.', 'codesigner' ); ?></p>
				<?php
			endif;
			?>
			</div>
		</div>
	</div>
	<div class="wcd-help-links">
		<?php
		foreach ( $buttons as $key => $button ) {
			?>
				<a target='_blank' href='<?php echo esc_url( $button['url'] ); ?>' class='wcd-help-link'><?php echo esc_html( $button['label'] ); ?></a>
			<?php
		}
		?>
	</div>
</div>

<script type="text/javascript">
	jQuery(function($){ $.get( ajaxurl, { action : 'codesigner-docs_json' }); });
</script>

<?php do_action( 'wcd_help_tab_content' ); ?>