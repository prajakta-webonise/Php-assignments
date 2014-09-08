<?php
	require_once("Datasource/DbInterface.php");
	require_once("Datasource/MySqlAbstract.php");
	
	class mysqlClass extends mysqlAbstract implements dbInterface {
		/**
		* database configuration array
		*/
		private $config;
		/**
		* source table name
		*/
		public $table=null;
		/**
		* columns to be selected
		*/
		public $columns=null;
		/**
		* order by clause
		*/
		public $orderBy=null;
		/**
		* group by clause
		*/
		public $groupBy=null;
		/**
		* having clause
		*/
		public $having=null;
		/**
		* show table columns to be used to search column names from table
		*/
		const SHOW_TABLE_COLUMNS = 'SHOW columns FROM';
		/**
		* select query
		*/
		const SELECT = 'SELECT';
		const FROM = 'FROM';
		/**
		* where clause
		*/
		const WHERE = 'WHERE';
		/**
		* group by clause
		*/
		const GROUP_BY = 'GROUP BY';
		/**
		* having clause
		*/
		const HAVING = 'HAVING';
		/**
		* order by clause
		*/
		const ORDER_BY = 'ORDER BY';
		/**
		* performs insert operation on database
		*/
		const INSERT_INTO = 'INSERT INTO';
		/**
		* specifies the values of columns in insert query
		*/
		const VALUES = 'VALUES';
		/**
		* UPDATE used to perform database update
		*/
		const UPDATE = 'UPDATE';
		/**
		* specifies set parameters in Update
		*/
		const SET = 'SET';
		/**
		* DELETE used to perform delete operations
		*/
		const DELETE = 'DELETE';
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
				$connectionString = 'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'];
				PDO::__construct($connectionString,$config['user'],$config['password']);
				$this->config=$config;
			}
			catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
				die();
			}
		}
		/**
		* sets source table name
		*/
		public function setSourceTable($table) {
			$this->table=$table;
		}
		/**
		* sets columns to be selected
		*/
		public function setColumns($columns) {
			$this->columns=$columns;
		}
		/**
		* sets order by clause
		*/
		public function setOrderBy($orderBy='')	{
			$this->orderBy=$orderBy;
		}
		/**
		* sets group by clause
		*/
		public function setGroupBy($groupBy='')	{
			$this->groupBy=$groupBy;
		}
		/**
		* sets having clause
		*/
		public function setHaving($having='') {
			$this->having=$having;
		}
		
		public function selectQuery($join='', $where='' ,$andOr='') {
			/**
			* gives the names of the column to be selected
			*/	
			$columnList = $this->getColumns($this->columns);
			if($where=='') {
				$query=$this::SELECT.' '.$columnList.' '.$this::FROM.' '.$this->table.' '.$join.' '.($this->groupBy? $this::GROUP_BY.' '.$this->groupBy:' ').' '.($this->having? $this::HAVING.' '.$this->having:' ').' '.($this->orderBy? $this::ORDER_BY.' '.$this->orderBy:' ');	
				return $this->executeQuery($query);
			}
			else {
				/**
				* key = :key format
				*/
				foreach ($where as $key => $value) {
					$whereParameters[] = $key." = :".$key;
				}
				if(count($where) == 1) {
					$condition=implode(" ",array_values($whereParameters));
					$query=$this::SELECT.' '.$columnList.' '.$this::FROM.' '.$this->table.' '.$this::WHERE.' '.$condition.' '.($this->groupBy? $this::GROUP_BY.' '.$this->groupBy:' ').' '.($this->orderBy? $this::ORDER_BY.' '.$this->orderBy:' ');
					return $this->executeBindParameters($query,$where);
				}
				else {
					$query=$this::SELECT.' '.$columnList.' '.$this::FROM.' '.$this->table.' '.$this::WHERE.' ';
					array_push($andOr, '');
					$combinedArray =array_combine($whereParameters, $andOr);
					foreach ($combinedArray as $key => $value) {
						$query .= $key.' '.$value.' ';
					}
					$query= $query.($this->groupBy? $this::GROUP_BY.' '.$this->groupBy:' ').' '.($this->orderBy? $this::ORDER_BY.' '.$this->orderBy:' ');
					return $result=$this->executeBindParameters($query,$where);
				}
			}
		}
		/**
		* performs database insert operation
		*/
		public function insert()	{
			$columnList=implode(', ',array_keys($this->columns));
			$columnValues=':'.implode(', :',array_keys($this->columns));
			$query=$this::INSERT_INTO.' '.$this->table." ( ".$columnList." ) ".$this::VALUES." ( ".$columnValues." ) ";
			
			/** 
			* creates a queryParameters array to bind parameters
			*/

			foreach ($this->columns as $key => $value) {
				$queryParameters[':'.$key] = $value;
			}
			
			try {
				$stmt = parent::prepare($query);
				return $result = $stmt->execute($queryParameters);
			}
			catch(PDOException $ex)  {
					echo 'Failed to run query'.$ex->getMessage();
			}
			
		}
		/**
		* performs database update operation
		*/
		public function update($where='') {
			foreach ($this->columns as $key => $value) {
				$fields .= "$key = :$key,";
			}
			$setParameters = rtrim($fields,",");
			$query=$this::UPDATE.' '.$this->table.' '.$this::SET.' '.$setParameters.' '.($where? $this::WHERE.' '.$where:' ');
			foreach ($this->columns as $key => $value) {
				$queryParameters[':'.$key] = $value;
			}
			$stmt = parent::prepare($query);
			return $result = $stmt->execute($queryParameters);
			
		}
		/**
		* performs database delete operation
		*/
		public function delete($where='') {
			$query=$this::DELETE.' '.$this::FROM.' '.$this->table.' '.($where? $this::WHERE.' '.$where:' ');	
			$stmt = parent::prepare($query);
			return $result= $stmt->execute();
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
		* gives the columns to be selected in select query
		*/
		public function getColumns($columns) {
			if($columns == "*") {
				$columnList=$columns;
			}
			else {
				foreach ($columns as $key => $value) {
					$columnAlias[$key]=$value." AS ".str_replace(".", "_", $value);
				}
				$columnList=implode(', ',array_values($columnAlias));
			}
			return $columnList;
		}
		/**
		* execute query
		*/
		public function executeQuery($query) {
			$stmt= parent::prepare($query);
			return ($stmt->execute()? $stmt->fetchAll(parent::FETCH_ASSOC): false);
		}
		/**
		* prepare statement
		*/
		public function executeBindParameters($query,$where) {
			foreach ($where as $key => $value) {
				$queryParameters[':'.$key] = $value;
			}
			$stmt= parent::prepare($query);
			return ($stmt->execute($queryParameters)? $stmt->fetchAll(parent::FETCH_ASSOC): false);
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
