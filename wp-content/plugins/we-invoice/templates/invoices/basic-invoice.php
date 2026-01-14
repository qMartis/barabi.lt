<?php

/**
 * Basic Invoice Template
 *
 * @var \WC_Order $order
 * @var array $invoice
 * @var string $invoice_id
 * @var array $company_details
 */

defined('ABSPATH') || exit;

// Check if Polylang is installed and activated
if (function_exists('pll_get_post_language')) {
    $order_language = pll_get_post_language($order->get_id());
    if ($order_language) {
        switch_to_locale($order_language);
    }
}

// Extract customer data from invoice if available
$customer_data = [];
if (isset($invoice['customer_data']) && !empty($invoice['customer_data'])) {
    $customer_data = json_decode($invoice['customer_data'], true);
}

// Extract seller data from invoice if available, fallback to company_details
$seller_data = [];
if (isset($invoice['seller_data']) && !empty($invoice['seller_data'])) {
    $seller_data = json_decode($invoice['seller_data'], true);
}

// Use seller data if available, otherwise fallback to company_details
$company_name = !empty($seller_data['name']) ? $seller_data['name'] : $company_details['name'];
?>

<!-- Simple header -->
<div class="invoice-header">
    <div class="header-left">
        <?php
          $logo_url = get_option('we_invoice_logo', '');
        if (!empty($logo_url)): ?>
            <div class="company-logo">
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($company_name); ?>" style="max-height: 80px; max-width: 200px;">
            </div>
        <?php endif; ?>
    </div>
    <div class="header-right">
        <div class="invoice-title">
            <h1><?= __('Invoice', 'we-invoice'); ?></h1>
        </div>
    </div>
</div>
<div class="buyer-details-section" style="margin-bottom: 20px; width: 48%; float: left; margin-right: 2%;  box-sizing: border-box;">
    <h3 style="margin: 0 0 10px 0; font-size: 14px; "><?php _e('Buyer Information:', 'we-invoice'); ?></h3>
    <div class="buyer-info">
        <?php
        // Display company name or customer name
        $display_name = !empty($customer_data['company_name_alt']) ? $customer_data['company_name_alt'] : 
                       (!empty($customer_data['company']) ? $customer_data['company'] : $customer_data['name']);
        echo '<strong>' . esc_html($display_name) . '</strong><br>';

        // Display address
        $address = !empty($customer_data['company_address_alt']) ? $customer_data['company_address_alt'] : $customer_data['address'];
        echo wp_kses_post($address) . '<br>';

        // Display company codes if available
        if (!empty($customer_data['company_code'])) {
            echo '<strong>' . __('Company Code:', 'we-invoice') . '</strong> ' . esc_html($customer_data['company_code']) . '<br>';
        }
        if (!empty($customer_data['company_vat'])) {
            echo '<strong>' . __('VAT Code:', 'we-invoice') . '</strong> ' . esc_html($customer_data['company_vat']) . '<br>';
        }

        // Display contact info
        if (!empty($customer_data['email'])) {
            echo esc_html($customer_data['email']) . '<br>';
        }
        if (!empty($customer_data['phone'])) {
            echo esc_html($customer_data['phone']);
        }
        ?>
    </div>
</div>

<!-- Seller Details Section -->
<?php if (!empty($seller_data)): ?>
    <div class="seller-details-section" style="margin-bottom: 20px; width: 48%; float: right;   box-sizing: border-box;">
        <h3 style="margin: 0 0 10px 0; font-size: 14px; "><?php _e('Seller Information:', 'we-invoice'); ?></h3>
        <div class="seller-info">
            <?php if (!empty($seller_data['name'])): ?>
                <div><strong><?php echo esc_html($seller_data['name']); ?></strong></div>
            <?php endif; ?>

            <?php if (!empty($seller_data['code'])): ?>
                <div><?php _e('Company Code:', 'we-invoice'); ?> <?php echo esc_html($seller_data['code']); ?></div>
            <?php endif; ?>

            <?php if (!empty($seller_data['vat'])): ?>
                <div><?php _e('VAT Code:', 'we-invoice'); ?> <?php echo esc_html($seller_data['vat']); ?></div>
            <?php endif; ?>

            <?php if (!empty($seller_data['address'])): ?>
                <div style="margin-top: 5px;"><?php echo nl2br(esc_html($seller_data['address'])); ?></div>
            <?php endif; ?>

            <div style="margin-top: 10px;">
                <?php if (!empty($seller_data['phone'])): ?>
                    <div><?php _e('Phone:', 'we-invoice'); ?> <?php echo esc_html($seller_data['phone']); ?></div>
                <?php endif; ?>

                <?php if (!empty($seller_data['email'])): ?>
                    <div><?php _e('Email:', 'we-invoice'); ?> <?php echo esc_html($seller_data['email']); ?></div>
                <?php endif; ?>


            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Clear floats -->
<div style="clear: both;"></div>

<!-- Invoice details -->
<div class="invoice-details">


    <div class="order-info">
        <div class="order-row">
            <span class="label"><?php _e('Invoice Number:', 'we-invoice'); ?></span>
            <span class="value"><?php echo esc_html($invoice_id); ?></span>
        </div>
        <div class="order-row">
            <span class="label"><?php _e('Invoice Date:', 'we-invoice'); ?></span>
            <span class="value"><?php echo date_i18n(get_option('date_format')); ?></span>
        </div>
        <div class="order-row">
            <span class="label"><?php _e('Order Number:', 'we-invoice'); ?></span>
            <span class="value">#<?php echo esc_html($order->get_order_number()); ?></span>
        </div>
        <div class="order-row">
            <span class="label"><?php _e('Order Date:', 'we-invoice'); ?></span>
            <span class="value"><?php echo date_i18n(get_option('date_format'), $order->get_date_created()->getTimestamp()); ?></span>
        </div>
    </div>
</div>

<!-- Products table -->
<table class="products-table">
    <thead>
        <tr>
            <th class="product-col"><?php _e('Products', 'we-invoice'); ?></th>
            <th class="quantity-col"><?php _e('Quantity', 'we-invoice'); ?></th>
            <th class="price-col"><?php _e('Price', 'we-invoice'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order->get_items() as $item_id => $item): ?>
            <?php $product = $item->get_product(); ?>
            <tr>
                <td class="product-col">
                    <?php echo esc_html($item->get_name()); ?>
                    <?php if ($product && $product->get_sku()): ?>
                        <div style="font-size: 10px; color: #666;"><?php _e('SKU:', 'we-invoice'); ?> <?php echo esc_html($product->get_sku()); ?></div>
                    <?php endif; ?>
                </td>
                <td class="quantity-col"><?php echo esc_html($item->get_quantity()); ?></td>
                <td class="price-col"><?php echo $order->get_formatted_line_subtotal($item); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Totals section -->
<div class="totals-section">
    <div class="totals-table">
        <div class="total-row">
            <span class="total-label"><?php _e('Subtotal:', 'we-invoice'); ?></span>
            <span class="total-value"><?php echo wc_price($order->get_subtotal(), ['currency' => $order->get_currency()]); ?></span>
        </div>
        <?php if ($order->get_total_shipping() > 0): ?>
            <div class="total-row">
                <span class="total-label"><?php _e('Shipping:', 'we-invoice'); ?></span>
                <span class="total-value"><?php echo wc_price($order->get_shipping_total(), ['currency' => $order->get_currency()]); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($order->get_total_tax() > 0): ?>
            <div class="total-row">
                <span class="total-label"><?php _e('Tax:', 'we-invoice'); ?></span>
                <span class="total-value"><?php echo wc_price($order->get_total_tax(), ['currency' => $order->get_currency()]); ?></span>
            </div>
        <?php endif; ?>
        <div class="total-row grand-total">
            <span class="total-label"><?php _e('Total:', 'we-invoice'); ?></span>
            <span class="total-value"><?php echo wc_price($order->get_total(), ['currency' => $order->get_currency()]); ?></span>
        </div>
    </div>
</div>

<?php if ($order->get_customer_note()): ?>
    <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border: 1px solid #ddd;">
        <h3 style="margin: 0 0 10px 0; font-size: 14px;"><?php _e('Customer Notes:', 'we-invoice'); ?></h3>
        <p style="margin: 0; font-size: 12px;"><?php echo wp_kses_post(nl2br($order->get_customer_note())); ?></p>
    </div>
<?php endif; ?>

<div class="bottom-spacer"></div>