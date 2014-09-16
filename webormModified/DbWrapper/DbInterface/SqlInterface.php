<?php

    interface sqlInterface {
        public function getPrimaryKey($db, $table);
        public function getForeignKey($db,$table,$referencedTable);
        public function oneToOne($table, $targetTable, $joinType);
        public function oneToMany($table, $targetTable, $joinType);
        public function manyToOne($table, $targetTable, $joinType);
        public function manyToMany($table, $joinTable, $targetTable, $joinType);
        public function getTableColumns($table);
    }