<?php 
use Codexpert\CoDesigner\Helper;
$add_to_cart 		= CODESIGNER_ASSETS . '/img/Add-to-cart.png';
$cross_domain 		= CODESIGNER_ASSETS . '/img/cross-domain-copy-paste.png';
$redirect_checkout 	= CODESIGNER_ASSETS . '/img/redirect-checkout.png';
$add_to_cart_text	= Helper::get_option( 'codesigner_tools', 'add-to-cart-text' );
$add_cart_checked 	= ( $add_to_cart_text != '' ) ? 'checked' : '' ;
$checkout			= Helper::get_option( 'codesigner_tools', 'redirect_to_checkout' );
$redirect_checked 	= ( $checkout != '' ) ? 'checked' : '' ;
$cross_domain_copy	= Helper::get_option( 'codesigner_tools', 'cross_domain_copy_paste' );
$cross_domain_checked = ( $cross_domain_copy != '' ) ? 'checked' : '' ;

?>
<div class="setup-wizard-configration-panel">
	<h4 class="cx-title"><?php esc_html( 'Configration', 'codesigner' ); ?></h4>
	<div class="setup-wizard-configrations">
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php esc_html( 'Add To Cart Text', 'codesigner' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap">
					<label class="cx-toggle">
						  <input type="checkbox" <?php echo esc_attr( $add_cart_checked ); ?> name="enable_add-to-cart" id="codesigner_tools-add-to-cart" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<div class="cx-hide-fields" style="display: none;">
						<input class="cx-input" type="text" name="add-to-cart-text" value="<?php echo esc_attr( $add_to_cart_text); ?>">
					</div>

					<p class="cx-desc"><?php esc_html( 'Enable this if you want to replace the text of the \'Add to cart\' button with something else. E.g. \'Buy Now\' or \'Purchase\'.', 'codesigner' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $add_to_cart ); ?>">
			</div>
		</div>
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php esc_html( 'Redirect to checkout', 'codesigner' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap ">
					<label class="cx-toggle">
						<input type="checkbox" <?php echo esc_attr( $redirect_checked ); ?> name="redirect_to_checkout" id="codesigner_tools-redirect_to_checkout" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<p class="cx-desc"><?php esc_html( 'Enable this if you want to skip the cart page and take customers directly to the checkout page after they add products to the cart.', 'codesigner' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $redirect_checkout ); ?>">
			</div>
		</div>
		<div class="setup-wizard-configration">
			<div class="setup-wizard-configration-label">
				<label for=""><?php esc_html( 'Cross-domain Copy Paste', 'codesigner' ); ?></label>
			</div>
			<div class="setup-wizard-configration-content">
				<div class="cx-field-wrap ">
					<label class="cx-toggle">
						<input type="checkbox" <?php echo esc_attr( $cross_domain_checked ); ?> name="cross_domain_copy_paste" id="codesigner_tools-cross_domain_copy_paste" class="cx-toggle-checkbox cx-field cx-field-switch" value="on">
						<div class="cx-toggle-switch"></div>
					</label>
					<p class="cx-desc"><?php esc_html( 'Enable this if you want to enable cross-domain copy &amp; paste feature. It\'ll help you copy a widget or section that you designed on one of your sites to another one.', 'codesigner' ); ?></p>
				</div>
			</div>
			<div class="setup-wizard-configration-img">
				<img src="<?php echo esc_url( $cross_domain ); ?>">
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(function($){
		
		if ($('#codesigner_tools-add-to-cart').is(':checked')) {
			$('.cx-hide-fields').slideDown();
		}

		$(document).on( 'click', '#codesigner_tools-add-to-cart', function (e) {
			if ( $(this).is(':checked') ) {
				$('.cx-hide-fields').slideDown();
			}
			else {
				$('.cx-hide-fields').slideUp();
			}
		} );
	});
</script>