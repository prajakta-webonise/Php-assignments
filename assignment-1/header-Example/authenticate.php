<?php
	//if username is webonise and password is webonise6186 then redirect to success.php else same same page
	if (isset($_POST['submit'])) {
	
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if($username=="webonise" && $password=="webonise6186")
		{
			header("location:success.php");
		}
		else
		{
			header("location:index.php");
		}
	}
?>