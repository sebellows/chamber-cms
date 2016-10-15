<?php

namespace Chamber\Plugin;

/** @var \Oni\Providers\TwigServiceProvider $twig */

/*
 * Adding Wordpress functions as Twig extensions
 */

// Might eventually need these ones added:
//
// 'esc_html',
// 'esc_attr',
// 'esc_attr_e',
// 'esc_textarea',
// 'esc_url',
// 'esc_js',

oni()->extend('twig.functions', function ($functions) {
    return array_merge($functions, [
    'add_list_separators',
    'apply_filters',
    'checked',
    'function_exists',
    'print_r',
    'sanitize_title',
    'strip_shortcodes',
    'the_permalink',
    'the_post_thumbnail',
    'the_excerpt',
    'the_content',
    'the_author',
    'the_date',
    'to_array',
    'wpautop',
    'wp_trim_words',
    'wp_get_attachment_image_src',
    'wp_parse_args',
    'do_action',
    'do_settings_sections',
    'do_shortcode',
    'exec_function',
    'get_admin_page_title',
    'settings_fields',
    'submit_button',

    'acf_add_local_field_group'
    ]);
});