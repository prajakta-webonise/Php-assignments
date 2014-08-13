<?php 

    //connect to the database and start the session 
    require("connection.php"); 
   // check if user is logged in 
     $userid=$_SESSION['user']['id'];
     
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
         
                
        //retrieve data
        $query = " 
            SELECT 
                *
            FROM create_book where create_book.id = :id 
        "; 
         
        
		echo 'id='.$_POST['book_id'];
        $query_params = array( 
            //':user_id' => $userid ,
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
         
        
        $row = $stmt->fetch(); 
         
        
        if($row) 
        { 
            setcookie("file_name",$row['book_name']);
			$file_name=$row['book_name'];
			$file=fopen("/var/www/assignment-5/files/$file_name","a+") or exit("Unable to open");
			$file_contents=file_get_contents("/var/www/assignment-5/files/$file_name");
			echo $file_contents;
            setcookie("file_contents",$file_contents);
			//fclose($file);
			
			header("Location: read_contents.php");
		?>
		Book Id:<br /> 
		<input type="text" name="book_id" value="<?php echo $row['id']; ?>" /> 
		<br /><br /> 
		Book name:<br /> 
		<input type="text" name="book_name" value="<?php echo $row['book_name']; ?>" /> 
		<br /><br /> 
		
		<br /><br /> <?php
		
			
        } 
         
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
<h1>Read Books</h1> 
<form action="read_file.php" method="post"> 
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
	
	    <input type="submit" value="Search" /> 
</form>
</div>
</div>
</body>