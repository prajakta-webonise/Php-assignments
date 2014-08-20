<style>
a{
	display: block;
	padding: 5px;
	

}
</style>
<?php
require_once "includes/require.php";
//Displaying user name and menus.
echo '<span>Welcome&nbsp'. $_COOKIE['user_name'].'</span>'; 
echo '<a href="newProduct.php">New Order</a>
      <a href="uListOrders.php">Current Orders</a>
      <a href="uListOrdersDelivered.php">Previous Orders</a>';
  		
?>