<?php
use Codexpert\CoDesigner\Helper;

$utm			= [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab' ];
$pro_link		= add_query_arg( $utm, 'https://codexpert.io/codesigner/#pricing' );
$fire_features	= [ 'email-header', 'email-footer', 'email-item-details', 'email-billing-addresses', 'email-shipping-addresses', 'email-customer-note', 'email-description', 'wishlist', 'billing-address', 'shipping-address', 'payment-methods', 'shop-accordion', 'shop-table', 'dynamic-tabs', 'menu-cart', 'filter-vertical', 'product-comparison' ];

$pro_features	= [
	'checkout-widgets'	=> [
		'title'			=> __( 'Checkout Page', 'codesigner' ),
		'subtitle'		=> __( 'Customizable Checkout 🔥', 'codesigner' ),
		'description'	=> __( 'Helps you customize your checkout page. Adding new billing or shipping fields, changing field attributes, styling your own.. You name it.', 'codesigner' ),
	],
	'email-designer'	=> [
		'title'			=> __( 'Email Designer', 'codesigner' ),
		'subtitle'		=> __( 'Customizable Transactional Emails 🔥', 'codesigner' ),
		'description'	=> __( 'Bored with WooCommerce\'s ugly and pale emails? You won\'t be again. It now allows you to send beautiful transnational mails built with Elementor!', 'codesigner' ),
	],
	'more-shop-design'	=> [
		'title'			=> __( 'New Shop Designs', 'codesigner' ),
		'subtitle'		=> __( 'More Shop Widgets', 'codesigner' ),
		'description'	=> __( 'CoDesigner Pro includes 6 additional beautiful shop widgets. But, we\'re not stopping here and are continuously working. More widgets are coming soon.', 'codesigner' ),
	],
	'ready-made-templates'=> [
		'title'			=> __( 'Template Library', 'codesigner' ),
		'subtitle'		=> __( 'Ready-made Templates For You 🔥', 'codesigner' ),
		'description'	=> __( 'You will have access to hundreds of ready-made templates that uses Pro widgets to be imported using the native Elementor importer.', 'codesigner' ),
	],
	'template-builder'	=> [
		'title'			=> __( 'Template Builder', 'codesigner' ),
		'subtitle'		=> __( 'Header, Footer, Archive & Much More', 'codesigner' ),
		'description'	=> __( 'You can now create header, footer, archive, etc templates conditionally with a lot of customization options.', 'codesigner' ),
	],
	'pricing-table'	=> [
		'title'			=> __( 'Pricing Table', 'codesigner' ),
		'subtitle'		=> __( 'Amazing Pricing Tables', 'codesigner' ),
		'description'	=> __( 'Along with 2 Pricing Tables included in the free version, CoDesigner Pro brings 3 more Pricing Table widgets that are amazing and mind blowing.', 'codesigner' ),
	],
	'beautiful-wishlist'	=> [
		'title'			=> __( 'Wishlist', 'codesigner' ),
		'subtitle'		=> __( 'Smart Wishlist Management 🔥', 'codesigner' ),
		'description'	=> __( 'CoDesigner Pro includes a very smart and intuitive Wishlist feature. You customers can now add products to Wishlist and to the cart right from there.', 'codesigner' ),
	],
	'sales-notification'=> [
		'title'			=> __( 'Sales Notification', 'codesigner' ),
		'subtitle'		=> __( 'Display Recent Sales', 'codesigner' ),
		'description'	=> __( 'Sales Notification widget lets you display your recent sales. It\'s a proven token of trust! Notifications can be pulled from your orders or added manually.', 'codesigner' ),
	],
];
?>
<div id="wl-pro-wrap">
	<div id="wl-pro-features">
		<div class="wl-pro-features-heading">
			<p class="wl-desc"><?php esc_html_e( 'Along with the <strong>Award Winning</strong> premium and priority support from our dedicated support team, you\'re going to get these awesome features if you upgrade to CoDesigner Pro. And, you\'re covered under a <strong>14-day 100% refund</strong> policy.', 'codesigner' ) ?></p>
			<div class="wl-cta-btns">
				<a class="wl-upgrade-pro-btn" href="https://codexpert.io/codesigner/?utm_source=dashboard&amp;utm_medium=settings&amp;utm_campaign=pro-tab#pricing" target="_blank">Upgrade to PRO</a>
			</div>
		</div>

		<div class="wl-pro-features">
			<?php
			$item_count = 0;
			foreach ( $pro_features as $id => $data ) {
				$is_even 	= $item_count % 2;
				$img 		= "<img src='" . plugins_url( "assets/img/{$id}.png", CODESIGNER ) . "' />";
				$reverse 	= $alignment = '';
				$reverse 	= $is_even == 0 ? '' : 'reverse';
				$alignment 	= $is_even == 0 ? 'left' : 'right';
				?>
				<div class='wl-pro-feature <?php echo esc_attr( $reverse ); ?>'>
					<div class='wl-pro-feature-content'>
						<a href="<?php echo esc_url( $pro_link ); ?>" target='_blank'>
							<h3 class='wl-widget-subtitle'><?php echo esc_html( $data['title'] ); ?></h3>
						</a>
						<h2 class='wl-widget-title'><?php echo esc_html( $data['subtitle'] ); ?></h2>
						<p class='wl-feature-desc'><?php echo esc_html( $data['description'] ); ?></p>
					</div>
					<div class='wl-pro-feature-img'><?php echo wp_kses_post( wpautop( $img ) ); ?></div>
				</div>
				<?php
				$item_count++;
			}
			?>
		</div>
	</div>
	<div id="wl-pro-widgets" class="">
		<div id="wl-widgets-heading" class="">
			<h1 class="wl-large-title"><?php esc_html_e( '40+ Pro Widgets', 'codesigner' ); ?></h1>
		</div>
		<div class='wl-pro-widget-list'>
			<?php 
			foreach ( codesigner_widgets() as $id => $widget ) {
				if( wcd_is_pro_feature( $id ) ) {
					$demo_txt = __( 'View Demo', 'codesigner' );
					$demo_url = add_query_arg( $utm, $widget['demo'] );
					$title = in_array( $id, $fire_features ) ? "{$widget['title']} 🔥" : $widget['title'];
					?>
					<a href='<?php echo esc_url( $demo_url ); ?>' title='<?php echo esc_attr( $demo_txt ); ?>' target='_blank'>
						<div class='wl-pro-widget'>
							<i class='<?php echo esc_attr( $widget['icon'] ); ?>'></i><?php echo esc_html( $title ); ?>
						</div>
					</a>
					<?php
				}
			}
			?>
		</div>
	</div>
	<div id="wl-call-to-action">
		<div class="wl-cta-content">
			<h4><?php esc_html_e( 'Best Elementor WooCommerce Builder', 'codesigner' ) ?></h4>
		</div>
		<div class="wl-cta-btns">
			<a class="wl-help-support" href="https://help.codexpert.io/tickets/" target='_blank'><?php esc_html_e( 'Help and support', 'codesigner' ) ?></a>
			<a class="wl-upgrade-pro-btn" href="<?php echo esc_url( $pro_link ); ?>" target='_blank'><?php esc_html_e( 'Upgrade to PRO', 'codesigner' ) ?></a>
		</div>
	</div>
	<!-- <div id="wl-pro-upgrade">
		<div class="wcd-edf-btns">
			<a href="<?php echo esc_url( wcd_help_link() ); ?>" target="_blank" class="wcd-edf-btn"><?php esc_html_e( 'I have a question' ) ?></a>
			<a href="<?php echo esc_url( wcd_home_link() ); ?>" target="_blank" class="wcd-edf-btn active"><?php esc_html_e( 'I\'m ready to upgrade' ) ?></a>
		</div>
	</div> -->
</div>