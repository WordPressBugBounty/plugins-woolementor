<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Tabs_Beauty extends Widget_Base {

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
				'label' 		=> __( 'Title', 'codesigner' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Tab Title' , 'codesigner' ),
				'label_block' 	=> true,
			]
		);

        $repeater->add_control(
			'tab_text_color',
			[
				'label' 		=> __( 'Text Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'before',
			]
		);

        $repeater->add_control(
			'tab_bg_color',
			[
				'label' 		=> __( 'Tab Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'after',
				// 'default'		=> null,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'codesigner' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'codesigner' ),
				'show_label' 	=> false,
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
						'tab_bg_color' 	=> '#E9345F',
						'tab_content' 	=> __( 'Item content of Tab #1. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'codesigner' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'codesigner' ),
						'tab_bg_color' 	=> '#4139AA',
						'tab_content' 	=> __( 'Item content of Tab #2. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'codesigner' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->end_controls_section();

		/**
		*Tab items control
		*/
		$this->start_controls_section(
			'_section_tabs_style',
			[
				'label' => __( 'Tabs', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography',
				'label' 	=> __( 'Title Typography', 'codesigner' ),
				'selector' 	=> '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-title',
				'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 600 ],
                ]
			]
		);

		$this->add_control(
		    'tabs_title_alignment',
		    [
		        'label'     => __( 'Title Alignment', 'codesigner' ),
		        'type'      => Controls_Manager::CHOOSE,
		        'options'   => [
		            'left'      => [
		                'title'     => __( 'Left', 'codesigner' ),
		                'icon'      => 'eicon-text-align-left',
		            ],
		            'center'    => [
		                'title'     => __( 'Center', 'codesigner' ),
		                'icon'      => 'eicon-text-align-center',
		            ],
		            'right'     => [
		                'title'     => __( 'Right', 'codesigner' ),
		                'icon'      => 'eicon-text-align-right',
		            ],
		        ],
		        'default'   => 'left',
		        'toggle'    => true,
		        'selectors' => [
		            '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-title' => 'text-align: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_content_typography',
				'label' 	=> __( 'Content Typography', 'codesigner' ),
				'selector' 	=> '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-description',
				'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 15 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ]
			]
		);

		$this->add_control(
			'panel_height',
			[
				'label' => __( 'Height', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tab-beauty' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        $style 		= '';
        $tabs 		= count( $settings['tabs_list'] );
        $section_id = $this->get_raw_data()['id'];
        ?>

        <div class="wl-tab-beauty">
        	<?php $tab_count = 0; foreach ( $settings['tabs_list'] as $key => $tab ): 
        		$checked 	= '';
	        	$top 		= $tab_count * ( 100 / (int)$tabs );
	        	$tab_height = $top;
	        	if ( $tab_count == 0 ) {
	        		$checked 	= 'checked';
	        		$tab_height = ( 100 / (int)$tabs );
	        	}

	        	if( $tab['tab_bg_color'] == '' ) {
	        		$tab['tab_bg_color'] = '#' . str_pad( dechex( mt_rand( 0, 0xFFFFFF ) ), 6, '0', STR_PAD_LEFT );
	        	}

	        	$style .= "
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content{background-color:{$tab['tab_bg_color']} !important}
	        		.wl .wl-tab-beauty .wl-tb-radio.wl-tb-{$tab['_id']}-radio{
	        			outline-color:{$tab['tab_bg_color']} !important;
	        			top: {$top}%;
	        			height: {$tab_height}%;
	        		}
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content .wl-tb-title{color:{$tab['tab_text_color']}}
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content .wl-tb-description{color:{$tab['tab_text_color']}}
	        		";
        	?>

    		<input class="wl-tb-radio wl-tb-<?php echo esc_attr( $tab['_id'] ); ?>-radio" type="radio" name="wl_tabs_beauty_<?php echo esc_attr( $section_id ); ?>" <?php echo esc_html( $checked ); ?>>
    		<div class="wl-tb-content wl-tb-<?php echo esc_attr( $tab['_id'] ); ?>-content">
    			<h4 class="wl-tb-title"><?php echo esc_html( $tab['tab_name'] ); ?></h4>
    			<div class="wl-tb-description">
    				<?php echo wp_kses_post( wpautop( $tab['tab_content'] ) ); ?>
    			</div>
    		</div>
        	<?php $tab_count++; endforeach; ?>
        </div>

    	<style>
	    	<?php echo esc_html( $style ); ?>
	    </style>
		<?php

		do_action( 'codesigner_after_main_content', $this );
	}
}