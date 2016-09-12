<?php

namespace Chamber;

use Chamber\Helper;

/** @var \Oni\Plugin\Panel $panel */

$panel->add([
	'type'   => 'panel',
	'as'     => 'mainPanel',
	'title'  => 'Chamber CMS',
	'rename' => 'Documentation',
	'slug'   => 'chamber-index',
	'icon'   => 'dashicons-carrot',
	'uses'   => __NAMESPACE__ . '\Controllers\AdminController@index',
	'order'  => '20.1'
]);

// $panel->add([
// 	'type'   => 'sub-panel',
// 	'parent' => 'mainPanel',
// 	'as'     => 'settingsSubpanel',
// 	'title'  => 'Chamber Settings',
// 	'slug'   => 'chamber-settings',
// 	'uses'   => __NAMESPACE__ . '\Controllers\AdminController@settings'
// ]);

