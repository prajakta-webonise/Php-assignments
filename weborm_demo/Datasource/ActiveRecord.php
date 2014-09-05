<?php

require_once("Datasource/Registry.php");

class ActiveRecord
{
	public function autoloadConnection()
	{
		$registry = Registry::getInstance();
		$db = $registry->get("db");
		return $db;
	}
}

