<?php
//UserOptionss.class.php
 
require_once 'user.class.php';
require_once 'connection.class.php';
 
class UserOptions {
 		
    //Check to see if a username exists.

    public function checkUsername($username) {

        $db = new connection();

        $db1=$db->connect();
        // check if username already exists
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        $query_params = array( 
            ':username' => $username
        ); 
         
        try 
        { 
            // run the query against database table. 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        //username already exists
        if($row) 
        { 
            
            return true;
        } 
        else {
            return false;
        }

    }

    public function checkEmail($username) {
		$db = new connection();
		$db1=$db->connect();
		
		$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
           return true;
        } 
        else {
            return false;
        } 
	}
	
	public function login($username,$password) {
		$db = new connection();
		$db1=$db->connect();
		
		//fetch data with username 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $username 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // to check if login is successful. Initially it is false
        $login_ok = false; 
               
        $row = $stmt->fetch(); 
        //username exists
        if($row) 
        { 
            //check if corresponding passwors matches submitted password

            if($password === $row['password']) {  
				//don't store password in session
				unset($row['password']); 
                //store result in session
				$_SESSION["user"] = $row;
                return true; 
            } 
			else {
				return false;
			}
		} 
       
	}
	
	public function checkBookShelfId($bookshelf_id) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		  $query = " 
            SELECT 
                bookshelf.id 
            FROM users INNER JOIN bookshelf ON users.id = :user_id AND bookshelf.id = :id 
        "; 
         
		//echo 'id='.$_POST['id'];
        $query_params = array( 
            ':user_id' => $userid ,
			':id' => $bookshelf_id 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!!!Failed to run query: " . $ex->getMessage()); 
        } 
         
        //returns result
        $row = $stmt->fetch(); 
         
        // If a row was returned, then a matching bookshelf id is found in the database
        if($row) 
        { 
            return false; 
        } 
		else{
			return true;
		}
	}
	
	public function checkBookName($name) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
            SELECT 
                name 
            FROM users INNER JOIN bookshelf ON users.id = :user_id AND name = :name 
        "; 
         
        $query_params = array( 
			':user_id' => $userid , 
            ':name' => $name 
        ); 
         
        try 
        { 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
			return false;
        } 
		else{
			return true;
		}
	}
	
	public function createBookShelf($bookshelf_id,$name) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
            INSERT INTO bookshelf ( 
                id, 
                name, 
                user_id 
            ) VALUES ( 
                :id, 
                :name, 
                :user_id 
            ) 
        "; 
               
        $query_params = array( 
            ':id' => $bookshelf_id, 
            ':name' => $name, 
            ':user_id' => $userid
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("!Failed to run query: " . $ex->getMessage()); 
        } 
         
        
	}
	
	public function viewBookShelf() {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
        SELECT 
            id, 
            name 
        FROM bookshelf WHERE bookshelf.user_id = ".$userid; 
    
    try 
    { 
        // run the query in database table. 
        $stmt = $db1->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    } 
    
    $rows = $stmt->fetchAll();
		return $rows;
	}
	
	public function checkBookId($book_id) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
            SELECT 
                books.id 
            FROM books WHERE books.id = :id 
        "; 
         
        //echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':id' => $book_id 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db1->prepare($query); 
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
            return true; 
        } 
		else{
			return false;
		}
        	
	}
	
	public function addBooks($data) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		
		$query = " 
            INSERT INTO books ( 
                id, 
                book_name,
                author_name, 
                bookshelf_id 
            ) VALUES ( 
                :book_id, 
                :book_name, 
                :author_name, 
                :bookshelf_id 
            ) 
        "; 
        //value of tokens 
        $query_params = array( 
            ':book_id' => $data['book_id'], 
            ':book_name' => $data['book_name'], 
            ':author_name' => $data['author_name'], 
            ':bookshelf_id' => $data['bookshelf_id']
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        
	}
    
	public function viewBooks() {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
        SELECT 
            books.id, 
            books.book_name,books.author_name 
        FROM bookshelf INNER JOIN books ON books.bookshelf_id=bookshelf.id AND bookshelf.user_id = ".$userid; 
    
    try 
    { 
        // run the query in database table. 
        $stmt = $db1->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    
    $rows = $stmt->fetchAll(); 
	return $rows;
	}
	
	public function searchBooks($book_id) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		
		$query = " 
            SELECT 
                *
            FROM books INNER JOIN bookshelf on books.bookshelf_id=bookshelf.id and bookshelf.user_id=:user_id and books.id = :id 
        "; 
         
        
		//echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':user_id' => $userid ,
			':id' => $book_id 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
             
            die("!!!Failed to run query: " . $ex->getMessage()); 
        } 
         
        
        $row = $stmt->fetch(); 
         
        
        if($row) {
			
			setcookie("book_name",$row['book_name']);
			setcookie("author_name",$row['author_name']);
			return true;
		}
		else{
			return false;
		}
		
	}
	
	public function updateBooks($data) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
	$query = " 
            update books set book_name=:book_name, author_name=:author_name where id=:id;
        "; 
		$query_params = array( 
                ':book_name' => $data['book_name'],
				':author_name' => $data['author_name'],
				':id' => $data['book_id']				
            ); 
		try 
            { 
                // Execute the query 
                $stmt = $db1->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex) 
            { 
                die("Failed to run query: " . $ex->getMessage()); 
            } 
	}
	
	public function deleteBooks($book_id) {
		$db = new connection();
		$db1=$db->connect();
		$userid=$_SESSION['user']['id'];
		$query = " 
            DELETE B 
                FROM books B INNER JOIN bookshelf on B.bookshelf_id=bookshelf.id and bookshelf.user_id=:user_id and B.id = :id 
        "; 
         
        //echo 'id='.$_POST['book_id'];
        $query_params = array( 
            ':user_id' => $userid ,
			':id' => $book_id 
        ); 
         
        try 
        { 
            // run the query against your database table. 
            $stmt = $db1->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        
	}
	
    
}
 
?>