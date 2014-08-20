<?php
require_once("includes/require.php");
require_once("header.php");
if(isset($_SESSION['user_id']))
{
  header("Location:dashboard.php");
}
?>
<div class="col-lg-3">
<img src="img/login.jpg"/>
</div>
<div class="col-lg-4">


<?php



if(isset($_POST['submit']))
{
  $userData['email'] = $_POST['email'];
  $userData['password'] = $_POST['password'];
  $message=NULL;
  if(!isEmpty($userData['email']) || !isEmpty($userData['password']))
  {
	   $message.="Please enter all the fields ";
		
  }
  /*if(!isEmpty($userData['password']))
  {
	   $message.="Password";	
  }*/
  else
  {
	  if($user->login($userData))
	  {
	    header("Location: dashboard.php");
      echo 'Done';
	  }
	  else
	  {
	    echo '<p class="text-danger">Invalid UserName or Password</p>';
	  }

  }
  if(isset($message))
  {
  	echo '<p class="text-danger">'.$message.'</p>';
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
<div class="col-lg-3">
</div>


