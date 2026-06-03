<?php
/**
 * Secure Custom Fields (SCF) registration.
 *
 * All field groups are registered in PHP via acf_add_local_field_group() so the
 * theme is self-contained and version controlled. The same API is exposed by
 * the Secure Custom Fields plugin and by Advanced Custom Fields, so this works
 * with either. Every call is guarded so the theme never fatals when the plugin
 * is inactive.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin notice prompting the site owner to install Secure Custom Fields.
 */
function ayed_scf_admin_notice() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	$search = admin_url( 'plugin-install.php?s=secure+custom+fields&tab=search&type=term' );
	echo '<div class="notice notice-warning"><p><strong>' . esc_html__( 'AYED Ghana theme:', 'ayed-ghana' ) . '</strong> ';
	printf(
		/* translators: %s: plugin install link */
		wp_kses_post( __( 'Please install and activate the free <a href="%s">Secure Custom Fields</a> plugin to manage your site content. The site will still display with its default content until then.', 'ayed-ghana' ) ),
		esc_url( $search )
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'ayed_scf_admin_notice' );

/**
 * Register the global options page.
 */
function ayed_register_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => __( 'AYED Site Settings', 'ayed-ghana' ),
		'menu_title' => __( 'Site Settings', 'ayed-ghana' ),
		'menu_slug'  => 'ayed-settings',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-admin-site-alt3',
		'position'   => 3,
		'redirect'   => false,
	) );
}
add_action( 'acf/init', 'ayed_register_options_page' );

/**
 * Register all field groups.
 */
function ayed_register_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$icon_choices = ayed_icon_choices();

	/* ---------------------------------------------------------------------
	 * 1. Global Site Settings (options page).
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_settings',
		'title'    => __( 'AYED Site Settings', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'options_page', 'operator' => '==', 'value' => 'ayed-settings' ),
			),
		),
		'menu_order' => 0,
		'fields'   => array(
			array( 'key' => 'tab_general', 'label' => __( 'General', 'ayed-ghana' ), 'type' => 'tab' ),
			array( 'key' => 'field_org_tagline', 'label' => __( 'Organisation Tagline', 'ayed-ghana' ), 'name' => 'org_tagline', 'type' => 'text', 'default_value' => 'African Youth Empowerment and Development', 'wrapper' => array( 'width' => 60 ) ),
			array( 'key' => 'field_founded_year', 'label' => __( 'Year Founded', 'ayed-ghana' ), 'name' => 'founded_year', 'type' => 'text', 'default_value' => '2017', 'wrapper' => array( 'width' => 40 ) ),
			array( 'key' => 'field_show_site_title', 'label' => __( 'Show site name beside logo', 'ayed-ghana' ), 'name' => 'show_site_title', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1, 'instructions' => __( 'When a logo is uploaded, show the "AYED Ghana" wordmark next to it. Turn off to show the logo alone.', 'ayed-ghana' ) ),

			array( 'key' => 'tab_contact', 'label' => __( 'Contact', 'ayed-ghana' ), 'type' => 'tab' ),
			array( 'key' => 'field_contact_email', 'label' => __( 'Email Address', 'ayed-ghana' ), 'name' => 'contact_email', 'type' => 'email', 'default_value' => 'info@ayedghana.org', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_contact_phone', 'label' => __( 'Phone Number', 'ayed-ghana' ), 'name' => 'contact_phone', 'type' => 'text', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_contact_address', 'label' => __( 'Address', 'ayed-ghana' ), 'name' => 'contact_address', 'type' => 'text', 'default_value' => 'C170/5, Adenkum Road, Accra, Ghana', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_contact_website', 'label' => __( 'Display Website', 'ayed-ghana' ), 'name' => 'contact_website', 'type' => 'text', 'default_value' => 'ayedghana.org', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_contact_recipient', 'label' => __( 'Form Recipient Email', 'ayed-ghana' ), 'name' => 'contact_recipient', 'type' => 'email', 'instructions' => __( 'Where contact form submissions are delivered. Defaults to the site admin email if blank.', 'ayed-ghana' ) ),

			array( 'key' => 'tab_applications', 'label' => __( 'Applications', 'ayed-ghana' ), 'type' => 'tab' ),
			array( 'key' => 'field_applications_recipient', 'label' => __( 'Applications Recipient Email', 'ayed-ghana' ), 'name' => 'applications_recipient', 'type' => 'email', 'instructions' => __( 'Where programme application submissions are delivered. Defaults to the contact recipient if blank. Turn applications on or off per programme under each Program.', 'ayed-ghana' ) ),

			array( 'key' => 'tab_social', 'label' => __( 'Social', 'ayed-ghana' ), 'type' => 'tab' ),
			array( 'key' => 'field_social_links', 'label' => __( 'Social Links', 'ayed-ghana' ), 'name' => 'social_links', 'type' => 'repeater', 'layout' => 'table', 'button_label' => __( 'Add Social Link', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_social_network', 'label' => __( 'Network', 'ayed-ghana' ), 'name' => 'network', 'type' => 'select', 'choices' => array(
					'facebook' => 'Facebook', 'instagram' => 'Instagram', 'twitter' => 'X / Twitter', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube',
				) ),
				array( 'key' => 'field_social_url', 'label' => __( 'URL', 'ayed-ghana' ), 'name' => 'url', 'type' => 'url' ),
			) ),

			array( 'key' => 'tab_footer', 'label' => __( 'Footer', 'ayed-ghana' ), 'type' => 'tab' ),
			array( 'key' => 'field_footer_blurb', 'label' => __( 'Footer Blurb', 'ayed-ghana' ), 'name' => 'footer_blurb', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'A non-governmental organisation dedicated to empowering the youth of Ghana and Africa through training, mentoring, and opportunity.' ),
			array( 'key' => 'field_footer_cta_label', 'label' => __( 'Footer CTA Label', 'ayed-ghana' ), 'name' => 'footer_cta_label', 'type' => 'text', 'default_value' => 'Get Involved', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_footer_cta_url', 'label' => __( 'Footer CTA Link', 'ayed-ghana' ), 'name' => 'footer_cta_url', 'type' => 'text', 'default_value' => '#involved', 'wrapper' => array( 'width' => 50 ) ),
		),
	) );

	/* ---------------------------------------------------------------------
	 * 2. Front Page sections.
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_front',
		'title'    => __( 'Front Page Content', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ),
			),
		),
		'menu_order'      => 0,
		'position'        => 'normal',
		'style'           => 'default',
		'hide_on_screen'  => array( 'the_content' ),
		'fields'   => array(

			/* Hero */
			array( 'key' => 'tab_hero', 'label' => __( 'Hero', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_hero_badge', 'label' => __( 'Badge Text', 'ayed-ghana' ), 'name' => 'hero_badge', 'type' => 'text', 'default_value' => 'Established in Ghana. Empowering Africa\'s Youth.' ),
			array( 'key' => 'field_hero_title', 'label' => __( 'Headline', 'ayed-ghana' ), 'name' => 'hero_title', 'type' => 'text', 'default_value' => 'Empowering the Next Generation of Africa', 'instructions' => __( 'Wrap one or two words in [em]...[/em] to highlight them in orange.', 'ayed-ghana' ) ),
			array( 'key' => 'field_hero_sub', 'label' => __( 'Subheadline', 'ayed-ghana' ), 'name' => 'hero_sub', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'A platform where young people connect, grow and succeed, in business, industry, and beyond.' ),
			array( 'key' => 'field_hero_primary_label', 'label' => __( 'Primary Button Label', 'ayed-ghana' ), 'name' => 'hero_primary_label', 'type' => 'text', 'default_value' => 'Our Programs', 'wrapper' => array( 'width' => 25 ) ),
			array( 'key' => 'field_hero_primary_url', 'label' => __( 'Primary Button Link', 'ayed-ghana' ), 'name' => 'hero_primary_url', 'type' => 'text', 'default_value' => '#programs', 'wrapper' => array( 'width' => 25 ) ),
			array( 'key' => 'field_hero_secondary_label', 'label' => __( 'Secondary Button Label', 'ayed-ghana' ), 'name' => 'hero_secondary_label', 'type' => 'text', 'default_value' => 'Get Involved', 'wrapper' => array( 'width' => 25 ) ),
			array( 'key' => 'field_hero_secondary_url', 'label' => __( 'Secondary Button Link', 'ayed-ghana' ), 'name' => 'hero_secondary_url', 'type' => 'text', 'default_value' => '#involved', 'wrapper' => array( 'width' => 25 ) ),
			array( 'key' => 'field_hero_image', 'label' => __( 'Background Image (optional)', 'ayed-ghana' ), 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),

			/* About */
			array( 'key' => 'tab_about', 'label' => __( 'About', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_about_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'about_tag', 'type' => 'text', 'default_value' => 'Who We Are', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_about_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'about_title', 'type' => 'text', 'default_value' => 'African Youth Empowerment and [em]Development[/em] Ghana', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_about_body', 'label' => __( 'Body', 'ayed-ghana' ), 'name' => 'about_body', 'type' => 'wysiwyg', 'media_upload' => 0, 'default_value' => '<p><strong>AYED Ghana</strong> is a non-governmental organisation dedicated to empowering the youth of Ghana and Africa. We are builders of human potential, giving young people the tools, networks, and opportunities they need to shape their own futures.</p><p>We recognise that young people learn best through active participation. Whether in classrooms, communities, or boardrooms, we create the conditions for growth, providing every young person the chance to feel competent, useful, and empowered.</p>' ),
			array( 'key' => 'field_about_image', 'label' => __( 'About Image', 'ayed-ghana' ), 'name' => 'about_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => __( 'If left empty, the brand emblem is shown.', 'ayed-ghana' ) ),
			array( 'key' => 'field_about_stats', 'label' => __( 'Stats', 'ayed-ghana' ), 'name' => 'about_stats', 'type' => 'repeater', 'layout' => 'table', 'max' => 4, 'button_label' => __( 'Add Stat', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_stat_num', 'label' => __( 'Number', 'ayed-ghana' ), 'name' => 'number', 'type' => 'text' ),
				array( 'key' => 'field_stat_label', 'label' => __( 'Label', 'ayed-ghana' ), 'name' => 'label', 'type' => 'text' ),
			) ),

			/* Programs */
			array( 'key' => 'tab_programs', 'label' => __( 'Programs', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_programs_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'programs_tag', 'type' => 'text', 'default_value' => 'Featured Initiatives', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_programs_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'programs_title', 'type' => 'text', 'default_value' => 'Programs Shaping [em]Ghana\'s Future[/em]', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_programs_source', 'label' => __( 'Featured Programs', 'ayed-ghana' ), 'name' => 'featured_programs', 'type' => 'relationship', 'post_type' => array( 'program' ), 'filters' => array( 'search' ), 'max' => 6, 'return_format' => 'id', 'instructions' => __( 'Select up to six programs. If empty, the most recent programs are shown.', 'ayed-ghana' ) ),

			/* Get Involved */
			array( 'key' => 'tab_involved', 'label' => __( 'Get Involved', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_involved_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'involved_tag', 'type' => 'text', 'default_value' => 'Join Us', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_involved_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'involved_title', 'type' => 'text', 'default_value' => 'Be Part of the [em]Movement[/em]', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_involved_cards', 'label' => __( 'Cards', 'ayed-ghana' ), 'name' => 'involved_cards', 'type' => 'repeater', 'layout' => 'block', 'button_label' => __( 'Add Card', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_iv_icon', 'label' => __( 'Icon', 'ayed-ghana' ), 'name' => 'icon', 'type' => 'select', 'choices' => $icon_choices, 'wrapper' => array( 'width' => 25 ) ),
				array( 'key' => 'field_iv_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'title', 'type' => 'text', 'wrapper' => array( 'width' => 40 ) ),
				array( 'key' => 'field_iv_link_label', 'label' => __( 'Link Label', 'ayed-ghana' ), 'name' => 'link_label', 'type' => 'text', 'wrapper' => array( 'width' => 35 ) ),
				array( 'key' => 'field_iv_interest', 'label' => __( 'Preselect Interest', 'ayed-ghana' ), 'name' => 'interest', 'type' => 'select', 'allow_null' => 1, 'choices' => ayed_contact_interests(), 'instructions' => __( 'Links the card to the contact form with this interest preselected.', 'ayed-ghana' ), 'wrapper' => array( 'width' => 50 ) ),
				array( 'key' => 'field_iv_link_url', 'label' => __( 'Custom Link URL (optional)', 'ayed-ghana' ), 'name' => 'link_url', 'type' => 'text', 'instructions' => __( 'Overrides the contact link, for example an external donation page.', 'ayed-ghana' ), 'wrapper' => array( 'width' => 50 ) ),
				array( 'key' => 'field_iv_text', 'label' => __( 'Text', 'ayed-ghana' ), 'name' => 'text', 'type' => 'textarea', 'rows' => 3 ),
			) ),
		),
	) );

	/* ---------------------------------------------------------------------
	 * 2b. About Page sections (moved off the homepage).
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_about',
		'title'    => __( 'About Page Content', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-about.php' ),
			),
		),
		'menu_order'     => 1,
		'position'       => 'normal',
		'style'          => 'default',
		'hide_on_screen' => array(),
		'fields'   => array(

			/* Mission / Vision / Values */
			array( 'key' => 'tab_mission', 'label' => __( 'Mission', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_mission_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'mission_tag', 'type' => 'text', 'default_value' => 'Our Foundation', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_mission_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'mission_title', 'type' => 'text', 'default_value' => 'Guided by [em]Purpose[/em], Driven by People', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_mission_cards', 'label' => __( 'Cards', 'ayed-ghana' ), 'name' => 'mission_cards', 'type' => 'repeater', 'layout' => 'block', 'button_label' => __( 'Add Card', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_mc_icon', 'label' => __( 'Icon', 'ayed-ghana' ), 'name' => 'icon', 'type' => 'select', 'choices' => $icon_choices, 'wrapper' => array( 'width' => 30 ) ),
				array( 'key' => 'field_mc_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'title', 'type' => 'text', 'wrapper' => array( 'width' => 70 ) ),
				array( 'key' => 'field_mc_text', 'label' => __( 'Text', 'ayed-ghana' ), 'name' => 'text', 'type' => 'textarea', 'rows' => 3 ),
			) ),
			array( 'key' => 'field_mission_quote', 'label' => __( 'Feature Quote', 'ayed-ghana' ), 'name' => 'mission_quote', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Young people learn best through active participation. Learning can occur in any environment or scenario. Our role is to create the conditions for it.', 'wrapper' => array( 'width' => 70 ) ),
			array( 'key' => 'field_mission_quote_attr', 'label' => __( 'Quote Attribution', 'ayed-ghana' ), 'name' => 'mission_quote_attr', 'type' => 'text', 'default_value' => 'AYED Ghana', 'wrapper' => array( 'width' => 30 ) ),

			/* Pillars */
			array( 'key' => 'tab_pillars', 'label' => __( 'Pillars', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_pillars_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'pillars_tag', 'type' => 'text', 'default_value' => 'Areas of Impact', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_pillars_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'pillars_title', 'type' => 'text', 'default_value' => 'Five Pillars of [em]Youth Development[/em]', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_pillars_intro', 'label' => __( 'Intro', 'ayed-ghana' ), 'name' => 'pillars_intro', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Our comprehensive service model addresses the full spectrum of a young person\'s development, from individual skills to global citizenship, ensuring no opportunity is out of reach.' ),
			array( 'key' => 'field_pillars', 'label' => __( 'Pillars', 'ayed-ghana' ), 'name' => 'pillars', 'type' => 'repeater', 'layout' => 'block', 'button_label' => __( 'Add Pillar', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_pl_icon', 'label' => __( 'Icon', 'ayed-ghana' ), 'name' => 'icon', 'type' => 'select', 'choices' => $icon_choices, 'wrapper' => array( 'width' => 30 ) ),
				array( 'key' => 'field_pl_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'title', 'type' => 'text', 'wrapper' => array( 'width' => 70 ) ),
				array( 'key' => 'field_pl_text', 'label' => __( 'Text', 'ayed-ghana' ), 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
			) ),

			/* Approach */
			array( 'key' => 'tab_approach', 'label' => __( 'Approach', 'ayed-ghana' ), 'type' => 'tab', 'placement' => 'left' ),
			array( 'key' => 'field_approach_tag', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'approach_tag', 'type' => 'text', 'default_value' => 'How We Work', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_approach_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'approach_title', 'type' => 'text', 'default_value' => 'Our Four-Point [em]Programme Framework[/em]', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_approach_items', 'label' => __( 'Steps', 'ayed-ghana' ), 'name' => 'approach_items', 'type' => 'repeater', 'layout' => 'block', 'button_label' => __( 'Add Step', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_ap_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'title', 'type' => 'text', 'wrapper' => array( 'width' => 40 ) ),
				array( 'key' => 'field_ap_text', 'label' => __( 'Text', 'ayed-ghana' ), 'name' => 'text', 'type' => 'textarea', 'rows' => 2, 'wrapper' => array( 'width' => 60 ) ),
			) ),
		),
	) );

	/* ---------------------------------------------------------------------
	 * 3. Program post details.
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_program',
		'title'    => __( 'Program Details', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'program' ),
			),
		),
		'fields'   => array(
			array( 'key' => 'field_prog_label', 'label' => __( 'Label / Category', 'ayed-ghana' ), 'name' => 'program_label', 'type' => 'text', 'instructions' => __( 'Short eyebrow shown above the title, for example "Environment and Heritage".', 'ayed-ghana' ), 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_prog_icon', 'label' => __( 'Icon', 'ayed-ghana' ), 'name' => 'program_icon', 'type' => 'select', 'choices' => $icon_choices, 'default_value' => 'star', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_prog_summary', 'label' => __( 'Card Summary', 'ayed-ghana' ), 'name' => 'program_summary', 'type' => 'textarea', 'rows' => 3, 'instructions' => __( 'Short text shown on the program card. Falls back to the excerpt if empty.', 'ayed-ghana' ) ),
			array( 'key' => 'field_prog_color', 'label' => __( 'Card Accent', 'ayed-ghana' ), 'name' => 'program_color', 'type' => 'select', 'choices' => array(
				'navy'   => __( 'Navy', 'ayed-ghana' ),
				'orange' => __( 'Orange', 'ayed-ghana' ),
				'teal'   => __( 'Teal', 'ayed-ghana' ),
			), 'default_value' => 'navy', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_prog_external', 'label' => __( 'External Link (optional)', 'ayed-ghana' ), 'name' => 'program_external', 'type' => 'url', 'wrapper' => array( 'width' => 50 ) ),

			array( 'key' => 'field_prog_apply_msg', 'label' => __( 'Applications', 'ayed-ghana' ), 'type' => 'message', 'message' => __( 'When "Accepting Applications" is on, this program shows a contextual "Apply Now" button that opens the application form with this program preselected. When off, the program page shows an "Applications Closed" state instead.', 'ayed-ghana' ) ),
			array( 'key' => 'field_prog_apply_enabled', 'label' => __( 'Accepting Applications', 'ayed-ghana' ), 'name' => 'accepting_applications', 'type' => 'true_false', 'ui' => 1, 'default_value' => 0, 'instructions' => __( 'Turn on while this program is open to applicants.', 'ayed-ghana' ) ),
			array( 'key' => 'field_prog_apply_label', 'label' => __( 'Apply Button Label', 'ayed-ghana' ), 'name' => 'apply_label', 'type' => 'text', 'default_value' => 'Apply Now', 'conditional_logic' => array( array( array( 'field' => 'field_prog_apply_enabled', 'operator' => '==', 'value' => '1' ) ) ), 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_prog_apply_url', 'label' => __( 'Apply Link Override (optional)', 'ayed-ghana' ), 'name' => 'apply_url', 'type' => 'url', 'instructions' => __( 'Leave blank to use the on-site Apply page with this program preselected.', 'ayed-ghana' ), 'conditional_logic' => array( array( array( 'field' => 'field_prog_apply_enabled', 'operator' => '==', 'value' => '1' ) ) ), 'wrapper' => array( 'width' => 50 ) ),
		),
	) );

	/* ---------------------------------------------------------------------
	 * 4. Event details (photos, videos, related programs).
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_event',
		'title'    => __( 'Event Details', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'event' ),
			),
		),
		'fields'   => array(
			array( 'key' => 'field_event_date', 'label' => __( 'Event Date', 'ayed-ghana' ), 'name' => 'event_date', 'type' => 'date_picker', 'required' => 1, 'display_format' => 'j F Y', 'return_format' => 'Ymd', 'first_day' => 1, 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_event_location', 'label' => __( 'Location', 'ayed-ghana' ), 'name' => 'event_location', 'type' => 'text', 'placeholder' => 'Accra, Ghana', 'wrapper' => array( 'width' => 50 ) ),
			array( 'key' => 'field_event_programs', 'label' => __( 'Related Programs', 'ayed-ghana' ), 'name' => 'related_programs', 'type' => 'relationship', 'post_type' => array( 'program' ), 'filters' => array( 'search' ), 'return_format' => 'id', 'instructions' => __( 'Link this event to one or more programs. Linked events appear on the program page.', 'ayed-ghana' ) ),
			array( 'key' => 'field_event_gallery', 'label' => __( 'Photo Gallery', 'ayed-ghana' ), 'name' => 'event_gallery', 'type' => 'repeater', 'layout' => 'table', 'button_label' => __( 'Add Photo', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_event_photo', 'label' => __( 'Image', 'ayed-ghana' ), 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail' ),
				array( 'key' => 'field_event_photo_caption', 'label' => __( 'Caption', 'ayed-ghana' ), 'name' => 'caption', 'type' => 'text' ),
			) ),
			array( 'key' => 'field_event_videos', 'label' => __( 'Videos', 'ayed-ghana' ), 'name' => 'event_videos', 'type' => 'repeater', 'layout' => 'table', 'button_label' => __( 'Add Video', 'ayed-ghana' ), 'instructions' => __( 'Paste a YouTube or Vimeo URL. It will be embedded responsively.', 'ayed-ghana' ), 'sub_fields' => array(
				array( 'key' => 'field_event_video_url', 'label' => __( 'Video URL', 'ayed-ghana' ), 'name' => 'url', 'type' => 'url' ),
				array( 'key' => 'field_event_video_title', 'label' => __( 'Title', 'ayed-ghana' ), 'name' => 'title', 'type' => 'text' ),
			) ),
		),
	) );

	/* ---------------------------------------------------------------------
	 * 5. Page subtitle (for interior pages).
	 * ------------------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_ayed_page',
		'title'    => __( 'Page Header', 'ayed-ghana' ),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ),
			),
		),
		'fields'   => array(
			array( 'key' => 'field_page_subtitle', 'label' => __( 'Subtitle', 'ayed-ghana' ), 'name' => 'page_subtitle', 'type' => 'text', 'instructions' => __( 'Optional short line shown beneath the page title.', 'ayed-ghana' ) ),
			array( 'key' => 'field_page_eyebrow', 'label' => __( 'Eyebrow', 'ayed-ghana' ), 'name' => 'page_eyebrow', 'type' => 'text' ),
		),
	) );
}
add_action( 'acf/init', 'ayed_register_field_groups' );
