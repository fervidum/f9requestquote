<?php
/**
 * F9requestquote setup
 *
 * @package  F9requestquote
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main F9requestquote Class.
 *
 * @class F9requestquote
 */
final class F9requestquote {

	/**
	 * F9requestquote version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var F9requestquote
	 */
	protected static $_instance = null;

	/**
	 * Main F9requestquote Instance.
	 *
	 * Ensures only one instance of F9requestquote is loaded or can be loaded.
	 *
	 * @static
	 * @see f9requestquote()
	 * @return F9requestquote - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * F9requestquote Constructor.
	 */
	public function __construct() {
		$this->define_constants();

		do_action( 'f9requestquote_loaded' );
	}

	/**
	 * Define F9REQUESTQUOTE Constants.
	 */
	private function define_constants() {
		$this->define( 'F9REQUESTQUOTE_ABSPATH', dirname( F9REQUESTQUOTE_PLUGIN_FILE ) . '/' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
}
