<?php
/**
 * Reusable interior page header.
 *
 * @param array $args { eyebrow, title, subtitle }
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args     = wp_parse_args( $args ?? array(), array( 'eyebrow' => '', 'title' => '', 'subtitle' => '' ) );
$eyebrow  = $args['eyebrow'];
$title    = $args['title'];
$subtitle = $args['subtitle'];
?>
<header class="page-hero">
	<div class="page-hero__pattern" aria-hidden="true"></div>
	<div class="container page-hero__inner">
		<?php if ( $eyebrow ) : ?>
			<span class="section-eyebrow section-eyebrow--light"><?php echo esc_html( $eyebrow ); ?></span>
		<?php endif; ?>
		<h1 class="page-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
		<?php if ( $subtitle ) : ?>
			<p class="page-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
</header>
