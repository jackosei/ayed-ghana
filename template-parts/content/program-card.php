<?php
/**
 * Reusable program card. Expects the loop to be set to a program post.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label    = ayed_field( 'program_label', '', get_the_ID() );
$icon     = ayed_field( 'program_icon', 'star', get_the_ID() );
$color    = ayed_field( 'program_color', 'navy', get_the_ID() );
$summary  = ayed_field( 'program_summary', '', get_the_ID() );
$external = ayed_field( 'program_external', '', get_the_ID() );

if ( ! $summary ) {
	$summary = get_the_excerpt();
}
$link = $external ? $external : get_permalink();
$ext_attr = $external ? ' target="_blank" rel="noopener noreferrer"' : '';
$apply = ayed_program_apply( get_the_ID() );
?>
<article <?php post_class( 'program-card' ); ?>>
	<a class="program-card__media program-card__media--<?php echo esc_attr( $color ); ?>" href="<?php echo esc_url( $link ); ?>"<?php echo $ext_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ayed-card', array( 'loading' => 'lazy', 'class' => 'program-card__img' ) ); ?>
		<?php else : ?>
			<span class="program-card__glyph"><?php ayed_icon( $icon, array( 'size' => 56 ) ); ?></span>
		<?php endif; ?>
		<?php if ( $apply ) : ?>
			<span class="program-card__badge"><?php esc_html_e( 'Applications open', 'ayed-ghana' ); ?></span>
		<?php endif; ?>
	</a>
	<div class="program-card__body">
		<?php if ( $label ) : ?>
			<span class="program-card__label"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
		<h3 class="program-card__title"><a href="<?php echo esc_url( $link ); ?>"<?php echo $ext_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php the_title(); ?></a></h3>
		<?php if ( $summary ) : ?>
			<p class="program-card__text"><?php echo esc_html( wp_trim_words( $summary, 34 ) ); ?></p>
		<?php endif; ?>
		<?php echo ayed_arrow_link( $link, __( 'Learn more', 'ayed-ghana' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</article>
