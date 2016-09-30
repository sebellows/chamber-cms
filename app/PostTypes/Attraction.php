<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Attraction
 * 
 * @var CPT
 */
class Attraction
{
    public function __construct()
    {
        $attraction = new PostType(
            'attraction',
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => ['attraction_category'],
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ],
                'has_archive'  => TRUE
            ]
        );

        $attraction->taxonomy(
            [
                'name'     => 'attraction_category',
                'singular' => 'Attraction Category',
                'plural'   => 'Attraction Categories',
                'slug'     => 'attraction-categories'
            ],
            [
                'show_ui'           => TRUE,
                'show_admin_column' => TRUE,
                'capabilities' => [
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'manage_categories'
                ],
                'query_var'    => TRUE,
                'hierarchical' => TRUE
            ]
        );

        $attraction->columns()->set([
            'cb'                  => '<input type="checkbox" />',
            'title'               => __('Title'),
            'attraction_category' => __('Attraction Category')
        ]);
    } 
}
