<?php

acf_add_local_field_group(array (
	'key' => 'group_570c83d828c6a',
	'title' => 'Attraction Categories',
	'fields' => array (
		array (
			'key' => 'field_570c83e8fe63b',
			'label' => 'Attraction Category',
			'name' => 'attraction_category',
			'type' => 'taxonomy',
			'instructions' => 'Check one or more appropriate categories for the attraction.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'attraction_category',
			'field_type' => 'checkbox',
			'allow_null' => 0,
			'add_term' => 0,
			'save_terms' => 1,
			'load_terms' => 1,
			'return_format' => 'object',
			'multiple' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'attraction',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'custom_fields',
		1 => 'discussion',
		2 => 'comments',
	),
	'active' => 1,
	'description' => 'Select one or more categories that the attraction fits into to help filter results',
));
