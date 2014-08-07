<?php
	//download a txt file
	header('Content-Disposition: attachment; filename="file.txt"');
	echo 'File download successful!';
?>