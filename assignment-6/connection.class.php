<?php
//connection.class.php
 
class connection {
 
    protected $db_name = "bookshelf";
    protected $db_username = "root";
    protected $db_password = "prajakta";
    protected $host = "localhost";
 
    //open a connection to the database. 
    public function connect() {
        try
        {
            return new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->db_username, $this->db_password);
        }
        catch(PDOException $ex) 
        { 
            die("!!Failed to connect to the database: " . $ex->getMessage()); 
        } 
     
    //makes PDO throw an exception when it occurs
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    
    //makes PDO return associative aray with string indexes i.e column name
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        
        return true;
    }
 
    
}
 
?>