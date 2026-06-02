<?php
/**
 * Default page template.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/page-header', null, array(
		'eyebrow'  => ayed_field( 'page_eyebrow', '', get_the_ID() ),
		'title'    => get_the_title(),
		'subtitle' => ayed_field( 'page_subtitle', '', get_the_ID() ),
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
