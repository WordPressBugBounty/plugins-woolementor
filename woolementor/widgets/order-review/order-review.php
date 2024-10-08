<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Order_Review extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
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


		$this->start_controls_section(
			'order_notes_title',
			[
				'label' => __( 'Section Title', 'codesigner' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'order_review_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'codesigner' ),
                'label_off'     => __( 'Hide', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
		//order_button_text
		$this->add_control(
		    'order_review_title_text',
		    [
		        'label' 		=> __( 'Text', 'codesigner' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Order Review', 'codesigner' ) ,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
			'order_review_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'codesigner' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'codesigner' ),
					'h2'  => __( 'H2', 'codesigner' ),
					'h3'  => __( 'H3', 'codesigner' ),
					'h4'  => __( 'H4', 'codesigner' ),
					'h5'  => __( 'H5', 'codesigner' ),
					'h6'  => __( 'H6', 'codesigner' ),
				],
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_review_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'codesigner' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-order-review-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'order_review_content',
			[
				'label' => __( 'Table Headings', 'codesigner' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'order_review_table_th1',
		    [
		        'label' 		=> __( 'Product Column Heading', 'codesigner' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Product', 'codesigner' ) ,
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
		    'order_review_table_th2',
		    [
		        'label' 		=> __( 'Price Column Heading', 'codesigner' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Subtotal', 'codesigner' ) ,
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'order_review_title_style',
			[
				'label' => __( 'Title', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_review_title_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-order-review-title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'order_review_title_color',
				'selector' => '{{WRAPPER}} .wl-order-review-title',
			]
		);

		$this->end_controls_section();


		/**
		 * Table border control
		 */
		$this->start_controls_section(
			'order_table_border_style',
			[
				'label' => __( 'Table Sell Border', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'      => 'table_border_type',
		        'label'     => __( 'Border', 'codesigner' ),
		        'selector'  => '{{WRAPPER}} .wl-or-table tr td,
		        				{{WRAPPER}} .wl-or-table tr th',
		    ]
		);

		$this->end_controls_section();

		/**
		 * Table Header control
		 */
		$this->start_controls_section(
			'order_table_header_style',
			[
				'label' => __( 'Table Header', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_thead_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-or-table thead tr th',
			]
		);


        $this->add_control(
			'order_thead_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table thead tr th' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'order_thead_bg_color',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table thead tr th' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
            'order_thead_alignment',
            [
                'label' 	   => __( 'Alignment', 'codesigner' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-or-table thead tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_thead_padding',
        	[
        		'label' => __( 'Padding', 'codesigner' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-or-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		/**
		 * Table body control
		 */
		$this->start_controls_section(
			'order_tbody_style',
			[
				'label' => __( 'Table Body', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-or-table tbody tr td',
			]
		);


        $this->add_control(
			'order_tbody_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table tbody tr td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table tbody tr td' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'order_tbody_alignment',
            [
                'label' 	   => __( 'Alignment', 'codesigner' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-or-table tbody tr td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tbody_padding',
        	[
        		'label' => __( 'Padding', 'codesigner' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-or-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();


		/**
		 * Table footer control
		 */
		$this->start_controls_section(
			'order_tfoot_style',
			[
				'label' => __( 'Table Footer', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tfoot_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-or-table tfoot tr td,
								{{WRAPPER}} .wl-or-table tfoot tr th',
			]
		);


        $this->add_control(
			'order_tfoot_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table tfoot tr td,
					 {{WRAPPER}} .wl-or-table tfoot tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-or-table tfoot tr td,
					 {{WRAPPER}} .wl-or-table tfoot tr th' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
            'order_tfoot_alignment',
            [
                'label' 	   => __( 'Alignment', 'codesigner' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
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
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-or-table tfoot tr td,
					 {{WRAPPER}} .wl-or-table tfoot tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tfoot_padding',
        	[
        		'label' => __( 'Padding', 'codesigner' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-or-table tfoot tr td,
					 {{WRAPPER}} .wl-or-table tfoot tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        // Translators: 1: Widget name, 2: Link to CoDesigner Pro.
        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%1$s</strong> is a premium widget. Please upgrade to <strong>%2$s</strong> or activate your license if you already have upgraded!', 'codesigner' ), esc_html( $this->get_name() ), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }

	/**
	 * Adds the starting form tag <form>
	 */
	public function start_form( $start ) {
		return '<form name="checkout" method="post" class="checkout woocommerce-checkout" action="" enctype="multipart/form-data" novalidate="novalidate">';
	}

	/**
	 * Adds the closing form tag </form>
	 */
	public function close_form( $close ) {
		return '</form>';
	}
}

