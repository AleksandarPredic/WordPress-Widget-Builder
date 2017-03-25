<?php

/**
 * Abstract class for admin form fields to extend
 */
abstract class Predic_Widget_Form_Field {
    
	/**
	 * Constructor
	 * 
	 * @since 1.0.0
	 */
    abstract public function __construct( $atts, $id, $name, $value );

	/**
	 * Output admin form field
	 * 
	 * @since 1.0.0
	 */
    abstract public function field();
    
}