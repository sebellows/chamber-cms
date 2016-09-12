<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * People
 * 
 * @var PostTypes\PostType
 */
class PersonPostType
{
    public function __construct()
    {
        $people = new PostType(
            [
                'name'     => 'people',
                'singular' => 'Person',
                'plural'   => 'People',
                'slug'     => 'people'
            ],
            [
                'supports'     => [ 'title', 'editor', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => true,
                'taxonomies'   => ['department'],
                'rewrite'      => ['slug' => 'people', 'with_front' => FALSE]

            ]
        );

        $people->taxonomy(
            'department',
            [
                'show_ui'      => false,
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
