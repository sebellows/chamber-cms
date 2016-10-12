<?php

namespace Chamber\Plugin\Controllers;

use Chamber\Plugin\Helper;

/**
 * Class AdminController.
 */
class AdminController {
	/**
	 * Returns the main view of the plugin.
	 *
	 * @return \Oni\Panel $panel
	 */
	public function index() {
		return view('@Chamber/admin/index.twig');
	}

	/**
	 * A configuration page w/ settings to turn features ON or OFF.
	 *
	 * @return \Oni\Panel $panel
	 */
	// public function settings() {
	// 	return view('@Chamber/admin/settings.twig');
	// }
}
