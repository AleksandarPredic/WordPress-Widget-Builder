/**
 * Init widgets uploader fields
 */
(function($){
    
    "use strict";
    
    // Used fields classes
    var $classButton = '.predic-widget-img-uploader__select';
    var $classInput = '.predic-widget-img-uploader__input';
    var $classPreview = '.predic-widget-img-uploader__preview';
    var $classWrapper = '.predic-widget-img-uploader__wrapper';
    
    // Handle widget admin screen init
    $(document).ready(function(){

        $(document).on('click', $classButton, function( event ) { 
            event.preventDefault();
            
            // Uploading files
            var file_frame;
            
            var $clicked = $(this);
            var $input = $clicked.parent($classWrapper).find($classInput);
            var $preview = $clicked.parent($classWrapper).find($classPreview);
            var $attachment;

            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: predic_widget_uploader_field.uploader_title,
                button: {
                    text: predic_widget_uploader_field.button_text,
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on('select', function () {

                // We set multiple to false so only get one image from the uploader
                $attachment = file_frame.state().get('selection').first().toJSON();

                // Get attachement id and set preview
                $input.val($attachment.id);
                $input.trigger('change'); // Fix for widget not registering change for admin form
                $preview.html('<img src="' + $attachment.url + '" />');

            });

            // Finally, open the modal
            file_frame.open();
            
        });
        
        // Clear preview image and value
        $(document).on('click', '.predic-widget-img-uploader__clear', function( event ) { 
            event.preventDefault();

            var $clicked = $(this);
            var $input = $clicked.parent($classWrapper).find($classInput);

            $input.val('');
            $input.trigger('change'); // Fix for widget not registering change for admin form
            $clicked.parent($classWrapper).find($classPreview).html('');
            
        });
        
        // Default value preview and value
        $(document).on('click', '.predic-widget-img-uploader__default', function( event ) { 
            event.preventDefault();

            var $clicked = $(this);
            var $url = $clicked.data('url');
            var $input = $clicked.parent($classWrapper).find($classInput);

            $input.val($url);
            $input.trigger('change'); // Fix for widget not registering change for admin form
            $clicked.parent($classWrapper).find($classPreview).html('<img src="' + $url + '" />');
            
        });
        
    });
    
})(jQuery);