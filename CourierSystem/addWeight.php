<?php
require_once("includes/require.php");
require_once("header.php");

if(!isset($_SESSION['user_id']) OR $_SESSION['user_role'] != 1)
{
  header("Refresh:3;url=index.php");
  echo '<p class="text-danger">Access Denied</p>';
}
else
{
?>
<div class="col-lg-6">
	<?php
		if(isset($_POST['submit']))
		{
			$weight['from'] = $_POST['from'];
			$weight['to'] = $_POST['to'];
			$weight['price'] = $_POST['price'];
			$message=NULL;
			if(isNumber($weight['from']) || !isEmpty($weight['from']))
			{
				$message .= "From Weight";
			}
			else if(isNumber($weight['to']) || !isEmpty($weight['to']))
			{
				$message .= "to Weight";
			}
			else if(isNumber($weight['price']) || !isEmpty($weight['price']))
			{
				$message .= "Price";
			}
			else
			{
				if($db->addPriceRange($weight))
				{
					echo '<p class="text-success">Successfully Added</p>';
				}
				else
				{
					echo 'Unsuccessfull to Add';
				}
			}
			if(isset($message))
			{
				echo '<p class="text-danger">Please Enter Valid '.$message.'</p>';
			}
		}

	?>
	<h3>Add Weight</h3>
	<form action="addWeight.php" method="post">
	<div class="form-group">
      <label>From</label>
      <input type="text" class="form-control" name="from" id="from" placeholder="Enter From Range">
    </div>
    <div class="form-group">
      <label>To</label>
      <input type="text" class="form-control" name="to" id="to" placeholder="Enter To Weight">
    </div>
    <div class="form-group">
      <label>Price</label>
      <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price">
    </div>
    <button type="submit" name="submit" class="btn btn-default">Add</button>
     <button type="reset" class="btn btn-default">Reset</button>
	</form>

</div>
<div class="col-lg-3">
</div>
<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>



<?php
}
require_once("footer.php");
?>