/**
 * Init widgets color picker fields
 * @see predic-widget/class/fields/class-predic-widget-color-field.php
 */
(function($){
    
    "use strict";

    var $colorFieldClass = '.predic-widget-color__field';
    
    // Handle widget admin screen init
    $(window).load(function(){

        // Init widgets on page load
        $($colorFieldClass).each(function(){

            var $self = $(this);
            var $id = '#' + $self.attr('id');

            // Avoid widget base with __i__
            if ( $id.indexOf('__i__') === -1 ) {
                $($colorFieldClass).wpColorPicker({
                    /**
                     * @param {Event} event - standard jQuery event, produced by whichever
                     * control was changed.
                     * @param {Object} ui - standard jQuery UI object, with a color member
                     * containing a Color.js object.
                     */
                    change: function (event, ui) {
                        var element = event.target;
                        var color = ui.color.toString();

                        // Trigger change to enable save widget instance button
                        $(element).val(color).hide().trigger('change');
                    }
                });
            }

        });

        /**
         * Handle customizer init, adding and update widget form
         * Handle widget admin screen update and adding widgets
         * @see wp-admin/js/widgets.js
         */
        $(document).on('widget-added widget-updated', function( event, $widget ) {
            $widget.find($colorFieldClass).wpColorPicker();
        });
        
    });
    
})(jQuery);