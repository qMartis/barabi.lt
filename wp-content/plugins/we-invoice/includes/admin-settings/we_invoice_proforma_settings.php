<?php

namespace WeInvoice\Includes\AdminSettings;

defined('ABSPATH') || exit;

/**
 * Class We_Invoice_proforma_Invoice_Settings
 * Handles proforma invoice settings.
 */
class We_Invoice_Proforma_Settings
{

    /**
     * Initialize proforma invoice settings
     *
     * @return void
     */
    public function init(): void
    {
        add_action('admin_init', [$this, 'registerSettings']);

    }

    /**
     * Render the settings page
     *
     * @return void
     */
    public function renderSettingsPage(): void
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Proforma Invoice Settings', 'we-invoice'); ?></h1>
            <form method="post" action="options.php">
                <?php
                $this->renderSettings(); // Render all settings
                submit_button(__('Save Changes', 'we-invoice'));
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Render all settings
     *
     * @return void
     */
    public function renderSettings(): void
    {
        settings_fields('we_invoice_proforma_settings'); // Nonce and group
        do_settings_sections('we_invoice_proforma_settings'); // Settings fields
    }

    /**
     * Register proforma invoice settings
     *
     * @return void
     */
    public function registerSettings(): void
    {
        // Handle counter reset if requested
        $this->handleCounterReset();
        
        // Add the settings section
        add_settings_section(
            'proforma_invoice_section',
            __('Proforma Invoice Settings', 'we-invoice'),
            null,
            'we_invoice_proforma_settings'
        );

        // Enable/Disable proforma Invoice Settings
        register_setting('we_invoice_proforma_settings', 'we_proforma_invoice_enabled');
        add_settings_field(
            'we_proforma_invoice_enabled',
            __('Enable proforma Invoice', 'we-invoice'),
            [$this, 'renderEnableField'],
            'we_invoice_proforma_settings',
            'proforma_invoice_section'
        );


        // Invoice Prefix
        register_setting('we_invoice_proforma_settings', 'we_proforma_invoice_prefix');
        add_settings_field(
            'we_proforma_invoice_prefix',
            __('Proforma Invoice Prefix', 'we-invoice'),
            [$this, 'renderPrefixField'],
            'we_invoice_proforma_settings',
            'proforma_invoice_section'
        );

        // Starting Number
        register_setting('we_invoice_proforma_settings', 'we_proforma_invoice_starting_number');
        add_settings_field(
            'we_proforma_invoice_starting_number',
            __('Starting Number', 'we-invoice'),
            [$this, 'renderStartingNumberField'],
            'we_invoice_proforma_settings',
            'proforma_invoice_section'
        );

        // Register the reset counter field (but don't save it to database)
        register_setting('we_invoice_proforma_settings', 'we_proforma_invoice_reset_counter', [
            'type' => 'boolean',
            'default' => false,
            'sanitize_callback' => function($value) {
                // Don't actually save this value, we just process it
                return false;
            }
        ]);

        // Order Status Hooks for Invoice Generation
        register_setting('we_invoice_proforma_settings', 'we_proforma_invoice_order_hooks');
        add_settings_field(
            'we_proforma_invoice_order_hooks',
            __('Generate Proforma Invoice On', 'we-invoice'),
            [$this, 'renderOrderHooksField'],
            'we_invoice_proforma_settings',
            'proforma_invoice_section'
        );


    }

    /**
     * Render the Enable/Disable field
     *
     * @return void
     */
    public function renderEnableField(): void
    {
        $enabled = get_option('we_proforma_invoice_enabled', 1);
    ?>
        <input type="checkbox" name="we_proforma_invoice_enabled" value="1" <?php checked($enabled, 1); ?> />
        <p class="description"><?php esc_html_e('Enable or disable proforma invoice settings.', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Render the Invoice Prefix field
     *
     * @return void
     */
    public function renderPrefixField(): void
    {
        $prefix = get_option('we_proforma_invoice_prefix', 'INV-');
    ?>
        <input type="text" name="we_proforma_invoice_prefix" value="<?php echo esc_attr($prefix); ?>" class="regular-text" />
        <p class="description"><?php esc_html_e('Set a prefix for invoices (e.g., PROFORMA-).', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Render the Starting Number field
     *
     * @return void
     */
    public function renderStartingNumberField(): void
    {
        $startingNumber = get_option('we_proforma_invoice_starting_number', 1);
        $currentNumber = get_option('we_proforma_invoice_current_number', $startingNumber);
        
        // Get the latest invoice number from the database
        $latestInvoiceNumber = $this->getLatestProformaInvoiceNumber();
    ?>
        <div class="invoice-number-settings">
            <input type="number" name="we_proforma_invoice_starting_number" value="<?php echo esc_attr($startingNumber); ?>" class="small-text" min="1" />
            <p class="description">
                <?php esc_html_e('Set the starting number for proforma invoice numbering.', 'we-invoice'); ?><br>
                <strong><?php esc_html_e('Current next number:', 'we-invoice'); ?></strong> <?php echo esc_html($currentNumber); ?><br>
                <?php if ($latestInvoiceNumber): ?>
                    <strong><?php esc_html_e('Latest invoice number:', 'we-invoice'); ?></strong> <?php echo esc_html($latestInvoiceNumber); ?>
                <?php else: ?>
                    <em><?php esc_html_e('No invoices created yet.', 'we-invoice'); ?></em>
                <?php endif; ?>
            </p>
            
            <div style="margin-top: 10px;">
                <label>
                    <input type="checkbox" name="we_proforma_invoice_reset_counter" value="1" />
                    <?php esc_html_e('Reset next invoice number to this starting number', 'we-invoice'); ?>
                </label>
                <p class="description">
                    <?php esc_html_e('Check this box to reset the invoice counter. The next invoice will use the starting number above.', 'we-invoice'); ?>
                </p>
            </div>
        </div>
    <?php
    }

    /**
     * Render the Order Hooks field
     *
     * @return void
     */
    public function renderOrderHooksField(): void
    {
        $selectedHooks = get_option('we_proforma_invoice_order_hooks', ['woocommerce_order_status_pending']);
        
        $availableHooks = [
            'woocommerce_new_order' => __('Order Created (New Order)', 'we-invoice'),
            'woocommerce_order_status_pending' => __('Order Status: Pending Payment', 'we-invoice'),
            'woocommerce_order_status_processing' => __('Order Status: Processing', 'we-invoice'),
            'woocommerce_order_status_on-hold' => __('Order Status: On Hold', 'we-invoice'),
            'woocommerce_order_status_completed' => __('Order Status: Completed', 'we-invoice'),
            'woocommerce_payment_complete' => __('Payment Completed', 'we-invoice'),
        ];
    ?>
        <fieldset>
            <legend class="screen-reader-text"><?php esc_html_e('Select when to generate proforma invoices', 'we-invoice'); ?></legend>
            <?php foreach ($availableHooks as $hook => $label): ?>
                <label>
                    <input type="checkbox" name="we_proforma_invoice_order_hooks[]" value="<?php echo esc_attr($hook); ?>" 
                           <?php checked(in_array($hook, $selectedHooks)); ?> />
                    <?php echo esc_html($label); ?>
                </label><br>
            <?php endforeach; ?>
        </fieldset>
        <p class="description"><?php esc_html_e('Select when proforma invoices should be automatically generated.', 'we-invoice'); ?></p>
    <?php
    }

  


    /**
     * Get the latest proforma invoice number from the database
     *
     * @return string|null
     */
    private function getLatestProformaInvoiceNumber(): ?string
    {
        // Get the latest proforma invoice post
        $latest_invoice = get_posts([
            'post_type' => 'we_proforma_invoice',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => [
                [
                    'key' => '_invoice_number',
                    'compare' => 'EXISTS'
                ]
            ]
        ]);

        if (!empty($latest_invoice)) {
            return get_post_meta($latest_invoice[0]->ID, '_invoice_number', true);
        }

        return null;
    }

    /**
     * Handle counter reset when the option is checked
     *
     * @return void
     */
    private function handleCounterReset(): void
    {
        // Check if form was submitted and reset counter is checked
        if (isset($_POST['we_proforma_invoice_reset_counter']) && $_POST['we_proforma_invoice_reset_counter'] === '1') {
            $startingNumber = intval($_POST['we_proforma_invoice_starting_number'] ?? 1);
            
            // Update the current number to the starting number
            update_option('we_proforma_invoice_current_number', $startingNumber);
            
            // Add admin notice
            add_action('admin_notices', function() use ($startingNumber) {
                echo '<div class="notice notice-success is-dismissible">';
                echo '<p>' . sprintf(
                    __('Proforma invoice counter has been reset. Next invoice will be #%d.', 'we-invoice'),
                    $startingNumber
                ) . '</p>';
                echo '</div>';
            });
        }
    }

}
