<?php

/**
 * Example for adding custom form field to widget builder
 * 
 * DEMO: Include this file in your theme functions.php file or plugin
 */

/**
 * Class responsible for widget admin form field
 */
class Custom_Textarea_Form_Field extends Predic_Widget_Form_Field {
    
	/**
	 * Field version
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private $version = '1.0.0';
	
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
	 * Field placeholder
	 * 
	 * @since 1.0.0
	 * @var string
	 */
    private $placeholder;
	
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
		$this->placeholder = isset( $atts['placeholder'] ) && !empty( $atts['placeholder'] ) ? $atts['placeholder'] : ''; // Placeholder
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
		
        $html .= '<textarea class="widefat" '
                . 'id="' . esc_attr( $this->id ) . '" '
                . 'name="' . esc_attr( $this->name ) . '" '
                . 'type="textarea" '
                . 'rows="10" ';
		
		if ( !empty( $this->placeholder ) ) {
            $html .= 'placeholder="' . esc_attr( $this->placeholder ) . '" ';
        }
        
        $html .= '>'
                . wp_kses_post( $value )
                . '</textarea>';
        
        return $html;
    }
    
}

/**
 * Add custom field via filter
 * 
 * @param array $php_classes List of field_type => array( 'class' => 'PHP_Class_Name', 'path' => 'class_filepath' ), to use to render field html
 * @return array List of field_type_id => array( 'class' => 'PHP_Class_Name', 'path' => 'class_filepath' )
 */
function add_custom_form_field( $fields_classes ) {

	/**
	 * custom_textarea is your type when adding fields in configuration array
	 */
	$fields_classes['custom_textarea'] = array(
		'class' => 'Custom_Textarea_Form_Field',
		'path' => dirname( __FILE__ ) . '/custom-admin-form-field.php'
	);
	
	/**
	 * This is example of how you would add your custom field to 
	 * form_fields configuration array
	 * 
	'form_fields' => array(

		'custom_field_name' => array(
			'type' => 'custom_textarea',
			'label' => esc_html__( 'Label name:', 'textdomain' ),
			'placeholder' => esc_html__( 'Placeholder text', 'textdomain' ),
			'default' => esc_html__( 'Default text', 'textdomain' )
		)

	)
	 */
	
	return $fields_classes;
	
}
add_filter( 'predic_widget_fields_php_classes', 'add_custom_form_field' );