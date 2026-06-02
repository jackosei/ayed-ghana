<?php
/**
 * Front page template, composed of modular sections driven by Secure Custom Fields.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ayed_sections = array( 'hero', 'about', 'mission', 'pillars', 'programs', 'approach', 'involved' );

foreach ( $ayed_sections as $ayed_section ) {
	get_template_part( 'template-parts/sections/' . $ayed_section );
}

get_footer();
