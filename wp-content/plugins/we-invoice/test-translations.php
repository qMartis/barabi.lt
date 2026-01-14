<?php

// Test file to check if translations are working
// Run this from WordPress admin or via WP-CLI

function test_we_invoice_translations() {
    // Load text domain
    load_plugin_textdomain('we-invoice', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    
    echo "Testing We Invoice Translations:\n";
    echo "================================\n";
    
    // Test English (default)
    echo "English: " . __('Invoice', 'we-invoice') . "\n";
    echo "English: " . __('Buyer Information:', 'we-invoice') . "\n";
    echo "English: " . __('Company Code:', 'we-invoice') . "\n";
    
    // Switch to Lithuanian
    switch_to_locale('lt_LT');
    echo "\nLithuanian:\n";
    echo "Lithuanian: " . __('Invoice', 'we-invoice') . "\n";
    echo "Lithuanian: " . __('Buyer Information:', 'we-invoice') . "\n";
    echo "Lithuanian: " . __('Company Code:', 'we-invoice') . "\n";
    
    // Switch to Russian
    switch_to_locale('ru_RU');
    echo "\nRussian:\n";
    echo "Russian: " . __('Invoice', 'we-invoice') . "\n";
    echo "Russian: " . __('Buyer Information:', 'we-invoice') . "\n";
    echo "Russian: " . __('Company Code:', 'we-invoice') . "\n";
    
    // Restore original locale
    restore_previous_locale();
    
    echo "\nTranslation test completed.\n";
}

// Uncomment to test:
// test_we_invoice_translations();
