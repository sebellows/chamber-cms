<?php

namespace Chamber\Plugin;

class Helper {

    /**
     * The booted state.
     *
     * @var boolean
     */
    protected static $booted = false;

    /**
     * The base path.
     *
     * @var string
     */
    protected static $base;

    /**
     * The config/plugin.php content.
     *
     * @var array
     */
    protected static $config = [];

    /**
     * Boots the Helper.
     */
    public static function boot()
    {
        self::$base = plugin_directory();
        self::$base = self::$base . '/' . basename(plugin_dir_url(__DIR__)) . '/';

        self::$config = @require self::$base . '/oni.config.php';

        self::$booted = true;
    }

    /**
     * Gets a config variable.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        if ( ! self::$booted)
        {
            self::boot();
        }

        if ($key === null)
        {
            return self::$config;
        }

        return array_get(self::$config, $key, $default);
    }

    /**
     * Gets a path to a relative file.
     *
     * @param  string $file
     * @return string
     */
    public static function path($file)
    {
        if ( ! self::$booted)
        {
            self::boot();
        }

        return self::$base . $file;
    }

    /**
     * Gets a path to a relative asset.
     *
     * @param  string $file
     * @return string
     */
    public static function asset($file = null)
    {
        $asset = trim(self::get('public', 'public'), '/');

        if ($file !== null)
        {
            $asset .= '/' . trim($file, '/');
        }

        return self::path($asset);
    }

    /**
     * Gets a url to a relative asset.
     *
     * @param  string $file
     * @return string
     */
    public static function assetUrl($file = null)
    {
        return content_url(
            substr(self::asset($file), strlen(content_directory()))
        );
    }

    /**
     * Render human-friendly taxonomy name
     * 
     * @param  string $string the taxonomy name
     * @return string the human-friendly taxonomy name
     */
    public static function humanize( $string = null ) {
        return ucwords( strtolower( str_replace( ['-', '_'], ' ', $string ) ) );
    }

    public static function pluralize( $string )
    {
        if ( $string == 'person' ) {

            $plural = 'people';

        } else {

            $last = $string[strlen( $string ) - 1];

            if( $last == 'y' )
            {
                $cut = substr( $string, 0, -1 );
                //convert y to ies
                $plural = $cut . 'ies';
            }

            else
            {
                // just attach an s
                $plural = $string . 's';
            }            
        }

        return $plural;
    }

    public static function slugify( $string )
    {
        return strtolower(str_replace([' ', '_'], '-', $string));
    }

    /**
     * Return the plugin`s registered name in composer.json file as a string.
     * 
     * @return string  `My Plugin` → `myplugin`
     */
    public static function pluginName()
    {
        // return $this->basePath . '/' . strtolower(basename($this->basePath));
        return rtrim(oni()->getNamespace(), '\\');
    }

    /**
     * Prefixes a given string using define prefix 
     * 
     * @param  string $string
     * @param  string $splitter
     * @return string
     */
    public static function prefix($string, $splitter = '_')
    {
        $prefix = self::get('prefix');
        $prefix = trim($prefix, $splitter);

        return sprintf("%s%s%s", $prefix, $splitter, $string);
    }

    /**
     * Limit the length of an excerpt.
     *
     * @param integer $limit the character count limit
     * @param string  $continued_mark glyph or text to communicate that this is abbreviated text
     * @return string excerpt text
     */
    public static function limitContent( $content = '', $limit = 120, $continued_mark = '&hellip;' ) {

        $content = wordwrap($content, $limit);

        // Do not cut if too short
        if ( strlen( $content ) < $limit ) {
            return $content;
        }

        // Find the next space after `$limit` to prevent sudden word break
        $break = strpos( $content, ' ', $limit );

        // Take the existing content and return a subset of it
        $chunk = substr( $content, 0, $break );

        // Make sure any tags don't get left off in the cut
        return balanceTags( $chunk ) . $continued_mark;
    }

}
