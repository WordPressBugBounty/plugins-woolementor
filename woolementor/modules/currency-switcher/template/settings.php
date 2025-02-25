<?php
if ( get_option( 'codesigner_currency_switcher', true ) ) {
	$cd_currency = get_option( 'codesigner_currency_switcher', true );

	if ( empty( $cd_currency ) || ! is_array( $cd_currency ) ) {
		$cd_currency = array(
			array(
				'cd_cs_name'  => '',
				'cd_cs_rate'  => '',
				'cd_cs_image' => '',
			),
		);
	} else {
		$cd_currency = get_option( 'codesigner_currency_switcher', true )['cd_currency'];
	}

	?>
	<div class="cd-cs-wrapper">
		<?php foreach ( $cd_currency as $index => $values ) { ?>
			<div class="cd-single-currency">
				<select name="cd_currency[<?php esc_attr( $index ); ?>][cd_cs_name]" class="cd-currency-name">
					<?php
					if ( function_exists( 'get_woocommerce_currencies' ) ) {
						$currency_options         = get_woocommerce_currencies();
						$currency_options['none'] = 'None';
						foreach ( $currency_options as $currency_code => $currency_name ) {
							$selected = ( esc_attr( $values['cd_cs_name'] ) == $currency_code ) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr( $currency_code ); ?> <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $currency_name ); ?></option>
							<?php
						}
					}
					?>
				</select>
				<?php
				if ( isset( $values['cd_cs_rate'] ) ) {
					?>
					<input type="text" name="cd_currency[<?php esc_attr( $index ); ?>][cd_cs_rate]" value="<?php echo esc_attr( $values['cd_cs_rate'] ); ?>" placeholder="Rate" />
					<?php
				} else {
					?>
					<input type="text" name="cd_currency[<?php esc_attr( $index ); ?>][cd_cs_rate]" value="" placeholder="Rate" />
					<?php
				}
				if ( isset( $values['cd_cs_img'] ) ) {
					?>
					<input type="hidden" name="cd_currency[<?php esc_attr( $index ); ?>][cd_cs_img]" value="<?php echo esc_attr( $values['cd_cs_img'] ); ?>" class= 'cd-cs-image' />
					<?php
				} else {
					?>
					<input type="hidden" name="cd_currency[<?php esc_attr( $index ); ?>][cd_cs_img]" value="" class= 'cd-cs-image' />
					<?php
				}
				?>

				<div class="cd-cs-preview-image">
					<?php if ( isset( $values['cd_cs_img'] ) && wp_get_attachment_url( $values['cd_cs_img'] ) ) : ?>
						<img class= 'cd-cs-upload-image' src="<?php echo esc_url( wp_get_attachment_url( $values['cd_cs_img'] ) ); ?>" >
					<?php else : ?>
						<button class='cd-cs-upload-image cd-cs-button'><?php esc_attr_e( 'Upload Flag', 'codesigner' ); ?></button>
					<?php endif ?>
				</div>
				<a class="cd-cs-add-row">+</a>
				<a class="cd-cs-remove-row">-</a>
			</div>
		<?php } ?>
	</div>
	<?php
}
