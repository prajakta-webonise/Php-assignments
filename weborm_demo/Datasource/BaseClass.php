<?php
require_once("Datasource/DBInterface.php");
require_once("config/database.php");
require_once("Datasource/Registry.php");

class BaseClass {
			
	public function __construct()
	{
		$ds = new DATABASE_CONFIG();
		
		switch($ds->default['datasource'])
		{
			case "Mysql": $this->Mysql($ds->default);
						  break;	  
			case "Pgsql": $this->Pgsql($ds->default);							
						  break;
			default: echo'Unable to Load the Driver';
		}
	}

	public static function  Mysql($config)
	{
		require_once("Datasource/MysqlClass.php");
		$registry = Registry::getInstance();
		$registry->set("db",new MysqlClass($config));

	}
	public static function  Pgsql($config)
	{
		require_once("Datasource/PgsqlClass.php");
		$registry = Registry::getInstance();
		$registry->set("db",new PgsqlClass($config));
		
	}
}
?>