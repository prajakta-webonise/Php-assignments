<?php
require_once("header.php");

?>
<div class="col-lg-3">
<img src="img/login.jpg"/>
</div>
<div class="col-lg-4">


<?php
  require_once('Datasource/Model.php');
  class users extends Model
  {
     var $email="";
    var $password="";
    var $condition = array();    
  }
  $users =  new users();
  
  if(isset($_POST['submit']))
  {
    $users->email=$_POST['email'];
    $users->password=$_POST['password'];
    $users->condition = array(
              //'columns'=> array('name', 'address', 'id'),
              'where' => array("email" => $users->email, "password" => $users->password),
              'and_or' => array('AND')
              );
  
	  $result = $users->search();
    if($result)
    {
        
        echo 'Success';
          
    }
    else
    {
      echo 'No Records found.';
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


