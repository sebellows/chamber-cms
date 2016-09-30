<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * People
 * 
 * @var PostTypes\PostType
 */
class Person
{
    public function __construct()
    {
        $people = new PostType(
            [
                'name'     => 'People',
                'singular' => 'Person',
                'plural'   => 'People',
                'slug'     => 'people'
            ],
            [
                'supports'     => [ 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => ['department'],
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ]
            ]
        );

        $people->taxonomy(
            'department',
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

        $people->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title'),
            'department' => __('Department')
        ]);
    } 
}