<?php
/**
 * Section: Hero.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$badge        = ayed_field( 'hero_badge', "Established in Ghana. Empowering Africa's Youth." );
$title        = ayed_field( 'hero_title', 'Empowering the [em]Next[/em] Generation of Africa' );
$sub          = ayed_field( 'hero_sub', 'A platform where young people connect, grow and succeed, in business, industry, and beyond.' );
$primary_lbl  = ayed_field( 'hero_primary_label', 'Our Programs' );
$primary_url  = ayed_field( 'hero_primary_url', '#programs' );
$second_lbl   = ayed_field( 'hero_secondary_label', 'Get Involved' );
$second_url   = ayed_field( 'hero_secondary_url', '#involved' );
$hero_image   = ayed_field( 'hero_image', '' );

$hero_style = '';
if ( is_array( $hero_image ) && ! empty( $hero_image['url'] ) ) {
	$hero_style = ' style="background-image:linear-gradient(rgba(13,41,68,0.86),rgba(13,41,68,0.92)),url(' . esc_url( $hero_image['url'] ) . ');background-size:cover;background-position:center;"';
}
?>
<section id="hero" class="hero"<?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>>
	<div class="hero__pattern" aria-hidden="true"></div>
	<div class="hero__inner">
		<?php if ( $badge ) : ?>
			<p class="hero__badge"><?php echo esc_html( $badge ); ?></p>
		<?php endif; ?>

		<h1 class="hero__title"><?php ayed_the_emphasis( $title ); ?></h1>

		<span class="hero__rule" aria-hidden="true"></span>

		<?php if ( $sub ) : ?>
			<p class="hero__sub"><?php echo esc_html( $sub ); ?></p>
		<?php endif; ?>

		<div class="hero__ctas">
			<?php if ( $primary_lbl ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_lbl ); ?></a>
			<?php endif; ?>
			<?php if ( $second_lbl ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( $second_url ); ?>"><?php echo esc_html( $second_lbl ); ?></a>
			<?php endif; ?>
		</div>
	</div>

	<a class="hero__scroll" href="#about" aria-label="<?php esc_attr_e( 'Scroll to content', 'ayed-ghana' ); ?>">
		<span class="hero__scroll-line" aria-hidden="true"></span>
		<span class="hero__scroll-text"><?php esc_html_e( 'Scroll', 'ayed-ghana' ); ?></span>
	</a>
</section>
