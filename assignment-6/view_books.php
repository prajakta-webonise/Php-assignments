 

 <?php 
 	
    //connect to the database and start the session 
	require_once 'common.php'; 
     $userid=$_SESSION['user']['id'];
     
     
     // check if user is logged in  
    if(empty($_SESSION['user'])) 
    { 
        //If not, redirect  to the login page.  
        header("Location: login.php"); 
        
    } 
     
    //select books to be viewed
	$userOptions = new UserOptions();
	$rows=$userOptions->viewBooks();
    
?> 
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<h1>Books list</h1> 
<table> 
    <tr> 
        <th>ID</th> 
        <th>Book name </th> 
        <th>Author name </th> 
       
    </tr> 
    <?php foreach($rows as $row): ?> 
        <tr> 
            <td><?php echo $row['id']; ?></td> 
            <td><?php echo $row['book_name']; ?></td> 
            <td><?php echo $row['author_name']; ?></td> 
            
        </tr> 
    <?php endforeach; ?> 
</table> 
<a href="menu.php">Menu</a><br />
</div>
</div>
</body>