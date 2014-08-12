<?php 

    // connection for MySQL database 
    $username = "root"; 
    $password = "password"; 
    $host = "localhost"; 
    $dbname = "bookshelf"; 

    
    try 
    { 
        //connect to database using PDO library
        $db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
     
    //makes PDO throw an exception when it occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    
    //makes PDO return associative aray with string indexes i.e column name
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    
    session_start(); 

    