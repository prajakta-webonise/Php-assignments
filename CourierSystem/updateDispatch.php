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
	$result = $db->query("SELECT `track_details`.`id` FROM `track` , `orders`  , `track_details` , `status`  WHERE `track`.`order_id` = `orders`.`id`  AND `track`.`id` = `track_details`.`track_id` AND `status`.`id` = `track_details`.`status_id` AND `orders`.`date_time` BETWEEN DATE_SUB(NOW(),INTERVAL 1 DAY) AND Now() AND `status`.`id`=1");
	$trackid=$result->fetchAll(PDO::FETCH_ASSOC);
	if($trackid)
	{
		foreach($trackid as $id)
			$db->query("UPDATE track_details SET status_id= 2 WHERE id=".$id['id']);

		echo '<p class="text-success">Successfull Dispatched</p>';
	}
	else
	{
		echo '<p class="text-danger">No orders to Dispatch</p>';
	}


?>
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