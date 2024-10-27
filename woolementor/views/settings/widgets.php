<?php
use Codexpert\CoDesigner\Helper;

$widgets 		= codesigner_widgets();
$active_widgets = wcd_active_widgets();

// sort by category first
$widget_categories = [];
$category_names = wcd_widget_categories();
foreach ( $widgets as $id => $widget ) {
	$categories = $widget['categories'];
	if( count( $categories ) > 0 ) {
		$widget_categories[ $categories[0] ][ $id ] = $widget;
	}
}
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
				<span class="wl-action-divider"></span>
				<div class="wl-header-search">
					<div class="wl-search-area">
						<input id="wl-search" type="text" placeholder="<?php esc_attr_e( 'Search Widgets', 'codesigner' ); ?>">
						<button type="button" class="wl-search-btn"><span class="dashicons dashicons-search"></span></button>
					</div>
				</div>
			</div>
		</div>
		<div class="wl-toggle-group">
			<h4 class="wl-disable"><?php esc_attr_e( 'Disable All', 'codesigner' ); ?></h4>
			<label class="wl-toggle-all-wrap">
			  	<input type="checkbox">
			  	<span class="wl-toggle-all"></span>
			</label>
			<h4 class="wl-enable"><?php esc_attr_e( 'Enable All', 'codesigner' ); ?></h4>
		</div>
	</div>

	<?php
	foreach ( $widget_categories as $_category => $widgets ) {
		printf( '<div id="wl-dashboard-widgets-%s" class="wl-dashboard-widgets">', esc_attr( $_category ) );

		$category = str_replace( 'CoDesigner - ', '', $category_names[ $_category ]['title'] );

		echo wp_kses_post( "<h3 class='wl-widget-category'>{$category}</h3>" );

		printf( '<div id="wl-widgets-group-%s" class="wl-widgets-group">', esc_attr( $_category ) );
		foreach ( $widgets as $id => $widget ) {

			$_class = isset( $widget['pro_feature'] ) && $widget['pro_feature'] ? 'pro' : 'free';

			$_active	= in_array( $id, $active_widgets ) ? 'active' : '';
			$_checked	= in_array( $id, $active_widgets ) ? 'checked' : '';

			$pro_html 	= '';
			if ( $_class == 'pro' ) {
				$pro_html = '<span class="wl-pro-ribbon">'. __( 'Pro', 'codesigner' ) .'</span>';
			}

			$_demo = sprintf(
				'<span class="wl-demo-icon">
					<!--a href="%1$s" title="%2$s" target="_blank"><i class="eicon-help-o"></i></a-->
					<a href="%1$s" title="%2$s" target="_blank"><i class="eicon-device-laptop"></i></a>
				</span>',
				// $widget['demo'],
				// __( 'Documentation', 'codesigner' ),
				isset( $widget['doc'] ) && $widget['doc'] != '' ? $widget['doc'] : $widget['demo'],
				__( 'View Demo', 'codesigner' ),
			);

			$_button	= "
			{$pro_html}
			<label class='wl-toggle-switch'>
				{$_demo}
			  	<input type='checkbox' class='wl-widget-checkbox' id='codesigner-checkbox-{$id}' name='{$id}' {$_checked}>
			  	<span class='wl-toggle-slider'></span>
			</label>
			";

			if( ! wcd_is_pro_activated() && $_class == 'pro' ) {
				$_button	= "
				{$pro_html}
				<label class='wl-toggle-switch wl-pro-popup-show'>
					{$_demo}
				  	<input type='checkbox' class='wl-widget-checkbox' id='codesigner-checkbox-{$id}' name='{$id}' {$_checked}>
				  	<span class='wl-pro-slider' data-demo='{$widget['demo']}'><span class='dashicons dashicons-lock'></span></span>
				</label>
				";
			}

			$keywords = implode( ' ', $widget['keywords'] ) . " {$widget['title']}";

			$title = str_replace( 'Shop - ', '', $widget['title'] );
			echo "<div id='wl-" . esc_attr( $id ) . "' class='wl-widget " . esc_attr( $_class ) . " " . esc_attr( $_active ) . "' data-keywords='" . esc_attr( $keywords ) . "'>
			    <label class='wl-widget-title' for='codesigner-checkbox-" . esc_attr( $id ) . "'>" . esc_html( $title ) . "</label>
			    " . $_button . "
			</div>";

		}
		
		echo '</div><!-- .wl-widgets-group -->';

		echo '</div><!-- .wl-dashboard-widgets -->';
	}
	?>

</div>

<div id="wl-pro-popup" style="display: none;">
	<button id="wl-pro-popup-hide" type="button">&times;</button>
	<h2 class="wl-pro-popup-title"><?php esc_attr_e( 'Get this Premium Feature', 'codesigner' ); ?></h2>
	<img class="wl-pro-popup-img" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/pro-rocket.png' ); ?>">
			<p class="wl-pro-popup-txt"><?php echo wp_kses( 'This feature is only available in <strong>CoDesigner Pro</strong>!', 'codesigner' ); ?></p>
	<p class="wl-pro-popup-txt"><?php echo wp_kses( 'Make a smart choice today; a <strong>small investment</strong> can lead to a <strong>big boost</strong> in your sales. Your decision can make a significant difference.', 'codesigner' ); ?></p>
	<p><a id="wl-pro-popup-btn" href="https://codexpert.io/codesigner/pro/?utm_source=dashboard&utm_medium=settings&utm_campaign=pro-popup" target="_blank">
		<span class="dashicons dashicons-unlock"></span>
		<?php esc_attr_e( 'Unlock Premium Features', 'codesigner' ); ?>
	</a></p>
</div>