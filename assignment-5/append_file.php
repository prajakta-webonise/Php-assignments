Success!
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
     if (isset($_COOKIE['file_name']) && isset($_COOKIE['file_contents'])) {
	
	}
	//check if form is submitted
	if(!empty($_POST)) 
    { 
    	
            $file_name=$_COOKIE['file_name'];
		
             $file=fopen("/var/www/assignment-5/files/$file_name","a") or exit("Unable to open");
             $contents=$_POST['contents'];
             fputs ($file, "$contents");
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
<form action="append_file.php" method="post"> 
		Book name:<br /> 
		<input type="text" name="book_name" value="<?php echo $_COOKIE['file_name']; ?>" /> 
		<br /><br /> 
		Book Contents:<br />
		<textarea  name="contents" value=""></textarea>
    	<br /><br /> 
        <input type="submit" value="Submit" /> 
</form>
<a href="menu.php">Menu</a><br />
 </div>
 </div>
 </div>
		
			
