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
	public function select_new($table,$columns,$join,$where,$and_or,$group_by,$having,$order_by)
	{
		
		$column_list = $this->get_columns($columns);
			
		if($where=='')
		{
			$query="SELECT ".$column_list." FROM ".$table.$join.($group_by? ' GROUP BY '.$group_by:' ').($having? ' HAVING '.$having:' ').($order_by? ' ORDER BY '.$order_by:' ');	
			echo 'q'.$query;
			return $this->execute($query);
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
				$query="SELECT ".$column_list." FROM ".$table." WHERE ".$condition.($group_by? ' GROUP BY '.$group_by:' ').($order_by? ' ORDER BY '.$order_by:' ');
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
				$query= $query.($group_by? ' GROUP BY '.$group_by:' ').($order_by? ' ORDER BY '.$order_by:' ');
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
	public function delete($table,$columns,$where='')
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

	public function getForeignKey($db,$table)
	{
		$query = "SELECT kcu.COLUMN_NAME FROM information_schema.key_column_usage AS kcu
						INNER JOIN information_schema.referential_constraints AS rc ON ( kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME ) 
						WHERE kcu.TABLE_SCHEMA =  '".$db."'
						AND kcu.TABLE_NAME =  '".$table."'";
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
			$column_list=implode(', ',array_values($columns));
		}
		return $column_list;
	}
	public function execute($query)
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
	public function oneToMany($table,$target_table,$join_type)
	{
		$source_table=$table;
		$primary_key=$this->getPrimaryKey($this->config['database'],$source_table);
		$foreign_key=$this->getForeignKey($this->config['database'],$target_table);
		return " INNER JOIN ".$target_table." ON ". $source_table.".".$primary_key." = ".$target_table.".".$foreign_key;	
		
	}
}
