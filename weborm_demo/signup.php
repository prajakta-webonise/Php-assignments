<?php

require_once("header.php");

?>
<div class="col-lg-3">
<img src="img/signup.jpg"/>
</div>
<div class="col-lg-6">

<?php
	require_once('Datasource/Model.php');
	class users extends Model
	{
		var $first_name="";
		var $last_name="";
		var $email="";
		var $password="";
		var $manyToOne = array(
						'target_table' =>array('roles'),
						'join_type' => 'inner',
						'columns' => array ('users.first_name','users.last_name', 'roles.id'),
						//'group_by' => 'name',
						'order_by' =>'test.id DESC'
						);
	}
	$users =  new users();
	
	
	

	if(isset($_POST['submit']))
	{
		$users->first_name=$_POST['firstName'];
		$users->last_name=$_POST['lastName'];
		$users->email=$_POST['email'];
		$users->password=$_POST['password'];
		if($users->save())
  		{
			echo '<p class="text-success">Succefully inserted</p>';
			header("Refresh:3;url=login.php");
		}
		else
		{
			echo '<p class="text-danger">Failed to insert</p>';
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