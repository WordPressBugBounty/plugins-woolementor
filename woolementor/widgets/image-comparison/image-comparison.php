<?php
namespace Codexpert\CoDesigner;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Image_Comparison extends Widget_Base {

	public $id;
	public $widget;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );

		// Are we in debug mode?
		$min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

		wp_register_style( "codesigner-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), array(), '1.1' );
	}

	public function get_script_depends() {
		return array( "codesigner-{$this->id}" );
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
		 * Image controls
		 */
		$this->start_controls_section(
			'imgcomp_image',
			array(
				'label' => __( 'Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'imgcomp_first_image',
			array(
				'label'   => esc_html__( 'First Image', 'codesigner' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'imgcomp_second_image',
			array(
				'label'   => esc_html__( 'Second Image', 'codesigner' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'imgcomp_slide_icon',
			array(
				'label' => __( 'Icon', 'codesigner' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->end_controls_section();

		/**
		 * Image style
		 */
		$this->start_controls_section(
			'imgcomp_image_style',
			array(
				'label' => __( 'Image', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_box_height',
			array(
				'label'      => __( 'Image Box Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-container' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 100,
					),
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-img img' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 100,
					),
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_height',
			array(
				'label'      => __( 'Image Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-img img' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 100,
					),
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'imgcomp_image_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-img-comp-img img',
			)
		);

		$this->add_responsive_control(
			'imgcomp_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'imgcomp_image_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-img-comp-img img',
			)
		);

		$this->end_controls_section();

		/**
		 * Slider style
		 */
		$this->start_controls_section(
			'imgcomp_slider_style',
			array(
				'label' => __( 'Slider', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'imgcomp_icon_heading',
			array(
				'label' => esc_html__( 'Icon', 'codesigner' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'imgcomp_icon_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_icon_size',
			array(
				'label'      => __( 'Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'imgcomp_slider_heading',
			array(
				'label'     => esc_html__( 'Slider', 'codesigner' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'imgcomp_slider_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_slider_width',
			array(
				'label'      => __( 'Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_responsive_control(
			'imgcomp_slider_height',
			array(
				'label'      => __( 'Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
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
				'name'     => 'imgcomp_slider_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-img-comp-slider',
			)
		);

		$this->add_responsive_control(
			'imgcomp_slider_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-img-comp-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = $this->id;

		extract( $settings );
		?>
		<div class="wl-image-comparison-panel">
			<div class="wl-img-comp-container">
				<div class="wl-img-comp-img">
					<img src="<?php echo esc_url( $imgcomp_first_image['url'] ); ?>">
				</div>
				<div class="wl-img-comp-img wl-img-comp-overlay">
					<img src="<?php echo esc_url( $imgcomp_second_image['url'] ); ?>">
				</div>
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
		$settings = $this->get_settings_for_display();
		extract( $settings );

		$section_id = $this->get_raw_data()['id'];
		?>

		<script type="text/javascript">
			jQuery(function($){
				function initComparisons() {
					var x, i;

					x = document.getElementsByClassName("wl-img-comp-overlay");
					for (i = 0; i < x.length; i++) {
						compareImages(x[i]);
					}
					function compareImages(img) {
						var slider, img, clicked = 0, w, h;

						w = img.offsetWidth;
						h = img.offsetHeight;

						img.style.width = (w / 2) + "px";

						slider = document.createElement("DIV");
						slider.setAttribute("class", "wl-img-comp-slider");
						slider.innerHTML = '<i class="<?php echo esc_js( $imgcomp_slide_icon['value'] ); ?>"></i>';

						img.parentElement.insertBefore(slider, img);

						slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
						slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";

						slider.addEventListener("mousedown", slideReady);

						window.addEventListener("mouseup", slideFinish);

						slider.addEventListener("touchstart", slideReady);

						window.addEventListener("touchend", slideFinish);
						function slideReady(e) {

							e.preventDefault();

							clicked = 1;

							window.addEventListener("mousemove", slideMove);
							window.addEventListener("touchmove", slideMove);
						}
						function slideFinish() {

							clicked = 0;
						}
						function slideMove(e) {
							var pos;

							if (clicked == 0) return false;

							pos = getCursorPos(e)

							if (pos < 0) pos = 0;
							if (pos > w) pos = w;

							slide(pos);
						}
						function getCursorPos(e) {
							var a, x = 0;
							e = (e.changedTouches) ? e.changedTouches[0] : e;

							a = img.getBoundingClientRect();

							x = e.pageX - a.left;

							x = x - window.pageXOffset;
							return x;
						}
						function slide(x) {

							img.style.width = x + "px";

							slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";
						}
					}
				}
				initComparisons();
			})
		</script>

		<?php
	}
}