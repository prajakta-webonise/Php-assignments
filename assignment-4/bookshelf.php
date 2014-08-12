<?php 

    //connect to the database and start the session 
    require("connection.php"); 
   
     $userid=$_SESSION['user']['id'];
     // check if user is logged in 
     if(empty($_SESSION['user'])) 
    { 
        //If not,redirect to the login page
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
        // check if booksheld id is not empty 
        if(empty($_POST['bookshelf_id'])) 
        { 
            die("Please enter a Id."); 
        } 
         
        // check if bookshelf name is not empty 
        if(empty($_POST['name'])) 
        { 
            die("Please enter a bookshelf name."); 
        } 
         
        // check if bookshelf id already exists
        $query = " 
            SELECT 
                bookshelf.id 
            FROM users INNER JOIN bookshelf ON users.id = :user_id AND bookshelf.id = :id 
        "; 
         
		echo 'id='.$_POST['id'];
        $query_params = array( 
            ':user_id' => $userid ,
			':id' => $_POST['bookshelf_id'] 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!!!Failed to run query: " . $ex->getMessage()); 
        } 
         
        //returns result
        $row = $stmt->fetch(); 
         
        // If a row was returned, then a matching bookshelf id is found in the database
        if($row) 
        { 
            die("This id is already in use"); 
        } 
         
        // If a row was returned, then a matching bookshelf name is found in the database
         
        $query = " 
            SELECT 
                name 
            FROM users INNER JOIN bookshelf ON users.id = :user_id AND name = :name 
        "; 
         
        $query_params = array( 
			':user_id' => $userid , 
            ':name' => $_POST['name'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This category address is already registered"); 
        } 
         
        // add bookshelf to database. 
        $query = " 
            INSERT INTO bookshelf ( 
                id, 
                name, 
                user_id 
            ) VALUES ( 
                :id, 
                :name, 
                :user_id 
            ) 
        "; 
               
        $query_params = array( 
            ':id' => $_POST['bookshelf_id'], 
            ':name' => $_POST['name'], 
            ':user_id' => $userid
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This redirects the user back to the login page after they register 
         $_SESSION['book'] = $row; 
         print_r($_SESSION['book']);
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
<h1>Create Bookshelf</h1> 
<form action="bookshelf.php" method="post"> 
    Bookshelf Id:<br /> 
    <input type="text" name="bookshelf_id" value="" /> 
    <br /><br /> 
    Category:<br /> 
    <input type="text" name="name" value="" /> 
    <br /><br /> 
	
    <input type="submit" value="Create" /> 
</form>
</div>
</div>
</body>