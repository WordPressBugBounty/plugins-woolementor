<?php
use Codexpert\CoDesigner\Helper;

$widgets        = codesigner_widgets();
$active_widgets = wcd_active_widgets();

// sort by category first
$widget_categories = array();
$category_names    = wcd_widget_categories();
foreach ( $widgets as $id => $widget ) {
	$categories = $widget['categories'];
	if ( count( $categories ) > 0 ) {
		$widget_categories[ $categories[0] ][ $id ] = $widget;
	}
}
?>

<div class="wl-content-area">
	<div class="wl-wizard-widget-header">
		<h2><?php echo esc_html__( 'Select the Widgets That Suit Your Needs', 'codesigner' ); ?></h2>
		<p><?php echo esc_html__( 'You can turn ON/OFF anytime from the dashboard', 'codesigner' ); ?></p>
	</div>

	<?php
	$flag = 0;
	foreach ( $widget_categories as $_category => $widgets ) {

		if ( $flag > 0 ) {
			printf( '<div id="wl-dashboard-widgets-%s" class="wl-dashboard-widgets cd-hide-section">', esc_attr( $_category ) );
		} else {
			printf( '<div id="wl-dashboard-widgets-%s" class="wl-dashboard-widgets">', esc_attr( $_category ) );
		}

		$category = str_replace( 'CoDesigner - ', '', $category_names[ $_category ]['title'] );

		?>
		<h3 class='wl-widget-category'><?php echo esc_html( $category ); ?></h3>
		<?php

		printf( '<div id="wl-widgets-group-%s" class="wl-widgets-group">', esc_attr( $_category ) );
		foreach ( $widgets as $id => $widget ) {

			$_class = isset( $widget['pro_feature'] ) && $widget['pro_feature'] ? 'pro' : 'free';

			$_active  = in_array( $id, $active_widgets ) ? 'active' : '';
			$_checked = in_array( $id, $active_widgets ) ? 'checked' : '';

			$pro_html = '';
			if ( $_class == 'pro' ) {
				$pro_html = '<span class="wl-pro-ribbon">' . __( 'Pro', 'codesigner' ) . '</span>';
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

			$_button = "
			{$pro_html}
			<label class='wl-toggle-switch'>
				{$_demo}
			  	<input type='checkbox' class='wl-widget-checkbox' id='codesigner-checkbox-{$id}' name='{$id}' {$_checked}>
			  	<span class='wl-toggle-slider'></span>
			</label>
			";

			if ( ! wcd_is_pro_activated() && $_class == 'pro' ) {
				$_button = "
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
			?>
				<div id='wl-<?php echo esc_attr( $id ); ?>' class='wl-widget <?php echo esc_attr( $_class ); ?> <?php echo esc_attr( $_active ); ?>' data-keywords='<?php echo esc_attr( $keywords ); ?>'>
					<label class='wl-widget-title' for='codesigner-checkbox-{$id}'><?php echo esc_html( $title ); ?></label>
					<?php echo $_button; ?>
				</div>
			<?php
		}

		echo wp_kses_post( '</div>' );

		echo wp_kses_post( '</div>' );

		++$flag;
	}
	?>

	<div class="cd-wizard-view-all">
		<button class="cd-view-all-btn" id="cd-view-widgets-btn" type="button">
			<?php echo esc_html__( 'View All Widgets', 'codesigner' ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
				<path d="M16.692 5.19202L15.6675 6.21656L20.2265 10.7756H0V12.2245H20.2265L15.6675 16.7835L16.692 17.808L23 11.5L16.692 5.19202Z" fill="#FA5542"/>
			</svg>
		</button>
	</div>
</div>

<div id="wl-pro-popup" style="display: none;">
	<button id="wl-pro-popup-hide" type="button">&times;</button>
	<h2 class="wl-pro-popup-title"><?php esc_html__( 'This is a Premium Feature', 'codesigner' ); ?></h2>
	<img class="wl-pro-popup-img" src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/pro-rocket.png' ); ?>">
	<p class="wl-pro-popup-txt"><?php echo wp_kses_post( 'Get <b>50+ premium features</b> along with this one and create your dream WooCommerce site in no time.' ); ?></p>
	<p>
		<a id="wl-pro-popup-btn" href="https://codexpert.io/codesigner/?utm_source=dashboard&utm_medium=settings&utm_campaign=pro-popup" target="_blank">
			<span class="dashicons dashicons-unlock"></span>
			<?php esc_html__( 'Unlock Premium Features', 'codesigner' ); ?>
		</a>
	</p>
</div>

<script>
	jQuery(function ($) {
		// add or remove active class from widget
		$(".cx-wizard-wrap .cx-wizard-container .wl-toggle-slider").click(function() {
			var widget = $(this).parent().parent();

			if(widget.hasClass("active")) {
				widget.removeClass("active");
			} else {
				widget.addClass("active");
			}
		});

		// view all widgets
		$(".cd-wizard-view-all #cd-view-widgets-btn").click(function(e) {
			$(".wl-dashboard-widgets").removeClass("cd-hide-section");
			$(".cd-wizard-view-all").hide("fast");
		});

		// show hide pro popup
		$(".cx-wizard-wrap .cx-wizard-container .wl-widget.pro .wl-pro-popup-show").click(function (e) {
			$("#wl-pro-popup").slideDown("fast");
		});

		$("#wl-pro-popup-hide").click(function (e) {
			$("#wl-pro-popup").slideUp("fast");
		});
});
</script>