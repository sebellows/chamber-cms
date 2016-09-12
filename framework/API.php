<?php

namespace Oni\Framework;

use Exception;

/**
 * @see docs
 */
class API {

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var \Oni\Framework\Application
     */
    protected $app;

    /**
     * @param \Oni\Framework\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Add a method.
     *
     * @param $method
     * @param $fn
     */
    public function add($method, $fn)
    {
        $this->methods[$method] = $fn;
    }

    /**
     * Gets a method.
     *
     * @param  string $method
     * @return Callable
     */
    public function get($method)
    {
        return array_get($this->methods, $method);
    }

    /**
     * Magic call from the function collection.
     *
     * @param $method
     * @param $params
     * @return mixed
     * @throws \WP_Error
     */
    public function __call($method, $params)
    {
        if ( ! isset($this->methods[$method]))
        {
            throw new Exception("Method '{$method}' not set!");
        }

        return $this->app->call(
            $this->methods[$method], $params
        );
    }

}
