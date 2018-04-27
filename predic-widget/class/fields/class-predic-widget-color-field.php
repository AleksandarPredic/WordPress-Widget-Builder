<?php

/**
 * Class responsible for color field in widget admin form
 */
class Predic_Widget_Color_Field extends Predic_Widget_Form_Field {
    
	/**
	 * Field version
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private static $version = '1.0.0';
	
	/**
	 * Generated field id
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private $id;
	
	/**
	 * Generated form field name
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private $name;
	
	/**
	 * Field label
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private $label;
	
	/**
	 * Boolean to add alpha to color picker
	 * 
	 * @since 1.0.0
	 * @var boolean
	 */
    private $alpha;
	
	/**
	 * Default field value until it is saved via widget admin form
	 * 
	 * @since 1.0.0
	 * @var mixed
	 */
    private $default;
	
	/**
	 * Field value from current widget instance
	 * 
	 * @since 1.0.0
	 * @var mixed
	 */
    private $value;
    
    /**
     * Constructor
	 * 
	 * @since 1.0.0
     * @param array $atts User passed config array
     * @param string $id Generated field id
     * @param string $name Generated form field name
     * @param mixed $value Field value. Before save the value is NULL
     */
    public function __construct( $atts, $id, $name, $value ) {
        $this->id = $id; // Id
        $this->name = $name; // Name
        $this->label = isset( $atts['label'] ) && !empty( $atts['label'] ) ? $atts['label'] : ''; // Label
        $this->alpha = isset( $atts['alpha'] ) && $atts['alpha'] === true ? $atts['alpha'] : false; // Alpha
        $this->default = isset( $atts['default'] ) && !empty( $atts['default'] ) ? $atts['default'] : ''; // Default
        $this->value = $value; // Value
    }
    
    /**
	 * Output admin form field
	 * 
	 * @since 1.0.0
	 * @return string Field output
	 */
    public function field() {
        
        $html = '';
        
        if ( empty( $this->name ) ) {
            return $html;
        }
        
        if ( $this->label ) {
            $html .= '<label for="' . esc_attr( $this->id ) . '">' . strip_tags( $this->label ) . '</label>';
            $html .= '<br />';
        }
        
        // If value NULL (only first time before save) set empty string to init color picker
        $value = NULL === $this->value ? $this->default : $this->value;
        
        $html .= '<input class="widefat predic-widget-color__field" '
                . 'data-id="' . esc_js( $this->id ) . '" '
                . 'id="' . esc_attr( $this->id ) . '" '
                . 'name="' . esc_attr( $this->name ) . '" '
                . 'type="text" '
                . 'value="' . esc_attr( $value ) . '" ';

        if ( !empty( $this->default ) ) {
            $html .= 'data-default-color="' . esc_js( $this->default ) . '" ';
        }
        
        // User selection do enable / disable alpha
        if ( $this->alpha ) {
            $html .= 'data-alpha="true" ';
        } else {
            $html .= 'data-alpha="false" ';
        }
        
        $html .= '/>';
        
        return $html;
    }
    
    /**
     * Add script
	 * 
	 * @since 1.0.0
     */
    public static function admin_scripts( $hook ) {

	    if ( 'widgets.php' !== $hook ) {
		    return;
	    }

	    // Default scripts
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );

        /**
         * Overwrite Automattic Iris for enabled Alpha Channel in wpColorPicker
         * @see https://github.com/23r9i0/wp-color-picker-alpha
         */
        wp_enqueue_script( 'wp-color-picker-alpha', PREDIC_WIDGET_ASSETS_URL . '/vendor/wp-color-picker-alpha/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), self::$version, true );
        
        // Color picker init
        wp_enqueue_script( 'predic-widget-color-field', PREDIC_WIDGET_ASSETS_URL . '/js/fields/color-field.min.js', array( 'wp-color-picker' ), self::$version, true );
        
    }
    
}
