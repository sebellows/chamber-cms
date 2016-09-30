<?php

namespace Chamber\PostTypes;

use PostTypes\PostType;

/**
 * Testimonials
 * 
 * @var PostTypes\PostType
 */
class Testimonial
{
    public function __construct()
    {
        $testimonials = new PostType(
            [
                'name'     => 'Testimonials',
                'singular' => 'Testimonial',
                'plural'   => 'Testimonials',
                'slug'     => 'testimonials'
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

        $testimonials->columns()->set([
            'cb'         => '<input type="checkbox" />',
            'title'      => __('Title')
        ]);
    } 
}
