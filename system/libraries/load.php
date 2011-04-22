<?php

class load {
	
	private $libraries 	= array();
	private $views 		= array();
	private $models 	= array();
	
	private $db 		= null;
	
	private $upcoming_type = null; // default to library
	
	public function __construct() {
	}
	
	public function __get($name) {
		if ($this->upcoming_type==null OR !method_exists($this,$this->upcoming_type))
			return show_error('Trying to load non existant type: '.$this->upcoming_type);
			
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
		
		require_once BASEPATH . 'database/DB.php';
		return DB();
	}
	
	private function load_file($location,$type,$type_singular) {
		$name = basename($location);
		$class = '\libraries\\'.$name;
		
		if (isset($this->{$type}[$name]))
			return $this->{$type}[$name];
		
		if ( ! file_exists($file = BASEPATH . $type.'/' . $location . EXT))
			$file = APPPATH . $type.'/' . $location . EXT;
			
		if ( ! file_exists($file))
			return show_error("Could not find $type_singular file: ".$location);
			
		require_once $file;
		
		if ( ! class_exists($class))
			return show_error("Could not load $type_singular: ".$name);
			
		$this->{$type}[$name] = new $class;
		$this->$name =& $this->{$type}[$name]; // provide compatiblity with CodeIgniter apps
		
		log_message('info',"Loaded $type_singular: $name");
		
		return $this->{$type}[$name];
	}
	
	public function set_upcoming_type($type) {
		$this->upcoming_type = $type;
	}
	
}