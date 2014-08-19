<?php
require_once("includes/require.php");
require_once("header.php");
?>
<div class="col-lg-3">

<?php
	
	if(isset($_POST['submit']))
	{	
		$track_id=$_POST['tracking_id'];
		if(!isEmpty($track_id))
		{
		   echo 'Please enter Tracking Id';
		
		}
		else
		{
		
			$order_id = $db->getOrderId($track_id);
			
			if($order_id)
			{
				$result= $db->getOrderDetails($order_id);
				$status = $db->getStatus($order_id);
				$productName= $db->getProductName($order_id);
				$fromAddress= $db->getFromAddress($order_id);
				
			}
			else
			{

				echo 'Tracking id does not exists';
			}
			
		}
	}		
			/*if($user->insertUser($userData,true))
			{
				//header('Location:index.php');
				echo'<p class="text-success">Successfully Registered.</p>';
				echo'<p>Click Here to <a href="login.php">Login</a></p>';
			}
			else
			{

					echo 'Registration Failed';
			}*/
		
				
?>

	<h3>Track Product</h3>
	<form action="trackingProduct.php" method="post">
		<div class="form-group">
			<label>Tracking Id</label>
      		<input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="Enter Tracking Id">
      	</div>
      		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-default">Submit</button>
     		<button type="reset" class="btn btn-default">Reset</button>
     	</div>
			<div class="form-group">
			<p><label><?php echo 'Product Name: <br>  '.$productName['name']; ?></label></p>
			<p><label><?php echo 'To: <br>'.$result['to_name']; ?></label></p>
			<p><label><?php echo 'Address: <br>'.$result['address_line1'].'  '.$result['address_line2'].'  '.$result['city'].'  '.$result['state'].'  '.$result['country'].'  '.$result['pincode']; ?></label></p>
			<p><label><?php echo 'From: <br>'.$fromAddress['first_name'].' '.$fromAddress['last_name']; ?></label></p>
			<p><label><?php echo 'Address: <br>'.$fromAddress['address_line1'].'  '.$fromAddress['address_line2'].'  '.$fromAddress['city'].'  '.$fromAddress['state'].'  '.$fromAddress['country'].'  '.$fromAddress['pincode']; ?></label></p>
			<p><label><?php echo 'Tracking Id: <br>'.$_POST['tracking_id']; ?></label></p>
			<p><label><?php echo 'Order Id: <br>'.$order_id; ?></label></p>
			<p><label><?php echo 'Delivery Status: <br>'.$status; ?></label></p>
			
		</div>
	</form>
</div>
