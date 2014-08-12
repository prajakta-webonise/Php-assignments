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
     
    // This block of code is used to undo magic quotes.  Magic quotes are a terrible 
    // feature that was removed from PHP as of PHP 5.4.  However, older installations 
    // of PHP may still have magic quotes enabled and this code is necessary to 
    // prevent them from causing problems.  For more information on magic quotes: 
    // http://php.net/manual/en/security.magicquotes.php 
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
    
    session_start(); 

    