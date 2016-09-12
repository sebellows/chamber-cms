<?php

namespace Chamber\ACF;

use Chamber\Helper;
use acf_field;

/**
 * SVG Icon picker field using Advanced Custom Fields plugin.
 */
class SvgIconPicker extends acf_field {

	/**
	 * Will hold info such as dir/path.
	 * 
	 * @var array
	 */
	// public $settings = [];

	/**
	 * Will hold default field options.
	 * 
	 * @var array
	 */
	// public $defaults = [];

	/**
	 * Hold the content of icons JSON config file.
	 * 
	 * @var array
	 */
	// public $json_content;

	// Vars
	var $settings, 		// Will hold info such as dir / path
		$defaults,		// Will hold default field options
		$json_content; 	// Hold the content of icons JSON config file

	/**
	 *  Construct
	 */
	function __construct() {

		$this->name     = 'svgiconpicker';
		$this->label    = __('Icon Picker');
		$this->category = __("jQuery", 'acf');

		$this->defaults = [
			'value' => false, // prevents acf_renderFields() from attempting to load value
		];

    	parent::__construct();

    	// Settings
		$this->settings = [
			'icons' => Helper::asset('/icons/icons.json')
		];

		// Apply a filter so that the icon set will load from theme
		apply_filters('acf/svgiconpicker/settings', $this->settings);

		// Load icons list from the icons JSON file
		if (is_admin()) {
			$json_file = @file_get_contents( $this->settings['icons'] );
			$this->json = $json_file;
			$this->json_content = @json_decode( $json_file, true );
		}
	}

	/**
	 *  Render the select field for the icons.
	 *
	 *  @param array $field  An array holding all the field's data
	 *
	 * @return  void
	 */
	function render_field( $field ) {
		if ( !isset( $this->json_content['icons'] ) ){
			_e('No icons found');
			return;
		}

		// icons SELECT input
		echo '<select name="'. $field['name'] .'" id="'. $field['name'] .'" class="acf-svgiconpicker">';
		echo '<option value="">'. __('None').'</option>';
		foreach ( $this->json_content['icons'] as $icon ) {
			$icon_full = $this->json_content['prefix'] . $icon['name'];
			echo '<option value="'. $icon_full .'" '. selected( $field['value'], $icon_full, false ) .'>'. $icon['name'] .'</option>';
		}
		echo '</select>';
	}
}
