<?php
require_once("Datasource/Registry.php");
require_once("Datasource/ActiveRecord.php");

class Model extends ActiveRecord
{
	var $condition=null;
	var $oneToOne=null;
	var $oneToMany=null;
	var $manyToOne=null;
	var $manyToMany=null;
	var $hasRelation=null;
	public function __construct()
	{
		
	}

	public function save()
	{
		$db=$this->autoloadConnection();
		$table=get_class($this);
		$columns=array_flip(get_object_vars($this));
		
		$tableColumns=$db->getTableColumns($table);
		$columns=array_intersect($columns, $tableColumns);
		$columns=array_flip($columns);
		
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
		$db=$this->autoloadConnection();
		$table=get_class($this);
		$columns=array_flip(get_object_vars($this));
		$tableColumns=$db->getTableColumns($table);
		$columns=array_intersect($columns, $tableColumns);
		$columns=array_flip($columns);
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
		$db=$this->autoloadConnection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		$where= 'id = '.$columns["id"];
		if($db->delete($table,$where))
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
		$db=$this->autoloadConnection();
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
		$db=$this->autoloadConnection();
		$table=get_class($this);
		if(isset($this->oneToOne))
		{
			echo 'onetoone';
			$join=$this->oneToOneJoin();
			echo 'hjh';
			if(isset($this->oneToOne["columns"]))
			{
				$columns = $this->oneToOne["columns"];
			}
			else
			{
				$columns = "*";
			}
			$orderBy=$this->oneToOne["order_by"];
			$groupBy=$this->oneToOne["group_by"];
			$result= $db->selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
			return ($result? $result : false);
			
			
		}
		if(isset($this->oneToMany))
		{
			echo 'onetomany';
			$join=$this->oneToManyJoin();
			if(isset($this->oneToMany["columns"]))
			{
				$columns = $this->oneToMany["columns"];
			}
			else
			{
				$columns = "*";
			}
			$orderBy=$this->oneToMany["order_by"];
			$groupBy=$this->oneToMany["group_by"];
			$result= $db->selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
			return ($result? $result : false);
			
			
		}
		if(isset($this->manyToOne))
		{
			echo 'manytoone';
			$join=$this->manyToOneJoin();
			if(isset($this->manyToOne["columns"]))
			{
				$columns = $this->manyToOne["columns"];
			}
			else
			{
				$columns = "*";
			}
			$orderBy=$this->manyToOne["order_by"];
			$groupBy=$this->manyToOne["group_by"];
			$result= $db->selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
			return ($result? $result : false);
			
		}
		if(isset($this->manyToMany))
		{
			echo 'manyToMany';
			$join=$this->manyToManyJoin();
			if(isset($this->manyToOne["columns"]))
			{
				$columns = $this->manyToOne["columns"];
			}
			else
			{
				$columns = "*";
			}
			$orderBy=$this->manyToOne["order_by"];
			$groupBy=$this->manyToOne["group_by"];
			$result= $db->selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
			return ($result? $result : false);
		}

		if(!isset($this->oneToMany) && !isset($this->manyToOne)) 
		{	
			$result= $this->attachFields();
			return $result;
		}
		
		

	}
	public function attachFields()
	{
			
		$db=$this->autoloadConnection();
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
			$orderBy=$this->condition["order_by"];
			$groupBy=$this->condition["group_by"];
			
			$result= $db->selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
			return ($result? $result : false);
	}
	public function oneToOneJoin()
	{
			echo 'Hi';
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$target_table=$this->oneToOne["target_table"];
			$join_type=$this->oneToOne["join_type"];
			echo 'jhjjg';
			$join=$db->oneToOne($table,$target_table,$join_type);
			echo 'ttto'.$join;
			return $join;
	}
	public function oneToManyJoin()
	{
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$target_table=$this->oneToMany["target_table"];
			$join_type=$this->oneToMany["join_type"];
			
			$join=$db->oneToMany($table,$target_table,$join_type);
			return $join;
	}
	public function manyToOneJoin()
	{
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$target_table=$this->manyToOne["target_table"];
			$join_type=$this->manyToOne["join_type"];
			$join=$db->manyToOne($table,$target_table,$join_type);
			return $join;
	}
	public function manyToManyJoin()
	{
			$db=$this->autoloadConnection();
			$table=get_class($this);
			$targetTable=$this->manyToMany["target_table"];
			echo "</br>tt: ".$targetTable;
			$joinTable=$this->manyToMany["join_table"];
			$joinType=$this->manyToMany["join_type"];
			$join=$db->manyToMany($table,$joinTable,$targetTable,$joinType);
			return $join;
	}
	public function hasRelation()
	{
		
		
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
			$db=$this->autoloadConnection();
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
		$db=$this->autoloadConnection();
		$table=get_class($this);
		$columns=get_object_vars($this);
		return $result=$db->select_by_id($table,$columns,$where);
	}
}



?>