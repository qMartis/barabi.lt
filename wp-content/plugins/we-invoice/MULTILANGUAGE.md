# We Invoice Multi-Language Support

The We Invoice plugin now supports multiple languages for invoice generation. This document explains how to use and configure the multi-language functionality.

## Supported Languages

The plugin currently supports three languages:

1. **English (en_US)** - Default language
2. **Lithuanian (lt_LT)** - Full Lithuanian support including special characters (ą, č, ę, ė, į, š, ų, ū, ž)
3. **Russian (ru_RU)** - Full Russian/Cyrillic support

## How Language Detection Works

The plugin automatically detects the appropriate language for each invoice using the following priority:

1. **Polylang Integration**: If Polylang plugin is installed and active, the plugin will use the order's language setting
2. **WordPress Locale**: Falls back to the site's default WordPress locale
3. **Default Fallback**: English (en_US) if no other language is detected

## Language Files Structure

All translation files are located in the `/languages/` directory:

```
/languages/
├── we-invoice.pot          # Template file for translations
├── we-invoice-en_US.po     # English translation source
├── we-invoice-en_US.mo     # English compiled translation
├── we-invoice-lt_LT.po     # Lithuanian translation source
├── we-invoice-lt_LT.mo     # Lithuanian compiled translation
├── we-invoice-ru_RU.po     # Russian translation source
└── we-invoice-ru_RU.mo     # Russian compiled translation
```

## Translated Elements

The following invoice elements are fully translatable:

### Invoice Headers
- "Invoice" / "Proforma Invoice"
- "Buyer Information:" / "Seller Information:"

### Company Information
- "Company Code:" / "VAT Code:"
- "Phone:" / "Email:"

### Invoice Details
- "Invoice Number:" / "Invoice Date:"
- "Order Number:" / "Order Date:"

### Product Information
- "Products" / "Quantity" / "Price"
- "SKU:" for product codes

### Financial Totals
- "Subtotal:" / "Shipping:" / "Tax:" / "Total:"

### Additional Elements
- "Customer Notes:"

## Adding New Translations

To add support for a new language:

1. **Copy the template file:**
   ```bash
   cp languages/we-invoice.pot languages/we-invoice-[locale].po
   ```

2. **Edit the .po file** and translate all msgstr entries

3. **Compile the translation:**
   ```bash
   msgfmt -o languages/we-invoice-[locale].mo languages/we-invoice-[locale].po
   ```

4. **Update language detection** in the trait if needed

## Example Translations

### Lithuanian Examples
- "Invoice" → "Sąskaita faktūra"
- "Buyer Information:" → "Pirkėjo informacija:"
- "Company Code:" → "Įmonės kodas:"
- "VAT Code:" → "PVM kodas:"

### Russian Examples
- "Invoice" → "Счёт-фактура"
- "Buyer Information:" → "Информация о покупателе:"
- "Company Code:" → "Код компании:"
- "VAT Code:" → "НДС код:"

## Character Encoding

The plugin includes special handling for Lithuanian and other Unicode characters:

- Full UTF-8 support in PDF generation
- Special character fixes for common encoding issues
- DejaVu Sans font support for proper character rendering

## Testing Translations

Use the included test file to verify translations are working:

```php
// Uncomment the function call in test-translations.php
test_we_invoice_translations();
```

## Polylang Integration

When Polylang is installed:

1. Orders will automatically use the customer's selected language
2. Invoices will be generated in the appropriate language
3. Language switching is automatic and seamless

## Troubleshooting

### Translations Not Showing
1. Verify .mo files exist and are compiled correctly
2. Check that the text domain 'we-invoice' is loaded
3. Ensure locale codes match exactly (e.g., 'lt_LT', not 'lt')

### Character Display Issues
1. Verify UTF-8 encoding in .po files
2. Check that DejaVu Sans font is available
3. Ensure isRemoteEnabled is true in Dompdf configuration

### Language Detection Issues
1. Check if Polylang is properly installed and activated
2. Verify order language metadata exists
3. Test with different WordPress locales

## Development Notes

- Language switching uses WordPress's `switch_to_locale()` function
- Original locale is restored after PDF generation
- Error handling includes locale restoration to prevent issues
- All templates use `_e()` and `__()` WordPress translation functions

## Future Enhancements

Potential improvements for future versions:

1. Admin interface for language selection
2. Support for additional languages
3. Custom date format per language
4. Currency symbol localization
5. Number formatting per locale
