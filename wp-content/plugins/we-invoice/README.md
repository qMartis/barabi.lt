# WE Invoice/Proforma for WooCommerce

A comprehensive WordPress plugin for generating, sending, and managing proforma and final invoices in WooCommerce. Built with a modern MVC architecture, the plugin supports multilingual functionality, customizable invoice numbering, PDF generation, and email integration.

## Features

### 🧾 Invoice Management
- **Proforma Invoices**: Generate proforma invoices for order confirmation
- **Basic Invoices**: Create final invoices for completed orders
- **Automatic Generation**: Trigger invoice creation based on order status changes
- **Manual Generation**: Create invoices manually from the order admin page

### 📄 PDF Generation
- **Professional Templates**: Clean, customizable invoice templates
- **PDF Export**: High-quality PDF generation using Dompdf library
- **Company Branding**: Include company logo, details, and custom styling
- **Responsive Design**: Templates work well in both web and PDF formats

### 📧 Email Integration
- **Automatic Sending**: Email invoices automatically when generated
- **Custom Email Templates**: Professional email templates for invoice delivery
- **Manual Sending**: Send invoices manually from admin interface
- **Customer Notifications**: Keep customers informed with invoice updates

### ⚙️ Configuration
- **Flexible Numbering**: Customize invoice prefixes and starting numbers
- **Order Hooks**: Configure which order statuses trigger invoice generation
- **Company Settings**: Set up company details, logo, and contact information
- **Global Settings**: Enable/disable different invoice types and features

### 🏗️ Technical Features
- **MVC Architecture**: Clean separation of concerns with Controllers, Models, and Templates
- **Database Integration**: Custom tables for invoice data storage
- **WordPress Standards**: Built following WordPress coding standards and best practices
- **Extensible Design**: Easy to extend and customize for specific needs

## Installation

1. **Upload the Plugin**
   ```bash
   # Copy the plugin to your WordPress plugins directory
   cp -r we-invoice /path/to/wordpress/wp-content/plugins/
   ```

2. **Activate the Plugin**
   - Go to WordPress Admin → Plugins
   - Find "We Invoice/Proforma for Woocommerce"
   - Click "Activate"

3. **Verify Installation**
   - The plugin will automatically create necessary database tables
   - Check WooCommerce → Invoice Test (in debug mode) for status verification

## Configuration

### 1. Company Settings
Navigate to **WooCommerce → Settings → WE Invoice** to configure:

- **Company Name**: Your business name
- **Company Logo**: Upload your company logo
- **Company Address**: Full business address
- **Contact Information**: Phone and email
- **Tax Numbers**: VAT/Tax registration numbers

### 2. Proforma Invoice Settings
Configure proforma invoice generation:

- **Enable/Disable**: Toggle proforma invoice functionality
- **Number Prefix**: Set custom prefix (e.g., "PROFORMA-")
- **Starting Number**: Set the initial invoice number
- **Order Triggers**: Choose which order statuses trigger proforma invoice creation
- **Email Settings**: Configure automatic email sending

### 3. Basic Invoice Settings
Configure final invoice generation:

- **Enable/Disable**: Toggle basic invoice functionality
- **Number Prefix**: Set custom prefix (e.g., "INV-")
- **Starting Number**: Set the initial invoice number
- **Order Triggers**: Choose which order statuses trigger final invoice creation
- **Email Settings**: Configure automatic email sending

## Usage

### Automatic Invoice Generation
Invoices are automatically generated based on your configured order status triggers:

1. **Proforma Invoice**: Usually triggered on "pending" or "processing" status
2. **Basic Invoice**: Usually triggered on "completed" status

### Manual Invoice Generation
From any WooCommerce order page:

1. **View Order**: Go to WooCommerce → Orders → [Select Order]
2. **Invoice Actions**: Use the "Invoice Actions" meta box
3. **Generate**: Click "Generate Proforma" or "Generate Basic Invoice"
4. **Send**: Use "Send via Email" to deliver to customer
5. **Download**: Click "Download PDF" to get a local copy

### Managing Invoices
- **View All Invoices**: Check the invoice tables in your database
- **Invoice Status**: Track draft, sent, and paid status
- **Download History**: Access previously generated PDFs

## File Structure

```
we-invoice/
├── we-invoice.php              # Main plugin file
├── composer.json               # Composer dependencies
├── README.md                   # This documentation
├── includes/                   # Core plugin files
│   ├── Controllers/            # MVC Controllers
│   │   ├── ProformaInvoiceController.php
│   │   └── BasicInvoiceController.php
│   ├── Models/                 # Database models
│   │   ├── ProformaInvoice.php
│   │   └── BasicInvoice.php
│   ├── admin-settings/         # Admin configuration pages
│   │   ├── we_invoice_global_settings.php
│   │   ├── we_invoice_proforma_settings.php
│   │   └── we_invoice_basic_settings.php
│   ├── admin-test.php          # Development testing page
│   └── we_invoice_settings.php # Main settings class
├── templates/                  # HTML templates
│   ├── invoices/              # Invoice layouts
│   │   ├── proforma-invoice.php
│   │   └── basic-invoice.php
│   ├── admin/                 # Admin interface templates
│   │   ├── invoice-actions.php
│   │   └── invoice-meta-box.php
│   └── emails/                # Email templates
│       ├── proforma-invoice.php
│       └── basic-invoice.php
└── assets/                    # Static assets
    ├── css/                   # Stylesheets
    │   ├── admin.css
    │   └── invoice-pdf.css
    └── js/                    # JavaScript files
        └── admin.js
```

## Database Schema

### Proforma Invoices Table (`wp_we_proforma_invoices`)
- `id` - Primary key
- `order_id` - WooCommerce order ID
- `invoice_number` - Generated invoice number
- `invoice_date` - Creation date
- `due_date` - Payment due date
- `status` - Invoice status (draft, sent, paid)
- `total_amount` - Invoice total
- `pdf_path` - Path to generated PDF
- `sent_date` - Email sent date
- `created_at` - Record creation timestamp
- `updated_at` - Last update timestamp

### Basic Invoices Table (`wp_we_basic_invoices`)
- Similar structure to proforma invoices
- Used for final/completed order invoices

## Customization

### Template Customization
Templates can be customized by copying them to your theme:

```bash
# Copy template to theme for customization
cp wp-content/plugins/we-invoice/templates/invoices/proforma-invoice.php wp-content/themes/your-theme/we-invoice/proforma-invoice.php
```

### Styling Customization
- **Admin Styles**: Modify `assets/css/admin.css`
- **PDF Styles**: Customize `assets/css/invoice-pdf.css`
- **Email Styles**: Edit email templates in `templates/emails/`

### Extending Functionality
The plugin follows WordPress standards and can be extended through:

- **Action Hooks**: Use WordPress action hooks for custom functionality
- **Filter Hooks**: Modify plugin behavior with filter hooks
- **Class Extension**: Extend controller and model classes
- **Template Overrides**: Override templates in your theme

## Requirements

- **WordPress**: 5.0 or higher
- **WooCommerce**: 3.0 or higher
- **PHP**: 7.4 or higher
- **Dompdf Library**: Available in theme vendor directory

## Development

### Testing
Enable WordPress debug mode to access the test page:

```php
// In wp-config.php
define('WP_DEBUG', true);
```

Then visit **WooCommerce → Invoice Test** for plugin status and testing tools.

### Debug Mode Features
- Plugin status verification
- Database table status
- File existence checks
- Test order listing
- Manual table creation tools

## Support

For support, feature requests, or bug reports:

1. Check the plugin status page (WooCommerce → Invoice Test)
2. Review WordPress debug logs for errors
3. Verify WooCommerce compatibility
4. Ensure all required files are present

## License

This plugin is licensed under the GPL-2.0+ license.

## Changelog

### Version 1.0.0
- Initial release
- MVC architecture implementation
- Proforma and basic invoice support
- PDF generation with Dompdf
- Email integration
- WooCommerce order integration
- Comprehensive admin interface
- Customizable templates and styling

---

**Note**: This plugin integrates with existing Dompdf installation from your theme. Ensure the Dompdf library is available at `wp-content/themes/your-theme/vendor/dompdf/dompdf/autoload.inc.php` for PDF generation to work properly.
