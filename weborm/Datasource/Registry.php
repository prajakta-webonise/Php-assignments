<?php
require_once("Datasource/BaseClass.php");
require_once("Datasource/MysqlClass.php");
class Registry 
{
   private  $object = array();
   private static $instance= null;

   public function __construct()
   {
      
   }
    public function __clone()
   {
      
   }
   public static function getInstance()
   {
      if(self::$instance ===null)
      {
         self::$instance = new Registry();
      }

      return self::$instance;
   }
   /* Set method set the values of array*/
   public function set($key, $value) {

      if (isset($this->object[$key])) {
         throw new Exception("There is already an entry for key " . $key);
      }

      $this->object[$key] = $value;
   }

   public function get($key) 
   {
      if (!isset($this->object[$key])) 
      {
         throw new Exception("There is no entry for key " . $key);
      }

      return $this->object[$key];
   }

}

$bs = new BaseClass();