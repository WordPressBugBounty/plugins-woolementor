<?php
namespace Codexpert\CoDesigner;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Sales_Notification extends Widget_Base {

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
			'sectio_cat',
			[
				'label' 		=> __( 'Content', 'codesigner' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'notification_from',
			[
				'label' 		=> __( 'Content Source', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'this_site'  	=> __( 'From This Site', 'codesigner' ),
					'from_api' 		=> __( 'From API', 'codesigner' ),
				],
				'default' 		=> 'this_site',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'api_url',
			[
				'label' 		=> __( 'API URL', 'codesigner' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> 'https://your-link.com/api',
				'default' 		=> [
					'url' => '',
				],
				'label_block' 	=> true,
				'description' 	=> __( 'REST API URL to fetch order data from.', 'codesigner' ),
                'condition' => [
            		'notification_from' => 'from_api'
                ],
			]
		);

		$this->add_control(
			'enable_url',
			[
				'label' => __( 'Link To Product', 'codesigner' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'ON', 'codesigner' ),
				'label_off' => __( 'OFF', 'codesigner' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'notification_type',
			[
				'label' 		=> __( 'Content Type', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'real_data'  	=> __( 'Real Data', 'codesigner' ),
					'fake_data' 	=> __( 'Fake Data', 'codesigner' ),
					'both_data' 	=> __( 'Both ', 'codesigner' ),
				],
				'default' 		=> 'fake_data',
				'label_block' 	=> true,
				'condition' 	=> [
					'notification_from' => 'this_site'
				],
			]
		);

		$this->add_control(
			'orders_limit',
			[
				'label' 		=> __( 'Number of Orders', 'codesigner' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 5,
				'label_block' 	=> true,
                'conditions' => [
            		'relation' => 'and',
            		'terms' => [
            			[
            				'name' => 'notification_type',
            				'operator' => 'in',
            				'value' => [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' => 'notification_from',
            				'operator' => '==',
            				'value' => 'this_site',
            			],
            		],
                ],
			]
		);

		$this->add_control(
		    'orders_statuses',
		    [
		        'label'         => __( 'Order Statuses', 'codesigner' ),
		        'type'          => Controls_Manager::SELECT2,
		        'multiple'       => true,
		        'separator'      => 'after',
		        'options'       => [
		            'completed'    => __( 'Completed', 'codesigner' ),
		            'processing'   => __( 'Processing', 'codesigner' ),
		            'on-hold'      => __( 'On Hold', 'codesigner' ),
		        ],
		        'default'       => [ 'completed', 'processing', 'on-hold' ],
                'conditions' => [
                	'relation' => 'and',
            		'terms' => [
            			[
            				'name' => 'notification_type',
            				'operator' => 'in',
            				'value' => [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' => 'notification_from',
            				'operator' => '==',
            				'value' => 'this_site',
            			],
            		],
                ],
		    ]
		);

		$this->add_control(
			'product_ids', [
				'label' => __( 'Product IDs', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Ex: 21,56,89' , 'codesigner' ),
				'description' => __( 'Input the product IDs you want to show' , 'codesigner' ),
				'label_block' => true,
				'conditions' => [
					'relation' => 'and',
            		'terms' => [
            			[
            				'name' => 'notification_type',
            				'operator' => 'in',
            				'value' => [ 'real_data', 'both_data' ],
            			],
            			[
            				'name' => 'notification_from',
            				'operator' => '==',
            				'value' => 'this_site',
            			],
            		],
				],
			]
		);

        $repeater = new Repeater();

		$repeater->add_control(
			'customer', [
				'label' => __( 'Client Name', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'address', [
				'label' => __( 'Client Address', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New York, USA' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_name', [
				'label' => __( 'Product Name', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Item' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_url', [
				'label' => __( 'Product URL', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'https://example.com' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_image',
			[
				'label' => __( 'Choose Image', 'codesigner' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'time', [
				'label' => __( 'Notification Time', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '1 hour' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'notifications',
			[
				'label' => __( 'Notification List', 'codesigner' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'client_name' => __( 'John Doe', 'codesigner' ),
						'client_address' => __( 'New York, USA', 'codesigner' ),
						'product_name' => __( 't-shirt', 'codesigner' ),
						'sell_time' => '1 hours'
					],
					[
						'client_name' => __( 'John Max', 'codesigner' ),
						'client_address' => __( 'New York, USA', 'codesigner' ),
						'product_name' => __( 't-shirt with logo', 'codesigner' ),
						'sell_time' => '30 minutes'
					],
					[
						'client_name' => __( 'Peter Jackson', 'codesigner' ),
						'client_address' => __( 'New York, USA', 'codesigner' ),
						'product_name' => __( 'album', 'codesigner' ),
						'sell_time' => '40 minutes'
					],
					[
						'client_name' => __( 'Alan Jackson', 'codesigner' ),
						'client_address' => __( 'New York, USA', 'codesigner' ),
						'product_name' => __( 'single', 'codesigner' ),
						'sell_time' => '20 minutes'
					],
				],
                'conditions' => [
                	'relation' => 'and',
            		'terms' => [
            			[
            				'name' => 'notification_type',
            				'operator' => 'in',
            				'value' => [ 'fake_data', 'both_data' ],
            			],
            			[
            				'name' => 'notification_from',
            				'operator' => '==',
            				'value' => 'this_site',
            			],
            		],
                ],
				'title_field' => '{{{ client_name }}}',
			]
		);

		$this->add_control(
			'notification_duration',
			[
				'label' => __( 'Interval (millisecond)', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'separator' 	=> 'before',
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 60000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 3000,
				],
			]
		);

		$this->add_control(
			'notification_delay',
			[
				'label' => __( 'Delay (millisecond)', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 60000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 1000,
				],
			]
		);


        $this->add_responsive_control(
            'alignment',
            [
                'label' 		=> __( 'Alignment', 'codesigner' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'left',
            ]
        );

        $this->end_controls_section();

		/**
		 * Notification area
		 */
		$this->start_controls_section(
			'notification_style',
			[
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'nt_background',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'position_x',
			[
				'label' => __( 'Position X', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'position_l_y',
			[
				'label' => __( 'Position Y', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' 	=> [
                    'alignment' => 'left'
                ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification.left' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'position_r_y',
			[
				'label' => __( 'Position Y', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' 	=> [
                    'alignment' => 'right'
                ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification.right' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * Notification area		 
		 */
		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'image_width',
            [
                'label' 	=> __( 'Image Width', 'codesigner' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-sales-notification .notification .image' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' 	=> __( 'Image Height', 'codesigner' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-sales-notification .notification .image' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'img_border',
				'label' => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification .image',
			]
		);

		$this->add_responsive_control(
			'img_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'img_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification .image',
			]
		);

		$this->add_responsive_control(
			'img_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'img_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 

		/**
		 * Notification content area		 
		 */
		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> '_typography',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-sales-notification .notification .item_details',
			]
		);

		 $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'pricing_table_header_color',
                'selector' => '{{WRAPPER}} .wl-sales-notification .notification .item_details',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-sales-notification .notification .item_details',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( wcd_is_edit_mode() ){
        	echo wcd_notice ( __( 'The actual sales notification shows at the bottom left/right of this page!', 'codesigner' ), '' );
        }
        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img width='300' src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}

