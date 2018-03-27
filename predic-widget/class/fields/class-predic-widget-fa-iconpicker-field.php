<?php

/**
 * Class responsible for widget admin form FontAwesome icon picker
 */
class Predic_Widget_Fa_Iconpicker_Field extends Predic_Widget_Form_Field {

    /**
     * Field version
     *
     * @since 1.0.1
     * @var string
     */
    private static $version = '1.0.0';

    /**
     * Generated field id
     *
     * @since 1.0.1
     * @var string
     */
    private $id;

    /**
     * Generated form field name
     *
     * @since 1.0.1
     * @var string
     */
    private $name;

    /**
     * Field label
     *
     * @since 1.0.1
     * @var string
     */
    private $label;

    /**
     * Default field value until it is saved via widget admin form
     *
     * @since 1.0.1
     * @var mixed
     */
    private $default;

    /**
     * Field value from current widget instance
     *
     * @since 1.0.1
     * @var mixed
     */
    private $value;

    /**
     * Constructor
     *
     * @since 1.0.1
     * @param array $atts User passed config array
     * @param string $id Generated field id
     * @param string $name Generated form field name
     * @param mixed $value Field value. Before save the value is NULL
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
     * @since 1.0.1
     * @return string Field output
     */
    public function field() {

        $html = '';

        if ( empty( $this->name ) ) {
            return $html;
        }

        // Wrapper around field to avoid changing other uploaders values if more upload fields in same widget
        $html .= '<section class="predic-widget-fa-iconpicker predic-widget-fa-iconpicker__field">';

        if ( $this->label ) {
            $html .= '<label for="' . esc_attr( $this->id ) . '">' . strip_tags( $this->label ) . '</label>';
            $html .= '<br />';
        }

        // If value NULL (only first time before save) set default value if passed
        $value = NULL === $this->value && '' !== $this->default ? $this->default : $this->value;

        // Hidden input to store attachment id
        $html .= '<input class="widefat predic-widget-fa-iconpicker__input" '
            . 'id="' . esc_attr( $this->id ) . '" '
            . 'name="' . esc_attr( $this->name ) . '" '
            . 'type="text" '
            . 'value="' . esc_attr( $value ) . '" ';

        $html .= '/>';

        /**
         * Preview default or selected icon
         */
        $icon_preview = '';

        // Image preview
        $html .= '<p class="predic-widget-fa-iconpicker__preview">' . $icon_preview . '</p>';

        $html .= '<div class="predic-widget-fa-iconpicker__list">' . $this->get_icons_list() . '</div>';

        // Select button
        $html .= '<button type="button" class="button predic-widget-fa-iconpicker__select">' . esc_html__( 'Select', 'predic_widget' ) . '</button>';
        // Clear button
        $html .= '<button type="button" class="button predic-widget-fa-iconpicker__clear">' . esc_html__( 'Clear', 'predic_widget' ) . '</button>';

        // Default value
        if ( !empty( $this->default ) ) {
            $html .= '<button type="button" class="button predic-widget-fa-iconpicker__default" data-url="' . esc_url( $this->default ) . '">' . esc_html__( 'Default', 'predic_widget' ) . '</button>';
        }

        // Close field wrapper
        $html .= '</section>';

        return $html;
    }

    /**
     * Add script
     * We are not using admin_enqueue_scripts hook as it is already too late to hook in
     *
     * @since 1.0.1
     */
    public static function admin_scripts( $hook ) {

    	if ( 'widgets.php' !== $hook ) {
    		return;
	    }

        wp_enqueue_style( 'predic-widget-font-awesome', PREDIC_WIDGET_ASSETS_URL . '/vendor/font-awesome/css/font-awesome.min.css', array(), self::$version );

        // Uploader picker init
        wp_enqueue_script( 'predic-widget-fa-iconpicker-field', PREDIC_WIDGET_ASSETS_URL . '/js/fields/fa-iconpicker-field.min.js', array( 'jquery' ), self::$version, true );
        /*wp_localize_script( 'predic-widget-fa-iconpicker-field', 'predic_widget_uploader_field', array(
            'uploader_title' => esc_html__( 'Upload or select image', 'predic_widget' ),
            'button_text' => esc_html__( 'Select image', 'predic_widget' )
        ));*/

    }

    private function get_icons_list() {

        $output = '';

        $icons = include PREDIC_WIDGET_LIB_PATH . '/font-awesome-icons.php';

        if ( empty( $icons ) || ! is_array( $icons ) ) {
            return $output;
        }

        $output .= '<ul>';

        foreach ( $icons as $icon ) {
            $output .= '<li data-icon="' . esc_js( $icon ) . '"><i class="fa ' . sanitize_text_field( $icon ) . '" aria-hidden="true"></i></li>';
        }

        $output .= '</ul>';

        return $output;

    }

}