<?php
if(!file_exists("/home/webonise/Desktop/files/welcome1.txt"))
{
	die("File not found");
}
else
{
 	$file=fopen("/home/webonise/Desktop/files/welcome1.txt","a+") or exit("Unable to open");
}


while(!feof($file)) {
  echo fgets($file). "<br>";
  }
  fputs ($file, "yyy");
fclose($file);
?>