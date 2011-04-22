<?php

	define('STARTTIME',microtime());

	/* Enable error reporting, the framework will handle the exceptions */
	error_reporting(E_ALL);

	/* Set app and system folders */
	$system_folder = "system";
	$application_folder = "application";

	/* Framework constants */
	define('EXT', '.php');
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FCPATH', str_replace(SELF, '', __FILE__));
	define('BASEPATH', is_dir($system_folder) ? $system_folder.'/' : dirname(__FILE__).'/'.$system_folder.'/');
	define('APPPATH', is_dir($application_folder) ? $application_folder.'/' : FCPATH.$application_folder.'/');

	/* Load the main controller */
	require_once BASEPATH.'codeintel/codeintel'.EXT;