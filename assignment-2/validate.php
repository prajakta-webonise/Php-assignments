<!DOCTYPE html>
<html>
	<head>
		<title> Registration Form </title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
	</head>
	<body>
<?php
	$data=array();
	if (isset($_POST['submit'])) {
		
		$name = $_POST['name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$email = $_POST['email'];
		$contact_number = $_POST['contact_number'];

		if(empty($name) || empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($contact_number))
		{
			echo '<center><br>Please fill all the fields</center>';
			$empty_flag=1;	
		}
		else 
		{
			$empty_flag=0;			
			//contact number validation
			if(!ctype_digit($contact_number) || strlen($contact_number)!=10)
			{
				echo '<center><br>Please enter 10 digit contact number</center>';
				$contact_flag=1;
			}
			else
			{
				$contact_flag=0;
			}
			//email validation
			if(!ereg("^[a-zA-Z0-9_.]+@[a-zA-Z]+.[a-zA-Z.]{2,5}$",$email))
			{
				echo '<center><br>Please enter a valid email</center>';	
				$email_flag=1;
			}
			else
			{
				$email_flag=0;
				
			}
			//password validation
			if(!ereg("([a-z])+([A-Z])+([0-9])+([$])",$password))
			{
				$password_flag=1;				
				echo '<center><br>weak password</center>';	
			}
			else
			{	
				$password_flag=0;
				
			}
			//confirm password validation
			if($confirm_password!=$password)
			{
				$confirm_flag=1;				
				echo '<center><br>Passwords do not match</center>';
			}
			else
			{
				$confirm_flag=0;
				
			}
			
		}

	}

?>
</body>
</html>
