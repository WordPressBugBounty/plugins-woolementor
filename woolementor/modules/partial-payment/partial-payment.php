<?php
namespace Codexpert\CoDesigner\Modules;

use Codexpert\CoDesigner\Helper;

use Codexpert\Plugin\Base;

class Partial_Payment extends Base {

	public $id = 'codesigner_partial_payment';

	public $slug;

	public $version;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->action( 'init', 'init_plugin' );

		// register order status
		$this->action( 'woocommerce_register_shop_order_post_statuses', 'register_partial_payment_order_status' );
		$this->filter( 'wc_order_statuses', 'add_partial_payment_order_status' );

		// scripts
		$this->action( 'admin_enqueue_scripts', 'admin_enqueue_script' );
		$this->action( 'wp_enqueue_scripts', 'enqueue_script' );

		// admin
		$this->filter( 'woocommerce_product_data_tabs', 'add_partial_payment_tab' );
		$this->action( 'woocommerce_product_data_panels', 'partial_payment_tab_panel' );
		$this->action( 'woocommerce_process_product_meta', 'save_partial_payment_data' );

		// cart
		$this->action( 'woocommerce_before_add_to_cart_button', 'display_payment_option' );
		$this->filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 4 );
		$this->action( 'woocommerce_add_to_cart', 'save_product_original_price' );
		$this->filter( 'woocommerce_cart_item_subtotal', 'update_cart_item_subtotal', 10, 3 );

		// cart & checkout
		$this->filter( 'woocommerce_get_item_data', 'display_cart_item_installment', 10, 2 );
		$this->action( 'woocommerce_cart_totals_after_order_total', 'add_installment_after_order_total' );
		$this->filter( 'woocommerce_checkout_create_order_line_item', 'add_order_item_meta', 10, 4 );
		$this->action( 'woocommerce_review_order_after_order_total', 'add_installment_after_order_total' );

		// order item meta display
		$this->filter( 'woocommerce_order_item_get_formatted_meta_data', 'format_order_item_meta_for_display', 10, 2 );

		// create order
		$this->filter( 'woocommerce_calculated_total', 'change_total_before_order_is_placed' );
		$this->action( 'woocommerce_checkout_create_order', 'add_partial_payment_order_meta', 10, 2 );

		// payment
		$this->filter( 'woocommerce_valid_order_statuses_for_payment', 'add_status_for_payment', 10, 2 );
		$this->filter( 'woocommerce_valid_order_statuses_for_payment_complete', 'add_status_for_payment', 10, 2 );
		$this->action( 'woocommerce_payment_complete', 'change_stripe_payment_intent_meta_key' );

		// thankyou page
		$this->action( 'woocommerce_thankyou', 'change_order_status' );

		// email
		$this->action( 'woocommerce_email_after_order_table', 'add_email_due_payment_link' );

		/**
		 * admin order edit page and
		 * woocommerce dashboard order display page
		 */
		$this->action( 'woocommerce_admin_order_totals_after_total', 'add_partial_payment_data' );
		$this->filter( 'woocommerce_get_order_item_totals', 'add_partial_payment_order_item_totals', 10, 3 );
		$this->filter( 'woocommerce_my_account_my_orders_actions', 'add_orders_list_due_payment_action', 10, 2 );
	}

	/**
	 * Form WP version 6.7.0 Need to loade some
	 * Data like TextDomain and other in init hook
	 */
	public function init_plugin() {
		$this->plugin  = get_plugin_data( CODESIGNER );
		$this->slug    = $this->plugin['TextDomain'];
		$this->version = $this->plugin['Version'];
	}

	public function __settings( $settings ) {
		$settings['sections'][ $this->id ] = array(
			'id'     => $this->id,
			'label'  => __( 'Partial Payment', 'codesigner' ),
			'icon'   => 'dashicons-money-alt',
			'sticky' => false,
			'fields' => array(
				array(
					'id'      => 'pp-first-label',
					'label'   => __( 'First Installment Label', 'codesigner' ),
					'type'    => 'text',
					'default' => __( 'First Installment', 'codesigner' ),
					'desc'    => __( 'Change if you want to set the first installment label.', 'codesigner' ),
				),
				array(
					'id'      => 'pp-second-label',
					'label'   => __( 'Second Installment Label', 'codesigner' ),
					'type'    => 'text',
					'default' => __( 'Second Installment', 'codesigner' ),
					'desc'    => __( 'Change if you want to set the second installment label.', 'codesigner' ),
				),
				array(
					'id'      => 'pp-type-label',
					'label'   => __( 'Payment Type Label', 'codesigner' ),
					'type'    => 'text',
					'default' => __( 'Payment Type', 'codesigner' ),
					'desc'    => __( 'Change if you want to set the payment type label.', 'codesigner' ),
				),
				array(
					'id'      => 'pp-default-percentage',
					'label'   => __( 'Default Percentage Amount', 'codesigner' ),
					'type'    => 'number',
					'default' => 50,
					'min'     => 1,
					'max'     => 100,
					'desc'    => __( 'Enter default percentage amount for partial payment products.', 'codesigner' ),
				),
				array(
					'id'      => 'pp-default-fixed',
					'label'   => __( 'Default Fixed Amount', 'codesigner' ),
					'type'    => 'number',
					'default' => 10,
					'min'     => 1,
					'desc'    => __( 'Enter default fixed amount for partial payment products.', 'codesigner' ),
				),
				array(
					'id'      => 'pp-default-custom',
					'label'   => __( 'Default Custom Amount', 'codesigner' ),
					'type'    => 'number',
					'default' => 10,
					'min'     => 1,
					'desc'    => __( 'Enter default minimum amount for partial payment products.', 'codesigner' ),
				),
			),
		);

		return $settings;
	}

	public function register_partial_payment_order_status( $order_statuses ) {
		$order_statuses['wc-partial-payment'] = array(
			'label'                     => _x( 'Partially Paid', 'Order status', 'codesigner' ),
			'public'                    => false,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop(
				'Partially Paid <span class="count">(%s)</span>',
				'Partially Paid <span class="count">(%s)</span>',
				'codesigner'
			),
		);

		return $order_statuses;
	}

	public function add_partial_payment_order_status( $order_statuses ) {
		$order_statuses['wc-partial-payment'] = _x( 'Partially Paid', 'Order status', 'codesigner' );

		return $order_statuses;
	}

	public function admin_enqueue_script() {
		wp_enqueue_script( 'cd-partial-payment-admin-js', plugins_url( '/modules/partial-payment/js/admin.js', CODESIGNER ), array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'cd-partial-payment-admin-css', plugins_url( '/modules/partial-payment/css/admin.css', CODESIGNER ), '', $this->version, 'all' );
	}

	public function enqueue_script() {
		wp_enqueue_script( 'cd-partial-payment-front-js', plugins_url( '/modules/partial-payment/js/front.js', CODESIGNER ), array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'cd-partial-payment-front-css', plugins_url( '/modules/partial-payment/css/front.css', CODESIGNER ), '', $this->version, 'all' );
	}

	public function add_partial_payment_tab( $tabs ) {
		// Add a new tab
		$tabs['partial_payment'] = array(
			'label'    => __( 'Partial Payment', 'codesigner' ),
			'target'   => 'partial_payment_tab_content',
			'class'    => array( 'show_if_simple' ),
			'priority' => 80,
		);

		return $tabs;
	}

	public function partial_payment_tab_panel() {
		$enable_partial_payment    = get_post_meta( get_the_ID(), 'cd_enable_partial_payment', true );
		$partial_payment_type      = get_post_meta( get_the_ID(), 'cd_partial_amount_type', true );
		$percentage_payment_amount = get_post_meta( get_the_ID(), 'cd_percentage_payment_amount', true );
		$fixed_payment_amount      = get_post_meta( get_the_ID(), 'cd_fixed_payment_amount', true );
		$minimum_payment_amount    = get_post_meta( get_the_ID(), 'cd_minimum_payment_amount', true );

		?>
		<div id="partial_payment_tab_content" class="panel woocommerce_options_panel">
			<?php
			woocommerce_wp_checkbox(
				array(
					'id'          => 'cd_enable_partial_payment',
					'label'       => __( 'Enable Partial Payment', 'codesigner' ),
					'value'       => $enable_partial_payment ? $enable_partial_payment : 'no',
					'description' => __( 'Enable this if you want to accept partial payment for this product.', 'codesigner' ),
					'desc_tip'    => 'true',
				)
			);

			?>
			<div id="partial_payment_options" style="display:none;">
				<?php
				woocommerce_wp_select(
					array(
						'id'          => 'cd_partial_amount_type',
						'label'       => __( 'Partial Amount Type', 'codesigner' ),
						'description' => __( 'Select Partial Amount Type', 'codesigner' ),
						'desc_tip'    => 'true',
						'options'     => array(
							'percentage' => __( 'Percentage', 'codesigner' ),
							'fixed'      => __( 'Fixed', 'codesigner' ),
							'custom'     => __( 'Custom', 'codesigner' ),
						),
						'value'       => $partial_payment_type ? $partial_payment_type : 'percentage',
					)
				);

				?>
			<div id="cd_percentage_payment">
				<?php
				woocommerce_wp_text_input(
					array(
						'id'          => 'cd_percentage_payment_amount',
						'label'       => __( 'Percentage Amount', 'codesigner' ),
						'description' => __( 'Enter the payment amount that customers have to pay.', 'codesigner' ),
						'desc_tip'    => 'true',
						'value'       => $percentage_payment_amount ? $percentage_payment_amount : Helper::get_option( 'codesigner_partial_payment', 'pp-default-percentage', 50 ),
					)
				);
				?>
			</div>
			
			<div id="cd_fixed_payment">
				<?php
				woocommerce_wp_text_input(
					array(
						'id'          => 'cd_fixed_payment_amount',
						'label'       => __( 'Fixed Payment Amount', 'codesigner' ),
						'description' => __( 'Enter the payment amount that customers have to pay.', 'codesigner' ),
						'desc_tip'    => 'true',
						'value'       => $fixed_payment_amount ? $fixed_payment_amount : Helper::get_option( 'codesigner_partial_payment', 'pp-default-fixed', 5 ),
					)
				);
				?>
			</div>

			<div id="cd_custom_payment" style="display:none;">
				<?php
				woocommerce_wp_text_input(
					array(
						'id'          => 'cd_minimum_payment_amount',
						'label'       => __( 'Minimum Payment Amount', 'codesigner' ),
						'description' => __( 'Enter the minimum payment amount that customers have to pay.', 'codesigner' ),
						'desc_tip'    => 'true',
						'value'       => $minimum_payment_amount ? $minimum_payment_amount : Helper::get_option( 'codesigner_partial_payment', 'pp-default-custom', 10 ),
					)
				);
				?>
			</div>

			<?php
			woocommerce_wp_note(
				array(
					'id'      => 'cd_partial_payment_note',
					'label'   => __( 'Note', 'codesigner' ),
					'message' => __( 'Disable guest checkout and Cash on Delivery from WooCommerce Settings for Partial Payment.', 'codesigner' ),
				)
			);
			?>
			</div>
		</div>
		<?php
	}

	public function save_partial_payment_data( $post_id ) {
		if ( isset( $_POST['cd_enable_partial_payment'] ) && $this->sanitize( $_POST['cd_enable_partial_payment'] ) === 'yes' ) {
			update_post_meta( $post_id, 'cd_enable_partial_payment', $this->sanitize( $_POST['cd_enable_partial_payment'] ) );
			update_post_meta( $post_id, 'cd_partial_amount_type', $this->sanitize( $_POST['cd_partial_amount_type'] ) );

			if ( $this->sanitize( $_POST['cd_partial_amount_type'] ) === 'custom' ) {
				update_post_meta( $post_id, 'cd_minimum_payment_amount', $this->sanitize( $_POST['cd_minimum_payment_amount'] ) );
				delete_post_meta( $post_id, 'cd_percentage_payment_amount' );
				delete_post_meta( $post_id, 'cd_fixed_payment_amount' );
			} elseif ( $this->sanitize( $_POST['cd_partial_amount_type'] ) === 'percentage' ) {
				update_post_meta( $post_id, 'cd_percentage_payment_amount', $this->sanitize( $_POST['cd_percentage_payment_amount'] ) );
				delete_post_meta( $post_id, 'cd_minimum_payment_amount' );
				delete_post_meta( $post_id, 'cd_fixed_payment_amount' );
			} elseif ( $this->sanitize( $_POST['cd_partial_amount_type'] ) === 'fixed' ) {
				update_post_meta( $post_id, 'cd_fixed_payment_amount', $this->sanitize( $_POST['cd_fixed_payment_amount'] ) );
				delete_post_meta( $post_id, 'cd_minimum_payment_amount' );
				delete_post_meta( $post_id, 'cd_percentage_payment_amount' );
			}
		} else {
			delete_post_meta( $post_id, 'cd_enable_partial_payment' );
			delete_post_meta( $post_id, 'cd_partial_amount_type' );
			delete_post_meta( $post_id, 'cd_percentage_payment_amount' );
			delete_post_meta( $post_id, 'cd_fixed_payment_amount' );
			delete_post_meta( $post_id, 'cd_minimum_payment_amount' );
		}
	}

	public function display_payment_option() {
		$product_id = get_the_ID();
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			return;
		}

		if ( get_post_meta( $product_id, 'cd_enable_partial_payment', true ) && $product->is_in_stock() ) {
			$partial_amount_type       = get_post_meta( $product_id, 'cd_partial_amount_type', true );
			$percentage_payment_amount = get_post_meta( $product_id, 'cd_percentage_payment_amount', true );
			$fixed_payment_amount      = get_post_meta( $product_id, 'cd_fixed_payment_amount', true );
			$minimum_payment_amount    = get_post_meta( $product_id, 'cd_minimum_payment_amount', true );
			$select_field_text         = ucwords( $partial_amount_type ) . ' Payment';

			?>
			<div class="cd_partial_payment_block">
				<p><?php echo esc_attr( __( 'Select Payment Type', 'codesigner' ) ); ?></p>

				<div class="cd_radio_block">
					<input type="radio" id="cd_full" name="cd_partial_payment_type" value="full" checked>
					<label for="cd_full"><?php echo esc_attr( __( 'Full Payment', 'codesigner' ) ); ?></label><br>
				</div>
				
				<div class="cd_radio_block">
					<input type="radio" id="cd_partial" name="cd_partial_payment_type" value="<?php echo esc_attr( $partial_amount_type ); ?>">
					<label for="cd_partial"><?php echo esc_html( $select_field_text ); ?></label>
				</div>

				<div class="cd_partial_payment_amount_block" style="display: none;">
					<p class="cd_partial_amount" style="display: none;">
						<?php
						if ( $partial_amount_type === 'percentage' ) {
							$product_price     = $product->get_price();
							$first_installment = $product_price * $percentage_payment_amount / 100;

							printf(
								esc_attr( __( 'First installment( %1$1s%2$2s ): %3$0.2f%4$4s Per Item.', 'codesigner' ) ),
								esc_attr( $percentage_payment_amount ),
								'&percnt;',
								esc_attr( $first_installment ),
								esc_attr( get_woocommerce_currency_symbol() )
							);
						}
						if ( $partial_amount_type === 'fixed' ) {
							printf(
								esc_attr( __( 'First installment( Fixed ): %1$0.2f%2$2s Per Item.', 'codesigner' ) ),
								esc_attr( $fixed_payment_amount ),
								esc_attr( get_woocommerce_currency_symbol() )
							);
						}
						?>
					</p>
					<p class="cd_custom_amount" style="display: none;">
						<input 
							type        = "number" 
							name        = "cd_custom_payment" 
							id          = "cd_custom_payment" 
							min         = "<?php echo esc_attr( $minimum_payment_amount ); ?>"
							value       = "<?php echo esc_attr( $minimum_payment_amount ); ?>"
							placeholder = "<?php printf( esc_attr( __( 'Minimum Amount is %1$0.2f%2$2s', 'codesigner' ) ), esc_attr( $minimum_payment_amount ), esc_attr( get_woocommerce_currency_symbol() ) ); ?>" 
						>
					</p>
				</div>
			</div>
			<?php
		}
	}

	public function add_cart_item_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
		if ( isset( $_POST['cd_partial_payment_type'] ) ) {
			$product      = wc_get_product( $product_id );
			$payment_type = $this->sanitize( $_POST['cd_partial_payment_type'] );

			/**
			 * Check is product already added in the cart
			 * with full/custom/percentage payment
			 */
			foreach ( WC()->cart->get_cart() as $item_key => $cart_item ) {
				if ( ( $cart_item['product_id'] == $product_id ) && ( $cart_item['variation_id'] == $variation_id ) && ( $cart_item['cd_payment_type'] != $payment_type ) ) {
					throw new \Exception( esc_html__( 'Item already added in the cart with ' . $cart_item['cd_payment_type'] . ' payment', 'codesigner' ) );
				}
			}

			$cart_item_data['cd_payment_type'] = $payment_type;

			// check payment type
			if ( $payment_type === 'full' ) {
				return $cart_item_data;
			}

			if ( $payment_type === 'percentage' ) {
				$percentage_amount = get_post_meta( $product_id, 'cd_percentage_payment_amount', true );
				$first_installment = $product->get_price() * $percentage_amount / 100;

				$cart_item_data[ 'cd_' . $payment_type . '_amount' ] = $first_installment;
			} elseif ( $payment_type === 'fixed' ) {
				$fixed_amount = get_post_meta( $product_id, 'cd_fixed_payment_amount', true );

				$cart_item_data[ 'cd_' . $payment_type . '_amount' ] = $fixed_amount;
			} elseif ( $payment_type === 'custom' ) {
				$cart_item_data[ 'cd_' . $payment_type . '_amount' ] = $this->sanitize( $_POST[ 'cd_' . $payment_type . '_payment' ] );
			}
		}

		return $cart_item_data;
	}

	public function save_product_original_price( $cart_item_key ) {
		$cart_item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $cart_item['cd_payment_type'] ) && $cart_item['cd_payment_type'] !== 'full' ) {
			$product = $cart_item['data'];
			WC()->cart->cart_contents[ $cart_item_key ]['cd_product_original_price'] = $product->get_price();
		}
	}

	public function update_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
		$payment_type = isset( $cart_item['cd_payment_type'] ) ? $cart_item['cd_payment_type'] : null;

		if ( $payment_type && $payment_type !== 'full' ) {
			$partial_amount = $cart_item[ 'cd_' . $payment_type . '_amount' ] * $cart_item['quantity'];
			$subtotal       = wc_price( $partial_amount );
		}

		return $subtotal;
	}

	public function display_cart_item_installment( $item_data, $cart_item ) {
		$product_id   = $cart_item['product_id'];
		$variation_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
		$product_data = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
		$payment_type = isset( $cart_item['cd_payment_type'] ) ? $cart_item['cd_payment_type'] : null;

		if ( $payment_type && $payment_type !== 'full' ) {
			$first_installment_amount  = $cart_item[ 'cd_' . $payment_type . '_amount' ] * $cart_item['quantity'];
			$second_installment_amount = ( $product_data->get_price() * $cart_item['quantity'] ) - $first_installment_amount;

			$item_data[] = array(
				'name'    => esc_html__( Helper::get_option( 'codesigner_partial_payment', 'pp-first-label', 'First Installment' ), 'codesigner' ),
				'display' => wc_price( $first_installment_amount ),
			);

			$item_data[] = array(
				'name'    => esc_html__( 'Second Installment', 'codesigner' ),
				'name'    => esc_html__( Helper::get_option( 'codesigner_partial_payment', 'pp-second-label', 'Second Installment' ), 'codesigner' ),
				'display' => wc_price( $second_installment_amount ),
			);
		}

		return $item_data;
	}

	public function add_installment_after_order_total() {
		if ( WC()->cart ) {
			$order_total                = WC()->cart->get_total( 'f' );
			$subtotal_first_installment = $subtotal_second_installment = 0;
			$is_partial_payment         = false;

			foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
				$product_id   = $cart_item['product_id'];
				$variation_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
				$product      = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
				$payment_type = isset( $cart_item['cd_payment_type'] ) ? $cart_item['cd_payment_type'] : null;

				if ( $payment_type && $payment_type !== 'full' ) {
					$is_partial_payment = true;
					$first_installment  = $cart_item[ 'cd_' . $payment_type . '_amount' ] * $cart_item['quantity'];
					$second_installment = ( $product->get_price() * $cart_item['quantity'] ) - $first_installment;

					$subtotal_first_installment  += $first_installment;
					$subtotal_second_installment += $second_installment;
				}
			}

			if ( $is_partial_payment && $subtotal_second_installment > 0 ) {
				?>
					<tr class="order-total cd-order-total">
						<th><?php esc_html_e( 'Order Total', 'woocommerce' ); ?></th>
						<td><?php echo wp_kses_post( wc_price( $order_total + $subtotal_second_installment ) ); ?></td>
					</tr>
					<tr class="cd-order-paid">
						<th><?php echo esc_html__( 'Currently Paying', 'codesigner' ); ?></th>
						<td><?php echo wp_kses_post( wc_price( $order_total ) ); ?></td>
					</tr>
					<tr class="cd-order-due">
						<th><?php echo esc_html__( 'Due', 'codesigner' ); ?></th>
						<td><?php echo wp_kses_post( wc_price( $subtotal_second_installment ) ); ?></td>
					</tr>
				<?php
			} elseif ( $is_partial_payment && $subtotal_second_installment == 0 ) {
				?>
				<tr class="order-total cd-old">
					<th><?php esc_html_e( 'Total', 'codesigner' ); ?></th>
					<td><?php wc_cart_totals_order_total_html(); ?></td>
				</tr>
				<?php
			}
		}
	}

	public function add_order_item_meta( $item, $cart_item_key, $values, $order ) {
		$cart_item      = WC()->cart->get_cart()[ $cart_item_key ];
		$product_id     = $cart_item['product_id'];
		$variation_id   = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
		$product        = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
		$currently_paid = $cart_item[ 'cd_' . $cart_item['cd_payment_type'] . '_amount' ];
		$due_amount     = $order->get_meta( 'cd-order-due' ) ? $order->get_meta( 'cd-order-due' ) : $product->get_price() - $cart_item[ 'cd_' . $cart_item['cd_payment_type'] . '_amount' ];

		if ( isset( $cart_item['cd_payment_type'] ) && $cart_item['cd_payment_type'] !== 'full' ) {
			$item->add_meta_data( 'cd_partial_payment_type', __( 'Partial Payment', 'codesigner' ), true );
			$item->add_meta_data( 'cd_partial_payment_amount', $currently_paid, true );
			$item->add_meta_data( 'cd_partial_payment_due', $due_amount, true );
		}
	}

	public function format_order_item_meta_for_display( $formatted_meta, $item ) {
		foreach ( $formatted_meta as $key => $meta ) {

			if ( $meta->key === 'cd_partial_payment_type' ) {
				$meta->display_key   = esc_html__( Helper::get_option( 'codesigner_partial_payment', 'pp-type-label', 'Payment Type' ), 'codesigner' );
				$meta->display_value = ucfirst( strip_tags( trim( $meta->display_value ) ) );
			}

			if ( $meta->key === 'cd_partial_payment_amount' ) {
				$meta->display_key   = esc_html__( Helper::get_option( 'codesigner_partial_payment', 'pp-first-label', 'First Installment' ), 'codesigner' );
				$meta->display_value = wc_price( strip_tags( trim( $meta->display_value ) ) );
			}

			if ( $meta->key === 'cd_partial_payment_due' ) {
				$meta->display_key   = esc_html__( Helper::get_option( 'codesigner_partial_payment', 'pp-second-label', 'Second Installment' ), 'codesigner' );
				$meta->display_value = wc_price( strip_tags( trim( $meta->display_value ) ) );
			}
		}

		return $formatted_meta;
	}

	public function change_total_before_order_is_placed( $total ) {
		$subtotal_first_installment = $subtotal_second_installment = 0;
		foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
			$product_id   = $cart_item['product_id'];
			$variation_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
			$product      = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
			$payment_type = isset( $cart_item['cd_payment_type'] ) ? $cart_item['cd_payment_type'] : null;

			if ( $payment_type && $payment_type !== 'full' ) {
				$first_installment  = $cart_item[ 'cd_' . $payment_type . '_amount' ] * $cart_item['quantity'];
				$second_installment = ( $product->get_price() * $cart_item['quantity'] ) - $first_installment;

				$subtotal_first_installment  += $first_installment;
				$subtotal_second_installment += $second_installment;
			}
		}

		if ( $subtotal_second_installment > 0 ) {
			return $total - $subtotal_second_installment;
		}

		return $total;
	}

	public function add_partial_payment_order_meta( $order, $data ) {
		$cart = WC()->cart;

		if ( ! $cart->is_empty() ) {
			$cart_items                 = $cart->get_cart();
			$order_total                = $cart->get_total( 'f' );
			$subtotal_first_installment = $subtotal_second_installment = 0;

			foreach ( $cart_items as $key => $cart_item ) {
				$product_id   = $cart_item['product_id'];
				$variation_id = isset( $cart_item['variation_id'] ) && $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : null;
				$product      = $variation_id ? wc_get_product( $variation_id ) : wc_get_product( $product_id );
				$payment_type = isset( $cart_item['cd_payment_type'] ) ? $cart_item['cd_payment_type'] : null;

				if ( $payment_type && $payment_type !== 'full' ) {
					$first_installment  = $cart_item[ 'cd_' . $payment_type . '_amount' ] * $cart_item['quantity'];
					$second_installment = ( $product->get_price() * $cart_item['quantity'] ) - $first_installment;

					$subtotal_first_installment  += $first_installment;
					$subtotal_second_installment += $second_installment;
				}
			}

			if ( $subtotal_second_installment > 0 ) {
				$order->update_meta_data( 'cd-partial-payment-order', true );
				$order->update_meta_data( 'cd-order-total', $order_total + $subtotal_second_installment );
				$order->update_meta_data( 'cd-order-paid', $order_total );
				$order->update_meta_data( 'cd-order-due', $subtotal_second_installment );
			}
		}
	}

	public function add_status_for_payment( $statuses, $order ) {
		array_push( $statuses, 'partial-payment' );

		return $statuses;
	}

	public function change_stripe_payment_intent_meta_key( $order_id ) {
		$order            = wc_get_order( $order_id );
		$is_partial_order = $order->get_meta( 'cd-partial-payment-order' );

		if ( $is_partial_order ) {
			$prev_intent = $order->get_meta( '_stripe_intent_id_cd_first' );

			/**
			 * Check if previously paid
			 */
			if ( ! $prev_intent ) {
				// get stripe payment intent
				$first_intent = $order->get_meta( '_stripe_intent_id' );

				/**
				 * Change Stripe payment intent ID key
				 * so that next payment can be processed
				 */
				if ( $first_intent ) {
					$order->update_meta_data( '_stripe_intent_id_cd_first', $first_intent );
					$order->delete_meta_data( '_stripe_intent_id' );
					$order->save();
				}
			} else {
				$order->update_meta_data( 'cd-order-fully-paid', true );
				$order->update_meta_data( 'cd-order-paid', $order->get_meta( 'cd-order-total' ) );
				$order->update_meta_data( 'cd-order-due', 0 );
				$order->save();
			}
		}
	}

	public function change_order_status( $order_id ) {
		$order            = wc_get_order( $order_id );
		$is_partial_order = $order->get_meta( 'cd-partial-payment-order' );

		if ( ! $is_partial_order ) {
			return;
		}

		if ( $is_partial_order ) {
			$order_total    = $order->get_meta( 'cd-order-total' );
			$paid_amount    = $order->get_meta( 'cd-order-paid' );
			$is_paid_before = $order->get_meta( '_stripe_intent_id_cd_first' );
			$is_paid_full   = $order->get_meta( 'cd-order-fully-paid' );

			/**
			 * Check if order is partially paid or
			 * fully paid
			 */
			if ( $is_paid_before && ! $is_paid_full ) {
				$due_amount = $order->get_meta( 'cd-order-due' );

				// check due amount
				if ( $due_amount > 0 ) {
					$order->set_total( $due_amount );
					$order->update_status( 'wc-partial-payment' );
					$order->save();
				} else {
					$order->update_status( 'processing' );
					$order->save();
				}
			} else {
				$order->set_total( $order_total );
				$order->update_status( 'processing' );
				$order->save();
			}
		}
	}

	public function add_email_due_payment_link( $order ) {
		$is_partial_order = $order->get_meta( 'cd-partial-payment-order' );
		$order_due        = $order->get_meta( 'cd-order-due' );
		if ( $is_partial_order && $order_due > 0 ) {
			$due_payment_url = wc_get_endpoint_url( 'order-pay', $order->get_id(), wc_get_checkout_url() );

			$due_payment_url = add_query_arg(
				array(
					'cd_due_payment' => 'true',
					'pay_for_order'  => 'true',
					'key'            => $order->get_order_key(),
				),
				$due_payment_url
			);

			?>
			<p>
				<?php
				echo esc_attr( __( 'Pay Due Amount: ', 'codesigner' ) );
				?>
			<a href="<?php echo esc_url( $due_payment_url ); ?>">
			<?php
				esc_html_e( __( 'Pay Now', 'codesigner' ) );
			?>
			</a></p>
			<?php
		}
	}

	public function add_partial_payment_data( $order_id ) {
		$order            = wc_get_order( $order_id );
		$is_partial_order = $order->get_meta( 'cd-partial-payment-order' );

		if ( $is_partial_order ) :
			$order_total = $order->get_meta( 'cd-order-total' );
			$amount_paid = $order->get_meta( 'cd-order-paid' );
			$amount_due  = $order->get_meta( 'cd-order-due' );
			?>
		<tr>
			<td class="label"><?php echo esc_html__( 'Order Total:', 'codesigner' ); ?></td>
			<td width="1%"></td>
			<td class="total"><?php echo wp_kses_post( wc_price( $order_total ) ); ?></td>
		</tr>
		<tr>
			<td class="label"><?php echo esc_html__( 'Currently Paid:', 'codesigner' ); ?></td>
			<td width="1%"></td>
			<td class="total"><?php echo wp_kses_post( wc_price( $amount_paid ) ); ?></td>
		</tr>
		<tr>
			<td class="label"><?php echo esc_html__( 'Due:', 'codesigner' ); ?></td>
			<td width="1%"></td>
			<td class="total"><?php echo wp_kses_post( wc_price( $amount_due ) ); ?></td>
		</tr>
			<?php
		endif;
	}

	public function add_partial_payment_order_item_totals( $total_rows, $order, $tax_display ) {
		$is_partial_order  = $order->get_meta( 'cd-partial-payment-order' );
		$is_final_checkout = isset( $_GET['cd_due_payment'] ) ? true : false;

		// Due checkout page
		if ( $is_partial_order && $is_final_checkout && is_checkout() ) {
			$custom_rows = array(
				'payment_method' => array(
					'label' => __( 'Payment method:', 'codesigner' ),
					'value' => $order->get_payment_method_title(),
				),
				'order_total'    => array(
					'label' => __( 'Total:', 'codesigner' ),
					'value' => $order->get_formatted_order_total( $tax_display ),
				),
			);

			return $custom_rows;
		}

		// Order Details Table
		if ( $is_partial_order ) {
			$order_total = $order->get_meta( 'cd-order-total' );
			$amount_paid = $order->get_meta( 'cd-order-paid' );
			$amount_due  = $order->get_meta( 'cd-order-due' );

			$total_rows['order_total']['label']   = __( 'Order Total:', 'codesigner' );
			$total_rows['order_total']['value']   = wc_price( $order_total );
			$total_rows['cd_order_paid']['label'] = __( 'Currently Paid:', 'codesigner' );
			$total_rows['cd_order_paid']['value'] = wc_price( $amount_paid );
			$total_rows['cd_order_due']['label']  = __( 'Due:', 'codesigner' );
			$total_rows['cd_order_due']['value']  = wc_price( $amount_due );
		}

		return $total_rows;
	}

	public function add_orders_list_due_payment_action( $actions, $order ) {
		if ( $order->get_status() === 'partial-payment' && $order->get_meta( 'cd-order-due' ) > 0 ) {
			$due_payment_url = wc_get_endpoint_url( 'order-pay', $order->get_id(), wc_get_checkout_url() );

			$due_payment_url = add_query_arg(
				array(
					'cd_due_payment' => 'true',
					'pay_for_order'  => 'true',
					'key'            => $order->get_order_key(),
				),
				$due_payment_url
			);

			$actions['pay'] = array(
				'url'  => $due_payment_url,
				'name' => __( 'Pay Due', 'codesigner' ),
			);
		}

		return $actions;
	}
}