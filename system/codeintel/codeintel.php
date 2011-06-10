<?php

namespace ci\sys;

require_once BASEPATH . 'libraries/loader'.EXT;
require_once BASEPATH . 'helpers/base'.EXT;

class codeintel {
	
	public $load;
	
	public function __construct() {
		$this->load 	= new \ci\sys\libs\loader;
	}
	
	public function __get($name) {
		switch ($name) {
			case 'lib':
			case 'library':
				$this->load->set_upcoming_type('library');
				return $this->load;
				break;
			case 'view':
				$this->load->set_upcoming_type('view');
				return $this->load;
				break;
			case 'model':
				$this->load->set_upcoming_type('model');
				return $this->load;
				break;
			case 'config':
				$this->load->set_upcoming_type('config');
				return $this->load->config();
				break;
			case 'db':
				return $this->load->db();
				break;
			default:
				return $this->load;
				break;
		}
	}
	
}

global $CI;
$CI = new \ci\sys\codeintel;
log_message('info','codeintel initialized');

log_message('DEBUG','Test 123');
log_message('DEBUG','Test 123');

$CI->config->test();
$CI->config->test();