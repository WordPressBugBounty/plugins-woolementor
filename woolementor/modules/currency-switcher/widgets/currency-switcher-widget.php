<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class Currency_Switcher_Widget extends Widget_Base {

	public function get_name() {
		return 'currency_switcher_widget';
	}

	public function get_title() {
		return esc_html__( 'Currency Switcher', 'codesigner' );
	}

	public function get_icon() {
		$cd_branding_class = ' wlbi';
		return 'eicon-exchange' . $cd_branding_class;
	}
	
	public function get_categories() {
		return [ 'codesigner' ];
	}

	public function get_keywords() {
		return [ 'currency', 'switcher' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'currency_content',
			[
				'label' 		=> __( 'Content', 'codesigner-pro' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'image_show_hide',
			[
				'label' 		=> __( 'Image Show/Hide', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner-pro' ),
				'label_off' 	=> __( 'Hide', 'codesigner-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'title_show_hide',
			[
				'label' 		=> __( 'Title Show/Hide', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'codesigner-pro' ),
				'label_off' 	=> __( 'Hide', 'codesigner-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->end_controls_section();

		/**
		 * style section
		 */
		$this->start_controls_section(
			'currency_style',
			[
				'label' => __( 'Wrapper', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'currency_popover',
			[
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'label' 		=> esc_html__( 'Position', 'codesigner' ),
				'label_off' 	=> esc_html__( 'Default', 'codesigner' ),
				'label_on' 		=> esc_html__( 'Custom', 'codesigner' ),
				'return_value' 	=> 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'currency_popover_transform_x',
			[
				'label' 	=> __( 'Content Transform X', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #cd-currency-switcher-warpper' => 'top: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => -200,
                        'max'   => 2000
                    ],
                ],
				'condition' 	=> [
					'currency_popover' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'currency_popover_transform_Y',
			[
				'label' 	=> __( 'Content Transform Y', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #cd-currency-switcher-warpper' => 'right: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => -200,
                        'max'   => 2000
                    ],
                ],
				'condition' 	=> [
					'currency_popover' => 'yes'
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
            'wrapper_width',
            [
                'label' 	=> __( 'Gap', 'codesigner-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} #cd-currency-switcher-warpper' => 'gap: {{SIZE}}{{UNIT}}',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 	=> 'currency_background',
				'label' => __( 'Background', 'codesigner-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} #cd-currency-switcher-warpper',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ], 
					'color' => [ 'default' => '#fff' ], 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'border',
				'label' => __( 'Border', 'codesigner-pro' ),
				'selector' => '.wl {{WRAPPER}} #cd-currency-switcher-warpper',
			]
		);

		$this->add_responsive_control(
			'currency_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'box_shadow',
				'label' 		=> __( 'Box Shadow', 'codesigner-pro' ),
				'selector' 		=> '.wl {{WRAPPER}} #cd-currency-switcher-warpper',
			]
		);

		$this->add_responsive_control(
			'currency_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'list_style',
			[
				'label' => __( 'List', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'list_width',
            [
                'label' 	=> __( 'Width', 'codesigner-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency' => 'width: {{SIZE}}{{UNIT}}',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
            ]
        );

        $this->add_control(
        	'list_background',
        	[
        		'label'     => __( 'Background Color', 'codesigner-pro' ),
        		'type'      => Controls_Manager::COLOR,
        		'selectors' => [
        			'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency' => 'background-color: {{VALUE}}',
        		],
        	]
        );

        $this->add_control(
        	'list_hover_background',
        	[
        		'label'     => __( 'Background Hover Color', 'codesigner-pro' ),
        		'type'      => Controls_Manager::COLOR,
        		'selectors' => [
        			'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency:hover' => 'background-color: {{VALUE}}',
        		],
        	]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'list_border',
				'label' 	=> __( 'Border', 'codesigner-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency',
			]
		);

		$this->add_responsive_control(
			'list_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency',
				'fields_options' => [
					'box_shadow_type' => [ 
                        'default' 	=>'yes' 
                	],
				]
			]
		);

		$this->add_responsive_control(
			'list_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'list_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-single-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'image_width',
            [
                'label' 	=> __( 'Image Width', 'codesigner-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} #cd-currency-switcher-warpper img' => 'width: {{SIZE}}{{UNIT}}',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' 	=> __( 'Image Height', 'codesigner-pro' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} #cd-currency-switcher-warpper img' => 'height: {{SIZE}}{{UNIT}}',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'img_border',
				'label' 	=> __( 'Border', 'codesigner-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} #cd-currency-switcher-warpper img',
			]
		);

		$this->add_responsive_control(
			'img_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'img_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} #cd-currency-switcher-warpper img',
			]
		);

		$this->add_responsive_control(
			'img_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'img_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section(); 


		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'codesigner-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> '_typography',
				'label' 	=> __( 'Typography', 'codesigner-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 300 ],
				],
			]
		);

        $this->add_control(
        	'content_color',
        	[
        		'label'     => __( 'Message Color', 'codesigner-pro' ),
        		'type'      => Controls_Manager::COLOR,
        		'selectors' => [
        			'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text' => 'color: {{VALUE}}',
        		],
        		'default'  	=> '#000000'
        	]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => __( 'Border', 'codesigner-pro' ),
				'selector' => '.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} #cd-currency-switcher-warpper .cd-currency-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->end_controls_section();  
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();

		if( wcd_is_edit_mode() ){
			echo wp_kses_post( wcd_notice( __( 'The actual currency switcher shows at the middle right of this page!', 'codesigner-pro' ) ) );
		}
        ?>
        <div id="cd-currency-switcher-warpper">
        	<?php do_action( 'cd_currency_switcher_button_start' ); ?>
			<?php
			if ( get_option( 'codesigner_currency_switcher', true ) && isset( get_option( 'codesigner_currency_switcher', true )['cd_currency'] ) ) {
				$cd_currency 		= get_option( 'codesigner_currency_switcher', true )['cd_currency'];
				$currency_code 		= codesigner_get_currency_code();

				foreach ( $cd_currency as $currency_array ) {
					$checked = $currency_array['cd_cs_name'] == $currency_code ? 'checked' : '';
					?>
					<label>
						<input type="radio" name="cd_selected_currency" value="<?php esc_attr( $currency_array['cd_cs_name'] ); ?>" <?php esc_attr( $checked ); ?> >
						<div class='cd-single-currency'>
							<?php if( $settings['image_show_hide'] ) : ?>
								<img src="<?php echo esc_url( wp_get_attachment_url( $currency_array['cd_cs_img'] ) ); ?>">
							<?php endif ?>
							<?php if( $settings['title_show_hide'] ) : ?>
								<span class='cd-currency-text'>
									<?php esc_html( $currency_array['cd_cs_name'] ); ?>
								</span>
							<?php endif ?>
						</div>
					</label>
					<?php
				}
			}
			?>
			<?php
			do_action( 'cd_currency_switcher_button_end' ); 
			do_action( 'codesigner_after_main_content', $this );
			?>
        </div>

        <?php   	
	}

}

