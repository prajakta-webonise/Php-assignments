<?php

class X {
  $id;  
}

class_alias('X','Y');
class_alias('Y','Z');
$z = new ReflectionClass('Z');
echo $z->getName(); // X

?>