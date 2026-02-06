<?php
use Codexpert\CoDesigner\Helper;

$modules        = codesigner_modules();
$active_modules = get_option( 'codesigner_modules', array() );

// Helper::pri( $active_modules );

?>

<div class="wl-content-area">
	<div class="wl-wizard-widget-header">
		<h2><?php echo esc_html__( 'Choose the Modules That Meet Your Needs', 'codesigner' ); ?></h2>
		<p><?php echo esc_html__( 'One-Click Enable/Disable for All Options', 'codesigner' ); ?></p>
	</div>

	<div class="cd-wizard-modules-container">
		<h3 class='wl-widget-category'><?php echo esc_html__( 'All Modules', 'codesigner' ); ?></h3>
		<div class="cd-wizard-modules-list">

		<?php $flag = 1; ?>
		<?php foreach ( $modules as $key => $module ) : ?>
			<div class="<?php echo esc_attr( $flag > 12 ? 'wl-widget cd-wizard-module-block cd-hide-module' : 'wl-widget cd-wizard-module-block' ); ?>">
				<div class="cx-label-wrap">
					<label for="<?php echo esc_attr( 'codesigner_modules-' . $key ); ?>">
						<?php echo esc_html( $module['title'] ); ?>
					</label>
					<p class="cd-module-desc"><?php echo esc_html( $module['desc'] ); ?></p>
				</div>
				<?php
				if ( $module['pro'] ) {
					?>
						<span class="wl-pro-ribbon"><?php echo esc_html( 'Pro' ); ?></span>
					<?php
				}
				?>
				<div class="cx-field-wrap ">
					<label class="cx-toggle">
						<input 
							type="checkbox" name="<?php echo esc_attr( $key ); ?>" 
							id="<?php echo esc_attr( 'codesigner_modules-' . $module['id'] ); ?>" 
							class="cx-toggle-checkbox cx-field cx-field-switch" value="on" 
							<?php echo array_key_exists( $key, $active_modules ) && $active_modules[ $key ] === 'on' ? 'checked' : ''; ?>
							<?php echo ! wcd_is_pro_activated() && $module['pro'] ? 'disabled' : ''; ?>
						>
						<div class="<?php echo ! wcd_is_pro_activated() && $module['pro'] ? 'cx-toggle-switch pro' : 'cx-toggle-switch'; ?>"></div>
					</label>
				</div>
			</div>
			<?php ++$flag; ?>
		<?php endforeach; ?>
		</div>

		<div class="cd-wizard-view-all">
			<button class="cd-view-all-btn" id="cd-view-modules-btn" type="button">
				<?php echo esc_html__( 'View All Modules', 'codesigner' ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
					<path d="M16.692 5.19202L15.6675 6.21656L20.2265 10.7756H0V12.2245H20.2265L15.6675 16.7835L16.692 17.808L23 11.5L16.692 5.19202Z" fill="#FA5542"/>
				</svg>
			</button>
		</div>
	</div>
</div>

<div id="wl-pro-popup" style="display: none;">
	<button id="wl-pro-popup-hide" type="button">&times;</button>
	<h2 class="wl-pro-popup-title"><?php echo esc_html__( 'This is a Premium Feature', 'codesigner' ); ?></h2>
	<img class="wl-pro-popup-img" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/pro-rocket.png' ); ?>">
	<p class="wl-pro-popup-txt"><?php echo wp_kses_post( 'Get <b>50+ premium features</b> along with this one and create your dream WooCommerce site in no time.' ); ?></p>
	<p>
		<a id="wl-pro-popup-btn" href="<?php echo esc_url( 'https://codesigner.dev/pricing/?utm_source=inplugin&utm_medium=button&utm_campaign=year-end' ); ?>" target="_blank">
			<span class="dashicons dashicons-unlock"></span>
			<?php echo esc_html__( 'Unlock Premium Features', 'codesigner' ); ?>
		</a>
	</p>
</div>

<script>
	jQuery(function ($) {
		// view all modules
		$(".cd-wizard-view-all #cd-view-modules-btn").click(function(e) {
			$(".cd-wizard-module-block").removeClass("cd-hide-module");
			$(".cd-wizard-view-all").hide("fast");
		});

		// modules pro popup show
		$(".cd-wizard-module-block .cx-toggle-switch.pro").click(function (e) {
			$("#wl-pro-popup").slideDown("fast");
		});
		
		// modules pro popup hide
		$("#wl-pro-popup-hide").click(function (e) {
			$("#wl-pro-popup").slideUp("fast");
		});

});
</script>