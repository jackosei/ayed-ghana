<?php
/**
 * Single event: details, photo gallery, videos and related programs.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$date     = ayed_format_event_date( ayed_field( 'event_date', '', get_the_ID() ) );
	$location = ayed_field( 'event_location', '', get_the_ID() );
	$gallery  = ayed_field( 'event_gallery', array(), get_the_ID() );
	$videos   = ayed_field( 'event_videos', array(), get_the_ID() );
	$programs = ayed_field( 'related_programs', array(), get_the_ID() );

	$subtitle_parts = array_filter( array( $date, $location ) );

	get_template_part( 'template-parts/content/page-header', null, array(
		'eyebrow'  => __( 'Event', 'ayed-ghana' ),
		'title'    => get_the_title(),
		'subtitle' => implode( '  .  ', $subtitle_parts ),
	) );
	?>

	<article <?php post_class( 'section single-content' ); ?>>
		<div class="container container--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single-content__media"><?php the_post_thumbnail( 'ayed-wide', array( 'loading' => 'eager' ) ); ?></figure>
			<?php endif; ?>

			<?php if ( get_the_content() ) : ?>
				<div class="prose"><?php the_content(); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $gallery ) && is_array( $gallery ) ) : ?>
			<div class="container">
				<h2 class="event-section-title"><?php esc_html_e( 'Photo Gallery', 'ayed-ghana' ); ?></h2>
				<div class="gallery-grid">
					<?php foreach ( $gallery as $item ) : ?>
						<?php
						$img = isset( $item['image'] ) ? $item['image'] : '';
						if ( ! is_array( $img ) || empty( $img['url'] ) ) {
							continue;
						}
						$caption = isset( $item['caption'] ) ? $item['caption'] : '';
						$thumb   = isset( $img['sizes']['ayed-card'] ) ? $img['sizes']['ayed-card'] : $img['url'];
						?>
						<figure class="gallery-grid__item">
							<a href="<?php echo esc_url( $img['url'] ); ?>" target="_blank" rel="noopener noreferrer">
								<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $img['alt'] ? $img['alt'] : ( $caption ? $caption : get_the_title() ) ); ?>" loading="lazy" />
							</a>
							<?php if ( $caption ) : ?>
								<figcaption><?php echo esc_html( $caption ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $videos ) && is_array( $videos ) ) : ?>
			<div class="container">
				<h2 class="event-section-title"><?php esc_html_e( 'Videos', 'ayed-ghana' ); ?></h2>
				<div class="video-grid">
					<?php foreach ( $videos as $video ) : ?>
						<?php
						$url = isset( $video['url'] ) ? $video['url'] : '';
						if ( ! $url ) {
							continue;
						}
						$embed = wp_oembed_get( $url );
						?>
						<div class="video-item">
							<?php if ( $embed ) : ?>
								<div class="video-item__frame"><?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted oEmbed markup. ?></div>
							<?php else : ?>
								<a class="video-item__link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php ayed_icon( 'globe', array( 'size' => 18 ) ); ?><span><?php echo esc_html( ! empty( $video['title'] ) ? $video['title'] : $url ); ?></span></a>
							<?php endif; ?>
							<?php if ( ! empty( $video['title'] ) && $embed ) : ?>
								<p class="video-item__title"><?php echo esc_html( $video['title'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="container container--narrow">
			<?php if ( ! empty( $programs ) && is_array( $programs ) ) : ?>
				<div class="related-programs">
					<h2 class="event-section-title"><?php esc_html_e( 'Related Programs', 'ayed-ghana' ); ?></h2>
					<ul class="related-programs__list">
						<?php foreach ( $programs as $program_id ) : ?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $program_id ) ); ?>">
									<?php ayed_icon( 'arrow-right', array( 'size' => 16 ) ); ?>
									<span><?php echo esc_html( get_the_title( $program_id ) ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<footer class="single-content__footer">
				<a class="arrow-link arrow-link--back" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
					<?php ayed_icon( 'arrow-right', array( 'size' => 16, 'class' => 'arrow-link__back-icon' ) ); ?>
					<span><?php esc_html_e( 'All Events', 'ayed-ghana' ); ?></span>
				</a>
			</footer>
		</div>
	</article>

<?php
endwhile;

get_footer();
