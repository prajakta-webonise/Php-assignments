<?php
//user.class.php
 
require_once 'connection.class.php';
 
 
class user {
 
    public $id;
    public $username;
    public $password;
    public $email;
    
 
    //Constructor is called whenever a new object is created.

    function __construct($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->username = (isset($data['username'])) ? $data['username'] : "";
        $this->password = (isset($data['password'])) ? $data['password'] : "";
        $this->email = (isset($data['email'])) ? $data['email'] : "";
       
    }
 
    public function save() {
        //create a new database object.
        $db = new connection();

        $db1=$db->connect();

        echo $this->username;
            //insert new record
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                email 
            ) VALUES ( 
                :username, 
                :password, 
                :email 
            ) 
        "; 
               
        $query_params = array( 
            ':username' => $this->username, 
            ':password' => $this->password, 
            ':email' => $this->email 
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
    
}
 
?>