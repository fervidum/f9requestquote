<?php
/**
 * F9requestquote Formatting
 *
 * Functions for formatting data.
 *
 * @author      Fervidum
 * @category    Core
 * @package     F9requestquote/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function f9requestquote_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'f9request_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}
