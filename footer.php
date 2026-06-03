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
$ayed_email   = ayed_setting( 'contact_email', 'info@ayedghana.org' );
$ayed_phone   = ayed_setting( 'contact_phone', '' );
$ayed_address = ayed_setting( 'contact_address', 'C170/5, Adenkum Road, Accra, Ghana' );
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
				foreach ( ayed_fallback_nav_items() as $ayed_link ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( $ayed_link['url'] ), esc_html( $ayed_link['label'] ) );
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
