 

 <?php 
 	
    //connect to the database and start the session 
    require_once 'common.php';  
     $userid=$_SESSION['user']['id'];
    
     
     // check if user is logged in  
    if(empty($_SESSION['user'])) 
    { 
        //If not, redirect  to the login page.   
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
    //select bookshelf details
	$userOptions = new UserOptions();
	$rows=$userOptions->viewBookShelf();
    
?> 
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<h1>Bookshelf </h1> 
<table> 
    <tr> 
        <th>ID</th> 
        <th>Bookshelf name</th> 
       
    </tr> 
    <?php foreach($rows as $row): ?> 
        <tr> 
            <td><?php echo $row['id']; ?></td> 
            <td><?php echo $row['name']; ?></td> 
            
        </tr> 
    <?php endforeach; ?> 
</table> 
<a href="menu.php">Menu</a><br />
</div>
</div>
</body>