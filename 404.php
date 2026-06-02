<?php
/**
 * 404 template.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="section section--dark error-404">
	<div class="container container--narrow error-404__inner">
		<span class="error-404__code">404</span>
		<h1 class="error-404__title"><?php esc_html_e( 'This page could not be found', 'ayed-ghana' ); ?></h1>
		<p class="error-404__text"><?php esc_html_e( 'The page you are looking for may have moved or no longer exists. Let us help you find your way.', 'ayed-ghana' ); ?></p>
		<div class="error-404__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'ayed-ghana' ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'program' ) ); ?>"><?php esc_html_e( 'View Programs', 'ayed-ghana' ); ?></a>
		</div>
		<div class="error-404__search"><?php get_search_form(); ?></div>
	</div>
</section>
<?php
get_footer();
