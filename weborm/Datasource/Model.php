<?php
require_once("Datasource/Registry.php");
require_once("Datasource/ActiveRecord.php");

class Model extends ActiveRecord
{
	var $condition=null;
	var $oneToMany=null;
	public function save()
	{
		$db=$this->autoload_connection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		if($db->insert($table,$columns))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function modify()
	{
		$db=$this->autoload_connection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		$where= 'id = '.$columns["id"];
		if($db->update($table,$columns,$where))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function remove()
	{
		$db=$this->autoload_connection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		$where= 'id = '.$columns["id"];
		if($db->delete($table,$columns,$where))
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	public function find($select_fields)
	{
		$db=$this->autoload_connection();
		$table=get_class($this);
		$columns=" * ";
		$result=$db->select($table,$columns);
		if($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}
	public function search()
	{
		//echo 'Condition in search'.$condition;
		$db=$this->autoload_connection();
		$table=get_class($this);
		if(isset($this->oneToMany))
		{
			echo 'onetomany';
			$target_table=$this->oneToMany["target_table"];
			$join_type=$this->oneToMany["join_type"];
			if(isset($this->oneToMany["columns"]))
			{
				$columns = $this->oneToMany["columns"];
			}
			else
			{
				$columns = "*";
			}
			$order_by=$this->oneToMany["order_by"];
			$group_by=$this->oneToMany["group_by"];
			$join=$db->oneToMany($table,$target_table,$join_type);
			$result= $db->select_new($table,$columns,$join,$where,$and_or,$group_by,$having,$order_by);
			if($result)
			{
				return $result;
			
			}
			else
			{
				return false;
			}
			
		}
		else 
		{	echo 'condition';
			$a= $this->attach_fields();
			return $a;
		}
		
		

	}
	public function attach_fields()
	{
		//var_dump($this->condition);
		
		$db=$this->autoload_connection();
		$table=get_class($this);
		if(isset($this->condition["having"]))
			{
				if(isset($this->condition["columns"]))
				{
					$having=$this->condition["having"];
					foreach ($columns=$this->condition["columns"] as $key => $value) {
						if($having["column"]==$value)
						{
							$columns[$key]=$having["aggregate_function"].'( '.$value.' )';
							$having=$having["aggregate_function"].'('.$value.')';
							
						}
					}
				}
				else
				{
					$columns = "*";		
				}
			}
			else
			{
				$having='';
				if(isset($this->condition["columns"]))
				{
					$columns = $this->condition["columns"];
				}
				else
				{
					$columns = "*";
				}
			}
			$where = $this->condition["where"];
			$and_or=$this->condition["and_or"];
			$order_by=$this->condition["order_by"];
			$group_by=$this->condition["group_by"];
			
			$result= $db->select_new($table,$columns,$join,$where,$and_or,$group_by,$having,$order_by);
			if($result)
			{
				return $result;
			
			}
			else
			{
				return false;
			}
	}
	public function find_by_join($condition)
	{
		
			$where=$condition["condition"];
			var_dump($where);
			$and_or=$condition["condition_para"];
			
			$relation=get_object_vars($this);
			foreach ($relation as $key => $value) {
				if($key != 'hasMany')
				{
					$columns[$key] =$key;
				}
			}
			$db=$this->autoload_connection();
			$table=get_class($this);
			//$columns=get_object_vars($this);
			$result= $db->select_by_join($table,$columns,$where,$and_or);
			if($result)
			{
				return $result;
			}
			else
			{
				return false;
			}
		
		

	}
	public function find_by_id($where)
	{
		$db=$this->autoload_connection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		return $result=$db->select_by_id($table,$columns,$where);
	}
}



?>