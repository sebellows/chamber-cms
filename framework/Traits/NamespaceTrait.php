<?php

namespace Oni\Traits;

trait NamespaceTrait {

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
		if ($this->namespace === null) {
				return $as;
		}

		return $this->namespace . '::' . $as;
	}

	/**
	 * Get the application namespace.
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	public function getNamespace()
	{
	    if (! is_null($this->namespace)) {
	        return $this->namespace;
	    }

	    $composer = json_decode(file_get_contents(base_path('composer.json')), true);

	    foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
	        foreach ((array) $path as $pathChoice) {
	            if (realpath(app_path()) == realpath(base_path().'/'.$pathChoice)) {
	                return $this->namespace = $namespace;
	            }
	        }
	    }

	    throw new RuntimeException('Unable to detect application namespace.');
	}

}