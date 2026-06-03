<?php
/**
 * Template Name: Apply Page
 *
 * A dedicated application journey for programmes such as Youth Development,
 * separate from the general contact form.
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
		'eyebrow'  => ayed_field( 'page_eyebrow', __( 'Join the Programme', 'ayed-ghana' ), get_the_ID() ),
		'title'    => get_the_title(),
		'subtitle' => ayed_field( 'page_subtitle', __( 'Tell us about yourself and the programme you want to join. It takes a couple of minutes.', 'ayed-ghana' ), get_the_ID() ),
	) );
	?>

	<section class="section section--light">
		<div class="container">
			<div class="apply-grid">
				<div class="apply-intro">
					<?php if ( trim( get_the_content() ) ) : ?>
						<div class="prose"><?php the_content(); ?></div>
					<?php else : ?>
						<h2 class="apply-intro__title"><?php esc_html_e( 'What happens next', 'ayed-ghana' ); ?></h2>
						<ol class="apply-steps">
							<li><span class="apply-steps__num">1</span><?php esc_html_e( 'Submit this short application form.', 'ayed-ghana' ); ?></li>
							<li><span class="apply-steps__num">2</span><?php esc_html_e( 'Our team reviews your details and gets in touch by email.', 'ayed-ghana' ); ?></li>
							<li><span class="apply-steps__num">3</span><?php esc_html_e( 'We invite you to the next intake for the programme.', 'ayed-ghana' ); ?></li>
						</ol>
					<?php endif; ?>
				</div>

				<div class="contact-form-wrap">
					<?php get_template_part( 'template-parts/content/application-form' ); ?>
				</div>
			</div>
		</div>
	</section>

<?php
endwhile;

get_footer();
