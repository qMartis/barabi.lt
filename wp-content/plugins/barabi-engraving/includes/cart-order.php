<?php
defined('ABSPATH') || exit;

add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id) {
    foreach (['engraving_text','engraving_font','engraving_size'] as $field) {
        if (!empty($_POST[$field])) {
            $cart_item_data[$field] = sanitize_text_field($_POST[$field]);
        }
    }
    return $cart_item_data;
}, 10, 2);

add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (isset($cart_item['engraving_text'])) {
        $item_data[] = [
            'name' => 'Engraving',
            'value' => $cart_item['engraving_text']
        ];
    }
    return $item_data;
}, 10, 2);

add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values) {
    foreach (['engraving_text','engraving_font','engraving_size'] as $field) {
        if (isset($values[$field])) {
            $item->add_meta_data(ucfirst(str_replace('_',' ', $field)), $values[$field]);
        }
    }
}, 10, 3);
