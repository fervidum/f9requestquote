<?php
/**
 * F9requestquote General Settings
 *
 * @author      Fervidum
 * @category    Admin
 * @package     F9requestquote/Admin
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'F9requestquote_Settings_General', false ) ) :

	/**
	 * F9requestquote_Admin_Settings_General.
	 */
	class F9requestquote_Settings_General extends F9requestquote_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id    = 'general';
			$this->label = __( 'General', 'f9requestquote' );

			parent::__construct();
		}

		/**
		 * Get settings array.
		 *
		 * @return array
		 */
		public function get_settings() {

			$settings = apply_filters( 'f9requestquote_general_settings', array(

				array(
					'title'    => __( 'Cart page', 'f9requestquote' ),
					'desc'     => sprintf( __( 'Page contents: [%s]', 'f9requestquote' ), apply_filters( 'f9requestquote_cart_shortcode_tag', 'f9requestquote_cart' ) ),
					'id'       => 'f9requestquote_cart_page_id',
					'type'     => 'single_select_page',
					'default'  => '',
					'class'    => 'f9requestquote-enhanced-select-nostd',
					'css'      => 'min-width:300px;',
					'desc_tip' => true,
				),

			) );

			return apply_filters( 'f9requestquote_get_settings_' . $this->id, $settings );
		}

		/**
		 * Output the settings.
		 */
		public function output() {
			$settings = $this->get_settings();

			F9requestquote_Admin_Settings::output_fields( $settings );
		}

		/**
		 * Save settings.
		 */
		public function save() {
			$settings = $this->get_settings();

			F9requestquote_Admin_Settings::save_fields( $settings );
		}
	}

endif;

return new F9requestquote_Settings_General();
