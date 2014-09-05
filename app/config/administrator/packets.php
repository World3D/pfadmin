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
		'description' => array(
			'title' => 'Description',
		),
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
			'type' => 'textarea',
			'editdata' => true,
		),
		'public' => array(
			'title' => 'Public',
			'type' => 'bool'
		),
	),
	
	/**
	 * This is where you can define the model's custom actions
	 */
	'global_actions' => array(
		//Ordering an item up
		'generate_code' => array(
			'title' => 'Generate Code',
			'messages' => array(
				'active' => 'Reordering...',
				'success' => 'Reordered',
				'error' => 'There was an error while reordering',
			),
			'permission' => function($model)
			{
				return $model->category_id !== 2;
			},
			//the model is passed to the closure
			'action' => function($model)
			{
				//get all the items of this model and reorder them
				$model->orderUp();
			}
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
		$isjson = function($str) {
			json_decode($str);
			return (json_last_error() == JSON_ERROR_NONE);
		};
		$datas = $data['data'];
		if (!$isjson($datas)) {
			return 'the field [data] not a valid json';
		}
	},
	
	'editdata' => true,

);