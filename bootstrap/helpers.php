<?php

defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);

if ( ! function_exists('dd'))
{
    /**
     * Dies and dumps.
     *
     * @return string
     */
    function dd()
    {
        call_user_func_array('dump', func_get_args());
        die;
    }
}

if ( ! function_exists('content_directory'))
{
    /**
     * Gets the content directory.
     *
     * @return string
     */
    function content_directory()
    {
        return WP_CONTENT_DIR;
    }
}

if ( ! function_exists('plugin_directory'))
{
    /**
     * Gets the plugin directory.
     *
     * @return string
     */
    function plugin_directory()
    {
        return WP_PLUGIN_DIR;
    }
}

if ( ! function_exists('response'))
{
    /**
     * Generates a response.
     *
     * @param  string  $body
     * @param  integer $status
     * @param  array   $headers
     * @return \Oni\Framework\Response
     */
    function response($body, $status = 200, $headers = null)
    {
        return new Oni\Framework\Response($body, $status, $headers);
    }
}

if ( ! function_exists('json_response'))
{
    /**
     * Generates a json response.
     *
     * @param  mixed   $jsonable
     * @param  integer $status
     * @param  array   $headers
     * @return \Oni\Framework\Response
     */
    function json_response($jsonable, $status = 200, $headers = null)
    {
        return new Oni\Framework\JsonResponse($jsonable, $status, $headers);
    }
}

if ( ! function_exists('redirect_response'))
{
    /**
     * Generates a redirect response.
     *
     * @param  string  $url
     * @param  integer $status
     * @param  array   $headers
     * @return \Oni\Framework\Response
     */
    function redirect_response($url, $status = 302, $headers = null)
    {
        return new Oni\Framework\RedirectResponse($url, $status, $headers);
    }
}

if ( ! function_exists('oni'))
{
    /**
     * Gets the oni container.
     *
     * @param  string $binding
     * @return string
     */
    function oni($binding = null)
    {
        $instance = Oni\Framework\Application::getInstance();
        if ( ! $binding)
        {
            return $instance;
        }
        return $instance[$binding];
    }
}

if ( ! function_exists('errors'))
{
    /**
     * Get the errors.
     *
     * @param string key
     * @return array
     */
    function errors($key = null)
    {
        $errors = oni('errors');
        $errors = isset($errors[0]) ? $errors[0] : $errors;
        if (!$key)
        {
            return $errors;
        }
        return array_get($errors, $key);
    }
}

if ( ! function_exists('session'))
{
    /**
     * Gets the session or a key from the session.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return \Illuminate\Session\Store|mixed
     */
    function session($key = null, $default = null)
    {
        if ($key === null)
        {
            return oni('session');
        }
        return oni('session')->get($key, $default);
    }
}

if ( ! function_exists('session_flashed'))
{
    /**
     * Gets the session flashbag or a key from the session flashbag.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return \Illuminate\Session\Store|mixed
     */
    function session_flashed($key = null, $default = [])
    {
        if ($key === null)
        {
            return oni('session')->getFlashBag();
        }
        return oni('session')->getFlashBag()->get($key, $default);
    }
}

if ( ! function_exists('view'))
{
    /**
     * Renders a twig view.
     *
     * @param  string $name
     * @param  array  $context
     * @return string
     */
    function view($name, $context = [])
    {
        return response(oni('Twig_Environment')->render($name, $context));
    }
}

if ( ! function_exists('panel_url'))
{
    /**
     * Gets the url to a panel.
     *
     * @param  string $name
     * @param  array  $query
     * @return string
     */
    function panel_url($name, $query = [])
    {
        return add_query_arg($query, oni('panel')->url($name));
    }
}

if ( ! function_exists('route_url'))
{
    /**
     * Gets the url to a route.
     *
     * @param  string $name
     * @param  array  $args
     * @param  array  $query
     * @return string
     */
    function route_url($name, $args = [], $query = [])
    {
        return add_query_arg($query, oni('router')->url($name, $args));
    }
}

