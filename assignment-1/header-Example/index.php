<!DOCTYPE html>
<html>
	<head>
		<title> SignIn Form </title>
	</head>
	<body>
		<?php include("authenticate.php"); ?>
		<form name="form" action="" method="post">
		<table>
			<tr>
				<td>Username: *<input type="text" name="username" value="<?php echo @$val_username; ?>"/></td>
				
			</tr>
			<tr>
				<td>Password: *<input type="password" name="password" value="<?php echo @$val_password; ?>"/></td>
				
			</tr>
			<tr>
			<td>
			<input type="submit" name="submit" value="Submit"/>
			</td>
			</tr>
		</table>
		
		</form>
	</body>
</html>