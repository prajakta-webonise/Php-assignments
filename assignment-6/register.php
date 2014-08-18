<?php
//register.php
 
require_once 'common.php';
 
//initialize php variables used in the form
$username = "";
$password = "";
$email = "";
$error = "";
$error_email = "";
$userOptions = new UserOptions();
$empty_flag=0;

//check to see that the form has been submitted
if(!empty($_POST)) { 
 
    //retrieve the $_POST variables
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(empty($username) || empty($password) || empty($email)) { 
     
        echo 'Please enter all the fields';
        $empty_flag=1; 
    } 
    else if(!empty($username) && !empty($password) && !empty($email)){

        if($userOptions->checkUsername($username))
        {
            $error='Username is already taken.';
            $empty_flag = 1;
        }
		if($userOptions->checkEmail($email))
        {
            $error_email='Email is already registered';
            $empty_flag = 1;
        }
		
    }
    else {
        $empty_flag=0;
    }
    if($empty_flag==0) {


        $data['username'] = $username;
        $data['password'] = $password; 
        $data['email'] = $email;
    
 
        //create the new user object
        $newUser = new user($data);
 
        //save the new user to the database
        $newUser->save();
		header("Location: register.php"); 
    }    
  
    
 
}
 

?>
<html> 
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<h1>Register</h1> 
<form action="register.php" method="post"> 
    Username:<br /> 
    <input type="text" name="username" value="<?php echo $username; ?>" /> 
    
    <label><?php echo $error; ?></label>
    <br /><br /> 
    E-Mail:<br /> 
    <input type="text" name="email" value="<?php echo $email; ?>" /> 
	<label><?php echo $error_email; ?></label>
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Register" /> 
	<a href="login.php">Login</a><br />
</form>
</div>
</div>
</body>
</html>