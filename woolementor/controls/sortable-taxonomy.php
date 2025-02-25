<?php
/**
 * Group_Control_Gradient_Text control class
 *
 * @package codexpert\CoDesigner
 */
namespace Codexpert\CoDesigner\App\Controls;

use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || die();

class Sortable_Taxonomy extends Base_Data_Control {

	/**
	 * Control identifier
	 */
	const TYPE = 'sortable-taxonomy';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::TYPE;
	}

	/**
	 * Get Sortable_Taxonomy control default settings.
	 *
	 * Retrieve the default settings of the Sortable_Taxonomy control. Used to return the
	 * default settings while initializing the Sortable_Taxonomy control.
	 *
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return array();
	}

	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'sortable-taxonomy-control', CODESIGNER_ASSETS . '/css/sortable-taxonomy-control.css', time(), 'all' );
		wp_enqueue_script( 'SortableJS', 'https://raw.githack.com/SortableJS/Sortable/master/Sortable.js', array(), time(), true );
		wp_enqueue_script( 'sortable-taxonomy-control', CODESIGNER_ASSETS . '/js/sortable-taxonomy-control.js', array( 'jquery', 'jquery-ui-sortable' ), time(), true );
		// if ( $this->get_settings( 'sortable' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		// }
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>

			<div class="elementor-control-sortable-wrapper">
				<ul class="wl-sortable-control-panel" id="<?php echo esc_attr( $control_uid ); ?>" data-setting="{{ data.name }}">
					<input class="wl-sortable-input" value="" id="<?php $this->print_control_uid(); ?>" type="hidden" title="" data-setting="{{ data.name }}" />

					<# 
						var save_value  = data.controlValue;
						var save_values = save_value.split(',');

						_.each( data.options, function( label, value ) { 
							if ( typeof save_values == 'string' ) {
								var checked = ( value === save_values ) ? 'checked' : '';
							} else {
								var checked = ( -1 !== save_values.indexOf( value ) ) ? 'checked' : '';
							}
						#>
						<li class="ui-state-default">{{{ label }}}
							<input class="wl-sortable-input-field" value="{{ value }}" name="{{ data.name }}[{{ value }}]" id="<?php $this->print_control_uid( '{{ value }}' ); ?>" type="hidden" title="{{ data.title }}" data-setting="{{ value }}" />
							<label class="switch">
								<input class="wl-sortable-checkbox-field {{ value }}" value="{{ value }}" type="checkbox" {{ checked }}>
								<span class="slider round"></span>
							</label>
						</li>
					<# } ); #>
				</ul>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}