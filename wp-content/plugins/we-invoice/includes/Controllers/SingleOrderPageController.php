<?php

namespace WeInvoice\Includes\Controllers;

defined('ABSPATH') || exit;

use WeInvoice\Includes\Models\ProformaInvoice;
use WeInvoice\Includes\Models\BasicInvoice;

/**
 * Class SingleOrderPageController
 * Handles order page related invoice functionality (meta boxes, admin displays)
 */
class SingleOrderPageController
{
    /**
     * @var ProformaInvoice
     */
    private $proformaModel;

    /**
     * @var BasicInvoice
     */
    private $basicModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->proformaModel = new ProformaInvoice();
        $this->basicModel = new BasicInvoice();
    }

    /**
     * Initialize the controller
     *
     * @return void
     */
    public function init(): void
    {
        $this->registerAdminActions();
        $this->registerAjaxActions();
    }

    /**
     * Register admin-specific actions
     *
     * @return void
     */
    private function registerAdminActions(): void
    {
        // Add meta box to order edit page
        add_action('add_meta_boxes', [$this, 'addInvoiceMetaBox']);
        
        
        // Enqueue admin scripts and styles
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
    }

    /**
     * Register AJAX actions for both invoice types
     *
     * @return void
     */
    private function registerAjaxActions(): void
    {
        // Proforma invoice actions
        add_action('wp_ajax_generate_proforma_invoice', [$this, 'ajaxGenerateProformaInvoice']);
        add_action('wp_ajax_send_proforma_invoice', [$this, 'ajaxSendProformaInvoice']);
        add_action('wp_ajax_download_proforma_invoice', [$this, 'ajaxDownloadProformaInvoice']);
        
        // Basic invoice actions
        add_action('wp_ajax_generate_basic_invoice', [$this, 'ajaxGenerateBasicInvoice']);
        add_action('wp_ajax_send_basic_invoice', [$this, 'ajaxSendBasicInvoice']);
        add_action('wp_ajax_download_basic_invoice', [$this, 'ajaxDownloadBasicInvoice']);
    }

    /**
     * Add invoice meta box to order edit page
     *
     * @return void
     */
    public function addInvoiceMetaBox(): void
    {
        $screen = get_current_screen();
        
        // Support both traditional post-based orders and HPOS
        if ($screen && in_array($screen->id, ['shop_order', 'woocommerce_page_wc-orders'])) {
            // For HPOS compatibility, use different approaches
            if ($screen->id === 'woocommerce_page_wc-orders') {
                // HPOS screen
                add_meta_box(
                    'woocommerce-order-invoice-management',
                    __('Invoice Management', 'we-invoice'),
                    [$this, 'renderInvoiceMetaBox'],
                    $screen->id,
                    'side',
                    'default'
                );
            } else {
                // Traditional post-based orders
                add_meta_box(
                    'woocommerce-order-invoice-management',
                    __('Invoice Management', 'we-invoice'),
                    [$this, 'renderInvoiceMetaBox'],
                    'shop_order',
                    'side',
                    'default'
                );
            }
        }
    }

    /**
     * Render combined invoice meta box
     *
     * @param \WP_Post $post
     * @return void
     */
    public function renderInvoiceMetaBox($post): void
    {
        // Handle both traditional posts and HPOS orders
        if (isset($post->ID)) {
            $order_id = $post->ID;
        } elseif (is_object($post) && method_exists($post, 'get_id')) {
            $order_id = $post->get_id();
        } else {
            // Fallback for HPOS
            global $theorder;
            if ($theorder && method_exists($theorder, 'get_id')) {
                $order_id = $theorder->get_id();
            } else {
                return; // Can't determine order ID
            }
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $proformaInvoice = $this->proformaModel->getByOrderId($order_id);
        $basicInvoice = $this->basicModel->getByOrderId($order_id);

        echo $this->loadTemplate('admin/invoice-meta-box.php', [
            'order' => $order,
            'order_id' => $order_id,
            'proforma_invoice' => $proformaInvoice,
            'basic_invoice' => $basicInvoice
        ]);
    }

    /**
     * Enqueue admin assets
     *
     * @return void
     */
    public function enqueueAdminAssets(): void
    {
        $screen = get_current_screen();
        
        // Support both traditional post-based orders and HPOS
        if ($screen && in_array($screen->id, ['shop_order', 'edit-shop_order', 'woocommerce_page_wc-orders'])) {
            
            // Enqueue WordPress postbox script for draggable meta boxes
            wp_enqueue_script('postbox');
            
            wp_enqueue_script(
                'we-invoice-admin',
                WE_INVOICE_PLUGIN_URL . 'assets/js/invoice-admin.js',
                ['jquery', 'postbox'],
                '1.0.0',
                true
            );

            wp_enqueue_style(
                'we-invoice-admin',
                WE_INVOICE_PLUGIN_URL . 'assets/css/invoice-admin.css',
                [],
                '1.0.0'
            );

            wp_localize_script('we-invoice-admin', 'weInvoice', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('we_invoice_nonce'),
                'strings' => [
                    'generating' => __('Generating invoice...', 'we-invoice'),
                    'sending' => __('Sending invoice...', 'we-invoice'),
                    'success' => __('Action completed successfully', 'we-invoice'),
                    'error' => __('An error occurred', 'we-invoice')
                ]
            ]);
            
            // Add inline script to initialize postboxes for HPOS compatibility
            wp_add_inline_script('postbox', '
                jQuery(document).ready(function($) {
                    if (typeof postboxes !== "undefined") {
                        // Get the page name for HPOS compatibility
                        var page = pagenow || "woocommerce_page_wc-orders";
                        postboxes.add_postbox_toggles(page);
                    }
                });
            ');
        }
    }

    /**
     * AJAX: Generate proforma invoice
     *
     * @return void
     */
    public function ajaxGenerateProformaInvoice(): void
    {
        check_ajax_referer('we_invoice_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(['message' => __('Insufficient permissions', 'we-invoice')]);
        }

        $orderId = intval($_POST['order_id']);
        if (!$orderId) {
            wp_send_json_error(['message' => __('Invalid order ID', 'we-invoice')]);
        }

        // Use ProformaInvoiceController for creation
        $proformaController = new \WeInvoice\Includes\Controllers\ProformaInvoiceController();
        $invoiceId = $proformaController->createInvoice($orderId);

        if ($invoiceId) {
            wp_send_json_success([
                'message' => __('Proforma invoice generated successfully', 'we-invoice'),
                'invoice_id' => $invoiceId
            ]);
        } else {
            wp_send_json_error(['message' => __('Failed to generate proforma invoice', 'we-invoice')]);
        }
    }

    /**
     * AJAX: Send proforma invoice
     *
     * @return void
     */
    public function ajaxSendProformaInvoice(): void
    {
        check_ajax_referer('we_invoice_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(['message' => __('Insufficient permissions', 'we-invoice')]);
        }

        $orderId = intval($_POST['order_id']);
        $invoiceId = intval($_POST['invoice_id']);

        if (!$orderId || !$invoiceId) {
            wp_send_json_error(['message' => __('Invalid parameters', 'we-invoice')]);
        }

        // Use ProformaInvoiceController for sending
        $proformaController = new \WeInvoice\Includes\Controllers\ProformaInvoiceController();
        
        // Note: Invoice will be automatically attached to order emails via EmailIntegration
        wp_send_json_success(['message' => __('Proforma invoice sent successfully', 'we-invoice')]);
    }

    /**
     * AJAX: Download proforma invoice
     *
     * @return void
     */
    public function ajaxDownloadProformaInvoice(): void
    {
        check_ajax_referer('we_invoice_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Insufficient permissions', 'we-invoice'));
        }

        $invoiceId = intval($_GET['invoice_id']);
        if (!$invoiceId) {
            wp_die(__('Invalid invoice ID', 'we-invoice'));
        }

        // Use ProformaInvoiceController for download
        $proformaController = new \WeInvoice\Includes\Controllers\ProformaInvoiceController();
        $proformaController->downloadInvoice($invoiceId, 'proforma-');
    }

    /**
     * AJAX: Generate basic invoice
     *
     * @return void
     */
    public function ajaxGenerateBasicInvoice(): void
    {
        check_ajax_referer('we_invoice_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(['message' => __('Insufficient permissions', 'we-invoice')]);
        }

        $orderId = intval($_POST['order_id']);
        if (!$orderId) {
            wp_send_json_error(['message' => __('Invalid order ID', 'we-invoice')]);
        }

        // Use BasicInvoiceController for creation
        $basicController = new \WeInvoice\Includes\Controllers\BasicInvoiceController();
        $invoiceId = $basicController->createInvoice($orderId);

        if ($invoiceId) {
            wp_send_json_success([
                'message' => __('Basic invoice generated successfully', 'we-invoice'),
                'invoice_id' => $invoiceId
            ]);
        } else {
            wp_send_json_error(['message' => __('Failed to generate basic invoice', 'we-invoice')]);
        }
    }


    /**
     * AJAX: Download basic invoice
     *
     * @return void
     */
    public function ajaxDownloadBasicInvoice(): void
    {
        check_ajax_referer('we_invoice_nonce', 'nonce');

        if (!current_user_can('manage_woocommerce')) {
            wp_die(__('Insufficient permissions', 'we-invoice'));
        }

        $invoiceId = intval($_GET['invoice_id']);
        if (!$invoiceId) {
            wp_die(__('Invalid invoice ID', 'we-invoice'));
        }

        // Use BasicInvoiceController for download
        $basicController = new \WeInvoice\Includes\Controllers\BasicInvoiceController();
        $basicController->downloadInvoice($invoiceId, '');
    }

    /**
     * Load template file
     *
     * @param string $template
     * @param array $vars
     * @return string
     */
    private function loadTemplate($template, $vars = []): string
    {
        $templatePath = dirname(dirname(dirname(__FILE__))) . '/templates/' . $template;
        
        if (!file_exists($templatePath)) {
            return '';
        }

        extract($vars);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
}
