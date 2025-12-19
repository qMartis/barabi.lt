# Product Interior Visualizer

AI-powered interior visualization for WooCommerce products using Google Gemini.

## Features

- **AI-Powered Visualization**: Uses Google Gemini to place products in customer's interior photos
- **Usage Limits**: Set daily request limits per IP or per user
- **Admin Panel**: Easy configuration with API key management and usage statistics
- **Per-Product Control**: Enable/disable visualizer for each product individually
- **OOP Architecture**: Clean, maintainable code following WordPress best practices
- **Security**: Nonce verification, file validation, and sanitized inputs

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Interior Visualizer
4. Add your Google Gemini API key
5. Configure usage limits

## Usage

### Enabling for Products

1. Edit any WooCommerce product
2. In the right sidebar, find the "Interior Visualizer" meta box
3. Check "Enable AI Visualizer"
4. The visualizer will automatically appear on that product's page

### Getting a Gemini API Key

1. Visit [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Create a new API key
3. Copy and paste it in the plugin settings

## Configuration

- **API Key**: Your Google Gemini API key
- **Daily Limit**: Maximum requests per day (default: 10)
- **Limit Type**: Track by IP address or logged-in user
- **Max Image Size**: Maximum upload size in MB (default: 5MB)

## Requirements

- WordPress 5.8 or higher
- WooCommerce 5.0 or higher
- PHP 7.4 or higher

## License

GPL v2 or later
