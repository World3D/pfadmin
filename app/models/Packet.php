<?php

class Packet extends Eloquent {

	public static $rules = array
	(
		'name' => 'required',
		'from_id' => 'required',
		'to_id' => 'required',
	);
	
 	public function from()
 	{
 		return $this->belongsTo('Application');
 	}
 	
 	public function to()
 	{
 		return $this->belongsTo('Application');
 	}
}