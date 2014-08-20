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
<?php
	if(isset($_POST['submit']))
	{
		
		$order_id = $_POST['orderid'];
		$status_id = $_POST['Status'];
		
		if($db->updateTrackDetails($status_id,$order_id))
		{
			echo'<p class="text-success">Successfully Updated.</p>';
		}
		else
		{
			echo'<p class="text-danger">Unsuccessfully to update.</p>';
		}
	}

?>
<?php
if(isset($_GET['id']))
{
	$result = $db->getOrderDetails($_GET['id']);
	$result2 = $db->getTrackDetails($_GET['id']);
	
?>	
<h3>Update Orders</h3>
	<form action="editOrders.php" method="post">
		<div class="form-group">
	      <label>Order ID : <?php echo $result['id'] ; ?></label>
	      <input type="hidden" class="form-control" name="orderid" id="orderid" value="<?php echo $result['id'] ; ?>" placeholder="Enter From Range">
	    </div>
	    <div class="form-group">
	      <label>Track ID : <?php echo $result2['id'] ; ?> </label>
	      <input type="hidden" class="form-control" name="trackid" id="trackid" placeholder="Enter From Range">
	    </div>
	    
	    <div class="form-group">
	      <label>To : <?php echo $result['to_name'] ; ?> </label>
	      
	    </div>
	    <div class="form-group">
	      <label>City : <?php echo $result['city'] ; ?> </label>
	      
	    </div>
	    <div class="form-group">
  		<label>Select Status</label>
  		<select name="Status">
  		<?php
  			
  			$opt = $db->getListStatus();
  			
  			foreach($opt as $value){
  				echo '<option value="'.$value['id'].'">'.$value['status'].'</option>';
  		}


  		?>
  		</select>
  		
		</div>
	    <button type="submit" name="submit" class="btn btn-default">Update</button>
        <button type="reset" class="btn btn-default">Reset</button>
    </form>
<?php

}
?>
</div>
<div class="col-lg-3">
</div>
<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>