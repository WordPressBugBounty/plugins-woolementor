<?php
namespace Codexpert\CoDesigner;

use Elementor\Widget_Base;
use Elementor\Control_Icons;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\CoDesigner\App\Controls\Group_Control_Gradient_Text;

class Product_Barcode extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id = wcd_get_widget_id( __CLASS__ );
        $this->widget = wcd_get_widget( $this->id );
        
        // Are we in debug mode?
        $min = defined( 'CODESIGNER_DEBUG' ) && CODESIGNER_DEBUG ? '' : '.min';

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

	
    protected function render() {
        if( ! current_user_can( 'edit_pages' ) ) return;

		$message = wp_kses( 
			// Translators: %1$s is the widget title, %2$s is the link to upgrade or activate the license.
			sprintf( __( 'This beautiful widget, <strong>%1$s</strong> is a premium widget. Please upgrade to <strong>%2$s</strong> or activate your license if you already have upgraded!', 'codesigner' ), esc_html( $this->get_title() ), '<a href="' . esc_url( 'https://codexpert.io/codesigner' ) . '" target="_blank">' . esc_html__( 'CoDesigner Pro', 'codesigner' ) . '</a>' ),
			[
				'strong' 	=> [],
				'a' 		=> [
					'href' 	=> [],
					'target' => [],
				],
			]
		);
		
		echo wp_kses_post( wcd_notice( $message ) );
		
		if ( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.jpg' ) ) {
			echo '<img src="' . esc_url( plugins_url( 'assets/img/screenshot.jpg', __FILE__ ) ) . '" alt="' . esc_attr__( 'Screenshot', 'codesigner' ) . '" />';
		}	
    }
}