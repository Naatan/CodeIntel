<?php

function get_instance() {
	global $CI;
	
	if ($CI == null)
		$CI = new codeintel;
		
	return $CI;
}

function show_error($message,$status_code=500) {
	$heading = 'Error Occured';
	
	require_once APPPATH . 'errors/error_general.php';
}

function log_message($level,$message) {
	static $config = null;
	
	if ($config == null)
		require APPPATH . 'config/logging' . EXT;
		
	$level = strtoupper($level);
	
	switch ($level) {
		case 'INFO':
			if ($config['log_level']!='INFO')
				return false;
			break;
		case 'DEBUG':
			if (!in_array($config['log_level'],array('INFO','DEBUG')))
				return false;
			break;
		case 'ERROR':
			if (!in_array($config['log_level'],array('INFO','DEBUG','ERROR')))
				return false;
			break;
		default:
			return false;
			break;
	}
	
	$path = APPPATH . $config['log_path'];
	if ( ! is_dir($path) OR ! is_writable($path))
		return false;
	
	$file = $path . $config['log_file'];
	$line = 	$level . $config['log_level_seperator'] .
				($config['log_prepend_microtime'] ? microtime()-STARTTIME . $config['log_level_seperator'] : '') .
				$config['log_line_prepend'] . $message . $config['log_line_append'];
	
	file_put_contents($file,$line,FILE_APPEND);
}

/**
 * Instantiate Class
 *
 * Returns a new class object by reference, used by load_class() and the DB class.
 * Required to retain PHP 4 compatibility and also not make PHP 5.3 cry.
 *
 * Use: $obj =& instantiate_class(new Foo());
 * 
 * @access	public
 * @param	object
 * @return	object
 */
function &instantiate_class(&$class_object)
{
	return $class_object;
}