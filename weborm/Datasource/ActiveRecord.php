<?php

require_once("Datasource/Registry.php");

class ActiveRecord
{
	public function autoload_connection()
	{
		$registry = Registry::getInstance();
		$db = $registry->get("db");
		return $db;
	}
}

