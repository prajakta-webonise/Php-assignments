<?php

interface DBInterface
{
	public function select($table,$columns);
	public function select_by_join($table,$columns,$where,$and_or);
	public function insert($table,$columns);
	public function update($table,$columns,$where);
	public function delete($table,$columns,$where);
	public function select_by_id($table,$columns,$where);
	public function select_new($table,$columns,$join,$where,$and_or,$group_by,$having,$order_by);
	public function oneToMany($table,$target_table,$join_type);
}