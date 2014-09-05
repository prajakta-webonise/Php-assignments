<?php

abstract class MysqlAbstract extends PDO
{
	abstract public function getTableColumns($table);

	
}
