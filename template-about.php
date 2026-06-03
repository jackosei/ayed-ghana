<?php
/**
 * Template Name: About Page
 *
 * The full story: an intro, then the foundation (mission, vision, values),
 * areas of impact, and how we work. These sections were moved off the homepage
 * to keep the front page focused.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	// The page subtitle becomes the prominent lead statement, so it is not
	// repeated in the hero.
	$ayed_statement = ayed_field( 'page_subtitle', '', get_the_ID() );
	if ( ! $ayed_statement ) {
		$ayed_statement = __( 'We build human potential, giving young people the tools, networks, and opportunities they need to [em]shape their own futures.[/em]', 'ayed-ghana' );
	}
	$ayed_body = trim( get_the_content() );

	get_template_part( 'template-parts/content/page-header', null, array(
		'eyebrow'  => ayed_field( 'page_eyebrow', __( 'Who We Are', 'ayed-ghana' ), get_the_ID() ),
		'title'    => get_the_title(),
		'subtitle' => '',
	) );
	?>
	<section class="section section--light about-lead">
		<div class="container">
			<div class="about-lead__grid">
				<div class="about-lead__aside">
					<?php ayed_eyebrow( __( 'Our Story', 'ayed-ghana' ) ); ?>
					<p class="about-lead__statement"><?php ayed_the_emphasis( $ayed_statement ); ?></p>
					<span class="about-lead__rule" aria-hidden="true"></span>
				</div>
				<div class="about-lead__body prose">
					<?php
					if ( $ayed_body ) {
						the_content();
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php

	// Foundation, areas of impact and approach, sourced from this page's fields.
	get_template_part( 'template-parts/sections/mission' );
	get_template_part( 'template-parts/sections/pillars' );
	get_template_part( 'template-parts/sections/approach' );

endwhile;

get_footer();
