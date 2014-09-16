<?php
	require_once("header.php");
	require_once('Model/Model.php');
?>
<div class="col-lg-3">
	<img src="img/login.jpg"/>
</div>
<div class="col-lg-4">
	<?php
		/**
		* class users which contains email and password pair
		*/
		class users extends model {
			public $email="";
			public $password="";
			public $condition = array();  

		}
		$users = new users();
		if(isset($_POST['submit'])) {
			$users->email=$_POST['email'];
			$users->password=$_POST['password'];
			$users->condition = array(
					  'where' => array("email" => $users->email, "password" => $users->password),
					  'and_or' => array('AND')
					  );
			
			$message=NULL;
			if(empty($users->email) || empty($users->password)) {
				   echo '<p class="text-danger">Please enter all the fields </p>';
			}
			else {
				$result = $users->search();
				if($result) {
					echo '<p class="text-success">Login successful.</p>';
				}
				else {
					echo '<p class="text-danger">Please enter valid email and password pair.</p>';
				}
			}
		}
	?>
	<h3>Login</h3>
	<form action="login.php" method="post">
		<div class="form-group">
			<label>Email address</label>
			<input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" class="form-control" name="password" id="password" placeholder="Password">
		</div>
		<button type="submit" name="submit" class="btn btn-default">Login</button>
		<button type="reset" class="btn btn-default">Reset</button>
	</form>
</div>  
<div class="col-lg-3"></div>
<?php
	require_once "footer.php";
?>

