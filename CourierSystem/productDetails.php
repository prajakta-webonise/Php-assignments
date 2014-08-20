<?php
require_once("includes/require.php");
require_once("header.php");
?>
<div class="col-lg-4">

<?php
	
	if(isset($_GET['track_id']))
	{	
		$track_id=$_GET['track_id'];
		
	}
	
			$order_id = $db->getOrderId($track_id);
			
			if($order_id)
			{
				$result= $db->getOrderDetails($order_id);
				$status = $db->getStatus($order_id);
				$productName= $db->getProductName($order_id);
				$fromAddress= $db->getFromAddress($order_id);
				echo '<p>Product Name:<br><label>   '.$productName['name'].'</label></p>
					<p>To: <br><label>'.$result['to_name'].'</label></p>
					<p>Address: <br><label>'.$result['address_line1'].'  '.$result['address_line2'].'  '.$result['city'].'  '.$result['state'].'  '.$result['country'].'  '.$result['pincode'].'</label></p>
					<p>From: <br><label>'.$fromAddress['first_name'].' '.$fromAddress['last_name'].'</label></p>
					<p>Address: <br><label>'.$fromAddress['address_line1'].'  '.$fromAddress['address_line2'].'  '.$fromAddress['city'].'  '.$fromAddress['state'].'  '.$fromAddress['country'].'  '.$fromAddress['pincode'].'</label></p>
					<p>Tracking Id: <br><label>'.$_GET['track_id'].'</label></p>
					<p>Order Id: <br><label>'.$order_id.'</label></p>
					<p>Delivery Status: <br><label>'.$status.'</label></p>';				
			}
			else
			{

				echo '<p class="text-danger"> Tracking id does not exists </p>';
			}
			
	
			
				
?>

	
</div>

<div class="col-lg-3">

</div>
<div class="col-lg-4">
<img src="img/track.png"/>
</div>