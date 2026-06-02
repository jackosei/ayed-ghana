<?php
/**
 * Section: Contact.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag     = ayed_field( 'contact_tag', 'Reach Out' );
$title   = ayed_field( 'contact_title', "Let's Start a [em]Conversation[/em]" );
$intro   = ayed_field( 'contact_intro', 'Whether you want to learn more about our programmes, explore a partnership, or simply connect with our team, reach out and we will respond promptly.' );

$email   = ayed_setting( 'contact_email', 'info@ayedghana.com' );
$phone   = ayed_setting( 'contact_phone', '' );
$address = ayed_setting( 'contact_address', 'Accra, Ghana, West Africa' );
$website = ayed_setting( 'contact_website', 'ayedghana.com' );
?>
<section id="contact" class="section section--contact">
	<div class="container">
		<header class="section-head reveal">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="contact-grid">
			<div class="contact-info reveal">
				<?php if ( $intro ) : ?>
					<p class="contact-info__intro"><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>

				<ul class="contact-info__list">
					<?php if ( $website ) : ?>
						<li><span class="contact-info__icon"><?php ayed_icon( 'globe', array( 'size' => 20 ) ); ?></span><span><?php echo esc_html( $website ); ?></span></li>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<li><span class="contact-info__icon"><?php ayed_icon( 'map-pin', array( 'size' => 20 ) ); ?></span><span><?php echo esc_html( $address ); ?></span></li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li><span class="contact-info__icon"><?php ayed_icon( 'mail', array( 'size' => 20 ) ); ?></span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<li><span class="contact-info__icon"><?php ayed_icon( 'phone', array( 'size' => 20 ) ); ?></span><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
				</ul>

				<?php ayed_social_links( 'social-links social-links--contact' ); ?>
			</div>

			<div class="contact-form-wrap reveal">
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
			</div>
		</div>
	</div>
</section>
