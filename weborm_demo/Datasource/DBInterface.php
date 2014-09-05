<?php

interface DBInterface
{
	public function select($table,$columns);
	public function select_by_join($table,$columns,$where,$and_or);
	public function insert($table,$columns);
	public function update($table,$columns,$where);
	public function delete($table,$where);
	public function select_by_id($table,$columns,$where);
	public function selectQuery($table,$columns,$join,$where,$and_or,$groupBy,$having,$orderBy);
	public function oneToMany($table,$target_table,$join_type);
	public function manyToOne($table,$target_table,$join_type);
	public function manyToMany($table,$joinTable,$targetTable,$joinType);
}