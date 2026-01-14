<?php
/**
 * Combined Invoice Meta Box Template
 * Displays both proforma and basic invoice management in one meta box
 */

defined('ABSPATH') || exit;

// Use the passed order_id instead of getting it from order object
// This prevents HPOS compatibility issues
$nonce = wp_create_nonce('we_invoice_nonce');
?>

<div class="we-invoice-meta-box">
    <style>
        .we-invoice-meta-box .invoice-section {
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            margin-bottom: 12px;
            background: #fff;
        }
        .we-invoice-meta-box .invoice-section-header {
            background: #f6f7f7;
            border-bottom: 1px solid #c3c4c7;
            padding: 8px 12px;
            font-weight: 600;
            color: #1d2327;
        }
        .we-invoice-meta-box .invoice-section-content {
            padding: 12px;
        }
        .invoice-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .status-generated { background: #d5e5d6; color: #2d5016; }
        .status-sent { background: #d5e9ff; color: #0a4b78; }
        .status-none { background: #f0f0f1; color: #646970; }
        .invoice-info {
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 10px;
        }
        .invoice-info div {
            margin-bottom: 3px;
        }
        .invoice-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .btn-invoice {
            padding: 4px 8px;
            border: 1px solid #2271b1;
            border-radius: 3px;
            background: #2271b1;
            color: #fff;
            text-decoration: none;
            font-size: 11px;
            cursor: pointer;
            display: inline-block;
            line-height: 1.4;
        }
        .btn-invoice:hover {
            background: #135e96;
            border-color: #135e96;
            color: #fff;
        }
        .btn-generate { background: #00a32a; border-color: #00a32a; }
        .btn-generate:hover { background: #008a20; border-color: #008a20; }
        .btn-send { background: #2271b1; border-color: #2271b1; }
        .btn-download { background: #646970; border-color: #646970; }
        .btn-download:hover { background: #50575e; border-color: #50575e; }
        .invoice-section.disabled {
            opacity: 0.5;
        }
        .invoice-section.disabled .invoice-section-header {
            background: #f6f6f7;
            color: #8c8f94;
        }
    </style>

    <!-- Proforma Invoice Section -->
    <div class="invoice-section <?php echo !get_option('we_proforma_invoice_enabled', 1) ? 'disabled' : ''; ?>">
        <div class="invoice-section-header">
            <?php _e('Proforma Invoice', 'we-invoice'); ?>
        </div>
        <div class="invoice-section-content">
            <?php if (!get_option('we_proforma_invoice_enabled', 1)): ?>
                <div class="invoice-status status-none">
                    <?php _e('Disabled', 'we-invoice'); ?>
                </div>
            <?php else: ?>
                <?php if ($proforma_invoice): ?>
                    <div class="invoice-status <?php echo $proforma_invoice['status'] === 'sent' ? 'status-sent' : 'status-generated'; ?>">
                        <?php 
                        echo $proforma_invoice['status'] === 'sent' 
                            ? __('Sent', 'we-invoice') 
                            : __('Generated', 'we-invoice'); 
                        ?>
                    </div>
                    
                    <div class="invoice-info">
                        <div><strong><?php _e('Invoice #:', 'we-invoice'); ?></strong> <?php echo esc_html($proforma_invoice['invoice_number']); ?></div>
                        <div><strong><?php _e('Created:', 'we-invoice'); ?></strong> <?php echo date_i18n(get_option('date_format'), strtotime($proforma_invoice['created_date'])); ?></div>
                        <?php if ($proforma_invoice['sent_date']): ?>
                            <div><strong><?php _e('Sent:', 'we-invoice'); ?></strong> <?php echo date_i18n(get_option('date_format'), strtotime($proforma_invoice['sent_date'])); ?></div>
                        <?php endif; ?>
                        <div><strong><?php _e('Amount:', 'we-invoice'); ?></strong> <?php echo wc_price($proforma_invoice['total_amount']); ?></div>
                    </div>

                    <div class="invoice-actions">

                        <a href="<?php echo admin_url('admin-ajax.php?action=download_proforma_invoice&invoice_id=' . $proforma_invoice['id'] . '&nonce=' . $nonce); ?>" 
                           class="btn-invoice btn-download" target="_blank">
                            <?php _e('Download PDF', 'we-invoice'); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="invoice-status status-none">
                        <?php _e('Not generated', 'we-invoice'); ?>
                    </div>
                    
                    <div class="invoice-actions">
                        <button type="button" class="btn-invoice btn-generate" 
                                onclick="weInvoiceAction('generate_proforma', <?php echo $order_id; ?>)">
                            <?php _e('Generate', 'we-invoice'); ?>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Basic Invoice Section -->
    <div class="invoice-section <?php echo !get_option('we_invoice_enabled', 1) ? 'disabled' : ''; ?>">
        <div class="invoice-section-header">
            <?php _e('Invoice', 'we-invoice'); ?>
        </div>
        <div class="invoice-section-content">
            <?php if (!get_option('we_invoice_enabled', 1)): ?>
                <div class="invoice-status status-none">
                    <?php _e('Disabled', 'we-invoice'); ?>
                </div>
            <?php else: ?>
                <?php if ($basic_invoice): ?>
                    <div class="invoice-status <?php echo $basic_invoice['status'] === 'sent' ? 'status-sent' : 'status-generated'; ?>">
                        <?php 
                        echo $basic_invoice['status'] === 'sent' 
                            ? __('Sent', 'we-invoice') 
                            : __('Generated', 'we-invoice'); 
                        ?>
                    </div>
                    
                    <div class="invoice-info">
                        <div><strong><?php _e('Invoice #:', 'we-invoice'); ?></strong> <?php echo esc_html($basic_invoice['invoice_number']); ?></div>
                        <div><strong><?php _e('Created:', 'we-invoice'); ?></strong> <?php echo date_i18n(get_option('date_format'), strtotime($basic_invoice['created_date'])); ?></div>
                        <?php if ($basic_invoice['sent_date']): ?>
                            <div><strong><?php _e('Sent:', 'we-invoice'); ?></strong> <?php echo date_i18n(get_option('date_format'), strtotime($basic_invoice['sent_date'])); ?></div>
                        <?php endif; ?>
                        <div><strong><?php _e('Amount:', 'we-invoice'); ?></strong> <?php echo wc_price($basic_invoice['total_amount']); ?></div>
                    </div>

                    <div class="invoice-actions">
                
                        <a href="<?php echo admin_url('admin-ajax.php?action=download_basic_invoice&invoice_id=' . $basic_invoice['id'] . '&nonce=' . $nonce); ?>" 
                           class="btn-invoice btn-download" target="_blank">
                            <?php _e('Download PDF', 'we-invoice'); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="invoice-status status-none">
                        <?php _e('Not generated', 'we-invoice'); ?>
                    </div>
                    
                    <div class="invoice-actions">
                        <button type="button" class="btn-invoice btn-generate" 
                                onclick="weInvoiceAction('generate_basic', <?php echo $order_id; ?>)">
                            <?php _e('Generate', 'we-invoice'); ?>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function weInvoiceAction(action, orderId, invoiceId = null) {
    const actionMap = {
        'generate_proforma': 'generate_proforma_invoice',
        'send_proforma': 'send_proforma_invoice',
        'generate_basic': 'generate_basic_invoice',
        'send_basic': 'send_basic_invoice'
    };

    const button = event.target;
    const originalText = button.textContent;
    button.textContent = '<?php _e('Processing...', 'we-invoice'); ?>';
    button.disabled = true;

    const data = {
        action: actionMap[action],
        order_id: orderId,
        nonce: '<?php echo $nonce; ?>'
    };

    if (invoiceId) {
        data.invoice_id = invoiceId;
    }

    jQuery.post(ajaxurl, data, function(response) {
        if (response.success) {
            location.reload();
        } else {
            alert(response.data.message || '<?php _e('An error occurred', 'we-invoice'); ?>');
            button.textContent = originalText;
            button.disabled = false;
        }
    });
}
</script>
