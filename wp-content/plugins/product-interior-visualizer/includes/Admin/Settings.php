<?php
/**
 * Admin Settings
 *
 * @package ProductInteriorVisualizer
 */

namespace PIV\Admin;

class Settings {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add settings page
	 */
	public function add_settings_page() {
		add_options_page(
			__( 'Interior Visualizer Settings', 'product-interior-visualizer' ),
			__( 'Interior Visualizer', 'product-interior-visualizer' ),
			'manage_options',
			'piv-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register settings
	 */
	public function register_settings() {
		register_setting( 'piv_settings_group', 'piv_api_key', array(
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
		));

		register_setting( 'piv_settings_group', 'piv_daily_limit', array(
			'type' => 'integer',
			'sanitize_callback' => 'absint',
			'default' => 10,
		));

		register_setting( 'piv_settings_group', 'piv_limit_type', array(
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => 'ip',
		));

		register_setting( 'piv_settings_group', 'piv_image_max_size', array(
			'type' => 'integer',
			'sanitize_callback' => 'absint',
			'default' => 5,
		));

		// API Settings Section
		add_settings_section(
			'piv_api_section',
			__( 'API Configuration', 'product-interior-visualizer' ),
			array( $this, 'render_api_section' ),
			'piv-settings'
		);

		add_settings_field(
			'piv_api_key',
			__( 'Gemini API Key', 'product-interior-visualizer' ),
			array( $this, 'render_api_key_field' ),
			'piv-settings',
			'piv_api_section'
		);

		// Usage Limits Section
		add_settings_section(
			'piv_limits_section',
			__( 'Usage Limits', 'product-interior-visualizer' ),
			array( $this, 'render_limits_section' ),
			'piv-settings'
		);

		add_settings_field(
			'piv_daily_limit',
			__( 'Daily Request Limit', 'product-interior-visualizer' ),
			array( $this, 'render_daily_limit_field' ),
			'piv-settings',
			'piv_limits_section'
		);

		add_settings_field(
			'piv_limit_type',
			__( 'Limit Type', 'product-interior-visualizer' ),
			array( $this, 'render_limit_type_field' ),
			'piv-settings',
			'piv_limits_section'
		);

		add_settings_field(
			'piv_image_max_size',
			__( 'Max Image Size (MB)', 'product-interior-visualizer' ),
			array( $this, 'render_max_size_field' ),
			'piv-settings',
			'piv_limits_section'
		);
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Show success message
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error(
				'piv_messages',
				'piv_message',
				__( 'Settings saved successfully.', 'product-interior-visualizer' ),
				'success'
			);
		}

		settings_errors( 'piv_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<form action="options.php" method="post">
				<?php
				settings_fields( 'piv_settings_group' );
				do_settings_sections( 'piv-settings' );
				submit_button();
				?>
			</form>

			<div class="piv-usage-stats">
				<h2><?php esc_html_e( 'Usage Statistics', 'product-interior-visualizer' ); ?></h2>
				<?php $this->render_usage_stats(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render API section description
	 */
	public function render_api_section() {
		?>
		<p><?php esc_html_e( 'Configure your Google Gemini API credentials. Get your API key from:', 'product-interior-visualizer' ); ?> 
			<a href="https://makersuite.google.com/app/apikey" target="_blank">https://makersuite.google.com/app/apikey</a>
		</p>
		<?php
	}

	/**
	 * Render limits section description
	 */
	public function render_limits_section() {
		?>
		<p><?php esc_html_e( 'Set usage limits to control API costs and prevent abuse.', 'product-interior-visualizer' ); ?></p>
		<?php
	}

	/**
	 * Render API key field
	 */
	public function render_api_key_field() {
		$value = get_option( 'piv_api_key', '' );
		?>
		<input type="password" 
			   name="piv_api_key" 
			   id="piv_api_key" 
			   value="<?php echo esc_attr( $value ); ?>" 
			   class="regular-text"
			   placeholder="<?php esc_attr_e( 'Enter your Gemini API key', 'product-interior-visualizer' ); ?>">
		<p class="description">
			<?php esc_html_e( 'Your API key will be encrypted and stored securely.', 'product-interior-visualizer' ); ?>
		</p>
		<?php
	}

	/**
	 * Render daily limit field
	 */
	public function render_daily_limit_field() {
		$value = get_option( 'piv_daily_limit', 10 );
		?>
		<input type="number" 
			   name="piv_daily_limit" 
			   id="piv_daily_limit" 
			   value="<?php echo esc_attr( $value ); ?>" 
			   min="1" 
			   max="1000"
			   class="small-text">
		<p class="description">
			<?php esc_html_e( 'Maximum number of visualization requests per day.', 'product-interior-visualizer' ); ?>
		</p>
		<?php
	}

	/**
	 * Render limit type field
	 */
	public function render_limit_type_field() {
		$value = get_option( 'piv_limit_type', 'ip' );
		?>
		<select name="piv_limit_type" id="piv_limit_type">
			<option value="ip" <?php selected( $value, 'ip' ); ?>>
				<?php esc_html_e( 'Per IP Address', 'product-interior-visualizer' ); ?>
			</option>
			<option value="user" <?php selected( $value, 'user' ); ?>>
				<?php esc_html_e( 'Per User (Logged in only)', 'product-interior-visualizer' ); ?>
			</option>
		</select>
		<p class="description">
			<?php esc_html_e( 'Choose how to track usage limits.', 'product-interior-visualizer' ); ?>
		</p>
		<?php
	}

	/**
	 * Render max size field
	 */
	public function render_max_size_field() {
		$value = get_option( 'piv_image_max_size', 5 );
		?>
		<input type="number" 
			   name="piv_image_max_size" 
			   id="piv_image_max_size" 
			   value="<?php echo esc_attr( $value ); ?>" 
			   min="1" 
			   max="20"
			   class="small-text">
		<p class="description">
			<?php esc_html_e( 'Maximum upload size in megabytes.', 'product-interior-visualizer' ); ?>
		</p>
		<?php
	}

	/**
	 * Render usage statistics
	 */
	private function render_usage_stats() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'piv_usage_log';

		$today = $wpdb->get_var( 
			$wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE request_date = %s",
				current_time( 'Y-m-d' )
			)
		);

		$this_month = $wpdb->get_var( 
			$wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE MONTH(request_date) = %d AND YEAR(request_date) = %d",
				current_time( 'm' ),
				current_time( 'Y' )
			)
		);

		$total = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		?>
		<table class="widefat">
			<tbody>
				<tr>
					<td><strong><?php esc_html_e( 'Requests Today:', 'product-interior-visualizer' ); ?></strong></td>
					<td><?php echo esc_html( $today ); ?></td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Requests This Month:', 'product-interior-visualizer' ); ?></strong></td>
					<td><?php echo esc_html( $this_month ); ?></td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Total Requests:', 'product-interior-visualizer' ); ?></strong></td>
					<td><?php echo esc_html( $total ); ?></td>
				</tr>
			</tbody>
		</table>
		<?php
	}
}
