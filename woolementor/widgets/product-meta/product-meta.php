<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Typography;

class Product_Meta extends Widget_Base {

	public $id;
	public $widget;

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

		$this->start_controls_section(
			'section_product_meta_style',
			array(
				'label' => __( 'Style', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'view',
			array(
				'label'        => __( 'View', 'codesigner' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inline',
				'options'      => array(
					'table'   => __( 'Table', 'codesigner' ),
					'stacked' => __( 'Stacked', 'codesigner' ),
					'inline'  => __( 'Inline', 'codesigner' ),
				),
				'prefix_class' => 'elementor-woo-meta--view-',
			)
		);

		$this->add_responsive_control(
			'space_between',
			array(
				'label'     => __( 'Space Between', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'right: calc( (-{{SIZE}}{{UNIT}}/2) + (-{{divider_weight.SIZE}}px/2) )',
					'body:not.rtl {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'left: calc( (-{{SIZE}}{{UNIT}}/2) - ({{divider_weight.SIZE}}px/2) )',
				),
			)
		);

		$this->add_control(
			'divider',
			array(
				'label'        => __( 'Divider', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'codesigner' ),
				'label_on'     => __( 'On', 'codesigner' ),
				'selectors'    => array(
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'content: ""',
				),
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'divider_style',
			array(
				'label'     => __( 'Style', 'codesigner' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'codesigner' ),
					'double' => __( 'Double', 'codesigner' ),
					'dotted' => __( 'Dotted', 'codesigner' ),
					'dashed' => __( 'Dashed', 'codesigner' ),
				),
				'default'   => 'solid',
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'divider_weight',
			array(
				'label'     => __( 'Weight', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}; margin-bottom: calc(-{{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'divider_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => '%',
				),
				'condition'  => array(
					'divider' => 'yes',
					'view!'   => 'inline',
				),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_height',
			array(
				'label'      => __( 'Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'  => array(
					'divider' => 'yes',
					'view'    => 'inline',
				),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_text_style',
			array(
				'label'     => __( 'Text', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'text_typography',
				'selector'       => '.wl {{WRAPPER}}',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}}' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_link_style',
			array(
				'label'     => __( 'Link', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'link_typography',
				'selector'       => '.wl {{WRAPPER}} a',
				'fields_options' => array(
					'typography'  => array( 'default' => 'yes' ),
					'font_family' => array( 'default' => 'Montserrat' ),
					'font_weight' => array( 'default' => 400 ),
				),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_meta_captions',
			array(
				'label' => __( 'Captions', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_category_caption',
			array(
				'label' => __( 'Category', 'codesigner' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'category_caption_single',
			array(
				'label'       => __( 'Singular', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Category', 'codesigner' ),
			)
		);

		$this->add_control(
			'category_caption_plural',
			array(
				'label'       => __( 'Plural', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Categories', 'codesigner' ),
			)
		);

		$this->add_control(
			'heading_tag_caption',
			array(
				'label'     => __( 'Tag', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'tag_caption_single',
			array(
				'label'       => __( 'Singular', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Tag', 'codesigner' ),
			)
		);

		$this->add_control(
			'tag_caption_plural',
			array(
				'label'       => __( 'Plural', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Tags', 'codesigner' ),
			)
		);

		$this->add_control(
			'heading_sku_caption',
			array(
				'label'     => __( 'SKU', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sku_caption',
			array(
				'label'       => __( 'SKU', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'SKU', 'codesigner' ),
			)
		);

		$this->add_control(
			'sku_missing_caption',
			array(
				'label'       => __( 'Missing', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'N/A', 'codesigner' ),
			)
		);

		$this->end_controls_section();
	}

	private function get_plural_or_single( $single, $plural, $count ) {
		return 1 === $count ? $single : $plural;
	}

	protected function render() {
		global $product;

		if ( ! is_woocommerce_activated() ) {
			return;
		}

		$product = wc_get_product();

		if ( isset( $_POST['product_id'] ) ) {
			$product_id = codesigner_sanitize_number( $_POST['product_id'] );
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id = wcd_get_product_id();
			$product    = wc_get_product( $product_id );
		}

		if ( empty( $product ) ) {
			return;
		}

		$sku = $product->get_sku();

		$settings                = $this->get_settings_for_display();
		$sku_caption             = ! empty( $settings['sku_caption'] ) ? sanitize_text_field( $settings['sku_caption'] ) : __( 'SKU', 'codesigner' );
		$sku_missing             = ! empty( $settings['sku_missing_caption'] ) ? sanitize_text_field( $settings['sku_missing_caption'] ) : __( 'N/A', 'codesigner' );
		$category_caption_single = ! empty( $settings['category_caption_single'] ) ? sanitize_text_field( $settings['category_caption_single'] ) : __( 'Category', 'codesigner' );
		$category_caption_plural = ! empty( $settings['category_caption_plural'] ) ? sanitize_text_field( $settings['category_caption_plural'] ) : __( 'Categories', 'codesigner' );
		$tag_caption_single      = ! empty( $settings['tag_caption_single'] ) ? sanitize_text_field( $settings['tag_caption_single'] ) : __( 'Tag', 'codesigner' );
		$tag_caption_plural      = ! empty( $settings['tag_caption_plural'] ) ? sanitize_text_field( $settings['tag_caption_plural'] ) : __( 'Tags', 'codesigner' );
		?>
		<div class="wcd_product_meta">

			<?php do_action( 'woocommerce_product_meta_start' ); ?>

			<?php if ( wc_product_sku_enabled() && ( $sku || $product->is_type( 'variable' ) ) ) : ?>
				<span class="sku_wrapper detail-container"><span class="detail-label"><?php echo esc_html( $sku_caption ); ?></span> <span class="sku"><?php echo esc_html( $sku ? $sku : $sku_missing ); ?></span></span>
			<?php endif; ?>

			<?php if ( count( $product->get_category_ids() ) ) : ?>
				<span class="posted_in detail-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $category_caption_single, $category_caption_plural, count( $product->get_category_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_cat', '', ', ' ); ?></span></span>
			<?php endif; ?>

			<?php if ( count( $product->get_tag_ids() ) ) : ?>
				<span class="tagged_as detail-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $tag_caption_single, $tag_caption_plural, count( $product->get_tag_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_tag', '', ', ' ); ?></span></span>
			<?php endif; ?>

			<?php do_action( 'woocommerce_product_meta_end', $this ); ?>

		</div>
		<?php
	}
}

