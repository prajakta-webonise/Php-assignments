<?php 

    //connect to the database and start the session 
    require("connection.php"); 
    $userid=$_SESSION['user']['id'];
    // check if user is logged in 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
    
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
        // check if book id is not empty 
        if(empty($_POST['book_id'])) 
        { 
            die("Please enter a book Id."); 
        } 
        // check if book name is not empty 
        if(empty($_POST['book_name'])) 
        { 
            die("Please enter a book name."); 
        }
        // check if book id already exists
        $query = " 
            SELECT 
                create_book.id 
            FROM create_book WHERE create_book.id = :id 
        "; 
         
        echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':id' => $_POST['book_id'] 
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
        
        // If a row was returned, then a matching book id is found in the database  
        if($row) 
        { 
            die("This id is already in use"); 
        } 
        // Redirect to the login page after registration 
        
         $file_name=$_POST['book_name'];
         if(file_exists("/var/www/files/$file_name"))
		{
			exit('Book already exists!');
		}
		else
		{
			// add book to database. 
			$query = " 
				INSERT INTO create_book ( 
					id, 
					book_name                
				) VALUES ( 
					:book_id, 
					:book_name
				) 
			"; 
			//value of tokens 
			$query_params = array( 
				':book_id' => $_POST['book_id'], 
				':book_name' => $_POST['book_name']
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
        	$file=fopen("/var/www/assignment-5/files/$file_name","x+");
            $contents=$_POST['contents'];
            fputs ($file, "$contents");
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
<h1>Add Books</h1> 
<form action="create_book.php" method="post"> 
	
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
    Book name:<br /> 
    <input type="text" name="book_name" value="" /> 
    <br /><br /> 
	Book contents:<br /> 
    <textarea  name="contents" value=""></textarea>
    <br /><br /> 
   
    <input type="submit" value="Add" /> 
</form>
<a href="menu.php">Menu</a><br />
</div>
</div>
</body>