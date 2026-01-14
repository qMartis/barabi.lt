<?php
/**
 * Autoload required files for WE Invoice plugin
 */

defined('ABSPATH') || exit;
if (!class_exists('\WeInvoice\Includes\Traits\InvoicePdfGenerator')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Traits/InvoicePdfGenerator.php';

// Include models
if (!class_exists('\WeInvoice\Includes\Models\ProformaInvoice')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Models/ProformaInvoice.php';

if (!class_exists('\WeInvoice\Includes\Models\BasicInvoice')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Models/BasicInvoice.php';

if (!class_exists('\WeInvoice\Includes\Controllers\ProformaInvoiceController')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Controllers/ProformaInvoiceController.php';

if (!class_exists('\WeInvoice\Includes\Controllers\BasicInvoiceController')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Controllers/BasicInvoiceController.php';

if (!class_exists('\WeInvoice\Includes\Controllers\SingleOrderPageController')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/Controllers/SingleOrderPageController.php';

if (!class_exists('\WeInvoice\Includes\We_Invoice_Settings')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/we_invoice_settings.php';

if (!class_exists('\WeInvoice\Includes\AdminSettings\We_Invoice_Global_Settings')) 
    require_once WE_INVOICE_PLUGIN_PATH . 'includes/admin-settings/we_invoice_global_settings.php';

