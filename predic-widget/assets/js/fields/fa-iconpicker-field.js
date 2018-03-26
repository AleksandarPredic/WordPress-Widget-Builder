/**
 * Init widgets color picker fields
 * @see predic-widget/class/fields/class-predic-widget-fa-iconpicker-field.php
 */
(function($){

    "use strict";

    var $iconFieldClass = '.predic-widget-fa-iconpicker';

    alert('dsdasdasdfsa');

    // Handle widget admin screen init
    $(window).load(function(){

        // Init widgets on page load
        $($iconFieldClass).each(function(){

            var $self = $(this);
            var $id = '#' + $self.attr('id');



        });

        /**
         * Handle customizer init, adding and update widget form
         * Handle widget admin screen update and adding widgets
         * @see wp-admin/js/widgets.js
         */
        $(document).on('widget-added widget-updated', function( event, $widget ) {

        });

    });

})(jQuery);