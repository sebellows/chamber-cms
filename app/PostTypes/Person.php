<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * People
 * 
 * @var \PostTypes\PostType
 */
class Person
{
    public function __construct()
    {
        $person = new PostType(
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

        $person->taxonomy(
            'department',
            [
                'show_ui'           => TRUE,
                'show_admin_column' => TRUE,
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

        $person->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title'),
            'department' => __('Department')
        ]);
    } 
}
