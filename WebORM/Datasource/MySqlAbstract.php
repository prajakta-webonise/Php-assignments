<?php
	abstract class mysqlAbstract extends PDO {
		/* get table columns from database */
		abstract public function getTableColumns($table);
	}
