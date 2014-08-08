<?php
	$string1 = "PHP is a popular language general-purpose scripting language that is especially suited to language web development.";

	$string2 = "Fast, flexible and pragmatic, PHP powers everything from your blog to the most popular websites in the world.";

	$string3 = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';

	echo '<br><b>string1:</b> '.$string1;
	echo '<br><b>string2:</b> '.$string2;
	
	//1.Get string postion in $string1 $string = "language";
	echo '<br><br><b>1.Get postion  of language in $string1";</b>';
	$array=explode(" ",$string1);
	$i=0;
	$length=count($array);
	while($i<$length)
	{
		if($array[$i]=="language")
		{
			$i++;		
			echo '<br>Found language at: '.$i;
		}
		else
		{
			$i++;
		}
	}
	//2.Compare strings and print the differnce between two strings
	echo '<br><br><b>2.Compare strings and print the differnce between two strings</b>';
	if(strcmp($string1,$string2)==0) {
		echo '<br><b>-- > Strings are identical</b>';
	}
	elseif (strcmp($string1, $string2)<0) {
		echo '<br><b>-- > string1 is less than string2</b>';
	}
	else {
		echo '<br><b>-- > string2 is less than string1</b>';
	}
	//3.Get the count of words $string2 
	echo '<br><br><b>3.Get the count of words $string2 </b>';
	echo '<br><b>-- >'.str_word_count($string2);

	//4.Reverse and join both strings i.e ($string1 and $string2).
	echo '<br><br><b>4.Reverse and join both strings i.e ($string1 and $string2).</b>';
	$string1_reverse=strrev($string1);
	$string2_reverse=strrev($string2);
	echo '<br><b>-- > </b>'.$string1_reverse.$string2_reverse;

	//5.Count the string length of both strings and print the output.
	echo '<br><br><b>5.Count the string length of both strings and print the output.</b>';
	echo '<br><b>-- >Length of string1: </b>'.strlen($string1);
	echo '<br><b>-- >Length of string2: </b>'.strlen($string2);

	//6.Wrap $string1 after 10 characters and print the output.
	echo '<br><br><b>6.Wrap $string1 after 10 characters and print the output.<b>';
	echo '<b><br> -- ></b>'.wordwrap($string1, 10, "<br />", true);

	//7.Remove html tags from $string3 and print the output.
	echo '<br><br><b>7.Remove html tags from $string3 and print the output.</b>';
	echo '<br><b>-- ></b>'.strip_tags($string3);

	/*8.Alter the domain name of email address of following array and print the output;
	change the doamin name to = "weboniselab.com"
	*/
	echo '<br><br><b>8.Alter the domain name of email address of following array and print the output;
	change the doamin name to = "weboniselab.com"</b>';
	$email =array (
	1=>'harshal.shinde@gmail.com',
	2=>'hrishikesh@yahoo.co.in',
	3=>'xyz@yomail.com',
	);
	echo '<br><b>-- >Email</b>';
	print_r($email);
	echo '<br><b>Changed array: </b>';
	//$replace = array('gmail.com', 'yahoo.co.in', 'yomail.com');
	$a = array ('15','11','4');
	echo implode('; ', substr_replace($email, 'weboniselab.com',$a))."\n";

	/*9.Convert string into array and divide into following way
   - $string1 array into 5 parts
   - $string2 array into 6 parts */
   echo '<br><br><b>9.Convert string into array and divide into following way
   - $string1 array into 5 parts
   - $string2 array into 6 parts</b>';
   echo '<br><b> -- >String1 in 5 chunks:  </b>';
   $string1_array=str_split($string1,10); //chunk length 10
   print_r(array_chunk($string1_array, 5)); //chunk length 5
   echo '<br><b> -- >String2 in 6 chunks:  </b>';
   $string2_array=str_split($string2,5); //chunk length 10
   print_r(array_chunk($string2_array, 6)); //chunk length 6

   /*10.Removes the last word from a string.
	Sample string : 'remove last word from the string quick brown fox'
	Expected Output : remove last word from the string quick brown 
   */
	$string4='remove last word from the string quick brown fox';
	echo '<br><br><b>10.Removes the last word from a string.<br> Sample string: </b>'.$string4;
	$string_array=explode(' ',$string4);
	$length=count($string_array);
	$string_array[$length-1]='';
	$remove_last_word=implode(' ', $string_array);
	echo '<br><b>-- ></b>'.$remove_last_word;

	/*11.Round the following values with 1 decimal digit precision.
	Sample values and Output :
	1.65 --> 1.7
	1.65 --> 1.6
	-1.54 --> -1.5*/
	echo '<br><br><b>11.Round the following values with 1 decimal digit precision.</b>';
	echo '<br><b>-- ></b>'.round(1.65 ,1 ,PHP_ROUND_HALF_UP);
	echo '<br><b>-- ></b>'.round(1.65 ,1 ,PHP_ROUND_HALF_DOWN);
	echo '<br><b>-- ></b>'.round(-1.54 ,1 ,PHP_ROUND_HALF_UP);

	/*12. Display the colors in the following way :
	$color = array('white', 'green', 'red'')
	Output :
   	white, green, red,	*/
   	echo "<br><br><b>12. Display the colors in the following way :
	$color = array('white', 'green', 'red'')
	Output :
   	white, green, red,</b>";
   	$color = array('white', 'green', 'red');
   	echo '<br><b>-- ></b>'.implode(', ', $color);

   	/*13. Insert a new item in an array on any position.
	Expected Output :
	Original array : 
	1 2 3 4 5 
	After inserting '*' the array is :
	1 2 3 * 4 5*/
	echo '<br><br><b>13.Insert a new item in an array on any position.</b>';
	$original_array= array('1','2','3','4','5');
	$replacement= array('*');
	print_r($original_array);
	echo '<br><b>-- ></b>';
	array_splice($original_array, 3, 0, $replacement);
	print_r ($original_array);

	/*14.Do the operations intersect, merge, differnce
	$toppings1 = array("Pepperoni", "Cheese", "Anchovies", "Tomatoes");
	$toppings2 = array("Ham", "Cheese", "Peppers");*/
	echo '<br><br><b>14.Do the operations intersect, merge, differnce
	<br>$toppings1 = array("Pepperoni", "Cheese", "Anchovies", "Tomatoes")
	<br>$toppings2 = array("Ham", "Cheese", "Peppers")</b>';
	$toppings1 = array("Pepperoni", "Cheese", "Anchovies", "Tomatoes");
	$toppings2 = array("Ham", "Cheese", "Peppers");
	echo '<br><b>Intersection: </b>';
	print_r(array_intersect($toppings1, $toppings2));
	echo '<br><b>Merge: </b>';
	print_r(array_merge($toppings1, $toppings2));
	echo '<br><b>Difference: </b>';
	print_r(array_diff($toppings1, $toppings2));

	/*15.Count the number of characters values of given array and print it in array format.
	$email =array (
	1=>'harshal.shinde@gmail.com',
	2=>'hrishikesh@yahoo.co.in',
	3=>'xyz@yomail.com',
	);*/
	echo '<br><br>15.Count the number of characters values of given array and print it in array format.<b></b>';
	$email =array (
	1=>'harshal.shinde@gmail.com',
	2=>'hrishikesh@yahoo.co.in',
	3=>'xyz@yomail.com',
	);
	echo '<br><b>-- ><b/>';
	print_r(array_count_values($email));

	//16.create an array of $string1 and sort the array using sorting.
	echo '<br><b>16.create an array of $string1 and sort the array using sorting.</b>';
	$array_string1=explode(' ', $string1);
	
	natcasesort($array_string1);
	echo '<br><b>-- ></b>';
	foreach ($array_string1 as $value) {
		echo "  ".$value;
	}

	//17. Format the array using array_walk 
	echo '<br><br><b>17. Format the array using array_walk </b>';
	echo '<br><b>-- ></b>';
	$input_array = array('get', 'ready', 'for', 'cool');
	function alter(&$item1,$key,$prefix) {
		$item1="$prefix:$item1(KEY:$key)<br/>";
	}
	array_walk($input_array, 'alter', 'webonise');
	
	print_r($input_array);
?>