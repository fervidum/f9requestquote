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
		$this->includes();

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
	private function define( string $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( string $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		/**
		 * Class autoloader.
		 */
		include_once F9REQUESTQUOTE_ABSPATH . 'includes/class-f9requestquote-autoloader.php';

		/**
		 * Core classes.
		 */
		include_once F9REQUESTQUOTE_ABSPATH . 'includes/f9requestquote-core-functions.php';
		include_once F9REQUESTQUOTE_ABSPATH . 'includes/class-f9requestquote-install.php';

		if ( $this->is_request( 'admin' ) ) {
			include_once F9REQUESTQUOTE_ABSPATH . 'includes/admin/class-f9requestquote-admin.php';
		}
	}
}
