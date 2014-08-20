<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['userID']) AND $_SESSION['userRole'] == 1)
{
  header("Location:index.php");
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
		$result = $db->getListNewOrders(1);
		foreach($result as $value){
			$track_id=$db->getTrackDetails($value['ID']);
		echo '<tr>
				<td> 
				<a href="productDetails.php?track_id='.$track_id['id'].'">'.$value['ID'].'</a>
				</td>
				<td> 
					'.$value['ProductName'].'
				</td>
				<td> 
					'.$value['To1'].'
				</td>
				<td> 
					'.$value['From1'].'
				</td>
				<td> 
					'.$value['Date1'].'
				</td>
				<td> 
					'.$value['Date1'].'
				</td>
				<td> 
					'.$db->getStatus($value['ID']).'
				</td>
				<td> 
					<a href="editOrders.php?id='.$value['ID'].'">Edit</a>
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