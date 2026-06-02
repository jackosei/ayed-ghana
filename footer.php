<?php
/**
 * Footer template.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ayed_blurb   = ayed_setting( 'footer_blurb', 'A non-governmental organisation dedicated to empowering the youth of Ghana and Africa.' );
$ayed_email   = ayed_setting( 'contact_email', 'info@ayedghana.com' );
$ayed_phone   = ayed_setting( 'contact_phone', '' );
$ayed_address = ayed_setting( 'contact_address', 'Accra, Ghana, West Africa' );
?>
</main><!-- #main -->

<footer id="colophon" class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__brand">
			<?php ayed_brand( true ); ?>
			<p class="site-footer__blurb"><?php echo esc_html( $ayed_blurb ); ?></p>
			<?php ayed_social_links( 'social-links social-links--footer' ); ?>
		</div>

		<div class="site-footer__col">
			<h4 class="site-footer__heading"><?php esc_html_e( 'Explore', 'ayed-ghana' ); ?></h4>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'site-footer__menu',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
			} else {
				echo '<ul class="site-footer__menu">';
				$ayed_footer_links = array(
					'#about'    => __( 'About', 'ayed-ghana' ),
					'#programs' => __( 'Programs', 'ayed-ghana' ),
					'#involved' => __( 'Get Involved', 'ayed-ghana' ),
					'#contact'  => __( 'Contact', 'ayed-ghana' ),
				);
				foreach ( $ayed_footer_links as $href => $label ) {
					$url = is_front_page() ? $href : home_url( '/' ) . $href;
					printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
		</div>

		<div class="site-footer__col">
			<h4 class="site-footer__heading"><?php esc_html_e( 'Contact', 'ayed-ghana' ); ?></h4>
			<ul class="site-footer__contact">
				<?php if ( $ayed_address ) : ?>
					<li><?php ayed_icon( 'map-pin', array( 'size' => 18 ) ); ?><span><?php echo esc_html( $ayed_address ); ?></span></li>
				<?php endif; ?>
				<?php if ( $ayed_email ) : ?>
					<li><?php ayed_icon( 'mail', array( 'size' => 18 ) ); ?><a href="mailto:<?php echo esc_attr( $ayed_email ); ?>"><?php echo esc_html( $ayed_email ); ?></a></li>
				<?php endif; ?>
				<?php if ( $ayed_phone ) : ?>
					<li><?php ayed_icon( 'phone', array( 'size' => 18 ) ); ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $ayed_phone ) ); ?>"><?php echo esc_html( $ayed_phone ); ?></a></li>
				<?php endif; ?>
			</ul>
		</div>

		<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
			<div class="site-footer__col site-footer__widgets">
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="site-footer__bar">
		<p class="site-footer__copy">
			<?php
			printf(
				/* translators: 1: year, 2: site name */
				esc_html__( '© %1$s %2$s. All rights reserved.', 'ayed-ghana' ),
				esc_html( gmdate( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<p class="site-footer__credit"><?php esc_html_e( 'African Youth Empowerment and Development Ghana', 'ayed-ghana' ); ?></p>
	</div>
</footer>

<button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'ayed-ghana' ); ?>" data-back-to-top>
	<?php ayed_icon( 'chevron', array( 'size' => 22, 'class' => 'back-to-top__icon' ) ); ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
