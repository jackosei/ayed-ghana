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
 * Register widget areas.
 */
function ayed_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'ayed-ghana' ),
		'id'            => 'footer-widgets',
		'description'   => __( 'Optional widgets shown in the footer.', 'ayed-ghana' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-widget__title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'ayed_widgets_init' );

/**
 * Custom post type: Programs.
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
 * Pagination defaults for the Programs archive.
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
}
add_action( 'pre_get_posts', 'ayed_programs_archive_query' );
