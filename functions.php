<?php
/**
 * AYED Ghana theme bootstrap.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AYED_VERSION' ) ) {
	define( 'AYED_VERSION', '1.1.0' );
}
if ( ! defined( 'AYED_DIR' ) ) {
	define( 'AYED_DIR', get_template_directory() );
}
if ( ! defined( 'AYED_URI' ) ) {
	define( 'AYED_URI', get_template_directory_uri() );
}

/**
 * Load theme modules.
 */
$ayed_includes = array(
	'inc/setup.php',              // Theme supports, menus, post types, taxonomies.
	'inc/enqueue.php',            // Styles and scripts.
	'inc/icons.php',              // Inline SVG icon system (no emoji).
	'inc/scf-fields.php',         // Secure Custom Fields registration.
	'inc/template-functions.php', // Helpers used across templates.
	'inc/seo.php',                // Meta tags, Open Graph and JSON-LD schema.
	'inc/contact.php',            // Secure AJAX contact form handler.
	'inc/apply.php',              // Secure AJAX programme application handler.
);

foreach ( $ayed_includes as $ayed_file ) {
	$ayed_path = AYED_DIR . '/' . $ayed_file;
	if ( is_readable( $ayed_path ) ) {
		require_once $ayed_path;
	}
}
