<?php

namespace Chamber\Plugin\PostTypes;

use PostTypes\PostType;

/**
 * Testimonials
 * 
 * @var \PostTypes\PostType
 */
class Testimonial
{
    public function __construct()
    {
        $testimonial = new PostType(
            'testimonial',
            [
                'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'show_in_menu' => FALSE,
                'show_in_rest' => TRUE,
                'taxonomies'   => [ 'post_tag', 'category' ],
                'rewrite'      => [ 'with_front' => FALSE ],
                'has_archive'  => 'testimonials'
            ]
        );

        $testimonial->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title')
        ]);
    }
}
