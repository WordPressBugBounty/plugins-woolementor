<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Backorder extends Base {

	public $id = 'codesigner_backorder';

	public $slug;
	
	public $version;
    
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->plugin	= get_plugin_data( CODESIGNER );
		$this->slug		= $this->plugin['TextDomain'];
		$this->version	= $this->plugin['Version'];

        $this->action( 'woocommerce_product_options_stock_status', 'fields' );
        $this->filter( 'woocommerce_product_stock_status_use_radio', 'use_radio', 10, 2 );
        $this->action( 'woocommerce_process_product_meta', 'save_fields' );
        $this->filter( 'woocommerce_get_availability_text', 'get_availability_text', 10, 2 );
        $this->action( 'codesigner_after_shop_content_controls', 'widget_content_section' );
        $this->action( 'codesigner_after_shop_style_controls', 'widget_style_section' );
        $this->action( 'codesigner_shop_before_flash_sale', 'widget_render', 10, 2 );
        $this->action( 'admin_enqueue_scripts', 'admin_enqueue_script' );
        $this->action( 'wp_enqueue_scripts', 'front_enqueue_style' );
	}

	public function __settings ( $settings ) {
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'BackOrder', 'codesigner' ),
            'icon'      => 'dashicons-controls-back',
            'sticky'	=> false,
            'fields'	=> [
                [
                    'id'        => 'backorder-deafult-woocommerce',
                    'label'     => __( 'Change Deafult BackOrder text', 'codesigner' ),
                    'type'      => 'switch',
                    'desc'      => __( 'Select if you want to change deafult backorder text.', 'codesigner' )
                ],
                [
                    'id'      	=> 'backorder-text',
                    'label'     => __( 'BackOrder text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Expected availability: %%available_date%%',
                    'desc'   	=> __( 'Input your desired custom backorder text', 'codesigner' )
                ]
            ]
        ];

        return $settings;
    }

    public function use_radio( $true ) {
        return false;
    }

	public function fields() {

        echo '<div class="show_if_simple show_if_variable">';
            woocommerce_wp_text_input( array(
                'id'    => 'cd_backorder_time',
                'label' => 'BackOrder Available Date',
                'type'  => 'date',
            ) );
        echo "</div>";
    }

    public function save_fields( $post_id ) {
        if ( isset( $_POST['cd_backorder_time'] ) ) {
            $cd_backorder_time = sanitize_text_field( $_POST['cd_backorder_time'] );
            update_post_meta( $post_id, 'cd_backorder_time', $cd_backorder_time );
        }
    }

    public function get_availability_text( $availability, $product ) {
        $backorder_status 	    = Helper::get_option( 'codesigner_backorder','backorder-deafult-woocommerce' );
        $backorder_text         = Helper::get_option( 'codesigner_backorder','backorder-text', 'Available on backorder' );
        if ( $product->get_stock_status() == 'outofstock' && $product->get_meta( 'cd_backorder_time' ) && $backorder_status == 'on' && $backorder_text ) {
            $available_date = $product->get_meta( 'cd_backorder_time' );
			return str_replace( '%%available_date%%', $available_date, $backorder_text );
    
        }
        return $availability;
    }

    public function widget_content_section( $widget_class ) {

        if ( $widget_class->get_name() == 'shop-table' ) return;
        
        $widget_class->start_controls_section(
            'section_content_backorder',
            [
                'label' => __( 'Backorder', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget_class->add_control(
            'backorder_show_hide',
            [
                'label'         => __( 'Show/Hide', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'codesigner' ),
                'label_off'     => __( 'Hide', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $widget_class->add_control(
            'backorder_text',
            [
                'label'         => __( 'Text', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
				'default'       => Helper::get_option( 'codesigner_backorder', 'backorder-default-text'),
                'condition'     => [
                    'backorder_show_hide' => 'yes'
                ],
            ]
        );

        $widget_class->end_controls_section();
    }

	public function widget_style_section( $widget_class ) {
        
		$widget_class->start_controls_section(
            'section_style_backorder_ribbon',
            [
                'label' => __( 'Backorder Ribbon', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'backorder_show_hide' => 'yes'
                ],
            ]
        );

        $widget_class->add_control(
            'backorder_offset_toggle',
            [
                'label'         => __( 'Offset', 'codesigner' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'codesigner' ),
                'label_on'      => __( 'Custom', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $widget_class->start_popover();

        $widget_class->add_responsive_control(
            'backorder_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'backorder_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'right: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'render_type'   => 'ui',
            ]
        );

        $widget_class->add_responsive_control(
            'backorder_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'codesigner' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'backorder_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'default' =>[
                    'unit' => 'px',
                    'size' => 310
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $widget_class->end_popover();

        $widget_class->add_responsive_control(
            'backorder_ribbon_width',
            [
                'label'     => __( 'Width', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
                'default' =>[
                    'unit' => '%',
                    'size' => 94
                ],
            ]
        );

        $widget_class->add_responsive_control(
            'backorder_ribbon_transform',
            [
                'label'     => __( 'Transform', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
            'backorder_ribbon_font_color',
            [
                'label'     => __( 'Color', 'codesigner' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'color: {{VALUE}}',
                ],
                'default'   => '#FCFCFC',
                'separator' => 'before'
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'backorder_content_typography',
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'  => '.wl {{WRAPPER}} .wl-product-backorder',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 15 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 600 ],
                ],
            ]
        );

        $widget_class->add_control(
            'backorder_ribbon_background',
            [
                'label'         => __( 'Background', 'codesigner' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'background: {{VALUE}}',
                ],
                'default'       => '#15242F'
            ]
        );

        $widget_class->add_responsive_control(
            'backorder_ribbon_padding',
            [
                'label'         => __( 'Padding', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'isLinked' => false
                ],
                'separator' => 'after'
            ]
        );

        $widget_class->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'backorder_ribbon_border',
                'label'         => __( 'Border', 'codesigner' ),
                'selector'      => '.wl {{WRAPPER}} .wl-product-backorder',
            ]
        );

        $widget_class->add_responsive_control(
            'backorder_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'codesigner' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-product-backorder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ], 
            ]
        );

        $widget_class->end_controls_section();
	}

	public function widget_render( $settings, $product ) {
		$backorder_text 	= $settings['backorder_text'];
		$stock_status 		= $product->get_stock_status();

		if ( $stock_status == 'onbackorder' && $backorder_text ) {
			$available_date = get_post_meta( $product->get_id(), 'cd_backorder_time', true );
			$text 			= str_replace( '%%available_date%%', $available_date, $backorder_text );
			echo "<div class='wl-product-backorder'>";
				esc_html( $text );
			echo "</div>";
		}
	}

    public function admin_enqueue_script() {
        wp_enqueue_script( 'cd-backorder-modules', plugins_url( 'js/admin.js', __FILE__), array( 'jquery' ), $this->version, true );
    }

    public function front_enqueue_style() {
        wp_enqueue_style( 'cd-backorder-css', plugins_url( 'css/front.css', __FILE__), [], $this->version, 'all' );
    }
}