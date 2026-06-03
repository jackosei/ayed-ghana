<?php
/**
 * Reusable contact details block, sourced from Site Settings.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email   = ayed_setting( 'contact_email', 'info@ayedghana.org' );
$phone   = ayed_setting( 'contact_phone', '' );
$address = ayed_setting( 'contact_address', 'C170/5, Adenkum Road, Accra, Ghana' );
$website = ayed_setting( 'contact_website', 'ayedghana.org' );
?>
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
