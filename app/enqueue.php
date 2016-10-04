<?php

namespace Chamber;

/** @var \Oni\Framework\Enqueue $enqueue */

/*
|--------------------------------------------------------------------------
| Admin Menu Panel
|--------------------------------------------------------------------------
|
| Register the CSS and JavaScript for the admin settings menu page 
| and icon picker.
*/
$enqueue->admin([
    'as' => 'panelCSS',
    'src' => Helper::assetUrl('/css/chamber-panel.css'),
    'filter' => [ 'panel' => '*' ],
]);

$enqueue->admin([
    'as' => 'panelJS',
    'src' => Helper::assetUrl('/js/chamber-panel.js'),
    'dep' => 'jquery',
    'filter' => [ 'panel' => '*' ],
], 'footer');

/*
|--------------------------------------------------------------------------
| Post.php
|--------------------------------------------------------------------------
|
| Register the CSS and JavaScript for the admin settings menu page 
| and icon picker.
*/
$enqueue->admin([
    'as' => 'postCSS',
    'src' => Helper::assetUrl('/css/chamber-post.css'),
]);

$enqueue->admin([
    'as' => 'postJS',
    'src' => Helper::assetUrl('/js/chamber-post.js'),
    'dep' => 'jquery',
    'filter' => [ 'hook' => 'post.php' ],
    'localize' => [ 'icons_url' => Helper::assetUrl('/icons/chamber-sprite.svg') ]
], 'footer');

/*
|--------------------------------------------------------------------------
| ACF Restrict Color Picker
|--------------------------------------------------------------------------
|
| Register the CSS and JavaScript for the admin settings menu page.
*/
$enqueue->admin([
    'as' => 'panelCSS',
    'src' => Helper::assetUrl('/css/chamber-panel.css'),
    'filter' => [ 'panel' => '*' ],
]);

$enqueue->admin([
    'as' => 'widgetJS',
    'src' => Helper::assetUrl('/js/chamber-widgets.js'),
    'dep' => 'jquery',
    'filter' => [ 'hook' => 'widgets.php' ],
], 'footer');

// $enqueue->admin([
//     'as' => 'acfRCPOptions',
//     'src' => Helper::assetUrl('/js/acfRestrictColorPicker.js'),
//     'dep' => 'jquery',
//     'filter' => [ 'hook' => 'post.php' ],
//     'localize' => \Chamber\ACF\acfRestrictColorPicker::localize();
// ], 'footer');
