<?php

if(!empty($_POST)) 
    { 
$uploaddir = '/var/www/assignment-5/uploaded_files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);


if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File successfully uploaded.\n";
}
else {
    echo "File upload fail!\n";
}


}
?>
<head><link rel="stylesheet" type="text/css" href="css/style.css"></head>
<body>
<div class="contents">
<div class="image">
<img src="images/bookshelf.jpg" alt="Bookshelf">
</div>
<div class=register>
<form enctype="multipart/form-data" action="upload_file.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    File to upload: <input name="userfile" type="file" /><br><br>
    Move file to folder: <input type="submit" value="Send File" />
</form>
<a href="menu.php">Menu</a><br />
</div>
</div>
</body>