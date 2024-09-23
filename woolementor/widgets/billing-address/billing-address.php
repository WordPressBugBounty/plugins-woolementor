<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Billing_Address extends Widget_Base {

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
			'shipping_title',
			[
				'label' => __( 'Section Title', 'codesigner' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'billing_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'codesigner' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'codesigner' ),
                'label_off'     => __( 'Hide', 'codesigner' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
		$this->add_control(
		    'billing_title_text',
		    [
		        'label' 		=> __( 'Text', 'codesigner' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Billing Address', 'codesigner' ) ,
                'condition' 	=> [
                    'billing_title_show' => 'yes'
                ],
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
			'payment_title_tag',
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
                    'billing_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'billing_title_alignment',
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
                    'billing_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-billing-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Billing Fields', 'codesigner' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'billing_input_label', [
				'label' => __( 'Input Label', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New Section' , 'codesigner' ),
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$repeater->add_control(
			'billing_input_class', [
				'label' => __( 'Class Name', 'codesigner' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'form-row-wide',
				'options' => [
					'form-row-first' => 'form-row-first',
					'form-row-last' => 'form-row-last',
					'form-row-wide' => 'form-row-wide',
				],
			]
		);

		$repeater->add_control(
			'billing_input_type', [
				'label' => __( 'Input Type', 'codesigner' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'text',
				'options' => [
					// 'country'			=> __( 'Country', 'codesigner' ),
					// 'state'				=> __( 'State', 'codesigner' ),
					'textarea'			=> __( 'Textarea', 'codesigner' ),
					'checkbox'			=> __( 'Checkbox', 'codesigner' ),
					'text'				=> __( 'Text', 'codesigner' ),
					'password'			=> __( 'Password', 'codesigner' ),
					'date'				=> __( 'Date', 'codesigner' ),
					'number'			=> __( 'Number', 'codesigner' ),
					'email'				=> __( 'Email', 'codesigner' ),
					'url'				=> __( 'Url', 'codesigner' ),
					'tel'				=> __( 'Tel', 'codesigner' ),
					'select'			=> __( 'Select', 'codesigner' ),
					'radio'				=> __( 'Radio', 'codesigner' ),
				],
			]
		);

		$repeater->add_control(
			'billing_input_options', [
				'label' => __( 'Options', 'codesigner' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => implode( PHP_EOL, [ __( 'Option 1', 'codesigner' ), __( 'Option 2', 'codesigner' ), __( 'Option 3', 'codesigner' ) ] ),
				'label_block' => true,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'billing_input_type',
							'operator' => '==',
							'value' => 'select',
						],
						[
							'name' => 'billing_input_type',
							'operator' => '==',
							'value' => 'radio',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'billing_input_name', [
				'label' => __( 'Field Name', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'name_' . wp_rand( 111, 999 ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_input_placeholder', [
				'label' => __( 'Placeholder', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Placeholder' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_input_autocomplete', [
				'label' => __( 'Autocomplete Value', 'codesigner' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Given value' , 'codesigner' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'billing_input_required',
			[
				'label'         => __( 'Required', 'codesigner' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'codesigner' ),
				'label_off'     => __( 'no', 'codesigner' ),
				'return_value'  => true,
				'default'       => true,
			]
		);

		$this->add_control(
			'billing_form_items',
			[
				'label' => __( '', 'codesigner' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => wcd_checkout_fields(),
				'title_field' => '{{{ billing_input_label }}}',
			]
		);

		$this->end_controls_section();



		//section title style
		$this->start_controls_section(
			'billing_title_style',
			[
				'label' => __( 'Title', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'billing_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'billing_title_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-billing-title',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 18 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'billing_title_color',
				'selector' => '{{WRAPPER}} .wl-billing-title',
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'billing_style',
			[
				'label' => __( 'Labels', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'billing_label_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-billing label',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);


        $this->add_control(
			'billing_label_color',
			[
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-billing label' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
        	'billing_label_padding',
        	[
        		'label' => __( 'Padding', 'codesigner' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-billing label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->add_control(
			'billing_label_line_hight',
			[
				'label' => __( 'Line Height', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-billing label' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Color
		 */
		$this->start_controls_section(
			'billing_input_style',
			[
				'label' => __( 'Input Fields', 'codesigner' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'billing_input_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
					// 'line_height' 	=> [ 'default' => [ 'size' => 37 ] ],
		            'font_family' 	=> [ 'default' => 'Montserrat' ],
		            'font_weight' 	=> [ 'default' => 500 ],
				],
				'selector' => '{{WRAPPER}} .wl-billing input, 
								{{WRAPPER}} .wl-billing select, 
								{{WRAPPER}} .wl-billing option,
								{{WRAPPER}} .wl-billing textarea',
			]
		);

		$this->add_control(
			'billing_input_color',
			[
				'label'     => __( 'Input Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
								'{{WRAPPER}} .wl-billing input, 
								 {{WRAPPER}} .wl-billing select, 
								 {{WRAPPER}} .wl-billing option,
								 {{WRAPPER}} .wl-billing textarea' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'billing_input_background_color',
			[
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
								'{{WRAPPER}} .wl-billing input, 
								 {{WRAPPER}} .wl-billing select, 
								 {{WRAPPER}} .wl-billing option,
								 {{WRAPPER}} .wl-billing textarea' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'billing_input_border',
				'label' 	=> __( 'Border', 'codesigner' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .wl-billing input, 
								{{WRAPPER}} .wl-billing select,
								{{WRAPPER}} .wl-billing textarea',
			]
		);

        $this->add_control(
			'billing_input_border_radius',
			[
				'label' => __( 'Border Radius', 'codesigner' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select,
					 {{WRAPPER}} .wl-billing textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'billing_input_padding',
			[
				'label' => __( 'Padding', 'codesigner' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-billing input, 
					 {{WRAPPER}} .wl-billing select,
					 {{WRAPPER}} .wl-billing textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_name(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( '/assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}