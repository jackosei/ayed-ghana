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
	$class      = $inverse ? 'brand brand--inverse' : 'brand';
	$home       = esc_url( home_url( '/' ) );
	$show_title = (bool) ayed_setting( 'show_site_title', true );

	$wordmark = '<span class="brand__text"><span class="brand__mark">AYED</span><span class="brand__sep">Ghana</span></span>';

	$logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$logo = wp_get_attachment_image( $logo_id, 'full', false, array(
			'class' => 'brand__logo',
			'alt'   => get_bloginfo( 'name' ),
		) );
		if ( $logo ) {
			printf(
				'<a class="%1$s brand--with-logo" href="%2$s" rel="home">%3$s%4$s</a>',
				esc_attr( $class ),
				$home,
				$logo, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image returns safe markup.
				$show_title ? $wordmark : '' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static trusted markup.
			);
			return;
		}
	}

	printf(
		'<a class="%1$s" href="%2$s" rel="home">%3$s</a>',
		esc_attr( $class ),
		$home,
		$wordmark // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static trusted markup.
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
 * Resolve the URL of the dedicated Contact page.
 *
 * Looks for a page using the Contact template, then a page with the slug
 * "contact". Falls back to a mailto link, then the home page.
 *
 * @return string
 */
function ayed_contact_url() {
	static $url = null;
	if ( null !== $url ) {
		return $url;
	}

	$pages = get_posts( array(
		'post_type'      => 'page',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'template-contact.php',
	) );
	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0] );
		return $url;
	}

	$page = get_page_by_path( 'contact' );
	if ( $page ) {
		$url = get_permalink( $page );
		return $url;
	}

	$email = ayed_setting( 'contact_email', '' );
	$url   = is_email( $email ) ? 'mailto:' . $email : home_url( '/' );
	return $url;
}

/**
 * Resolve the URL of the dedicated About page.
 *
 * Looks for a page using the About template, then a page with the slug
 * "about". Falls back to the homepage About section anchor.
 *
 * @return string
 */
function ayed_about_url() {
	static $url = null;
	if ( null !== $url ) {
		return $url;
	}

	$pages = get_posts( array(
		'post_type'      => 'page',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'template-about.php',
	) );
	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0] );
		return $url;
	}

	$page = get_page_by_path( 'about' );
	if ( $page ) {
		$url = get_permalink( $page );
		return $url;
	}

	$url = is_front_page() ? '#about' : home_url( '/#about' );
	return $url;
}

/**
 * Canonical list of contact form interests, keyed by slug.
 *
 * Used by the contact form select, the "Get Involved" links (for query-param
 * preselection) and the email handler, so all three stay in sync.
 *
 * @return array slug => label
 */
function ayed_contact_interests() {
	return array(
		'volunteering' => __( 'Volunteering', 'ayed-ghana' ),
		'partnership'  => __( 'Partnership', 'ayed-ghana' ),
		'donating'     => __( 'Donating', 'ayed-ghana' ),
		'programmes'   => __( 'Learning more about programmes', 'ayed-ghana' ),
		'media'        => __( 'Media or press enquiry', 'ayed-ghana' ),
		'other'        => __( 'Other', 'ayed-ghana' ),
	);
}

/**
 * Contact page URL, optionally with an interest preselected via query param.
 *
 * @param string $interest Interest slug from ayed_contact_interests().
 * @return string
 */
function ayed_contact_url_for( $interest = '' ) {
	$url = ayed_contact_url();
	if ( $interest && 0 === strpos( $url, 'http' ) ) {
		$url = add_query_arg( 'interest', rawurlencode( $interest ), $url );
	}
	return $url;
}

/**
 * Resolve the URL of the dedicated Apply page, optionally preselecting a program.
 *
 * @param int $program_id Optional program post ID to preselect via query param.
 * @return string
 */
function ayed_apply_url( $program_id = 0 ) {
	static $base = null;
	if ( null === $base ) {
		$pages = get_posts( array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'template-apply.php',
		) );
		if ( ! empty( $pages ) ) {
			$base = get_permalink( $pages[0] );
		} else {
			$page = get_page_by_path( 'apply' );
			$base = $page ? get_permalink( $page ) : '';
		}
	}

	// Fall back to the contact page if no Apply page exists yet.
	$url = $base ? $base : ayed_contact_url();

	if ( $program_id && 0 === strpos( $url, 'http' ) ) {
		$slug = get_post_field( 'post_name', $program_id );
		if ( $slug ) {
			$url = add_query_arg( 'program', rawurlencode( $slug ), $url );
		}
	}
	return $url;
}

/**
 * Whether a given program is currently accepting applications.
 *
 * Driven by the per-program "Accepting Applications" toggle.
 *
 * @param int $program_id Program post ID.
 * @return bool
 */
function ayed_program_accepting( $program_id ) {
	return $program_id && (bool) ayed_field( 'accepting_applications', false, $program_id );
}

/**
 * The contextual Apply button label and link for a given program.
 *
 * The URL always preselects this program on the application form, so the
 * applicant never has to choose it manually and never sees the wrong program.
 *
 * @param int $program_id Program post ID.
 * @return array|null { label, url } or null when the program is not accepting applications.
 */
function ayed_program_apply( $program_id ) {
	if ( ! ayed_program_accepting( $program_id ) ) {
		return null;
	}
	$label = ayed_field( 'apply_label', __( 'Apply Now', 'ayed-ghana' ), $program_id );
	$url   = ayed_field( 'apply_url', '', $program_id );
	if ( ! $url ) {
		$url = ayed_apply_url( $program_id );
	}
	return array( 'label' => $label, 'url' => $url );
}

/**
 * Age brackets offered on the application form.
 *
 * @return array slug => label
 */
function ayed_age_brackets() {
	return array(
		'under-18' => __( 'Under 18', 'ayed-ghana' ),
		'18-24'    => __( '18 to 24', 'ayed-ghana' ),
		'25-30'    => __( '25 to 30', 'ayed-ghana' ),
		'31-35'    => __( '31 to 35', 'ayed-ghana' ),
		'over-35'  => __( 'Over 35', 'ayed-ghana' ),
	);
}

/**
 * Default navigation items used when no menu is assigned to the primary location.
 *
 * @return array List of items with 'url' and 'label'.
 */
function ayed_fallback_nav_items() {
	// Home, About, Programs, Events, Get Involved. Contact is the header CTA
	// button (rendered separately), not an inline link.
	$items = array(
		array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'ayed-ghana' ) ),
		array( 'url' => ayed_about_url(), 'label' => __( 'About', 'ayed-ghana' ) ),
		array( 'url' => get_post_type_archive_link( 'program' ), 'label' => __( 'Programs', 'ayed-ghana' ) ),
		array( 'url' => get_post_type_archive_link( 'event' ), 'label' => __( 'Events', 'ayed-ghana' ) ),
		array( 'url' => is_front_page() ? '#involved' : home_url( '/#involved' ), 'label' => __( 'Get Involved', 'ayed-ghana' ) ),
	);

	// Drop any items whose URL could not be resolved.
	return array_values( array_filter( $items, static function ( $item ) {
		return ! empty( $item['url'] );
	} ) );
}

/**
 * Query events associated with a given program via the related_programs field.
 *
 * @param int $program_id Program post ID.
 * @return WP_Query
 */
function ayed_events_for_program( $program_id ) {
	return new WP_Query( array(
		'post_type'      => 'event',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
		'meta_key'       => 'event_date',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'related_programs',
				'value'   => '"' . (int) $program_id . '"',
				'compare' => 'LIKE',
			),
		),
	) );
}

/**
 * Format an event date stored by Secure Custom Fields (Ymd) for display.
 *
 * @param string $raw Raw date value (Ymd) or empty.
 * @return string
 */
function ayed_format_event_date( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return '';
	}
	$timestamp = strtotime( $raw );
	if ( ! $timestamp ) {
		return $raw;
	}
	return date_i18n( get_option( 'date_format', 'j F Y' ), $timestamp );
}

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
