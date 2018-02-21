<?php
/**
 * F9requestquote Autoloader.
 *
 * @class       F9requestquote_Autoloader
 * @version     1.0.0
 * @package     F9requestquote/Classes
 * @category    Class
 * @author      Fervidum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * F9requestquote_Autoloader class.
 */
class F9requestquote_Autoloader {

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $include_path = '';

	/**
	 * The Constructor.
	 */
	public function __construct() {
		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->include_path = untrailingslashit( plugin_dir_path( F9REQUESTQUOTE_PLUGIN_FILE ) ) . '/includes/';
	}

	/**
	 * Take a class name and turn it into a file name.
	 *
	 * @param  string $class Class name.
	 * @return string
	 */
	private function get_file_name_from_class( string $class ) {
		return 'class-' . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string $path Path of file.
	 * @return bool successful or not
	 */
	private function load_file( string $path ) {
		if ( $path && is_readable( $path ) ) {
			include_once( $path );
			return true;
		}
		return false;
	}

	/**
	 * Auto-load F9REQUESTQUOTE classes on demand to reduce memory consumption.
	 *
	 * @param string $class Class name.
	 */
	public function autoload( string $class ) {
		$class = strtolower( $class );

		if ( 0 !== strpos( $class, 'f9requestquote_' ) ) {
			return;
		}

		$file  = $this->get_file_name_from_class( $class );
		$path  = '';

		if ( 0 === strpos( $class, 'f9requestquote_admin' ) ) {
			$path = $this->include_path . 'admin/';
		}

		if ( empty( $path ) || ! $this->load_file( $path . $file ) ) {
			$this->load_file( $this->include_path . $file );
		}
	}
}

new F9requestquote_Autoloader();
