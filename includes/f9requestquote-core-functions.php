<?php
/**
 * F9requestquote Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @author   Fervidum
 * @category Core
 * @package  F9requestquote\Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include core functions (available in both admin and frontend).
include F9REQUESTQUOTE_ABSPATH . 'includes/f9requestquote-formatting-functions.php';

/**
 * Display a F9requestquote help tip.
 *
 * @param  string $tip        Help tip text.
 * @param  bool   $allow_html Allow sanitized HTML if true or escape.
 * @return string
 */
function f9requestquote_help_tip( $tip, $allow_html = false ) {
	if ( $allow_html ) {
		$tip = f9requestquote_sanitize_tooltip( $tip );
	} else {
		$tip = esc_attr( $tip );
	}

	return '<span class="f9requestquote-help-tip" data-tip="' . $tip . '"></span>';
}
