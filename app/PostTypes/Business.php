<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Businesses
 * 
 * @var \PostTypes\PostType
 */
class Business
{
    public function __construct()
    {
        $business = new PostType(
            [
                'name'     => 'business',
                'singular' => 'Business',
                'plural'   => 'Businesses',
                'slug'     => 'businesses'
            ],
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => [ 'business_type', 'post_tag', 'category' ],
                'rewrite'      => [ 'with_front' => FALSE ],
                'has_archive'  => TRUE
            ]
        );

        $business->taxonomy(
            'business_type',
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

        $business->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title'),
            'business_type' => __('Business Type')
        ]);
    } 
}
