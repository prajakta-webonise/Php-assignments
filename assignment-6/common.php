<?php
require_once 'user.class.php';
require_once 'UserOptions.class.php';
require_once 'connection.class.php';
 
//connect to the database
$db_obj = new connection();
$db_obj->connect();

//start the session
session_start();
 

?>
