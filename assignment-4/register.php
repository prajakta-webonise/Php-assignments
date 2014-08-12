<?php 

    ///connect to the database and start the session 
    require("connection.php");  
     
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
        // check if username is not empty 
        if(empty($_POST['username'])) 
        { 
            die("Please enter a username."); 
        } 
         
        // check if password is not empty 
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        } 
         
        //validate email
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        // check if username already exists
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // run the query against database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        //username already exists
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        // check if email id exists
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        //insert new record
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                email 
            ) VALUES ( 
                :username, 
                :password, 
                :email 
            ) 
        "; 
               
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $_POST['password'], 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // redirectto login page after registration 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
?> 
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<h1>Register</h1> 
<form action="register.php" method="post"> 
    Username:<br /> 
    <input type="text" name="username" value="" /> 
    <br /><br /> 
    E-Mail:<br /> 
    <input type="text" name="email" value="" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Register" /> 
</form>
</div>
</div>
</body>