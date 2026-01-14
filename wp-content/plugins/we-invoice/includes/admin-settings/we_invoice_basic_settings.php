<?php

namespace WeInvoice\Includes\AdminSettings;

defined('ABSPATH') || exit;


class We_Invoice_Basic_Settings
{

    /**
     * Initialize basic invoice settings
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
            <h1><?php esc_html_e('Basic Invoice Settings', 'we-invoice'); ?></h1>
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
        settings_fields('we_invoice_basic_settings'); // Nonce and group
        do_settings_sections('we_invoice_basic_settings'); // Settings fields
    }

    /**
     * Register basic invoice settings
     *
     * @return void
     */
    public function registerSettings(): void
    {
        // Handle counter reset if requested
        $this->handleCounterReset();
        
        // Add the settings section
        add_settings_section(
            'basic_invoice_section',
            __('Basic Invoice Settings', 'we-invoice'),
            null,
            'we_invoice_basic_settings'
        );

        // Enable/Disable Basic Invoice Settings
        register_setting('we_invoice_basic_settings', 'we_invoice_basic_enabled');
        add_settings_field(
            'we_invoice_basic_enabled',
            __('Enable Basic Invoice', 'we-invoice'),
            [$this, 'renderEnableField'],
            'we_invoice_basic_settings',
            'basic_invoice_section'
        );

        // Invoice Prefix
        register_setting('we_invoice_basic_settings', 'we_invoice_prefix');
        add_settings_field(
            'we_invoice_prefix',
            __('Invoice Prefix', 'we-invoice'),
            [$this, 'renderPrefixField'],
            'we_invoice_basic_settings',
            'basic_invoice_section'
        );

        // Starting Number
        register_setting('we_invoice_basic_settings', 'we_invoice_starting_number');
        add_settings_field(
            'we_invoice_starting_number',
            __('Starting Number', 'we-invoice'),
            [$this, 'renderStartingNumberField'],
            'we_invoice_basic_settings',
            'basic_invoice_section'
        );

        // Reset Counter (for handling the reset checkbox)
        register_setting('we_invoice_basic_settings', 'we_invoice_reset_counter');

        // Order Status Hooks for Invoice Generation
        register_setting('we_invoice_basic_settings', 'we_invoice_order_hooks');
        add_settings_field(
            'we_invoice_order_hooks',
            __('Generate Basic Invoice On', 'we-invoice'),
            [$this, 'renderOrderHooksField'],
            'we_invoice_basic_settings',
            'basic_invoice_section'
        );

        // Email Settings
        register_setting('we_invoice_basic_settings', 'we_invoice_send_email');
    }

    /**
     * Render the Enable/Disable field
     *
     * @return void
     */
    public function renderEnableField(): void
    {
        $enabled = get_option('we_invoice_basic_enabled', 1);
    ?>
        <input type="checkbox" name="we_invoice_basic_enabled" value="1" <?php checked($enabled, 1); ?> />
        <p class="description"><?php esc_html_e('Enable or disable basic invoice settings.', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Render the Invoice Prefix field
     *
     * @return void
     */
    public function renderPrefixField(): void
    {
        $prefix = get_option('we_invoice_prefix', 'INV-');
    ?>
        <input type="text" name="we_invoice_prefix" value="<?php echo esc_attr($prefix); ?>" class="regular-text" />
        <p class="description"><?php esc_html_e('Set a prefix for invoices (e.g., INV-).', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Render the Starting Number field
     *
     * @return void
     */
    public function renderStartingNumberField(): void
    {
        $startingNumber = get_option('we_invoice_starting_number', 1);
        $currentNumber = get_option('we_invoice_current_number', $startingNumber);
        
        // Get the latest invoice number from the database
        $latestInvoiceNumber = $this->getLatestBasicInvoiceNumber();
    ?>
        <div class="invoice-number-settings">
            <input type="number" name="we_invoice_starting_number" value="<?php echo esc_attr($startingNumber); ?>" class="small-text" min="1" />
            <p class="description">
                <?php esc_html_e('Set the starting number for invoice numbering.', 'we-invoice'); ?><br>
                <strong><?php esc_html_e('Current next number:', 'we-invoice'); ?></strong> <?php echo esc_html($currentNumber); ?><br>
                <?php if ($latestInvoiceNumber): ?>
                    <strong><?php esc_html_e('Latest invoice number:', 'we-invoice'); ?></strong> <?php echo esc_html($latestInvoiceNumber); ?>
                <?php else: ?>
                    <em><?php esc_html_e('No invoices created yet.', 'we-invoice'); ?></em>
                <?php endif; ?>
            </p>
            
            <div style="margin-top: 10px;">
                <label>
                    <input type="checkbox" name="we_invoice_reset_counter" value="1" />
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
        $selectedHooks = get_option('we_invoice_order_hooks', ['woocommerce_order_status_completed']);
        
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
            <legend class="screen-reader-text"><?php esc_html_e('Select when to generate basic invoices', 'we-invoice'); ?></legend>
            <?php foreach ($availableHooks as $hook => $label): ?>
                <label>
                    <input type="checkbox" name="we_invoice_order_hooks[]" value="<?php echo esc_attr($hook); ?>" 
                           <?php checked(in_array($hook, $selectedHooks)); ?> />
                    <?php echo esc_html($label); ?>
                </label><br>
            <?php endforeach; ?>
        </fieldset>
        <p class="description"><?php esc_html_e('Select when basic invoices should be automatically generated.', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Render the Attach to Emails field
     *
     * @return void
     */
    public function renderAttachToEmailsField(): void
    {
        $attachToEmails = get_option('we_invoice_attach_to_emails', 1);
        ?>
        <input type="checkbox" name="we_invoice_attach_to_emails" value="1" <?php checked($attachToEmails, 1); ?> />
        <label><?php esc_html_e('Automatically attach basic invoice PDF to WooCommerce order emails', 'we-invoice'); ?></label>
        <p class="description"><?php esc_html_e('When enabled, the basic invoice PDF will be attached to order status emails (completed, processing, etc.).', 'we-invoice'); ?></p>
        <?php
    }

    /**
     * Render the Show Links in Emails field
     *
     * @return void
     */
    public function renderShowLinksInEmailsField(): void
    {
        $showLinksInEmails = get_option('we_invoice_show_links_in_emails', 1);
        ?>
        <input type="checkbox" name="we_invoice_show_links_in_emails" value="1" <?php checked($showLinksInEmails, 1); ?> />
        <label><?php esc_html_e('Show invoice download links in WooCommerce order emails', 'we-invoice'); ?></label>
        <p class="description"><?php esc_html_e('When enabled, customers will see download links for invoices in their order emails.', 'we-invoice'); ?></p>
        <?php
    }    /**
     * Render the Reset Counter field
     *
     * @return void
     */
    public function renderResetCounterField(): void
    {
    ?>
        <button type="button" class="button button-secondary" onclick="
            if (confirm('<?php echo esc_js(__('Are you sure you want to reset the basic invoice counter to 1? This action cannot be undone.', 'we-invoice')); ?>')) {
                document.getElementById('we_invoice_reset_basic_counter').value = '1';
                document.querySelector('input[name=submit]').click();
            }
        ">
            <?php esc_html_e('Reset Counter to 1', 'we-invoice'); ?>
        </button>
        <input type="hidden" id="we_invoice_reset_basic_counter" name="we_invoice_reset_basic_counter" value="0" />
        <p class="description"><?php esc_html_e('Reset the invoice counter back to 1. This will affect the next generated invoice number.', 'we-invoice'); ?></p>
    <?php
    }

    /**
     * Get the latest basic invoice number
     *
     * @return int
     */
    private function getLatestBasicInvoiceNumber(): int
    {
        $posts = get_posts([
            'post_type' => 'we_basic_invoice',
            'post_status' => 'publish',
            'numberposts' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => [
                [
                    'key' => '_invoice_number',
                    'compare' => 'EXISTS'
                ]
            ]
        ]);

        if (empty($posts)) {
            return 0;
        }

        $invoiceNumber = get_post_meta($posts[0]->ID, '_invoice_number', true);
        
        // Extract numeric part from invoice number (remove prefix/suffix)
        $prefix = get_option('we_invoice_basic_number_prefix', '');
        $suffix = get_option('we_invoice_basic_number_suffix', '');
        
        $numericPart = $invoiceNumber;
        if (!empty($prefix)) {
            $numericPart = str_replace($prefix, '', $numericPart);
        }
        if (!empty($suffix)) {
            $numericPart = str_replace($suffix, '', $numericPart);
        }
        
        return (int) $numericPart;
    }

    /**
     * Handle counter reset
     *
     * @return void
     */
    private function handleCounterReset(): void
    {
        if (isset($_POST['we_invoice_reset_counter']) && $_POST['we_invoice_reset_counter'] === '1') {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'we_invoice_basic_settings-options')) {
                // Reset both the starting number and current number
                $newStartingNumber = isset($_POST['we_invoice_starting_number']) ? (int)$_POST['we_invoice_starting_number'] : 1;
                update_option('we_invoice_starting_number', $newStartingNumber);
                update_option('we_invoice_current_number', $newStartingNumber);
                
                add_settings_error(
                    'we_invoice_basic_settings',
                    'counter_reset',
                    sprintf(__('Basic invoice counter has been reset to %d.', 'we-invoice'), $newStartingNumber),
                    'updated'
                );
            }
        }
    }

   
}
