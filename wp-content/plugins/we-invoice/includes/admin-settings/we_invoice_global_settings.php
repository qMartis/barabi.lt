<?php

namespace WeInvoice\Includes\AdminSettings;

defined('ABSPATH') || exit;

/**
 * Class We_Invoice_Global_Settings
 * Handles logo upload in global plugin-wide settings.
 */
class We_Invoice_Global_Settings
{

    /**
     * Initialize global settings
     *
     * @return void
     */
    public function init(): void
    {
        add_action('admin_init', [$this, 'registerSettings']);

        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_ajax_get_order_meta_fields', [$this, 'ajaxGetOrderMetaFields']);
    }

    /**
     * Enqueue scripts and styles for the media uploader
     *
     * @return void
     */
    public function enqueueScripts(): void
    {
        $screen = get_current_screen();
        // Ensure the scripts load only on the Global Settings page
        if ($screen->id !== 'woocommerce_page_we-invoice-settings') return;

        // Enqueue WordPress media uploader
        wp_enqueue_media();
        wp_enqueue_script(
            'we-invoice-media-uploader',
            WE_INVOICE_PLUGIN_URL  . 'assets/js/admin-logo-picker.js', // Use plugin directory as base
            ['jquery'],
            false,
            true
        );
    }


    /**
     * Render the settings page
     *
     * @return void
     */
    public function renderSettings(): void
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Global Invoice Settings', 'we-invoice'); ?></h1>
            <form method="post" action="options.php">
                <?php
                // Display the settings section and fields
                settings_fields('we_invoice_global_settings');
                do_settings_sections('we_invoice_global_settings');
                submit_button(__('Save Changes', 'we-invoice'));
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Register global settings
     *
     * @return void
     */
    public function registerSettings(): void
    {
        // Add the settings section
        add_settings_section(
            'global_section',
            __('Global Settings', 'we-invoice'),
            null,
            'we_invoice_global_settings'
        );

        // Register the Logo Upload field
        register_setting('we_invoice_global_settings', 'we_invoice_logo');
        add_settings_field(
            'we_invoice_logo',
            __('Logo', 'we-invoice'),
            [$this, 'renderLogoField'],
            'we_invoice_global_settings',
            'global_section'
        );

        $this->registerCompanyDetailsFields();
        $this->registerOrderMetaPickerFields();
    }

    /**
     * Register order meta picker fields for company information
     *
     * @return void
     */
    private function registerOrderMetaPickerFields(): void
    {
        // Order Meta Data Picker fields
        $metaFields = [
            'company_name_meta' => __('Company Name Meta Field', 'we-invoice'),
            'company_code_meta' => __('Company Code Meta Field', 'we-invoice'),
            'company_vat_meta' => __('Company VAT Meta Field', 'we-invoice'),
            'company_address_meta' => __('Company Address Meta Field', 'we-invoice'),
        ];

        foreach ($metaFields as $field => $label) {
            register_setting('we_invoice_global_settings', "we_invoice_{$field}");
            add_settings_field(
                "we_invoice_{$field}",
                $label,
                function () use ($field) {
                    $this->renderOrderMetaPickerField("we_invoice_{$field}");
                },
                'we_invoice_global_settings',
                'global_section'
            );
        }
    }

    /**
     * Register company details fields
     *
     * @return void
     */
    private function registerCompanyDetailsFields(): void
    {
        $fields = [
            'company_name' => __('Company Name', 'we-invoice'),
            'company_address' => __('Address', 'we-invoice'),
            'company_phone' => __('Phone Number', 'we-invoice'),
            'company_email' => __('Email Address', 'we-invoice'),
            'company_code' => __('Company Code', 'we-invoice'),
            'company_vat' => __('Company VAT', 'we-invoice'),
        ];

        foreach ($fields as $field => $label) {
            register_setting('we_invoice_global_settings', "we_invoice_{$field}");
            add_settings_field(
                "we_invoice_{$field}",
                $label,
                function () use ($field) {
                    $this->renderTextField("we_invoice_{$field}");
                },
                'we_invoice_global_settings',
                'global_section'
            );
        }
    }

    /**
     * Render a text field for settings
     *
     * @param string $optionName
     * @return void
     */
    private function renderTextField(string $optionName): void
    {
        $value = get_option($optionName, '');
    ?>
        <input type="text" name="<?php echo esc_attr($optionName); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" />
    <?php
    }

    /**
     * Render the Logo Upload field with media picker
     *
     * @return void
     */
    public function renderLogoField(): void
    {
        $logo = get_option('we_invoice_logo', '');
    ?>
        <div class="we-invoice-logo-picker">
            <input type="hidden" id="we-invoice-logo" name="we_invoice_logo" value="<?php echo esc_attr($logo); ?>" />
            <button type="button" class="button" id="upload-logo-button"><?php esc_html_e('Select Logo', 'we-invoice'); ?></button>
            <button type="button" class="button" id="remove-logo-button" <?php echo empty($logo) ? 'style="display:none;"' : ''; ?>>
                <?php esc_html_e('Remove Logo', 'we-invoice'); ?>
            </button>
            <div id="logo-preview" style="margin-top: 10px;">
                <?php if ($logo): ?>
                    <img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('Logo Preview', 'we-invoice'); ?>" style="max-height: 100px;" />
                <?php endif; ?>
            </div>
        </div>
<?php
    }

    /**
     * Get all orders for the order picker
     *
     * @return array
     */
    private function getAllOrders(): array
    {
        $orders = wc_get_orders([
            'limit' => 50, // Limit to prevent performance issues
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'any'
        ]);

        $orderOptions = [];
        foreach ($orders as $order) {
            $orderOptions[$order->get_id()] = sprintf(
                '#%d - %s (%s)',
                $order->get_id(),
                $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                $order->get_date_created()->format('Y-m-d H:i')
            );
        }

        return $orderOptions;
    }

    /**
     * Get all meta data from a specific order
     *
     * @param int $orderId
     * @return array
     */
    private function getOrderMetaData(int $orderId): array
    {
        if (empty($orderId)) {
            return [];
        }

        $order = wc_get_order($orderId);
        if (!$order) {
            return [];
        }

        $metaData = [];
        
        // Add standard billing/shipping fields first with their actual values
        $standardFields = [
            '_billing_company' => 'Billing Company',
            '_billing_first_name' => 'Billing First Name',
            '_billing_last_name' => 'Billing Last Name',
            '_billing_address_1' => 'Billing Address 1',
            '_billing_address_2' => 'Billing Address 2',
            '_billing_city' => 'Billing City',
            '_billing_state' => 'Billing State',
            '_billing_postcode' => 'Billing Postcode',
            '_billing_country' => 'Billing Country',
            '_billing_email' => 'Billing Email',
            '_billing_phone' => 'Billing Phone',
            '_shipping_company' => 'Shipping Company',
            '_shipping_first_name' => 'Shipping First Name',
            '_shipping_last_name' => 'Shipping Last Name',
            '_shipping_address_1' => 'Shipping Address 1',
            '_shipping_address_2' => 'Shipping Address 2',
            '_shipping_city' => 'Shipping City',
            '_shipping_state' => 'Shipping State',
            '_shipping_postcode' => 'Shipping Postcode',
            '_shipping_country' => 'Shipping Country',
        ];

        // Use proper getter methods for standard fields
        foreach ($standardFields as $key => $label) {
            $value = '';
            switch ($key) {
                case '_billing_company': $value = $order->get_billing_company(); break;
                case '_billing_first_name': $value = $order->get_billing_first_name(); break;
                case '_billing_last_name': $value = $order->get_billing_last_name(); break;
                case '_billing_address_1': $value = $order->get_billing_address_1(); break;
                case '_billing_address_2': $value = $order->get_billing_address_2(); break;
                case '_billing_city': $value = $order->get_billing_city(); break;
                case '_billing_state': $value = $order->get_billing_state(); break;
                case '_billing_postcode': $value = $order->get_billing_postcode(); break;
                case '_billing_country': $value = $order->get_billing_country(); break;
                case '_billing_email': $value = $order->get_billing_email(); break;
                case '_billing_phone': $value = $order->get_billing_phone(); break;
                case '_shipping_company': $value = $order->get_shipping_company(); break;
                case '_shipping_first_name': $value = $order->get_shipping_first_name(); break;
                case '_shipping_last_name': $value = $order->get_shipping_last_name(); break;
                case '_shipping_address_1': $value = $order->get_shipping_address_1(); break;
                case '_shipping_address_2': $value = $order->get_shipping_address_2(); break;
                case '_shipping_city': $value = $order->get_shipping_city(); break;
                case '_shipping_state': $value = $order->get_shipping_state(); break;
                case '_shipping_postcode': $value = $order->get_shipping_postcode(); break;
                case '_shipping_country': $value = $order->get_shipping_country(); break;
            }
            
            if (!empty($value)) {
                $metaData[$key] = sprintf('[INTERNAL] %s (Value: %s)', $label, $value);
            } else {
                $metaData[$key] = sprintf('[INTERNAL] %s (empty)', $label);
            }
        }

        // Get all custom meta fields (non-internal)
        $orderMeta = $order->get_meta_data();
        foreach ($orderMeta as $meta) {
            $key = $meta->get_data()['key'];
            $value = $meta->get_data()['value'];
            
            // Only include custom meta keys (those that don't start with _)
            if (strpos($key, '_') !== 0) {
                $metaData[$key] = sprintf('[CUSTOM] %s (Value: %s)', $key, is_array($value) ? json_encode($value) : $value);
            }
        }

        // Also get ALL internal meta fields using get_meta_data() with no filtering
        $allMeta = $order->get_meta_data();
        foreach ($allMeta as $meta) {
            $key = $meta->get_data()['key'];
            $value = $meta->get_data()['value'];
            
            // Include internal meta that's not in our standard fields list
            if (strpos($key, '_') === 0 && !isset($standardFields[$key])) {
                $metaData[$key] = sprintf('[OTHER] %s (Value: %s)', $key, is_array($value) ? json_encode($value) : (string)$value);
            }
        }

        return $metaData;
    }

    /**
     * Render order meta picker field
     *
     * @param string $optionName
     * @return void
     */
    public function renderOrderMetaPickerField(string $optionName): void
    {
        $selectedMeta = get_option($optionName, '');
        $orders = $this->getAllOrders();
    ?>
        <div class="we-invoice-meta-picker">
            <div style="margin-bottom: 10px;">
                <label><?php esc_html_e('Select an order to view meta fields:', 'we-invoice'); ?></label><br>
                <select id="order-selector-<?php echo esc_attr($optionName); ?>" style="min-width: 300px;">
                    <option value=""><?php esc_html_e('Select an order...', 'we-invoice'); ?></option>
                    <?php foreach ($orders as $orderId => $orderLabel): ?>
                        <option value="<?php echo esc_attr($orderId); ?>"><?php echo esc_html($orderLabel); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="button" onclick="loadOrderMeta('<?php echo esc_attr($optionName); ?>')"><?php esc_html_e('Load Meta Fields', 'we-invoice'); ?></button>
            </div>
            
            <div id="meta-fields-<?php echo esc_attr($optionName); ?>" style="margin-bottom: 10px; display: none;">
                <label><?php esc_html_e('Select meta field:', 'we-invoice'); ?></label><br>
                <select name="<?php echo esc_attr($optionName); ?>" id="meta-selector-<?php echo esc_attr($optionName); ?>" style="min-width: 300px;">
                    <option value=""><?php esc_html_e('Select a meta field...', 'we-invoice'); ?></option>
                </select>
            </div>
            
            <?php if (!empty($selectedMeta)): ?>
                <div style="padding: 10px; background: #f0f0f0; border-radius: 3px;">
                    <strong><?php esc_html_e('Currently selected:', 'we-invoice'); ?></strong> <?php echo esc_html($selectedMeta); ?>
                </div>
            <?php endif; ?>
        </div>

        <script type="text/javascript">
        function loadOrderMeta(optionName) {
            var orderId = document.getElementById('order-selector-' + optionName).value;
            if (!orderId) {
                alert('<?php esc_html_e('Please select an order first.', 'we-invoice'); ?>');
                return;
            }

            // AJAX call to get order meta
            var data = {
                'action': 'get_order_meta_fields',
                'order_id': orderId,
                'nonce': '<?php echo wp_create_nonce('get_order_meta_nonce'); ?>'
            };

            jQuery.post(ajaxurl, data, function(response) {
                if (response.success) {
                    var metaSelector = document.getElementById('meta-selector-' + optionName);
                    metaSelector.innerHTML = '<option value=""><?php esc_html_e('Select a meta field...', 'we-invoice'); ?></option>';
                    
                    for (var key in response.data) {
                        var option = document.createElement('option');
                        option.value = key;
                        option.textContent = response.data[key];
                        metaSelector.appendChild(option);
                    }
                    
                    document.getElementById('meta-fields-' + optionName).style.display = 'block';
                } else {
                    alert('<?php esc_html_e('Error loading meta fields.', 'we-invoice'); ?>');
                }
            });
        }
        </script>
    <?php
    }

    /**
     * AJAX handler to get order meta fields
     *
     * @return void
     */
    public function ajaxGetOrderMetaFields(): void
    {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'get_order_meta_nonce')) {
            wp_die('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('manage_woocommerce')) {
            wp_die('Insufficient permissions');
        }

        $orderId = intval($_POST['order_id']);
        if (empty($orderId)) {
            wp_send_json_error('Invalid order ID');
        }

        $metaData = $this->getOrderMetaData($orderId);
        
        if (empty($metaData)) {
            wp_send_json_error('No meta data found for this order');
        }

        wp_send_json_success($metaData);
    }
}
