<?php
	require_once("DbWrapper/AbstractClass.php");
    require_once("DbWrapper/DbInterface/SqlInterface.php");
	
	class mysqlClass extends abstractClass implements sqlInterface {
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
	
		/**
		* gives the foreign key based on table name and referenced table name
		*/
		public function getForeignKey($db,$table,$referencedTable) {
			$query = "SELECT kcu.REFERENCED_TABLE_NAME, kcu.COLUMN_NAME FROM information_schema.key_column_usage AS kcu
					INNER JOIN information_schema.referential_constraints AS rc ON ( kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME ) 
					WHERE kcu.TABLE_SCHEMA =  '".$db."' AND kcu.TABLE_NAME =  '".$table."' AND kcu.REFERENCED_TABLE_NAME = '".$referencedTable."'" ;
			$result = $this->query($query);
			$foreignKey=$result->fetch(PDO::FETCH_ASSOC);
			return $foreignKey["COLUMN_NAME"];
		}

		/**
		* gives the primary key based on table name
		*/
		public function getPrimaryKey($db,$table) {
			$query = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k 
					USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_schema='".$db."'
					AND t.table_name='".$table."'";
			$result = $this->query($query);
			$primaryKey=$result->fetch(PDO::FETCH_ASSOC);
			return $primaryKey["column_name"];  						
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
		/**
		* gives names of columns of specified table
		*/
		public function getTableColumns($table) {
			$query= $this::SHOW_TABLE_COLUMNS.' '.$table;
			$result = $this->query($query);
			$tableColumn=$result->fetchAll();
			foreach ($tableColumn as $row) {
				$tableColumns[]=$row["Field"];
			}
			return $tableColumns;
		}
	}
