<?php

/**
 * Example widget
 */

/**
 * Render widget frontend view
 * 
 * @param array $args     Display arguments including 'before_title', 'after_title',
 *                        'before_widget', and 'after_widget'.
 * @param array $instance The settings for the particular instance of the widget.
 * @param array $form_fields Widget admin form fields configuration array
 * @param string $this->id Widget generated unique id by instance number. 
 *                        Can be used to target this widget instance only
 * @param string $widget_id Widget generated unique id by instance number. 
 *                        Can be used to target this widget instance only
 */
function example_widget( $args, $instance, $form_fields, $widget_id ) {

	/**
	 * Please note: 
	 * $instance will hold all admin form fields values
	 */

	// Set widget title
	$widget_title = isset( $instance['title'] ) ? $instance['title'] : '';

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];

	if ( ! empty( $widget_title ) ) {
		echo $args['before_title'] . esc_html( $widget_title ) . $args['after_title'];
	}

	/**
	 * Widget html output start
	 */

	// Some widget output

	/**
	 * Widget html output start
	 */

	// before and after widget arguments are defined by themes
	echo $args['after_widget'];

	/**
	 * Add script
	 * We are not using wp_enqueue_scripts hook for scripts as it is already too late to hook in
	 */
	wp_enqueue_script( 'example-widget', 'uri-to-example-widget-script', array( 'jquery' ), false, true );

}

$config = array(

	// Core configuration

	/**
	 * Unique widget id
	 * @var string (required)
	 */
	'base_id' => 'example_widget',

	/**
	 * Widget name
	 * @var string (required)
	 */
	'name' => esc_html__('+ Example widget', 'textdomain'),

	/**
	 * Widger callback function to render frontend html
	 * 
	 * If use class callback, the class instance must be used
	 * If you use array('MyClassName', 'method') than __autoload will not fire properly when
	 * a not-yet-loaded class was invoked through a PHP command
	 * 
	 * @var string|array String if function name is passed, if using class method than it will be array (required)
	 */
	'callback' => 'example_widget',

	/**
	 * Widget Options
	 * Option array passed to wp_register_sidebar_widget() using $options.
	 * @see https://codex.wordpress.org/Function_Reference/wp_register_sidebar_widget
	 * @var array|string (optional)
	 */
	'widget_ops' => array(
		'classname' => 'example-widget-css-class',
		'description' => esc_html__( 'Example widget description', 'textdomain' ),
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
	'form_fields' => array(

		/**
		 * Please note:
		 * 
		 * array key is required. It should be unique string for widget admin form. 
		 * String may contain only lowercase letters and underlines
		 * It will be used as name and id.
		 * Also you will get values on frontend using this key
		 */

		'title' => array(
			'type' => 'text', // Required  // Input type: text, email, password, search, tel, url, button
			'label' => esc_html__( 'Title:', 'textdomain' ), // Optional
			'placeholder' => esc_html__( 'Enter widget title here', 'textdomain' ), // Optional
			'default' => esc_html__( 'Example widget', 'textdomain' ) // Optional
		),

		'text_field_name' => array(
			'type' => 'text', // Required  // Input type: text, email, password, search, tel, url, button
			'label' => esc_html__( 'Label name:', 'textdomain' ), // Optional
			'placeholder' => esc_html__( 'Placeholder text', 'textdomain' ), // Optional
			'default' => esc_html__( 'Default text', 'textdomain' ) // Optional
		),

		/**
		 * When echo textarea content use this fucntion to preserve new lines (convert them to <br />)
		 * wp_kses_post( nl2br( $description ) )
		 */
		'textarea_field_name' => array(
			'type' => 'textarea', // Required
			'label' => esc_html__( 'Label name:', 'pbtheme' ), // Optional
			'placeholder' => esc_html__( 'Enter description here', 'pbtheme' ), // Optional
			'default' => esc_html__( 'Default text', 'textdomain' ) // Optional
		),

		'select_field_name' => array(
			'type' => 'select', // Required
			'label' => esc_html__( 'Label name:', 'textdomain' ), // Optional
			'options' => array( // Required
				'one' => esc_html__( 'One', 'textdomain' ),
				'two' => esc_html__( 'Two', 'textdomain' ),
				'three' => esc_html__( 'Three', 'textdomain' ),
				'four' => esc_html__( 'Four', 'textdomain' ),
			),
			//'options' => array( 'callable' => array( $class_instance, 'method_name' ) ), // instead you can use function not method
			'default' => 'two' // Optional
		),

		'color_field_name' => array(
			'type' => 'color', // Required
			'label' => esc_html__( 'Label name:', 'textdomain' ), // Optional
			'alpha' => true, // Optional
			'default' => '#FF0000' // Optional
		),

		/**
		 * Uploader field accept both attachment id or url as param. Also in the field user can enter external url
		 * and field will automatically use url or generate attachment url if attachment id provided.
		 * 
		 * NOTICE: Default value can not be attachment id, only url
		 */
		'uploader_field_name' => array(
			'type' => 'uploader_image', // Required
			'label' => esc_html__( 'Label name:', 'textdomain' ), // Optional
			'default' => 'http://placehold.it/350x150' // Optional // accept url only
		),

	)

);

// Init widget
if ( function_exists( 'predic_widget' ) ) {
	predic_widget()->add_widget( $config );
}