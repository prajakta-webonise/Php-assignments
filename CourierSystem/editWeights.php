<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['user_id']) || !$_SESSION['user_role'] == 1)
{
  header("Refresh:3;url=index.php");
  echo '<p class="text-danger">Access Denied</p>';
}
?>
<div class="col-lg-6">
	<h3>Edit Weight</h3>
	<?php
	if(isset($_POST['submit']))
	{
		$weight['order_id'] = $_POST['order_id'];
		$weight['from_range'] = $_POST['from'];
		$weight['to_range'] = $_POST['to'];
		$weight['price'] = $_POST['price'];

		$message = NULL;
		if(isNumber($weight['from_range']) || !isEmpty($weight['from_range']))
		{
			$message .= "From Weight";
		}
		else if(isNumber($weight['to_range']) || !isEmpty($weight['to_range']))
		{
			$message .= "to Weight";
		}
		else if(isNumber($weight['price']) || !isEmpty($weight['price']))
		{
			$message .= "Price";
		}
		else
		{
			if($db->updatePriceRange($weight))
			{
				echo '<p class="text-success">Successfully Updated</p>';
				header("Refresh:3;url=showWeights.php");
			}
			else
			{
				echo 'Unsuccessfull to Update';
			}
		}
		if(isset($message))
		{
			echo '<p class="text-danger">Please Enter Valid '.$message.'</p>';
		}
	}

	if(isset($_GET['id']))
	{
		
		if($result = $db->getWeightDetails($_GET['id']))
		{

	?>
	<form action="editWeights.php" method="post">
		<div class="form-group">
			<label>From</label>
			<input type="text" class="form-control" name="from" id="from" value="<?php echo $result['from_range']; ?>" placeholder="Enter From Weight"/>
		</div>
		<div class="form-group">
			<label>To</label>
			<input type="text" class="form-control" name="to" id="to" value="<?php echo $result['to_range']; ?>" placeholder="Enter To Weight"/>
		</div>
		<div class="form-group">
			<label>Price</label>
			<input type="text" class="form-control" name="price" id="price" value="<?php echo $result['price']; ?>" placeholder="Enter Price"/>
		</div>
		<input type="hidden" class="form-control" name="order_id" id="order_id" value="<?php echo $result['id']; ?>" />
		<button type="submit" name="submit" class="btn btn-default">Update</button>
		<button type="reset" class="btn btn-default">Reset</button>
	</form>
	<?php	
		}
		else
		{
			echo '<p class="text-danger">Invalid Weight Range Selected</p>';
		}
	}
	?>
</div>
<div class="col-lg-3">
</div>

<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>


<?php
require_once("footer.php");
?>