 success.
 <?php 

    //connect to the database and start the session 
    require_once 'common.php';
    $error=""; 
    // check if user is logged in 
    if(empty($_SESSION['user'])) 
    { 
        // If not,redirect to the login page. 
        header("Location: login.php"); 
        
    } 
     if (isset($_COOKIE['book_name']) && isset($_COOKIE['author_name']) && isset($_COOKIE['book_id'])) {
	
	}
	//check if form is submitted
	if(!empty($_POST)) 
    { 
		$data['book_id']=$_COOKIE['book_id'];
		$data['book_name']=$_POST['book_name'];
		$data['author_name']=$_POST['author_name'];
		$userOptions = new UserOptions();
		//update books whose id is equal to id entered by user
    	$userOptions->updateBooks($data);
		$error="Updated successfully";
		
		
    	
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
<label><?php echo $error; ?></label></br>
		Book name:<br /> 
		<input type="text" name="book_name" value="<?php echo $_COOKIE['book_name']; ?>" /> 
		<br /><br /> 
		Author name:<br /> 
		<input type="text" name="author_name" value="<?php echo $_COOKIE['author_name']; ?>" /> 
		<br /><br /> 
        <input type="submit" value="Submit" /> 
		<a href="menu.php">Menu</a><br />
</form>
 </div>
 </div>
 </div>
		
			
			