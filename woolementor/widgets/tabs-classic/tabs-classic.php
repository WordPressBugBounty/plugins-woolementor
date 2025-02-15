<?php
namespace Codexpert\CoDesigner;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Tabs_Classic extends Widget_Base {

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
			'tab_bg_color',
			[
				'label' 		=> __( 'Color', 'codesigner' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'after',
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
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'codesigner' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
				'show_label' 	=> false,
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
						'tab_bg_color' 	=> '#E9345F',
						'tab_content' 	=> __( 'Item content of Tab #1. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'codesigner' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'codesigner' ),
						'tab_bg_color' 	=> '#4054B2',
						'tab_content' 	=> __( 'Item content of Tab #2. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'codesigner' ),
					],
					[
						'tab_name' 		=> __( 'Tab #3', 'codesigner' ),
						'tab_bg_color' 	=> '#FF7B00',
						'tab_content' 	=> __( 'Item content of Tab #3. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'codesigner' ),
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
				'label' 	=> __( 'Typography', 'codesigner' ),
				'selector' 	=> '{{WRAPPER}} .wl-tc-tab .wl-tc-tab-title',
				'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 600 ],
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tab_shadow',
				'label' => __( 'Tab Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-tc-tab, {{WRAPPER}} .wl-tc-panels',
			]
		);


		$this->add_control(
			'panel_width',
			[
				'label' => __( 'Width', 'codesigner' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tc-panels' => 'width: {{SIZE}}{{UNIT}};',
				],
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
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tc-panels' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        $post_id 	= get_the_ID();
        $style 		= '';
        $section_id = $this->get_raw_data()['id'];
        ?>

        <div class="wl-tc-wrapper wl-<?php echo esc_attr( $section_id ); ?>-tc-wrapper">

	        <?php $tab_count = 0; foreach ( $settings['tabs_list'] as $key => $tab ) : 
	        	$checked = '';
	        	if ( $tab_count == 0 ) {
	        		$checked = 'checked';
	        	}
	        	?>
	        	<input class="wl-tc-radio wl-tc-<?php echo esc_attr( $tab['_id'] ); ?>-radio" id="<?php echo esc_attr( $tab['_id'] ); ?>" name="wl_tabs_classic-<?php echo esc_attr( $section_id ); ?>" type="radio" data-id="<?php echo esc_attr( $tab['_id'] ); ?>" <?php echo esc_html( $checked ); ?>>
	        <?php $tab_count++; endforeach; ?>

	        <div class="wl-tc-tabs">
	        	<?php $tab_count = 0; foreach ( $settings['tabs_list'] as $key => $tab ) : 
	        		$wl_class = '';
	        		if ( $tab_count == 0 ) {
	        			$wl_class = 'wl-tc-tab-active';
	        		}
	        		$style .= "
	        		.wl-tc-{$tab['_id']}-tab{background-color:{$tab['tab_bg_color']}}
	        		.wl-tc-tabs .wl-tc-{$tab['_id']}-tab.wl-tc-tab-active .wl-tc-tab-title{color:{$tab['tab_bg_color']} !important}
	        		.wl-tc-{$tab['_id']}-tab.wl-tc-tab-active{border-color:{$tab['tab_bg_color']} !important}";
	        		?>
	        		<label id="<?php echo esc_attr( $tab['_id'] ); ?>" style="background: <?php echo esc_attr( $tab['tab_bg_color'] ); ?>;"
	        		class="wl-tc-tab wl-tc-<?php echo esc_attr( $tab['_id'] ); ?>-tab <?php echo esc_attr( $wl_class ); ?>"  
	        		for="<?php echo esc_attr( $tab['_id'] ); ?>"><span class="wl-tc-tab-title"><?php echo esc_html( $tab['tab_name'] );?></span></label>
	        	<?php $tab_count++; endforeach; ?>
	        </div>

	        <div class="wl-tc-panels">
	        	<?php $tab_count = 0; foreach ( $settings['tabs_list'] as $key => $tab ) : 
	        		$wl_class = '';
	        		if ( $tab_count == 0 ) {
	        			$wl_class = 'wl-tc-panel-active';
	        		}
	        		?>
	        		<div class="wl-tc-panel wl-tc-<?php echo esc_attr( $tab['_id'] ); ?>-panel <?php echo esc_attr( $wl_class ); ?>">
	        			<?php 
		        		if ( 'static_texts' == $tab['tab_content_source'] ) {
		        			echo wp_kses_post( wpautop( $tab['tab_content'] ) ); 
		        		}
		        		else{
		        			$value = get_post_meta( $post_id, $tab['tab_content_meta'], true );
		        			
		        			if ( !is_array( $value ) ) {
		        				echo esc_html( $value );
		        			}
		        			else{
		        				esc_html_e( 'Array', 'codesigner' );
		        			}
		        		}
		        		?>
	        		</div>
	        	<?php $tab_count++; endforeach;?>
	        </div>

    	</div>

    	<style>
	    	<?php echo esc_html( $style ); ?>
	    </style>
    		
		<?php

		do_action( 'codesigner_after_main_content', $this );
		
		/**
         * Load Script
         */
        $this->render_script();
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
        extract( $settings );
        $section_id = $this->get_raw_data()['id'];
		?>
		<script type="text/javascript">
			jQuery(function($){
				$('.wl-<?php echo esc_js( $section_id ); ?>-tc-wrapper .wl-tc-radio').on('click',function(e){
					var $this = $( this );
					var par = $this.closest('.wl-tc-wrapper');
	    			var id = $this.data( 'id' );
	    			if( $(this).is(":checked") ) {
	    				$( '.wl-tc-tab', par ).removeClass('wl-tc-tab-active');
	    				$( '.wl-tc-'+id+'-tab', par ).addClass('wl-tc-tab-active');
	    				$( '.wl-tc-panel', par ).removeClass('wl-tc-panel-active');
	    				$( '.wl-tc-'+id+'-panel', par ).addClass('wl-tc-panel-active');
	    			}
	    		})
			})
		</script>
		<?php
	}
}