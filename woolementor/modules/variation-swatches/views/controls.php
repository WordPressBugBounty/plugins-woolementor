<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

global $post;
$is_archive = false;
if ( $post && $post->post_type == 'product' ) {
    $product    = wc_get_product( get_the_ID() );
}
//for shop widgets
else{
    $is_archive  = true;
    $product_id = codesigner_get_product_with_most_attributes();
    $product    = wc_get_product( $product_id );
} 

if ( ! $product ) return;

$attributes      = $product->get_attributes();

$settings->start_controls_section(
    'section_vs_switch',
    [
        'label' => __( 'Variation Swatches', 'codesigner' ),
        'tab'   => Controls_Manager::TAB_CONTENT,
    ]
);
$settings->add_control(
    'vs_show_hide',
    [
        'label'         => __( 'Show/Hide', 'codesigner' ),
        'type'          => Controls_Manager::SWITCHER,
        'label_on'      => __( 'Show', 'codesigner' ),
        'label_off'     => __( 'Hide', 'codesigner' ),
        'return_value'  => 'yes',
        'default'       => '',
    ]
);

$settings->end_controls_section();

foreach ( $attributes as $attribute_key => $attribute ) {
    $name           = substr( $attribute_key, 3 );
    $selector       = '.attribute_' . $attribute_key;
    $id             = $attribute->get_id();
    $attribute_type = codesigner_get_attribute_type_by_id( $id );

    $settings->start_controls_section(
        "vs_{$attribute_key}",
        [
            /* translators: %s: Name of the attribute */
            'label'     => sprintf( __( 'VS %s', 'codesigner' ), ucfirst( $name ) ),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'vs_show_hide' => 'yes'
            ],
        ]
    );

    $settings->add_control(
        "{$name}",
        [
            'label'     => __( 'Label Text', 'codesigner' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => ucfirst( $name ),
        ]
    );

    $settings->end_controls_section();

    $settings->start_controls_section(
        "vs_style_{$attribute_key}",
        [
            /* translators: %s: Name of the attribute */
            'label'     => sprintf( __( 'VS %s', 'codesigner' ), ucfirst( $name ) ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'vs_show_hide' => 'yes'
            ],
        ]
    );

    $settings->add_responsive_control(
        "{$name}_height",
        [
            'label'     => __( 'Height', 'codesigner' ),
            'type'      => Controls_Manager::SLIDER,
            'size_units'=> [ 'px', 'em' ],
            'selectors' => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content' => 'height: {{SIZE}}{{UNIT}}',
            ],
            'range'     => [
                'px'    => [
                    'min'   => 1,
                    'max'   => 1000
                ],
                'em'    => [
                    'min'   => 1,
                    'max'   => 50
                ],
            ],
        ]
    );
    $settings->add_responsive_control(
        "{$name}_width",
        [
            'label'     => __( 'Width', 'codesigner' ),
            'type'      => Controls_Manager::SLIDER,
            'size_units'=> [ 'px', 'em' ],
            'selectors' => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content' => 'width: {{SIZE}}{{UNIT}}',
            ],
            'range'     => [
                'px'    => [
                    'min'   => 1,
                    'max'   => 1000
                ],
                'em'    => [
                    'min'   => 1,
                    'max'   => 50
                ],
            ],
        ]
    );

    $settings->add_responsive_control(
        "{$name}_padding",
        [
            'label'     => __( 'Padding', 'codesigner' ),
            'type'      => Controls_Manager::SLIDER,
            'size_units'=> [ 'px', 'em' ],
            'selectors' => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content' => 'padding: {{SIZE}}{{UNIT}}',
            ],
            'range'     => [
                'px'    => [
                    'min'   => 1,
                    'max'   => 1000
                ],
                'em'    => [
                    'min'   => 1,
                    'max'   => 50
                ],
            ],
        ]
    );

    $settings->start_controls_tabs(
        "{$attribute_key}tabs_separator",
        [
            'separator' => 'before'
        ]
    );

    $settings->start_controls_tab(
        "{$name}_normal_tab",
        [
            'label'     => __( 'Normal', 'codesigner' ),
        ]
    );

    if ( $attribute_type == 'label' ) {
        $settings->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => "{$name}_background",
                'label'     => __( 'Background', 'codesigner' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content',
            ]
        );
        $settings->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => "{$name}typography",
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );
    }

    $settings->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'          => "{$name}_normal_border",
            'label'         => __( 'Border', 'codesigner' ),
            'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content',
        ]
    );

    $settings->add_responsive_control(
        "{$name}_normal_border_radius",
        [
            'label'         => __( 'Border Radius', 'codesigner' ),
            'type'          => Controls_Manager::DIMENSIONS,
            'size_units'    => [ 'px', '%' ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    if ( $attribute_type != 'label' ) {
        $settings->add_control(
            "{$name}_normal_grayscale",
            [
                'label'     => __( 'GrayScale', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content' => 'filter: grayscale( {{SIZE}}% )',
                ],
                'range'     => [
                    '%'    => [
                        'min'   => 1,
                        'max'   => 1000
                    ],
                ],
            ]
        );
    }

    $settings->end_controls_tab();

    $settings->start_controls_tab(
        "{$name}_hover_tab",
        [
            'label'     => __( 'Hover', 'codesigner' ),
        ]
    );

    if ( $attribute_type == 'label' ) {
        $settings->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => "{$name}_hover_background",
                'label'     => __( 'Background', 'codesigner' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content:hover',
            ]
        );
        $settings->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => "{$name}_hover_typography",
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content:hover',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );
    }

    $settings->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'          => "{$name}_hover_border",
            'label'         => __( 'Border', 'codesigner' ),
            'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content:hover',
        ]
    );

    $settings->add_responsive_control(
        "{$name}_hover_border_radius",
        [
            'label'         => __( 'Border Radius', 'codesigner' ),
            'type'          => Controls_Manager::DIMENSIONS,
            'size_units'    => [ 'px', '%' ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    if ( $attribute_type != 'label' ) {
        $settings->add_control(
            "{$name}_hover_grayscale",
            [
                'label'     => __( 'GrayScale', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-content:hover' => 'filter: grayscale( {{SIZE}}% )',
                ],
                'range'     => [
                    '%'    => [
                        'min'   => 1,
                        'max'   => 1000
                    ],
                ],
            ]
        );
    }


    $settings->end_controls_tab();

    $settings->start_controls_tab(
        "{$name}_active_tab",
        [
            'label'     => __( 'Active', 'codesigner' ),
        ]
    );

    if ( $attribute_type == 'label' ) {
        $settings->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => "{$name}_active_background",
                'label'     => __( 'Background', 'codesigner' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:checked + .codesigner-vs-content',
            ]
        );

        $settings->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => "{$name}_active_typography",
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:checked + .codesigner-vs-content',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );
    }

    $settings->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'          => "{$name}_active_border",
            'label'         => __( 'Border', 'codesigner' ),
            'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:checked + .codesigner-vs-content',
        ]
    );

    $settings->add_responsive_control(
        "{$name}_active_border_radius",
        [
            'label'         => __( 'Border Radius', 'codesigner' ),
            'type'          => Controls_Manager::DIMENSIONS,
            'size_units'    => [ 'px', '%' ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:checked + .codesigner-vs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    if ( $attribute_type != 'label' ) {
        $settings->add_control(
            "{$name}_active_grayscale",
            [
                'label'     => __( 'GrayScale', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:checked + .codesigner-vs-content' => 'filter: grayscale( {{SIZE}}% )',
                ],
                'range'     => [
                    '%'    => [
                        'min'   => 1,
                        'max'   => 1000
                    ],
                ],
            ]
        );
    }


    $settings->end_controls_tab();

    $settings->start_controls_tab(
        "{$name}_disabled_tab",
        [
            'label'     => __( 'Disabled', 'codesigner' ),
        ]
    );

    if ( $attribute_type == 'label' ) {
        $settings->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => "{$name}_disabled_background",
                'label'     => __( 'Background', 'codesigner' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:disabled + .codesigner-vs-content',
            ]
        );
        
        $settings->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => "{$name}_disabled_typography",
                'label'     => __( 'Typography', 'codesigner' ),
                'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:disabled + .codesigner-vs-content',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );
    }

    $settings->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'          => "{$name}_disabled_border",
            'label'         => __( 'Border', 'codesigner' ),
            'selector'      => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:disabled + .codesigner-vs-content',
        ]
    );

    $settings->add_responsive_control(
        "{$name}_disabled_border_radius",
        [
            'label'         => __( 'Border Radius', 'codesigner' ),
            'type'          => Controls_Manager::DIMENSIONS,
            'size_units'    => [ 'px', '%' ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:disabled + .codesigner-vs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    if ( $attribute_type != 'label' ) {
        $settings->add_control(
            "{$name}_disabled_grayscale",
            [
                'label'     => __( 'GrayScale', 'codesigner' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper '. $selector .' .codesigner-vs-radio:disabled + .codesigner-vs-content' => 'filter: grayscale( {{SIZE}}% )',
                ],
                'range'     => [
                    '%'    => [
                        'min'   => 1,
                        'max'   => 1000
                    ],
                ],
            ]
        );
    }

    $settings->end_controls_tab();
    $settings->end_controls_tabs();
    $settings->end_controls_section();

}
$settings->start_controls_section(
    "vs_style_label",
    [
        'label'         => __( 'VS Label', 'codesigner' ),
        'tab'           => Controls_Manager::TAB_STYLE,
        'condition' => [
            'vs_show_hide' => 'yes'
        ],
    ]
);

$settings->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name'      => 'label_typography',
        'label'     => __( 'Label Typography', 'codesigner' ),
        'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name',
        'fields_options'    => [
            'typography'    => [ 'default' => 'yes' ],
            'font_size'     => [ 'default' => [ 'size' => 16 ] ],
            'font_family'   => [ 'default' => 'Montserrat' ],
            'font_weight'   => [ 'default' => 500 ],
        ],
    ]
);

$settings->add_responsive_control(
    'vs_label_width',
    [
        'label'     => __( 'Width', 'codesigner' ),
        'type'      => Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em' ],
        'selectors' => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name' => 'width: {{SIZE}}{{UNIT}}',
        ],
        'range'     => [
            'px'    => [
                'min'   => 1,
                'max'   => 1000
            ],
            'em'    => [
                'min'   => 1,
                'max'   => 50
            ],
        ],
    ]
);

$settings->add_responsive_control(
    'vs_label_margin',
    [
        'label'         => __( 'Margin', 'codesigner' ),
        'type'          => Controls_Manager::DIMENSIONS,
        'size_units'    => [ 'px', '%', 'em' ],
        'selectors'     => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator'     => 'before',
    ]
);

$settings->add_responsive_control(
    'vs_label_padding',
    [
        'label'         => __( 'Padding', 'codesigner' ),
        'type'          => Controls_Manager::DIMENSIONS,
        'size_units'    => [ 'px', '%', 'em' ],
        'selectors'     => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$settings->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name'      => 'vs_label_border',
        'label'     => __( 'Border', 'codesigner' ),
        'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name',
    ]
);

$settings->add_responsive_control(
    'vs_label_border_radius',
    [
        'label'         => __( 'Border Radius', 'codesigner' ),
        'type'          => Controls_Manager::DIMENSIONS,
        'size_units'    => [ 'px', '%' ],
        'selectors'     => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$settings->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name'      => 'vs_label_box_shadow',
        'label'     => __( 'Box Shadow', 'codesigner' ),
        'selector'  => '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper .codesigner-tax-name',
    ]
);

$settings->end_controls_section();


$settings->start_controls_section(
    "vs_style_options",
    [
        'label'         => __( 'VS Options', 'codesigner' ),
        'tab'           => Controls_Manager::TAB_STYLE,
        'condition' => [
            'vs_show_hide' => 'yes'
        ],
    ]
);

$settings->add_responsive_control(
    'vs_options_gap',
    [
        'label'     => __( 'Gap', 'codesigner' ),
        'type'      => Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em' ],
        'selectors' => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-form .codesigner-vs-wrapper' => 'gap: {{SIZE}}{{UNIT}}',
        ],
        'range'     => [
            'px'    => [
                'min'   => 1,
                'max'   => 1000
            ],
            'em'    => [
                'min'   => 1,
                'max'   => 50
            ],
        ],
    ]
);

$settings->end_controls_section();

$settings->start_controls_section(
    "vs_style_options",
    [
        'label'         => __( 'VS Options', 'codesigner' ),
        'tab'           => Controls_Manager::TAB_STYLE,
        'condition' => [
            'vs_show_hide' => 'yes'
        ],
    ]
);

$settings->add_responsive_control(
    'vs_options_gap',
    [
        'label'     => __( 'Gap', 'codesigner' ),
        'type'      => Controls_Manager::SLIDER,
        'size_units'=> [ 'px', 'em' ],
        'selectors' => [
            '.codesigner {{WRAPPER}} .cd-variation-swatches-form .codesigner-vs-wrapper' => 'gap: {{SIZE}}{{UNIT}}',
        ],
        'range'     => [
            'px'    => [
                'min'   => 1,
                'max'   => 1000
            ],
            'em'    => [
                'min'   => 1,
                'max'   => 50
            ],
        ],
    ]
);

$settings->end_controls_section();

/*Offset controller*/
if ( $is_archive ) {
    $settings->start_controls_section(
        'vs_style_offset',
        [
            'label' => __( 'VS Offset', 'codesigner' ),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => [
                'vs_show_hide' => 'yes'
            ],
        ]
    );
    
    $settings->add_control(
        'vs_default_style',
        [
            'label'     => __( 'Display', 'codesigner' ),
            'type'      => Controls_Manager::HIDDEN,
            'selectors' => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper' => 'text-align: center;letter-spacing: 1px;z-index: 100;top:27px',
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper' => 'right: 0;',
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper' => 'left: 0;',
            ],
            'default' => 'traditional',
        ]
    );
    
    $settings->add_control(
        'vs_style_offset_toggle',
        [
            'label'         => __( 'Offset', 'codesigner' ),
            'type'          => Controls_Manager::POPOVER_TOGGLE,
            'label_off'     => __( 'None', 'codesigner' ),
            'label_on'      => __( 'Custom', 'codesigner' ),
            'return_value'  => 'yes',
            'default'  => 'yes',
        ]
    );
    
    $settings->start_popover();
    
    $settings->add_responsive_control(
        'vs_media_offset_x',
        [
            'label'         => __( 'Offset Left', 'codesigner' ),
            'type'          => Controls_Manager::SLIDER,
            'size_units'    => ['px'],
            'condition'     => [
                'vs_style_offset_toggle' => 'yes'
            ],
            'range'         => [
                'px'        => [
                    'min'   => -1000,
                    'max'   => 1000,
                ],
            ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper' => 'left: {{SIZE}}{{UNIT}}',
            ],
            'render_type'   => 'ui',
        ]
    );
    
    $settings->add_responsive_control(
        'vs_media_offset_y',
        [
            'label'         => __( 'Offset Top', 'codesigner' ),
            'type'          => Controls_Manager::SLIDER,
            'size_units'    => ['px'],
            'condition'     => [
                'vs_style_offset_toggle' => 'yes'
            ],
            'range'         => [
                'px'        => [
                    'min'   => -1000,
                    'max'   => 1000,
                ],
            ],
            'selectors'     => [
                '.codesigner {{WRAPPER}} .cd-variation-swatches-wrapper' => 'top: {{SIZE}}{{UNIT}}',
            ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ]
        ]
    );
    $settings->end_popover();
    
    $settings->end_controls_section();
}