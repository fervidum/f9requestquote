<?php
/**
 * F9requestquote Admin
 *
 * @class    F9requestquote_Admin
 * @author   Fervidum
 * @category Admin
 * @package  F9requestquote/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * F9requestquote_Admin class.
 */
class F9requestquote_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( dirname( __FILE__ ) . '/class-f9requestquote-admin-menus.php' );
	}
}

return new F9requestquote_Admin();
