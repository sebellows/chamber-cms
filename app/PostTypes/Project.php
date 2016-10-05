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
            'project',
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'rewrite'      => [ 'with_front' => FALSE ],
                'has_archive'  => 'projects'
            ]
        );

        $project->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title')
        ]);
    } 
}
