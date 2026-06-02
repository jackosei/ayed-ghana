<?php
/**
 * Reusable event card. Expects the loop to be set to an event post.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$date     = ayed_format_event_date( ayed_field( 'event_date', '', get_the_ID() ) );
$location = ayed_field( 'event_location', '', get_the_ID() );
$gallery  = ayed_field( 'event_gallery', array(), get_the_ID() );
$photo_count = is_array( $gallery ) ? count( $gallery ) : 0;
$videos   = ayed_field( 'event_videos', array(), get_the_ID() );
$video_count = is_array( $videos ) ? count( $videos ) : 0;
?>
<article <?php post_class( 'event-card' ); ?>>
	<a class="event-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ayed-card', array( 'loading' => 'lazy', 'class' => 'event-card__img' ) ); ?>
		<?php else : ?>
			<span class="event-card__glyph"><?php ayed_icon( 'users', array( 'size' => 48 ) ); ?></span>
		<?php endif; ?>
		<?php if ( $photo_count || $video_count ) : ?>
			<span class="event-card__count">
				<?php if ( $photo_count ) : ?>
					<span><?php ayed_icon( 'star', array( 'size' => 14 ) ); ?><?php echo esc_html( number_format_i18n( $photo_count ) ); ?></span>
				<?php endif; ?>
				<?php if ( $video_count ) : ?>
					<span><?php ayed_icon( 'globe', array( 'size' => 14 ) ); ?><?php echo esc_html( number_format_i18n( $video_count ) ); ?></span>
				<?php endif; ?>
			</span>
		<?php endif; ?>
	</a>
	<div class="event-card__body">
		<div class="event-card__meta">
			<?php if ( $date ) : ?>
				<span class="event-card__date"><?php ayed_icon( 'pulse', array( 'size' => 15 ) ); ?><?php echo esc_html( $date ); ?></span>
			<?php endif; ?>
			<?php if ( $location ) : ?>
				<span class="event-card__loc"><?php ayed_icon( 'map-pin', array( 'size' => 15 ) ); ?><?php echo esc_html( $location ); ?></span>
			<?php endif; ?>
		</div>
		<h3 class="event-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_excerpt() ) : ?>
			<p class="event-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
		<?php endif; ?>
		<?php echo ayed_arrow_link( get_permalink(), __( 'View event', 'ayed-ghana' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</article>
