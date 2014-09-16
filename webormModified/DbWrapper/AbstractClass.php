<?php
	require_once("Registry/Registry.php");
	abstract class abstractClass extends PDO {
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
		
		public function __construct($config) {
			
		}
		/* get table columns from database */
		abstract public function getTableColumns($table);
		abstract public function oneToOne($table,$targetTable,$joinType);
		abstract public function oneToMany($table,$targetTable,$joinType);
		abstract public function manyToOne($table,$targetTable,$joinType);
		abstract public function manyToMany($table,$joinTable,$targetTable,$joinType);
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
		
		
		
	}
