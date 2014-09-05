<?php

require_once("Datasource/DBInterface.php");
require_once("Datasource/MySqlAbstract.php");

class MysqlClass extends MySqlAbstract implements DBInterface
{
	private $config;
	public function __construct($config)
	{
		try {
			  $connection_string =	'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'];
			  PDO::__construct($connection_string,$config['user'],$config['password']);
			  $this->config=$config;
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}
	public function select($table,$columns)
	{
		//$column_list=implode(', ',array_keys($columns));
		$query="SELECT ".$columns." FROM ".$table;
		echo 'query'.$query;
		$stmt= parent::prepare($query);
		if($stmt->execute())
		{
			$result = $stmt->fetchAll(parent::FETCH_ASSOC);
			return $result;
		}
		else
		{
			return 'false';
		}
	}
	public function selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy)
	{
		
		$column_list = $this->get_columns($columns);
		
		if($where=='')
		{
			$query="SELECT ".$column_list." FROM ".$table.$join.($groupBy? ' GROUP BY '.$groupBy:' ').($having? ' HAVING '.$having:' ').($orderBy? ' ORDER BY '.$orderBy:' ');	
			echo 'q'.$query;
			return $this->executeQuery($query);
		}
		else
		{
			//name = :name format
			foreach ($where as $key => $value) {
				$where_para[] = $key." = :".$key;
			}
			
			if(count($where) == 1)
			{
				$condition=implode(" ",array_values($where_para));
				$query="SELECT ".$column_list." FROM ".$table." WHERE ".$condition.($groupBy? ' GROUP BY '.$groupBy:' ').($orderBy? ' ORDER BY '.$orderBy:' ');
				echo $query;
				return $this->execute_bind_parameters($query,$where);

				
			}
			else
			{
				
				$query="SELECT ".$column_list." FROM ".$table." WHERE ";
				array_push($and_or, '');
				$combined_array =array_combine($where_para, $and_or);
				foreach ($combined_array as $key => $value) {
					$query .= $key.' '.$value.' ';
				}
				$query= $query.($groupBy? ' GROUP BY '.$groupBy:' ').($orderBy? ' ORDER BY '.$orderBy:' ');
				return $result=$this->execute_bind_parameters($query,$where);
				

			}
		}
		
		
	}
	public function select_by_join($table,$columns,$where,$and_or)
	{
		/*if($r)
		{
			$fk = $this->getForeignKey($this->config['database'],$table);
		}*/
		// name = :name
		echo 'hi'.$where;
		foreach ($where as $key => $value) {
			$whr[$key] = $key." = :".$key;
		}
		//var_dump($whr);
		$and_or=implode(', ',array_values($and_or));
		
		$condition=implode(" $and_or ",array_values($whr));
		echo $condition;
		$column_list=implode(', ',array_keys($columns));
		$query="SELECT ".$column_list." FROM ".$table." WHERE ".$condition;
		foreach ($where as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		//var_dump($query_params);
		$stmt= parent::prepare($query);
		//var_dump($stmt);
		if($stmt->execute($query_params))
		{
			$result = $stmt->fetchAll(parent::FETCH_ASSOC);
			return $result;
		}
		else
		{
			return false;
		}
	}
	public function select_by_id($table,$columns,$where)
	{
		
		$column_list=implode(', ',array_keys($columns));
		$query="SELECT ".$column_list." FROM ".$table." WHERE id = ".$where;
		$stmt= parent::prepare($query);
		if($stmt->execute())
		{
			$result = $stmt->fetch(parent::FETCH_ASSOC);
			return $result;
		}
		else
		{
			return 'false';
		}
	}
	public function insert($table,$columns)
	{
		
		//var_dump(columns);

		$column_list=implode(', ',array_keys($columns));
		
		$column_values=':'.implode(', :',array_keys($columns));
		
		$query="INSERT INTO " .$table." ( ".$column_list." ) VALUES ( ".$column_values." )";
		
		//creates a $query_array to bind parameters
		foreach ($columns as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		
		
		$stmt = parent::prepare($query);
		
		if ($stmt->execute($query_params))
    	{
       		return true;
    	}	
    	else
    	{
    		return false;
    	}
		

	}
	public function update($table,$columns,$where='')
	{
		//$columns=array_flip($column);
		foreach ($columns as $key => $value) {
			$fields .= "$key = :$key,";
		}
		$set_params = rtrim($fields,",");
		
		$query="UPDATE ".$table." SET ".$set_params.($where? ' WHERE '.$where:' ');
		foreach ($columns as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		$stmt = parent::prepare($query);
		if ($stmt->execute($query_params))
		{
			return true;
	    	}	
	    	else
	    	{
	    		return false;
	    	}
	}
	public function delete($table,$where='')
	{
		$column_list=implode(', ',array_keys($columns));
		$query="DELETE FROM ".$table.($where? " WHERE ".$where:' ');	
		$stmt = parent::prepare($query);
		if ($stmt->execute())
	 	{
	       		return true;;
	    	}	
	    	else
	    	{
	    		return false;
	    	}
	}
	
	public function getForeignKey($db,$table,$referencedTable)
	{
		$query = "SELECT kcu.REFERENCED_TABLE_NAME, kcu.COLUMN_NAME FROM information_schema.key_column_usage AS kcu
						INNER JOIN information_schema.referential_constraints AS rc ON ( kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME ) 
						WHERE kcu.TABLE_SCHEMA =  '".$db."'
						AND kcu.TABLE_NAME =  '".$table."' AND kcu.REFERENCED_TABLE_NAME = '".$referencedTable."'" ;
		$result = $this->query($query);
		$foreign_key=$result->fetch(PDO::FETCH_ASSOC);
		return $foreign_key["COLUMN_NAME"];
		
	}

	
	public function getPrimaryKey($db,$table)
	{
		$query = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k 
						 USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_schema='".$db."'
  						 AND t.table_name='".$table."'";
		$result = $this->query($query);
		$primary_key=$result->fetch(PDO::FETCH_ASSOC);
		return $primary_key["column_name"];  						
	}
	public function get_columns($columns)
	{
		if($columns == "*")
		{
			$column_list=$columns;
		}
		else
		{
			foreach ($columns as $key => $value) {
				$columnAlias[$key]=$value." AS ".str_replace(".", "_", $value);
			}
			$column_list=implode(', ',array_values($columnAlias));

		}
				
		return $column_list;
	}
	public function executeQuery($query)
	{
		
		$stmt= parent::prepare($query);
		if($stmt->execute())
		{
			
			$result = $stmt->fetchAll(parent::FETCH_ASSOC);
			return $result;
		}
		else
		{
			return false;
		}
	}
	public function execute_bind_parameters($query,$where)
	{
		foreach ($where as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		$stmt= parent::prepare($query);
		if($stmt->execute($query_params))
		{
			$result = $stmt->fetchAll(parent::FETCH_ASSOC);
			return $result;
		}
		else
		{
			return false;
		}

	}
	public function oneToOne($table,$target_table,$join_type)
	{
		$source_table=$table;
		$primary_key=$this->getPrimaryKey($this->config['database'],$source_table);

		switch($join_type)
		{
			case 'inner': $join = " INNER JOIN ";
						  break;
			case 'left': $join = " LEFT JOIN ";
						  break;
			case 'right': $join = " RIGHT JOIN ";
						  break;
			default: $join = " INNER JOIN ";					
		}
		echo "</br>join type: ".$join;
		foreach ($target_table as $key => $value) {
				
				$foreign_key=$this->getForeignKey($this->config['database'],$value,$source_table);
				
				$query.= $join.$value." ON ". $source_table.".".$primary_key." = ".$value.".".$foreign_key;	
				$source_table=$value;
				
				//$primary_key=$this->getPrimaryKey($this->config['database'],$value);
		}
		
		return $query;
		
	}
	public function oneToMany($table,$target_table,$join_type)
	{
		$source_table=$table;
		$primary_key=$this->getPrimaryKey($this->config['database'],$source_table);
		
		switch($join_type)
		{
			case 'inner': $join = " INNER JOIN ";
						  break;
			case 'left': $join = " LEFT JOIN ";
						  break;
			case 'right': $join = " RIGHT JOIN ";
						  break;
			default: $join = " INNER JOIN ";					
		}
		
		foreach ($target_table as $key => $value) {
				
				$foreign_key=$this->getForeignKey($this->config['database'],$value,$source_table);
				$query.= $join.$value." ON ". $source_table.".".$primary_key." = ".$value.".".$foreign_key;	
				$source_table=$value;
								
		}
		
		return $query;
		
	}
	public function manyToOne($table,$target_table,$join_type)
	{
		$source_table=$table;
		//$foreign_key=$this->getForeignKey($this->config['database'],$source_table);
		switch($join_type)
		{
			case 'inner': $join = " INNER JOIN ";
						  break;
			case 'left': $join = " LEFT JOIN ";
						  break;
			case 'right': $join = " RIGHT JOIN ";
						  break;
			default: $join = " INNER JOIN ";					
		}
		
		foreach ($target_table as $key => $value) {
				$foreign_key=$this->getForeignKey($this->config['database'],$source_table,$value);
				$primary_key=$this->getPrimaryKey($this->config['database'],$value);
				$query.= $join.$value." ON ". $source_table.".".$foreign_key." = ".$value.".".$primary_key;	
				$source_table=$value;
				//$foreign_key=$this->getForeignKey($this->config['database'],$source_table);
		}
		
		return $query;
		
	}
	
	public function manyToMany($table,$joinTable,$targetTable,$joinType)
	{
		$sourceTable=$table;
		$primaryKey=$this->getPrimaryKey($this->config['database'],$sourceTable);
		switch($join_type)
		{
			case 'inner': $join = " INNER JOIN ";
						  break;
			case 'left': $join = " LEFT JOIN ";
						  break;
			case 'right': $join = " RIGHT JOIN ";
						  break;
			default: $join = " INNER JOIN ";					
		}
		
		foreach ($joinTable as $key => $value) {
		 	$joinTables[$value]=$value;
		 } 
		
		 echo "</br> jj ".$joinTables["recipes_ingredients"];
		 
		 	$foreignKey=$this->getForeignKey($this->config['database'],$joinTables[$value]);
		 	echo "</br>-----";
		 	var_dump($foreignKey);
		 
		
	
		
	}

	public function getTableColumns($table)
	{
		$query= " SHOW columns FROM ".$table;
		$result = $this->query($query);
		$tableColumn=$result->fetchAll();
		foreach ($tableColumn as $row) {
			$tableColumns[]=$row["Field"];
		}
		return $tableColumns;
	}
}
