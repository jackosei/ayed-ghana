<?php
/**
 * Reusable secure AJAX contact form.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="contact-form" data-ajax-form novalidate>
	<input type="hidden" name="action" value="ayed_contact" />
	<?php wp_nonce_field( 'ayed_contact_nonce', 'nonce', false ); ?>
	<div class="form-row">
		<p class="form-field">
			<label for="cf-first"><?php esc_html_e( 'First Name', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
			<input type="text" id="cf-first" name="first_name" autocomplete="given-name" required />
		</p>
		<p class="form-field">
			<label for="cf-last"><?php esc_html_e( 'Last Name', 'ayed-ghana' ); ?></label>
			<input type="text" id="cf-last" name="last_name" autocomplete="family-name" />
		</p>
	</div>
	<p class="form-field">
		<label for="cf-email"><?php esc_html_e( 'Email Address', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
		<input type="email" id="cf-email" name="email" autocomplete="email" required />
	</p>
	<p class="form-field">
		<label for="cf-interest"><?php esc_html_e( 'I am interested in', 'ayed-ghana' ); ?></label>
		<span class="form-select">
			<?php
			// Preselect from the ?interest= query param (set by the Get Involved links).
			$ayed_selected = isset( $_GET['interest'] ) ? sanitize_key( wp_unslash( $_GET['interest'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only UI preselection.
			?>
			<select id="cf-interest" name="interest">
				<option value=""><?php esc_html_e( 'Select an option', 'ayed-ghana' ); ?></option>
				<?php foreach ( ayed_contact_interests() as $ayed_slug => $ayed_label ) : ?>
					<option value="<?php echo esc_attr( $ayed_slug ); ?>" <?php selected( $ayed_selected, $ayed_slug ); ?>><?php echo esc_html( $ayed_label ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php ayed_icon( 'chevron', array( 'size' => 18, 'class' => 'form-select__icon' ) ); ?>
		</span>
	</p>
	<p class="form-field">
		<label for="cf-message"><?php esc_html_e( 'Message', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
		<textarea id="cf-message" name="message" rows="5" required></textarea>
	</p>

	<?php /* Honeypot: hidden from humans, tempting to bots. */ ?>
	<p class="form-hp" aria-hidden="true">
		<label for="cf-website"><?php esc_html_e( 'Leave this field empty', 'ayed-ghana' ); ?></label>
		<input type="text" id="cf-website" name="website_hp" tabindex="-1" autocomplete="off" />
	</p>

	<button type="submit" class="btn btn--primary form-submit"><?php esc_html_e( 'Send Message', 'ayed-ghana' ); ?></button>
	<p class="form-status" role="status" aria-live="polite"></p>
</form>
