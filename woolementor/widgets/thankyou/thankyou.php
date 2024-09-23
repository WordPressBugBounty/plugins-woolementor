<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Thankyou extends Widget_Base {

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
			'thankyou_notice_content',
			[
				'label' => __( 'Thank You Message', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'thankyou_notice_description',
			[
				'label' => __( '', 'codesigner' ),
				'type' 	=> Controls_Manager::TEXTAREA,
				'default' => __( 'Thank you. Your order has been received.', 'codesigner' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_order_info',
			[
				'label' => __( 'Order Info', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'thankyou_order_info_title_show',
			[
				'label' => __( 'Show Title', 'codesigner' ),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'codesigner' ),
				'label_off' => __( 'Hide', 'codesigner' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'order_info_title',
			[
				'label' => __( 'Text', 'codesigner' ),
				'type' 	=> Controls_Manager::TEXT,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
				'default' => __( 'Order Info', 'codesigner' ),
			]
		);


		$this->add_control(
			'order_info_title_tag',
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
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_notice',
			[
				'label' => __( 'Thank you', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_notice_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .codesigner-notice',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_notice_color',
				'selector' 	=> '{{WRAPPER}} .codesigner-notice',
			]
		);

		$this->add_control(
            'thankyou_notice_alignment',
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
                    'justify' 	=> [
                        'title' 	=> __( 'Justify', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-justify',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'codesigner' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .codesigner-notice' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_notice_background',
				'label' 	=> __( 'Background', 'codesigner' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .codesigner-notice',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'thankyou_notice_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .codesigner-notice',
			]
		);

		$this->add_control(
			'thankyou_notice_border_radius',
			[
				'label' => __( 'Border Radius', 'codesigner' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'separator' 	=> 'after',
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .codesigner-notice' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_notice_padding',
			[
				'label' => __( 'Padding', 'codesigner' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .codesigner-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_title_style',
			[
				'label' => __( 'Order Info Title', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_info_title_alignment',
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
                    '{{WRAPPER}} .codesigner-thankyou .thankyou_order_info_title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_title_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_info_title_color',
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_style',
			[
				'label' => __( 'Order Info', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
			'order_info_column',
			[
				'label' => __( 'Column Width', 'codesigner' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' 	=> 50,
						'max' 	=> 900,
						'step' 	=> 5,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 130,
				],
				'selectors' => [
					'{{WRAPPER}} .codesigner-order-overview .wl-tnq-order-col1' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .codesigner-order-overview',
			]
		);

		$this->add_control(
			'order_info_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .codesigner-order-overview li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_info_bg_color1',
			[
				'label'     => __( 'Background Color(Odd row)', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .codesigner-order-overview li:nth-child(odd)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_info_bg_color2',
			[
				'label'     => __( 'Background Color(Even row)', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .codesigner-order-overview li:nth-child(even)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_title_style',
			[
				'label' => __( 'Order Details Title', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'order_details_title_alignment',
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
                    '{{WRAPPER}} .codesigner-thankyou .woocommerce-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_title_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_details_title_color',
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_table_style',
			[
				'label' => __( 'Order Details Table', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_details_table_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tr th,
								{{WRAPPER}} .woocommerce-order-details table tr td',
			]
		);

		$this->start_controls_tabs(
			'order_details_table_style_tab'
		);

		$this->start_controls_tab(
			'order_details_table_header',
			[
				'label' => __( 'Header', 'codesigner' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_th_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table thead tr th',
			]
		);

		$this->add_control(
			'order_details_th_color',
			[
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_th_bg_color',
			[
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_body',
			[
				'label' => __( 'Body', 'codesigner' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tbody tr td',
			]
		);

		$this->add_control(
			'order_details_tbody_color',
			[
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tbody td a' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_foot',
			[
				'label' => __( 'Footer', 'codesigner' ),
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tfoot_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tfoot tr th,
								{{WRAPPER}} .woocommerce-order-details table tfoot tr td',
			]
		);

		$this->add_control(
			'order_details_tfoot_color',
			[
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th,
					{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_addresses',
			[
				'label' => __( 'Addresses', 'codesigner' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_addresses_background',
				'label' 	=> __( 'Background', 'codesigner' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'thankyou_addresses_border',
				'label' => __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_control(
			'thankyou_addresses_border_radius',
			[
				'label' => __( 'Border Radius', 'codesigner' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'after',
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_addresses_padding',
			[
				'label' => __( 'Padding', 'codesigner' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'thankyou_addresses_style_tab'
		);

		$this->start_controls_tab(
			'thankyou_addresses_title',
			[
				'label' => __( 'Titles', 'codesigner' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .codesigner-thankyou .woocommerce-customer-details h2',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_color',
				'selector' 	=> '{{WRAPPER}} .codesigner-thankyou .woocommerce-customer-details h2',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'thankyou_addresses_content',
			[
				'label' => __( 'Contents', 'codesigner' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .codesigner-thankyou .woocommerce-customer-details address',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_color',
				'selector' 	=> '{{WRAPPER}} .codesigner-thankyou .woocommerce-customer-details address',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		if( !current_user_can( 'edit_pages' ) ) return;

        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}
