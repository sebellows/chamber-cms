<?php

namespace Oni\Traits;

trait PathTrait
{

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath.DS.'app';
    }

    /**
     *  Get the base path of the Plugin installation
     *
     *  @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @return string
     */
    public function bootstrapPath()
    {
        return $this->basePath.DS.'bootstrap';
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        return $this->basePath.DS.'config';
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DS.'public';
    }

    /**
     * Get the path to the resources directory.
     *
     * @return string
     */
    public function assetsPath()
    {
        return $this->basePath.DS.'resources'.DS.'assets';
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    // public function storagePath()
    // {
    //     return $this->storagePath ?: $this->basePath.DS.'storage';
    // }

    /**
     * Set the storage directory.
     *
     * @param  string  $path
     * @return $this
     */
    // public function useStoragePath($path)
    // {
    //     $this->storagePath = $path;

    //     $this->instance('path.storage', $path);

    //     return $this;
    // }

    /**
     * Get the full path and filename of the plugin's registration file.
     *
     * @return string
     */
    public function pluginFile()
    {
        // return $this->basePath.DS.strtolower(basename($this->basePath)).'.php';
        return $this->basePath.DS.'plugin.php';
    }

    /**
     * Get the full path and filename of the plugin's registration file.
     *
     * @return string
     */
    public function pluginConfigFile($config)
    {
        if (! empty($config)) {
            // $configPath = $this->basePath.DS.$config;
            @require_once "$config";
        }
    }
}
