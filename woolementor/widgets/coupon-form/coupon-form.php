<?php
namespace codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Coupon_Form extends Widget_Base {

	public $id;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->id     = wcd_get_widget_id( __CLASS__ );
		$this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return array();
	}

	public function get_style_depends() {
		return array();
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
			'coupon_section_settings',
			array(
				'label' => __( 'General', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'coupon_placeholder_text',
			array(
				'label'       => __( 'Placeholder Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Coupon Code', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
			)
		);

		$this->add_control(
			'coupon_button_text',
			array(
				'label'       => __( 'Button Text', 'codesigner' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Apply', 'codesigner' ),
				'placeholder' => __( 'Type your title here', 'codesigner' ),
			)
		);

		$this->add_control(
			'coupon_Alignment',
			array(
				'label'     => __( 'Alignment', 'codesigner' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'    => array(
						'title' => __( 'Left', 'codesigner' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'   => array(
						'title' => __( 'Center', 'codesigner' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end' => array(
						'title' => __( 'Right', 'codesigner' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Coupon Input Field
		 */
		$this->start_controls_section(
			'coupon_input_field',
			array(
				'label' => __( 'Input Field', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'coupon_input_field_default',
			array(
				'label'     => __( 'View', 'plugin-domain' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon' => 'display: flex;align-items: center;justify-content: end;',
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-fields' => 'position: relative;',
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-input.input-text' => 'width: 100%;padding: 10px;border: 1px solid transparent; padding-left: 18px;font-size: 14px;background: #eee;outline: none;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_responsive_control(
			'coupon_input_width',
			array(
				'label'      => __( 'Input Size', 'codesigner' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-fields' => 'width: {{SIZE}}{{UNIT}}',
				),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
					'em' => array(
						'min' => 10,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
			)
		);

		$this->add_control(
			'coupon_input_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} input.wl-cf-apply-coupon-input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'coupon_input_bg',
			array(
				'label'     => __( 'Background Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} input.wl-cf-apply-coupon-input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'coupon_input_typography',
				'label'    => __( 'Typography', 'codesigner' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '.wl {{WRAPPER}} input.wl-cf-apply-coupon-input',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'coupon_input_field_border',
				'label'     => __( 'Border', 'codesigner' ),
				'selector'  => '.wl {{WRAPPER}} input.wl-cf-apply-coupon-input',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'coupon_input_field_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} input.wl-cf-apply-coupon-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'coupon_input_field_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} input.wl-cf-apply-coupon-input',
			)
		);

		$this->add_responsive_control(
			'coupon_input_field_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} input.wl-cf-apply-coupon-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'coupon_input_field_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} input.wl-cf-apply-coupon-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Coupon Button
		 */
		$this->start_controls_section(
			'coupon_button',
			array(
				'label' => __( 'Apply Button', 'codesigner' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'coupon_button_default',
			array(
				'label'     => __( 'View', 'plugin-domain' ),
				'type'      => Controls_Manager::HIDDEN,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'position: absolute; right: 0; padding: 10px 30px; cursor: pointer; bottom: 0; top: 0; transition: .4s;',
					'.wl {{WRAPPER}} .checkout_coupon.woocommerce-form-coupon' => 'display: block !important;',
				),
				'default'   => 'traditional',
			)
		);

		$this->add_control(
			'coupon_button_color',
			array(
				'label'     => __( 'Text Color', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button:hover' => 'color: {{VALUE}}',
				),
				'default'   => '#fff',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'coupon_button_typography',
				'label'          => __( 'Typography', 'codesigner' ),
				'global'         => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'       => '.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button',
				'fields_options' => array(
					'typography' => array( 'default' => 'yes' ),
					'font_size'  => array( 'default' => array( 'size' => 14 ) ),
				),
			)
		);

		$this->add_control(
			'coupon_button_bg',
			array(
				'label'     => __( 'Background', 'codesigner' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'background: {{VALUE}}',
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button:hover' => 'background: {{VALUE}}',
				),
				'default'   => '#584899',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'coupon_button_border',
				'label'          => __( 'Border', 'codesigner' ),
				'selector'       => '.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button',
				'separator'      => 'before',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'default' => 'transparent',
					),
				),
			)
		);

		$this->add_responsive_control(
			'coupon_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '0',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '0',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'coupon_button_box_shadow',
				'label'    => __( 'Box Shadow', 'codesigner' ),
				'selector' => '.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button',
			)
		);

		$this->add_responsive_control(
			'coupon_button_padding',
			array(
				'label'      => __( 'Padding', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '10',
					'right'  => '30',
					'bottom' => '10',
					'left'   => '30',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'coupon_button_margin',
			array(
				'label'      => __( 'Margin', 'codesigner' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'.wl {{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->render_editing_attributes();
		?>

		<div class="cx-row">
			<div class="cx-col-md-12 cx-col-sm-12">
				<form class="checkout_coupon woocommerce-form-coupon" method="post" style="">
					<div class="wl-cf-apply-coupon">
						<div class="wl-cf-apply-coupon-fields">
							<input type="text" name="coupon_code" class="wl-cf-apply-coupon-input input-text" placeholder="<?php echo esc_attr( $settings['coupon_placeholder_text'] ); ?>" id="coupon_code" value="">

							<?php
							printf(
								'<button %1$s type="submit" name="apply_coupon" value="%2$s">%2$s</button>',
								wp_kses_post( $this->get_render_attribute_string( 'coupon_button_text' ) ),
								esc_html( $settings['coupon_button_text'] )
							);
							?>
							
						</div>
					</div>
					<div class="clear"></div>
				</form>
			</div>
		</div>		

		<?php

		do_action( 'codesigner_after_main_content', $this );
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'coupon_button_text', 'none' );
		$this->add_render_attribute( 'coupon_button_text', 'class', 'wl-cf-apply-coupon-button button' );
	}
}