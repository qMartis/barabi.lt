<?php

/**
 * Plugin Name: We Invoice/Proforma for Woocommerce
 * Description: A WooCommerce plugin for generating, sending, and managing proforma and final invoices. It supports multilingual functionality (Polylang), customizable invoice numbering, PDF generation, and email integration. 
 * Version: 1.0.0
 * Author: Martynas Beržinskas
 * License: GPL-2.0+
 */

defined('ABSPATH') || exit;

// Include Composer's autoloader
if (file_exists(__DIR__ . '/vendor/autoload.php')) 
    require_once __DIR__ . '/vendor/autoload.php';


if (!defined('WE_INVOICE_PLUGIN_URL')) 
    define('WE_INVOICE_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('WE_INVOICE_PLUGIN_PATH')) 
    define('WE_INVOICE_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once WE_INVOICE_PLUGIN_PATH . 'includes/autoload.php';

/**
 * Load text domain for translations
 *
 * @return void
 */
function weInvoiceLoadTextDomain() {
    load_plugin_textdomain('we-invoice', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

/**
 * Initialize the WooCommerce Invoices Plugin
 *
 * @return void
 */
function weInvoiceInit() {
    // Load text domain for translations
    weInvoiceLoadTextDomain();

    // Initialize settings page (admin only)
    if (is_admin() && class_exists('\WeInvoice\Includes\We_Invoice_Settings')) {
        $globalSettings = new \WeInvoice\Includes\We_Invoice_Settings();
        $globalSettings->init();
    }
    
    if (class_exists('\WeInvoice\Includes\Controllers\ProformaInvoiceController')) {
        $proformaController = new \WeInvoice\Includes\Controllers\ProformaInvoiceController();
        $proformaController->init();
    }
    
    if (class_exists('\WeInvoice\Includes\Controllers\BasicInvoiceController')) {
        $basicController = new \WeInvoice\Includes\Controllers\BasicInvoiceController();
        $basicController->init();
    }
    
    if (class_exists('\WeInvoice\Includes\Controllers\SingleOrderPageController')) {
        $orderController = new \WeInvoice\Includes\Controllers\SingleOrderPageController();
        $orderController->init();
    }
}

/**
 * Plugin activation hook
 *
 * @return void
 */
function weInvoiceActivation() {
    // Include the autoloader to make sure models are available
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/autoload.php';
    
    $proformaModel = new \WeInvoice\Includes\Models\ProformaInvoice();
    $proformaModel->registerPostType();
    
    $basicModel = new \WeInvoice\Includes\Models\BasicInvoice();
    $basicModel->registerPostType();
}

/**
 * Plugin deactivation hook
 *
 * @return void
 */
function weInvoiceDeactivation(): void {
    // Clean up any scheduled events or temporary data
}

add_action('plugins_loaded', 'weInvoiceInit');
register_activation_hook(__FILE__, 'weInvoiceActivation');
register_deactivation_hook(__FILE__, 'weInvoiceDeactivation');