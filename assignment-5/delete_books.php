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
        // check if book name is not empty 
        if(empty($_POST['book_id'])) 
        { 
            die("Please enter a book Id."); 
        } 
         
        
         
        //delete book
        $query = " 
            DELETE B 
                FROM books B INNER JOIN bookshelf on B.bookshelf_id=bookshelf.id and bookshelf.user_id=:user_id and B.id = :id 
        "; 
         
        echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':user_id' => $userid ,
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
            die("Failed to run query: " . $ex->getMessage()); 
        } 
              
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
<h1>Delete Books</h1> 
<form action="delete_books.php" method="post"> 
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
    <input type="submit" value="Search" /> 
</form>
</div>
</div>
</body>