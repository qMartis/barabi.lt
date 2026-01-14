<?php
/**
 * Template for displaying invoice actions in admin order page
 *
 * @var \WC_Order $order
 * @var array|null $invoice
 * @var string $invoice_type
 */

defined('ABSPATH') || exit;

$invoice_type_label = $invoice_type === 'proforma' ? __('Proforma', 'we-invoice') : __('Basic', 'we-invoice');
$nonce_action = $invoice_type === 'proforma' ? 'we_proforma_invoice_nonce' : 'we_basic_invoice_nonce';
?>

<div class="we-invoice-actions" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
    <h4 style="margin-top: 0;">
        <span class="dashicons dashicons-media-document" style="vertical-align: middle;"></span>
        <?php echo sprintf(__('%s Invoice', 'we-invoice'), $invoice_type_label); ?>
    </h4>
    
    <?php if ($invoice): ?>
        <div class="invoice-info" style="margin-bottom: 10px;">
            <p><strong><?php _e('Invoice Number:', 'we-invoice'); ?></strong> <?php echo esc_html($invoice['invoice_number']); ?></p>
            <p><strong><?php _e('Status:', 'we-invoice'); ?></strong> 
                <span class="invoice-status invoice-status-<?php echo esc_attr($invoice['status']); ?>">
                    <?php echo esc_html(ucfirst($invoice['status'])); ?>
                </span>
            </p>
            <p><strong><?php _e('Created:', 'we-invoice'); ?></strong> <?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($invoice['created_date']))); ?></p>
            <?php if ($invoice['sent_date']): ?>
                <p><strong><?php _e('Sent:', 'we-invoice'); ?></strong> <?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($invoice['sent_date']))); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="invoice-actions">
            <?php if (!empty($invoice['pdf_path']) && file_exists($invoice['pdf_path'])): ?>
                <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=download_' . $invoice_type . '_invoice&invoice_id=' . $invoice['id'] . '&_wpnonce=' . wp_create_nonce($nonce_action))); ?>" 
                   class="button button-secondary" target="_blank">
                    <span class="dashicons dashicons-download" style="vertical-align: middle;"></span>
                    <?php _e('Download PDF', 'we-invoice'); ?>
                </a>
            <?php endif; ?>
            
            <button type="button" 
                    class="button button-secondary we-send-invoice" 
                    data-order-id="<?php echo esc_attr($order->get_id()); ?>"
                    data-invoice-id="<?php echo esc_attr($invoice['id']); ?>"
                    data-invoice-type="<?php echo esc_attr($invoice_type); ?>">
                <span class="dashicons dashicons-email-alt" style="vertical-align: middle;"></span>
                <?php _e('Send Email', 'we-invoice'); ?>
            </button>
            
            <button type="button" 
                    class="button button-primary we-regenerate-invoice" 
                    data-order-id="<?php echo esc_attr($order->get_id()); ?>"
                    data-invoice-type="<?php echo esc_attr($invoice_type); ?>">
                <span class="dashicons dashicons-update" style="vertical-align: middle;"></span>
                <?php _e('Regenerate', 'we-invoice'); ?>
            </button>
        </div>
        
    <?php else: ?>
        <p><?php echo sprintf(__('No %s invoice generated yet.', 'we-invoice'), strtolower($invoice_type_label)); ?></p>
        <button type="button" 
                class="button button-primary we-generate-invoice" 
                data-order-id="<?php echo esc_attr($order->get_id()); ?>"
                data-invoice-type="<?php echo esc_attr($invoice_type); ?>">
            <span class="dashicons dashicons-plus-alt" style="vertical-align: middle;"></span>
            <?php echo sprintf(__('Generate %s Invoice', 'we-invoice'), $invoice_type_label); ?>
        </button>
    <?php endif; ?>
</div>

<style>
.invoice-status {
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}

.invoice-status-generated {
    background: #e1f5fe;
    color: #0277bd;
}

.invoice-status-sent {
    background: #e8f5e8;
    color: #2e7d32;
}

.invoice-status-failed {
    background: #ffebee;
    color: #c62828;
}

.we-invoice-actions .button {
    margin-right: 5px;
    margin-bottom: 5px;
}

.we-invoice-actions .dashicons {
    font-size: 16px;
    width: 16px;
    height: 16px;
}
</style>
