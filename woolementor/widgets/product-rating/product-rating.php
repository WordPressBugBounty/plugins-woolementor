<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Product_Rating extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_style_depends() {
		return array();
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

		$this->start_controls_section(
			'section_product_rating_style',
			array(
				'label' => __( 'Style', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_default_styles',
			array(
				'label'     => __( 'Display', 'codesigner-pro' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating' => 'display:flex;margin: 0;',
					'.wl {{WRAPPER}} .wcd-product-rating .woocommerce-product-rating' => 'margin: 0;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => __( 'Star Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wcd-product-rating .wcd-demo-product-rating dashicons.dashicons-star-filled::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'empty_star_color',
			array(
				'label'     => __( 'Empty Star Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating::before' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wcd-product-rating .wcd-demo-product-rating dashicons.dashicons-star-empty::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => __( 'Link Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating a.woocommerce-review-link' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'text_typography',
				'selector'       => '.wl {{WRAPPER}} .wcd-product-rating .woocommerce-review-link',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_size'   => array( 'default' => array( 'size' => 16 ) ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 500 ),
				),
			)
		);

		$this->add_control(
			'star_size',
			array(
				'label'     => __( 'Star Size', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => 'em',
				),
				'range'     => array(
					'em' => array(
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'space_between',
			array(
				'label'      => __( 'Space Between', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'em',
				),
				'range'      => array(
					'em' => array(
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					),
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'.wl:not(.rtl) {{WRAPPER}} .wcd-product-rating .star-rating' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.wl.rtl {{WRAPPER}} .wcd-product-rating .star-rating' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'     => __( 'Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'  => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'end'    => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'start',
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd-product-rating' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! is_woocommerce_activated() || ! post_type_supports( 'product', 'comments' ) ) {
			return;
		}

		$product_id = get_the_ID();
		$product    = wc_get_product( $product_id );

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product    = wc_get_product( $product_id );
		}

		echo wp_kses_post( "<div class='wcd-product-rating' >" );

		if ( empty( $product ) ) {
			return;
		}

		if ( ( wcd_is_edit_mode() || wcd_is_preview_mode() ) && $product->get_rating_count() < 1 ) {
			$review_count = 5;
			?>
			<div class="wcd-demo-product-rating">
				<?php echo wp_kses( wcd_rating_html( 4 ), array( 'span' => array( 'class' => array() ) ) ); ?>
				<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
					(<?php printf( esc_html( _n( '%s customer review', '%s customer reviews', $review_count, 'codesigner' ) ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)
				</a>
			</div>
			<?php
		}
		wc_get_template( 'single-product/rating.php' );

		echo wp_kses_post( '</div>' );

		do_action( 'codesigner_after_main_content', $this );
	}
}

