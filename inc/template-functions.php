<?php
/**
 * Template helper functions.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get an SCF/ACF field with a safe fallback when the plugin is inactive.
 *
 * @param string $name     Field name.
 * @param mixed  $default  Fallback value.
 * @param mixed  $post_id  Post ID, or 'option' for options page.
 * @return mixed
 */
function ayed_field( $name, $default = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
		if ( null !== $value && '' !== $value && array() !== $value && false !== $value ) {
			return $value;
		}
	}
	return $default;
}

/**
 * Get a global setting from the options page with a fallback.
 *
 * @param string $name    Field name.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function ayed_setting( $name, $default = '' ) {
	return ayed_field( $name, $default, 'option' );
}

/**
 * Convert [em]...[/em] markers into a highlighted span. Output is escaped.
 *
 * @param string $text Raw text containing optional [em] markers.
 * @return string Safe HTML.
 */
function ayed_emphasis( $text ) {
	$text = (string) $text;
	$parts = preg_split( '/(\[em\].*?\[\/em\])/s', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	$out   = '';
	foreach ( $parts as $part ) {
		if ( preg_match( '/^\[em\](.*?)\[\/em\]$/s', $part, $m ) ) {
			$out .= '<em class="accent">' . esc_html( $m[1] ) . '</em>';
		} else {
			$out .= esc_html( $part );
		}
	}
	return $out;
}

/**
 * Echo an emphasised title.
 *
 * @param string $text Raw title.
 */
function ayed_the_emphasis( $text ) {
	echo ayed_emphasis( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ayed_emphasis escapes its output.
}

/**
 * Render a section eyebrow tag.
 *
 * @param string $text Eyebrow text.
 */
function ayed_eyebrow( $text ) {
	if ( ! $text ) {
		return;
	}
	echo '<span class="section-eyebrow">' . esc_html( $text ) . '</span>';
}

/**
 * Output the social links list from settings.
 *
 * @param string $class Wrapper class.
 */
function ayed_social_links( $class = 'social-links' ) {
	$links = ayed_setting( 'social_links', array() );
	if ( empty( $links ) || ! is_array( $links ) ) {
		return;
	}
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $links as $link ) {
		$network = isset( $link['network'] ) ? $link['network'] : '';
		$url     = isset( $link['url'] ) ? $link['url'] : '';
		if ( ! $network || ! $url ) {
			continue;
		}
		printf(
			'<li><a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a></li>',
			esc_url( $url ),
			esc_attr( ucfirst( $network ) ),
			ayed_get_icon( $network, array( 'size' => 18, 'label' => ucfirst( $network ) ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	echo '</ul>';
}

/**
 * Brand logo: custom logo if set, otherwise text mark.
 *
 * @param bool $inverse Use light text for dark backgrounds.
 */
function ayed_brand( $inverse = false ) {
	$class = $inverse ? 'brand brand--inverse' : 'brand';
	if ( has_custom_logo() ) {
		echo '<div class="' . esc_attr( $class ) . ' brand--image">';
		the_custom_logo();
		echo '</div>';
		return;
	}
	printf(
		'<a class="%1$s" href="%2$s" rel="home"><span class="brand__mark">AYED</span><span class="brand__sep">Ghana</span></a>',
		esc_attr( $class ),
		esc_url( home_url( '/' ) )
	);
}

/**
 * Excerpt length tweak.
 *
 * @param int $length Default length.
 * @return int
 */
function ayed_excerpt_length( $length ) {
	return 28;
}
add_filter( 'excerpt_length', 'ayed_excerpt_length' );

/**
 * Excerpt ellipsis.
 *
 * @return string
 */
function ayed_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'ayed_excerpt_more' );

/**
 * Body classes.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function ayed_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'ayed_body_classes' );

/**
 * A reusable "read more" arrow link.
 *
 * @param string $url   URL.
 * @param string $label Label.
 * @return string
 */
function ayed_arrow_link( $url, $label ) {
	return sprintf(
		'<a class="arrow-link" href="%1$s"><span>%2$s</span>%3$s</a>',
		esc_url( $url ),
		esc_html( $label ),
		ayed_get_icon( 'arrow-right', array( 'size' => 16 ) )
	);
}
