/**
 * Media Image Filter Generator - Media Modal Extension
 * 
 * Extends the WordPress Media Library modal to add filter generation UI
 */

(function($, wp) {
    'use strict';
    
    if (!wp || !wp.media) {
        console.log('MIFG: wp.media not available');
        return;
    }
    
    if (typeof mifgData === 'undefined') {
        console.error('MIFG: mifgData not loaded');
        return;
    }
    
    console.log('MIFG: Initializing Media Image Filter Generator', mifgData);
    
    /**
     * Wait for DOM ready
     */
    $(document).ready(function() {
        
        /**
         * Extend the Attachment Details Two Column view
         * This is the view shown when you click on an image in the media modal
         */
        var AttachmentDetailsTwoColumn = wp.media.view.Attachment.Details.TwoColumn;
        
        console.log('MIFG: Extending Attachment.Details.TwoColumn view');
        
        wp.media.view.Attachment.Details.TwoColumn = AttachmentDetailsTwoColumn.extend({
            
            /**
             * Initialize the view
             */
            initialize: function() {
                // Call parent initialize
                AttachmentDetailsTwoColumn.prototype.initialize.apply(this, arguments);
                
                // Add our ready handler
                this.on('ready', this.addFilterUI, this);
            },
            
            /**
             * Add filter UI to the attachment details
             */
            addFilterUI: function() {
                console.log('MIFG: addFilterUI called');
                var attachment = this.model;
                
                // Only add UI for images
                if (!attachment || attachment.get('type') !== 'image') {
                    console.log('MIFG: Not an image attachment, skipping');
                    return;
                }
                
                console.log('MIFG: Adding filter UI for image:', attachment.get('id'));
                
                // Check if UI already exists
                if (this.$el.find('.mifg-filter-controls').length > 0) {
                    console.log('MIFG: UI already exists');
                    return;
                }
                
                // Create UI elements
                var $container = $('<div class="mifg-filter-controls" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;"></div>');
                var $label = $('<label style="display: block; margin-bottom: 8px; font-weight: 600;">' + mifgData.strings.label + '</label>');
                var $select = $('<select class="mifg-filter-select" style="width: 100%; margin-bottom: 10px; padding: 5px;"></select>');
                var $button = $('<button type="button" class="button button-primary mifg-generate-btn" style="width: 100%; position: relative;">' + mifgData.strings.button + '</button>');
                var $spinner = $('<span class="spinner" style="position: absolute; right: 8px; top: 50%; margin-top: -10px; display: none; visibility: visible; float: none;"></span>');
                var $notice = $('<div class="mifg-notice" style="margin-top: 10px; padding: 10px 12px; display: none; border-radius: 4px; font-size: 13px; line-height: 1.5;"></div>');
                
                // Add default option
                $select.append('<option value="">' + mifgData.strings.selectFilter + '</option>');
                
                // Add filter options
                $.each(mifgData.filters, function(key, label) {
                    $select.append('<option value="' + key + '">' + label + '</option>');
                });
                
                // Assemble UI
                $button.append($spinner);
                $container.append($label);
                $container.append($select);
                $container.append($button);
                $container.append($notice);
                
                // Find the settings section and append our UI
                var $settings = this.$el.find('.settings');
                if ($settings.length > 0) {
                    console.log('MIFG: Appending to .settings');
                    $settings.append($container);
                } else {
                    // Fallback: append to attachment-info
                    console.log('MIFG: Fallback - appending to .attachment-info');
                    this.$el.find('.attachment-info').append($container);
                }
                
                console.log('MIFG: UI successfully added');
                
                // Bind event handlers
                this.bindFilterEvents($select, $button, $notice, attachment);
            },
            
            /**
             * Bind event handlers for filter UI
             */
            bindFilterEvents: function($select, $button, $notice, attachment) {
                var self = this;
                
                // Button click handler
                $button.on('click', function(e) {
                    e.preventDefault();
                    
                    var filter = $select.val();
                    
                    if (!filter) {
                        self.showNotice($notice, mifgData.strings.selectFilter, 'error');
                        return;
                    }
                    
                    self.generateFilteredImage(attachment.get('id'), filter, $button, $notice);
                });
                
                // Enable/disable button based on selection
                $select.on('change', function() {
                    if ($(this).val()) {
                        $button.prop('disabled', false);
                    } else {
                        $button.prop('disabled', true);
                    }
                });
                
                // Initially disable button
                $button.prop('disabled', true);
            },
            
            /**
             * Generate filtered image via AJAX
             */
            generateFilteredImage: function(attachmentId, filter, $button, $notice) {
                var self = this;
                var $spinner = $button.find('.spinner');
                
                // Show loading state
                $button.prop('disabled', true).css('padding-right', '40px');
                $spinner.css('display', 'inline-block');
                self.hideNotice($notice);
                
                console.log('MIFG: Sending AJAX request', {
                    attachmentId: attachmentId,
                    filter: filter,
                    ajaxUrl: mifgData.ajaxUrl,
                    nonce: mifgData.nonce
                });
                
                // Send AJAX request
                $.ajax({
                    url: mifgData.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'generate_filtered_image',
                        attachmentId: attachmentId,
                        filter: filter,
                        _ajax_nonce: mifgData.nonce
                    },
                    success: function(response) {
                        console.log('MIFG: AJAX response received', response);
                        $spinner.hide();
                        $button.css('padding-right', '');
                        
                        if (response.success) {
                            // Show success message
                            self.showNotice($notice, response.data.message, 'success');
                            
                            // Refresh the media library
                            self.refreshMediaLibrary(response.data.attachment_id);
                            
                            // Reset button after delay
                            setTimeout(function() {
                                $button.prop('disabled', false);
                                self.hideNotice($notice);
                            }, 3000);
                        } else {
                            // Show error message
                            var errorMsg = response.data && response.data.message 
                                ? response.data.message 
                                : mifgData.strings.error;
                            self.showNotice($notice, errorMsg, 'error');
                            $button.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('MIFG: AJAX error', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            responseJSON: xhr.responseJSON
                        });
                        $spinner.hide();
                        $button.css('padding-right', '').prop('disabled', false);
                        
                        // Show detailed error message
                        var errorMsg = mifgData.strings.error;
                        if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                            errorMsg = xhr.responseJSON.data.message;
                        } else if (xhr.responseText) {
                            errorMsg += ' (Check console for details)';
                        } else if (error) {
                            errorMsg += ' (' + error + ')';
                        }
                        self.showNotice($notice, errorMsg, 'error');
                    }
                });
            },
            
            /**
             * Refresh the media library to show newly created image
             */
            refreshMediaLibrary: function(newAttachmentId) {
                // Get the media library controller
                var frame = wp.media.frame || wp.media.editor;
                
                if (!frame) {
                    return;
                }
                
                // Get the library collection
                var library = frame.state().get('library');
                
                if (library) {
                    // Fetch the new attachment
                    var newAttachment = wp.media.attachment(newAttachmentId);
                    
                    newAttachment.fetch().done(function() {
                        // Add to the beginning of the library
                        library.add(newAttachment, {at: 0});
                        
                        // Trigger reset to refresh the view
                        library.trigger('reset');
                        
                        // Optional: Select the new attachment
                        // frame.state().get('selection').reset([newAttachment]);
                    });
                }
            },
            
            /**
             * Show notice message
             */
            showNotice: function($notice, message, type) {
                var bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
                var textColor = type === 'success' ? '#155724' : '#721c24';
                var borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
                
                $notice.css({
                    'background-color': bgColor,
                    'color': textColor,
                    'border': '1px solid ' + borderColor,
                    'border-radius': '4px',
                    'font-weight': '500'
                }).html(message).fadeIn('fast');
            },
            
            /**
             * Hide notice message
             */
            hideNotice: function($notice) {
                $notice.fadeOut();
            }
        });
        
    });
    
})(jQuery, wp);
