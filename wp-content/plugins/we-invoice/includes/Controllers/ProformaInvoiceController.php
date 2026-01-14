<?php

namespace WeInvoice\Includes\Controllers;

defined('ABSPATH') || exit;

use WeInvoice\Includes\Models\ProformaInvoice;
use WeInvoice\Includes\Traits\InvoicePdfGenerator;

/**
 * Class ProformaInvoiceController
 * Handles proforma invoice logic and hooks
 */
class ProformaInvoiceController
{
    use InvoicePdfGenerator;

    /**
     * @var ProformaInvoice
     */
    private $invoiceModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceModel = new ProformaInvoice();
    }

    /**
     * Initialize the controller
     *
     * @return void
     */
    public function init(): void
    {
        // Only initialize if proforma invoices are enabled
        if (!get_option('we_proforma_invoice_enabled', 1)) return;
            
        $this->registerHooks();
        $this->registerEmailHooks();
    }

    /**
     * Register WooCommerce order hooks based on settings
     *
     * @return void
     */
    private function registerHooks(): void
    {
        $selectedHooks = get_option('we_proforma_invoice_order_hooks', ['woocommerce_order_status_pending']);
        
        foreach ($selectedHooks as $hook) {
            add_action($hook, [$this, 'handleOrderStatusChange'], 10, 1);
        }
    }

    /**
     * Register email attachment hooks
     *
     * @return void
     */
    private function registerEmailHooks(): void
    {
        $selectedHooks = get_option('we_proforma_invoice_order_hooks', ['woocommerce_order_status_pending']);
        
        if (!empty($selectedHooks)) {
            add_filter('woocommerce_email_attachments', function($attachments, $email_id, $order) use ($selectedHooks) {
                // Check if current order status matches any configured hook
                $currentOrderStatus = 'woocommerce_order_status_' . $order->get_status();
                if (in_array($currentOrderStatus, $selectedHooks)) 
                    return $this->attachInvoiceToEmails($attachments, $email_id, $order);
                
                return $attachments;
            }, 10, 3);
        }
    }

    /**
     * Handle order status changes
     *
     * @param int $orderId
     * @return void
     */
    public function handleOrderStatusChange($orderId): void
    {
        if (!$orderId) return;

        $order = wc_get_order($orderId);
        if (!$order) return;
        if ($this->invoiceModel->invoiceExists($orderId)) return;
       
        $invoiceId = $this->createInvoice($orderId);
    }

    /**
     * Create a proforma invoice for an order
     *
     * @param int $orderId
     * @return int|false Invoice ID on success, false on failure
     */
    public function createInvoice($orderId)
    {
        try {
            $order = wc_get_order($orderId);
            if (!$order) {
                throw new \Exception('Order not found');
            }

            $invoiceData = $this->prepareInvoiceData($order, 'proforma');
            $invoiceId = $this->invoiceModel->create($invoiceData);
 
            if (!$invoiceId) 
                throw new \Exception('Failed to create invoice record');

            $pdfPath = $this->generatePDF($order, $invoiceId, 'proforma-invoice.php', 'proforma');
            
            if ($pdfPath) 
                $this->invoiceModel->updatePdfPath($invoiceId, $pdfPath);

            $order->add_order_note(sprintf(__('Proforma invoice #%s generated', 'we-invoice'), $invoiceId));

            return $invoiceId;

        } catch (\Exception $e) {
            error_log('Proforma Invoice Creation Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Display invoice actions in admin
     *
     * @param int $orderId
     * @return array|null
     */
    public function displayInvoice($orderId)
    {
        return $this->invoiceModel->getByOrderId($orderId);
    }

    /**
     * Get invoice by ID for admin display
     *
     * @param int $invoiceId
     * @return array|null
     */
    public function getInvoiceById($invoiceId)
    {
        return $this->invoiceModel->getById($invoiceId);
    }


    /**
     * Attach proforma invoice PDF to WooCommerce emails
     *
     * @param array $attachments
     * @param string $email_id
     * @param WC_Order $order
     * @return array
     */
    public function attachInvoiceToEmails($attachments, $email_id, $order): array
    {
        $order_id = $order->get_id();
        $invoice = $this->invoiceModel->getByOrderId($order_id);
        
        // If invoice doesn't exist, create it
        if (!$invoice) {
            error_log("ProformaInvoiceController: No invoice found for order $order_id, creating one for email attachment");
            $invoiceId = $this->createInvoice($order_id);
            if ($invoiceId) {
                $invoice = $this->invoiceModel->getById($invoiceId);
            }
        }
        
        // If invoice exists but PDF doesn't exist, generate it
        if ($invoice && (empty($invoice['pdf_path']) || !file_exists($invoice['pdf_path']))) {
            error_log("ProformaInvoiceController: PDF missing for invoice, generating for email attachment");
            $pdfPath = $this->generatePDF($order, $invoice['id'], 'proforma-invoice.php', 'proforma');
            if ($pdfPath) {
                $this->invoiceModel->updatePdfPath($invoice['id'], $pdfPath);
                $invoice['pdf_path'] = $pdfPath;
            }
        }
        
        // Attach PDF if it exists
        if ($invoice && !empty($invoice['pdf_path']) && file_exists($invoice['pdf_path'])) {
            $attachments[] = $invoice['pdf_path'];
            error_log("ProformaInvoiceController: Attached invoice PDF to email for order $order_id");
        }

        return $attachments;
    }
}
