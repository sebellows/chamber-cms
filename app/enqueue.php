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
// $enqueue->admin([
//     'as' => 'panelCSS',
//     'src' => Helper::assetUrl('/css/chamber-panel.css'),
//     'filter' => [ 'panel' => '*' ],
// ]);

// $enqueue->admin([
//     'as' => 'panelJS',
//     'src' => Helper::assetUrl('/js/chamber-panel.js'),
//     'filter' => [ 'panel' => '*' ],
// ], 'footer');

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

// $enqueue->admin([
//     'as' => 'postJS',
//     'src' => Helper::assetUrl('/js/chamber-post.js'),
//     'filter' => [ 'hook' => 'post.php' ],
// ], 'footer');

/*
|--------------------------------------------------------------------------
| Edit.php
|--------------------------------------------------------------------------
|
| Register the CSS and JavaScript for edit.php
*/
