 success.
 <?php 

    //connect to the database and start the session 
    require("connection.php"); 
     
    // check if user is logged in 
    if(empty($_SESSION['user'])) 
    { 
        // If not,redirect to the login page. 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     if (isset($_COOKIE['book_name']) && isset($_COOKIE['author_name']) && isset($_COOKIE['book_id'])) {
	
	}
	//check if form is submitted
	if(!empty($_POST)) 
    { 
    	//update books whose id is equal to id entered by user
    	$query = " 
            update books set book_name=:book_name, author_name=:author_name where id=:id;
        "; 
		$query_params = array( 
                ':book_name' => $_POST['book_name'],
				':author_name' => $_POST['author_name'],
				':id' => $_COOKIE['book_id']				
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
			header("Location: menu.php");
	}
 ?>
 <head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
 <h1>Edit Books</h1> 
<form action="add.php" method="post"> 
		Book name:<br /> 
		<input type="text" name="book_name" value="<?php echo $_COOKIE['book_name']; ?>" /> 
		<br /><br /> 
		Author name:<br /> 
		<input type="text" name="author_name" value="<?php echo $_COOKIE['author_name']; ?>" /> 
		<br /><br /> 
        <input type="submit" value="Submit" /> 
</form>
 </div>
 </div>
 </div>
		
			
			