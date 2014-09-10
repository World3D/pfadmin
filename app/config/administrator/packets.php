<?php

//this functions can write in a class, but now i don't need it must.

if (!defined('LF')) define('LF', "\n");

/**
 * Check the string is a valid json string.
 *
 * @param  string  $str
 * @return bool
 */
if (!function_exists('is_validjson'))
{
	function is_validjson($str) {
		json_decode($str);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}

/**
 * Get spaces by count.
 *
 * @param  integer  $count
 * @return string
 */
if (!function_exists('getspaces'))
{
	function getspaces($count) 
	{
		$str = '';
		for ($i = 0; $i < $count; ++$i)
		{
			$str .= ' ';
		}
		return $str;
	}
}

/**
 * Get array last key.
 *
 * @param  array  $array
 * @return integer
 */
if (!function_exists('array_lastkey'))
{
	function array_lastkey(array $array = array())
	{
		$key = 0;
		$array_count = count($array);
		$key = $array_count > 0 ? $array_count - 1 : $key;
		return $key;
	}
}

/**
 * Get construct implement string.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_construct_implement'))
{
	function get_construct_implement(array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		$autospace = false;
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			if ('string' === $typestr)
			{
				$str .= true === $autospace ? getspaces(4) : '';
				$str .= 'memset(' .$val[1]. ', 0, sizeof(' .$val[1]. ');';
				$str .= $key === $lastkey ? '' : LF;
				if (false === $autospace)
				{
					$autospace = true;
				}
			}
		}
		return $str;
	}
}

/**
 * Get read implement string.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_read_implement'))
{
	function get_read_implement(array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$typestr = 'string' == $typestr ? $typestr : substr($typestr, 0, strlen($typestr) - 2);
			$str .= 0 === $key ? '' : getspaces(4);
			$str .= 'string' === $typestr ? '' : $val[1]. '_ = ';
			$str .= 'inputstream.read_' .$typestr. '(';
			$str .= 'string' === $typestr ? $val[1]. '_' : '';
			$str .= 'string' === $typestr ? ', sizeof(' .$val[1]. '));' : ');';
			$str .= $key === $lastkey ? '' : LF;
		}
		return $str;
	}
}

/**
 * Get write implement string.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_write_implement'))
{
	function get_write_implement(array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$typestr = 'string' == $typestr ? $typestr : substr($typestr, 0, strlen($typestr) - 2);
			$str .= 0 === $key ? '' : getspaces(4);
			$str .= 'inputstream.write_' .$typestr. '(';
			$str .= $val[1]. '_';
			$str .= ');';
			$str .= $key === $lastkey ? '' : LF;
		}
		return $str;
	}
}

/**
 * Get size implement string.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_size_implement'))
{
	function get_size_implement(array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$str .= 0 === $key ? '' : getspaces(20);
			$str .= 'string' == $typestr ? 'strlen(' : 'sizeof(';
			$str .= $val[1] .'_';
			$str .= ')';
			$str .= $key === $lastkey ? '' : ' +';
			$str .= $key === $lastkey ? ';' : LF;
		}
		return $str;
	}
}

/**
 * Get max size implement string.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_maxsize_implement'))
{
	function get_maxsize_implement(array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$str .= 0 === $key ? '' : getspaces(20);
			$str .= 'sizeof(';
			$str .= 'string' == $typestr ? 'char' : $typestr;
			$str .= ')';
			$str .= 'string' == $typestr ? ' * ' .$val[2] : '';
			$str .= $key === $lastkey ? '' : ' +';
			$str .= $key === $lastkey ? ';' : LF;
		}
		return $str;
	}
}

/**
 * Get packet variable type string.
 *
 * @param  integer  $type
 * @return string
 */
if (!function_exists('get_packettype'))
{
	function get_packettype($type)
	{
		$types = array(
			'int8_t', 'int16_t', 'int32_t', 'int64_t', 'uint8_t', 'uint16_t', 'uint32_t', 'uint64_t', 'float', 'double', 'string'
		);
		$str = array_key_exists($type - 1, $types) ? $types[$type - 1] : '';
		return $str;
	}
}

/**
 * Format error str to html.
 *
 * @param  string  $str
 * @return string
 */
if (!function_exists('format_error'))
{
	function format_error($str)
	{
		return '<font color="red">' .$str. '</font>';
	}
}

/**
 * Convert the class name to file name.
 *
 * @param  string  $classname
 * @return string
 */
if (!function_exists('classname_tofilename')) 
{
	function classname_tofilename($classname)
	{
		$array = preg_split("/(?=[A-Z])/", $classname);
		array_shift($array);
		$filename = strtolower(implode('_', $array));
		return $filename;
	}
}

/**
 * Get packet header macro define.
 *
 * @param  string  $module
 * @param  string  $filename
 * @return string
 */
if (!function_exists('get_packetmacro'))
{
	function get_packetmacro($module, $filename)
	{
		$macro = strtoupper($module. '_' .$filename);
		return $macro;
	}
}

/**
 * Get packet module name.
 *
 * @param  string  $from
 * @param  string  $to
 * @param  bool	   $public
 * @param  string  $commonpath
 * @return string
 */
if (!function_exists('get_modulename'))
{
	function get_modulename($from, $to, $public = false, $commonpath = '')
	{
		$modulename = '';
		if (false === $public)
		{
			$modulename = $from. '_to' .$to;
		} 
		else
		{
			if ('' === $commonpath) return false;
			$modulename = $from.$to;
			if (!is_dir($commonpath.'/include/common/net/packet/'.$modulename))
			{
				if (is_dir($commonpath.'/include/common/net/packet/'.$to.$from))
				{
					$modulename = $to.$from;
				}
			}
		} 
		return $modulename;
	}
}

/**
 * Get packet id module name.
 *
 * @param  string  $from
 * @param  string  $to
 * @param  string  $commonpath
 * @return string
 */
if (!function_exists('get_id_modulename'))
{
	function get_id_modulename($from, $to, $commonpath = '')
	{
		$modulename = '';
		if ('' === $commonpath) return false;
		if (file_exists($commonpath.'/include/common/define/net/packet/id/' .$from.$to. '.h'))
		{
			$modulename = $from.$to;
		}
		elseif (file_exists($commonpath.'/include/common/define/net/packet/id/' .$to.$from. '.h'))
		{
			$modulename = $to.$from;
		}
		return $modulename;
	}
}

/**
 * Get header functions define.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_functions'))
{
	function get_functions(array $data = array())
	{
		$functions = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$functions .= 0 === $key ? '' : getspaces(3);
			$functions .= 'string' == $typestr ? 'const char *' : $typestr. ' ';
			$functions .= 'get_' .$val[1];
			$functions .= 'string' == $typestr ? '();' : '() const;';
			$functions .= LF;
			$functions .= getspaces(3);
			$functions .= 'void set_' .$val[1]. '(';
			$functions .= 'string' == $typestr ? 'const char *' : $typestr. ' ';
			$functions .= $val[1]. ');';
			$functions .= $key === $lastkey ? '' : LF;
		}
		return $functions;
	}
}

/**
 * Get header functions define.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_functions_implement'))
{
	function get_functions_implement($classname, array $data = array())
	{
		$str = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$str .= 'string' == $typestr ? 'const char *' : $typestr. ' ';
			$str .= $classname. '::get_' .$val[1];
			$str .= 'string' == $typestr ? '()' : '() const {';
			$str .= LF;
			$str .= getspaces(2).'return ' .$val[1]. '_;'.LF;
			$str .= '}'.LF;
			
			$str .= LF;
			
			$str .= 'void ' .$classname. '::set_' .$val[1]. '(';
			$str .= 'string' == $typestr ? 'const char *' : $typestr. ' ';
			$str .= $val[1]. ') {'.LF;
			$str .= getspaces(2);
			$str .= 'string' == $typestr ? 'pf_base::string::safecopy(' .$val[1]. '_, ' .$val[1]. ', sizeof(' .$val[1]. '_))' : '';
			$str .= 'string' == $typestr ? '' : $val[1]. '_ = ' .$val[1]. ';';
			$str .= LF;
			$str .= '}';
			$str .= $key === $lastkey ? '' : LF.LF;
		}
		return $str;
	}
}

/**
 * Get header variables define.
 *
 * @param  array  $data
 * @return string
 */
if (!function_exists('get_variables'))
{
	function get_variables(array $data = array())
	{
		$variables = '';
		$lastkey = array_lastkey($data);
		foreach ($data as $key => $val)
		{
			$typestr = get_packettype($val[0]);
			$variables .= 0 === $key ? '' : getspaces(3);
			$variables .= 'string' == $typestr ? 'char' : $typestr;
			$variables .= getspaces(1).$val[1]. '_';
			$variables .= array_key_exists(2, $val) ? '[' .$val[2]. '];' : ';';
			$variables .= $key === $lastkey ? '' : LF;
		}
		return $variables;
	}
}

/**
 * Set packet id to enum define file.
 *
 * @param  string  $data
 * @param  string  $module
 * @param  string  $id_module
 * @param  string  $commonpath
 * @return string
 */
if (!function_exists('set_packetid'))
{
	function set_packetid($classname, $module, $id_module, $commonpath)
	{
		if ('serverserver' == $id_module) return true;
		$enum_name = 'k' .$classname;
		$filepath = $commonpath. '/include/common/define/net/packet/id/' .$id_module. '.h';
		if (!file_exists($filepath)) return false;
		$content = file_get_contents($filepath);
		$content_array = explode(LF, $content);
		$enum_first = '  kFirst = ' .strtoupper($module). '_PACKETID_MIN,';
		$enum_max = '  kMax = ' .strtoupper($module). '_PACKETID_MAX,';
		$is_idexists = false;
		$enum_firstkey = array_search($enum_first, $content_array);
		$enum_maxkey = array_search($enum_max, $content_array);
		if (!$enum_firstkey || !$enum_maxkey) return false;
		$keys = array_keys($content_array, '  ' .$enum_name. ',');
		foreach ($keys as $key => $val)
		{
			if ($val > $enum_firstkey && $val < $enum_maxkey)
			{
				$is_idexists = true;
				break;
			}
		}
		if (true === $is_idexists) return true;
		$enum_lastkey = $enum_maxkey - 1;
		$content_array[$enum_lastkey] = getspaces(2).$enum_name. ','. LF.$content_array[$enum_lastkey];
		$content_new = implode(LF, $content_array);
		$result = file_put_contents($filepath, $content_new) !== false;
		return $result;
	}
}

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
			//the model is passed to the closure
			'action' => function($model)
			{
				//get all the items of this model and reorder them
				return $model->count;
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
		$datas = $data['data'];
		if (!is_validjson($datas)) {
			return '<font color="red">the field [data] not a valid json</font>';
		}
	},
	
	'editdata' => true,
	
	/**
	 * This is where you can define the model's custom actions
	 */
	'actions' => array(
		//Ordering an item up
		'generate_code' => array(
			'title' => 'Generate Code',
			'messages' => array(
				'active' => 'Generate ...',
				'success' => 'Generate code success',
				'error' => 'Generate code failed',
			),
			//the model is passed to the closure
			'action' => function($model) //模块，局部的则是选中的数据
			{
				date_default_timezone_set('PRC');
				
				$work = DB::table('base_paths')->where('name', 'WORK_PATH')->first();
				$common = DB::table('base_paths')->where('name', 'COMMON_PATH')->first();
				$from = DB::table('applications')->where('id', $model->from_id)->first();
				$to = DB::table('applications')->where('id', $model->to_id)->first();
				if (!$work || !$common) 
				{
					return format_error('packet work or common path not set.');
				}
				if (!is_dir($work->path) || !is_dir($common->path))
				{
					return format_error('packet work path or common path is not exists.');
				}
				if (!$from)
				{
					return format_error('packet from application name is null, id: ' .$model->from_id);
				}
				if (!$to)
				{
					return format_error('packet to application name is null, id: ' .$model->to_id);
				}
				if (!is_writable($work->path) || !is_writable($common->path)) 
				{
					return format_error('packet work path or common path can\'t write.');
				}
				if (!file_exists(base_path(). '/public/packages/frozennode/administrator/packet/template.h') ||
					!file_exists(base_path(). '/public/packages/frozennode/administrator/packet/template.cc'))
				{
					return format_error('the template file not exists!');
				}
				if (!is_validjson($model->data))
				{
					return format_error('the packet data not a valid json string');
				}
				
				$content_header = file_get_contents(base_path(). '/public/packages/frozennode/administrator/packet/template.h');
				$content_source = file_get_contents(base_path(). '/public/packages/frozennode/administrator/packet/template.cc');
				
				$data = json_decode($model->data);
				$filename = classname_tofilename($model->name);
				$date = date('Y/m/d H:i');
				$description = $model->description;
				$module = get_modulename($from->name, $to->name, 1 === $model->public, $common);
				if (!$module)
				{
					return format_error('can\'t get module name');
				}
				$classname = $model->name;
				$functions = get_functions($data);
				$variables = get_variables($data);
				$macro = get_packetmacro($module, $filename);
				$id_module = get_id_modulename($from->name, $to->name, $common->path);
				$construct_implement = get_construct_implement($data);
				$read_implement = get_read_implement($data);
				$write_implement = get_write_implement($data);
				$size_implement = get_size_implement($data);
				$maxsize_implement = get_maxsize_implement($data);
				$functions_implement = get_functions_implement($classname, $data);
				
				$headerfile = $common->path. '/include/common/net/packet/' .$module. '/' .$filename. '.h';
				$sourcefile = $common->path. '/src/net/packet/' .$module. '/' .$filename. '.cc';
				
				//get new content
				$content_header = str_replace('${filename}', $filename, $content_header);
				$content_header = str_replace('${date}', $date, $content_header);
				$content_header = str_replace('${description}', $description, $content_header);
				$content_header = str_replace('${macro}', $macro, $content_header);
				$content_header = str_replace('${module}', $module, $content_header);
				$content_header = str_replace('${classname}', $classname, $content_header);
				$content_header = str_replace('${functions}', $functions, $content_header);
				$content_header = str_replace('${variables}', $variables, $content_header);
				
				if (!touch($headerfile)) 
				{
					return 'packet header file can\'t touch';
				}
				if (false === file_put_contents($headerfile, $content_header))
				{
					return 'packet header file write fail.';
				}
				
				$content_source = str_replace('${id_module}', $id_module, $content_source);
				$content_source = str_replace('${filename}', $filename, $content_source);
				$content_source = str_replace('${module}', $module, $content_source);
				$content_source = str_replace('${classname}', $classname, $content_source);
				$content_source = str_replace('${construct_implement}', $construct_implement, $content_source);
				$content_source = str_replace('${read_implement}', $read_implement, $content_source);
				$content_source = str_replace('${write_implement}', $write_implement, $content_source);
				$content_source = str_replace('${size_implement}', $size_implement, $content_source);
				$content_source = str_replace('${maxsize_implement}', $maxsize_implement, $content_source);
				$content_source = str_replace('${functions_implement}', $functions_implement, $content_source);
				
				if (!touch($sourcefile))
				{
					return 'packet source file can\'t touch';
				}
				if (false === file_put_contents($sourcefile, $content_source))
				{
					return 'packet source file write fail.';
				}
				
				//permision the group write
				chmod($headerfile, 0664);
				chmod($sourcefile, 0664);
				
				if (false === set_packetid($classname, $module, $id_module, $common->path))
				{
					return format_error('can\'t set packet id.');
				}
				
				return true;
			}
		),
	
	),

);