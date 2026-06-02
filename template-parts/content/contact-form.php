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
<form class="contact-form" data-contact-form novalidate>
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
			<select id="cf-interest" name="interest">
				<option value=""><?php esc_html_e( 'Select an option', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Volunteering', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Partnership', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Donating', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Learning more about programmes', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Media or press enquiry', 'ayed-ghana' ); ?></option>
				<option><?php esc_html_e( 'Other', 'ayed-ghana' ); ?></option>
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
