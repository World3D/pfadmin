<?php

/**
 * Packet model config
 */

return array(

	'title' => 'Packets',

	'single' => 'packet',

	'model' => 'Packet',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name',
		'from' => array(
			'title' => 'From',
			'relationship' => 'from',
			'select' => 'name',
		),
		'to' => array(
			'title' => 'To',
			'relationship' => 'to',
			'select' => 'name',
		),
		'public' => array(
			'title' => 'Public',
			'select' => "IF((:table).public, 'yes', 'no')",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name',
		'from' => array(
			'title' => 'From',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'to' => array(
			'title' => 'To',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'public' => array(
			'title' => 'Public',
			'type' => 'bool',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name',
		'description' => array(
			'title' => 'Description'
		),
		'from' => array(
			'title' => 'From',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'to' => array(
			'title' => 'To',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'data' => array(
			'title' => 'Data',
			'output' => 'datas',
		),
		'public' => array(
			'title' => 'Public',
			'type' => 'bool'
		),

	),

);