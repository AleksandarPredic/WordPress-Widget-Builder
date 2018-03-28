<?php

/**
 * Class responsible for uploading / selecting single image field
 */
class Predic_Widget_Image_Uploader_Field extends Predic_Widget_Form_Field {
    
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
    private $default;
	
	/**
	 * Default field value until it is saved via widget admin form
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
     * @param mixed $value Field value
     */
    public function __construct( $atts, $id, $name, $value ) {
        $this->id = $id; // Id
        $this->name = $name; // Name
        $this->label = isset( $atts['label'] ) && !empty( $atts['label'] ) ? $atts['label'] : ''; // Label
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
        
        // Wrapper around field to avoid changing other uploaders values if more upload fields in same widget
        $html .= '<section class="predic-widget-img-uploader__wrapper">';
        
        if ( $this->label ) {
            $html .= '<label for="' . esc_attr( $this->id ) . '">' . strip_tags( $this->label ) . '</label>';
            $html .= '<br />';
        }
        
        // If value NULL (only first time before save) set default value if passed
        $value = NULL === $this->value && '' !== $this->default ? $this->default : $this->value;

        // Hidden input to store attachment id
        $html .= '<input class="widefat predic-widget-img-uploader__input" '
                . 'id="' . esc_attr( $this->id ) . '" '
                . 'name="' . esc_attr( $this->name ) . '" '
                . 'type="text" '
                . 'value="' . esc_attr( $value ) . '" ';
        
        $html .= '/>';
        
        /**
         * Preview image
         * If attachment id is saved, intval > 0
         */
        $img_preview = '';
        
        if ( ! empty( $this->value ) && intval( $this->value ) > 0 ) {
            // Attachment id is saved as value
            $img_preview = wp_get_attachment_image( $this->value, 'medium' );
        } elseif( ! empty( $this->value ) ) {
            // Url is saved as value
            $img_preview = '<img src="' . esc_url( $this->value ) . '" />';
        } elseif ( NULL === $this->value ) {
            // Value is empty but only first time before save
            if ( !empty( $this->default ) ) {
                $img_preview = '<img src="' . esc_url( $this->default ) . '" />';
            }
        }

        // Image preview
        $html .= '<p class="predic-widget-img-uploader__preview">' . $img_preview . '</p>';
        
        // Select button
        $html .= '<button type="button" class="button predic-widget-img-uploader__select">' . esc_html__( 'Select', 'predic_widget' ) . '</button>';
        // Clear button
        $html .= '<button type="button" class="button predic-widget-img-uploader__clear">' . esc_html__( 'Clear', 'predic_widget' ) . '</button>';
        
        // Default value
        if ( !empty( $this->default ) ) {
            $html .= '<button type="button" class="button predic-widget-img-uploader__default" data-url="' . esc_url( $this->default ) . '">' . esc_html__( 'Default', 'predic_widget' ) . '</button>';
        }

        // Close field wrapper
        $html .= '</section>';
        
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
        wp_enqueue_media();
        
        // Uploader picker init
        wp_enqueue_script( 'predic-widget-uploader-field', PREDIC_WIDGET_ASSETS_URL . '/js/fields/uploader-field.min.js', array( 'jquery' ), self::$version, true );
        wp_localize_script( 'predic-widget-uploader-field', 'predic_widget_uploader_field', array(
           'uploader_title' => esc_html__( 'Upload or select image', 'predic_widget' ),
           'button_text' => esc_html__( 'Select image', 'predic_widget' )
        ));
        
    }
    
}