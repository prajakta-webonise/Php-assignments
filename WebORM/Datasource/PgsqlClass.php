<?php
	require_once("Datasource/DbInterface.php");
	require_once("Datasource/PgSqlAbstract.php");
class pgsqlClass extends pgsqlAbstract implements dbInterface {
	public function __construct($config) {
		try {
			$connection_string =	'pgsql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['database'];
			PDO::__construct($connection_string,$config['user'],$config['password']);
		}
 		catch (PDOException $e) {
   			echo 'Connection failed: ' . $e->getMessage();
			die();
		}
	}
	public function select($table,$columns)	{
		$column_list=implode(', ',array_keys($columns));
		$query="SELECT ".$column_list." FROM ".$table;
		$stmt= parent::prepare($query);
		if($stmt->execute()) {
			$result = $stmt->fetchAll(parent::FETCH_ASSOC);
			return $result;
		}
		else {
			return false;
		}
	}
	
	public function insert($table,$columns) {
		$column_list=implode(', ',array_keys($columns));
		$column_values=':'.implode(', :',array_keys($columns));
		$query="INSERT INTO " .$table." ( ".$column_list." ) VALUES ( ".$column_values." )";
		foreach ($columns as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		$stmt = parent::prepare($query);
		if ($stmt->execute($query_params)) {
	       	return true;
	    }	
	    else {
	    	return false;
	    }
	}
	public function update($table,$columns,$where='') {
		foreach ($columns as $key => $value) {
			$fields .= "$key = :$key,";
		}
		$set_params = rtrim($fields,",");
		$query="UPDATE ".$table." SET ".$set_params.($where? ' WHERE '.$where:' ');
		foreach ($columns as $key => $value) {
			$query_params[':'.$key] = $value;
		}
		$stmt = parent::prepare($query);
		if ($stmt->execute($query_params)) {
	       	return true;
		}	
		else {
	    	return false;
	    }
	}
	public function delete($table,$columns,$where='')
	{
		$column_list=implode(', ',array_keys($columns));
		$query="DELETE FROM ".$table.($where? " WHERE ".$where:' ');	
		$stmt = parent::prepare($query);
		if ($stmt->execute()) {
	       	return true;
	    }	
	    else {
	    	return false;
	    }
	}
}
