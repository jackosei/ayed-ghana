<?php
/**
 * Programs archive.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/content/page-header', null, array(
	'eyebrow'  => __( 'Our Work', 'ayed-ghana' ),
	'title'    => post_type_archive_title( '', false ),
	'subtitle' => __( 'Initiatives empowering young people across Ghana and the continent.', 'ayed-ghana' ),
) );
?>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="programs-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/program-card' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination( array(
				'mid_size'  => 1,
				'prev_text' => esc_html__( 'Previous', 'ayed-ghana' ),
				'next_text' => esc_html__( 'Next', 'ayed-ghana' ),
			) );
			?>
		<?php else : ?>
			<p class="no-results"><?php esc_html_e( 'No programs have been published yet. Please check back soon.', 'ayed-ghana' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
