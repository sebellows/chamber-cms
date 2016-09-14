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
                'name'     => 'project',
                'singular' => 'Project',
                'plural'   => 'Projects',
                'slug'     => 'projects'
            ],
            [
                'supports'     => array( 'title', 'editor', 'thumbnail' ),
                'show_in_menu' => FALSE,
            ]
        );
    } 
}
