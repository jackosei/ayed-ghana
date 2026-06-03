<?php
/**
 * Secure AJAX application form for the Youth Development (and other) programmes.
 * Distinct from the general contact form: captures applicant details.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Programs available to apply to.
$ayed_programs = get_posts( array(
	'post_type'      => 'program',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );

// Preselected program slug from the ?program= query param.
$ayed_pre = isset( $_GET['program'] ) ? sanitize_title( wp_unslash( $_GET['program'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only UI preselection.
?>
<form class="contact-form application-form" data-ajax-form novalidate>
	<input type="hidden" name="action" value="ayed_application" />
	<?php wp_nonce_field( 'ayed_application_nonce', 'nonce', false ); ?>

	<div class="form-row">
		<p class="form-field">
			<label for="af-first"><?php esc_html_e( 'First Name', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
			<input type="text" id="af-first" name="first_name" autocomplete="given-name" required />
		</p>
		<p class="form-field">
			<label for="af-last"><?php esc_html_e( 'Last Name', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
			<input type="text" id="af-last" name="last_name" autocomplete="family-name" required />
		</p>
	</div>

	<div class="form-row">
		<p class="form-field">
			<label for="af-email"><?php esc_html_e( 'Email Address', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
			<input type="email" id="af-email" name="email" autocomplete="email" required />
		</p>
		<p class="form-field">
			<label for="af-phone"><?php esc_html_e( 'Phone Number', 'ayed-ghana' ); ?></label>
			<input type="tel" id="af-phone" name="phone" autocomplete="tel" />
		</p>
	</div>

	<div class="form-row">
		<p class="form-field">
			<label for="af-age"><?php esc_html_e( 'Age Bracket', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
			<span class="form-select">
				<select id="af-age" name="age_bracket" required>
					<option value=""><?php esc_html_e( 'Select an option', 'ayed-ghana' ); ?></option>
					<?php foreach ( ayed_age_brackets() as $ayed_slug => $ayed_label ) : ?>
						<option value="<?php echo esc_attr( $ayed_slug ); ?>"><?php echo esc_html( $ayed_label ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php ayed_icon( 'chevron', array( 'size' => 18, 'class' => 'form-select__icon' ) ); ?>
			</span>
		</p>
		<p class="form-field">
			<label for="af-location"><?php esc_html_e( 'Location (City / Region)', 'ayed-ghana' ); ?></label>
			<input type="text" id="af-location" name="location" autocomplete="address-level2" />
		</p>
	</div>

	<p class="form-field">
		<label for="af-program"><?php esc_html_e( 'Program', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
		<span class="form-select">
			<select id="af-program" name="program" required>
				<option value=""><?php esc_html_e( 'Select a programme', 'ayed-ghana' ); ?></option>
				<?php foreach ( $ayed_programs as $ayed_program ) : ?>
					<option value="<?php echo esc_attr( $ayed_program->post_name ); ?>" <?php selected( $ayed_pre, $ayed_program->post_name ); ?>><?php echo esc_html( get_the_title( $ayed_program ) ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php ayed_icon( 'chevron', array( 'size' => 18, 'class' => 'form-select__icon' ) ); ?>
		</span>
	</p>

	<p class="form-field">
		<label for="af-message"><?php esc_html_e( 'Why do you want to join?', 'ayed-ghana' ); ?> <span aria-hidden="true">*</span></label>
		<textarea id="af-message" name="message" rows="5" required></textarea>
	</p>

	<?php /* Honeypot: hidden from humans, tempting to bots. */ ?>
	<p class="form-hp" aria-hidden="true">
		<label for="af-website"><?php esc_html_e( 'Leave this field empty', 'ayed-ghana' ); ?></label>
		<input type="text" id="af-website" name="website_hp" tabindex="-1" autocomplete="off" />
	</p>

	<button type="submit" class="btn btn--primary form-submit"><?php esc_html_e( 'Submit Application', 'ayed-ghana' ); ?></button>
	<p class="form-status" role="status" aria-live="polite"></p>
</form>
