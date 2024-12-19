<?php
namespace Codexpert\CoDesigner\Modules;
use Elementor\Utils;
use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Badges extends Base {

    public $id = 'codesigner_badges';

    public $slug;
    
    public $version;
    /**
     * Constructor
     */
    public function __construct() {

        $this->action( 'init', 'init_plugin' );
        $this->action( 'codesigner_after_shop_content_controls', 'widget_content_section' );
        $this->action( 'codesigner_after_shop_style_controls', 'widget_style_section' );
        $this->action( 'codesigner_shop_before_flash_sale', 'widget_render', 10, 2 );
        $this->action( 'wp_enqueue_scripts', 'badges_enqueue_script' );
        $this->action( 'woocommerce_product_options_general_product_data', 'badge_simple_product_content' );
        $this->action( 'save_post', 'badge_save_data' );
    }

    /**
     * Form WP version 6.7.0 Need to loade some 
     * Data like TextDomain and other in init hook 
     */

    public function init_plugin(){
        $this->plugin   = get_plugin_data( CODESIGNER );
        $this->slug     = $this->plugin['TextDomain'];
        $this->version  = $this->plugin['Version'];
    }

    public function __settings ( $settings ) {
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'Badges', 'codesigner' ),
            'icon'      => 'dashicons-tag',
            'sticky'    => false,
            'fields'    => [
                [
                    'id'        => 'badges-default-text',
                    'label'     => __( 'Badges Default text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Premium',
                    'desc'      => __( 'Select if you want to set the default Badges text for shop widgets.', 'codesigner' )
                ]
            ]
        ];

        return $settings;
    }

    public function badge_simple_product_content() {

        global $post;
        $product_id         = get_the_ID();
        $regular_price      = get_post_meta( $product_id, '_regular_price', true );
        $sale_price         = get_post_meta( $product_id, '_sale_price', true );
        $section_badge_text = get_post_meta($post->ID, 'section_badge_text', true);

        woocommerce_wp_checkbox( array(
            'id'          => 'section_badge_text',
            'label'       => __('Badge for this product', 'codesigner'),
            'value'       => $section_badge_text,
            'desc_tip'    => true,
            'description' => __('Enable this badge for the product', 'codesigner'),
        ));
    }

    public function badge_save_data($post_id) {
        if ( isset( $_POST['section_badge_text'] ) ) {
            $section_badge_text = sanitize_text_field( $_POST['section_badge_text'] );
            update_post_meta( $post_id, 'section_badge_text', $section_badge_text );
        }
    }

    public function widget_content_section( $widget_class ) {

        if ( $widget_class->get_name() == 'shop-table' ) return;

        $widget_class->start_controls_section(
            'section_content_badge',
            [
                'label' => __( 'Badge', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget_class->add_control(
            'badge_show_hide',
            [
                'label'        => __( 'Show/Hide', 'codesigner' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'codesigner' ),
                'label_off'    => __( 'Hide', 'codesigner' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $widget_class->add_control(
            'badge_selection',
            [
                'label'     => __( 'Badge Select', 'codesigner' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'badge_text',
                'options'   => [
                    'badge_img'   => __( 'Badge Image', 'codesigner' ),
                    'badge_text'  => __( 'Badge Text', 'codesigner' ),
                    'badge_icon'  => __( 'Badge Icon', 'codesigner' ),
                ],
                'condition' => [
                    'badge_show_hide' => 'yes',
                ],
            ]
        );


        $widget_class->add_control(
            'badge_text',
            [
                'label'       => __( 'Badge Text', 'codesigner' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => Helper::get_option( 'codesigner_badges', 'badges-default-text', 'Premium' ),
                'placeholder' => __( 'Custom Text', 'codesigner' ),
                'condition'   => [
                    'badge_selection' => 'badge_text', 
                    'badge_show_hide' => 'yes',
                ],
            ]
        );

		$widget_class->add_control(
			'badge_image',
			[
				'label'       => __( 'Image Control', 'codesigner' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => __( 'Select an image for batch.', 'codesigner' ),
				'condition'   => [
					'badge_selection' => 'badge_img',
					'badge_show_hide' => 'yes',
				],
			]
		);

        $widget_class->add_control(
            'badge_icons',
            [
                'label'       => __( 'Icon Control', 'codesigner' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'description' => __( 'Select an icon for badge.', 'codesigner' ),
                'condition'   => [
                    'badge_selection' => 'badge_icon',
                    'badge_show_hide' => 'yes',
                ],
            ]
        );

        $widget_class->end_controls_section();

    }

    public function widget_style_section( $widget_class ) {

        $widget_class->start_controls_section(
            'section_style_badge_text',
            [
                'label' => __( 'Badge', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'badge_selection' => 'badge_text', 
                    'badge_show_hide' => 'yes',
                ],
            ]
        );

        $widget_class->add_control(
            'badge_text_default_styles',
            [
                'label'     => __( 'Display', 'codesigner' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge' => 'position: absolute; border-radius: 3px;letter-spacing: 1px;z-index: 999;right: 30px;',
                ],
                'default' => 'traditional',
            ]
        );

        $widget_class->add_control(
            'badge_text_offset_toggle',
            [
                'label'         => __( 'Offset', 'codesigner' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'codesigner' ),
                'label_on'      => __( 'Custom', 'codesigner' ),
                'return_value'  => 'yes',
                'default'  => 'yes',
            ]
        );

        $widget_class->start_popover();

        $widget_class->add_responsive_control(
            'badge_text_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_text_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge' => 'left: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-badge' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_text_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_text_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
            ]
        );
        $widget_class->end_popover();

        $widget_class->add_responsive_control(
            'badge_text_width',
            [
                'label'     => __( 'Width', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge p' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_text_height',
            [
                'label'     => __( 'Height', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge p' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_text_transform',
            [
                'label'     => __( 'Transform', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $widget_class->add_control(
            'badge_text_font_color',
            [
                'label'     => __( 'Color', 'codesigner' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
                'default'   => '#FCFCFC',
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'badge_text_content_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'  => '.wl {{WRAPPER}} .wl-badge',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'line_height'   => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                ],
            ]
        );

        $widget_class->add_control(
            'badge_text_background',
            [
                'label'         => __( 'Background', 'codesigner' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge' => 'background: {{VALUE}}',
                ],
                'default'       => '#000000',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_text_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'top'           => '0',
                    'right'         => '14',
                    'bottom'        => '0',
                    'left'          => '14',
                ],
                'separator' => 'after',
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_text_border',
                'label'         => __( 'Border', 'codesigner' ),
                'selector'      => '.wl {{WRAPPER}} .wl-badge',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_text_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget_class->end_controls_section();

        /**
         * Badge Image Styling
         */
        $widget_class->start_controls_section(
            'section_style_badge_image',
            [
                'label' => __( 'Badge', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'badge_selection' => 'badge_img', 
                    'badge_show_hide' => 'yes',
                ],
            ]
        );

        $widget_class->add_control(
            'badge_img_default_styles',
            [
                'label'     => __( 'Display', 'codesigner' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'position: absolute;z-index: 999;top: 30px;right: 36px;',
                ],
                'default' => 'traditional',
            ]
        );

        $widget_class->add_control(
            'badge_img_offset_toggle',
            [
                'label'         => __( 'Offset', 'codesigner' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'codesigner' ),
                'label_on'      => __( 'Custom', 'codesigner' ),
                'return_value'  => 'yes',
                'default'  => 'yes',
            ]
        );

        $widget_class->start_popover();

        $widget_class->add_responsive_control(
            'badge_img_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_img_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'left: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-badge img' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_img_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_img_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );

        $widget_class->end_popover();

        $widget_class->add_responsive_control(
            'badge_img_width',
            [
                'label'     => __( 'Width', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
                'default'    => [
                    'size' => 100,
                    'unit' => 'px',
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_img_transform',
            [
                'label'     => __( 'Transform', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge img' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_img_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'top'           => '0',
                    'right'         => '14',
                    'bottom'        => '0',
                    'left'          => '14',
                ],
                'separator' => 'after',
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_img_border',
                'label'         => __( 'Border', 'codesigner' ),
                'selector'      => '.wl {{WRAPPER}} .wl-badge img',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_img_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget_class->end_controls_section();

        /**
        * Badge Icon Styling
        **/

        $widget_class->start_controls_section(
            'section_style_badge_icon',
            [
                'label' => __( 'Badge', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'badge_selection' => 'badge_icon', 
                    'badge_show_hide' => 'yes',
                ],
            ]
        );

        $widget_class->add_control(
            'badge_icon_default_styles',
            [
                'label'     => __( 'Display', 'codesigner' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'position: absolute;z-index: 999;right:20px',
                ],
                'default' => 'traditional',
            ]
        );

        $widget_class->add_control(
            'badge_icon_offset_toggle',
            [
                'label'         => __( 'Offset', 'codesigner' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'codesigner' ),
                'label_on'      => __( 'Custom', 'codesigner' ),
                'return_value'  => 'yes',
                'default'  => 'yes',
            ]
        );

        $widget_class->start_popover();

        $widget_class->add_responsive_control(
            'badge_icon_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_icon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'left: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_icon_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_icon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );
        $widget_class->end_popover();

        $widget_class->add_responsive_control(
            'badge_icon_width',
            [
                'label'     => __( 'Width', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 20,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'badge_icon_transform',
            [
                'label'     => __( 'Transform', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $widget_class->add_control(
            'badge_icon_font_color',
            [
                'label'     => __( 'Color', 'codesigner' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
                'default'   => '#dd3c0a',
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'badge_icon_content_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'  => '.wl {{WRAPPER}} .wl-badge',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'line_height'   => [ 'default' => [ 'size' => 20 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                ],
            ]
        );

        $widget_class->add_control(
            'badge_icon_background',
            [
                'label'         => __( 'Background', 'codesigner' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'background: {{VALUE}}',
                ],
                'default'       => '',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_icon_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'top'           => '0',
                    'right'         => '14',
                    'bottom'        => '0',
                    'left'          => '14',
                ],
                'separator' => 'after',
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_icon_border',
                'label'         => __( 'Border', 'codesigner' ),
                'selector'      => '.wl {{WRAPPER}} .wl-badge .icons',
            ]
        );

        $widget_class->add_responsive_control(
            'badge_icon _border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-badge .icons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget_class->end_controls_section();
    }
    
    public function widget_render( $settings, $product ) {
        if ( class_exists( 'WooCommerce' ) ) {
            global $woocommerce;
            $woocommerce->init();

            if ( 'yes' == $settings[ 'badge_show_hide' ] ) {
                $product_id         = $product->get_id();
                $product            = wc_get_product( $product_id );
                $regular_price      = $product->get_regular_price();
                $sale_price         = $product->get_sale_price();
                $section_badge_text = get_post_meta( $product_id, 'section_badge_text', true );

                if ( $section_badge_text ) {
                    $badge_content = '';

                    if ( $settings[ 'badge_selection' ] === 'badge_text' ) {
                        $badge_text         = $settings[ 'badge_text' ];
                        $placeholder_text   = $settings[ 'badge_text' ];
                        $badge_content      = '<div class="wl-badge wl-badge-circle"><p>' . esc_attr( $badge_text ) . '</p></div>';

                    } elseif ( $settings[ 'badge_selection' ] === 'badge_img' ) {
                        $badge_image_url    = esc_url( $settings[ 'badge_image' ][ 'url' ] );
                        $badge_content      = '<div class="wl-badge"><img src="' . esc_attr( $badge_image_url ) . '" alt="'. esc_attr__( 'Badge Image', 'codesigner' ) .'"></div>';

                    } elseif ( $settings[ 'badge_selection' ] === 'badge_icon' ) {
                        $badge_icon         = $settings[ 'badge_icons' ][ 'value' ];
                        $badge_content      = '<div class="wl-badge"><i class="icons ' . esc_attr( $badge_icon ) . '"></i></div>';
                    }

                    echo wp_kses_post( $badge_content );
                }
            }
        }
    }

    public function badges_enqueue_script(){
        wp_enqueue_style( "product-badges-css", plugins_url( "css/badges.css", __FILE__ ), [], $this->version, 'all' );
    }

}