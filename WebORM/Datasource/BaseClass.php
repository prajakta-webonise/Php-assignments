<?php
	require_once("Datasource/DbInterface.php");
	require_once("config/database.php");
	require_once("Datasource/Registry.php");

	/** 
	*	Based on datasource in default array the set
	* 	method of registry class is called to create 
	*	object of database
	*/
	class baseClass {
		public function __construct() {
			$ds = new databaseConfig();
			/* according to driver appropriate database is selected */
			switch($ds->default['datasource']) {
				case "mysql": $this->mysql($ds->default);
							  break;	  
				case "pgsql": $this->pgsql($ds->default);							
							  break;
				default: echo'Unable to Load the Driver';
			}
		}
		public static function  mysql($config) {
			require_once("Datasource/MysqlClass.php");
			/* get instance of registry and create object of mysql database */
			$registry = registry::getInstance();
			$registry->set("db",new mysqlClass($config));
		}
		public static function  pgsql($config) {
			require_once("Datasource/PgsqlClass.php");
			/* get instance of registry and create object of postgresql database */
			$registry = registry::getInstance();
			$registry->set("db",new pgsqlClass($config));
		}
	}
?>