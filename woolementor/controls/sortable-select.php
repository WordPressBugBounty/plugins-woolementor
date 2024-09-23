<?php
/**
 * Group_Control_Gradient_Text control class
 *
 * @package codexpert\CoDesigner
 */
namespace Codexpert\CoDesigner\App\Controls;

use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || die();

class Sortable_Select extends Base_Data_Control {

    /**
     * Control identifier
     */
    const TYPE = 'sortable-select';

    /**
     * Set control type.
     */
    public function get_type() {
        return self::TYPE;
    }

    /**
     * Get Sortable_Select control default settings.
     *
     * Retrieve the default settings of the Sortable_Select control. Used to return the
     * default settings while initializing the Sortable_Select control.
     *
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [];
    }
    // protected function get_default_value() {
    //     return [];
    // }

    // public function get_value( $control, $settings ) {
    //     $value = parent::get_value( $control, $settings );


    //     echo "<pre>";
    //     print_r($value);
    //     echo "</pre>";

    //     if ( empty( $control['default'] ) ) {
    //         $control['default'] = [];
    //     }

    //     if ( ! is_array( $value ) ) {
    //         $value = [];
    //     }

    //     $control['default'] = array_merge(
    //         $this->get_default_value(),
    //         $control['default']
    //     );

    //     $ttt = array_merge(
    //         $control['default'],
    //         $value
    //     );
    // }

    // public function get_value( $control, $settings ) {
    //     if ( ! isset( $control['default'] ) ) {
    //         $control['default'] = $this->get_default_value();
    //     }

    //     if ( isset( $settings[ $control['name'] ] ) ) {
    //         $value = $settings[ $control['name'] ];
    //     } else {
    //         $value = $control['default'];
    //     }

    //     return $value;
    // }

    /**
     * Enqueue control scripts and styles.
     */
    public function enqueue() {
        wp_enqueue_style( 'sortable-select-control', CODESIGNER_ASSETS . '/css/sortable-select-control.css', time(), 'all' );
        wp_enqueue_script( 'SortableJS', 'https://raw.githack.com/SortableJS/Sortable/master/Sortable.js', [], time(), true );
        wp_enqueue_script( 'sortable-select-control', CODESIGNER_ASSETS . '/js/sortable-select-control.js', [ 'jquery', 'jquery-ui-sortable' ], time(), true );
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

                    <# _.each( data.options, function( label, value ) { #>
                        <li class="ui-state-default">{{{ label }}}
                            <input value="{{ value }}" name="{{ data.name }}[{{ value }}]" id="<?php $this->print_control_uid( "{{ value }}" ); ?>" type="hidden" title="{{ data.title }}" data-setting="{{ value }}" />
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