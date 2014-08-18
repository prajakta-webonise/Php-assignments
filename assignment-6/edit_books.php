<?php 

    //connect to the database and start the session 
    require_once 'common.php';
   // check if user is logged in 
     $userid=$_SESSION['user']['id'];
     $error="";
     if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page.  
        header("Location: login.php"); 
        
    } 
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
        // check if book id is not empty  
        if(empty($_POST['book_id'])) 
        { 
            die("Please enter a book Id."); 
        } 
        $book_id= $_POST['book_id'];
        $userOptions = new UserOptions();
		if($userOptions->searchBooks($book_id)){
			setcookie("book_id",$book_id);
			header("Location: add.php");
		
		}
		else{
		 $error='Book not found';
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
<h1>Edit Books</h1> 
<form action="edit_books.php" method="post"> 
<label><?php echo $error; ?></label></br>
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
	
	    <input type="submit" value="Search" /> 
</form>
</div>
</div>
</body>