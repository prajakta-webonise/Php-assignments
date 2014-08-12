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
/*        // check if author name is not null 
        if(empty($_POST['author_name'])) 
        { 
            die("Please enter a author name."); 
        }
        // check if bookshelf id is not null 
        if(empty($_POST['bookshelf_id'])) 
        { 
            die("Please enter a bookshelif Id."); 
        } 
         
  */      
        // check if book id already exists
        $query = " 
            SELECT 
                create_book.id 
            FROM create_book WHERE create_book.id = :id 
        "; 
         
        echo 'id='.$_POST['book_id'];
        $query_params = array( 
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
            die("!!!Failed to run query: " . $ex->getMessage()); 
        } 
         
        //returns result
        $row = $stmt->fetch(); 
        
        // If a row was returned, then a matching book id is found in the database  
        if($row) 
        { 
            die("This id is already in use"); 
        } 

        // check if book name already exists
        $query = " 
            SELECT 
                create_book.book_name 
            FROM create_book WHERE create_book.book_name = :book_name 
        "; 
         
        echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':book_name' => $_POST['book_name'] 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!Failed to run query: " . $ex->getMessage()); 
        } 
         
        //returns result
        $row = $stmt->fetch(); 
        
        // If a row was returned, then a matching book id is found in the database  
        if($row) 
        { 
            die("This book already exists"); 
        } 
         
        
         
        // add book to database. 
        $query = " 
            INSERT INTO create_book ( 
                id, 
                book_name                
            ) VALUES ( 
                :book_id, 
                :book_name
            ) 
        "; 
        //value of tokens 
        $query_params = array( 
            ':book_id' => $_POST['book_id'], 
            ':book_name' => $_POST['book_name']
            
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // Redirect to the login page after registration 
         $_SESSION['book'] = $row; 
         print_r($_SESSION['book']);
        //header("Location: write_book.php"); 
         $file_name=$_POST['book_name'];
         /*if(!file_exists("/home/webonise/Desktop/files/$file_name"))
{
    die("File not found");
}*/
//else
//{
    $file=fopen("/home/webonise/Desktop/files/$file_name","x+") or exit("file exists");
//}


while(!feof($file)) {
  echo fgets($file). "<br>";
  }
  $contents=$_POST['contents'];
  echo 'data---------: '.$contents;
  fputs ($file, "$contents");
fclose($file);
        //die("Redirecting to menu.php"); 
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
<form action="create_book.php" method="post"> 
    Book Id:<br /> 
    <input type="text" name="book_id" value="" /> 
    <br /><br /> 
    Book name:<br /> 
    <input type="text" name="book_name" value="" /> 
    <br /><br /> 
    <textarea  name="contents" value=""></textarea>
    <br /><br /> 
   <!-- Author name:<br /> 
    <input type="text" name="author_name" value="" /> 
    <br /><br /> 
    Bookshelf Id:<br /> 
    <input type="text" name="bookshelf_id" value="" /> 
    <br /><br /> 
	-->
    <input type="submit" value="Add" /> 
</form>
</div>
</div>
</body>