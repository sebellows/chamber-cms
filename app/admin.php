<?php

namespace Chamber\Plugin;

/**
 * Custom Post Types
 *
 * @var array
 */
const CHAMBER_PLUGIN_POST_TYPES = [
	'attraction',
	'business',
	'community',
	'person',
	'project',
	'testimonial'
];

/**
 * Custom Taxonomies
 *
 * @var array
 */
const CHAMBER_PLUGIN_TAXONOMIES = [
	'attraction_category',
	'business_type',
	'department'
];

const CHAMBER_PLUGIN_INDEX = 'chamber-index';

add_action( 'admin_menu', __NAMESPACE__.'\\add_options_sub_page' );

function add_options_sub_page($parent_file) {

	foreach( CHAMBER_PLUGIN_POST_TYPES as $chamber_custom_posttype ) {
		$key = array_search($chamber_custom_posttype, CHAMBER_PLUGIN_POST_TYPES);
		$chamber_custom_posttype_title = $chamber_custom_posttype == 'faq' ? Helper::all_caps($chamber_custom_posttype) : Helper::humanize(Helper::pluralize($chamber_custom_posttype));

		add_submenu_page( CHAMBER_PLUGIN_INDEX, $chamber_custom_posttype_title, $chamber_custom_posttype_title, 'manage_options', 'edit.php?post_type=' . $chamber_custom_posttype, null, $key++);
	}

	foreach( CHAMBER_PLUGIN_TAXONOMIES as $chamber_taxonomy ) {
		$key = array_search($chamber_taxonomy, CHAMBER_PLUGIN_TAXONOMIES);

		$chamber_submenu_page_title = Helper::humanize(Helper::pluralize($chamber_taxonomy));

		add_submenu_page( CHAMBER_PLUGIN_INDEX, $chamber_submenu_page_title, $chamber_submenu_page_title, 'manage_options', 'edit-tags.php?taxonomy=' . $chamber_taxonomy, null, $key++);
	}

	// highlight the proper top level menu
	add_action( 'admin_menu', __NAMESPACE__.'\\tax_menu_highlight' );

	function tax_menu_highlight($parent_file) {
		global $current_screen;
		$taxonomy = $current_screen->taxonomy;

		foreach( CHAMBER_PLUGIN_TAXONOMIES as $chamber_taxonomy ) {
			if( $taxonomy == $chamber_taxonomy ) {
				$parent_file = CHAMBER_PLUGIN_INDEX;
			}
		}

		return $parent_file;
	}
}

add_filter('acf/update_value/name=people_first_name', __NAMESPACE__.'\\filter_people_title', 10, 3);
add_filter('acf/update_value/name=people_last_name',  __NAMESPACE__.'\\filter_people_title', 10, 3);

/**
 * Generate a title for the Person post type using the first and last name fields.
 *
 * @source  http://www.jennybeaumont.com/auto-create-post-title-acf-data/
 * 
 * @param  string $person_title   the new title composed of the person's name
 * @param  integer $post_id       the Person post ID
 * 
 * @return string                 the new title
 */
function filter_people_title( $person_title, $post_id, $field )
{
    $firstName = get_field('people_first_name');
    $lastName  = get_field('people_last_name');

    $title = $firstName . ' ' . $lastName;

    $slug = sanitize_title( $firstName . '-' . $lastName );

    $postdata = [
        'ID' => $post_id,
        'post_title' => $title,
        'post_type' => 'person',
        'post_name' => $slug
    ];

    wp_update_post( $postdata );

    return $person_title;
}
