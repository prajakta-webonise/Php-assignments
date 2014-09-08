<?php
	require_once "header.php";
?>

<div class="col-lg-6">
	<img src="img/blog.jpg">
</div>
<div class="col-lg-6">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li><a href="#login" role="tab" data-toggle="tab">Login</a></li>
	  <li><a href="#signup" role="tab" data-toggle="tab">Signup</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade in active" id="login">
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
		<div class="tab-pane fade" id="signup">
			<form action="signup.php" method="post">
				<div class="form-group"><input class="form-control" type="text" name="firstName" placeholder="First Name" /></div>
				<div class="form-group"><input class="form-control" type="text" name="lastName" placeholder="Last Name" /></div>
				<div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email Address"/></div>
				<div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"/></div>
				<div class="form-group"><input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password"/></div>
				<button type="submit" name="submit" class="btn btn-default">Signup</button>
				<button type="reset" class="btn btn-default">Reset</button>
			</form>
		</div>
	</div>
</div>
<?php
	require_once "footer.php";
?>