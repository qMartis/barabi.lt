/**
 * Basic Invoice Admin JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Generate invoice
        $(document).on('click', '.we-generate-invoice', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var orderId = $button.data('order-id');
            var invoiceType = $button.data('invoice-type');
            
            if (invoiceType !== 'basic') return;
            
            $button.prop('disabled', true).text(weBasicInvoice.strings.generating);
            
            $.ajax({
                url: weBasicInvoice.ajax_url,
                type: 'POST',
                data: {
                    action: 'generate_basic_invoice',
                    order_id: orderId,
                    nonce: weBasicInvoice.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(weBasicInvoice.strings.success, 'success');
                        location.reload(); // Reload to show the generated invoice
                    } else {
                        showNotice(response.data.message || weBasicInvoice.strings.error, 'error');
                    }
                },
                error: function() {
                    showNotice(weBasicInvoice.strings.error, 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).html('<span class="dashicons dashicons-plus-alt"></span> Generate Basic Invoice');
                }
            });
        });
        
        // Regenerate invoice
        $(document).on('click', '.we-regenerate-invoice', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var orderId = $button.data('order-id');
            var invoiceType = $button.data('invoice-type');
            
            if (invoiceType !== 'basic') return;
            
            if (!confirm('Are you sure you want to regenerate this invoice? This will create a new invoice number.')) {
                return;
            }
            
            $button.prop('disabled', true).text(weBasicInvoice.strings.generating);
            
            $.ajax({
                url: weBasicInvoice.ajax_url,
                type: 'POST',
                data: {
                    action: 'generate_basic_invoice',
                    order_id: orderId,
                    nonce: weBasicInvoice.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(weBasicInvoice.strings.success, 'success');
                        location.reload(); // Reload to show the regenerated invoice
                    } else {
                        showNotice(response.data.message || weBasicInvoice.strings.error, 'error');
                    }
                },
                error: function() {
                    showNotice(weBasicInvoice.strings.error, 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Regenerate');
                }
            });
        });
        
        // Send invoice
        $(document).on('click', '.we-send-invoice', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var orderId = $button.data('order-id');
            var invoiceId = $button.data('invoice-id');
            var invoiceType = $button.data('invoice-type');
            
            if (invoiceType !== 'basic') return;
            
            $button.prop('disabled', true).text(weBasicInvoice.strings.sending);
            
            $.ajax({
                url: weBasicInvoice.ajax_url,
                type: 'POST',
                data: {
                    action: 'send_basic_invoice',
                    order_id: orderId,
                    invoice_id: invoiceId,
                    nonce: weBasicInvoice.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(weBasicInvoice.strings.success, 'success');
                        // Update status indicator if exists
                        $('.invoice-status').removeClass('invoice-status-generated').addClass('invoice-status-sent').text('Sent');
                    } else {
                        showNotice(response.data.message || weBasicInvoice.strings.error, 'error');
                    }
                },
                error: function() {
                    showNotice(weBasicInvoice.strings.error, 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).html('<span class="dashicons dashicons-email-alt"></span> Send Email');
                }
            });
        });
        
        /**
         * Show admin notice
         */
        function showNotice(message, type) {
            var noticeClass = type === 'success' ? 'notice-success' : 'notice-error';
            var $notice = $('<div class="notice ' + noticeClass + ' is-dismissible"><p>' + message + '</p></div>');
            
            // Remove existing notices
            $('.notice.we-invoice-notice').remove();
            
            $notice.addClass('we-invoice-notice');
            
            // Insert notice
            if ($('.wrap h1').length) {
                $('.wrap h1').after($notice);
            } else {
                $('#wpbody-content').prepend($notice);
            }
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                $notice.fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
        
        /**
         * Handle notice dismiss button
         */
        $(document).on('click', '.we-invoice-notice .notice-dismiss', function() {
            $(this).closest('.notice').remove();
        });
        
    });

})(jQuery);
