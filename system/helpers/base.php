<?php

function get_instance() {
	global $CI;
	return $CI;
}

function show_error($message,$status_code=500) {
	$heading = 'Error Occured';
	
	require_once APPPATH . 'errors/error_general'.EXT;
}

function log_message($level,$message) {
	static $config = null;
	
	$CI =& get_instance();
	
	if ($config == null)
		require APPPATH . 'config/logging' . EXT;
		
	$level = strtoupper($level);
	
	if ( ! in_array($level,$config['log_filter']))
		return false;
	
	if ($CI!==null) {
		switch ($level) {
			case 'INFO':
				$CI->lib->fb->info($message);
				break;
			case 'WARNING':
				$CI->lib->fb->warn($message);
				break;
			case 'ERROR':
				$CI->lib->fb->error($message);
				break;
			default:
				$CI->lib->fb->log($level . ': ' .$message);
				break;
		}
	}
	
	$path = APPPATH . $config['log_path'];
	if ( ! is_dir($path) OR ! is_writable($path))
		return false;
	
	$file = $path . $config['log_file'];
	$line = $level . $config['log_level_seperator'] .
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