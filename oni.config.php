<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Plugin Version Constraint.
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'version' => '~0.1.0',

    /*
    |--------------------------------------------------------------------------
    | Plugin Aliases
    |--------------------------------------------------------------------------
    |
    | The plugin files to register within the service container.
    |
    */

    /**
     * Auto-load all required files.
     */
    'requires' => [
        __DIR__ . '/app/postTypes.php',
        __DIR__ . '/app/acf.php',
        __DIR__ . '/app/admin.php',
        __DIR__ . '/app/twigExtensions.php'
    ],

    
    /**
     * The tables to manage.
     */
    'tables' => [
        'people' => 'Chamber\Tables\People'
    ],

    /**
     * Activate
     */
    'activators' => [
        __DIR__ . '/app/activate.php'
    ],

    /**
     * Deactivate
     */
    'deactivators' => [
        __DIR__ . '/app/deactivate.php'
    ],

    /**
     * The shortcodes to auto-load.
     */
    'shortcodes' => [
        __DIR__ . '/app/shortcodes.php'
    ],

    /**
     * The widgets to auto-load.
     */
    'widgets' => [
        __DIR__ . '/app/widgets.php'
    ],

    /**
     * The styles and scripts to auto-load.
     */
    'enqueue' => [
        __DIR__ . '/app/enqueue.php'
    ],

    /**
     * The routes to auto-load.
     */
    'routes' => [
        'Chamber' => __DIR__ . '/app/routes.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'Chamber' => __DIR__ . '/app/panels.php'
    ],

    /**
     * The APIs to auto-load.
     */
    'apis' => [
        'Chamber' => __DIR__ . '/app/api.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'MyPlugin' => __DIR__ . '/views'
     * can be referenced via @MyPlugin/
     * when rendering a view in twig.
     */
    'views' => [
        'Chamber' => __DIR__ . '/resources/views'
    ],

    /**
     * The view globals.
     */
    'viewGlobals' => [
    ],


    /**
     * The asset path.
     */
    'assets' => '/resources/assets/'

];
