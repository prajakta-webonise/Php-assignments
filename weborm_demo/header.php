<?php
  
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/bootstrap.css"/>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<title>WebORM</title>
</head>
<body>
	
  <div class="container">
    <nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">WebORM</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <?php
      if(!isset($_SESSION['user_id']))
      {
    ?>
         <div class="navbar-right">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
          </ul>
        </div>
    <?php
      }
      else
      {
    ?>
        <div class="navbar-right">
        
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
         </ul>
        </div>
    <?php
      }
      
    ?>
    </div><!-- /.navbar-collapse -->
  
</nav>
