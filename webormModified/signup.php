<?php
	require_once("header.php");
	require_once('Model/Model.php');
?>
<div class="col-lg-3">
	<img src="img/signup.jpg"/>
</div>
<div class="col-lg-6">
	<?php
		/**
		* class users have many to one relationship with roles
		*/
		class users extends model {
			public $first_name="";
			public $last_name="";
			public $email="";
			public $password="";
			public $manyToOne = array(
							'target_table' =>array('roles'),
							'join_type' => 'inner'
							);
		}
		$users =  new users();
		if(isset($_POST['submit'])) {
			$users->first_name=$_POST['firstName'];
			$users->last_name=$_POST['lastName'];
			$users->email=$_POST['email'];
			$users->password=$_POST['password'];
			$confirmPassword=$_POST['confirmPassword'];
					
			if(empty($users->first_name) || empty($users->last_name) || empty($users->email) || empty($users->password) )	{
				echo '<p class="text-danger">Please enter all the fields</p>';	
			}
			else {
				if(!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z]+.[a-zA-Z.]{2,5}$/",$users->email)) {
					echo '<p class="text-danger"> Please enter a valid email </p>';	
				
				} 
				else if(strlen($users->password)<6 || !preg_match("/([A-Za-z])+([0-9])+/",$users->password)) {
					echo '<p class="text-danger">Password must be of 6 characters and should have atleast 1 letter and  1 digit </p>';
				}
				else if($confirmPassword!=$users->password) {
					echo '<p class="text-danger"> Passwords do not match </p>';
				}
				else if($users->save()){
					echo '<p class="text-success">Sign Up successful. </p>';
					header("Refresh:3;url=login.php");
				}
				else {
					echo '<p class="text-danger">Failed to sign up.</p>';
				}
			}
		}			
	?>
	<h3>Signup</h3>
	<form action="signup.php" method="post">
		<div class="form-group">
			<div class="form-group"><input class="form-control" type="text" name="firstName" placeholder="First Name" /></div>
			<div class="form-group"><input class="form-control" type="text" name="lastName" placeholder="Last Name" /></div>
			<div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email Address" /></div>
			<div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"/></div>
			<div class="form-group"><input class="form-control" type="password" name="confirmPassword" placeholder="Confirm Password"/></div>
			<button type="submit" name="submit" class="btn btn-default">Signup</button>
			<button type="reset" class="btn btn-default">Reset</button>
		</div>
	</form>
</div>
<div class="col-lg-3"></div>
<?php
	require_once "footer.php";
?>