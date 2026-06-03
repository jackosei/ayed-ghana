<?php
/**
 * Theme setup: supports, menus, image sizes, custom post types and taxonomies.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core theme supports.
 */
function ayed_theme_setup() {
	load_theme_textdomain( 'ayed-ghana', AYED_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 120,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'ayed-ghana' ),
		'footer'  => __( 'Footer Navigation', 'ayed-ghana' ),
	) );

	// Custom image sizes for cards and hero.
	add_image_size( 'ayed-card', 720, 480, true );
	add_image_size( 'ayed-wide', 1600, 900, true );
}
add_action( 'after_setup_theme', 'ayed_theme_setup' );

/**
 * Content width.
 */
function ayed_content_width() {
	$GLOBALS['content_width'] = 1140;
}
add_action( 'after_setup_theme', 'ayed_content_width', 0 );

/**
 * Custom post types: Programs and Events.
 */
function ayed_register_post_types() {
	$program_labels = array(
		'name'               => __( 'Programs', 'ayed-ghana' ),
		'singular_name'      => __( 'Program', 'ayed-ghana' ),
		'add_new'            => __( 'Add New', 'ayed-ghana' ),
		'add_new_item'       => __( 'Add New Program', 'ayed-ghana' ),
		'edit_item'          => __( 'Edit Program', 'ayed-ghana' ),
		'new_item'           => __( 'New Program', 'ayed-ghana' ),
		'view_item'          => __( 'View Program', 'ayed-ghana' ),
		'search_items'       => __( 'Search Programs', 'ayed-ghana' ),
		'not_found'          => __( 'No programs found', 'ayed-ghana' ),
		'not_found_in_trash' => __( 'No programs found in Trash', 'ayed-ghana' ),
		'all_items'          => __( 'All Programs', 'ayed-ghana' ),
		'menu_name'          => __( 'Programs', 'ayed-ghana' ),
	);

	register_post_type( 'program', array(
		'labels'       => $program_labels,
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-awards',
		'menu_position' => 22,
		'rewrite'      => array( 'slug' => 'programs', 'with_front' => false ),
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
		'show_in_rest' => true,
	) );

	// Taxonomy: Program Category.
	register_taxonomy( 'program_category', 'program', array(
		'labels'            => array(
			'name'          => __( 'Program Categories', 'ayed-ghana' ),
			'singular_name' => __( 'Program Category', 'ayed-ghana' ),
			'menu_name'     => __( 'Categories', 'ayed-ghana' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'program-category' ),
	) );

	// Events: photo and video showcase of past events and projects.
	$event_labels = array(
		'name'               => __( 'Events', 'ayed-ghana' ),
		'singular_name'      => __( 'Event', 'ayed-ghana' ),
		'add_new'            => __( 'Add New', 'ayed-ghana' ),
		'add_new_item'       => __( 'Add New Event', 'ayed-ghana' ),
		'edit_item'          => __( 'Edit Event', 'ayed-ghana' ),
		'new_item'           => __( 'New Event', 'ayed-ghana' ),
		'view_item'          => __( 'View Event', 'ayed-ghana' ),
		'search_items'       => __( 'Search Events', 'ayed-ghana' ),
		'not_found'          => __( 'No events found', 'ayed-ghana' ),
		'not_found_in_trash' => __( 'No events found in Trash', 'ayed-ghana' ),
		'all_items'          => __( 'All Events', 'ayed-ghana' ),
		'menu_name'          => __( 'Events', 'ayed-ghana' ),
	);

	register_post_type( 'event', array(
		'labels'        => $event_labels,
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-calendar-alt',
		'menu_position' => 23,
		'rewrite'       => array( 'slug' => 'events', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'ayed_register_post_types' );

/**
 * Flush rewrite rules once on activation so the Programs CPT works immediately.
 */
function ayed_rewrite_flush() {
	ayed_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ayed_rewrite_flush' );

/**
 * Flush rewrite rules once after a theme update introduces new post types,
 * so custom URLs (such as Events) resolve without a manual permalink save.
 */
function ayed_maybe_flush_rewrites() {
	if ( get_option( 'ayed_rewrite_version' ) !== AYED_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'ayed_rewrite_version', AYED_VERSION );
	}
}
add_action( 'init', 'ayed_maybe_flush_rewrites', 99 );

/**
 * Ensure the core "About", "Contact" and "Apply" pages exist and use their
 * templates, so the navigation and CTAs always resolve to a real page. Runs once
 * per provisioning version; pages the site owner creates or deletes are respected.
 */
function ayed_provision_pages() {
	$provision_version = '2';
	if ( get_option( 'ayed_pages_provisioned' ) === $provision_version ) {
		return;
	}

	$pages = array(
		'about'   => array(
			'title'    => __( 'About Us', 'ayed-ghana' ),
			'template' => 'template-about.php',
			'content'  => '<p>AYED Ghana is a non-governmental organisation dedicated to empowering the youth of Ghana and Africa. We build human potential by giving young people the tools, networks, and opportunities they need to shape their own futures.</p>',
		),
		'contact' => array(
			'title'    => __( 'Contact', 'ayed-ghana' ),
			'template' => 'template-contact.php',
			'content'  => '<p>Whether you want to learn more about our programmes, explore a partnership, or simply connect with our team, reach out and we will respond promptly.</p>',
		),
		'apply'   => array(
			'title'    => __( 'Apply', 'ayed-ghana' ),
			'template' => 'template-apply.php',
			'content'  => '',
		),
	);

	foreach ( $pages as $slug => $data ) {
		// Skip if a page with this slug or this template already exists.
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			continue;
		}
		$by_template = get_posts( array(
			'post_type'      => 'page',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'post_status'    => 'any',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $data['template'],
		) );
		if ( ! empty( $by_template ) ) {
			continue;
		}

		$page_id = wp_insert_post( array(
			'post_title'   => $data['title'],
			'post_name'    => $slug,
			'post_content' => $data['content'],
			'post_status'  => 'publish',
			'post_type'    => 'page',
		) );
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', $data['template'] );
		}
	}

	update_option( 'ayed_pages_provisioned', $provision_version );
}
add_action( 'admin_init', 'ayed_provision_pages' );

/**
 * Create the dedicated Contact page once, assigned to the Contact template,
 * so the navigation link always resolves to a real page.
 */
function ayed_install_pages() {
	if ( get_option( 'ayed_pages_installed' ) ) {
		return;
	}

	$contact = get_page_by_path( 'contact' );
	if ( ! $contact ) {
		$contact_id = wp_insert_post( array(
			'post_title'   => __( 'Contact', 'ayed-ghana' ),
			'post_name'    => 'contact',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
		if ( $contact_id && ! is_wp_error( $contact_id ) ) {
			update_post_meta( $contact_id, '_wp_page_template', 'template-contact.php' );
		}
	} elseif ( '' === (string) get_post_meta( $contact->ID, '_wp_page_template', true ) || 'default' === (string) get_post_meta( $contact->ID, '_wp_page_template', true ) ) {
		update_post_meta( $contact->ID, '_wp_page_template', 'template-contact.php' );
	}

	update_option( 'ayed_pages_installed', 1 );
}
add_action( 'init', 'ayed_install_pages', 100 );

/**
 * Pagination and ordering defaults for the custom archives.
 */
function ayed_programs_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'program' ) || $query->is_tax( 'program_category' ) ) {
		$query->set( 'posts_per_page', 9 );
		$query->set( 'orderby', 'menu_order date' );
		$query->set( 'order', 'ASC' );
	}
	if ( $query->is_post_type_archive( 'event' ) ) {
		$query->set( 'posts_per_page', 9 );
		$query->set( 'meta_key', 'event_date' );
		$query->set( 'orderby', array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ) );
	}
}
add_action( 'pre_get_posts', 'ayed_programs_archive_query' );
