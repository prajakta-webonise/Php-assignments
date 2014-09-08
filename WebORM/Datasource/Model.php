
<?php
	require_once("Datasource/Registry.php");
	require_once("Datasource/ActiveRecord.php");

	class model extends activeRecord {
		/**
		* $condition array specifies the conditional parameters
		* such as where condition, group by clause, having clause
		*/
		protected $condition=null;
		/** 
		* Represents one to one relationship between source table
		* and target table, by specifying target table name,
		* join type and conditions for join
		*/
		protected $oneToOne=null;
		/** 
		* Represents one to many relationship between source table
		* and target table, by specifying target table name,
		* join type and conditions for join
		*/
		protected $oneToMany=null;
		/** 
		* Represents many to one relationship between source table
		* and target table, by specifying target table name,
		* join type and conditions for join
		*/
		protected $manyToOne=null;
		/** 
		* Represents many to many relationship between source table
		* and target table, by specifying target table name, join table
		* join type and conditions for join
		*/
		protected $manyToMany=null;
		
		
		/** 
		* saves the data using insert function, by passing table name
		* where to save data and columns to be saved
		*/
		public function save() {
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$db->setSourceTable($table);
			$columns=array_flip(get_object_vars($this));
			$tableColumns=$db->getTableColumns($table);
			$columns=array_intersect($columns, $tableColumns);
			$columns=array_flip($columns);
			$db->setColumns($columns);
			return $result = $db->insert();
		}
		/** 
		* modify data based on table name and columns which are to be 
		* modified. Uses update function to perform database updation
		*/
		public function modify() {
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$db->setSourceTable($table);
			$columns=array_flip(get_object_vars($this));
			$tableColumns=$db->getTableColumns($table);
			$columns=array_intersect($columns, $tableColumns);
			$columns=array_flip($columns);
			$db->setColumns($columns);
			$where= 'id = '.$columns["id"];
			return $result = $db->update($where);
		}
		/**
		* remove data based on table name and condition specified.
		* Uses delete function to perform database deletion
		*/
		public function remove() {
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$db->setSourceTable($table);
			$where= 'id = '.$columns["id"];
			return $result = $db->delete($where);
		}
		/**
		* searches database for finding required data based on conditions
		* and association specified. Uses selectQuery function to perform 
		* search operation on database
		*/
		public function search() {
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$db->setSourceTable($table);

			/**
			* checks the relationship defined based on  values oneToOne, 
			* oneToMany, manyToOne and manyToMany arrays
			*/
			if(isset($this->oneToOne)) {
				/* specifies the type of join and join parameters */
				$join=$this->oneToOneJoin();
				/* default select all columns otherwise select specified columns */
				if(isset($this->oneToOne["columns"])) {
					$columns = $this->oneToOne["columns"];
				}
				else {
					$columns = "*";
				}
				$db->setColumns($columns);
				$orderBy=$this->oneToOne["order_by"];
				$db->setOrderBy($orderBy);
				$groupBy=$this->oneToOne["group_by"];
				$db->setGroupBy($groupBy);
				$result= $db->selectQuery($join='',$where,$andOr);
				return ($result? $result : false);
			}
			if(isset($this->oneToMany)) {
				/* specifies the type of join and join parameters */
				$join=$this->oneToManyJoin();
				/* default select all columns otherwise select specified columns */
				if(isset($this->oneToMany["columns"])) {
					$columns = $this->oneToMany["columns"];
				}
				else {
					$columns = "*";
				}
				$db->setColumns($columns);
				$orderBy=$this->oneToMany["order_by"];
				$db->setOrderBy($orderBy);
				$groupBy=$this->oneToMany["group_by"];
				$db->setGroupBy($groupBy);
				$result= $db->selectQuery($join='',$where,$andOr);
				return ($result? $result : false);
			}
			if(isset($this->manyToOne)) {
				/* specifies the type of join and join parameters */
				$join=$this->manyToOneJoin();
				/* default select all columns otherwise select specified columns */
				if(isset($this->manyToOne["columns"])) {
					$columns = $this->manyToOne["columns"];
				}
				else {
					$columns = "*";
				}
				$db->setColumns($columns);
				$orderBy=$this->manyToOne["order_by"];
				$db->setOrderBy($orderBy);
				$groupBy=$this->manyToOne["group_by"];
				$db->setGroupBy($groupBy);
				$result= $db->selectQuery($join='',$where,$andOr);
				return ($result? $result : false);
			}
			if(isset($this->manyToMany)) {
				/* specifies the type of join and join parameters */
				$join=$this->manyToManyJoin();
				/* default select all columns otherwise select specified columns */
				if(isset($this->manyToOne["columns"])) {
					$columns = $this->manyToOne["columns"];
				}
				else {
					$columns = "*";
				}
				$db->setColumns($columns);
				$orderBy=$this->manyToOne["order_by"];
				$db->setOrderBy($orderBy);
				$groupBy=$this->manyToOne["group_by"];
				$db->setGroupBy($groupBy);
				$result= $db->selectQuery($join='',$where,$andOr);
				return ($result? $result : false);
			}

			if(!isset($this->oneToMany) && !isset($this->manyToOne) && !isset($this->oneToOne) && !isset($this->manyToMany)) {	
				$result= $this->whereCondition();
				return $result;
			}
		}
		/** 
		* where parameters 
		*/
		public function whereCondition() {
			try {
				$db=$this->autoloadConnection();
			}
			catch (Exception $e) {
				echo 'Database object not found: ' . $e->getMessage();
			}
			$table=get_class($this);
			$db->setSourceTable($table);
			if(isset($this->condition["having"])){
				if(isset($this->condition["columns"])){
					$having=$this->condition["having"];
					foreach ($columns=$this->condition["columns"] as $key => $value){
						if($having["column"]==$value){
							$columns[$key]=$having["aggregate_function"].'( '.$value.' )';
							$having=$having["aggregate_function"].'('.$value.')';
						}
					}
				}
				else{
					$columns = "*";		
				}
			}
			else{
				$having='';
				if(isset($this->condition["columns"])){
					$columns = $this->condition["columns"];
				}
				else{
					$columns = "*";
				}
			}
			$db->setColumns($columns);
			$where = $this->condition["where"];
			$andOr=$this->condition["and_or"];
			$orderBy=$this->condition["order_by"];
			$db->setOrderBy($orderBy);
			$groupBy=$this->condition["group_by"];
			$db->setGroupBy($groupBy);
			$db->setHaving($having);
			$result= $db->selectQuery($join='',$where,$andOr);
			return ($result? $result : false);
		}
		/**
		* specifies join type, target table to join with for one to one association
		*/
		public function oneToOneJoin() {
				
				$db=$this->autoloadConnection();
				$table=get_class($this);
				$targetTable=$this->oneToOne["target_table"];
				$joinType=$this->oneToOne["join_type"];
				$join=$db->oneToOne($table,$targetTable,$joinType);
				return $join;
		}
		/**
		* specifies join type, target table to join with for one to many association
		*/
		public function oneToManyJoin() {
				$db=$this->autoloadConnection();
				$table=get_class($this);
				$targetTable=$this->oneToMany["target_table"];
				$joinType=$this->oneToMany["join_type"];
				$join=$db->oneToMany($table,$targetTable,$joinType);
				return $join;
		}
		/**
		* specifies join type, target table to join with for many to one association
		*/
		public function manyToOneJoin() {
				$db=$this->autoloadConnection();
				$table=get_class($this);
				$targetTable=$this->manyToOne["target_table"];
				$joinType=$this->manyToOne["join_type"];
				$join=$db->manyToOne($table,$targetTable,$joinType);
				return $join;
		}
		/**
		* specifies join type, target table to join with for many to many association
		*/
		public function manyToManyJoin() {
				$db=$this->autoloadConnection();
				$table=get_class($this);
				$targetTable=$this->manyToMany["target_table"];
				$joinTable=$this->manyToMany["join_table"];
				$joinType=$this->manyToMany["join_type"];
				$join=$db->manyToMany($table,$joinTable,$targetTable,$joinType);
				return $join;
		}
		
	}


?>