<?php

namespace WeInvoice\Includes;

defined('ABSPATH') || exit;

use WeInvoice\Includes\AdminSettings\We_Invoice_Global_Settings;
use WeInvoice\Includes\AdminSettings\We_Invoice_Basic_Settings;
use WeInvoice\Includes\AdminSettings\We_Invoice_Proforma_Settings;

/**
 * Class WeInvoiceSettings
 * Manages admin settings with tabbed navigation.
 */
class We_Invoice_Settings
{

    private We_Invoice_Global_Settings $globalSettings;
    private We_Invoice_Basic_Settings $basicSettings;
    private We_Invoice_Proforma_Settings $proformaSettings;
    /**
     * Initialize the settings components
     *
     * @return void
     */
    public function init(): void
    {
        $this->globalSettings = new We_Invoice_Global_Settings();
        $this->globalSettings->init();
        
        $this->basicSettings = new We_Invoice_Basic_Settings();
        $this->basicSettings->init();

        $this->proformaSettings = new We_Invoice_Proforma_Settings();
        $this->proformaSettings->init();
        add_action('admin_menu', [$this, 'addSettingsPage']);
    }

    /**
     * Add the settings page to WooCommerce menu
     *
     * @return void
     */
    public function addSettingsPage(): void
    {
        add_submenu_page(
            'woocommerce',
            __('We Invoice Settings', 'we-invoice'),
            __('We Invoice Settings', 'we-invoice'),
            'manage_woocommerce',
            'we-invoice-settings',
            [$this, 'renderSettingsPage']
        );
    }

    /**
     * Render the settings page with tabs
     *
     * @return void
     */
    public function renderSettingsPage(): void
    {
        $activeTab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'global';

?>
        <div class="wrap">
            <h1><?php esc_html_e('Invoice Settings', 'we-invoice'); ?></h1>
            <h2 class="nav-tab-wrapper">
                <a href="?page=we-invoice-settings&tab=global" class="nav-tab <?php echo $activeTab === 'global' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e('Global Settings', 'we-invoice'); ?>
                </a>
                <a href="?page=we-invoice-settings&tab=basic" class="nav-tab <?php echo $activeTab === 'basic' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e('Basic Invoice Settings', 'we-invoice'); ?>
                </a>
                <a href="?page=we-invoice-settings&tab=proforma" class="nav-tab <?php echo $activeTab === 'proforma' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e('Proforma Settings', 'we-invoice'); ?>
                </a>
            </h2>

            <?php
            switch ($activeTab) {
                case 'basic':
                    $this->renderBasicSettings();
                    break;

                case 'proforma':
                    $this->renderProformaSettings();
                    break;

                case 'global':
                default:
                    $this->renderGlobalSettings();
                    break;
            }
            ?>

        </div>
<?php
    }

    /**
     * Render the Global Settings tab
     *
     * @return void
     */
    private function renderGlobalSettings(): void
    {
        $settings = new We_Invoice_Global_Settings();
        $settings->renderSettings();
    }

    /**
     * Render the Basic Invoice Settings tab
     *
     * @return void
     */
    private function renderBasicSettings(): void
    {
        $settings = new We_Invoice_Basic_Settings();
        $settings->renderSettingsPage();
    }

    /**
     * Render the Proforma Settings tab
     *
     * @return void
     */
    private function renderProformaSettings(): void
    {
        $settings = new We_Invoice_Proforma_Settings();
        $settings->renderSettingsPage();
    }
}
