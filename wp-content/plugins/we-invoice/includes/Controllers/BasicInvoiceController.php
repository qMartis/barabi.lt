<?php

namespace WeInvoice\Includes\Controllers;

defined('ABSPATH') || exit;

use WeInvoice\Includes\Models\BasicInvoice;
use WeInvoice\Includes\Traits\InvoicePdfGenerator;

/**
 * Class BasicInvoiceController
 * Handles basic invoice logic and hooks
 */
class BasicInvoiceController
{
    use InvoicePdfGenerator;

    /**
     * @var BasicInvoice
     */
    private $invoiceModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceModel = new BasicInvoice();
    }

    /**
     * Initialize the controller
     *
     * @return void
     */
    public function init(): void
    {
        // Only initialize if basic invoices are enabled
        if (!get_option('we_invoice_basic_enabled', 1)) return;

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
        $selectedHooks = get_option('we_invoice_order_hooks', ['woocommerce_order_status_completed']);

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
        $selectedHooks = get_option('we_invoice_order_hooks', ['woocommerce_order_status_completed']);

        if (!empty($selectedHooks)) {
            add_filter('woocommerce_email_attachments', function ($attachments, $email_id, $order) use ($selectedHooks) {
                // Check if current order status matches any configured hook
                $currentOrderStatus = 'woocommerce_order_status_' . $order->get_status();
                if (in_array($currentOrderStatus, $selectedHooks)) {
                    return $this->attachInvoiceToEmails($attachments, $email_id, $order);
                }
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

        if (!$invoiceId) {
            error_log("BasicInvoiceController: Failed to create invoice for order ID: $orderId");
        }
    }

    /**
     * Create a basic invoice for an order
     *
     * @param int $orderId
     * @return int|false Invoice ID on success, false on failure
     */
    public function createInvoice($orderId)
    {
        try {
            $order = wc_get_order($orderId);
            if (!$order) throw new \Exception('Order not found');
 
            $invoiceData = $this->prepareInvoiceData($order, 'basic');
            $invoiceId = $this->invoiceModel->create($invoiceData);
  
            if (!$invoiceId)
                throw new \Exception('Failed to create invoice record');

            $pdfPath = $this->generatePDF($order, $invoiceId, 'basic-invoice.php', 'basic');
            if ($pdfPath) $this->invoiceModel->updatePdfPath($invoiceId, $pdfPath);

            $order->add_order_note(
                sprintf(__('Basic invoice #%s generated', 'we-invoice'), $invoiceId)
            );

            return $invoiceId;
        } catch (\Exception $e) {
            error_log('Basic Invoice Creation Error: ' . $e->getMessage());
            return false;
        }
    }



    /**
     * Note: Email sending has been replaced with EmailIntegration class
     * Invoices are now automatically attached to WooCommerce order emails
     */

    /**
     * Attach basic invoice PDF to WooCommerce emails
     *
     * @param array $attachments
     * @param string $email_id
     * @param mixed $order
     * @return array
     */
    public function attachInvoiceToEmails($attachments, $email_id, $order): array
    {
        $order_id = $order->get_id();
        $invoice = $this->invoiceModel->getByOrderId($order_id);

        // If invoice doesn't exist, create it
        if (!$invoice) {
            error_log("BasicInvoiceController: No invoice found for order $order_id, creating one for email attachment");
            $invoiceId = $this->createInvoice($order_id);
            if ($invoiceId) {
                $invoice = $this->invoiceModel->getById($invoiceId);
            }
        }

        // If invoice exists but PDF doesn't exist, generate it
        if ($invoice && (empty($invoice['pdf_path']) || !file_exists($invoice['pdf_path']))) {
            error_log("BasicInvoiceController: PDF missing for invoice, generating for email attachment");
            $pdfPath = $this->generatePDF($order, $invoice['id'], 'basic-invoice.php', 'basic');
            if ($pdfPath) {
                $this->invoiceModel->updatePdfPath($invoice['id'], $pdfPath);
                $invoice['pdf_path'] = $pdfPath;
            }
        }

        // Attach PDF if it exists
        if ($invoice && !empty($invoice['pdf_path']) && file_exists($invoice['pdf_path'])) {
            $attachments[] = $invoice['pdf_path'];
            error_log("BasicInvoiceController: Attached invoice PDF to email for order $order_id");
        }

        return $attachments;
    }

    /**
     * Generate invoice number
     *
     * @return string
     */
    private function generateInvoiceNumber(): string
    {
        $prefix = get_option('we_invoice_prefix', 'INV-');
        $startingNumber = get_option('we_invoice_starting_number', 1);
        $currentNumber = get_option('we_invoice_current_number', $startingNumber);

        $invoiceNumber = $prefix . str_pad($currentNumber, 4, '0', STR_PAD_LEFT);

        // Increment for next invoice
        update_option('we_invoice_current_number', $currentNumber + 1);

        return $invoiceNumber;
    }
}
