<?php 

    //connect to the database and start the session 
    require("connection.php"); 
    
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
        //fetch data with username 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // to check if login is successful. Initially it is false
        $login_ok = false; 
               
        $row = $stmt->fetch(); 
        //username exists
        if($row) 
        { 
            //check if corresponding passwors matches submitted password
             $check_password = $_POST['password'];
            if($check_password === $row['password']) 
            { 
                $login_ok = true; 
            } 
        } 
         
        //login successful
        if($login_ok) 
        { 
            //don't store password in session
            unset($row['password']); 
             
            //store result in session
            $_SESSION['user'] = $row; 
             
            // Redirect the user to the private members-only page. 
            header("Location: menu.php"); 
            die("Redirecting to: menu.php"); 
        } 
        else 
        { 
            print("Login Failed."); 
        } 
    } 
     
?>
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register> 
<h1>Login</h1> 
<form action="login.php" method="post"> 
    Username:<br /> 
    <input type="text" name="username" value="" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Login" /> 
</form> 
<a href="register.php">Register</a>
</div>
</div>
</body>