<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Gallery_Box_Slider extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), '1.1' );
	}

	public function get_script_depends() {
		return array( "codesigner-{$this->id}", 'box-slider', 'modernizr' );
	}

	public function get_style_depends() {
		return array( "codesigner-{$this->id}" );
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
			'_section_settings',
			array(
				'label' => __( 'Animation', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'animation_effect',
			array(
				'label'   => __( 'Animation Effect', 'codesigner' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => array(
					// 'scrollVert3d'  => __( 'Scroll Vertical 3D', 'codesigner' ),
					// 'scrollHorz3d'  => __( 'Scroll Horizontal 3D', 'codesigner' ),
					'tile3d'     => __( 'Tile 3D', 'codesigner' ),
					'tile'       => __( 'Tile', 'codesigner' ),
					'scrollVert' => __( 'Scroll Vertical', 'codesigner' ),
					'scrollHorz' => __( 'Scroll Horizontal', 'codesigner' ),
					'blindLeft'  => __( 'Blind Left', 'codesigner' ),
					'blindDown'  => __( 'Blind Down', 'codesigner' ),
					'fade'       => __( 'Fade', 'codesigner' ),
				),
				'default' => 'scrollHorz',
			)
		);

		$this->add_control(
			'animation_responsive',
			array(
				'label'        => __( 'Responsive', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'codesigner' ),
				'label_off'    => __( 'Off', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		// $this->add_control(
		// 'animation_pauseOnHover',
		// [
		// 'label'         => __( 'PauseOnHover', 'codesigner' ),
		// 'type'          => Controls_Manager::SWITCHER,
		// 'label_on'      => __( 'On', 'codesigner' ),
		// 'label_off'     => __( 'Off', 'codesigner' ),
		// 'return_value'  => 'yes',
		// 'default'       => 'yes',
		// ]
		// );

		$this->add_control(
			'animation_autoScroll',
			array(
				'label'        => __( 'AutoScroll', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'codesigner' ),
				'label_off'    => __( 'Off', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'   => __( 'Speed', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 800,
			)
		);

		$this->add_control(
			'animation_timeout',
			array(
				'label'   => __( 'Timeout', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->add_control(
			'animation_perspective',
			array(
				'label'   => __( 'Perspective', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000,
			)
		);

		$this->end_controls_section();

		/**
		 * Image Gallery
		 */
		$this->start_controls_section(
			'section_image_gallery',
			array(
				'label' => __( 'Gallery', 'plugin-name' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image_source',
			array(
				'label'       => __( 'Image Source', 'codesigner' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => array(
					'current_product'  => __( 'From Current Product', 'codesigner' ),
					'custom_selection' => __( 'Custom Selection', 'codesigner' ),
				),
				'default'     => array( 'current_product' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'image_gallery_current_product',
			array(
				'label'     => __( 'Add Images', 'codesigner' ),
				'type'      => Controls_Manager::GALLERY,
				'default'   => wcd_product_gallery_images( get_the_ID() ),
				'condition' => array(
					'image_source' => 'current_product',
				),
			)
		);

		$this->add_control(
			'image_gallery_custom_selection',
			array(
				'label'     => __( 'Add Images', 'codesigner' ),
				'type'      => Controls_Manager::GALLERY,
				'condition' => array(
					'image_source' => 'custom_selection',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => __( 'Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'image_thumbnail',
				'default' => 'full',
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => __( 'Image Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #wl-gbs-box' => 'height: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .wl-gbs-box > .wl-gbs-slide img' => 'height: {{SIZE}}{{UNIT}} !important',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #wl-gbs-box' => 'width: {{SIZE}}{{UNIT}} !important',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-gbs-slide img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-gbs-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-gbs-slide img',
			)
		);

		$this->add_control(
			'image_box_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-gbs-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_control(
			'image_box_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-gbs-slide' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'image_effects',
			array(
				'separator' => 'before',
			)
		);

		$this->start_controls_tab(
			'image_effects_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'image_opacity',
			array(
				'label'     => __( 'Opacity', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wl-gbs-slide img' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters',
				'selector' => '{{WRAPPER}} .wl-gbs-slide img',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'image_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'image_opacity_hover',
			array(
				'label'     => __( 'Opacity', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wl-gbs-slide img:hover' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .wl-gbs-slide img:hover',
			)
		);

		$this->add_control(
			'image_hover_transition',
			array(
				'label'     => __( 'Transition Duration', 'codesigner' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wl-gbs-slide img:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );

		if ( 'custom_selection' == $image_source ) {
			$image_gallery = $image_gallery_custom_selection;
		} else {
			$image_gallery = $image_gallery_current_product;
		}

		if ( count( $image_gallery ) > 0 ) :
			?>
		
		<div class="wl-gbs-gallery">
			<section>
				<div id="wl-gbs-viewport">
					<div id="wl-gbs-box" class="wl-gbs-box">

						<?php
						foreach ( $image_gallery as $image ) :
							$thumbnail = wp_get_attachment_image_src( $image['id'], $image_thumbnail_size );

							?>
								<div class="wl-gbs-slide">
								<img src="<?php echo esc_url( $thumbnail[0] ); ?>" />
								</div>
							<?php
						endforeach;
						?>

					</div>
				</div>
			</section>
		</div>
		
			<?php
		endif;

		do_action( 'codesigner_after_main_content', $this );

		/**
		 * Load Script
		 */
		$this->render_script( $settings );
	}

	protected function render_script( $settings ) {

		$_config = array(
			'animation_effect'      => $settings['animation_effect'],
			'animation_responsive'  => $settings['animation_responsive'],
			// 'animation_pauseOnHover' => $settings['animation_pauseOnHover'],
			'animation_autoScroll'  => $settings['animation_autoScroll'],
			'animation_speed'       => $settings['animation_speed'],
			'animation_timeout'     => $settings['animation_timeout'],
			'animation_perspective' => $settings['animation_perspective'],
		);
		?>

		<script>
			$ = new jQuery.noConflict()
			$(function($){
				var config 	= <?php echo wp_json_encode( $_config ); ?>;

				$('.wl-gbs-box').boxSlider({
					effect: config.animation_effect,
					responsive: config.animation_responsive,
					// pauseOnHover: config.animation_pauseOnHover,
					autoScroll: config.animation_autoScroll, 
					speed: parseInt(config.animation_speed),
					timeout: parseInt(config.animation_timeout),
					perspective: parseInt(config.animation_perspective),
				});
			})
		</script>
		<?php
	}
}
