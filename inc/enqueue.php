<?php
/**
 * Enqueue styles and scripts.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function ayed_enqueue_assets() {
	// Google Fonts: Poppins for headings, Inter for body.
	wp_enqueue_style(
		'ayed-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Theme header stylesheet (required by WordPress).
	wp_enqueue_style(
		'ayed-style',
		get_stylesheet_uri(),
		array( 'ayed-fonts' ),
		AYED_VERSION
	);

	// Main stylesheet.
	$main_css = AYED_DIR . '/assets/css/main.css';
	wp_enqueue_style(
		'ayed-main',
		AYED_URI . '/assets/css/main.css',
		array( 'ayed-style' ),
		file_exists( $main_css ) ? filemtime( $main_css ) : AYED_VERSION
	);

	// Main script.
	$main_js = AYED_DIR . '/assets/js/main.js';
	wp_enqueue_script(
		'ayed-main',
		AYED_URI . '/assets/js/main.js',
		array(),
		file_exists( $main_js ) ? filemtime( $main_js ) : AYED_VERSION,
		true
	);

	// Data for the AJAX contact form.
	wp_localize_script( 'ayed-main', 'ayedData', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'ayed_contact_nonce' ),
		'sending' => esc_html__( 'Sending…', 'ayed-ghana' ),
		'sent'    => esc_html__( 'Message sent. Thank you.', 'ayed-ghana' ),
		'error'   => esc_html__( 'Something went wrong. Please try again.', 'ayed-ghana' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ayed_enqueue_assets' );

/**
 * Preconnect to the Google Fonts origins for faster loading.
 */
function ayed_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'ayed_resource_hints', 10, 2 );

/**
 * Editor styles so the block editor reflects the front end.
 */
function ayed_editor_assets() {
	add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'ayed_editor_assets' );
