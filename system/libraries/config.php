<?php

namespace ci\sys\libs;

class config {
	
	private $config = array();
	private $active = array();
	
	public function __get($name) {
		return $this->load($name,false,true);
	}
	
	public function load($file,$assoc=false,$suppress=false) {
		
		$key = sha1($file);
		
		if (isset($this->config[$key]))
			return $this->config[$key];
		
		if (in_array(substr($file,0,1),array('.','/'))) {
			if ($suppress) return false;
			return show_error('Invalid config file path: '.$file);
		}
		
		$app_file 	= APPPATH . 'config/' . $file . EXT;
		
		if ( ! file_exists($app_file)) {
			if ($suppress) return false;
			return show_error("Could not find config file: ".$file);
		}
			
		include $app_file;
		
		if ( ! isset($config))
			return show_error("Could not load config: ".$file);
			
		$this->config[$key] = (object) $config;
		$this->active = (object) array_merge( (array) $this->active, (array) $config);
		
		log_message('info',"Loaded config: $file");
		
		return $this->config[$key];
		
	}
	
	public function item($item, $file=null) {
		if ($file!=null)
			$this->load($file);
			
		if ( ! isset($this->active->{$item}))
			return false;
		
		return $this->active->{$item};
	}
	
}

?>