<?php
//login.php
 
require_once 'common.php';
 
$error = "";
$username = "";
$password = "";
$login_ok = false; 
 
    //check if form is submitted 
    if(!empty($_POST)) 
    { 
     
		$username = $_POST['username'];
		$password = $_POST['password'];
 
		$userOptions = new UserOptions();
		if($userOptions->login($username,$password)){
            $login_ok = true; 
		}else {
			$login_ok = false;
			$error = "Incorrect username or password. Please try again.";
		}
	    //login successful
        if($login_ok) 
        { 
            		
            header("Location: menu.php"); 
            
        } 
        else 
        { 
            print("Login Failed."); 
        } 
    } 
     
?>

<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register> 
<h1>Login</h1> 
<form action="login.php" method="post"> 
	<label><?php echo $error; ?></label>
    Username:<br /> 
    <input type="text" name="username" value="" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Login" /> 
</form> 
<a href="register.php">Register</a>
</div>
</div>
</body>