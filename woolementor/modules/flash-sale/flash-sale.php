<?php
namespace Codexpert\CoDesigner\Modules;
use Codexpert\CoDesigner\Helper;
use Codexpert\Plugin\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Flash_Sale extends Base {

	public $id = 'codesigner_flash_sale';

	public $slug;
	
	public $version;
    
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->plugin	= get_plugin_data( CODESIGNER );
		$this->slug		= $this->plugin['TextDomain'];
		$this->version	= $this->plugin['Version'];

        $this->action( 'codesigner_after_shop_content_controls', 'widget_content_section' );
        $this->action( 'codesigner_after_shop_style_controls', 'widget_style_section' );
        $this->action( 'codesigner_shop_before_flash_sale', 'widget_render', 10, 2 );
        $this->action( 'wp_enqueue_scripts', 'front_enqueue_style' );
	}

	public function __settings ( $settings ) {
        $settings['sections'][ $this->id ] = [
            'id'        => $this->id,
            'label'     => __( 'Flash Sale', 'codesigner' ),
            'icon'      => 'dashicons-schedule',
            'sticky'	=> false,
            'fields'	=> [
                [
                    'id'      	=> 'flashsale-day-text',
                    'label'     => __( 'Day Label Default text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Day',
                    'desc'   	=> __( 'Select if you want to set the default flashsale day text for shop widgets.', 'codesigner' )
                ],
                [
                    'id'      	=> 'flashsale-hour-text',
                    'label'     => __( 'Hour Label Default text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Hour',
                    'desc'   	=> __( 'Select if you want to set the default flashsale hour text for shop widgets.', 'codesigner' )
                ],
                [
                    'id'      	=> 'flashsale-minute-text',
                    'label'     => __( 'Minute Label Default text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Minute',
                    'desc'   	=> __( 'Select if you want to set the default flashsale minute text for shop widgets.', 'codesigner' )
                ],
                [
                    'id'      	=> 'flashsale-second-text',
                    'label'     => __( 'Second Label Default text', 'codesigner' ),
                    'type'      => 'text',
                    'default'   => 'Seconds',
                    'desc'   	=> __( 'Select if you want to set the default flashsale second text for shop widgets.', 'codesigner' )
                ],
            ]
        ];

        return $settings;
    }

    public function widget_content_section( $widget_class ) {

        if ( $widget_class->get_name() == 'shop-table' ) return;
        
        $widget_class->start_controls_section(
            'section_content_flash_sale',
            [
                'label' => __( 'Flash Sale', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget_class->add_control(
            'flash_sale_show_hide',
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
            'flash_sale_override_product_date',
            [
                'label'         => __( 'Override product sale price dates?', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'codesigner' ),
                'label_off'     => __( 'No', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'no',
                'condition' =>[
                    'flash_sale_show_hide' => 'yes'
                ]
            ]
        );

        $widget_class->add_control(
            'flash_sale_override_start_date',
            [
                'label' => esc_html__( 'Start Date', 'codesigner' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' =>[
                    'flash_sale_override_product_date' => 'yes'
                ]
            ]
        );

        $widget_class->add_control(
            'flash_sale_override_end_date',
            [
                'label' => esc_html__( 'End Date', 'codesigner' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' =>[
                    'flash_sale_override_product_date' => 'yes'
                ]
            ]
        );

        $widget_class->add_control(
            'flash_sale_when_expired',
            [
                'label'     => __( 'When Expired', 'codesigner' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'hide'  => __( 'Hide', 'codesigner' ),
                    'zero'  => __( '0', 'codesigner' ),
                ],
                'default'   => 'hide',
                'condition' => [
                    'flash_sale_show_hide' => 'yes'
                ],
            ]
        );

        $widget_class->add_control(
            'flash_sale_change_label',
            [
                'label'         => __( 'Change Label', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'codesigner' ),
                'label_off'     => __( 'No', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'no',
                'condition' =>[
                    'flash_sale_show_hide' => 'yes'
                ]
            ]
        );

        $widget_class->add_control(
            'flash_sale_change_label_days',
            [
                'label'         => __( 'Days', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
				'default'       => Helper::get_option( 'codesigner_flash_sale', 'flashsale-day-text'),
                'condition'     => [
                    'flash_sale_change_label' => 'yes'
                ],
            ]
        );

        $widget_class->add_control(
            'flash_sale_change_label_hours',
            [
                'label'         => __( 'Hours', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => Helper::get_option( 'codesigner_flash_sale', 'flashsale-hour-text'),
                'condition'     => [
                    'flash_sale_change_label' => 'yes'
                ],
            ]
        );

        $widget_class->add_control(
            'flash_sale_change_label_minute',
            [
                'label'         => __( 'Minute', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => Helper::get_option( 'codesigner_flash_sale', 'flashsale-minute-text'),
                'condition'     => [
                    'flash_sale_change_label' => 'yes'
                ],
            ]
        );

        $widget_class->add_control(
            'flash_sale_change_label_seconds',
            [
                'label'         => __( 'Seconds', 'codesigner' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => Helper::get_option( 'codesigner_flash_sale', 'flashsale-second-text'),
                'condition'     => [
                    'flash_sale_change_label' => 'yes'
                ],
            ]
        );

        $widget_class->end_controls_section();
    }

    public function widget_style_section( $widget_class ) {

        $widget_class->start_controls_section(
            'section_style_flash_sale',
            [
                'label' => __( 'Flash Sale', 'codesigner' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'flash_sale_show_hide' => 'yes'
                ]
            ]
        );

		$widget_class->add_control(
            'flash_sale_offset_toggle',
            [
                'label' 		=> __( 'Offset', 'codesigner' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'codesigner' ),
                'label_on' 		=> __( 'Custom', 'codesigner' ),
                'return_value' 	=> 'yes',
                'default'  => 'yes',
            ]
        );

        $widget_class->start_popover();

        $widget_class->add_responsive_control(
            'flash_sale_media_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'codesigner' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'flash_sale_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $widget_class->add_responsive_control(
            'flash_sale_media_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'codesigner' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'flash_sale_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $widget_class->end_popover();

        $widget_class->add_responsive_control(
            'flash_sale_width',
            [
                'label'     => __( 'Width', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => 'width: {{SIZE}}{{UNIT}}',
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
            'flash_sale_transform',
            [
                'label'     => __( 'Transform', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
            'flash_sale_gap',
            [
                'label'     => __( 'Gap', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => 'gap: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 5,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $widget_class->add_control(
			'section_styles',
			[
				'label' => esc_html__( 'Section styles', 'codesigner' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

		$widget_class->add_control(
			'flash_sale_background',
			[
				'label' 		=> __( 'Background', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-flash-sale-timer' => 'background: {{VALUE}}',
				],
                'default'       => '#000000'
			]
		);

		$widget_class->add_responsive_control(
			'flash_sale_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-flash-sale-timer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '10',
                    'right'         => '10',
                    'bottom'        => '10',
                    'left'          => '10',
                ],
			]
		);

        $widget_class->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'flash_sale_border',
				'label' 		=> __( 'Border', 'codesigner' ),
				'selector' 		=> '.wl {{WRAPPER}} .wl-flash-sale-timer',
			]
		);

		$widget_class->add_responsive_control(
            'flash_sale_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'codesigner' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget_class->add_control(
			'boxs_styles',
			[
				'label' => esc_html__( 'Box styles', 'codesigner' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

        $widget_class->add_control(
            'flash_sale_box_font_color',
            [
                'label'     => __( 'Color', 'codesigner' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer .time' => 'color: {{VALUE}}',
                ],
                'default'       => '#15242F'
            ]
        );

        $widget_class->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'flash_sale_box_content_typography',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-flash-sale-timer',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
			]
		);

		$widget_class->add_control(
			'flash_sale_box_background',
			[
				'label' 		=> __( 'Background', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-flash-sale-timer .time' => 'background: {{VALUE}}',
				],
                'default'       => '#ffffff'
			]
		);

		$widget_class->add_responsive_control(
			'flash_sale_box_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-flash-sale-timer .time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $widget_class->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'flash_sale_box_border',
				'label' 		=> __( 'Border', 'codesigner' ),
				'selector' 		=> '.wl {{WRAPPER}} .wl-flash-sale-timer .time',
			]
		);

		$widget_class->add_responsive_control(
            'flash_sale_box_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'codesigner' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-flash-sale-timer .time' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget_class->end_controls_section();
    }
    
    public function widget_render( $settings, $product ) {

        $sales_price_date_to    = '';
        $sales_price_date_from  = '';

        if ( 'yes' == $settings['flash_sale_show_hide'] ) {
            if ( 'yes' == $settings['flash_sale_override_product_date'] ) {
                $sales_price_date_to    = $settings['flash_sale_override_start_date'];
                $sales_price_date_from  = $settings['flash_sale_override_end_date'];
            }
            else {
                $sales_price_from   = $product->get_date_on_sale_from();
                $sales_price_to     = $product->get_date_on_sale_to();

                if( ! empty( $sales_price_from ) || ! empty( $sales_price_to ) ) {
                    $sales_price_date_to   = $sales_price_from->date( "Y-m-d H:i:s" );
                    $sales_price_date_from = $sales_price_to->date( "Y-m-d H:i:s" );
                }
            }
        }

        $flash_sale_label_days          = __( 'Days', 'codesigner' );
        $flash_sale_label_hours         = __( 'Hours', 'codesigner' );
        $flash_sale_label_minute        = __( 'Minute', 'codesigner' );
        $flash_sale_label_seconds       = __( 'Seconds', 'codesigner' );
        if ( 'yes' == $settings['flash_sale_change_label'] ) {
            $flash_sale_label_days      = $settings['flash_sale_change_label_days'];
            $flash_sale_label_hours     = $settings['flash_sale_change_label_hours'];
            $flash_sale_label_minute    = $settings['flash_sale_change_label_minute'];
            $flash_sale_label_seconds   = $settings['flash_sale_change_label_seconds'];
        }
        if ( strtotime( $sales_price_date_to ) < time() && ( ! empty( $sales_price_date_to ) || ! empty( $sales_price_date_from ) ) ): ?>

            <div class="wl-flash-sale-timer">
                <div class="time days"></div>
                <div class="time hours"></div>
                <div class="time minutes"></div>
                <div class="time seconds"></div>
            </div>

            <script>
                jQuery(function($) {
                    $(document).ready(function () {
                        function makeTimer() {

                            var endTime = new Date("<?php echo esc_attr( $sales_price_date_from ); ?>");       
                            endTime = (Date.parse(endTime) / 1000);

                            if (isNaN(endTime)) {
                                console.error("Invalid date format: " + endTimeString);
                                return;
                            }
                            
                            var now = new Date();
                            now     = (Date.parse(now) / 1000);

                            var timeLeft = endTime - now;

                            var expired = "<?php echo esc_attr( $settings['flash_sale_when_expired'] ); ?>";

                            if ( timeLeft <= 0 ) {
                                timeLeft = 0;
                            }

                            if ( expired != 'hide' || timeLeft != 0 ) {
                                var days    = Math.floor(timeLeft / 86400); 
                                var hours   = Math.floor((timeLeft - (days * 86400)) / 3600);
                                var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
                                var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

                                if (hours < "10") { hours = "0" + hours; }
                                if (minutes < "10") { minutes = "0" + minutes; }
                                if (seconds < "10") { seconds = "0" + seconds; }

                                $(".days").html(days + "<br><span><?php echo esc_attr( $flash_sale_label_days ); ?></span>");
                                $(".hours").html(hours + "<br><span><?php echo esc_attr( $flash_sale_label_hours ); ?></span>");
                                $(".minutes").html(minutes + "<br><span><?php echo esc_attr( $flash_sale_label_minute ); ?></span>");
                                $(".seconds").html(seconds + "<br><span><?php echo esc_attr( $flash_sale_label_seconds ); ?></span>");
                            }       
                        }
                        setInterval(function() { makeTimer(); }, 1000);
                    });
                });
            </script>
        <?php endif;
    }

    public function front_enqueue_style() {
        wp_enqueue_style( 'cd-flash-sale-css', plugins_url( 'css/front.css', __FILE__), [], $this->version , 'all' );
    }
}