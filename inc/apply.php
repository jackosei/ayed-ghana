<?php
/**
 * Secure AJAX application handler for programme applications.
 *
 * Mirrors inc/contact.php: validates a nonce, sanitises every field, enforces a
 * honeypot and a simple per-IP rate limit, then sends mail via wp_mail(). It is
 * a distinct journey from the general contact form. No data is stored.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle the application form submission.
 */
function ayed_handle_application() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ayed_application_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please refresh and try again.', 'ayed-ghana' ) ), 403 );
	}

	// Honeypot.
	if ( ! empty( $_POST['website_hp'] ) ) {
		wp_send_json_success( array( 'message' => __( 'Application received. Thank you.', 'ayed-ghana' ) ) );
	}

	// Per-IP rate limit.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'ayed_apply_' . md5( $ip );
	if ( get_transient( $key ) ) {
		wp_send_json_error( array( 'message' => __( 'Please wait a moment before submitting again.', 'ayed-ghana' ) ), 429 );
	}

	$first    = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last     = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$location = isset( $_POST['location'] ) ? sanitize_text_field( wp_unslash( $_POST['location'] ) ) : '';
	$message  = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	$age_slug = isset( $_POST['age_bracket'] ) ? sanitize_key( wp_unslash( $_POST['age_bracket'] ) ) : '';
	$brackets = function_exists( 'ayed_age_brackets' ) ? ayed_age_brackets() : array();
	$age      = isset( $brackets[ $age_slug ] ) ? $brackets[ $age_slug ] : '';

	$program_slug = isset( $_POST['program'] ) ? sanitize_title( wp_unslash( $_POST['program'] ) ) : '';
	$program_obj  = $program_slug ? get_page_by_path( $program_slug, OBJECT, 'program' ) : null;
	$program_name = $program_obj ? get_the_title( $program_obj ) : '';

	// Validate.
	$errors = array();
	if ( '' === $first || '' === $last ) {
		$errors[] = __( 'Please enter your full name.', 'ayed-ghana' );
	}
	if ( ! is_email( $email ) ) {
		$errors[] = __( 'Please enter a valid email address.', 'ayed-ghana' );
	}
	if ( '' === $age ) {
		$errors[] = __( 'Please select your age bracket.', 'ayed-ghana' );
	}
	if ( ! $program_obj ) {
		$errors[] = __( 'Please choose a programme to apply to.', 'ayed-ghana' );
	}
	if ( strlen( $message ) < 5 ) {
		$errors[] = __( 'Please tell us why you want to join.', 'ayed-ghana' );
	}
	if ( $errors ) {
		wp_send_json_error( array( 'message' => implode( ' ', $errors ) ), 400 );
	}

	// Recipient: applications recipient, then contact recipient, then admin.
	$recipient = ayed_setting( 'applications_recipient', '' );
	if ( ! is_email( $recipient ) ) {
		$recipient = ayed_setting( 'contact_recipient', '' );
	}
	if ( ! is_email( $recipient ) ) {
		$recipient = ayed_setting( 'contact_email', get_option( 'admin_email' ) );
	}
	if ( ! is_email( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}

	$name    = trim( $first . ' ' . $last );
	$subject = sprintf(
		/* translators: 1: programme name, 2: applicant name */
		__( 'New %1$s application from %2$s', 'ayed-ghana' ),
		$program_name,
		$name
	);

	$body  = __( 'A new programme application has been submitted on the AYED Ghana website.', 'ayed-ghana' ) . "\n\n";
	$body .= __( 'Programme:', 'ayed-ghana' ) . ' ' . $program_name . "\n";
	$body .= __( 'Name:', 'ayed-ghana' ) . ' ' . $name . "\n";
	$body .= __( 'Email:', 'ayed-ghana' ) . ' ' . $email . "\n";
	if ( $phone ) {
		$body .= __( 'Phone:', 'ayed-ghana' ) . ' ' . $phone . "\n";
	}
	$body .= __( 'Age bracket:', 'ayed-ghana' ) . ' ' . $age . "\n";
	if ( $location ) {
		$body .= __( 'Location:', 'ayed-ghana' ) . ' ' . $location . "\n";
	}
	$body .= "\n" . __( 'Why they want to join:', 'ayed-ghana' ) . "\n" . $message . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $recipient, $subject, $body, $headers );

	set_transient( $key, 1, 30 );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Application received. Our team will be in touch soon.', 'ayed-ghana' ) ) );
	}
	wp_send_json_error( array( 'message' => __( 'We could not submit your application right now. Please email us directly.', 'ayed-ghana' ) ), 500 );
}
add_action( 'wp_ajax_ayed_application', 'ayed_handle_application' );
add_action( 'wp_ajax_nopriv_ayed_application', 'ayed_handle_application' );
