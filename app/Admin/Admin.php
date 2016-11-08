<?php

namespace Chamber\Plugin\Admin;

use Chamber\Plugin\PostTypes\Person;

/**
 * Admin Menus and Metaboxes
 */
class Admin
{

	/**
	 * Custom Post Types
	 *
	 * @var array
	 */
	protected $customPosttypes = [];

	/**
	 * Custom Taxonomies
	 *
	 * @var array
	 */
	protected $taxonomies = [];

	/**
	 * Meta boxes on edit.php/post.php screens. When using ACF, 
	 * meta boxes wind up being duplicated. This gets rid of 
	 * the WP-generated default.
	 * 
	 * @var array
	 */
	protected $metaboxes = [];

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		add_action( 'admin_menu', [$this, 'addSubPage'] );
		add_action( 'admin_menu', [$this, 'menuHighlight'] );
		add_action( 'admin_head', [$this, 'removeMetaBoxes'] );
	}

	/**
	 * Set the sub-menu page for our taxonomies.
	 *
	 * @return void
	 */
	public function setPostTypeSubMenuPage(array $customPosttypes = [])
	{
		foreach( $customPosttypes as $customPosttype ) {

			$key = array_search($customPosttype, $customPosttypes);

			add_submenu_page(
				plugin_name().'-index', 
				$customPosttypeTitle, 
				$customPosttypeTitle, 
				'manage_options', 
				'edit.php?post_type=' . $customPosttype, null, 
				$key++
			);
		}
	}

	/**
	 * Set the sub-menu page for our taxonomies.
	 *
	 * @return void
	 */
	public function setTaxonomySubMenuPage(array $taxonomies = [])
	{
		foreach( $taxonomies as $taxonomy ) {

			$submenuPageTitle = Helper::humanize($taxonomy);

			add_submenu_page(
				plugin_name().'-index', 
				$submenuPageTitle, 
				$submenuPageTitle, 
				'manage_options', 
				'edit-tags.php?taxonomy=' . $taxonomy, null, 
				$key++
			);
		}

		$this->menuHighlight();
	}


	/**
	 * Highlight the proper top level menu
	 * 
	 * @param  string $parent_file Our plugin`s admin index url.
	 * @return string
	 */
	protected function menuHighlight()
	{
		global $current_screen;

		$parentPage = null

		$currentTaxonomy = $current_screen->taxonomy;

		collect($taxonomies)->each(function ($taxonomy, $currentTaxonomy) {
			$parentPage = plugin_name().'-index';
		});

		return $parentPage;
	}

	/**
	 * Remove meta boxes to prevent duplicates when using ACF
	 * to generate fields.
	 * 
	 * @return void
	 */
	public function removeMetaBoxes(array $removables = [])
	{
		collect($metaboxes)->each(function ($metabox) {
			collect(get_post_types())->each(function ($existingPostType) {
				remove_meta_box( $metabox . 'div', $existingPostType, 'side' );
			});
		});
	}
}