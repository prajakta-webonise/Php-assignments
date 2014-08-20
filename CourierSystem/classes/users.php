
<?php
require_once('DBClass.php');
class users extends PDO
{
	public $id;
	public $firstName;
	public $lastName;
	public $line1;
	public $line2;
	public $city;
	public $state;
	public $country;
	public $pincode;
	public $email;
	public $contact;
	public $password;
	//public $UserRoleID='3';
	

	function __construct()
	{
		
	}
	//Function to Insert new user
	function insertUser($userData=array(),$newuser=false)
	{
		$db = new DB();
		try 
		{			
			if($newuser)
			{

				$query = " 
	            INSERT INTO users (first_name,last_name,address_line1,address_line2,city,state,country,pincode,email,contact,password,user_role_id) VALUES ( 
	                :firstName, 
	                :lastName, 
	                :line1, 
	                :line2,
	                :city,
	                :state,
	                :country,
	                :pincode,
	                :email,
	              	:contact,
	              	:password,
	                :user_role_id 
	            ) 
	        	"; 
	               
	        	$query_params = array( 
	            	':firstName' => $userData['firstName'], 
	            	':lastName' => $userData['lastName'], 
	            	':line1' => $userData['line1'], 
	           		':line2' => $userData['line2'], 
	            	':city' => $userData['city'], 
	            	':state' => $userData['state'],
	            	':country' => $userData['country'], 
	            	':pincode' => $userData['pincode'], 
	            	':email' => $userData['email'], 
	            	':contact' => $userData['contact'], 
	            	':password' => $userData['password'], 
	            	':user_role_id' => '3' 
	        	); 
	         
	        	try 
	        	{ 
		            // Execute the query 
	    	        $stmt = $db->prepare($query); 
	        	    $result = $stmt->execute($query_params); 
	        	    if ($result)
	        	    {
	        	    	return true;
	        	    }	
	        	    else
	        	    {
	        	    	return false;
	        	    }
	        	} 
	        	catch(PDOException $ex) 
	        	{ 
	            	die("Failed to run query: " . $ex->getMessage()); 
	        	}
	        } 
				
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}
	//function to check user already exist or no
	function checkUsernameExists($email) {
		try
		{
			
			$db = new DB();
			$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
	        "; 
	         
	        $query_params = array( 
	            ':email' => $email
	        ); 
	         
	        try 
	        { 
	            // run the query against database table. 
	            
	            $stmt = $db->prepare($query); 
	            
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
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}
	//Function to  authentificaticate user.
	function login($credentials=array())
	{
		$db = new DB();
		try 
		{	
			
			$stmt = $db->prepare("SELECT * FROM users WHERE  email = ? AND password = ? ");
			$stmt->bindParam(1, $credentials['email']);
			$stmt->bindParam(2, $credentials['password']);
			if($stmt->execute())
			{
				if($stmt->rowcount())
				{
				
					$userDetails = $stmt->fetch();
					setcookie('user_name', $userDetails['first_name']);
					setcookie('email', $userDetails['email']);
					$_SESSION['user_id']= $userDetails['id'];
					$_SESSION['user_role']= $userDetails['user_role_id'];

					return true;
				}
				else
					return false;
			}
			else
			{
				return false;
			}
			
		}
 		catch (PDOException $e) {
   			 echo 'ERROR : ' . $e->getMessage();

		}
	}
	function getUserId()
	{
		if(isset($_SESSION['user_id']))
		{
			return $_SESSION['user_id'];
		}
		else
		{
			return false;
		}
	} 
	function getUserRole()
	{
		if(isset($_SESSION['user_role']))
		{
			return $_SESSION['user_role'];
		}
		else
		{
			return false;
		}
	} 
	function isLoggedIn()
	{
		
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function logout()
	{
		session_start();
		unset($_SESSION['user_id']);
		setcookie('user_name','',time()-1);
		session_destroy();
	}
	function userDashboard()
	{
		
		switch($this->getUserRole())
		{
			case 1: return "adminMenu.php";
					break;
			case 2: return "courierMenu.php";
					break;
			case 3: return "userMenu.php";
					break;

		}
	}
	function insertProduct($userData=array())
	{
		$db = new DB();
		try 
		{			
			
				$query = " 
	            INSERT INTO orders (to_name,address_line1,address_line2,city,state,country,pincode,message,contact,product_id,user_id,weight_id) VALUES ( 
	                :to, 
	                :line1, 
	                :line2,
	                :city,
	                :state,
	                :country,
	                :pincode,
	                :message,
	              	:contact,
	              	:product_id,
	                :user_id,
	              	:weight_id
	                
	            ) 
	        	"; 
	               
	        	$query_params = array( 
	            	':to' => $userData['to'], 
	            	':line1' => $userData['line1'], 
	           		':line2' => $userData['line2'], 
	            	':city' => $userData['city'], 
	            	':state' => $userData['state'],
	            	':country' => $userData['country'], 
	            	':pincode' => $userData['pincode'], 
	            	':message' => $userData['message'], 
	            	':contact' => $userData['contact'], 
	            	':product_id' => $userData['productName'],
	            	':user_id' => $_SESSION['user_id'], 
	            	':weight_id' => '3'
	            	
	        	); 
	         
	        	try 
	        	{ 
		            // Execute the query 
	    	        $stmt = $db->prepare($query); 
	        	    //$result = $stmt->execute($query_params); 
	        	    //echo $db->lastInsertId();
	        	    if ($stmt->execute($query_params))
	        	    {
	        	    	
	        	    	return ($db->lastInsertId());
	        	    }	
	        	    else
	        	    {
	        	    	return false;
	        	    }
	        	} 
	        	catch(PDOException $ex) 
	        	{ 
	            	die("Failed to run query: " . $ex->getMessage()); 
	        	}
	        
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}

	function generateUniqueToken($number)
	{
	    $arr = array('a', 'b', 'c', 'd', 'e', 'f',
	                 'g', 'h', 'i', 'j', 'k', 'l',
	                 'm', 'n', 'o', 'p', 'r', 's',
	                 't', 'u', 'v', 'x', 'y', 'z',
	                 'A', 'B', 'C', 'D', 'E', 'F',
	                 'G', 'H', 'I', 'J', 'K', 'L',
	                 'M', 'N', 'O', 'P', 'R', 'S',
	                 'T', 'U', 'V', 'X', 'Y', 'Z',
	                 '1', '2', '3', '4', '5', '6',
	                 '7', '8', '9', '0');
	    $token = "";
	    for ($i = 0; $i < $number; $i++) {
	        $index = rand(0, count($arr) - 1);
	        $token .= $arr[$index];
	    }

	    
	        return $token;
	    
	}

	function insertTrack($tracking_id,$order_id)
	{
		$db = new DB();
		try 
		{			
			
				$query = " 
	            INSERT INTO track (id,order_id) VALUES ( 
	                :tracking_id, 
	                :order_id
	                
	                
	            ) 
	        	"; 
	               
	        	$query_params = array( 
	            	':tracking_id' => $tracking_id, 
	            	':order_id' => $order_id 
	           		
	            	
	        	); 
	         
	        	try 
	        	{ 
		            // Execute the query 
	    	        $stmt = $db->prepare($query); 
	        	    //$result = $stmt->execute($query_params); 
	        	    //echo $db->lastInsertId();
	        	    if ($stmt->execute($query_params))
	        	    {
	        	    	
	        	    	return true;
	        	    }	
	        	    else
	        	    {
	        	    	return false;
	        	    }
	        	} 
	        	catch(PDOException $ex) 
	        	{ 
	            	die("Failed to run query: " . $ex->getMessage()); 
	        	}
	        
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}
	
	function insertTrackDetails($tracking_id)
	{
		$db = new DB();
		try 
		{			
			
				$query = " 
	            INSERT INTO track_details (location,track_id) VALUES ( 
	                :location, 
	                :tracking_id
	                
	            ) 
	        	"; 
	               
	        	$query_params = array( 
					':location' => 'Pune',
					':tracking_id' => $tracking_id
	            	
	           		
	            	
	        	); 
	         
	        	try 
	        	{ 
		            // Execute the query 
	    	        $stmt = $db->prepare($query); 
	        	    //$result = $stmt->execute($query_params); 
	        	    //echo $db->lastInsertId();
	        	    if ($stmt->execute($query_params))
	        	    {
	        	    	
	        	    	return true;
	        	    }	
	        	    else
	        	    {
	        	    	return false;
	        	    }
	        	} 
	        	catch(PDOException $ex) 
	        	{ 
	            	die("Failed to run query: " . $ex->getMessage()); 
	        	}
	        
		}
 		catch (PDOException $e) {
   			 echo 'Connection failed: ' . $e->getMessage();
			 die();
		}
	}

}
$user = new users();

?>