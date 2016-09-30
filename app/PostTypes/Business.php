<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Businesses
 * 
 * @var PostTypes\PostType
 */
class Business
{
    public function __construct()
    {
        $businesses = new PostType(
            [
                'name'     => 'Businesses',
                'singular' => 'Business',
                'plural'   => 'Businesses',
                'slug'     => 'businesses'
            ],
            [
                'supports'     => [ 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => ['business_type'],
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ]
            ]
        );

        $businesses->taxonomy(
            'business_type',
            [
                'show_ui'      => FALSE,
                'capabilities' => [
                    'manage_terms' => 'manage_custom_taxonomies',
                    'edit_terms'   => 'manage_custom_taxonomies',
                    'delete_terms' => 'manage_custom_taxonomies',
                    'assign_terms' => 'manage_custom_taxonomies',
                ]
            ]
        );

        $businesses->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title'),
            'business_type' => __('Business Type')
        ]);
    } 
}
