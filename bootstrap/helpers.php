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

if (!function_exists('render')) {
    /**
     * Helper function to build views.
     *
     * @param string $view      The view relative path, name.
     * @param array  $data      Passed data.
     * @param array  $mergeData
     *
     * @return \Illuminate\View\Factory
     */
    function render($view = null, array $data = [], array $mergeData = [])
    {
        $factory = oni('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData)->render();
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

if (!function_exists('oni_is_subpage')) {
    /**
     * Define if the current page is a child page.
     *
     * @param array $parent The parent page properties.
     *
     * @return int|bool Parent page ID if subpage. False if not.
     */
    function oni_is_subpage(array $parent)
    {
        global $post;

        $parentPage = get_post($post->post_parent);

        if (is_page() && $post->post_parent && $parentPage->post_name === $parent[0]) {
            return $post->post_parent;
        }

        return false;
    }
}

if (!function_exists('oni_convert_path')) {

    /**
     * Convert '.' into '/' directory separators.
     *
     * @param string $path The initial path with '.'
     *
     * @return string The converted path with '/'
     */
    function oni_convert_path($path)
    {
        if (strpos($path, '.') !== false) {
            $path = str_replace('.', DS, $path);
        } else {
            $path = trim($path);
        }
        return (string) $path;
    }
}

if (!function_exists('pp')) {
    /**
     * Print a value.
     *
     * @param mixed $value Any PHP value
     */
    function pp($value)
    {
        $attributes = func_get_args();

        if (count($attributes) == 1) {
            $attributes = $attributes[0];
        }

        echo '<pre>';
        print_r($attributes);
        echo '</pre>';
    }
}

if (!function_exists('oni_get_the_query')) {
    /**
     * Return the WP Query variable.
     *
     * @return object The global WP_Query instance.
     */
    function oni_get_the_query()
    {
        global $wp_query;

        return $wp_query;
    }
}

if (!function_exists('oni_add_filters')) {
    /**
     * Helper that runs multiple add_filter
     * functions at once.
     *
     * @param array  $tags     Filter tags.
     * @param string $function The name of the global function to call.
     */
    function oni_add_filters(array $tags, $function)
    {
        foreach ($tags as $tag) {
            add_filter($tag, $function);
        }
    }
}

if (!function_exists('oni_get_post_id')) {
    /**
     * A function that retrieves the post ID during
     * a wp-admin request on posts and custom post types.
     *
     * @return int|null
     */
    function oni_get_post_id()
    {
        $id = null;
        // When viewing the cpt (GET)
        if (isset($_GET['post'])) {
            $id = $_GET['post'];
        }
        // When saving the cpt (POST)
        if (isset($_POST['post_ID'])) {
            $id = $_POST['post_ID'];
        }
        return $id;
    }
}

if (!function_exists('oni_is_post')) {
    /**
     * A function that checks you're on a specified
     * admin page, post, or custom post type (edit) in order to display
     * a certain content.
     *
     * Example : Place a specific metabox for a page, a post or a one of your
     * custom post type.
     *
     * Give the post ID. Visible in the admin uri in your browser.
     *
     * @param int $id A WP_Post ID
     *
     * @return bool True. False if not a WordPress post type.
     */
    function oni_is_post($id)
    {
        $postId = oni_get_post_id();
        if (!is_null($postId) && is_numeric($id) && $id === (int) $postId) {
            return true;
        }
        return false;
    }
}

if (!function_exists('oni_attachment_id_from_url')) {
    /**
     * A function that returns the 'attachment_id' of a
     * media file by giving its URL.
     *
     * @param string $url The media/image URL - Works only for images uploaded from within WordPress.
     *
     * @return int|bool The image/attachment_id if it exists, false if not.
     */
    function oni_attachment_id_from_url($url = null)
    {
        /*-----------------------------------------------------------------------*/
        // Load the DB class
        /*-----------------------------------------------------------------------*/
        global $wpdb;
        /*-----------------------------------------------------------------------*/
        // Set attachment_id
        /*-----------------------------------------------------------------------*/
        $id = false;
        /*-----------------------------------------------------------------------*/
        // If there is no url, return.
        /*-----------------------------------------------------------------------*/
        if (null === $url) {
            return;
        }
        /*-----------------------------------------------------------------------*/
        // Get the upload directory paths
        /*-----------------------------------------------------------------------*/
        $upload_dir_paths = wp_upload_dir();
        /*-----------------------------------------------------------------------*/
        // Make sure the upload path base directory exists in the attachment URL,
        // to verify that we're working with a media library image
        /*-----------------------------------------------------------------------*/
        if (false !== strpos($url, $upload_dir_paths['baseurl'])) {
            /*-----------------------------------------------------------------------*/
            // If this is the URL of an auto-generated thumbnail,
            // get the URL of the original image
            /*-----------------------------------------------------------------------*/
            $url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url);
            /*-----------------------------------------------------------------------*/
            // Remove the upload path base directory from the attachment URL
            /*-----------------------------------------------------------------------*/
            $url = str_replace($upload_dir_paths['baseurl'].'/', '', $url);
            /*-----------------------------------------------------------------------*/
            // Grab the database prefix
            /*-----------------------------------------------------------------------*/
            $prefix = $wpdb->prefix;
            /*-----------------------------------------------------------------------*/
            // Finally, run a custom database query to get the attachment ID
            // from the modified attachment URL
            /*-----------------------------------------------------------------------*/
            $id = $wpdb->get_var($wpdb->prepare("SELECT {$prefix}posts.ID FROM $wpdb->posts {$prefix}posts, $wpdb->postmeta {$prefix}postmeta WHERE {$prefix}posts.ID = {$prefix}postmeta.post_id AND {$prefix}postmeta.meta_key = '_wp_attached_file' AND {$prefix}postmeta.meta_value = '%s' AND {$prefix}posts.post_type = 'attachment'", $url));
        }
        return $id;
    }
}
