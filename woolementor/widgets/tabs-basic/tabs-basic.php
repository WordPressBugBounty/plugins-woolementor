<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Tabs_Basic extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';
		wp_enqueue_script("jquery-ui-tabs");

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "codesigner-{$this->id}", 'fancybox' ];
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
		 * Settings controls
		 */
		$this->start_controls_section(
			'_section_settings_tabs',
			[
				'label' => __( 'Tabs', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_name', [
				'label' 		=> __( 'Title & Description', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Tab Title' , 'codesigner' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'tab_content_source',
			[
				'label' 		=> __( 'Content Source', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'static_texts'	=> __( 'Static Texts', 'codesigner' ),
					'post_meta'  	=> __( 'Post Meta', 'codesigner' ),
				],
				'default' 		=> 'static_texts',
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'codesigner' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Tabs Content' , 'codesigner' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
			]
		);

		$repeater->add_control(
			'tab_content_meta',
			[
				'label' 		=> __( 'Meta Key', 'codesigner' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_meta_keys(),
				'condition' 	=> [
                    'tab_content_source' => 'post_meta'
                ],
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' 		=> __( 'Tabs List', 'codesigner' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'tab_name' 		=> __( 'Tab #1', 'codesigner' ),
						'tab_content' 	=> __( 'Item content. Click the edit button to change this text.', 'codesigner' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'codesigner' ),
						'tab_content' 	=> __( 'Item content. Click the edit button to change this text.', 'codesigner' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->add_control(
			'tabs_type',
			[
				'label' => __( 'Type', 'codesigner' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wl-horizontal',
				'options' => [
					'wl-horizontal'	=> __( 'Horizontal', 'codesigner' ),
					'wl-vertical'	=> __( 'Vertical', 'codesigner' ),
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		/**
		 * Tabs Style
		 */
		$this->start_controls_section(
			'section_style_tabs',
			[
				'label' => __( 'Tabs', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navigation_width',
			[
				'label' => __( 'Navigation Width', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pt-navigation-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tabs_type' => 'wl-vertical'
				],
			]
		);

        $this->add_control(
			'tabs_nav_border_color',
			[
				'label' 		=> __( 'Border Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .wl-pt-navigation-wrapper ul' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tabs_nav_border_size',
			[
				'label' => __( 'Border Size', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-pt-navigation-wrapper ul' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_nav_padding',
			[
				'label' 		=> __( 'Padding', 'codesigner' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Tabs Title
		 */
		$this->start_controls_section(
			'section_style_tabs_title',
			[
				'label' => __( 'Title', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography_normal',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'selector' 	=> '{{WRAPPER}} .wl-pt-navigation-wrapper li a',
				'fields_options'    	=> [
                    'typography'    	=> [ 'default' => 'yes' ],
                    'font_size'     	=> [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   	=> [ 'default' => 'Montserrat' ],
                    'font_weight'   	=> [ 'default' => 600 ],
                    'text_decoration' 	=> [ 'default' => 'none']
                ]
			]
		);

		$this->start_controls_tabs(
			'section_style_tabs_tabs',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'section_style_tabs_normal',
			[
				'label' 	=> __( 'Normal', 'codesigner' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'tabs_title_color_normal',
                'selector' => '{{WRAPPER}} .wl-pt-navigation-wrapper li a',
            ]
        );

        $this->add_control(
			'tabs_nav_bg_color_normal',
			[
				'label' 		=> __( 'Background', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'section_style_tabs_active',
			[
				'label' 	=> __( 'Active', 'codesigner' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'tabs_title_color_active',
                'selector' => '{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a',
            ]
        );

        $this->add_control(
			'tabs_nav_bg_color_active',
			[
				'label' 		=> __( 'Background', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Tabs Content
		 */
		$this->start_controls_section(
			'section_style_tabs_content',
			[
				'label' => __( 'Content', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography_content_normal',
				'label' 	=> __( 'Typography', 'codesigner' ),
				'selector' 	=> '{{WRAPPER}} .wl-pt-content-wrapper',
				'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ]
			]
		);

		$this->add_control(
			'tabs_content_text_color_normal',
			[
				'label' 		=> __( 'Font Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'tabs_content_bg_color_normal',
			[
				'label' 		=> __( 'Background', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        $post_id 	= get_the_ID();
        ?>

        <div class="wl-product-tabs <?php echo esc_attr( $settings['tabs_type'] ); ?>">
        	<div class="wl-pt-navigation-wrapper">
	        	<ul>
	        		<?php 
						foreach ( $settings['tabs_list'] as $tab ) {
							?>
								<li><a href="#tab-<?php echo esc_attr( $tab['_id'] ); ?>"><?php echo esc_html( $tab['tab_name'] ); ?></a></li>
							<?php
						}
	        		?>
	        	</ul>
        	</div>
			
			<div class="wl-pt-content-wrapper">

        		<?php foreach ( $settings['tabs_list'] as $tab ): ?>
        			<div id="tab-<?php echo esc_attr( $tab['_id'] ); ?>">
		        		<?php 
		        		if ( 'static_texts' == $tab['tab_content_source'] ) {
		        			echo wp_kses_post( wpautop( $tab['tab_content'] ) ); 
		        		}
		        		else{
		        			$value = get_post_meta( $post_id, $tab['tab_content_meta'], true );
		        			
		        			if ( !is_array( $value ) ) {
		        				echo wp_kses_post( $value );
		        			}
		        			else{
		        				esc_html_e( 'Array', 'codesigner' );
		        			}
		        		}
		        		?>
		        	</div>
        		<?php endforeach; ?>
	        	
			</div>
        </div>

		<?php

		do_action( 'codesigner_after_main_content', $this );
		
		/**
         * Load Script
         */
        $this->render_script();
	}

	protected function render_script() {
		?>
		<script type="text/javascript">
			jQuery(function($){
				$( ".wl-product-tabs" ).tabs();
			})
		</script>
		<?php
	}
}