<?php

acf_add_local_field_group([
	'key' => 'group_56f3ecce60f4b',
	'title' => 'Location Information',
	'fields' => array (
		array (
			'key' => 'field_56f3ed2f914de',
			'label' => 'Street Address',
			'name' => 'street',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-street',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f3efbc914df',
			'label' => 'City',
			'name' => 'city',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-city',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f3f090914e0',
			'label' => 'State',
			'name' => 'state',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'select--inline',
				'id' => 'location-state',
			),
			'choices' => array (
				'AL' => 'AL',
				'AK' => 'AK',
				'AZ' => 'AZ',
				'AR' => 'AR',
				'CA' => 'CA',
				'CO' => 'CO',
				'CT' => 'CT',
				'DE' => 'DE',
				'FL' => 'FL',
				'GA' => 'GA',
				'HI' => 'HI',
				'ID' => 'ID',
				'IL' => 'IL',
				'IN' => 'IN',
				'IA' => 'IA',
				'KS' => 'KS',
				'KY' => 'KY',
				'LA' => 'LA',
				'ME' => 'ME',
				'MD' => 'MD',
				'MA' => 'MA',
				'MI' => 'MI',
				'MN' => 'MN',
				'MS' => 'MS',
				'MO' => 'MO',
				'MT' => 'MT',
				'NE' => 'NE',
				'NV' => 'NV',
				'NH' => 'NH',
				'NJ' => 'NJ',
				'NM' => 'NM',
				'NY' => 'NY',
				'NC' => 'NC',
				'ND' => 'ND',
				'OH' => 'OH',
				'OK' => 'OK',
				'OR' => 'OR',
				'PA' => 'PA',
				'RI' => 'RI',
				'SC' => 'SC',
				'SD' => 'SD',
				'TN' => 'TN',
				'TX' => 'TX',
				'UT' => 'UT',
				'VT' => 'VT',
				'VA' => 'VA',
				'WA' => 'WA',
				'WV' => 'WV',
				'WI' => 'WI',
				'WY' => 'WY',
			),
			'default_value' => array (
				0 => 'MI',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 1,
			'placeholder' => '',
			'disabled' => 0,
			'readonly' => 0,
		),
		array (
			'key' => 'field_56f3f3ba914e1',
			'label' => 'Postal Code',
			'name' => 'postalcode',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-postal',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => 10,
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f3f425914e2',
			'label' => 'Phone',
			'name' => 'phone',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-tel',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f3f505914e3',
			'label' => 'Fax',
			'name' => 'fax',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-fax',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f3f534914e4',
			'label' => 'Email',
			'name' => 'email',
			'type' => 'email',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-email',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array (
			'key' => 'field_56f3f558914e5',
			'label' => 'Website',
			'name' => 'website',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => 'textInput--inline',
				'id' => 'location-url',
			),
			'default_value' => '',
			'placeholder' => '',
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
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'discussion',
		1 => 'comments',
		2 => 'author',
		3 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
]);
