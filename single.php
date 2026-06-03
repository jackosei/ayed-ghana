<?php
/**
 * Single post template (also used by Programs).
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$is_program = ( 'program' === get_post_type() );
	$eyebrow    = $is_program ? ayed_field( 'program_label', __( 'Program', 'ayed-ghana' ), get_the_ID() ) : get_the_date();
	$apply      = $is_program ? ayed_program_apply( get_the_ID() ) : null;

	get_template_part( 'template-parts/content/page-header', null, array(
		'eyebrow'  => $eyebrow,
		'title'    => get_the_title(),
		'subtitle' => $is_program ? ayed_field( 'program_summary', '', get_the_ID() ) : '',
	) );
	?>

	<article <?php post_class( 'section single-content' ); ?>>
		<div class="container container--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single-content__media"><?php the_post_thumbnail( 'ayed-wide', array( 'loading' => 'eager' ) ); ?></figure>
			<?php endif; ?>

			<div class="prose">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<nav class="page-links">' . esc_html__( 'Pages:', 'ayed-ghana' ),
					'after'  => '</nav>',
				) );
				?>
			</div>

			<?php
			// Contextual application CTA: Heading -> Description -> this block.
			// Only programs render it; the per-program toggle decides Apply vs Closed.
			$external = $is_program ? ayed_field( 'program_external', '', get_the_ID() ) : '';
			if ( $is_program ) :
				?>
				<div class="program-cta<?php echo $apply ? '' : ' program-cta--closed'; ?>">
					<div class="program-cta__text">
						<?php if ( $apply ) : ?>
							<h2 class="program-cta__title"><?php esc_html_e( 'Ready to join this programme?', 'ayed-ghana' ); ?></h2>
							<p class="program-cta__note"><?php esc_html_e( 'Applications are open. Apply now and our team will be in touch.', 'ayed-ghana' ); ?></p>
						<?php else : ?>
							<h2 class="program-cta__title"><?php esc_html_e( 'Applications Closed', 'ayed-ghana' ); ?></h2>
							<p class="program-cta__note"><?php esc_html_e( 'This programme is not accepting applications right now. Please check back soon.', 'ayed-ghana' ); ?></p>
						<?php endif; ?>
					</div>
					<div class="program-cta__actions">
						<?php if ( $apply ) : ?>
							<a class="btn btn--primary" href="<?php echo esc_url( $apply['url'] ); ?>"><?php echo esc_html( $apply['label'] ); ?></a>
						<?php else : ?>
							<span class="program-cta__badge"><?php ayed_icon( 'close', array( 'size' => 16 ) ); ?><?php esc_html_e( 'Applications Closed', 'ayed-ghana' ); ?></span>
						<?php endif; ?>
						<?php if ( $external ) : ?>
							<a class="btn btn--outline" href="<?php echo esc_url( $external ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Program Site', 'ayed-ghana' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<footer class="single-content__footer">
				<a class="arrow-link arrow-link--back" href="<?php echo esc_url( $is_program ? get_post_type_archive_link( 'program' ) : home_url( '/' ) ); ?>">
					<?php ayed_icon( 'arrow-right', array( 'size' => 16, 'class' => 'arrow-link__back-icon' ) ); ?>
					<span><?php echo $is_program ? esc_html__( 'All Programs', 'ayed-ghana' ) : esc_html__( 'Back home', 'ayed-ghana' ); ?></span>
				</a>
			</footer>
		</div>
	</article>

	<?php
	// Associated events for this program.
	if ( $is_program ) :
		$ayed_events = ayed_events_for_program( get_the_ID() );
		if ( $ayed_events->have_posts() ) :
			?>
			<section class="section section--about related-events">
				<div class="container">
					<header class="section-head">
						<?php ayed_eyebrow( __( 'In Action', 'ayed-ghana' ) ); ?>
						<h2 class="section-title"><?php esc_html_e( 'Events from this Program', 'ayed-ghana' ); ?></h2>
					</header>
					<div class="events-grid">
						<?php
						while ( $ayed_events->have_posts() ) :
							$ayed_events->the_post();
							get_template_part( 'template-parts/content/event-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
			<?php
		endif;
	endif;

	if ( comments_open() || get_comments_number() ) {
		echo '<div class="container container--narrow">';
		comments_template();
		echo '</div>';
	}

endwhile;

get_footer();
