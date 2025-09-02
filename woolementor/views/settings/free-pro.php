<?php
$utm      = array(
	'utm_source'   => 'In-plugin',
	'utm_medium'   => 'In-plugin+upgrade',
	'utm_campaign' => 'upgrade+to+pro',
);
$pro_link = add_query_arg( $utm, 'https://codexpert.io/codesigner/pricing/' );

?>
<div class="cd-free-pro-wrapper">
	<div class="cd-free-pro-header">
		<div class="cd-free-pro-header-left">
			<div class="cd-free-pro-header-text">
				<h2>
					<?php esc_html_e( 'Upgrade &', 'codesigner' ); ?>
				</h2>
				<h2>
					<?php esc_html_e( 'Go Limitless', 'codesigner' ); ?>
				</h2>
				<h4>
					<?php esc_html_e( 'Enjoy', 'codesigner' ); ?>
					<span class="cd-free-pro-purple">
						<?php esc_html_e( '50+ Premium Widgets', 'codesigner' ); ?>
					</span>
					<?php esc_html_e( 'and', 'codesigner' ); ?>
					<span class="cd-free-pro-purple">
						<?php esc_html_e( '3 Modules', 'codesigner' ); ?>
					</span>
					<?php esc_html_e( 'With CoDesigner Pro', 'codesigner' ); ?>
				</h4>
				<a class="cd-upgrade-btn" href="<?php echo esc_url( $pro_link ); ?>" target="_blank">
					<?php esc_html_e( 'Upgrade Now', 'codesigner' ); ?>
				</a>
			</div>

			<div class="cd-free-pro-header-stats">
				<div class="cd-free-pro-header-stat">
					<div class="cd-free-pro-header-icon">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/icon-green.svg' ); ?>" alt="icon">
					</div>
					<div class="cd-free-pro-header-stat-text">
						<h4><?php esc_html_e( '14-Day', 'codesigner' ); ?></h4>
						<p><?php esc_html_e( 'Money Back Guarantee', 'codesigner' ); ?></p>
					</div>
				</div>
				<div class="cd-free-pro-header-stat">
					<div class="cd-free-pro-header-icon">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/icon-red.svg' ); ?>" alt="icon">
					</div>
					<div class="cd-free-pro-header-stat-text">
						<h4><?php esc_html_e( '83%', 'codesigner' ); ?></h4>
						<p><?php esc_html_e( '5-star Reviews', 'codesigner' ); ?></p>
					</div>
				</div>
				<div class="cd-free-pro-header-stat">
					<div class="cd-free-pro-header-icon">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/icon-purple.svg' ); ?>" alt="icon">
					</div>
					<div class="cd-free-pro-header-stat-text">
						<h4><?php esc_html_e( '27,000+', 'codesigner' ); ?></h4>
						<p><?php esc_html_e( 'Happy Users', 'codesigner' ); ?></p>
					</div>
				</div>
				<div class="cd-free-pro-header-stat">
					<div class="cd-free-pro-header-icon">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/icon-green.svg' ); ?>" alt="icon">
					</div>
					<div class="cd-free-pro-header-stat-text">
						<h4><?php esc_html_e( '2 Updates', 'codesigner' ); ?></h4>
						<p><?php esc_html_e( 'Every Month', 'codesigner' ); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="cd-free-pro-header-right">
			<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/free-pro-hero.svg' ); ?>" alt="hero-image">
		</div>
	</div>

	<div class="cd-free-pro-module">
		<div class="cd-pro-module-header">
			<div class="cd-module-title">
				<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/star-purple.svg' ); ?>" alt="icon">
				<h2>
					<?php esc_html_e( 'Pro Modules', 'codesigner' ); ?>
				</h2>
			</div>
			<p class="cd-module-desc">
				<?php esc_html_e( 'Craft stunning email campaigns, create professional invoices, and design beautiful and conversion-optimized checkout pages that boost sales in minutes using CoDesigner Pro Modules.', 'codesigner' ); ?>
			</p>
		</div>

		<div class="cd-pro-modules-wrapper">
			<div class="cd-pro-module">
				<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/email-icon.svg' ); ?>" alt="icon">
				<h3>
					<?php esc_html_e( 'Email Designer', 'codesigner' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'Craft stunning email campaigns in minutes with our drag-and-drop interface and pre-built templates.', 'codesigner' ); ?>
				</p>
				<div class="cd-pro-module-bottom">
					<!-- <a href="#" class="cd-pro-module-video">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/youtube-icon.svg' ); ?>" alt="icon">
						<?php esc_html_e( 'Watch Video', 'codesigner' ); ?>
					</a> -->
					<a href="<?php echo esc_url( 'https://codexpert.io/codesigner/pro/#codesigner-pro-email' ); ?>" class="cd-pro-module-details">
						<?php esc_html_e( 'View Details', 'codesigner' ); ?>
					</a>
				</div>
			</div>
			<div class="cd-pro-module">
				<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/invoice-icon.svg' ); ?>" alt="icon">
				<h3>
					<?php esc_html_e( 'Invoice Builder', 'codesigner' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'Create professional invoices that impress clients in seconds. Customize with your logo and branding for a seamless brand experience.', 'codesigner' ); ?>
				</p>
				<div class="cd-pro-module-bottom">
					<!-- <a href="#" class="cd-pro-module-video">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/youtube-icon.svg' ); ?>" alt="icon">
						<?php esc_html_e( 'Watch Video', 'codesigner' ); ?>
					</a> -->
					<a href="<?php echo esc_url( 'https://codexpert.io/codesigner/pro/#codesigner-pro-invoice' ); ?>" class="cd-pro-module-details">
						<?php esc_html_e( 'View Details', 'codesigner' ); ?>
					</a>
				</div>
			</div>
			<div class="cd-pro-module">
				<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/checkout-icon.svg' ); ?>" alt="icon">
				<h3>
					<?php esc_html_e( 'Checkout Builder', 'codesigner' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'Streamline your Checkout by designing beautiful and conversion-optimized checkout pages that boost sales.', 'codesigner' ); ?>
				</p>
				<div class="cd-pro-module-bottom">
					<!-- <a href="#" class="cd-pro-module-video">
						<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/youtube-icon.svg' ); ?>" alt="icon">
						<?php esc_html_e( 'Watch Video', 'codesigner' ); ?>
					</a> -->
					<a href="<?php echo esc_url( 'https://codexpert.io/codesigner/pro/#codesigner-pro-explore' ); ?>" class="cd-pro-module-details">
						<?php esc_html_e( 'View Details', 'codesigner' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="cd-free-pro-module">
		<div class="cd-pro-module-header">
			<div class="cd-module-title">
				<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/star-red.svg' ); ?>" alt="icon">
				<h2>
					<?php esc_html_e( 'Pro Widgets', 'codesigner' ); ?>
				</h2>
			</div>
			<p class="cd-module-desc">
				<?php
				esc_html_e(
					'CoDesigner Pro isn\'t just an Elementor plugin, it\'s a game-changer. Forget old WooCommerce designs - with these premium widgets, 
                                you\'ll be crafting stunning WooCommerce store pages, customize checkout, single product templates, and more to drive conversions like never before.',
					'codesigner'
				);
				?>
			</p>
		</div>

		<div class="cd-pro-widgets-wrapper">
				<?php
				foreach ( codesigner_widgets() as $key => $widget ) {
					if ( isset( $widget['pro_feature'] ) && $widget['pro_feature'] ) {
						printf( '<div class="cd-pro-widget">' );
							printf( '<i class="%1$s"></i>', esc_attr( $widget['icon'] ) );
							printf( '<h4>%1$s</h4>', esc_attr( $widget['title'] ) );
						printf( '</div>' );
					}
				}
				?>
		</div>
		<a class="cd-upgrade-btn" href="<?php echo esc_url( $pro_link ); ?>" target="_blank">
			<?php esc_html_e( 'Start Using These Widgets', 'codesigner' ); ?>
		</a>
	</div>
</div>

<div class="cd-free-pro-table-wrapper">
	<div class="cd-pro-table-header">
		<h2>
			<?php esc_html_e( 'Compare Modules & Widgets', 'codesigner' ); ?>
		</h2>
		<p>
			<?php esc_html_e( 'Unsure which tools fit your needs? Compare modules and widget features and find your perfect Match.', 'codesigner' ); ?>
		</p>
	</div>

	<div class="cd-pro-table-control">
		<button class="cd-active" data-id="module">
			<div class="cd-icon-block">
				<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/modules.svg' ); ?>" alt="icon">
			</div>
			<?php esc_html_e( 'Modules', 'codesigner' ); ?>
		</button>
		<button data-id="widget">
			<div class="cd-icon-block">
				<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/widgets.svg' ); ?>" alt="icon">
			</div>
			<?php esc_html_e( 'Widgets', 'codesigner' ); ?>
		</button>
	</div>

	<div class="cd-free-pro-table-block">
		<table>
			<colgroup>
				<col class="cd-first" />
				<col class="cd-second" />
				<col class="cd-third" />
			</colgroup>
			<thead>
				<tr>
					<th><?php esc_html_e( 'Features', 'codesigner' ); ?></th>
					<th>
						<div class="cd-table-title-icon">
							<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/love-purple.svg' ); ?>" alt="icon">
							<?php esc_html_e( 'Free', 'codesigner' ); ?>
						</div>
					</th>
					<th class="cd-table-title-icon">
						<div class="cd-table-title-icon">
							<img src="<?php echo esc_attr( CODESIGNER_ASSETS . '/img/free-pro/small-star-red.svg' ); ?>" alt="icon">
							<?php esc_html_e( 'Pro', 'codesigner' ); ?>
						</div>
					</th>
				</tr>
			</thead>

			<tbody id="cd-pro-table-module">
				<?php
					$modules = codesigner_modules();
					$i       = 1;
				foreach ( $modules as $key => $module ) {
					$odd_even_text = $i % 2 === 0 ? 'even' : 'odd';

					printf( '<tr>' );
						printf( '<td class="cd-%2$s-feature">%1$s</td>', esc_attr( $module['title'] ), esc_attr( $odd_even_text ) );

					if ( $module['pro'] ) {
						printf( '<td class="cd-%2$s-free cd-center"><img src="%1$s" alt="icon"</td>', esc_url( CODESIGNER_ASSETS . '/img/free-pro/no.svg' ), esc_attr( $odd_even_text ) );
					} else {
						printf( '<td class="cd-%2$s-free cd-center"><img src="%1$s" alt="icon"</td>', esc_url( CODESIGNER_ASSETS . '/img/free-pro/yes.svg' ), esc_attr( $odd_even_text ) );
					}

						printf( '<td class="cd-%2$s-pro cd-center"><img src="%1$s" alt="icon"</td>', esc_url( CODESIGNER_ASSETS . '/img/free-pro/yes.svg' ), esc_attr( $odd_even_text ) );
						printf( '</tr>' );

						++$i;
				}
				?>
			</tbody>

			<tbody id="cd-pro-table-widget">
				<?php
					$i = 1;
				foreach ( codesigner_widgets() as $key => $widget ) {
					if ( isset( $widget['pro_feature'] ) && $widget['pro_feature'] ) {
						$odd_even_text = $i % 2 === 0 ? 'even' : 'odd';

						printf( '<tr>' );
							printf( '<td class="cd-%2$s-feature">%1$s</td>', esc_attr( $widget['title'] ), esc_attr( $odd_even_text ) );
							printf( '<td class="cd-%2$s-free cd-center"><img src="%1$s" alt="icon"</td>', esc_url( CODESIGNER_ASSETS . '/img/free-pro/no.svg' ), esc_attr( $odd_even_text ) );
							printf( '<td class="cd-%2$s-pro cd-center"><img src="%1$s" alt="icon"</td>', esc_url( CODESIGNER_ASSETS . '/img/free-pro/yes.svg' ), esc_attr( $odd_even_text ) );
						printf( '</tr>' );

						++$i;
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<div class="cd-free-pro-review-block">
	<div class="cd-rewiew-wrapper">
		<div class="cd-review-header">
			<h2>
				<?php esc_html_e( 'What People think about ourself', 'codesigner' ); ?>
			</h2>
			<p>
				<?php esc_html_e( 'Read how CoDesigner transformed real businesses.', 'codesigner' ); ?>
			</p>
		</div>
		
		<div class="cd-pro-reviews">
			<div class="cd-pro-review">
				<div class="cd-review-user">
					<img class="cd-review-user-img" src="https://secure.gravatar.com/avatar/4d9dfd37a66e3c477ea2389fbd4aa1e4?s=150&d=retro&r=g" alt="Ghio Coste">
					
					<div class="cd-review-right">
						<div class="cd-ratings">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
						</div>

						<p class="cd-rating-num"><?php esc_html_e( '(5)', 'codesigner' ); ?></p>
					</div>
				</div>

				<h4 class="cd-review-title">
					<?php esc_html_e( 'Ghio Coste', 'codesigner' ); ?>
				</h4>

				<p class="cd-review-desc">
					<?php
					esc_html_e(
						'The only plugin so far that satisfied our needs, and think of deep integration and query whatever you want in your Woo shop. 
                        This make it possible and yes, out of the box...',
						'codesigner'
					);
					?>
				</p>
			</div>
			<div class="cd-pro-review">
				<div class="cd-review-user">
					<img class="cd-review-user-img" src="https://secure.gravatar.com/avatar/fc0f70af400b805a1a030360a7207723?s=150&d=retro&r=g" alt="andrevitormartins">
					
					<div class="cd-review-right">
						<div class="cd-ratings">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
						</div>

						<p class="cd-rating-num"><?php esc_html_e( '(5)', 'codesigner' ); ?></p>
					</div>
				</div>

				<h4 class="cd-review-title">
					<?php esc_html_e( 'andrevitormartins', 'codesigner' ); ?>
				</h4>

				<p class="cd-review-desc">
					<?php esc_html_e( 'Um ótimo olugin com um suporte incrível! Obrigado', 'codesigner' ); ?>
				</p>
			</div>
			<div class="cd-pro-review">
				<div class="cd-review-user">
					<img class="cd-review-user-img" src="https://secure.gravatar.com/avatar/61d048a7fe28bd0b4aac7d1d0849b6f2?s=150&d=retro&r=g" alt="graciewalters">
					
					<div class="cd-review-right">
						<div class="cd-ratings">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
						</div>

						<p class="cd-rating-num"><?php esc_html_e( '(5)', 'codesigner' ); ?></p>
					</div>
				</div>

				<h4 class="cd-review-title">
					<?php esc_html_e( 'graciewalters', 'codesigner' ); ?>
				</h4>

				<p class="cd-review-desc">
					<?php
					esc_html_e(
						'I had an issue with a client\'s site product data tabs not showing correctly using the hello elementor and woocommerce widgets.',
						'codesigner'
					);
					?>
				</p>
			</div>
			<div class="cd-pro-review">
				<div class="cd-review-user">
					<img class="cd-review-user-img" src="https://secure.gravatar.com/avatar/68b56d1657f2b029563381112b1f98a2?s=150&d=retro&r=g" alt="smartsoil">
					
					<div class="cd-review-right">
						<div class="cd-ratings">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
							<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/free-pro/rating.svg' ); ?>" alt="rating">
						</div>

						<p class="cd-rating-num"><?php esc_html_e( '(5)', 'codesigner' ); ?></p>
					</div>
				</div>

				<h4 class="cd-review-title">
					<?php esc_html_e( 'smartsoil', 'codesigner' ); ?>
				</h4>

				<p class="cd-review-desc">
					<?php
					esc_html_e(
						'Quick, friendly help that resolved the problem.',
						'codesigner'
					);
					?>
				</p>
			</div>
		</div>

		<a href="<?php echo esc_url( $pro_link ); ?>" target="_blank" class="cd-upgrade-btn"><?php esc_html_e( 'Upgrade Now', 'codesigner' ); ?></a>
	</div>
</div>