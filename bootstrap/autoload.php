<?php

/*
|--------------------------------------------------------------------------
| Exit if accessed directly.
/*----------------------------------------------------*/
if( ! defined( 'ABSPATH' ) ) exit;

/*
|--------------------------------------------------------------------------
| Ensure this is only ran once.
|--------------------------------------------------------------------------
*/
if (defined('ONI_AUTOLOAD'))
{
    return;
}

define('ONI_AUTOLOAD', microtime(true));

/*
|--------------------------------------------------------------------------
| Load the WP plugin system.
/*----------------------------------------------------*/
if (array_search(ABSPATH . 'wp-admin/includes/plugin.php', get_included_files()) === false)
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/*
|--------------------------------------------------------------------------
| The directory separator.
|--------------------------------------------------------------------------
*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

@require 'helpers.php';

/**
 * Get Oni.
 */
$oni = Oni\Framework\Application::getInstance();

/**
 * Load all oni.php files in plugin roots.
 */
$iterator = new DirectoryIterator(plugin_directory());

foreach ($iterator as $directory)
{
    if ( ! $directory->valid() || $directory->isDot() || ! $directory->isDir())
    {
        continue;
    }

    $root = $directory->getPath() . '/' . $directory->getFilename();

    if ( ! file_exists($root . '/oni.config.php'))
    {
        continue;
    }

    $oni_config = $oni->getPluginConfig($root);

    $oni_plugin = substr($root . '/plugin.php', strlen(plugin_directory()));
    $oni_plugin = ltrim($oni_plugin, '/');

    register_activation_hook($oni_plugin, function () use ($oni, $oni_config, $root)
    {
        if ( ! $oni->pluginMatches($oni_config))
        {
            $oni->pluginMismatched($root);
        }

        $oni->pluginMatched($root);
        $oni->loadPlugin($oni_config);
        $oni->activatePlugin($root);
    });

    register_deactivation_hook($oni_plugin, function () use ($oni, $root)
    {
        $oni->deactivatePlugin($root);
    });

    // Ugly hack to make the install hook work correctly
    // as WP doesn't allow closures to be passed here
    register_uninstall_hook($oni_plugin, create_function('', 'oni()->deletePlugin(\'' . $root . '\');'));

    if ( ! is_plugin_active($oni_plugin))
    {
        continue;
    }

    if ( ! $oni->pluginMatches($oni_config))
    {
        $oni->pluginMismatched($root);

        continue;
    }

    $oni->pluginMatched($root);

    @require_once $root.'/plugin.php';

    $oni->loadPlugin($oni_config);
}

/**
 * Boot Oni.
 */
$oni->boot();

// dd($oni->basePath());