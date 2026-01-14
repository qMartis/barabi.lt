<?php

namespace WeInvoice\Includes\Models;

defined('ABSPATH') || exit;

/**
 * Class ProformaInvoice
 * Handles proforma invoice data operations using WordPress post type
 */
class ProformaInvoice
{
    /**
     * @var string Post type name
     */
    private $postType = 'we_proforma_invoice';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initHooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function initHooks(): void
    {
        add_action('init', [$this, 'registerPostType']);
    }

    /**
     * Register the custom post type
     *
     * @return void
     */
    public function registerPostType(): void
    {
        $args = [
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => 'woocommerce',
            'query_var' => true,
            'rewrite' => ['slug' => 'we-proforma-invoice'],
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => ['title', 'custom-fields'],
            'labels' => [
                'name' => __('Proforma Invoices', 'we-invoice'),
                'singular_name' => __('Proforma Invoice', 'we-invoice'),
                'menu_name' => __('Proforma Invoices', 'we-invoice'),
                'name_admin_bar' => __('Proforma Invoice', 'we-invoice'),
                'add_new' => __('Add New', 'we-invoice'),
                'add_new_item' => __('Add New Proforma Invoice', 'we-invoice'),
                'new_item' => __('New Proforma Invoice', 'we-invoice'),
                'edit_item' => __('Edit Proforma Invoice', 'we-invoice'),
                'view_item' => __('View Proforma Invoice', 'we-invoice'),
                'all_items' => __('All Proforma Invoices', 'we-invoice'),
                'search_items' => __('Search Proforma Invoices', 'we-invoice'),
                'parent_item_colon' => __('Parent Proforma Invoices:', 'we-invoice'),
                'not_found' => __('No proforma invoices found.', 'we-invoice'),
                'not_found_in_trash' => __('No proforma invoices found in Trash.', 'we-invoice'),
            ],
        ];

        register_post_type($this->postType, $args);
    }

    /**
     * Create table - now just ensures post type is registered
     *
     * @return void
     */
    public function createTable(): void
    {
        // Post type registration handles the "table" creation
        $this->registerPostType();
    }

    /**
     * Create a new invoice record
     *
     * @param array $data
     * @return int|false
     */
    public function create(array $data)
    {
        $invoiceNumber = $data['invoice_number'] ?? '';
        $orderId = $data['order_id'] ?? 0;
        
        $post_data = [
            'post_type' => $this->postType,
            'post_title' => sprintf(__('Proforma Invoice %s', 'we-invoice'), $invoiceNumber),
            'post_status' => 'publish',
            'post_content' => '',
            'meta_input' => [
                '_order_id' => $orderId,
                '_invoice_number' => $invoiceNumber,
                '_invoice_type' => 'proforma',
                '_status' => $data['status'] ?? 'generated',
                '_total_amount' => $data['total_amount'] ?? 0,
                '_currency' => $data['currency'] ?? '',
                '_customer_data' => $data['customer_data'] ?? '',
                '_seller_data' => $data['seller_data'] ?? '',
                '_pdf_path' => '',
                '_sent_date' => '',
                '_notes' => ''
            ]
        ];

        $post_id = wp_insert_post($post_data);
        
        return $post_id !== 0 ? $post_id : false;
    }

    /**
     * Get invoice by ID
     *
     * @param int $id
     * @return array|null
     */
    public function getById($id): ?array
    {
        $post = get_post($id);
        
        if (!$post || $post->post_type !== $this->postType) {
            return null;
        }

        return $this->formatPostData($post);
    }

    /**
     * Get invoice by order ID
     *
     * @param int $orderId
     * @return array|null
     */
    public function getByOrderId($orderId): ?array
    {
        $posts = get_posts([
            'post_type' => $this->postType,
            'meta_query' => [
                [
                    'key' => '_order_id',
                    'value' => $orderId,
                    'compare' => '='
                ]
            ],
            'posts_per_page' => 1
        ]);

        if (empty($posts)) {
            return null;
        }

        return $this->formatPostData($posts[0]);
    }

    /**
     * Check if invoice exists for order
     *
     * @param int $orderId
     * @return bool
     */
    public function invoiceExists($orderId): bool
    {
        return $this->getByOrderId($orderId) !== null;
    }

    /**
     * Update PDF path
     *
     * @param int $id
     * @param string $pdfPath
     * @return bool
     */
    public function updatePdfPath($id, $pdfPath): bool
    {
        return update_post_meta($id, '_pdf_path', $pdfPath) !== false;
    }

    /**
     * Mark invoice as sent
     *
     * @param int $id
     * @return bool
     */
    public function markAsSent($id): bool
    {
        $updated = update_post_meta($id, '_status', 'sent');
        $sentDate = update_post_meta($id, '_sent_date', current_time('mysql'));
        
        return $updated !== false && $sentDate !== false;
    }

    /**
     * Get all invoices with pagination
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return array
     */
    public function getAll($page = 1, $perPage = 20, $filters = []): array
    {
        $args = [
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $perPage,
            'paged' => $page,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => []
        ];

        // Apply filters
        if (!empty($filters['status'])) {
            $args['meta_query'][] = [
                'key' => '_status',
                'value' => $filters['status'],
                'compare' => '='
            ];
        }

        if (!empty($filters['date_from'])) {
            $args['date_query'][] = [
                'after' => $filters['date_from'],
                'inclusive' => true
            ];
        }

        if (!empty($filters['date_to'])) {
            $args['date_query'][] = [
                'before' => $filters['date_to'],
                'inclusive' => true
            ];
        }

        $query = new \WP_Query($args);
        $results = [];

        foreach ($query->posts as $post) {
            $results[] = $this->formatPostData($post);
        }

        return [
            'data' => $results,
            'total' => $query->found_posts,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => $query->max_num_pages
        ];
    }

    /**
     * Delete invoice
     *
     * @param int $id
     * @return bool
     */
    public function delete($id): bool
    {
        // Get the invoice to delete PDF file
        $invoice = $this->getById($id);
        if ($invoice && !empty($invoice['pdf_path']) && file_exists($invoice['pdf_path'])) {
            unlink($invoice['pdf_path']);
        }

        $result = wp_delete_post($id, true);
        return $result !== false && $result !== null;
    }

    /**
     * Update invoice status
     *
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status): bool
    {
        return update_post_meta($id, '_status', $status) !== false;
    }

    /**
     * Get invoice statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $stats = [];

        // Total invoices
        $total_posts = wp_count_posts($this->postType);
        $stats['total'] = $total_posts->publish ?? 0;

        // By status - get all posts and count by meta value
        $all_invoices = get_posts([
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ]);

        $stats['by_status'] = [];
        foreach ($all_invoices as $post_id) {
            $status = get_post_meta($post_id, '_status', true) ?: 'generated';
            $stats['by_status'][$status] = ($stats['by_status'][$status] ?? 0) + 1;
        }

        // This month
        $this_month_posts = get_posts([
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'date_query' => [
                [
                    'year' => date('Y'),
                    'month' => date('n')
                ]
            ],
            'fields' => 'ids'
        ]);
        $stats['this_month'] = count($this_month_posts);

        // Total amount
        $total_amount = 0;
        foreach ($all_invoices as $post_id) {
            $amount = (float) get_post_meta($post_id, '_total_amount', true);
            $total_amount += $amount;
        }
        $stats['total_amount'] = $total_amount;

        return $stats;
    }

    /**
     * Format post data to array format similar to database result
     *
     * @param \WP_Post $post
     * @return array
     */
    private function formatPostData($post): array
    {
        return [
            'id' => $post->ID,
            'order_id' => get_post_meta($post->ID, '_order_id', true),
            'invoice_number' => get_post_meta($post->ID, '_invoice_number', true),
            'invoice_type' => get_post_meta($post->ID, '_invoice_type', true) ?: 'proforma',
            'status' => get_post_meta($post->ID, '_status', true) ?: 'generated',
            'created_date' => $post->post_date,
            'sent_date' => get_post_meta($post->ID, '_sent_date', true),
            'total_amount' => get_post_meta($post->ID, '_total_amount', true),
            'currency' => get_post_meta($post->ID, '_currency', true),
            'customer_data' => get_post_meta($post->ID, '_customer_data', true),
            'seller_data' => get_post_meta($post->ID, '_seller_data', true),
            'pdf_path' => get_post_meta($post->ID, '_pdf_path', true),
            'notes' => get_post_meta($post->ID, '_notes', true)
        ];
    }

    /**
     * Get count of all invoices (for invoice numbering)
     *
     * @return int
     */
    public function getCount(): int
    {
        $total_posts = wp_count_posts($this->postType);
        return $total_posts->publish ?? 0;
    }
}
