<?php 

    //connect to the database and start the session 
    require_once 'common.php';
    $error="";
	$bookshelf_id="";
	$name="";
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
        $bookshelf_id = $_POST['bookshelf_id'];
		$name = $_POST['name'];
 
		$userOptions = new UserOptions();
		if($userOptions->checkBookShelfId($bookshelf_id)){
            //$login_ok = true; 
		
			if($userOptions->checkBookName($name)){
		
					$userOptions->createBookShelf($bookshelf_id,$name);
					$error='BookShelf created successfully';
					header("Location: menu.php"); 
			}
			else{
				$error = "This book category already exists";
			}
		}else {
		
			$error = "Id already exists";
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
<h1>Create Bookshelf</h1> 
<form action="bookshelf.php" method="post"> 
	<label><?php echo $error; ?></label>
	<br/>
    Bookshelf Id:<br /> 
    <input type="text" name="bookshelf_id" value="<?php echo $bookshelf_id; ?>" /> 
    <br /><br /> 
    Category:<br /> 
    <input type="text" name="name" value="<?php echo $name; ?>" /> 
    <br /><br /> 
	
    <input type="submit" value="Create" /> 
	<a href="menu.php">Menu</a>
</form>
</div>
</div>
</body>