<?php
/**
 * Section: Get Involved.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag   = ayed_field( 'involved_tag', 'Join Us' );
$title = ayed_field( 'involved_title', 'Be Part of the [em]Movement[/em]' );

$ayed_contact = ayed_contact_url();
$cards = ayed_field( 'involved_cards', array(
	array( 'icon' => 'hand-heart', 'title' => 'Volunteer', 'text' => 'Bring your skills, energy, and time to AYED Ghana\'s programmes. Whether you are a professional, a student, or simply passionate about youth empowerment, there is a place for you here.', 'link_label' => 'Join as a Volunteer', 'link_url' => $ayed_contact ),
	array( 'icon' => 'handshake', 'title' => 'Partner With Us', 'text' => 'We welcome strategic partnerships with institutions, corporations, and international organisations who share our commitment to Africa\'s youth. Let us create something lasting together.', 'link_label' => 'Become a Partner', 'link_url' => $ayed_contact ),
	array( 'icon' => 'gift', 'title' => 'Support Our Work', 'text' => 'Your support funds training programmes, scholarships, community projects, and international exchanges that directly transform the lives of young Ghanaians. Every contribution matters.', 'link_label' => 'Make a Donation', 'link_url' => $ayed_contact ),
) );
?>
<section id="involved" class="section section--dark section--involved">
	<div class="section__glow" aria-hidden="true"></div>
	<div class="container">
		<header class="section-head section-head--light reveal">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="involved-grid">
			<?php foreach ( $cards as $card ) : ?>
				<article class="involved-card reveal">
					<span class="involved-card__icon"><?php ayed_icon( isset( $card['icon'] ) ? $card['icon'] : 'star', array( 'size' => 26 ) ); ?></span>
					<h3 class="involved-card__title"><?php echo esc_html( isset( $card['title'] ) ? $card['title'] : '' ); ?></h3>
					<p class="involved-card__text"><?php echo esc_html( isset( $card['text'] ) ? $card['text'] : '' ); ?></p>
					<?php if ( ! empty( $card['link_label'] ) ) : ?>
						<?php echo ayed_arrow_link( ! empty( $card['link_url'] ) ? $card['link_url'] : $ayed_contact, $card['link_label'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
