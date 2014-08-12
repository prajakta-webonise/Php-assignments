<?php 

    //connect to the database and start the session 
    require("connection.php"); 
    // check if user is logged in 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page.  
        header("Location: login.php"); 
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
Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>, <br /> 
<a href="bookshelf.php">Create bookshelf</a><br /> 
<a href="view_shelf.php">View bookshelf</a><br /> 
<a href="add_books.php">Add books to bookshelf</a><br /> 
<a href="view_books.php">View books</a><br /> 
<a href="edit_books.php">Edit Book</a><br /> 
<a href="delete_books.php">Delete Book</a><br /> 
<a href="edit_account.php">Edit Account</a><br /> 
<a href="logout.php">Logout</a>
</div>
</div>
</body>