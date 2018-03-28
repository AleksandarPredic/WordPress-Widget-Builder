/**
 * Init widgets color picker fields
 * @see predic-widget/class/fields/class-predic-widget-fa-iconpicker-field.php
 */
(function($){

    "use strict";

    var $iconFieldClass = '.predic-widget-fa-iconpicker';
    var $inputTextClass = '.predic-widget-fa-iconpicker__input';
    var $previewClass = '.predic-widget-fa-iconpicker__preview';
    var $listClass = '.predic-widget-fa-iconpicker__list';
    var $searchClass = '.predic-widget-fa-iconpicker__search';

    // Handle widget admin screen init
    $(window).load(function(){

        $(document).on('click', '.predic-widget-fa-iconpicker__list ul li', function () {

            var $self = $(this);

            setValues($self.parents($iconFieldClass), $self.data('icon'), $self.html());

        } );

        // Clear value
        $(document).on('click', '.predic-widget-fa-iconpicker__clear', function () {

            var $self = $(this);
            var $field = $self.parents($iconFieldClass);

            setValues($field, '', '');
            $field.find($searchClass).val('').trigger('change');

        } );

        // Default value
        $(document).on('click', '.predic-widget-fa-iconpicker__default', function () {

            var $self = $(this);
            var $field = $self.parents($iconFieldClass);
            var $default = $self.data('default');

            setValues($field, $default, $field.find($listClass).find('.' + $default)[0].outerHTML);

        } );

        // Search icons
        $(document).on('input change', $searchClass, function () {

            var $self = $(this);
            var $list = $self.next($listClass);

            $list.find('ul li').each(function (index, el) {

                var $listItem = $(el);
                var $icon = $listItem.data('icon');

                if ( -1 !== $icon.toLowerCase().indexOf($self.val().toString()) ) {
                    $listItem.css('display', 'block');
                } else {
                    $listItem.css('display', 'none');
                }

            });

        } );

        /**
         * Set input and preview values inside iconPicker field
         */
        function setValues($field, $inputVal, $previewHtml) {

            // Change input val
            $field.find($inputTextClass).val($inputVal).trigger('change');

            // Set preview icon
            $field.find($previewClass).html($previewHtml);

            // Remove selected icon in icon list
            $field.find($listClass).find('ul li').removeClass('predic-widget-fa-iconpicker__list--selected');

        }

    });

})(jQuery);