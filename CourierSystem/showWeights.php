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
<h3>Weights</h3>
<table class="table">
<th>From</th>
<th>To</th>
<th>Price</th>
<th></th>

	<?php
		$result = $db->getListWeight();
		foreach($result as $value){
		echo '<tr>
				<td> 
				'.$value['from_range'].'
				</td>
				<td> 
					'.$value['to_range'].'
				</td>
				<td> 
					'.$value['price'].'
				</td>
				<td> 
					<a href="editWeights.php?id='.$value['id'].'">Edit</a>
				</td>
			 </tr>	';
		}
	?>
</table>
</div>
<div class="col-lg-3">
</div>

<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>


<?php
require_once("footer.php");
?>