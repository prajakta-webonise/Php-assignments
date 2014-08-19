<style>
a{
	display: block;
	padding: 5px;
	

}
</style>
<?php
//Displaying user name and menus.
echo '<span>Welcome&nbsp'. $_COOKIE['user_name'].'</span>'; 
echo '<a href="adListOrders.php">List of New Orders</a>
  	  <a href="adListOrdersDelivered.php">Delivered Products</a>
  	  <a href="addWeight.php">Add Weight</a>
  	  <a href="updateDispatch.php">Dispatch New Orders</a>
  		';

?>