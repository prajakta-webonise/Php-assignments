<?php
require_once("DbWrapper/AbstractClass.php");
require_once("DbWrapper/DbInterface/SqlInterface.php");
class pgsqlClass extends abstractClass implements sqlInterface {
	/**
		* database configuration array
		*/
		private $config;
		
		/**
		* show table columns to be used to search column names from table
		*/
		const SHOW_TABLE_COLUMNS = 'SHOW columns FROM';
		
		/**
		* specifies type of join to be inner join
		*/
		const INNER_JOIN = 'INNER JOIN';
		/**
		* specifies type of join to be left join
		*/
		const LEFT_JOIN = 'LEFT JOIN';
		/**
		* specifies type of join to be right join
		*/
		const RIGHT_JOIN = 'RIGHT JOIN';
		public function __construct($config) {
			try { 
					$connectionString = $config['datasource'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'];
					PDO::__construct($connectionString,$config['user'],$config['password']);
					
					abstractClass::__construct($config);
					$this->config=$config;
					//$this->autoloadCon();
				}
				catch (PDOException $e) {
					echo 'Connection failed: ' . $e->getMessage();
					die();
				}
			
		}
	
	public function getPrimaryKey($db,$table) {
		$query = "SELECT pg_attribute.attname as column_name, format_type(pg_attribute.atttypid, pg_attribute.atttypmod) 
				FROM pg_index, pg_class, pg_attribute WHERE pg_class.oid = '".$table."'::regclass AND
					indrelid = pg_class.oid AND pg_attribute.attrelid = pg_class.oid AND pg_attribute.attnum = any(pg_index.indkey)
					AND indisprimary";
		$result = $this->query($query);
		$primaryKey=$result->fetch(PDO::FETCH_ASSOC);
		return $primaryKey["column_name"];  						
	}
	public function getForeignKey($db,$table,$referencedTable) {
		$query = "SELECT tc.constraint_name, tc.table_name, kcu.column_name, ccu.table_name AS foreign_table_name,
    			ccu.column_name AS foreign_column_name FROM information_schema.table_constraints AS tc JOIN 
    			information_schema.key_column_usage AS kcu  ON tc.constraint_name = kcu.constraint_name
    			JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name
				WHERE constraint_type = 'FOREIGN KEY' AND tc.table_name='".$table."' AND ccu.table_name = '".$referencedTable."'" ;
		$result = $this->query($query);
		$foreignKey=$result->fetch(PDO::FETCH_ASSOC);
		return $foreignKey["COLUMN_NAME"];
	}
	/**
	* prepare join query based on join type for one to one association
	*/
	public function oneToOne($table,$targetTable,$joinType) {
		$sourceTable=$table;
		$primaryKey=$this->getPrimaryKey($this->config['database'],$sourceTable);
		switch($joinType) {
			case 'inner': $join = ' '.$this::INNER_JOIN.' ';
						break;
			case 'left': $join = ' '.$this::LEFT_JOIN.' ';
						break;
			case 'right': $join = ' '.$this::RIGHT_JOIN.' ';
						break;
			default: $join = ' '.$this::INNER_JOIN.' ';					
		}
		foreach ($targetTable as $key => $value) {
				$foreignKey=$this->getForeignKey($this->config['database'],$value,$sourceTable);
				$query.= $join.$value." ON ". $sourceTable.".".$primaryKey." = ".$value.".".$foreignKey;	
				$sourceTable=$value;
		}
		return $query;
	}
	/**
	* prepare join query based on join type for one to many association
	*/
	public function oneToMany($table,$targetTable,$joinType) {
		$sourceTable=$table;
		$primaryKey=$this->getPrimaryKey($this->config['database'],$sourceTable);
		switch($joinType) {
			case 'inner': $join = ' '.$this::INNER_JOIN.' ';
						break;
			case 'left': $join = ' '.$this::LEFT_JOIN.' ';
						break;
			case 'right': $join = ' '.$this::RIGHT_JOIN.' ';
						break;
			default: $join = ' '.$this::INNER_JOIN.' ';					
		}
		foreach ($targetTable as $key => $value) {
				$foreignkey=$this->getForeignKey($this->config['database'],$value,$sourceTable);
				$query.= $join.$value." ON ". $sourceTable.".".$primaryKey." = ".$value.".".$foreignKey;	
				$sourceTable=$value;
		}
		return $query;
	}
	/**
	* prepare join query based on join type for many to one association
	*/
	public function manyToOne($table,$targetTable,$joinType) {
		$sourceTable=$table;
		switch($joinType) {
			case 'inner': $join = ' '.$this::INNER_JOIN.' ';
						break;
			case 'left': $join = ' '.$this::LEFT_JOIN.' ';
						break;
			case 'right': $join = ' '.$this::RIGHT_JOIN.' ';
						break;
			default: $join = ' '.$this::INNER_JOIN.' ';					
		}
		foreach ($targetTable as $key => $value) {
				$foreignKey=$this->getForeignKey($this->config['database'],$sourceTable,$value);
				$primaryKey=$this->getPrimaryKey($this->config['database'],$value);
				$query.= $join.$value." ON ". $sourceTable.".".$foreignKey." = ".$value.".".$primaryKey;	
				$sourceTable=$value;
		}
		return $query;
	}
	/**
	* prepare join query based on join type for many to many association
	*/
	public function manyToMany($table,$joinTable,$targetTable,$joinType) {
		$sourceTable=$table;
		$primaryKey=$this->getPrimaryKey($this->config['database'],$sourceTable);
		switch($joinType) {
			case 'inner': $join = ' '.$this::INNER_JOIN.' ';
						break;
			case 'left': $join = ' '.$this::LEFT_JOIN.' ';
						break;
			case 'right': $join = ' '.$this::RIGHT_JOIN.' ';
						break;
			default: $join = ' '.$this::INNER_JOIN.' ';					
		}
		foreach ($joinTable as $key => $value) {
			$joinTables[$value]=$value;
		} 
		$foreignKey=$this->getForeignKey($this->config['database'],$joinTables[$value]);
	}
	public function getTableColumns($table) {
		$query= "select column_name from information_schema.columns where
				table_name= '".$table."'";
		
		$result = $this->query($query);
		$tableColumn=$result->fetchAll();
		foreach ($tableColumn as $row) {
			$tableColumns[]=$row["column_name"];

		}
		return $tableColumns;
	}
	
}
