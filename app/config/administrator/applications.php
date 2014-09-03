<?php

/**
 * Packet model config
 */

return array(

	'title' => 'Applications',

	'single' => 'application',

	'model' => 'Application',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name',
		'description' => array(
			'title' => 'Description'
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'name',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name',
		'description' => array(
			'title' => 'Description'
		),
	),

);