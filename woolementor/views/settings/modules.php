<?php
use Codexpert\CoDesigner\Helper;

$modules        = codesigner_modules();
$active_modules = get_option( 'codesigner_modules', array() );

// Helper::pri( $active_modules );
// Helper::pri( $modules );

?>

<div class="wl-content-area">
	<div class="wl-header-content">
		<div class="wl-header-filter">
			<div class="wl-group-wrap">
				<div class="wl-filter-group">
					<button type="button" class="wl-filter filter-all active" data-filter=".free, .pro"><?php esc_attr_e( 'All', 'codesigner' ); ?></button>
					<button type="button" class="wl-filter filter-free" data-filter=".free"><?php esc_attr_e( 'Free', 'codesigner' ); ?></button>
					<button type="button" class="wl-filter filter-pro" data-filter=".pro"><?php esc_attr_e( 'Pro', 'codesigner' ); ?></button>
				</div>
				<!-- <span class="wl-action-divider"></span>
				<div class="wl-header-search">
					<div class="wl-search-area">
						<input id="wl-search" type="text" placeholder="<?php esc_attr_e( 'Search Modules', 'codesigner' ); ?>">
						<button type="button" class="wl-search-btn"><span class="dashicons dashicons-search"></span></button>
					</div>
				</div> -->
			</div>
		</div>
		<div class="wl-toggle-group">
			<h4 class="wl-disable"><?php esc_attr_e( 'Disable All', 'codesigner' ); ?></h4>
			<label class="wl-toggle-all-wrap">
					<input type="checkbox">
					<span class="wl-toggle-all cd-module-all-active"></span>
			</label>
			<h4 class="wl-enable"><?php esc_attr_e( 'Enable All', 'codesigner' ); ?></h4>
		</div>
	</div>

	<div class="cd-settings-modules-container">
		<div class="<?php echo esc_attr( count( $active_modules ) == 0 ? 'cd-settings-modules-list' : 'cd-settings-modules-list cd-list-column-2' ); ?>">

		<?php foreach ( $modules as $key => $module ) : ?>
			<?php $module_class = $module['pro'] ? 'pro' : 'free'; ?>
			<div class="<?php echo esc_attr( 'wl-widget cd-settings-module-block ' . $module_class ); ?>">
				<div class="cx-label-wrap">
					<label for="<?php echo esc_attr( 'codesigner_modules-' . $key ); ?>">
						<?php echo esc_html__( $module['title'], 'codesigner' ); ?>
					</label>
					<p class="cd-module-desc"><?php echo wp_kses_post( $module['desc'] ); ?></p>
				</div>
				<?php
				if ( $module['pro'] ) {
					?>
						<span class="wl-pro-ribbon">Pro</span>
					<?php
				}
				?>
				<div class="cx-field-wrap">
					<label class="cx-toggle">
						<input 
							type="checkbox" name="<?php echo esc_attr( $key ); ?>" 
							id="<?php echo esc_attr( 'codesigner_modules-' . $module['id'] ); ?>" 
							class="cx-toggle-checkbox cx-field cx-field-switch" value="on" 

							<?php
							if ( wcd_is_pro_activated() && $module['pro'] ) {
								echo array_key_exists( $key, $active_modules ) ? 'checked' : '';
							} elseif ( ! wcd_is_pro_activated() && $module['pro'] ) {
								echo '';
							} elseif ( wcd_is_pro_activated() || ! wcd_is_pro_activated() && ! $module['pro'] ) {
								echo array_key_exists( $key, $active_modules ) ? 'checked' : '';
							}

							echo ! wcd_is_pro_activated() && $module['pro'] ? 'disabled' : '';
							?>
						>
						<div class="<?php echo ! wcd_is_pro_activated() && $module['pro'] ? 'cx-toggle-switch pro' : 'cx-toggle-switch'; ?>"></div>
					</label>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>

<div id="wl-pro-popup" style="display: none;">
	<button id="wl-pro-popup-hide" type="button">&times;</button>
	<h2 class="wl-pro-popup-title"><?php esc_attr_e( 'Get this Premium Feature', 'codesigner' ); ?></h2>
	<img class="wl-pro-popup-img" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/pro-rocket.png' ); ?>">
	<p class="wl-pro-popup-txt"><?php echo wp_kses( 'This feature is only available in <strong>CoDesigner Pro</strong>!', 'codesigner' ); ?></p>
	<p class="wl-pro-popup-txt"><?php echo wp_kses( 'Make a smart choice today; a <strong>small investment</strong> can lead to a <strong>big boost</strong> in your sales. Your decision can make a significant difference.', 'codesigner' ); ?></p>
	<p>
		<a id="wl-pro-popup-btn" href="<?php echo esc_url( 'https://codexpert.io/codesigner/pro/?utm_source=dashboard&utm_medium=settings&utm_campaign=pro-popup' ); ?>" target="_blank">
			<span class="dashicons dashicons-unlock"></span>
			<?php esc_attr_e( 'Unlock Premium Features', 'codesigner' ); ?>
		</a>
	</p>
</div>
