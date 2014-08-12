<?php 

    //connect to the database and start the session 
    require("connection.php"); 
     
    // remove the user's data from the session 
    unset($_SESSION['user']); 
     
    // redirect to the login page 
    header("Location: login.php"); 
    die("Redirecting to: login.php");