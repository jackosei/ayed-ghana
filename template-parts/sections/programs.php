<?php
/**
 * Section: Featured Programs.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag   = ayed_field( 'programs_tag', 'Featured Initiatives' );
$title = ayed_field( 'programs_title', "Programs Shaping [em]Ghana's Future[/em]" );

$featured = ayed_field( 'featured_programs', array() );

$args = array(
	'post_type'      => 'program',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
	'no_found_rows'  => true,
);
if ( ! empty( $featured ) && is_array( $featured ) ) {
	$args['post__in'] = array_map( 'intval', $featured );
	$args['orderby']  = 'post__in';
	$args['posts_per_page'] = count( $featured );
}
$programs = new WP_Query( $args );

// Default content shown only when no Program posts exist yet.
$defaults = array(
	array( 'label' => 'Environment and Heritage', 'icon' => 'mountain', 'color' => 'navy', 'title' => 'Ghana Geopark Experience', 'text' => 'A landmark project to develop Ghana\'s geological, natural, and cultural heritage into a UNESCO Global Geopark, turning the Volta Region\'s wonders into a global destination while empowering local communities.' ),
	array( 'label' => 'Youth Empowerment', 'icon' => 'seedling', 'color' => 'orange', 'title' => 'Skills and Leadership Academy', 'text' => 'Intensive training and mentorship programmes equipping young Ghanaians with entrepreneurial skills, financial literacy, and the leadership competencies needed to create meaningful change.' ),
	array( 'label' => 'Global Partnerships', 'icon' => 'handshake', 'color' => 'teal', 'title' => 'International Exchange and Diplomacy', 'text' => 'Cross-border collaborations with universities, UNESCO bodies, and international institutions that open doors for young Ghanaians and position Ghana on the world stage.' ),
);
?>
<section id="programs" class="section section--programs">
	<div class="container">
		<header class="section-head reveal">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="programs-grid reveal">
			<?php if ( $programs->have_posts() ) : ?>
				<?php
				while ( $programs->have_posts() ) :
					$programs->the_post();
					get_template_part( 'template-parts/content/program-card' );
				endwhile;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<?php foreach ( $defaults as $d ) : ?>
					<article class="program-card">
						<span class="program-card__media program-card__media--<?php echo esc_attr( $d['color'] ); ?>">
							<span class="program-card__glyph"><?php ayed_icon( $d['icon'], array( 'size' => 56 ) ); ?></span>
						</span>
						<div class="program-card__body">
							<span class="program-card__label"><?php echo esc_html( $d['label'] ); ?></span>
							<h3 class="program-card__title"><?php echo esc_html( $d['title'] ); ?></h3>
							<p class="program-card__text"><?php echo esc_html( $d['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<?php if ( $programs->have_posts() || post_type_exists( 'program' ) ) : ?>
			<div class="section__more reveal">
				<a class="btn btn--outline" href="<?php echo esc_url( get_post_type_archive_link( 'program' ) ); ?>"><?php esc_html_e( 'View All Programs', 'ayed-ghana' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
