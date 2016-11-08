<?php

namespace Chamber\Plugin;

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
| Google Maps API
|--------------------------------------------------------------------------
|
| Used by the Attractions posts.
*/
$enqueue->front([
    'as' => 'googlemaps',
    'src' => '//maps.googleapis.com/maps/api/js?key=AIzaSyAS0yll51lLq5yVbqysc6gtKExyIKdURzE',
    'filter' => [ 'postType' => 'attraction' ],
], 'footer');

$enqueue->front([
    'as' => 'googlemapsInit',
    'src' => Helper::assetUrl('/js/chamber-attractions.js'),
    'dep' => ['googlemaps', 'jquery'],
    'filter' => [ 'postType' => 'attraction' ],
], 'footer');
