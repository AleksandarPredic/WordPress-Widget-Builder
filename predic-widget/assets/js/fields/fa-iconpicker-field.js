/**
 * Init widgets color picker fields
 * @see predic-widget/class/fields/class-predic-widget-fa-iconpicker-field.php
 */
(function($){

    "use strict";

    var $iconFieldClass = '.predic-widget-fa-iconpicker';
    var $inputText = '.predic-widget-fa-iconpicker__input';
    var $preview = '.predic-widget-fa-iconpicker__preview';

    // Handle widget admin screen init
    $(window).load(function(){

        $(document).on('click', '.predic-widget-fa-iconpicker__list ul li', function () {

            var $self = $(this);

            setValues($self.parents($iconFieldClass), $self.data('icon'), $self.html())

        } );

        // Clear value
        $(document).on('click', '.predic-widget-fa-iconpicker__clear', function () {

            setValues($(this).parents($iconFieldClass), '', '')

        } );

        // Default value
        $(document).on('click', '.predic-widget-fa-iconpicker__default', function () {

            var $self = $(this);

            setValues($self.parents($iconFieldClass), $self.data('default'), $self.html())

        } );

        /**
         * Set input and preview values inside iconPicker field
         */
        function setValues($field, $inputVal, $previewHtml) {

            // Change input val
            $field.find($inputText).val($inputVal).trigger('change');

            // Set preview icon
            $field.find($preview).html($previewHtml);

        }

    });

})(jQuery);