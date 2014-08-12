<?php 

    //connect to the database and start the session 
    require("connection.php"); 
    // check if user is logged in 
    if(empty($_SESSION['user'])) 
    { 
        // If not, redirect  to the login page.  
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
   //check if form is submitted  
    if(!empty($_POST)) 
    { 
        // validate E-Mail address
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        // check if email already exists
        if($_POST['email'] != $_SESSION['user']['email']) 
        { 
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
                // Execute the query 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex) 
            { 
                 die("Failed to run query: " . $ex->getMessage()); 
            } 
             
            // Retrieve results  
            $row = $stmt->fetch(); 
            if($row) 
            { 
                die("This E-Mail address is already in use"); 
            } 
        } 
         
        //update password
        if(!empty($_POST['password'])) 
        { 
            $password = $_POST['password'];
        } 
        else 
        { 
            
            $password = null; 
             
        } 
         
        
        $query_params = array( 
            ':email' => $_POST['email'], 
            ':user_id' => $_SESSION['user']['id'], 
        ); 
         
        
        if($password !== null) 
        { 
            $query_params[':password'] = $password; 
        } 
         
        //user can change or even keep password same, so query is divided using if -- else
        $query = " 
            UPDATE users 
            SET 
                email = :email 
        "; 
        //if user is changing password add this part to query 
        if($password !== null) 
        { 
            $query .= " 
                , password = :password 
                "; 
        } 
         
        // common where condition
        $query .= " 
            WHERE 
                id = :user_id 
        "; 
         
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
        
        //update email in session 
        $_SESSION['user']['email'] = $_POST['email']; 
        
        header("Location: menu.php"); 
        die("Redirecting to menu.php"); 
    } 
     
?> 
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<h1>Edit Account</h1> 
<form action="edit_account.php" method="post"> 
    Username:<br /> 
    <b><?php echo $_SESSION['user']['username']; ?></b> 
    <br /><br /> 
    E-Mail Address:<br /> 
    <input type="text" name="email" value="<?php echo $_SESSION['user']['email']; ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /><br /> 
    <i>(leave blank if you do not want to change your password)</i> 
    <br /><br /> 
    <input type="submit" value="Update Account" /> 
</form>
</div>
</div>
</body>