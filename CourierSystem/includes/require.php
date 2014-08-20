<?php
session_start();
require_once("classes/DBClass.php");
require_once("classes/validate.php");
require_once("classes/users.php");
//creating object of class DB
$db = new DB();
$user = new users();
$user->userDashboard();
?>