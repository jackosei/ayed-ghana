<?php
/**
 * Lightweight SEO: meta description, canonical, Open Graph, Twitter cards
 * and JSON-LD structured data. Defers to dedicated SEO plugins when present.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether a full SEO plugin is active. If so, this module stays out of the way.
 *
 * @return bool
 */
function ayed_seo_plugin_active() {
	return (
		defined( 'WPSEO_VERSION' )          // Yoast.
		|| defined( 'RANK_MATH_VERSION' )   // Rank Math.
		|| class_exists( 'AIOSEO\\Plugin\\AIOSEO' ) // All in One SEO.
		|| function_exists( 'seopress_init' )       // SEOPress.
	);
}

/**
 * Resolve a sensible meta description for the current view.
 *
 * @return string
 */
function ayed_meta_description() {
	$description = '';

	if ( is_front_page() ) {
		$description = get_bloginfo( 'description' );
		if ( ! $description ) {
			$description = ayed_field( 'hero_sub', '', get_option( 'page_on_front' ) );
		}
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post ) {
			if ( has_excerpt( $post ) ) {
				$description = get_the_excerpt( $post );
			} else {
				$summary = ayed_field( 'program_summary', '', $post->ID );
				$description = $summary ? $summary : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 30, '' );
			}
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
	} elseif ( is_post_type_archive() ) {
		$description = get_the_archive_description();
	}

	$description = trim( wp_strip_all_tags( (string) $description ) );
	if ( ! $description ) {
		$description = get_bloginfo( 'description' );
	}
	return mb_substr( $description, 0, 300 );
}

/**
 * Output meta tags in the document head.
 */
function ayed_seo_head() {
	if ( ayed_seo_plugin_active() ) {
		return;
	}

	$description = ayed_meta_description();
	$title       = wp_get_document_title();
	$url         = ( is_singular() || is_page() ) ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$site_name   = get_bloginfo( 'name' );

	$image = '';
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( get_queried_object_id(), 'ayed-wide' );
	}
	if ( ! $image ) {
		$image = AYED_URI . '/assets/images/ayed-logo-512.jpg';
	}

	echo "\n<!-- AYED SEO -->\n";
	if ( $description ) {
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
	}
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );

	// Open Graph.
	printf( '<meta property="og:type" content="%s" />' . "\n", is_singular() && ! is_front_page() ? 'article' : 'website' );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
	}
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( $site_name ) );
	printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );

	// Twitter.
	printf( '<meta name="twitter:card" content="%s" />' . "\n", 'summary_large_image' );
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
	if ( $description ) {
		printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $description ) );
	}
	printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );

	ayed_seo_jsonld();
	echo "<!-- /AYED SEO -->\n";
}
add_action( 'wp_head', 'ayed_seo_head', 5 );

/**
 * JSON-LD structured data describing the organisation.
 */
function ayed_seo_jsonld() {
	$social = array();
	$links  = ayed_setting( 'social_links', array() );
	if ( is_array( $links ) ) {
		foreach ( $links as $link ) {
			if ( ! empty( $link['url'] ) ) {
				$social[] = esc_url_raw( $link['url'] );
			}
		}
	}

	$org = array(
		'@context' => 'https://schema.org',
		'@type'    => 'NGO',
		'name'     => get_bloginfo( 'name' ),
		'alternateName' => 'AYED Ghana',
		'url'      => home_url( '/' ),
		'logo'     => AYED_URI . '/assets/images/ayed-logo-512.jpg',
		'description' => get_bloginfo( 'description' ),
		'foundingDate' => (string) ayed_setting( 'founded_year', '2017' ),
		'areaServed'   => 'Ghana',
	);

	$email = ayed_setting( 'contact_email', '' );
	$phone = ayed_setting( 'contact_phone', '' );
	$addr  = ayed_setting( 'contact_address', '' );
	if ( $email || $phone ) {
		$org['contactPoint'] = array_filter( array(
			'@type'       => 'ContactPoint',
			'contactType' => 'general',
			'email'       => $email,
			'telephone'   => $phone,
		) );
	}
	if ( $addr ) {
		$org['address'] = array(
			'@type'           => 'PostalAddress',
			'addressLocality' => $addr,
			'addressCountry'  => 'GH',
		);
	}
	if ( $social ) {
		$org['sameAs'] = $social;
	}

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}

/**
 * Add a relevant title separator and tail.
 *
 * @param array $parts Title parts.
 * @return array
 */
function ayed_document_title_parts( $parts ) {
	if ( is_front_page() && empty( $parts['tagline'] ) ) {
		$parts['tagline'] = ayed_setting( 'org_tagline', 'African Youth Empowerment and Development' );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'ayed_document_title_parts' );
