<?php
/**
 * Fallback template: blog index and archives.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ayed_title = __( 'Latest News', 'ayed-ghana' );
if ( is_home() && ! is_front_page() ) {
	$ayed_title = single_post_title( '', false );
	if ( ! $ayed_title ) {
		$ayed_title = __( 'News and Updates', 'ayed-ghana' );
	}
} elseif ( is_archive() ) {
	$ayed_title = get_the_archive_title();
} elseif ( is_search() ) {
	/* translators: %s: search query */
	$ayed_title = sprintf( __( 'Search results for "%s"', 'ayed-ghana' ), get_search_query() );
}

get_template_part( 'template-parts/content/page-header', null, array(
	'eyebrow'  => is_search() ? __( 'Search', 'ayed-ghana' ) : __( 'From AYED Ghana', 'ayed-ghana' ),
	'title'    => wp_strip_all_tags( $ayed_title ),
	'subtitle' => is_archive() ? wp_strip_all_tags( get_the_archive_description() ) : '',
) );
?>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/card' );
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
			<div class="no-results">
				<p><?php esc_html_e( 'Nothing found. Try a different search or browse our programs.', 'ayed-ghana' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
