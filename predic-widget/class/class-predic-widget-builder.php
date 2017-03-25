<?php

/**
 * Class responsible for registering widgets using Predic_Widget_Factory
 */
class Predic_Widget_Builder {
    
    /**
     * Widget factory class instance
     * 
     * @since 1.0.0
     * @var Predic_Widget_Factory 
     */
    private $widget;
    
    /**
     * Constructor
     * 
     * @since 1.0.0
     * @param array $atts widget configuration array
     */
    public function __construct( $atts ) {
        $this->widget = new Predic_Widget_Factory( $atts );
        $this->widget_init();
    }
    
    /**
     * Register widget on widgets_init hook
     * 
     * @since 1.0.0
     */
    public function widget_init() {
        add_action( 'widgets_init', array( $this, 'register_widget' ) );
    }

    /**
     * Register widget
     * 
     * @since 1.0.0
     * @hooked Hooked on widgets_init
     */
    public function register_widget() {
        register_widget( $this->widget );
    }
    
}