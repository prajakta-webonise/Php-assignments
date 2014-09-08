<?php

interface dbInterface
{
	public function insert();
	public function update($where);
	public function delete($where);
	public function setSourceTable($table);
	public function setColumns($columns);
	public function setOrderBy($orderBy);
	public function setGroupBy($groupBy);
	public function setHaving($having);
	public function selectQuery($join,$where,$andOr);
	public function oneToOne($table,$targetTable,$joinType);
	public function oneToMany($table,$targetTable,$joinType);
	public function manyToOne($table,$targetTable,$joinType);
	public function manyToMany($table,$joinTable,$targetTable,$joinType);
}