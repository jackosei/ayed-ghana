<?php
/**
 * Secure AJAX contact form handler.
 *
 * Validates a nonce, sanitises every field, enforces a honeypot and a simple
 * rate limit, then sends mail via wp_mail(). No data is stored.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle the contact form submission.
 */
function ayed_handle_contact() {
	// Verify nonce.
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ayed_contact_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please refresh and try again.', 'ayed-ghana' ) ), 403 );
	}

	// Honeypot: bots fill this hidden field.
	if ( ! empty( $_POST['website_hp'] ) ) {
		wp_send_json_success( array( 'message' => __( 'Message sent. Thank you.', 'ayed-ghana' ) ) );
	}

	// Basic rate limit per IP (one submission every 30 seconds).
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'ayed_contact_' . md5( $ip );
	if ( get_transient( $key ) ) {
		wp_send_json_error( array( 'message' => __( 'Please wait a moment before sending another message.', 'ayed-ghana' ) ), 429 );
	}

	$first   = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last    = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$interest_slug = isset( $_POST['interest'] ) ? sanitize_key( wp_unslash( $_POST['interest'] ) ) : '';
	$interests     = function_exists( 'ayed_contact_interests' ) ? ayed_contact_interests() : array();
	$interest      = isset( $interests[ $interest_slug ] ) ? $interests[ $interest_slug ] : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Validate required fields.
	$errors = array();
	if ( '' === $first ) {
		$errors[] = __( 'Please enter your first name.', 'ayed-ghana' );
	}
	if ( ! is_email( $email ) ) {
		$errors[] = __( 'Please enter a valid email address.', 'ayed-ghana' );
	}
	if ( strlen( $message ) < 5 ) {
		$errors[] = __( 'Please enter a message.', 'ayed-ghana' );
	}
	if ( $errors ) {
		wp_send_json_error( array( 'message' => implode( ' ', $errors ) ), 400 );
	}

	// Recipient.
	$recipient = ayed_setting( 'contact_recipient', '' );
	if ( ! is_email( $recipient ) ) {
		$recipient = ayed_setting( 'contact_email', get_option( 'admin_email' ) );
	}
	if ( ! is_email( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}

	$name    = trim( $first . ' ' . $last );
	$subject = sprintf(
		/* translators: %s: sender name */
		__( 'New website enquiry from %s', 'ayed-ghana' ),
		$name
	);

	$body  = __( 'You have received a new message from the AYED Ghana website.', 'ayed-ghana' ) . "\n\n";
	$body .= __( 'Name:', 'ayed-ghana' ) . ' ' . $name . "\n";
	$body .= __( 'Email:', 'ayed-ghana' ) . ' ' . $email . "\n";
	if ( $interest ) {
		$body .= __( 'Interested in:', 'ayed-ghana' ) . ' ' . $interest . "\n";
	}
	$body .= "\n" . __( 'Message:', 'ayed-ghana' ) . "\n" . $message . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $recipient, $subject, $body, $headers );

	// Throttle regardless of mail success to deter spam loops.
	set_transient( $key, 1, 30 );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Message sent. Thank you, we will be in touch soon.', 'ayed-ghana' ) ) );
	}
	wp_send_json_error( array( 'message' => __( 'We could not send your message right now. Please email us directly.', 'ayed-ghana' ) ), 500 );
}
add_action( 'wp_ajax_ayed_contact', 'ayed_handle_contact' );
add_action( 'wp_ajax_nopriv_ayed_contact', 'ayed_handle_contact' );
