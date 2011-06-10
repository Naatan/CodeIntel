<?php

/* ERROR > WARNING > DEBUG > INFO */
$config['log_filter']			= array('INFO','DEBUG','WARNING','ERROR');

/* Relative to the Application path */
$config['log_path']				= 'logs/';

/* Log filename */
$config['log_file']				= date('y-m-d').'.log';

/* Prepend to each log line */
$config['log_line_prepend']		= date('y-m-d H:i:s') . ' --> ';

/* append to the end of each line (line seperator?) */

$config['log_line_append']	= "\n";

/* Seperator between level and line prepend */

$config['log_level_seperator']	= ' - ';

/* Prepend microtime (added after the level and before the line prepend */
$config['log_prepend_microtime']	= true;