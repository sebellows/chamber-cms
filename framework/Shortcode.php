<?php

namespace Oni\Framework;

use Exception;

/**
 * @see docs
 */
class Shortcode {

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
     * Add a new shortcode.
     *
     * @param       $name
     * @param       $callable
     * @param array $arguments
     */
    public function add($name, $callable, $arguments = [])
    {
        add_shortcode($name, function ($attributes = [], $content = null) use ($callable, $arguments)
        {
            if ( ! is_array($attributes))
            {
                $attributes = [];
            }

            if ( ! empty($arguments))
            {
                $attributes = $this->renameArguments($arguments, $attributes);
            }

            if (is_string($callable) && strpos($callable, '::') !== false)
            {
                list($api, $method) = explode('::', $callable);

                global $$api;

                if ($$api === null)
                {
                    throw new Exception("API '{$api}' not set!");
                }

                $callable = $$api->get($method);

                if ($callable === null)
                {
                    throw new Exception("Method '{$method}' not set!");
                }
            }

            $response = $this->app->call(
                $callable,
                //// @see https://github.com/getherbert/framework/pull/28/commits/fb73785645873065a43490cf92ebd4e488741052
                // array_merge([
                //     '_attributes' => $attributes,
                //     '_content'    => $content
                // ], $attributes)
                $attributes
            );

            if ($response instanceof RedirectResponse)
            {
                $response->flash();
            }

            if ($response instanceof Response)
            {
                status_header($response->getStatusCode());

                foreach ($response->getHeaders() as $key => $value)
                {
                    @header($key . ': ' . $value);
                }

                return $response->getBody();
            }

            if (is_null($response) || is_string($response))
            {
                return $response;
            }

            if (is_array($response) || $response instanceof Jsonable || $response instanceof JsonSerializable)
            {
                return (new JsonResponse($response))->getBody();
            }

            throw new Exception('Unknown response type!');
        });
    }

    /**
     * Renames shortcode arguments in a 'from => to' format
     * eg: my_name => myName
     *
     * @param $arguments
     * @param $attributes
     * @return array
     */
    protected function renameArguments($arguments, $attributes)
    {
        $output = [];
        array_walk($attributes, function ($value, $key) use ($arguments, &$output)
        {
            if (!isset($arguments[$key]))
            {
                return;
            }

            $output[$arguments[$key]] = $value;
        });

        return $output;
    }

}
