<?php

use Codexpert\CoDesigner\Helper;
use Elementor\Widget_Base;

class Variation_Swatches_Widget extends Widget_Base {

	public function get_name() {
		return 'variation_swatches_widget';
	}

	public function get_title() {
		return esc_html__( 'Variation Swatches', 'codesigner' );
	}

	public function get_icon() {
		$cd_branding_class = ' wlbi';
		return 'eicon-loop-builder' . $cd_branding_class;
	}

	public function get_categories() {
		return [ 'codesigner-single' ];
	}

	public function get_keywords() {
		return [ 'variation', 'swatches' ];
	}

	protected function register_controls() {
		codesigner_get_variation_swatches_view( 'controls', $this, false );
	}

	protected function render() {
		
		$settings 	= $this->get_settings_for_display();
		codesigner_get_variation_swatches_view( 'swatches', $settings, false );   	
	}

}