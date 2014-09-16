<?php
	
	require_once("databaseConfig.php");
	require_once("Factory/Factory.php");

	/** 
	*	Based on datasource in default array the set
	* 	method of registry class is called to create 
	*	object of database
	*/

	class baseClass {
         public $databases=null;
		 public function __construct() {
		   $ds = new databaseConfig();
		   $this->databases = factory::selectDb($ds->default);

		 }

    }
?>