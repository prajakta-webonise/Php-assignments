<?php 

    //connect to the database and start the session 
    require_once 'common.php';   
	$error="";
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
        // check if author name is not null 
        if(empty($_POST['author_name'])) 
        { 
            die("Please enter a author name."); 
        }
        // check if bookshelf id is not null 
        if(empty($_POST['bookshelf_id'])) 
        { 
            die("Please enter a bookshelif Id."); 
        } 
		$book_id=$_POST['book_id'];
		$book_name=$_POST['book_name'];
		$author_name=$_POST['author_name'];
		$bookshelf_id=$_POST['bookshelf_id'];
         
		$userOptions = new UserOptions();
		if($userOptions->checkBookId($book_id))
		{
			$error='This Id already exists';
		}
		else{
			$error='Done';
			$data['book_id']=$book_id;
			$data['book_name']=$book_name;
			$data['author_name']=$author_name;
			$data['bookshelf_id']=$bookshelf_id;
			$userOptions->addBooks($data);
			$error='Added successfully';
			
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
<form action="add_books.php" method="post"> 
	<label><?php echo $error; ?></label>
	<br/>
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
    Book name:<br /> 
    <input type="text" name="book_name" value="" /> 
    <br /><br /> 
    Author name:<br /> 
    <input type="text" name="author_name" value="" /> 
    <br /><br /> 
    Bookshelf Id:<br /> 
    <input type="text" name="bookshelf_id" value="" /> 
    <br /><br /> 
	
    <input type="submit" value="Add" /> 
	<a href="menu.php">Menu</a><br />
</form>
</div>
</div>
</body>