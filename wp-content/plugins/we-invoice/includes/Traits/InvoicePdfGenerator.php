<?php

namespace WeInvoice\Includes\Traits;

defined('ABSPATH') || exit;

/**
 * Trait InvoicePdfGenerator
 * Shared PDF generation and invoice data preparation functionality
 */
trait InvoicePdfGenerator
{
    /**
     * Detect and set the appropriate language for invoice generation
     *
     * @param \WC_Order $order
     * @return string The detected language code
     */
    protected function detectAndSetLanguage($order): string
    {
        $detectedLanguage = 'en_US'; // Default fallback

        // Check if Polylang is installed and activated
        if (function_exists('pll_get_post_language')) {
            $orderLanguage = pll_get_post_language($order->get_id());
            if ($orderLanguage) {
                // Map Polylang language codes to our locales
                $languageMap = [
                    'en' => 'en_US',
                    'lt' => 'lt_LT', 
                    'ru' => 'ru_RU'
                ];
                
                $detectedLanguage = $languageMap[$orderLanguage] ?? 'en_US';
                
                // Switch to detected locale for this invoice generation
                switch_to_locale($detectedLanguage);
            }
        } elseif (function_exists('get_locale')) {
            // Fallback to WordPress locale if no Polylang
            $detectedLanguage = get_locale();
        }

        return $detectedLanguage;
    }

    /**
     * Restore original locale after invoice generation
     *
     * @return void
     */
    protected function restoreLocale(): void
    {
        if (function_exists('restore_previous_locale')) {
            restore_previous_locale();
        }
    }

    /**
     * Get localized date string
     *
     * @param int|null $timestamp Unix timestamp, defaults to current time
     * @param string|null $format Date format, defaults to WordPress date format
     * @return string Localized date string
     */
    protected function getLocalizedDate($timestamp = null, $format = null): string
    {
        if ($timestamp === null) {
            $timestamp = time();
        }
        
        if ($format === null) {
            $format = get_option('date_format');
        }

        // Use wp_date for proper localization (WordPress 5.3+)
        if (function_exists('wp_date')) {
            return wp_date($format, $timestamp);
        }
        
        // Fallback for older WordPress versions
        return date_i18n($format, $timestamp);
    }

    /**
     * Get order meta value using proper method based on field type
     *
     * @param \WC_Order $order
     * @param string $metaKey
     * @return string
     */
    protected function getOrderMetaValue($order, $metaKey): string
    {
        if (empty($metaKey)) {
            return '';
        }

        // Map of internal WooCommerce fields to their getter methods
        $internalFieldMap = [
            '_billing_first_name' => 'get_billing_first_name',
            '_billing_last_name' => 'get_billing_last_name',
            '_billing_company' => 'get_billing_company',
            '_billing_address_1' => 'get_billing_address_1',
            '_billing_address_2' => 'get_billing_address_2',
            '_billing_city' => 'get_billing_city',
            '_billing_state' => 'get_billing_state',
            '_billing_postcode' => 'get_billing_postcode',
            '_billing_country' => 'get_billing_country',
            '_billing_email' => 'get_billing_email',
            '_billing_phone' => 'get_billing_phone',
            '_shipping_first_name' => 'get_shipping_first_name',
            '_shipping_last_name' => 'get_shipping_last_name',
            '_shipping_company' => 'get_shipping_company',
            '_shipping_address_1' => 'get_shipping_address_1',
            '_shipping_address_2' => 'get_shipping_address_2',
            '_shipping_city' => 'get_shipping_city',
            '_shipping_state' => 'get_shipping_state',
            '_shipping_postcode' => 'get_shipping_postcode',
            '_shipping_country' => 'get_shipping_country',
        ];

        // Check if this is an internal WooCommerce field
        if (isset($internalFieldMap[$metaKey])) {
            $method = $internalFieldMap[$metaKey];
            if (method_exists($order, $method)) {
                return (string) $order->$method();
            }
        }

        // For custom meta fields, use get_meta
        return (string) $order->get_meta($metaKey);
    }
    /**
     * Prepare invoice data from order
     *
     * @param \WC_Order $order
     * @param string $invoiceType 'basic' or 'proforma'
     * @return array
     */
    protected function prepareInvoiceData($order, $invoiceType = 'basic'): array
    {
        try {
            // Use different invoice number generation based on type
            if ($invoiceType === 'proforma') {
                $invoiceNumber = $this->generateProformaInvoiceNumber();
            } else {
                $invoiceNumber = $this->generateInvoiceNumber();
            }

            // Get company meta fields from global settings
            $companyNameMeta = get_option('we_invoice_company_name_meta', '');
            $companyCodeMeta = get_option('we_invoice_company_code_meta', '');
            $companyVatMeta = get_option('we_invoice_company_vat_meta', '');
            $companyAddressMeta = get_option('we_invoice_company_address_meta', '');

            // Extract customer company data using configured meta fields with proper handling
            $companyCode = $this->getOrderMetaValue($order, $companyCodeMeta);
            $companyVat = $this->getOrderMetaValue($order, $companyVatMeta);
            $companyNameAlt = $this->getOrderMetaValue($order, $companyNameMeta);
            $companyAddressAlt = $this->getOrderMetaValue($order, $companyAddressMeta);

            $customerCompanyData = [
                'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                'email' => $order->get_billing_email(),
                'company' => $order->get_billing_company(),
                'address' => $order->get_formatted_billing_address(),
                'phone' => $order->get_billing_phone(),
                'company_code' => $companyCode,
                'company_vat' => $companyVat,
                'company_name_alt' => $companyNameAlt,
                'company_address_alt' => $companyAddressAlt,
            ];

            // Get seller company information from global settings
            $sellerCompanyData = [
                'name' => get_option('we_invoice_company_name', get_bloginfo('name')),
                'address' => get_option('we_invoice_company_address', ''),
                'phone' => get_option('we_invoice_company_phone', ''),
                'email' => get_option('we_invoice_company_email', get_option('admin_email')),
                'code' => get_option('we_invoice_company_code', ''),
                'vat' => get_option('we_invoice_company_vat', ''),
                'logo' => get_option('we_invoice_logo', ''),
            ];

            return [
                'order_id' => $order->get_id(),
                'invoice_number' => $invoiceNumber,
                'invoice_type' => $invoiceType,
                'status' => 'generated',
                'created_date' => current_time('mysql'),
                'total_amount' => $order->get_total(),
                'currency' => $order->get_currency(),
                'customer_data' => json_encode($customerCompanyData),
                'seller_data' => json_encode($sellerCompanyData)
            ];

        } catch (\Exception $e) {
            error_log('prepareInvoiceData error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate proforma invoice number
     *
     * @return string
     */
    protected function generateProformaInvoiceNumber(): string
    {
        $prefix = get_option('we_proforma_invoice_prefix', 'PROFORMA-');
        $startingNumber = get_option('we_proforma_invoice_starting_number', 1);
        $currentNumber = get_option('we_proforma_invoice_current_number', $startingNumber);
        
        $invoiceNumber = $prefix . str_pad($currentNumber, 4, '0', STR_PAD_LEFT);
        
        // Increment for next invoice
        update_option('we_proforma_invoice_current_number', $currentNumber + 1);
        
        return $invoiceNumber;
    }

    /**
     * Generate PDF for invoice
     *
     * @param \WC_Order $order
     * @param int $invoiceId
     * @param string $templateName Template file name (e.g., 'basic-invoice.php', 'proforma-invoice.php')
     * @param string $subdirectory Subdirectory for saving PDF (e.g., 'basic', 'proforma')
     * @return string|false
     */
    protected function generatePDF($order, $invoiceId, $templateName, $subdirectory)
    {
        try {
            // Detect and set language for this invoice
            $language = $this->detectAndSetLanguage($order);
            
            // Load Dompdf from plugin vendor directory
            $dompdfPath = dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';

            if (!file_exists($dompdfPath)) {
                error_log('Dompdf not found at: ' . $dompdfPath);
                return false;
            }

            require_once $dompdfPath;

            // Get invoice data
            $invoice = $this->invoiceModel->getById($invoiceId);

            // Generate HTML content
            $html = $this->loadTemplate('invoices/' . $templateName, [
                'order' => $order,
                'invoice' => $invoice,
                'invoice_id' => $invoice['invoice_number'] ?? $invoiceId,
                'company_details' => [
                    'name' => get_option('we_invoice_company_name', get_bloginfo('name')),
                    'address' => get_option('we_invoice_company_address', ''),
                    'phone' => get_option('we_invoice_company_phone', ''),
                    'email' => get_option('we_invoice_company_email', get_option('admin_email')),
                    'logo' => get_option('we_invoice_company_logo', ''),
                    'code' => get_option('we_invoice_registration_number', ''),
                    'vat' => get_option('we_invoice_tax_number', ''),
                ]
            ]);

            // Fix Unicode escape sequences that appear in some data
            $unicode_fixes = [
                'u017e' => 'ž', 'u017d' => 'Ž', // ž, Ž
                'u0173' => 'ų', 'u0172' => 'Ų', // ų, Ų
                'u0161' => 'š', 'u0160' => 'Š', // š, Š
                'u0105' => 'ą', 'u0104' => 'Ą', // ą, Ą
                'u010d' => 'č', 'u010c' => 'Č', // č, Č
                'u0119' => 'ę', 'u0118' => 'Ę', // ę, Ę
                'u0117' => 'ė', 'u0116' => 'Ė', // ė, Ė
                'u012f' => 'į', 'u012e' => 'Į', // į, Į
                'u016b' => 'ū', 'u016a' => 'Ū'  // ū, Ū
            ];

            // Fix Unicode escape sequences first
            foreach ($unicode_fixes as $unicode => $char) {
                $html = str_replace($unicode, $char, $html);
                $html = str_replace('\\' . $unicode, $char, $html);
                $html = str_replace('\u' . substr($unicode, 1), $char, $html);
            }

            // Load CSS for PDF
            $css = file_get_contents(dirname(dirname(dirname(__FILE__))) . '/assets/css/invoice-pdf.css');

            // Simple HTML structure with proper UTF-8 declaration
            $fullHtml = '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>' . $css . '</style>
</head>
<body>' . $html . '</body>
</html>';

            // Optimized Dompdf configuration for UTF-8 and Lithuanian characters
            $options = new \Dompdf\Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $options->set('isFontSubsettingEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', false);

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($fullHtml);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Create upload directory
            $upload_dir = wp_upload_dir();
            $invoice_dir = $upload_dir['basedir'] . '/invoices/' . $subdirectory . '/';

            if (!file_exists($invoice_dir)) {
                wp_mkdir_p($invoice_dir);
            }

            // Save PDF file
            $filename = $subdirectory . '-invoice-' . $invoiceId . '-' . time() . '.pdf';
            $filepath = $invoice_dir . $filename;

            file_put_contents($filepath, $dompdf->output());

            // Restore original locale
            $this->restoreLocale();

            return $filepath;

        } catch (\Exception $e) {
            error_log('PDF Generation Error: ' . $e->getMessage());
            // Ensure locale is restored even on error
            $this->restoreLocale();
            return false;
        }
    }

    /**
     * Load template file
     *
     * @param string $template
     * @param array $vars
     * @return string
     */
    protected function loadTemplate($template, $vars = []): string
    {
        $templatePath = dirname(dirname(dirname(__FILE__))) . '/templates/' . $template;

        if (!file_exists($templatePath)) {
            return '';
        }

        extract($vars);
        ob_start();
        include $templatePath;
        $content = ob_get_clean();

        // Ensure proper UTF-8 encoding and fix any encoding issues
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        }

        return $content;
    }


    /**
     * Download proforma invoice PDF
     *
     * @param int $invoiceId
     * @return void
     */
    public function downloadInvoice($invoiceId, $prefix): void
    {
        try {
            $invoice = $this->invoiceModel->getById($invoiceId);
            if (!$invoice) {
                wp_die(__('Invoice not found', 'we-invoice'));
            }

            $pdfPath = $invoice['pdf_path'] ?? '';
            
            // Generate PDF if it doesn't exist
            if (empty($pdfPath) || !file_exists($pdfPath)) {
                $order = wc_get_order($invoice['order_id']);
                if ($order) {
                    $pdfPath = $this->generatePDF($order, $invoiceId, 'proforma-invoice.php', 'proforma');
                    if ($pdfPath) {
                        $this->invoiceModel->updatePdfPath($invoiceId, $pdfPath);
                    }
                }
            }

            if ($pdfPath && file_exists($pdfPath)) {
                $filename = $prefix.'invoice-' . $invoice['invoice_number'] . '.pdf';
                
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Content-Length: ' . filesize($pdfPath));
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                
                readfile($pdfPath);
                exit;
            } else {
                wp_die(__('PDF file not found', 'we-invoice'));
            }

        } catch (\Exception $e) {
            error_log('Download Invoice Error: ' . $e->getMessage());
            wp_die(__('Error downloading invoice', 'we-invoice'));
        }
    }
}
