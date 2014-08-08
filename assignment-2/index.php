<!DOCTYPE html>
<html>
	<head>
		<title> Registration Form </title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<?php include("validate.php"); ?>
		<form id="form" name="form" action="" method="post">
		
		<table class="table">
			<tr>
				<td>Name: *<input class="name" type="text" name="name" value="<?php echo @$name; ?>"/></td>
				
			</tr>
			<tr>
				<td>Username:* <input class="username" type="text" name="username" value="<?php echo @$username; ?>"/></td>
				
			</tr>
			<tr>
				<td>Password:* <input class="password" type="password" name="password" value="<?php echo @$password; ?>"/></td>
				
			</tr>
			<tr>
				<td>Confirm Password: *<input class="confirm" type="password" name="confirm_password" value="<?php echo @$confirm_password; ?>"/></td>
				
			</tr>
			<tr>
				<td>Email: *<input class="email" type="text" name="email" value="<?php echo @$email; ?>"/></td>
				
			</tr>
			<tr>
				<td>Contact Number: *<input class="contact" type="text" name="contact_number" value="<?php echo @$contact_number; ?>"/></td>
				
			</tr>
			<tr>
			<td>
			<input class="submitButton" type="submit" name="submit" value="Submit"/>
			
			</td>
			</tr>
		</table>
		
		</form>
	</body>
</html>
