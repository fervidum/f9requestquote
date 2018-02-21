<?php
/**
 * Plugin Name: F9requestquote
 * Description: Request quote of products.
 * Version: 1.0.0
 * Author: Fervidum
 *
 * Text Domain: f9requestquote
 * Domain Path: /i18n/languages/
 *
 * @package F9requestquote
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define F9REQUESTQUOTE_PLUGIN_FILE.
if ( ! defined( 'F9REQUESTQUOTE_PLUGIN_FILE' ) ) {
	define( 'F9REQUESTQUOTE_PLUGIN_FILE', __FILE__ );
}

// Include the main F9requestquote class.
if ( ! class_exists( 'F9requestquote' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-f9requestquote.php';
}

/**
 * Main instance of F9requestquote.
 *
 * Returns the main instance of f9requestquote to prevent the need to use globals.
 *
 * @return F9requestquote
 */
function f9requestquote() {
	return F9requestquote::instance();
}

f9requestquote();
