<?php
/**
 * Template Name: Contact Page
 *
 * A dedicated contact page: page intro, organisation details and the secure
 * AJAX contact form.
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
		'eyebrow'  => ayed_field( 'page_eyebrow', __( 'Reach Out', 'ayed-ghana' ), get_the_ID() ),
		'title'    => get_the_title(),
		'subtitle' => ayed_field( 'page_subtitle', '', get_the_ID() ),
	) );
	?>

	<section class="section section--contact">
		<div class="container">
			<div class="contact-grid">
				<div class="contact-info">
					<?php if ( get_the_content() ) : ?>
						<div class="contact-info__intro prose"><?php the_content(); ?></div>
					<?php else : ?>
						<p class="contact-info__intro"><?php esc_html_e( 'Whether you want to learn more about our programmes, explore a partnership, or simply connect with our team, reach out and we will respond promptly.', 'ayed-ghana' ); ?></p>
					<?php endif; ?>

					<?php get_template_part( 'template-parts/content/contact-info' ); ?>

					<?php $ayed_apply = ayed_apply_url(); ?>
					<?php if ( $ayed_apply && 0 === strpos( $ayed_apply, 'http' ) ) : ?>
						<p class="contact-callout">
							<?php ayed_icon( 'graduation', array( 'size' => 20 ) ); ?>
							<span>
								<?php esc_html_e( 'Applying to a programme?', 'ayed-ghana' ); ?>
								<a href="<?php echo esc_url( $ayed_apply ); ?>"><?php esc_html_e( 'Use the application form', 'ayed-ghana' ); ?></a>
							</span>
						</p>
					<?php endif; ?>
				</div>

				<div class="contact-form-wrap">
					<?php get_template_part( 'template-parts/content/contact-form' ); ?>
				</div>
			</div>
		</div>
	</section>

<?php
endwhile;

get_footer();
