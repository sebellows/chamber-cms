<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Communities
 * 
 * @var PostTypes\PostType
 */
class Community
{
    public function __construct()
    {
        $communities = new PostType(
            [
                'name'     => 'Communities',
                'singular' => 'Community',
                'plural'   => 'Communities',
                'slug'     => 'communities'
            ],
            [
                'supports'     => [ 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                // 'taxonomies'   => ['community_type'],
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ]
            ]
        );

        // $communities->taxonomy(
        //     'community_type',
        //     [
        //         'show_ui'      => FALSE,
        //         'capabilities' => [
        //             'manage_terms' => 'manage_custom_taxonomies',
        //             'edit_terms'   => 'manage_custom_taxonomies',
        //             'delete_terms' => 'manage_custom_taxonomies',
        //             'assign_terms' => 'manage_custom_taxonomies',
        //         ]
        //     ]
        // );

        // $communities->columns()->set([
        //     'cb'         => '<input type="checkbox" />',
        //     'title'      => __('Title'),
        //     'community' => __('Community Type')
        // ]);
    } 
}
