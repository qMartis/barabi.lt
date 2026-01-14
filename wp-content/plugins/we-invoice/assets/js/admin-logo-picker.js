console.log("tete");
jQuery(document).ready(function ($) {
    let mediaUploader;

    // Select Logo button click
    $('#upload-logo-button').on('click', function (e) {
        e.preventDefault();

        // If the media uploader instance already exists, reopen it
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Create a new media uploader instance
        mediaUploader = wp.media({
            title: 'Select Logo',
            button: {
                text: 'Use this logo'
            },
            multiple: false // Allow only one image to be selected
        });

        // On logo selection
        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#we-invoice-logo').val(attachment.url); // Set the hidden input value
            $('#logo-preview').html(`<img src="${attachment.url}" alt="Logo Preview" style="max-height: 100px;" />`);
            $('#remove-logo-button').show(); // Show the Remove Logo button
        });

        mediaUploader.open();
    });

    // Remove Logo button click
    $('#remove-logo-button').on('click', function (e) {
        e.preventDefault();
        $('#we-invoice-logo').val(''); // Clear the hidden input value
        $('#logo-preview').html(''); // Clear the preview
        $(this).hide(); // Hide the Remove Logo button
    });
   
});
