<?php

namespace Chamber\PostTypes;

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
                'name'     => 'Communities',
                'singular' => 'Community',
                'plural'   => 'Communities',
                'slug'     => 'communities'
            ],
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ],
                'has_archive'  => TRUE
            ]
        );
    } 
}
