<?php
	require_once("Datasource/Registry.php");
	/* get database object by calling the get method of registry class */
	class activeRecord {
		public function autoloadConnection() {
			$registry = registry::getInstance();
			$db = $registry->get("db");
			return $db;
		}
	}

