<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Gradient_Button extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "codesigner-{$this->id}", 'fancybox' ];
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
		 * Repeater Tabs
		 */
		$this->start_controls_section(
			'gradient_button_section',
			[
				'label' 		=> __( 'Add to Cart', 'codesigner' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gradient_button_text',
			[
				'label' 		=> __( 'Button Text', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Click Here', 'codesigner' ),
				'placeholder' 	=> __( 'Type your title here', 'codesigner' ),
			]
		);

		$this->add_responsive_control(
			'gradient_button_alignment',
			[
				'label'		=> __( 'Button Alignment', 'codesigner' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
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
				'selectors' => [
					'{{WRAPPER}} .wl-gradient-button-area' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gradient_button_Block',
			[
				'label'			=> __( 'Block', 'codesigner' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'True', 'codesigner' ),
				'label_off' 	=> __( 'False', 'codesigner' ),
				'return_value' 	=> 'block',
				'default' 		=> 'inline-block',
				'separator' 	=> 'after',
				'selectors' 	=> [
                    '{{WRAPPER}} .wl-gradient-button' => 'display: {{VALUE}}',
                ],
			]
		);

		$this->add_control(
			'gradient_button_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'gradient_button_icon_align',
			[
				'label' => __( 'Icon Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'elementor' ),
					'right' => __( 'After', 'elementor' ),
				],
				'condition' => [
					'gradient_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'enable_hyperlink',
			[
				'label' => __( 'Enable Hyperlink', 'codesigner' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'codesigner' ),
				'label_off' => __( 'No', 'codesigner' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'gb_link',
			[
				'label' => __( 'Link', 'codesigner' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'codesigner' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' =>[
					'enable_hyperlink' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * add to cart button
		 */
		$this->start_controls_section(
			'gradient_button_style',
			[
				'label' => __( 'Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'gradient_button_typographyrs',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .wl-gradient-button',
			]
		);

		$this->start_controls_tabs(
			'gradient_button_button',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'gradient_button_normal',
			[
				'label' 	=> __( 'Normal', 'codesigner' ),
			]
		);

        $this->add_control(
			'gradient_button_color',
			[
				'label' 	=> __( 'Text Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-gradient-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gradient_button_bg',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-gradient-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'gradient_button_border',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '{{WRAPPER}} .wl-gradient-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'gradient_button_hover',
			[
				'label' 	=> __( 'Hover', 'codesigner' ),
			]
		);

        $this->add_control(
			'gradient_button_hover_color',
			[
				'label' 	=> __( 'Text Color', 'codesigner' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-gradient-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gradient_button_hover_bg',
				'label' => __( 'Background', 'codesigner' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-gradient-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'gradient_button_border_hover',
				'label'         => __( 'Border', 'codesigner' ),
				'selector'      => '{{WRAPPER}} .wl-gradient-button:hover',
			]
		);

		$this->add_control(
			'gradient_button_hover_transition',
			[
				'label' 	=> __( 'Transition Duration', 'codesigner' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 3,
						'step' 	=> 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-gradient-button:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'gradient_button_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gradient-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'gradient_button_margin',
			[
				'label' 		=> __( 'Margin', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gradient-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gradient_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'codesigner' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-gradient-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'gradient_button_box_shadow',
				'label' => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-gradient-button',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->add_render_attribute( 'button', 'class', 'wl-gradient-button-area' );

		$target 	= isset( $gb_link['is_external'] ) && $gb_link['is_external'] ? ' target="_blank"' : '';
		$nofollow 	= isset( $gb_link['nofollow'] ) && $gb_link['nofollow'] ? ' rel="nofollow"' : '';
		$href 		= isset( $gb_link['url'] ) ? $gb_link['url'] : '#';
		?>

		<div <?php echo esc_attr( $this->get_render_attribute_string( 'button' ) ); ?> >
			<a class="wl-gradient-button" href="<?php echo esc_url( $href ) ; ?>" <?php echo esc_attr( $target ).' '. esc_attr( $nofollow ) ?> >
				<?php if ( 'left' == $gradient_button_icon_align ): ?>
					<i class="<?php echo esc_attr( $gradient_button_icon['value'] ); ?>" aria-hidden="true"></i>
					<?php echo esc_html( $gradient_button_text ); ?>				
				<?php else: ?>
					<?php echo esc_html( $gradient_button_text ); ?>
					<i class="<?php echo esc_attr( $gradient_button_icon['value'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</a>
		</div>
		<?php

		do_action( 'codesigner_after_main_content', $this );
	}
}
