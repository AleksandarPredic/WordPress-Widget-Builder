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
	 * Icon html holder and it must contain %s to insert icon class
	 *
	 * @since 1.0.1
	 * @var string
	 */
	private $holder;

	/**
	 * Icons array to select from
	 *
	 * @since 1.0.2
	 * @var array
	 */
	private $icons;

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
        $this->holder = isset( $atts['holder'] ) && !empty( $atts['holder'] ) ? $atts['holder'] : '<i class="fa %s" aria-hidden="true"></i>'; // Default
	    $this->icons = isset( $atts['icons'] ) && is_array( $atts['icons'] ) && !empty( $atts['icons'] ) ? $atts['icons'] : array(); // Label
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

        // Wrapper around field to avoid changing other same fields in same widget
        $html .= '<section class="predic-widget-fa-iconpicker predic-widget-fa-iconpicker__field">';

	        if ( $this->label ) {
	            $html .= '<label for="' . esc_attr( $this->id ) . '">' . strip_tags( $this->label ) . '</label>';
	            $html .= '<br />';
	        }

	        // If value NULL (only first time before save) set default value if passed
	        $value = NULL === $this->value && '' !== $this->default ? $this->default : $this->value;

	        // Hidden input to store icon value
	        $html .= '<input class="widefat predic-widget-fa-iconpicker__input" '
	            . 'id="' . esc_attr( $this->id ) . '" '
	            . 'name="' . esc_attr( $this->name ) . '" '
	            . 'type="hidden" '
	            . 'value="' . esc_attr( $value ) . '" ';

	        $html .= '/>';

	        /**
	         * Preview default or selected icon
	         */
	        $icon_preview = ! empty( $value ) ? sprintf( $this->holder, esc_attr( $value ) ) : '';

	        /**
	         * Image preview
	         */
	        $html .= '<p class="predic-widget-fa-iconpicker__preview">' . wp_kses_post( $icon_preview ) . '</p>';

		    /**
		     * Search field
		     */
		    $html .= '<input type="text" class="widefat predic-widget-fa-iconpicker__search" placeholder="' . esc_html__( 'Search icons', 'predic_widget' ) . '"/>';

		    /**
		     * Icons list
		     */
	        $html .= '<div class="predic-widget-fa-iconpicker__list">' . $this->get_icons_list() . '</div>';

		    /**
		     * Clear button
		     */
	        $html .= '<button type="button" class="button predic-widget-fa-iconpicker__clear">' . esc_html__( 'Clear', 'predic_widget' ) . '</button>';

		    /**
		     * Default value
		     */
	        if ( !empty( $this->default ) ) {
	            $html .= '<button type="button" class="button predic-widget-fa-iconpicker__default" data-default="' . esc_attr( $this->default ) . '">' . esc_html__( 'Default', 'predic_widget' ) . '</button>';
	        }

        // Close field wrapper
        $html .= '</section>';

        return $html;
    }

    /**
     * Add script
     *
     * @since 1.0.1
     */
    public static function admin_scripts( $hook ) {

    	if ( 'widgets.php' !== $hook ) {
    		return;
	    }

        wp_enqueue_style( 'predic-widget-font-awesome', PREDIC_WIDGET_ASSETS_URL . '/vendor/font-awesome/css/font-awesome.min.css', array(), self::$version );
        wp_enqueue_script( 'predic-widget-fa-iconpicker-field', PREDIC_WIDGET_ASSETS_URL . '/js/fields/fa-iconpicker-field.min.js', array( 'jquery' ), self::$version, true );

    }

    private function get_icons_list() {

        $output = '';

        $icons = ! empty( $this->icons ) ? $this->icons : include PREDIC_WIDGET_LIB_PATH . '/font-awesome-icons.php';
	    $icons = apply_filters( 'predic_widget_fa_iconpicker_icons_array', $icons, $this->id );

        if ( empty( $icons ) || ! is_array( $icons ) ) {
            return $output;
        }

        $output .= '<ul>';

        foreach ( $icons as $icon ) {
        	$selected = $this->value === $icon ? ' class="predic-widget-fa-iconpicker__list--selected"' : '';
            $output .= '<li data-icon="' . esc_js( $icon ) . '"' . $selected . '>
			                <i class="fa ' . sanitize_text_field( $icon ) . '" aria-hidden="true"></i>
			            </li>';
        }

        $output .= '</ul>';

        return $output;

    }

}