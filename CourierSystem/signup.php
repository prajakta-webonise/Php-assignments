<?php
require_once("includes/require.php");
require_once("header.php");
require_once("classes/mailSender.php");
?>
<div class="col-lg-3">
<img src="img/signup.jpg"/>
</div>
<div class="col-lg-6">

<?php
	if(isset($_POST['submit']))
	{
		
		$userData['firstName'] = $_POST['firstName'];
		$userData['lastName'] = $_POST['lastName'];
		$userData['email'] = $_POST['email'];
		$userData['contact'] = $_POST['contact'];
		$userData['line1'] = $_POST['line1'];
		$userData['line2'] = $_POST['line2'];
		$userData['city'] = $_POST['city'];
		$userData['state'] = $_POST['state'];
		$userData['country'] = $_POST['country'];
		$userData['pincode'] = $_POST['pincode'];
		$userData['password'] = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$message=NULL;
		
		if(empty($userData['firstName']) || empty($userData['lastName']) || empty($userData['line1']) || empty($userData['line2']) || empty($userData['city']) 
			|| empty($userData['state']) || empty($userData['country']) || empty($userData['pincode']) || empty($userData['email']) || empty($userData['contact'])
			|| empty($userData['password']))
		{
			$message="Please enter all the fields";	
					
		
		}
		else
		{
				
			if(!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z]+.[a-zA-Z.]{2,5}$/",$userData['email']))
			{
				$message="Please enter a valid email";	
				
			}
			else if($user->checkUsernameExists($userData['email']))
			{
				$message="Email Already Exist";
			}
			else if(!ctype_digit($userData['pincode']) || strlen($userData['pincode'])!=6)
			{
				$message="Please enter 6 digit pincode";
				
			}
			else if(!ctype_digit($userData['contact']) || strlen($userData['contact'])!=10)
			{
				$message="Please enter 10 digit contact number";
				
			}
			else if(strlen($userData['password'])<6 || !preg_match("/([A-Za-z])+([0-9])+/",$userData['password']))
			{
				$message="Password must be of 6 characters and should have atleast 1 letter, 1 small letter and  1 digit";
			}
			else if($confirm_password!=$userData['password'])
			{
				$message="Passwords do not match";
			}


		}

		if(!isset($message))
		{
			
			if($user->insertUser($userData,true))
			{
				//header('Location:index.php');
				echo'<p class="text-success">Successfully Registered.</p>';
				$body = '<h4>Welcome to Courier System</h4>
					<h5>Dear,'.$userData['firstName'].'</h5>
					<p>Following are the credentials to login</p>
					<p>Username:'.$userData['email'].'</p>
					<p>Password:'.$userData['password'].'</p>
					<p>To login<a href="http://courierservices-rajapure.rhcloud.com/login.php"> Click Here</a></p>
						';
			$mail = new sendMail();

			$mail->sendEmail($userData['email'],"Registration",$body);

				
				
				header("Refresh:3;url=login.php");
			}
			else
			{

					echo 'Registration Failed';
			}
		}
		else
		{
			
			echo '<p class="text-danger">'.$message.'</p>';
		}
	}			
?>

	<h3>Signup</h3>
	<form action="signup.php" method="post">
		<div class="form-group">

			<div class="form-group"><input class="form-control" type="text" name="firstName" placeholder="First Name" value="<?php echo $_POST['firstName']; ?>"/></div>
			    
			   <div class="form-group"><input class="form-control" type="text" name="lastName" placeholder="Last Name" value="<?php echo $_POST['lastName']; ?>"/></div>
			    
			   <div class="form-group"><input class="form-control" type="text" name="line1" placeholder="Address line1" value="<?php echo $_POST['line1']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="line2" placeholder="Address Line2" value="<?php echo $_POST['line2']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="city" placeholder="City" value="<?php echo $_POST['city']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="state" placeholder="State" value="<?php echo $_POST['state']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="country" placeholder="country" value="<?php echo $_POST['country']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="pincode" placeholder="Pincode" value="<?php echo $_POST['pincode']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email Address" value="<?php echo $_POST['email']; ?>"/></div>
			    
			    <div class="form-group"><input class="form-control" type="text" name="contact" placeholder="Contact Number" value="<?php echo $_POST['contact']; ?>"/></div>
			    <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"/></div>
			    				
			    	<div class="form-group"><input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password"/></div>
			    				
			    			<button type="submit" name="submit" class="btn btn-default">Signup</button>
			   <button type="reset" class="btn btn-default">Reset</button>
		</div>
	</form>

</div>
<div class="col-lg-3">
</div>
<?php
require_once "footer.php";
?>