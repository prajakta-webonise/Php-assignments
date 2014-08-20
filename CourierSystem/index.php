<?php
require_once "includes/require.php";
require_once "header.php";
if(isset($_SESSION['user_id']))
{
  header("Location:dashboard.php");
}
?>

<div class="col-lg-6">
<img src="img/frontimg.jpg">
</div>
<div class="col-lg-6">
 <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#trackid" role="tab" data-toggle="tab">Track Product</a></li>
  <li><a href="#login" role="tab" data-toggle="tab">Login</a></li>
  <li><a href="#signup" role="tab" data-toggle="tab">Signup</a></li>
  
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade in active" id="trackid">
   
  <form action="trackingProduct.php" method="get">
    <div class="form-group">
      <label>Tracking Id</label>
      <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="Enter Tracking Id">
    </div>
     <button type="submit" name="submit" class="btn btn-default">Track</button>
     <button type="reset" class="btn btn-default">Reset</button>
  </form>

  </div>
 

   <div class="tab-pane fade" id="login">
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


      <div class="form-group"><input class="form-control" type="text" name="firstName" placeholder="First Name" value="<?php echo $_POST['firstName']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="lastName" placeholder="Last Name" value="<?php echo $_POST['lastName']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="line1" placeholder="Address line1" value="<?php echo $_POST['line1']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="line2" placeholder="Address Line2" value="<?php echo $_POST['line2']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="city" placeholder="City" value="<?php echo $_POST['city']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="state" placeholder="State" value="<?php echo $_POST['state']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="country" placeholder="country" value="<?php echo $_POST['country']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="pincode" placeholder="Pincode" value="<?php echo $_POST['pincode']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email Address" value="<?php echo $_POST['email']; ?>"/></div>

      <div class="form-group"><input class="form-control" type="text" name="contact" placeholder="Contact Number" value="<?php echo $_POST['contact']; ?>"/></div>

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