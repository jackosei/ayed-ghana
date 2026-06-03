<?php
/**
 * Section: About.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag   = ayed_field( 'about_tag', 'Who We Are' );
$title = ayed_field( 'about_title', 'African Youth Empowerment and [em]Development[/em] Ghana' );
$body  = ayed_field( 'about_body', '<p><strong>AYED Ghana</strong> is a non-governmental organisation dedicated to empowering the youth of Ghana and Africa. We are builders of human potential, giving young people the tools, networks, and opportunities they need to shape their own futures.</p><p>We recognise that young people learn best through active participation. Whether in classrooms, communities, or boardrooms, we create the conditions for growth, providing every young person the chance to feel competent, useful, and empowered.</p>' );
$image = ayed_field( 'about_image', '' );

$stats = ayed_field( 'about_stats', array(
	array( 'number' => ayed_setting( 'founded_year', '2017' ), 'label' => 'Year Founded' ),
	array( 'number' => '5+', 'label' => 'Active Programs' ),
	array( 'number' => 'Pan-Africa', 'label' => 'Vision and Reach' ),
) );
?>
<section id="about" class="section section--about reveal">
	<div class="container">
		<header class="section-head">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="about-grid">
			<div class="about-grid__text">
				<?php echo wp_kses_post( $body ); ?>
				<?php
				$ayed_about_url = ayed_about_url();
				if ( $ayed_about_url && false === strpos( $ayed_about_url, '#about' ) ) :
					?>
					<p class="about-grid__cta">
						<a class="btn btn--outline" href="<?php echo esc_url( $ayed_about_url ); ?>"><?php esc_html_e( 'More About Us', 'ayed-ghana' ); ?></a>
					</p>
				<?php endif; ?>
			</div>

			<div class="about-grid__visual">
				<?php if ( is_array( $image ) && ! empty( $image['url'] ) ) : ?>
					<img class="about-image" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ? $image['alt'] : get_bloginfo( 'name' ) ); ?>" loading="lazy" width="<?php echo esc_attr( $image['width'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>" />
				<?php else : ?>
					<?php get_template_part( 'template-parts/content/emblem' ); ?>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( ! empty( $stats ) && is_array( $stats ) ) : ?>
			<div class="stat-row">
				<?php foreach ( $stats as $stat ) : ?>
					<?php if ( empty( $stat['number'] ) ) { continue; } ?>
					<div class="stat">
						<span class="stat__num"><?php echo esc_html( $stat['number'] ); ?></span>
						<span class="stat__label"><?php echo esc_html( isset( $stat['label'] ) ? $stat['label'] : '' ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
