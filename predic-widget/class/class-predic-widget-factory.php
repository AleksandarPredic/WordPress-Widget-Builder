<?php

/**
 * Class responsible for adding new widget
 */
class Predic_Widget_Factory extends WP_Widget {
    
    /**
     * Widget admin form html tag before from field 
     * 
     * @since 1.0.0
     * @var string
     */
    private $section_opening_tag;
    
    /**
     * Widget admin form html tag after from field 
     * 
     * @since 1.0.0
     * @var string
     */
    private $section_closing_tag;
    
    /**
     * Configuration array which holds params to create widgets from
     * 
     * @since 1.0.0
     * @var array
     */
    private $atts;
    
    /**
     * Widget admin form fields configuration array
     * 
     * @since 1.0.0
     * @var array
     */
    private $form_fields;

    /**
     * Array of all PHP classes for fields to include and instantiate
     *
     * @since 1.0.1
     * @var array
     */
    private $field_php_classes;

    /**
     * Constructor
     * 
     * @since 1.0.0
     * @param array $atts widget configuration array
     */
    public function __construct(array $atts ) {

        /**
         * Supported fields and their PHP classes
         */
        $input_text_path = PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-input-field.php';
        $php_classes = array(

            // Input text and similar fields
            'text' => array(
                'class' => 'Predic_Widget_Input_Field',
                'path' => $input_text_path
            ),
            'password' => array(
                'class' => 'Predic_Widget_Input_Field',
                'path' => $input_text_path
            ),
            'search' => array(
                'class' => 'Predic_Widget_Input_Field',
                'path' => $input_text_path
            ),
            'tel' => array(
                'class' => 'Predic_Widget_Input_Field',
                'path' => $input_text_path
            ),
            'button' => array(
                'class' => 'Predic_Widget_Input_Field',
                'path' => $input_text_path
            ),
            // Select field
            'select' => array(
                'class' => 'Predic_Widget_Select_Field',
                'path' => PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-select-field.php'
            ),
            // Color field
            'color' => array(
                'class' => 'Predic_Widget_Color_Field',
                'path' => PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-color-field.php'
            ),
            // Single image uploader
            'uploader_image' => array(
                'class' => 'Predic_Widget_Image_Uploader_Field',
                'path' => PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-image-uploader-field.php'
            ),
            // Textarea field
            'textarea' => array(
                'class' => 'Predic_Widget_Textarea_Field',
                'path' => PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-textarea-field.php'
            ),
            // FontAwesome icon picker field
            'fa-iconpicker' => array(
                'class' => 'Predic_Widget_Fa_Iconpicker_Field',
                'path' => PREDIC_WIDGET_ROOT_PATH . '/class/fields/class-predic-widget-fa-iconpicker-field.php'
            ),
        );

        /**
         * Allow other to add more custom fields
         *
         * @param array $php_classes List of field_type => array( 'class' => 'PHP_Class_Name', 'path' => 'class_filepath' ), to use to render field html
         * @return array List of field_type_id => array( 'class' => 'PHP_Class_Name', 'path' => 'class_filepath' )
         */
        $this->field_php_classes = apply_filters( 'predic_widget_fields_php_classes', $php_classes );
        
        /**
         * Default configuration array values that every configured widget must have
         */
        $pairs = array(
            /**
             * Unique widget id
             * @var string (required)
             */
            'base_id' => false,
            /**
             * Widget name
             * @var string (required)
             */
            'name' => false,
            /**
             * Widger callback function to render frontend html
             * This function will be called instead of 'widget' function in this class
             * 
             * If use class callback, the class instance must be used
             * If you use array('MyClassName', 'method') than __autoload will not fire properly when
             * a not-yet-loaded class was invoked through a PHP command
			 * 
             * @var string|array String if function name is passed, if using class method than it will be array  (required)
             */
            'callback' => false,
            /**
             * Widget Options
             * Option array passed to wp_register_sidebar_widget() using $options.
             * @see https://codex.wordpress.org/Function_Reference/wp_register_sidebar_widget
             * @var array|string (optional)
             */
            'widget_ops' => array(
                'classname' => 'prefix_example_widget_class',
                'description' => esc_html__( 'Some description for example widget.', 'predic_widget' ),
                'customize_selective_refresh' => false,
            ),
            /**
             * Width and height of the widget
             * Option array passed to wp_register_widget_control() using $options.
             * @see https://codex.wordpress.org/Function_Reference/wp_register_widget_control
             * @var array|string (optional)
             */
            'control_ops' => array( 
                'width' => 400, 
                'height' => 350 
            ), 
            /**
             * Admin widget form section html element.
             * Example: <p>, ,<section>, <p> 
             * Can not have value of <div>
             * @var string (optional)
             */
            'section_opening_tag' => '<p>',
            /**
             * Admin widget form section html element.
             * Example: <p>, ,<section>, <p> 
             * Can not have value of <div>
             * @var string (optional)
             */
            'section_closing_tag' => '</p>',
            /**
             * Field arguments
             * @see field reference for supported field types
             */
            'form_fields' => array() // Required
        );
        
        $this->atts = shortcode_atts( $pairs , $atts );
        
        // Check for must have atts
        if ( empty( $this->atts['callback'] ) ) {
            trigger_error( esc_html__( 'Please provide setup param: callback.', 'predic_widget' ), E_USER_ERROR );
            return false;
        }
        
        if ( empty( $this->atts['base_id'] ) || empty( $this->atts['name'] ) ) {
            trigger_error( esc_html__( 'Please provide setup params: id and name.', 'predic_widget' ), E_USER_ERROR );
            return false;
        }
        
        // Setup rest of the properties
        $this->section_opening_tag = wp_kses_post( $this->atts['section_opening_tag'] );
        $this->section_closing_tag = wp_kses_post( $this->atts['section_closing_tag'] );
        $this->form_fields = $this->atts['form_fields'];
        $widget_ops = is_array( $this->atts['widget_ops'] ) ? array_map( 'sanitize_text_field', $this->atts['widget_ops'] ) : strip_tags( $this->atts['widget_ops'] );
        $control_ops = is_array( $this->atts['widget_ops'] ) ? array_map( 'sanitize_text_field', $this->atts['widget_ops'] ) : strip_tags( $this->atts['widget_ops'] );
        
        // Construct widget
        parent::__construct(
            // Base ID of your widget
            strip_tags( $this->atts['base_id'] ),
            // Widget name will appear in UI
            strip_tags( $this->atts['name'] ),
            // Widget atts
            $widget_ops,
            $control_ops
        );

        /**
         * Add admin scripts for all fields that have method admin_scripts and are used in this widget
         */
        $this->fields_admin_scripts();

    }

    /**
	 * Output the widget content.
	 *
	 * @since 1.0.0
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
    public function widget( $args, $instance ) {
        
        // Check if user defined function or method to use for widget output
        if ( ! isset( $this->atts['callback'] ) || ! is_callable( $this->atts['callback'] ) ) {
            trigger_error( esc_html__( 'Please provide setup params: id and name.', 'predic_widget' ), E_USER_ERROR );
            return false;
        }
        
        /**
         * Call funciton provided by user from configuration array
         *
         * @since 1.0.0
         * @access public
         *
         * @param array $args     Display arguments including 'before_title', 'after_title',
         *                        'before_widget', and 'after_widget'.
         * @param array $instance The settings for the particular instance of the widget.
         * @param array $this->form_fields Widget admin form fields configuration array
         * @param string $this->id Widget generated unique id by instance number. 
         *                        Can be used to target this widget instance only
         */
        call_user_func( $this->atts['callback'], $args, $instance, $this->form_fields, $this->id );

    }

    /**
	 * Outputs widget settings form.
	 *
	 * @since 1.0.0
	 * @param array $instance Current settings.
	 */
    public function form( $instance ) {

        // Widget admin form fields configuration array
        if ( ! is_array( $this->form_fields ) || empty( $this->form_fields ) ) {
            return false;
        }
        
        // Output admin form fields
        foreach ( $this->form_fields as $name => $field ) {

            // Check needed type and name params for all form input types
            if ( !isset( $field['type'] ) || empty( $field['type'] ) ) {
                continue;
            }

            // Key may be number of string
            if ( !isset( $name ) ) {
                continue;
            }
            
            // Check if key is int and throw notice
            if ( is_int( $name ) ) {
                trigger_error( strip_tags( sprintf( __( 'You should not use numbers as widget admin form field id. Id provided is: %d.', 'predic_widget' ), intval( $name ) ) ), E_USER_NOTICE );
            }

            // Get field class and path, also may be one added by external user and not default framework field
            $class = isset( $this->field_php_classes[ $field['type'] ]['class'] ) ? sanitize_text_field( $this->field_php_classes[ $field['type'] ]['class'] ) : false;
            $class_path = isset( $this->field_php_classes[ $field['type'] ]['path'] ) ? sanitize_text_field( $this->field_php_classes[ $field['type'] ]['path'] ) : false;

            // If field type doesn't exist continue
            if ( empty( $class ) || empty( $class_path ) ) {
                continue;
            }

            // Include field PHP class and ones that are added by external user
            if ( file_exists( $class_path ) ) {
                    require_once $class_path;
            } else {
                trigger_error( strip_tags( sprintf( __( 'File %s does not exists.', 'predic_widget' ), $class_path ) ), E_USER_WARNING );
                continue;
            }
 
            /**
             * Html output start
             */
            $html = '';
            
            // Oped container (section) tag
            $html .= $this->section_opening_tag;
            
            // Sanitize name as key
            $name = sanitize_key( $name );
            
            // Render field
            $form_field = new $class(
                $field, // User defined atts
                $this->get_field_id( $name ), // Id
                $this->get_field_name( $name ), // Name
                isset( $instance[ $name ] ) ? esc_attr( $instance[ $name ] ) : NULL // Value
            );

            // Check if field extend required class
            if ( $form_field instanceof Predic_Widget_Form_Field ) {
                $html .= $form_field->field();
            } else {
                $errors[] = trigger_error( 
                    esc_attr( sprintf( __( '%s class must extend abstract class Predic_Widget_Form_Field' ), get_class( $form_field ) ) ), 
                    E_USER_ERROR 
                );
                return false;
            }
            
            // Close container (section) tag
            $html .= $this->section_closing_tag;

            echo $html;
            
        }

    }

    /**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0.0
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save
	 */
    public function update( $new_instance, $old_instance ) {
        
        if ( ! is_array( $this->form_fields ) || empty( $this->form_fields ) ) {
            return;
        }
        
        $instance = array();
        
        foreach ( $this->form_fields as $name => $field ) {
            
            $name = sanitize_key( $name );
            
            if ( !isset( $field['type'] ) ) {
                continue;
            }
            
            $value = '';
            
            /**
             * To do: add user defined sanitization
             */
            if ( isset( $new_instance[ $name ] ) ) {
                
                if ( strpos( $field['type'], 'textarea') !== false ) {
                    $value = $this->validate_allowed_html_tags( $new_instance[ $name ] );
                } else {
                    $value = sanitize_text_field( $new_instance[ $name ] );
                }

            }
            
            $instance[ $name ] = $value;
            
        }

        return $instance;
    }
    
    /**
     * Validate all allowed html tags in content with addition of allowed iframe and script tags
     * 
     * @since 1.0.0
     * @global array $allowedposttags All allowed tags in WordPress post
     * @param string $content Content to validate
     * @return string
     */
    private function validate_allowed_html_tags( $content ) {
        
        global $allowedposttags; 

        $tags = array(
            'iframe' => array(
                'id' => true,
                'name' => true,
                'src' => true,
                'width' => true,
                'height' => true,
                'class' => true,
                'frameborder' => true,
                'webkitAllowFullScreen' => true,
                'mozallowfullscreen' => true,
                'allowFullScreen' => true
            ), 
            'embed' => array(
                'src' => true,
                'width' => true,
                'height' => true,
                'align' => true,
                'class' => true,
                'name' => true,
                'id' => true,
                'frameborder' => true,
                'seamless' => true,
                'srcdoc' => true,
                'sandbox' => true,
                'allowfullscreen' => true
            )
        );

        $allowed_tags = shortcode_atts( $tags, $allowedposttags );  
        
        return wp_kses( $content, $allowed_tags );
        
    }

    /**
     * Add admin scripts for all fields that have method admin_scripts
     * and are used in this widget
     *
     * @since 1.0.1
     */
    public function fields_admin_scripts() {

        $method = 'admin_scripts';

        foreach ( $this->field_php_classes as $class ) {

            // Include field PHP class
            if ( file_exists( $class['path'] ) ) {
                require_once $class['path'];
            } else {
                trigger_error( strip_tags( sprintf( __( 'File %s does not exists.', 'predic_widget' ), $class['path'] ) ), E_USER_WARNING );
                continue;
            }

            $class_name = isset( $class['class'] ) ? sanitize_text_field( $class['class'] ) : false;


            if ( method_exists( $class_name, $method ) ) {
                add_action( 'admin_enqueue_scripts', array( $class_name, $method ) );
            }

        }
    }

}