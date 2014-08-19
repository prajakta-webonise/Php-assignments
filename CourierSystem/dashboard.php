<?php
require_once("includes/require.php");
require_once("header.php");
if(!isset($_SESSION['user_id']))
{
  header("Location:index.php");
}
?>
<div class="col-lg-9">
	<img src="img/frontimg.jpg" alt="bookshelf"/>
</div>

<div class="col-lg-3">
<?php require_once($user->userDashboard()); ?>

</div>



<?php
require_once("footer.php");
?>