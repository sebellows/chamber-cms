<?php

namespace Oni\Framework;

use Closure;
use InvalidArgumentException;
use Oni\Framework\Exceptions\HttpErrorException;

/**
 * @see docs
 *
 * @method void get()    get(array $parameters)    Adds a get route.
 * @method void post()   post(array $parameters)   Adds a post route.
 * @method void put()    put(array $parameters)    Adds a put route.
 * @method void patch()  patch(array $parameters)  Adds a patch route.
 * @method void delete() delete(array $parameters) Adds a delete route.
 */
class Router {

    /**
     * @var array
     */
    protected static $methods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE'
    ];

    /**
     * @var \Oni\Framework\Application
     */
    protected $app;

    /**
     * @var \Oni\Framework\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
        'named' => []
    ];

    /**
     * The current namespace.
     *
     * @var string|null
     */
    protected $namespace = null;

    /**
     * @var string
     */
    protected $parameterPattern = '/{([\w\d]+)}/';

    /**
     * @var string
     */
    protected $valuePattern = '(?P<$1>[^\/]+)';

    /**
     * @var string
     */
    protected $valuePatternReplace = '([^\/]+)';

    /**
     * Adds the action hooks for WordPress.
     *
     * @param \Oni\Framework\Application $app
     * @param \Oni\Framework\Request     $request
     */
    public function __construct(Application $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;

        add_action('wp_loaded', [$this, 'flush']);
        add_action('init', [$this, 'boot']);
        add_action('parse_request', [$this, 'parseRequest']);
    }

    /**
     * Boot the router.
     *
     * @return void
     */
    public function boot()
    {
        add_rewrite_tag('%oni_route%', '(.+)');
        
        if(is_array($this->routes[$this->request->method()]))
        {
            foreach ($this->routes[$this->request->method()] as $id => $route)
            {
                $this->addRoute($route, $id, $this->request->method());
            } 
        }
        
    }

    /**
     * Adds the route to WordPress.
     *
     * @param $route
     * @param $id
     * @param $method
     */
    protected function addRoute($route, $id, $method)
    {
        $params = [
            'id' => $id,
            'parameters' => []
        ];

        $uri = '^' . preg_replace(
            $this->parameterPattern,
            $this->valuePatternReplace,
            str_replace('/', '\\/', $route['uri'])
        );

        $url = 'index.php?';

        $matches = [];
        if (preg_match_all($this->parameterPattern, $route['uri'], $matches))
        {
            foreach ($matches[1] as $id => $param)
            {
                add_rewrite_tag('%oni_param_' . $param . '%', '(.+)');
                $url .= 'oni_param_' . $param . '=$matches[' . ($id + 1) . ']&';
                $params['parameters'][$param] = null;
            }
        }

        add_rewrite_rule($uri . '$', $url . 'oni_route=' . urlencode(json_encode($params)), 'top');
    }

    /**
     * @param $method
     * @param $parameters
     * @return bool
     */
    public function add($method, $parameters)
    {
        if ( ! in_array($method, static::$methods))
        {
            return false;
        }

        if ($parameters instanceof Closure)
        {
            $parameters = [ 'uses' => $parameters ];
        }

        foreach (['uri', 'uses'] as $key)
        {
            if (isset($parameters[$key]))
            {
                continue;
            }

            throw new InvalidArgumentException("Missing {$key} definition for route");
        }

        $route = array_merge($parameters, [
            'uri' => ltrim($parameters['uri'], '/')
        ]);

        $this->routes[$method][] = $route;

        if (isset($route['as']))
        {
            $this->routes['named'][$method . '::' . $this->namespaceAs($route['as'])] = $route;
        }

        return true;
    }

    /**
     * Flushes WordPress's rewrite rules.
     *
     * @return void
     */
    public function flush()
    {
        flush_rewrite_rules();
    }

    /**
     * Parses a WordPress request.
     *
     * @param $wp
     * @return void
     */
    public function parseRequest($wp)
    {
        if ( ! array_key_exists('oni_route', $wp->query_vars))
        {
            return;
        }

        $data = @json_decode($wp->query_vars['oni_route'], true);
        $route = null;

        if (isset($data['id']) && isset($this->routes[$this->request->method()][$data['id']]))
        {
            $route = $this->routes[$this->request->method()][$data['id']];
        }
        elseif (isset($data['name']) && isset($this->routes['named'][$data['name']]))
        {
            $route = $this->routes['named'][$data['name']];
        }

        if ( ! isset($route))
        {
            return;
        }

        if ( ! isset($data['parameters']))
        {
            $data['parameters'] = [];
        }

        foreach ($data['parameters'] as $key => $val)
        {
            if ( ! isset($wp->query_vars['oni_param_' . $key]))
            {
                return;
            }

            $data['parameters'][$key] = $wp->query_vars['oni_param_' . $key];
        }

        try {
            $this->processRequest(
                $this->buildRoute(
                    $route,
                    $data['parameters']
                )
            );
        } catch (HttpErrorException $e) {
            if ($e->getStatus() === 301 || $e->getStatus() === 302)
            {
                $this->processResponse($e->getResponse());

                die;
            }

            if ($e->getStatus() === 404)
            {
                global $wp_query;
                $wp_query->set_404();
            }

            status_header($e->getStatus());

            define('oni_HTTP_ERROR_CODE', $e->getStatus());
            define('oni_HTTP_ERROR_MESSAGE', $e->getMessage());

            if ($e->getStatus() === 404)
            {
                @include get_404_template();
            }
            else
            {
                echo $e->getMessage();
            }
        }

        die;
    }

    /**
     * Build a route instance.
     *
     * @param $data
     * @param $params
     * @return \Oni\Framework\Route
     */
    protected function buildRoute($data, $params)
    {
        return new Route($this->app, $data, $params);
    }

    /**
     * Processes a request.
     *
     * @param \Oni\Framework\Route $route
     * @return void
     */
    protected function processRequest(Route $route)
    {
        $this->processResponse($route->handle());
    }

    /**
     * Processes a response.
     *
     * @param  \Oni\Framework\Response $response
     * @return void
     */
    protected function processResponse(Response $response)
    {
        if ($response instanceof RedirectResponse)
        {
            $response->flash();
        }

        status_header($response->getStatusCode());

        foreach ($response->getHeaders() as $key => $value)
        {
            @header($key . ': ' . $value);
        }

        echo $response->getBody();
    }

    /**
     * Get the URL to a route.
     *
     * @param  string $name
     * @param  array  $args
     * @return string
     */
    public function url($name, $args = [])
    {
        $route = null;
        $routes = $this->routes['named'];
        foreach (self::$methods as $method)
        {
            if ( ! isset($routes[$method . '::' . $name]))
            {
                continue;
            }

            $route = $routes[$method . '::' . $name];
        }

        if ($route === null)
        {
            return null;
        }

        $matches = [];
        preg_match_all($this->parameterPattern, $uri = $route['uri'], $matches);
        foreach ($matches[0] as $id => $match)
        {
            $uri = preg_replace('/' . preg_quote($match) . '/', array_get($args, $matches[1][$id], $match), $uri, 1);
        }

        return home_url() . '/' . $uri;
    }

    /**
     * Sets the current namespace.
     *
     * @param  string $namespace
     * @return void
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Unsets the current namespace.
     *
     * @return void
     */
    public function unsetNamespace()
    {
        $this->namespace = null;
    }

    /**
     * Namespaces a name.
     *
     * @param  string $as
     * @return string
     */
    protected function namespaceAs($as)
    {
        if ($this->namespace === null)
        {
            return $as;
        }

        return $this->namespace . '::' . $as;
    }

    /**
     * Magic method calling.
     *
     * @param       $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters = [])
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array([$this, $method], $parameters);
        }

        if (in_array(strtoupper($method), static::$methods))
        {
            return call_user_func_array([$this, 'add'], array_merge([strtoupper($method)], $parameters));
        }

        throw new InvalidArgumentException("Method {$method} not defined");
    }

}
