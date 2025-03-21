<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class Product_Categories extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
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

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'_sectio_cat',
			array(
				'label' => __( 'Content', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'product_cat_type',
			array(
				'label'       => __( 'Content Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'current_product' => __( 'Current Product', 'codesigner' ),
					'custom_product'  => __( 'Custom Product', 'codesigner' ),
					'custom_cat'      => __( 'Custom Text', 'codesigner' ),
				),
				'default'     => 'current_product',
				'label_block' => true,
			)
		);

		$this->add_control(
			'product_id',
			array(
				'label'       => __( 'Product Id', 'codesigner' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 'Product id',
				'condition'   => array(
					'product_cat_type' => 'custom_product',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'cat_label',
			array(
				'label'       => __( 'Label', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Category: ',
				'label_block' => true,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'cat_name',
			array(
				'label'       => __( 'Category Name', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'New Category', 'codesigner' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'cat_link',
			array(
				'label'         => __( 'Link', 'codesigner' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'codesigner' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$this->add_control(
			'cat_list',
			array(
				'label'       => __( 'Category List', 'codesigner' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'cat_name' => __( 'Category #1', 'codesigner' ),
						'cat_link' => array(
							'url'         => 'https://codexpert.io/codesigner',
							'is_external' => false,
							'nofollow'    => false,
						),
					),
					array(
						'cat_name' => __( 'Category #2', 'codesigner' ),
						'cat_link' => array(
							'url'         => 'https://codexpert.io/codesigner',
							'is_external' => false,
							'nofollow'    => false,
						),
					),
				),
				'condition'   => array(
					'product_cat_type' => 'custom_cat',
				),
				'title_field' => '{{{ cat_name }}}',
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => __( 'Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'toggle'    => true,
				'default'   => 'left',
				'separator' => 'before',
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-categories' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product sku label Style
		 */
		$this->start_controls_section(
			'section_style_cat_lable',
			array(
				'label' => __( 'Label', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cat_label_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-categories .cat-label',
			)
		);

		$this->add_control(
			'cat_label_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'default'   => '#000',
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'cat_lable_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-product-categories .cat-label',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_responsive_control(
			'cat_label_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_responsive_control(
			'cat_lable_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cat_lable_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Product categories Style
		 */
		$this->start_controls_section(
			'section_style_cat',
			array(
				'label' => __( 'Categories', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cat_default_style',
			array(
				'label'     => __( 'View', 'codesigner' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-categories .posted_in a' => 'color: #E9345F;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cat_background',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a',
			)
		);

		$this->add_control(
			'cat_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'separator' => 'before',
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'cat_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_responsive_control(
			'cat_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->add_responsive_control(
			'cat_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cat_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'cat_label', 'basic' );
		$this->add_render_attribute( 'cat_label', 'class', 'cat-label' );
		$product_cat_type = $settings['product_cat_type'];

		?>

		<div class="wl-product-categories">

			<?php
			do_action( 'wcd_product_cat_start' );

			if ( function_exists( 'wc_get_product' ) && ( $product_cat_type == 'current_product' || $product_cat_type == 'custom_product' ) ) :
				if ( $product_cat_type == 'current_product' ) {
					$product = wc_get_product( get_the_ID() );
					if ( wcd_is_edit_mode() || wcd_is_preview_mode() ) {
						$product_id = wcd_get_product_id();
						$product    = wc_get_product( $product_id );
					} elseif ( isset( $_POST['product_id'] ) ) {
							$product = wc_get_product( codesigner_sanitize_number( $_POST['product_id'] ) );
					}
				} elseif ( $product_cat_type == 'custom_product' ) {
					$product_id = codesigner_sanitize_number( $settings['product_id'] );
					$product    = $product_id != '' ? wc_get_product( $product_id ) : '';

					if ( $product_id == '' || ! $product ) {
						echo esc_html( 'Input valid Product ID' );
						return;
					}
				}
				?>

				<span class="categories_wrapper">
					<?php
					if ( $product ) {
						echo wp_kses(
							wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<span ' . $this->get_render_attribute_string( 'cat_label' ) . '>' . esc_html( $settings['cat_label'] ) . '</span>', '<span ' . $this->get_render_attribute_string( 'cat_label' ) . '>' . esc_html( $settings['cat_label'] ) . '</span>', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						);
					}
					?>
				</span>

			<?php elseif ( $product_cat_type == 'custom_cat' ) : ?>
				<span class="categories_wrapper">

					<?php
						printf(
							'<span %s>%s</span>',
							wp_kses_post( $this->get_render_attribute_string( 'cat_label' ) ),
							esc_html( $settings['cat_label'] )
						);
					?>

					<span class="cat-items">
						<?php
						$last_item = end( $settings['cat_list'] );
						foreach ( $settings['cat_list'] as $key => $category ) {
							$separator = isset( $category['_id'] ) && $category['_id'] != $last_item['_id'] ? ', ' : '';
							$target    = isset( $category['is_external'] ) && $category['is_external'] ? ' target="_blank"' : '';
							$nofollow  = isset( $category['nofollow'] ) && $category['nofollow'] ? ' rel="nofollow"' : '';
							?>
							<a href="<?php echo esc_url( $category['cat_link']['url'] ); ?>" <?php echo esc_attr( $target ); ?> <?php echo esc_attr( $nofollow ); ?> class="cat-item"><?php echo esc_html( $category['cat_name'] ); ?> <?php echo esc_html( $separator ); ?></a>
							<?php
						}
						?>
					</span>
				</span>

				<?php
			endif;

			do_action( 'wcd_product_cat_end', $this );
			?>

		</div>

		<?php
	}
}

