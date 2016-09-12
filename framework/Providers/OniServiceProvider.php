<?php

namespace Oni\Framework\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\CookieJar;
use Oni\Framework\Session;

/**
 * @see docs
 */
class oniServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquent();

        $this->app->instance(
            'env',
            defined('oni_ENV') ? oni_ENV
                : (defined('WP_DEBUG') ? 'local'
                    : 'production')
        );

        $this->app->instance(
            'http',
            \Oni\Framework\Http::capture()
        );

        $this->app->alias(
            'http',
            'Oni\Framework\Http'
        );

        $this->app->instance(
            'router',
            $this->app->make('Oni\Framework\Router', ['app' => $this->app])
        );

        $this->app->bind(
            'route',
            'Oni\Framework\Route'
        );

        $this->app->instance(
            'enqueue',
            $this->app->make('Oni\Framework\Enqueue', ['app' => $this->app])
        );

        $this->app->alias(
            'enqueue',
            'Oni\Framework\Enqueue'
        );

        $this->app->instance(
            'panel',
            $this->app->make('Oni\Framework\Panel', ['app' => $this->app])
        );

        $this->app->alias(
            'panel',
            'Oni\Framework\Panel'
        );

        $this->app->instance(
            'shortcode',
            $this->app->make('Oni\Framework\Shortcode', ['app' => $this->app])
        );

        $this->app->alias(
            'shortcode',
            'Oni\Framework\Shortcode'
        );

        $this->app->instance(
            'widget',
            $this->app->make('Oni\Framework\Widget', ['app' => $this->app])
        );

        $this->app->alias(
            'widget',
            'Oni\Framework\Widget'
        );

        $this->app->instance(
            'session',
            $this->app->make('Oni\Framework\Session', ['app' => $this->app])
        );

        $this->app->alias(
            'session',
            'Oni\Framework\Session'
        );

        $this->app->instance(
            'notifier',
            $this->app->make('Oni\Framework\Notifier', ['app' => $this->app])
        );

        $this->app->alias(
            'notifier',
            'Oni\Framework\Notifier'
        );

        $this->app->singleton(
            'errors',
            function ()
            {
                return session_flashed('__validation_errors', []);
            }
        );

        $_GLOBALS['errors'] = $this->app['errors'];
    }

    /**
     * Registers Eloquent.
     *
     * @return void
     */
    protected function registerEloquent()
    {
        global $wpdb;

        $capsule = new Capsule($this->app);

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'charset' => DB_CHARSET,
            'collation' => DB_COLLATE ?: $wpdb->collate,
            'prefix' => $wpdb->prefix
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Boots the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['session']->start();
    }

}
