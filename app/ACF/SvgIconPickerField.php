<?php

namespace Chamber\Plugin\ACF;

/**
 * SVG Icon picker field using Advanced Custom Fields plugin.
 *
 * Based off of the Font Icons Picker for ACF
 * @author Alessandro Benoit
 * @src    http://codeb.it/
 */
class SvgIconPickerField {

	/**
	 *  Construct
	 */
	function __construct() {
		add_action('acf/include_field_types',  [$this, 'include_field_types']);
	}

	/**
	 *  Include the SvgIconPicker select field.
	 *
	 * @return  void
	 */
	function include_field_types() {
		include_once('SvgIconPicker.php');
	}
}

// create field
new SvgIconPicker();
