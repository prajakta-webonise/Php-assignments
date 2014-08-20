<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['user_id']) || !$_SESSION['user_role'] == 1)
{
  header("Refresh:3;url=index.php");
  echo '<p class="text-danger">Access Denied</p>';
}
?>
<div class="col-lg-9">
<table class="table">
<th>Order ID</th>
<th>Product Name</th>
<th>To</th>
<th>From</th>
<th>Date</th>
<th>Status</th>
	<?php 
		
		$result = $db->getListNewOrders(0,$_SESSION['user_id']);
		

		foreach($result as $value){
			$track_id=$db->getTrackDetails($value['ID']);
			
		echo '<tr>
				<td><a href="productDetails.php?track_id='.$track_id['id'].'">'.$value['ID'].'</a>

				</td>
				<td> 
					'.$value['ProductName'].'
				</td>
				<td> 
					'.$value['To1'].'
				</td>
				<td> 
					'.$value['From_Name'].'
				</td>
				<td> 
					'.$value['Date1'].'
				</td>
				<td> 
					'.$db->getStatus($value['ID']).'
				</td>
				
			 </tr>	';
		}
	?>
</table>
</div>

<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>


<?php
require_once("footer.php");
?>