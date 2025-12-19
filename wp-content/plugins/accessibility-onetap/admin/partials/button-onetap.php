<?php
/**
 * Admin Button Template for Onetap plugin.
 *
 * This template is responsible for rendering the button section
 * of the plugin's admin pages, including logo, documentation links,
 * support links, and navigation menu.
 *
 * @package    Accessibility_Onetap
 * @subpackage Accessibility_Onetap/admin/partials
 */

$settings = get_option( 'onetap_settings' );
if ( ! is_array( $settings ) ) {
	$settings = array();
}

$toggle_classes = array_filter(
	array(
		! empty( $settings['border'] ) ? $settings['border'] : '',
		isset( $settings['toggle-device-position-desktop'] ) && 'on' === $settings['toggle-device-position-desktop'] ? 'hide-on-desktop' : '',
		isset( $settings['toggle-device-position-tablet'] ) && 'on' === $settings['toggle-device-position-tablet'] ? 'hide-on-tablet' : '',
		isset( $settings['toggle-device-position-mobile'] ) && 'on' === $settings['toggle-device-position-mobile'] ? 'hide-on-mobile' : '',
	)
);
?>

<button type="button" aria-label="Toggle Accessibility Toolbar" class="onetap-toggle <?php echo esc_attr( implode( ' ', $toggle_classes ) ); ?>">
	<?php
	// Define SVG paths for each icon type.
	$icon_paths = array(
		'design1' => 'assets/images/admin/Original_Logo_Icon.svg',
		'design2' => 'assets/images/admin/Hand_Icon.svg',
		'design3' => 'assets/images/admin/Accessibility-Man-Icon.svg',
		'design4' => 'assets/images/admin/Settings-Filter-Icon.svg',
		'design5' => 'assets/images/admin/Switcher-Icon.svg',
		'design6' => 'assets/images/admin/Eye-Show-Icon.svg',
	);

	// Check if the selected icon exists in the array.
	$settings = get_option( 'onetap_settings' );
	if ( isset( $settings['icons'], $icon_paths[ $settings['icons'] ] ) ) {
		$icons = array(
			'design1' => 'Original_Logo_Icon.svg',
			'design2' => 'Hand_Icon.svg',
			'design3' => 'Accessibility-Man-Icon.svg',
			'design4' => 'Settings-Filter-Icon.svg',
			'design5' => 'Switcher-Icon.svg',
			'design6' => 'Eye-Show-Icon.svg',
		);
		foreach ( $icons as $icon_value => $icon_image ) {
			if ( $icon_value === $settings['icons'] ) {
				$class_size   = isset( $settings['size'] ) ? $settings['size'] : '';
				$class_border = isset( $settings['border'] ) ? $settings['border'] : '';
				echo '<img class="' . esc_attr( $class_size ) . ' ' . esc_attr( $class_border ) . '" src="' . esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/' . $icon_image ) . '" alt="toggle icon" />';
			}
		}
	} else {
		echo '<img class="design-size2 design-border2" src="' . esc_url( ACCESSIBILITY_ONETAP_PLUGINS_URL . 'assets/images/admin/Original_Logo_Icon.svg' ) . '" alt="toggle icon" />';
	}
	?>
</button>