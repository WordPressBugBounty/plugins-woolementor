<?php
namespace Codexpert\CoDesigner;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class customer_Reviews_Classic extends Widget_Base {

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
		return array( "codesigner-{$this->id}", 'slick' );
	}

	public function get_style_depends() {
		return array( "codesigner-{$this->id}", 'slick' );
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
		 * Components
		 */
		$this->start_controls_section(
			'section_content_components',
			array(
				'label' => __( 'Components', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'review_name_switcher',
			array(
				'label'        => __( 'Name', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'review_description_switcher',
			array(
				'label'        => __( 'Description', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'review_rating_switcher',
			array(
				'label'        => __( 'Start Rating', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'review_comment_switcher',
			array(
				'label'        => __( 'Comment', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'review_date_switcher',
			array(
				'label'        => __( 'Date', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'review_photo_switcher',
			array(
				'label'        => __( 'Photo', 'codesigner' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'codesigner' ),
				'label_off'    => __( 'Hide', 'codesigner' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * repeater
		 */
		$this->start_controls_section(
			'review_section_repeater',
			array(
				'label' => __( 'Reviews', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'review_repeater_name',
			array(
				'label'       => __( 'Name', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'John Doe', 'codesigner' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'review_repeater_description',
			array(
				'label'       => __( 'Description', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Dhaka, Bangladesh', 'codesigner' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'review_repeater_rating',
			array(
				'label'   => __( 'Rating (Out of 5)', 'codesigner' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'default' => 4,
			)
		);

		$repeater->add_control(
			'review_repeater_date',
			array(
				'label'          => __( 'Date', 'codesigner' ),
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'enableTime' => false,
					'dateFormat' => 'j F, Y',
				),
				'default'        => date( 'j F, Y' ),
			)
		);

		$repeater->add_control(
			'review_repeater_comment',
			array(
				'label'   => __( 'Comment', 'codesigner' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'codesigner' ),
			)
		);

		$repeater->add_control(
			'review_repeater_photo',
			array(
				'label'   => __( 'Photo', 'codesigner' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'review_photo_align',
			array(
				'label'     => __( 'Photo Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'wl-left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'fa fa-align-left',
					),
					'wl-center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'fa fa-align-center',
					),
					'wl-right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'wl-center',
				'toggle'    => true,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'review_repeater_items',
			array(
				'label'       => __( 'Review List', 'codesigner' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'review_repeater_name'    => __( 'John Doe', 'codesigner' ),
						'review_repeater_comment' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'codesigner' ),
					),
					array(
						'review_repeater_name'    => __( 'Jane Doe', 'codesigner' ),
						'review_repeater_comment' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'codesigner' ),
					),
					array(
						'review_repeater_name'    => __( 'John Roe', 'codesigner' ),
						'review_repeater_comment' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'codesigner' ),
					),
				),
				'title_field' => '{{{ review_repeater_name }}}',
			)
		);

		$this->end_controls_section();

		/**
		 * Animation
		 */
		$this->start_controls_section(
			'section_content_settings',
			array(
				'label' => __( 'Slider Animation', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'              => __( 'Animation Speed', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 10,
				'max'                => 10000,
				'default'            => 300,
				'description'        => __( 'Slide speed in milliseconds', 'codesigner' ),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'              => __( 'Autoplay?', 'codesigner' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'codesigner' ),
				'label_off'          => __( 'No', 'codesigner' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'              => __( 'Autoplay Speed', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 100,
				'max'                => 10000,
				'default'            => 3000,
				'description'        => __( 'Autoplay speed in milliseconds', 'codesigner' ),
				'condition'          => array(
					'autoplay' => 'yes',
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'infinite_loop',
			array(
				'label'              => __( 'Infinite Loop?', 'codesigner' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'codesigner' ),
				'label_off'          => __( 'No', 'codesigner' ),
				'return_value'       => true,
				'default'            => true,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'              => __( 'Navigation', 'codesigner' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'none'  => __( 'None', 'codesigner' ),
					'arrow' => __( 'Arrow', 'codesigner' ),
					'dots'  => __( 'Dots', 'codesigner' ),
					'both'  => __( 'Arrow & Dots', 'codesigner' ),
				),
				'default'            => 'none',
				'frontend_available' => true,
				'style_transfer'     => true,
			)
		);

		$this->add_responsive_control(
			'slides_show',
			array(
				'label'              => __( 'Show at Once', 'codesigner' ),
				'type'               => Controls_Manager::NUMBER,
				'max'                => 12,
				'desktop_default'    => 3,
				'tablet_default'     => 2,
				'mobile_default'     => 1,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'arrow_icon_left',
			array(
				'label'     => __( 'Arrow Icon Left', 'text-domain' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fa fa-chevron-left',
					'library' => 'solid',
				),
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
			)
		);

		$this->add_control(
			'arrow_icon_right',
			array(
				'label'     => __( 'Arrow Icon Right', 'text-domain' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fa fa-chevron-right',
					'library' => 'solid',
				),
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style
		 * Card
		 */
		$this->start_controls_section(
			'_section_review_card_style',
			array(
				'label' => __( 'Card', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'review_card_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'review_card_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'review_card_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-single' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'review_card_background_tabs_hr',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'review_card_background_heading',
			array(
				'label' => __( 'Background', 'codesigner' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'review_card_background_tabs' );

		$this->start_controls_tab(
			'review_card_background_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'review_card_border_normal',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-single',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'review_card_background_normal',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-single',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'review_card_background_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'review_card_border_hover',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-single:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'review_card_background_hover',
				'label'    => __( 'Background', 'codesigner' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-single:hover',
			)
		);

		$this->add_control(
			'review_card_background_hover_transition',
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
					'{{WRAPPER}} .wl-crvc-review-single:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Name
		 */
		$this->start_controls_section(
			'review_name',
			array(
				'label'     => __( 'Name', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_name_switcher' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			array(
				'name'     => 'review_name_color',
				'selector' => '{{WRAPPER}} .wl-crvc-review-author h3',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_name_typographyrs',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-crvc-review-author h3',
			)
		);

		$this->end_controls_section();

		/**
		 * Description
		 */
		$this->start_controls_section(
			'review_description',
			array(
				'label'     => __( 'Description', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_name_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'review_description_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-crvc-review-author-details span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_description_typographyrs',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-crvc-review-author-details span',
			)
		);

		$this->end_controls_section();

		/**
		 * Date
		 */
		$this->start_controls_section(
			'review_date',
			array(
				'label'     => __( 'Date', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_date_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'review_date_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-crvc-review-date' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_date_typographyrs',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-crvc-review-date',
			)
		);

		$this->end_controls_section();

		/**
		 * star_rating
		 */
		$this->start_controls_section(
			'review_rating',
			array(
				'label'     => __( 'Rating', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_rating_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'review_rating_blockicon',
			array(
				'label'   => __( 'Block Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'review_rating_half_blockicon',
			array(
				'label'   => __( 'Half Block Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star-half-alt',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'review_rating_empty_icon',
			array(
				'label'   => __( 'Empty Icon', 'codesigner' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'far fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_responsive_control(
			'review_rating_icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'review_rating_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-crvc-review-author-rating span strong' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'review_rating_box_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '{{WRAPPER}} .wl-crvc-review-author-rating',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'review_rating_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'review_rating_box_bg_color',
			array(
				'label'     => __( 'Box Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'review_rating_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-author-rating',
			)
		);

		$this->add_control(
			'review_rating_box_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'review_rating_box_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-author-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Comment
		 */
		$this->start_controls_section(
			'review_comment',
			array(
				'label'     => __( 'Comment', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_comment_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'review_comment_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wl-crvc-review-details p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'review_comment_typographyrs',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .wl-crvc-review-details p',
			)
		);

		$this->end_controls_section();

		/**
		 * User Image controls
		 */
		$this->start_controls_section(
			'review_photo',
			array(
				'label'     => __( 'Photo', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'review_photo_switcher' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'review_photo_thumbnail',
				'default' => 'thumbnail',
			)
		);

		$this->add_responsive_control(
			'review_photo_width',
			array(
				'label'      => __( 'Image Width', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-img img' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_responsive_control(
			'review_photo_height',
			array(
				'label'      => __( 'Image Height', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-img img' => 'height: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
			)
		);

		$this->add_control(
			'review_photo_offset_toggle',
			array(
				'label'        => __( 'Offset', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'review_photo_image_transform_x',
			array(
				'label'      => __( 'Image Transform X', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-img' => 'top: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
				),
				'condition'  => array(
					'review_photo_offset_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'review_photo_image_transform_Y',
			array(
				'label'      => __( 'Image Transform Y', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-img' => 'left: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
				),
				'condition'  => array(
					'review_photo_offset_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'review_photo_border',
				'label'    => __( 'Border', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-img img',
			)
		);

		$this->add_responsive_control(
			'review_photo_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'review_photo_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '{{WRAPPER}} .wl-crvc-review-img img',
			)
		);

		$this->end_controls_section();

		/**
		 * Navigation - Arrow
		 */
		$this->start_controls_section(
			'_section_style_arrow',
			array(
				'label'     => __( 'Navigation Arrow', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation' => array( 'arrow', 'both' ),
				),
			)
		);

		$this->add_control(
			'arrow_position_toggle',
			array(
				'label'        => __( 'Position', 'codesigner' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'codesigner' ),
				'label_on'     => __( 'Custom', 'codesigner' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'arrow_position_y',
			array(
				'label'      => __( 'Vertical', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'arrow_position_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_position_x',
			array(
				'label'      => __( 'Horizontal', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'arrow_position_toggle' => 'yes',
				),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 250,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-next' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_popover();

		$this->add_responsive_control(
			'arrow_icon_size',
			array(
				'label'      => __( 'Icon Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-silder .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wl-crvc-review-silder .slick-prev' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_area_size',
			array(
				'label'      => __( 'Area Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-silder .slick-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-crvc-review-silder .slick-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'arrow_border',
				'selector' => '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next',
			)
		);

		$this->add_responsive_control(
			'arrow_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				),
			)
		);

		$this->start_controls_tabs( '_tabs_arrow' );

		$this->start_controls_tab(
			'_tab_arrow_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_arrow_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'arrow_hover_color',
			array(
				'label'     => __( 'Icon Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_bg_color',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'arrow_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrow_hover_transition',
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
					'{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Navigation - Dots
		 */
		$this->start_controls_section(
			'_section_style_dots',
			array(
				'label'     => __( 'Navigation Dots', 'codesigner' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation' => array( 'dots', 'both' ),
				),
			)
		);

		$this->add_responsive_control(
			'arrow_dots_size',
			array(
				'label'      => __( 'Dots Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .wl-crvc-review-silder .slick-dots li button::before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_position_y',
			array(
				'label'      => __( 'Vertical Position', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_spacing',
			array(
				'label'      => __( 'Spacing', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots li' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
				),
			)
		);

		$this->add_responsive_control(
			'dots_nav_align',
			array(
				'label'       => __( 'Alignment', 'codesigner' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'left'   => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'toggle'      => true,
				'selectors'   => array(
					'{{WRAPPER}} .slick-dots' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( '_tabs_dots' );

		$this->start_controls_tab(
			'_tab_dots_normal',
			array(
				'label' => __( 'Normal', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_dots_hover',
			array(
				'label' => __( 'Hover', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_hover_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li button:hover:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_dots_active',
			array(
				'label' => __( 'Active', 'codesigner' ),
			)
		);

		$this->add_control(
			'dots_nav_active_color',
			array(
				'label'     => __( 'Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots .slick-active button:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();
		extract( $settings );
		?>

		<div class="wl-crvc-review-area">
			<div class="wl-crvc-review-silder reviews-carousel-<?php echo esc_attr( $id ); ?>">
				
				<?php foreach ( $review_repeater_items as $item ) : ?>

					<div class="wl-crvc-review-single cr2 <?php echo esc_attr( $item['review_photo_align'] ); ?>">

						<?php if ( 'yes' == $review_photo_switcher ) : ?>
							<div class="wl-crvc-review-img">
								<?php
								if ( ! empty( $item['review_repeater_photo']['id'] ) ) {
									echo wp_get_attachment_image( $item['review_repeater_photo']['id'], $review_photo_thumbnail_size );
								} else {
									?>
											<img src="<?php echo esc_url( $item['review_repeater_photo']['url'] ); ?>">
										<?php
								}
								?>
							</div>
						<?php endif; ?>

						<div class="wl-crvc-review-inner">
							<div class="wl-crvc-review-author">
								<div class="wl-crvc-review-author-details">

									<?php if ( 'yes' == $review_name_switcher ) : ?>
										<h3><?php echo esc_html( $item['review_repeater_name'] ); ?></h3>
										<?php
									endif;

									if ( 'yes' == $review_description_switcher ) :
										?>
										<span><?php echo esc_html( $item['review_repeater_description'] ); ?></span>
									<?php endif; ?>

								</div>

								<?php if ( ! empty( $item['review_repeater_rating'] ) && 'yes' == $review_rating_switcher ) : ?>
									<div class="wl-crvc-review-author-rating">
										<span>
											<?php
											for ( $i = 0; $i < 5; $i++ ) {

												if ( $i < $item['review_repeater_rating'] ) {
													?>
														<i class="<?php echo esc_attr( $review_rating_blockicon['value'] ); ?>"></i>
													<?php
												} else {
													?>
														<i class="<?php echo esc_attr( $review_rating_empty_icon['value'] ); ?>"></i>
													<?php
												}
											}
											?>
											<strong><?php echo esc_html( $item['review_repeater_rating'] ); ?>/5</strong>
										</span>
									</div>
								<?php endif; ?>

							</div>
							
							<?php if ( 'yes' == $review_comment_switcher ) : ?>
								<div class="wl-crvc-review-details">
									<p><?php echo esc_html( $item['review_repeater_comment'] ); ?></p>
								</div>
								<?php
							endif;

							if ( 'yes' == $review_date_switcher ) :
								?>
								<div class="wl-crvc-review-date"><?php echo esc_html( $item['review_repeater_date'] ); ?></div>
							<?php endif; ?>

						</div>
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
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();
		extract( $settings );

		$slick_config = array(
			'autoplay'           => $autoplay,
			'autoplay_speed'     => codesigner_sanitize_number( $autoplay_speed ),
			'animation_speed'    => codesigner_sanitize_number( $animation_speed ),
			'infinite_loop'      => $infinite_loop,
			'navigation'         => $navigation,
			'slides_show'        => $slides_show,
			'slides_show_mobile' => $slides_show_mobile,
			'slides_show_tablet' => $slides_show_tablet,
			'arrow_icon_left'    => $arrow_icon_left,
			'arrow_icon_right'   => $arrow_icon_right,
		);
		?>
		<script type="text/javascript">

			jQuery(function($){
				var config 	= <?php echo json_encode( $slick_config ); ?>;
				var $loop 	= config.infinite_loop ? true : false;
				var $autoplay 	= config.autoplay ? true : false;

				if ( 'none' == config.navigation ) {
					$arrows = false;
					$dots 	= false;
				}
				else if( 'arrow' == config.navigation ) {
					$arrows = true;
					$dots 	= false;
				}
				else if( 'dots' == config.navigation ) {
					$arrows = false;
					$dots 	= true;
				}
				else {
					$arrows = true;
					$dots 	= true;
				}

				if ( config.arrow_icon_left ) {
					var $prevArrow = '<button type="button" class="slick-prev"><i class="'+ config.arrow_icon_left.value +'"></i></button>'
				} 
				else {
					var $prevArrow = false
				}

				if ( config.arrow_icon_right ) {
					var $nextArrow = '<button type="button" class="slick-next"><i class="'+ config.arrow_icon_right.value +'"></i></button>'
				} 
				else {
					var $nextArrow = false
				}

				$('.reviews-carousel-<?php echo esc_attr( $id ); ?>' ).slick({
						infinite: $loop,
						autoplay: $autoplay,
						autoplaySpeed: config.autoplay_speed,
						speed: config.animation_speed,
						slidesToShow: parseInt(config.slides_show),
						slidesToScroll: parseInt(config.slides_show),
						arrows: $arrows,
						dots: $dots,
					prevArrow: $prevArrow,
					nextArrow: $nextArrow,

					responsive: [
					{
						breakpoint: 1024,
						settings: {
						slidesToShow: parseInt(config.slides_show),
						slidesToScroll: parseInt(config.slides_show),
						}
					},
					{
						breakpoint: 769,
						settings: {
						slidesToShow: parseInt(config.slides_show_tablet),
						slidesToScroll: parseInt(config.slides_show_tablet),
						}
					},
					{
						breakpoint: 481,
						settings: {
						slidesToShow: parseInt(config.slides_show_mobile),
						slidesToScroll: parseInt(config.slides_show_mobile),
						}
					}
					]
				});
			})
		</script>
		<?php
	}
}
