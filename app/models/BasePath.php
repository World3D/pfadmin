<?php

class BasePath extends Eloquent {

	public static $rules = array
	(
		'name' => 'required|max:64',
		'path' => 'required|max:260',
	);
	
}