<?php
/**
 * Inline SVG icon system.
 *
 * Provides clean, accessible vector icons in place of emoji. Icons inherit the
 * current text colour via `currentColor` and scale with font size.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the raw SVG path markup for a named icon.
 *
 * Icons use a 24x24 viewBox, no fill, 1.75 stroke, rounded joins.
 *
 * @param string $name Icon key.
 * @return string Inner SVG markup, or empty string if unknown.
 */
function ayed_icon_paths( $name ) {
	$icons = array(
		// Brand / mission.
		'compass'    => '<circle cx="12" cy="12" r="9"/><polygon points="16.2 7.8 13.4 13.4 7.8 16.2 10.6 10.6 16.2 7.8"/>',
		'eye'        => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
		'heart'      => '<path d="M20.8 5.6a5.5 5.5 0 0 0-7.8 0L12 6.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/>',
		'route'      => '<circle cx="6" cy="19" r="2.5"/><circle cx="18" cy="5" r="2.5"/><path d="M8.5 19H15a3.5 3.5 0 0 0 0-7H9a3.5 3.5 0 0 1 0-7h6.5"/>',
		// Pillars.
		'book'       => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15.5H6.5A2.5 2.5 0 0 0 4 21Z"/><path d="M4 5.5V21"/><path d="M20 18.5H6.5"/>',
		'pulse'      => '<path d="M3 12h4l2.5-6 4 13 2.5-7H21"/>',
		'briefcase'  => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 12h18"/>',
		'globe'      => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.7 3.8 5.8 3.8 9s-1.3 6.3-3.8 9c-2.5-2.7-3.8-5.8-3.8-9S9.5 5.7 12 3Z"/>',
		'landmark'   => '<path d="M3 21h18"/><path d="M4 10h16"/><path d="M12 3 21 8H3Z"/><path d="M6 10v8M10 10v8M14 10v8M18 10v8"/>',
		// Programs / approach.
		'mountain'   => '<path d="M3 20 9.5 8l4 6 2-3L21 20Z"/>',
		'seedling'   => '<path d="M12 21v-7"/><path d="M12 14c0-3 2.5-5.5 6-5.5 0 3-2.5 5.5-6 5.5Z"/><path d="M12 12c0-3-2.5-5.5-6-5.5 0 3 2.5 5.5 6 5.5Z"/>',
		'handshake'  => '<path d="m11 17 2 2a1.4 1.4 0 0 0 2-2"/><path d="m13 19 2-2a1.4 1.4 0 0 0 2 2l1-1"/><path d="M3 11.5 7 7l4 1.5 3-2 6 5"/><path d="m18 11.5-3-2.5-3 2.5-2-1"/><path d="M3 11.5 6 14M21 11l-3 3"/>',
		'graduation' => '<path d="M22 9 12 4 2 9l10 5 10-5Z"/><path d="M6 11v5c0 1.1 2.7 2.5 6 2.5s6-1.4 6-2.5v-5"/>',
		'users'      => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><path d="M15.5 5.2A3.2 3.2 0 0 1 17 11.4"/><path d="M16.5 15c2.4.4 4 2.4 4 5"/>',
		'target'     => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>',
		'network'    => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="18" r="2.5"/><circle cx="19" cy="18" r="2.5"/><path d="M12 7.5v4M10 13.5 6.5 16M14 13.5 17.5 16"/>',
		'link'       => '<path d="M9 15 15 9"/><path d="M11 7l1-1a3.5 3.5 0 0 1 5 5l-1 1"/><path d="M13 17l-1 1a3.5 3.5 0 0 1-5-5l1-1"/>',
		// Get involved.
		'hand-heart' => '<path d="M11 14 8 11a1.6 1.6 0 0 1 2.3-2.2l.7.7.7-.7A1.6 1.6 0 0 1 14 11l-3 3Z"/><path d="M3 13v5a2 2 0 0 0 2 2h11l4-2a1.6 1.6 0 0 0-1.6-2.7L15 18"/><path d="M3 13a2 2 0 0 1 2-2h3"/>',
		'star'       => '<path d="m12 3 2.6 5.6L21 9.4l-4.5 4.3 1.1 6.3L12 17l-5.6 3 1.1-6.3L3 9.4l6.4-.8Z"/>',
		'gift'       => '<rect x="3" y="9" width="18" height="11" rx="1"/><path d="M3 13h18"/><path d="M12 9v11"/><path d="M12 9C9 9 7 8 7 6.2A2 2 0 0 1 12 6a2 2 0 0 1 5 .2C17 8 15 9 12 9Z"/>',
		// Contact.
		'map-pin'    => '<path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
		'mail'       => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/>',
		'phone'      => '<path d="M5 3h3l2 5-2.5 1.5a12 12 0 0 0 5 5L19 14l2 5v.5A2.5 2.5 0 0 1 18.5 22 16 16 0 0 1 3 6.5 2.5 2.5 0 0 1 5.5 4Z"/>',
		// Utility / UI.
		'arrow-right'=> '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
		'chevron'    => '<path d="m9 6 6 6-6 6"/>',
		'check'      => '<path d="m5 12 4.5 4.5L19 7"/>',
		'menu'       => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'      => '<path d="M6 6 18 18M18 6 6 18"/>',
		'quote'      => '<path d="M7 7h4v4c0 2.5-1.5 4-4 4.5V14c1-.4 1.6-1 1.6-2H7Z"/><path d="M15 7h4v4c0 2.5-1.5 4-4 4.5V14c1-.4 1.6-1 1.6-2H15Z"/>',
		// Social.
		'facebook'   => '<path d="M14 8.5h2.5V5.5H14c-2 0-3.5 1.5-3.5 3.5v2H8v3h2.5V21h3v-7H16l.5-3h-3V9.2c0-.4.3-.7.7-.7Z"/>',
		'instagram'  => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="3.6"/><circle cx="17" cy="7" r="1"/>',
		'twitter'    => '<path d="M4 4l7 9.5L4.5 20H7l5-5.4L16 20h4l-7.3-9.9L19.5 4H17l-4.5 4.9L9 4Z"/>',
		'linkedin'   => '<rect x="3.5" y="3.5" width="17" height="17" rx="2"/><path d="M8 10v7M8 7.2v.1"/><path d="M12 17v-4a2.2 2.2 0 0 1 4.4 0v4"/><path d="M12 17v-7"/>',
		'youtube'    => '<rect x="3" y="6" width="18" height="12" rx="3"/><path d="m11 9.5 4 2.5-4 2.5Z"/>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Echo an inline SVG icon.
 *
 * @param string $name  Icon key from ayed_icon_paths().
 * @param array  $args  Optional. size (px), class, label, stroke.
 */
function ayed_icon( $name, $args = array() ) {
	echo ayed_get_icon( $name, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Returns trusted, hard-coded SVG.
}

/**
 * Build an inline SVG icon string.
 *
 * @param string $name Icon key.
 * @param array  $args Optional arguments.
 * @return string Sanitised SVG markup.
 */
function ayed_get_icon( $name, $args = array() ) {
	$paths = ayed_icon_paths( $name );
	if ( '' === $paths ) {
		return '';
	}

	$args = wp_parse_args( $args, array(
		'size'   => 24,
		'class'  => '',
		'label'  => '',
		'stroke' => 1.75,
	) );

	$classes = trim( 'ayed-icon ' . $args['class'] );
	$aria    = '';
	if ( $args['label'] ) {
		$aria = ' role="img" aria-label="' . esc_attr( $args['label'] ) . '"';
	} else {
		$aria = ' aria-hidden="true" focusable="false"';
	}

	return sprintf(
		'<svg class="%1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%3$s" stroke-linecap="round" stroke-linejoin="round"%4$s>%5$s</svg>',
		esc_attr( $classes ),
		(int) $args['size'],
		esc_attr( $args['stroke'] ),
		$aria,
		$paths
	);
}

/**
 * List of icon choices for Secure Custom Fields select inputs.
 *
 * @return array
 */
function ayed_icon_choices() {
	return array(
		'compass'    => 'Compass (mission)',
		'eye'        => 'Eye (vision)',
		'heart'      => 'Heart (values)',
		'route'      => 'Route (approach)',
		'book'       => 'Book (education)',
		'pulse'      => 'Pulse (health)',
		'briefcase'  => 'Briefcase (employment)',
		'globe'      => 'Globe (international)',
		'landmark'   => 'Landmark (leadership)',
		'mountain'   => 'Mountain (environment)',
		'seedling'   => 'Seedling (growth)',
		'handshake'  => 'Handshake (partnership)',
		'graduation' => 'Graduation (academy)',
		'users'      => 'Users (community)',
		'target'     => 'Target (training)',
		'network'    => 'Network (networking)',
		'link'       => 'Link (alliances)',
		'hand-heart' => 'Hand and heart (volunteer)',
		'star'       => 'Star',
		'gift'       => 'Gift (donate)',
		'quote'      => 'Quote',
	);
}
