<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['user_id']) OR $_SESSION['user_role'] != 3)
{
  header("Refresh:3;url=index.php");
  echo '<p class="text-danger">Access Denied</p>';
}
else 
{
?>
<div class="col-lg-6">


<?php
echo $_SESSION['user_role'];
	if(isset($_POST['submit']))
	{
		$userData['productName'] = $_POST['productName'];
		$userData['productWeight'] = $_POST['productWeight'];
		$userData['to'] = $_POST['to'];
		$userData['line1'] = $_POST['line1'];
		$userData['line2'] = $_POST['line2'];
		$userData['city'] = $_POST['city'];
		$userData['state'] = $_POST['state'];
		$userData['country'] = $_POST['country'];
		$userData['pincode'] = $_POST['pincode'];
		$userData['message'] = $_POST['message'];
		$userData['contact'] = $_POST['contact'];
		$message=NULL;

		if(empty($userData['productName']) || empty($userData['productWeight']) || empty($userData['line1']) || empty($userData['line2']) || empty($userData['city']) 
			|| empty($userData['state']) || empty($userData['country']) || empty($userData['pincode']) || empty($userData['message']) || empty($userData['contact'])
			|| empty($userData['to']))
		{
			$message="Please enter all the fields";	
					
		
		}
		else if(!ctype_digit($userData['contact']) || strlen($userData['contact'])!=10)
			{
				$message="Please enter 10 digit contact number";
				
			}
		if(!isset($message))
		{
			$order_id=$user->insertProduct($userData);
			if($order_id)
			{
				echo'<p class="text-success">Successfully placed an ordered.</p>';
				
				$uniqueToken=$user->generateUniqueToken(2);
				$tracking_id=$uniqueToken.date('Ymd').date('His');
				$user->insertTrack($tracking_id,$order_id);
				$user->insertTrackDetails($tracking_id);
				
					
				
				
				
				;
			}
			else
			{

					echo 'Order Failed';
			} 
		}
		else
		{
			echo $message;
		}
	}			
?>

	<h3>New Order</h3>
	<form action="newProduct.php" method="post">
		<div class="form-group">

			<table class="table">
				<tr>
			    	<td><!--<div><input class="form-control" type="text" name="productName" placeholder="Product Name"/></div> -->
			    Product Name <select name = "productName">
				  <option value="1">Television</option>
				  <option value="2">Printer</option>
				  <option value="3">Laptop</option>
				  <option value="4">Documents</option>
				</select>
			</td>
			    </tr>
			    <tr>
			    	<td><div class="form-group">
  		<label>Select weight</label>
  		<select name="productWeight">
  		<?php
  			
  			$opt = $db->getListWeight();
  			
  			foreach($opt as $value){
  				echo '<option value="'.$value['id'].'">'.$value['from_range'].'&nbsp;-&nbsp;'.$value['to_range'].'</option>';
  		}


  		?>
  		</select></td>
			    
			    </tr>
			    
			    <tr>
			    	<td><div><input class="form-control" type="text" name="to" placeholder="To"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="line1" placeholder="Address Line1"/></div></td>
			    
			    </tr>
			    
			    <tr>
			    	<td><div><input class="form-control" type="text" name="line2" placeholder="Address Line2"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="city" placeholder="City"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="state" placeholder="State"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="country" placeholder="country"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="pincode" placeholder="Pincode"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="message" placeholder="Message"/></div></td>
			    
			    </tr>
			    <tr>
			    	<td><div><input class="form-control" type="text" name="contact" placeholder="Contact Number"/></div></td>
			    
			    </tr>
			    

			</table>
			<button type="submit" name="submit" class="btn btn-default">Place Order</button>
			   <button type="reset" class="btn btn-default">Reset</button>
		</div>
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