<?php

/**
 * BasePath model config
 */

return array(

	'title' => 'BasePaths',

	'single' => 'basepath',

	'model' => 'BasePath',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name',
		'path' => array(
			'title' => 'Path'
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
		'name' => array(
			'type' => 'enum',
			'options' => array( 'WORK_PATH', 'COMMON_PATH', ),
		),
		'path' => array(
			'title' => 'Path',
			'limit' => 260,
		),
	),
	
	/**
	 * This is run prior to saving the JSON form data
	 *
	 * @type function
	 * @param array     $data
	 * @param bool		$update data is need update(true) or add new(false)
	 *
	 * @return string (on error) / void (otherwise)
	 */
	'before_save' => function(&$data, $update)
	{
		$name = $data['name'];
		$path = $data['path'];
		$setnumber = DB::table('base_paths')->where('name', $name)->count();
		if ($setnumber > 0 && !$update) {
			return 'error, the name: [' .$name. '] already has set.';
		}
		if (!is_dir($path)) {
			return 'error, the path: [' .$path. '] doesn\'t exists.';
		}
	},

);