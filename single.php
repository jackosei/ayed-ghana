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
			$external = $is_program ? ayed_field( 'program_external', '', get_the_ID() ) : '';
			if ( $external ) :
				?>
				<p class="single-content__cta">
					<a class="btn btn--primary" href="<?php echo esc_url( $external ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visit Program Site', 'ayed-ghana' ); ?></a>
				</p>
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
	if ( comments_open() || get_comments_number() ) {
		echo '<div class="container container--narrow">';
		comments_template();
		echo '</div>';
	}

endwhile;

get_footer();
