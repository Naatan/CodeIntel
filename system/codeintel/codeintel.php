<?php

require_once BASEPATH . 'libraries/load.php';
require_once BASEPATH . 'helpers/base.php';

class codeintel {
	
	public $load;
	public $config;
	public $input;
	
	public function __construct() {
		log_message('info','codeintel initialized');
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
			case 'db':
				return $this->load->db();
				break;
			default:
				return $this->load;
				break;
		}
	}
	
	public function init() {
		$this->load 	= new load;
	}
	
}

$CI = get_instance();
$CI->init();

$r = $CI->db->query("SELECT * FROM user_profiles");
var_dump($r->result());