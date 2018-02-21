<?php
/**
 * Installation related functions and actions.
 *
 * @author   Fervidum
 * @category Admin
 * @package  F9requestquote/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * F9requestquote_Install Class.
 */
class F9requestquote_Install {

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
	}

	/**
	 * Check F9request version and run the updater is required.
	 *
	 * This check is done on all requests and runs if the versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'f9requestquote_version' ) !== f9requestquote()->version ) {
			die(__FUNCTION__);
			self::install();
			do_action( 'f9requestquote_updated' );
		}
	}

	/**
	 * Install actions when a update button is clicked within the admin area.
	 *
	 * This function is hooked into admin_init to affect admin only.
	 */
	public static function install_actions() {
		wp_safe_redirect( admin_url( 'admin.php?page=f9requestquote-settings' ) );
		exit;
	}

	/**
	 * Install F9requestquote.
	 */
	public static function install() {
		if ( ! is_blog_installed() ) {
			return;
		}

		// Check if we are not already running this routine.
		if ( 'yes' === get_transient( 'f9requestquote_installing' ) ) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'f9requestquote_installing', 'yes', MINUTE_IN_SECONDS * 10 );
		f9requestquote_maybe_define_constant( 'F9REQUESTQUOTE_INSTALLING', true );

		self::create_options();
		self::update_f9requestquote_version();

		delete_transient( 'f9requestquote_installing' );

		do_action( 'f9requestquote_flush_rewrite_rules' );
		do_action( 'f9requestquote_installed' );
	}

	/**
	 * Is this a brand new F9REQUESTQUOTE install?
	 *
	 * @return boolean
	 */
	private static function is_new_install() {
		return is_null( get_option( 'f9requestquote_version', null ) ) && is_null( get_option( 'f9requestquote_db_version', null ) );
	}

	/**
	 * Update F9REQUESTQUOTE version to current.
	 */
	private static function update_f9requestquote_version() {
		delete_option( 'f9requestquote_version' );
		add_option( 'f9requestquote_version', f9requestquote()->version );
	}

	/**
	 * Update DB version to current.
	 *
	 * @param string|null $version New F9requestquote DB version or null.
	 */
	public static function update_db_version( $version = null ) {
		delete_option( 'f9requestquote_db_version' );
		add_option( 'f9requestquote_db_version', is_null( $version ) ? f9requestquote()->version : $version );
	}

	/**
	 * Create pages that the plugin relies on, storing page IDs in variables.
	 */
	public static function create_pages() {
		include_once dirname( __FILE__ ) . '/admin/f9requestquote-admin-functions.php';

		$pages = apply_filters(
			'f9requestquote_create_pages', array(
				'cart'      => array(
					'name'    => _x( 'cart', 'Page slug', 'f9requestquote' ),
					'title'   => _x( 'Cart', 'Page title', 'f9requestquote' ),
					'content' => '[' . apply_filters( 'f9requestquote_cart_shortcode_tag', 'f9requestquote_cart' ) . ']',
				),
			)
		);

		foreach ( $pages as $key => $page ) {
			f9requestquote_create_page( esc_sql( $page['name'] ), 'f9requestquote_' . $key . '_page_id', $page['title'], $page['content'], ! empty( $page['parent'] ) ? f9requestquote_get_page_id( $page['parent'] ) : '' );
		}
	}

	/**
	 * Default options.
	 *
	 * Sets up the default options used on the settings page.
	 */
	private static function create_options() {
		// Include settings so that we can run through defaults.
		include_once dirname( __FILE__ ) . '/admin/class-f9requestquote-admin-settings.php';

		$settings = F9requestquote_Admin_Settings::get_settings_pages();

		foreach ( $settings as $section ) {
			if ( ! method_exists( $section, 'get_settings' ) ) {
				continue;
			}
			$subsections = array_unique( array_merge( array( '' ), array_keys( $section->get_sections() ) ) );

			foreach ( $subsections as $subsection ) {
				foreach ( $section->get_settings( $subsection ) as $value ) {
					if ( isset( $value['default'] ) && isset( $value['id'] ) ) {
						$autoload = isset( $value['autoload'] ) ? (bool) $value['autoload'] : true;
						add_option( $value['id'], $value['default'], '', ( $autoload ? 'yes' : 'no' ) );
					}
				}
			}
		}
	}
}

F9requestquote_Install::init();
