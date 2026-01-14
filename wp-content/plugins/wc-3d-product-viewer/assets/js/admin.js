jQuery(document).ready(function($) {
    'use strict';
    
    /**
     * Handle 3D model upload
     */
    $(document).on('click', '.wc-3d-upload-btn', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var loop = button.data('loop');
        var wrapper = button.closest('.wc-3d-model-upload-wrapper');
        var input = wrapper.find('.wc-3d-model-id');
        var preview = wrapper.find('.wc-3d-model-preview');
        
        // Create custom media frame
        var frame = wp.media({
            title: wc3dViewerAdmin.upload_title,
            button: {
                text: wc3dViewerAdmin.upload_button
            },
            library: {
                type: ['application', 'model']
            },
            multiple: false
        });
        
        // When a file is selected
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            var fileExtension = attachment.filename.split('.').pop().toLowerCase();
            
            // Validate file extension
            if (wc3dViewerAdmin.allowed_extensions.indexOf(fileExtension) === -1) {
                alert('Invalid file format. Allowed formats: ' + wc3dViewerAdmin.allowed_extensions.join(', ').toUpperCase());
                return;
            }
            
            // Update hidden input
            input.val(attachment.id);
            
            // Update preview
            preview.html(
                '<div class="wc-3d-model-info">' +
                    '<span class="dashicons dashicons-media-3d"></span>' +
                    '<span class="model-filename">' + attachment.filename + '</span>' +
                '</div>'
            );
            
            // Update button text
            button.text('Change 3D Model');
            
            // Show remove button if not exists
            if (wrapper.find('.wc-3d-remove-btn').length === 0) {
                button.after('<button type="button" class="button wc-3d-remove-btn" data-loop="' + loop + '">Remove</button>');
            }
        });
        
        // Open media frame
        frame.open();
    });
    
    /**
     * Handle 3D model removal
     */
    $(document).on('click', '.wc-3d-remove-btn', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var wrapper = button.closest('.wc-3d-model-upload-wrapper');
        var input = wrapper.find('.wc-3d-model-id');
        var preview = wrapper.find('.wc-3d-model-preview');
        var uploadBtn = wrapper.find('.wc-3d-upload-btn');
        
        // Confirm removal
        if (!confirm('Are you sure you want to remove this 3D model?')) {
            return;
        }
        
        // Clear input
        input.val('');
        
        // Clear preview
        preview.html('');
        
        // Update button text
        uploadBtn.text('Upload 3D Model');
        
        // Remove the remove button
        button.remove();
    });
});
