<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Codexpert\CoDesigner\Helper;

class Product_Stock extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id 		= wcd_get_widget_id( __CLASS__ );
	    $this->widget 	= wcd_get_widget( $this->id );

	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function register_controls() {

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_product_stock_content',
			[
				'label' 		=> __( 'Content', 'codesigner' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'outofstock_text',
			[
				'label'         => esc_html__( 'Outofstock Text', 'codesigner' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Out Of Stock', 'codesigner' ),
			]
        );

		$this->add_control(
			'backorder_text',
			[
				'label'         => esc_html__( 'Backorder Text', 'codesigner' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Expected availability: %%available_date%%', 'codesigner' ),
			]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' 		=> __( 'Alignment', 'codesigner' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'left',
				'separator' 	=> 'before',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-stock .stock' => 'text-align: {{VALUE}};',
                    '.wl {{WRAPPER}} .wl-product-stock' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_product_stock_style',
			[
				'label' => __( 'Style', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_stock_styles',
			[
				'label' 	=> __( 'Display', 'codesigner-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-stock .stock' => 'margin:0;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'codesigner' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-stock .stock' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-product-stock' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'codesigner' ),
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-stock .stock' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-product-stock' => 'color: {{VALUE}}',
				],
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		global $product;
		$settings  = $this->get_settings_for_display();
		if ( ! is_woocommerce_activated() ) return;

		$product = wc_get_product();

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product 	= wc_get_product( $product_id );
		}

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id 	= wcd_get_product_id();
			$product 		= wc_get_product( $product_id );
			$stock_status 	= $product->get_stock_status();
			$stock_qty 		= $product->get_stock_quantity();

			if ( $stock_status == 'instock' && is_null( $stock_qty ) ) {
				?>
				<div class='wl-product-stock'><p class='stock' >100 in stock</p></div>
				<?php
			}
		}

		if ( empty( $product ) ) {
			return;
		}
		$backorder_text 	= $settings['backorder_text'];
		$outofstock_text 	= $settings['outofstock_text'];
		$stock_status 		= $product->get_stock_status();
		if ( $stock_status == 'onbackorder' && $backorder_text ) {
			$available_date = get_post_meta( $product->get_id(), 'cd_backorder_time', true );
			$text =  str_replace(  '%%available_date%%', $available_date, $backorder_text );
		}
		elseif( $stock_status == 'outofstock' && $outofstock_text ){
			$text = $outofstock_text;
		}
		else{
			$text =  wc_get_stock_html( $product );
		}
		?>
		<div class='wl-product-stock'>
		<?php echo wp_kses_post( $text ); ?>
		</div>

		<?php

		do_action( 'codesigner_after_main_content', $this );
	}
}