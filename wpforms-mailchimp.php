<?php
/**
 * Plugin Name:       WPForms Mailchimp
 * Plugin URI:        https://wpforms.com
 * Description:       Mailchimp integration with WPForms.
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            WPForms
 * Author URI:        https://wpforms.com
 * Version:           2.2.0
 * Text Domain:       wpforms-mailchimp
 * Domain Path:       languages
 *
 * WPForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPForms. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WPFormsMailchimp\Plugin;

// phpcs:disable WPForms.Comments.PHPDocDefine.MissPHPDoc
// Plugin version.
define( 'WPFORMS_MAILCHIMP_VERSION', '2.2.0' );

// Plugin URL.
define( 'WPFORMS_MAILCHIMP_URL', plugin_dir_url( __FILE__ ) );

// Plugin directory.
define( 'WPFORMS_MAILCHIMP_DIR', plugin_dir_path( __FILE__ ) );
// phpcs:enable WPForms.Comments.PHPDocDefine.MissPHPDoc

/**
 * Load the provider class.
 *
 * @since 1.0.0
 */
function wpforms_mailchimp() {

	// Check requirements.
	if ( ! wpforms_mailchimp_required() ) {
		return;
	}

	// Load plugin.
	wpforms_mailchimp_plugin();

	// Get all active integrations.
	$providers = wpforms_get_providers_options();

	// Load v2 API integration if the user currently has it set up.
	if ( ! empty( $providers['mailchimp'] ) ) {
		require_once WPFORMS_MAILCHIMP_DIR . 'deprecated/class-mailchimp.php';
	}
}

add_action( 'wpforms_loaded', 'wpforms_mailchimp' );

/**
 * Check addon requirements.
 *
 * @since 2.0.0
 */
function wpforms_mailchimp_required() {

	if ( PHP_VERSION_ID < 50600 ) {
		add_action( 'admin_init', 'wpforms_mailchimp_deactivation' );
		add_action( 'admin_notices', 'wpforms_mailchimp_fail_php_version' );

		return false;
	}

	if ( ! function_exists( 'wpforms' ) ) {
		return false;
	}

	if ( version_compare( wpforms()->version, '1.7.5.5', '<' ) ) {
		add_action( 'admin_init', 'wpforms_mailchimp_deactivation' );
		add_action( 'admin_notices', 'wpforms_mailchimp_fail_wpforms_version' );

		return false;
	}

	if (
		! function_exists( 'wpforms_get_license_type' ) ||
		! in_array( wpforms_get_license_type(), [ 'plus', 'pro', 'agency', 'ultimate', 'elite' ], true )
	) {
		return false;
	}

	return true;
}

/**
 * Deactivate the plugin.
 *
 * @since 2.0.0
 */
function wpforms_mailchimp_deactivation() {

	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Admin notice for a minimum PHP version.
 *
 * @since 2.0.0
 */
function wpforms_mailchimp_fail_php_version() {

	echo '<div class="notice notice-error"><p>';
	printf(
		wp_kses( /* translators: %s - WPForms.com documentation page URI. */
			__( 'The WPForms Mailchimp plugin has been deactivated. Your site is running an outdated version of PHP that is no longer supported and is not compatible with the Mailchimp plugin. <a href="%s" target="_blank" rel="noopener noreferrer">Read more</a> for additional information.', 'wpforms-mailchimp' ),
			[
				'a' => [
					'href'   => [],
					'rel'    => [],
					'target' => [],
				],
			]
		),
		'https://wpforms.com/docs/supported-php-version/'
	);
	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Admin notice for minimum WPForms version.
 *
 * @since 2.0.0
 */
function wpforms_mailchimp_fail_wpforms_version() {

	echo '<div class="notice notice-error"><p>';
	esc_html_e( 'The WPForms Mailchimp plugin has been deactivated, because it requires WPForms v1.7.5.5 or later to work.', 'wpforms-mailchimp' );
	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Get the instance of the `\WPFormsMailchimp\Plugin` class.
 * This function is useful for quickly grabbing data used throughout the plugin.
 *
 * @since 2.0.0
 *
 * @return Plugin
 */
function wpforms_mailchimp_plugin() {

	// Actually, load the Mailchimp addon now, as we met all the requirements.
	require_once __DIR__ . '/vendor/autoload.php';

	return Plugin::get_instance();
}

/**
 * Load the plugin updater.
 *
 * @since 1.0.0
 *
 * @param string $key License key.
 */
function wpforms_mailchimp_updater( $key ) {

	new WPForms_Updater(
		[
			'plugin_name' => 'WPForms Mailchimp',
			'plugin_slug' => 'wpforms-mailchimp',
			'plugin_path' => plugin_basename( __FILE__ ),
			'plugin_url'  => trailingslashit( WPFORMS_MAILCHIMP_URL ),
			'remote_url'  => WPFORMS_UPDATER_API,
			'version'     => WPFORMS_MAILCHIMP_VERSION,
			'key'         => $key,
		]
	);
}

add_action( 'wpforms_updater', 'wpforms_mailchimp_updater' );
