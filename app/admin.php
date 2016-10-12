<?php

namespace Chamber\Plugin;

add_action( 'admin_menu', __NAMESPACE__.'\\chamber_add_options_sub_page' );

function chamber_add_options_sub_page($parent_file) {

	/**
	 * Custom Post Types
	 *
	 * @var array
	 */
	$chamber_custom_posttypes = [
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
	$chamber_taxonomies = [
		'attraction_category',
		'business_type',
		'department'
	];

	foreach( $chamber_custom_posttypes as $chamber_custom_posttype ) {
		$key = array_search($chamber_custom_posttype, $chamber_custom_posttypes);
		$chamber_custom_posttype_title = $chamber_custom_posttype == 'faq' ? Helper::all_caps($chamber_custom_posttype) : Helper::humanize(Helper::pluralize($chamber_custom_posttype));

		add_submenu_page( 'chamber-index', $chamber_custom_posttype_title, $chamber_custom_posttype_title, 'manage_options', 'edit.php?post_type=' . $chamber_custom_posttype, null, $key++);
	}

	foreach( $chamber_taxonomies as $chamber_taxonomy ) {
		$key = array_search($chamber_taxonomy, $chamber_taxonomies);

		$chamber_submenu_page_title = Helper::humanize(Helper::pluralize($chamber_taxonomy));

		add_submenu_page( 'chamber-index', $chamber_submenu_page_title, $chamber_submenu_page_title, 'manage_options', 'edit-tags.php?taxonomy=' . $chamber_taxonomy, null, $key++);
	}

	// highlight the proper top level menu
	add_action( 'admin_menu','chamber_tax_menu_highlight' );

	function chamber_tax_menu_highlight($parent_file) {
		global $current_screen;
		$taxonomy = $current_screen->taxonomy;

		foreach( $chamber_taxonomies as $chamber_taxonomy ) {
			if( $taxonomy == $chamber_taxonomy ) {
				$parent_file = 'chamber-index';
			}
		}

		return $parent_file;
	}
}


if ( function_exists( 'chamber_remove_custom_posttype_meta' ) ) {

	if ( !current_user_can( 'activate_plugins' ) ) {

		function chamber_remove_custom_posttype_meta() {
			$chamber_removable_taxonomies = ['attraction_category'];
			foreach( $chamber_removable_taxonomies as $chamber_removable_taxonomy ) {

				$post_types = get_post_types();

				foreach( $post_types as $post_type ) { remove_meta_box( $chamber_removable_taxonomy . 'div', $post_type, 'side' );
				}
			}
		}
		add_action( 'admin_head' , 'chamber_remove_custom_posttype_meta' );
	}
}
