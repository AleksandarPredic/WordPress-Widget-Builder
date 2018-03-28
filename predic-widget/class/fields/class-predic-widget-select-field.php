<?php

/**
 * Class responsible for widget admin form select field
 */
class Predic_Widget_Select_Field extends Predic_Widget_Form_Field {
    
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
	 * Field options
	 * 
	 * @since 1.0.0
	 * @var array|callable
	 */
    private $options;
	
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
        $this->options = isset( $atts['options'] ) && !empty( $atts['options'] ) ? $atts['options'] : array(); // Options
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
        }

        // If value NULL (only first time before save) set default value if passed
        $value = NULL === $this->value && '' !== $this->default ? $this->default : $this->value;
        
        // Html output
        $html .= '<select class="widefat" '
                . 'id="' . esc_attr( $this->id ) . '" '
                . 'name="' . esc_attr( $this->name ) . '" '
                . '>';
        
                $select_options = array();
        
                if ( ! is_array( $this->options ) || empty( $this->options ) ) {
                    $html .= '</select>';
                    return $html;
                }
                    
                if ( isset( $this->options['callable'] ) ) {
                    // Use function
                    if ( is_callable( $this->options['callable'] ) ) {
                        $select_options = call_user_func( $this->options['callable'] );
                    }

                } else {
                    // Use static already created options
                    $select_options = $this->options;
                }
                    
                // Output options
                foreach ( $select_options as $option => $label ) {
                    $html .= '<option value="' . esc_attr( $option ) . '" '. selected( $value, $option, false ) .'>' . esc_attr( $label ) . '</option>';
                }
        
        $html .= '</select>';
        
        return $html;
    }
    
}