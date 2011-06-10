<?php

namespace ci\sys\libs;

class load {
	
	private $libraries 	= array();
	private $views 		= array();
	private $models 	= array();
	
	private $db 		= null;
	
	private $upcoming_type = null;
	
	public function __construct() {
		// Can NOT use the get_instance() function in this constructor!
	}
	
	public function __get($name) {
		if ($this->upcoming_type==null OR !method_exists($this,$this->upcoming_type)) {
			return show_error('Trying to load non existant type: '.$this->upcoming_type);
		}
			
		$type = $this->upcoming_type;
		$this->upcoming_type = null;
			
		return call_user_func(array($this,$type),$name);
	}
	
	public function library($location) {
		return $this->load_file($location,'libraries','library');
	}
	
	public function model($location) {
		return $this->load_file($location,'models','model');
	}
	
	public function view($location) {
		return $this->load_file($location,'views','view');
	}
	
	public function db() {
		if ($this->db!=null)
			return $this->db;
		
		require_once BASEPATH . 'database/DB'.EXT;
		return DB();
	}
	
	private function load_file($location,$type,$type_singular) {
		$name = basename($location);
		
		if (isset($this->{$type}[$name]))
			return $this->{$type}[$name];
			
		$file 		= BASEPATH . $type.'/' . $location . EXT;
		$app_file 	= APPPATH . $type.'/' . $location . EXT;
		
		if (file_exists($app_file)) {
			if (file_exists($file))
				require_once $file;
			$file = $app_file;
			$class = '\\ci\\libs\\'.$name;
		} else if (file_exists($file))
			$class = '\\ci\\sys\\libs\\'.$name;
		else 
			return show_error("Could not find $type_singular file: ".$location);;
			
		require_once $file;
		
		if ( ! class_exists($class))
			return show_error("Could not load $type_singular: ".$name);
			
		$this->{$type}[$name] = new $class;
		
		if ( ! in_array($name,array('fb')))
			log_message('info',"Loaded $type_singular: $name");
		
		return $this->{$type}[$name];
	}
	
	public function set_upcoming_type($type) {
		$this->upcoming_type = $type;
	}
	
}