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
<div class="col-lg-3">
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
  <h3>Track Product</h3>
  <form action="trackingProduct.php" method="post">
    <div class="form-group">
      <label>Tracking Id</label>
      <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="Enter Tracking Id">
    </div>
     <button type="submit" name="submit" class="btn btn-default">Submit</button>
     <button type="reset" class="btn btn-default">Reset</button>
  </form>

</div>  


<div class="col-lg-3">
<?php require_once "signup.php"; ?>
</div>

<?php
require_once "footer.php";
?>