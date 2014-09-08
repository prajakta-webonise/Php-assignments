<?php
require_once("Datasource/BaseClass.php");
require_once("Datasource/MysqlClass.php");
/**
*  registry maintains container of objects 
*/
class registry {
	private  $object = array();
	private static $instance= null;
	
	private function __construct() {
	}
    private function __clone() {
    }
	public static function getInstance() {
		if(self::$instance ===null){
			self::$instance = new registry();
		}
		return self::$instance;
	}
   /* Set method set the values of array*/
	public function set($key, $value) {
		if (isset($this->object[$key])) {
			throw new Exception("There is already an entry for key " . $key);
		}
		$this->object[$key] = $value;
	}

	public function get($key) {
		if (!isset($this->object[$key])) {
			throw new Exception("There is no entry for key " . $key);
		}
		return $this->object[$key];
	}
}

$bs = new baseClass();