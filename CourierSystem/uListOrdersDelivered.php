<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['user_id']) AND $_SESSION['user_role'] == 1)
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
		$result = $db->getListNewOrders(1,$_SESSION['user_id']);
		foreach($result as $value){
		echo '<tr>
				<td> 
				'.$value['ID'].'
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