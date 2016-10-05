<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Attraction
 * 
 * @var \PostTypes\PostType
 */
class Project
{
    public function __construct()
    {
        $project = new PostType(
            [
                'name'     => 'Projects',
                'singular' => 'Project',
                'plural'   => 'Projects',
                'slug'     => 'projects'
            ],
            [
                'supports'     => [
                    'title',
                    'editor',
                    'thumbnail'
                ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'rewrite'      => [
                    'with_front' => FALSE,
                    'pages'      => TRUE,
                    'feeds'      => TRUE,
                    'ep_mask'    => EP_PERMALINK
                ]
            ]
        );
    } 
}
