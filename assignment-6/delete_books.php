<?php 

    //connect to the database and start the session 
    require_once 'common.php';
    $userid=$_SESSION['user']['id'];
    // check if user is logged in 
     if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page.
        header("Location: login.php"); 
        
    } 
     //check if form is submitted 
    if(!empty($_POST)) 
    { 
        // check if book name is not empty 
        if(empty($_POST['book_id'])) 
        { 
            die("Please enter a book Id."); 
        } 
        $userOptions = new UserOptions();
		$book_id=$_POST['book_id']; 
		//delete book
		$userOptions->deleteBooks($book_id);
                  
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
<h1>Delete Books</h1> 
<form action="delete_books.php" method="post"> 
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
    <input type="submit" value="Delete" /> 
</form>
</div>
</div>
</body>