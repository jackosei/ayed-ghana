<?php
/**
 * Header template.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'ayed-ghana' ); ?></a>

<header id="masthead" class="site-header" data-header>
	<div class="site-header__inner">
		<div class="site-header__brand">
			<?php ayed_brand(); ?>
		</div>

		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'ayed-ghana' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__menu',
					'depth'          => 2,
					'fallback_cb'    => false,
				) );
			} else {
				echo '<ul class="site-nav__menu">';
				foreach ( ayed_fallback_nav_items() as $ayed_item ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( $ayed_item['url'] ), esc_html( $ayed_item['label'] ) );
				}
				echo '</ul>';
			}
			?>
		</nav>

		<div class="site-header__cta">
			<a class="btn btn--primary btn--sm" href="<?php echo esc_url( is_front_page() ? '#involved' : home_url( '/#involved' ) ); ?>"><?php esc_html_e( 'Get Involved', 'ayed-ghana' ); ?></a>
			<button class="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'ayed-ghana' ); ?>" data-nav-toggle>
				<?php ayed_icon( 'menu', array( 'size' => 26, 'class' => 'nav-toggle__open' ) ); ?>
				<?php ayed_icon( 'close', array( 'size' => 26, 'class' => 'nav-toggle__close' ) ); ?>
			</button>
		</div>
	</div>

	<div id="mobile-nav" class="mobile-nav" hidden data-mobile-nav>
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mobile-nav__menu',
				'depth'          => 1,
				'fallback_cb'    => false,
			) );
		} else {
			echo '<ul class="mobile-nav__menu">';
			foreach ( ayed_fallback_nav_items() as $ayed_item ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( $ayed_item['url'] ), esc_html( $ayed_item['label'] ) );
			}
			echo '</ul>';
		}
		?>
	</div>
</header>

<main id="main" class="site-main">
