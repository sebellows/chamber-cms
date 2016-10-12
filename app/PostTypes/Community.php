<?php

namespace Chamber\Plugin\PostTypes;

use PostTypes\PostType;

/**
 * Communities
 * 
 * @var \PostTypes\PostType
 */
class Community
{
    public function __construct()
    {
        $community = new PostType(
            [
                'name'     => 'community',
                'singular' => 'Community',
                'plural'   => 'Communities',
                'slug'     => 'communities'
            ],
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => [ 'post_tag', 'category' ],
                'rewrite'      => [ 'with_front' => FALSE ],
                'has_archive'  => 'communities'
            ]
        );

        $community->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title')
        ]);
    } 
}
