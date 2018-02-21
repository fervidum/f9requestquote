<?php
/**
 * Setup menus in WP admin.
 *
 * @author   Fervidum
 * @category Admin
 * @package  Fervidum/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'F9requestquote_Admin_Menus', false ) ) {
	return new F9requestquote_Admin_Menus();
}

/**
 * F9requestquote_Admin_Menus Class.
 */
class F9requestquote_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus.
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 9 );
	}

	/**
	 * Add menu item.
	 */
	public function settings_menu() {
		$settings_page = add_options_page( __( 'Request Quote Settings', 'f9requestquote' ),  __( 'Request Quote', 'f9requestquote' ) , 'manage_options', 'f9requestquote-settings', array( $this, 'settings_page' ) );

		add_action( 'load-' . $settings_page, array( $this, 'settings_page_init' ) );
	}

	/**
	 * Loads gateways and shipping methods into memory for use within settings.
	 */
	public function settings_page_init() {
		global $current_tab, $current_section;

		// Include settings pages.
		F9requestquote_Admin_Settings::get_settings_pages();

		// Get current tab/section.
		$current_tab     = empty( $_GET['tab'] ) ? 'general' : sanitize_title( wp_unslash( $_GET['tab'] ) ); // WPCS: input var okay, CSRF ok.
		$current_section = empty( $_REQUEST['section'] ) ? '' : sanitize_title( wp_unslash( $_REQUEST['section'] ) ); // WPCS: input var okay, CSRF ok.

		// Save settings if data has been posted.
		if ( apply_filters( '' !== $current_section ? "f9requestquote_save_settings_{$current_tab}_{$current_section}" : "f9requestquote_save_settings_{$current_tab}", ! empty( $_POST ) ) ) { // WPCS: input var okay, CSRF ok.
			F9requestquote_Admin_Settings::save();
		}

		// Add any posted messages.
		if ( ! empty( $_GET['f9requestquote_error'] ) ) { // WPCS: input var okay, CSRF ok.
			F9requestquote_Admin_Settings::add_error( wp_kses_post( wp_unslash( $_GET['f9requestquote_error'] ) ) ); // WPCS: input var okay, CSRF ok.
		}

		if ( ! empty( $_GET['f9requestquote_message'] ) ) { // WPCS: input var okay, CSRF ok.
			F9requestquote_Admin_Settings::add_message( wp_kses_post( wp_unslash( $_GET['f9requestquote_message'] ) ) ); // WPCS: input var okay, CSRF ok.
		}
	}

	/**
	 * Init the settings page.
	 */
	public function settings_page() {
		F9requestquote_Admin_Settings::output();
	}
}

return new F9requestquote_Admin_Menus();
