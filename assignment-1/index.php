<?php
	$string1="PHP parses a file by looking for <br/> one of the special tags that tells it to start interpreting the text as PHP code. The parser then executes all 	of the code it finds until it runs into a PHP closing <br/> tag.";
	echo '<br><br>This is string1: '.$string1;
	$string2="PHP does not require (or support) explicit type definition in variable declaration; a variable's type is determined by the context in which the 		variable is used.";
	echo '<br><br> This is string2: '.$string2;
	//Find occurance of PHP from string 1
	echo '<b><br>Find occurance of PHP from string 1</b>';
	$occurance=substr_count($string1, 'PHP'); 
	echo '<br><br> Occurance of PHP in string1: '.$occurance;

//Find the position where PHP occures in the string 1.
echo '<b><br>Find the position where PHP occures in the string 1.</b>';
	$array=explode(" ",$string1);
	$i=0;
	$length=count($array);
	while($i<$length)
	{
		if($array[$i]=="PHP")
		{
			$i++;		
			echo '<br>Found PHP at: '.$i;
		}
		else
		{
			$i++;
		}
	}

	//Capitalise string 1
	echo '<b><br>Capitalise string 1</b>';
	echo '<br><br>String1 in uppercase : '.strtoupper($string1);

	//Combine string 1 & 2.
	echo '<b><br>Combine string 1 & 2.</b>';
	echo '<br><br>Two strings concatenated : '.$string1.$string2;

	//Echo string 1 & 2 using heredoc
echo '<b><br>Echo string 1 & 2 using heredoc</b>';
$str = <<<HEREDOC
<br>$string1 $string2
HEREDOC;
echo '<br><br> use of heredoc to concatenate'.$str;

//Print current date
echo '<b><br>Print current date</b>';
echo '<br><br>Current date: '.date("Y/m/d");

//print 12th Jan 2012
echo '<b><br>print 12th Jan 2012</b>';
echo '<br>'.date('jS M Y', mktime(0, 0, 0, 1, 12, 2012));

//add 7 days in current date
echo '<b><br>add 7 days in current date</b>';
$date = strtotime("+7 day");
echo '<br><br>Date after 7 days from now: '.date('M d, Y', $date);


//Cut the string 1 into 4 parts & print it.
echo '<b><br>Cut the string 1 into 4 parts & print it.</b>';
$stringLength=strlen($string1);
$partSize=$stringLength/4;
$array2 = str_split($string1, $partSize);
echo '<br><br> String in 4 parts: ';
print_r($array2);

//Divide the string 1 by occurances of '.'. Combine the array in reverse word sequence
echo '<b><br>Divide the string 1 by occurances of '.'. Combine the array in reverse word sequence</b>';
$array1=explode(".",$string1);
echo'<br><br> Split by . and reverse array: ';
print_r($array1);
$arrayLength=count($array1);
echo $arrayLength;
$j=0;
while($arrayLength>0)
{
	$reverseArray[$j]=$array1[$arrayLength-1];
	$arrayLength--;
	$j++;
}
print_r($reverseArray);

//Remove the HTML characters from string.
echo '<b><br>Remove the HTML characters from string.</b>';
$htmlString='<html> <span> hello world </span></html>';
echo '<br><br>String without HTML tags: '.strip_tags($htmlString);

//Find the length of string 1 & 2
echo '<b><br>Find the length of string 1 & 2</b>';
echo '<br><br>Length of string1: '.strlen($string1);
echo '<br><br>Length of string2: '.strlen($string2);

//Create file & write string 1 to that file using PHP functions.
echo '<b><br>Create file & write string 1 to that file using PHP functions.</b>';
$fileName='File.txt';
file_put_contents($fileName, $string1);
echo '<br><br>The contents of string1 are written to file '.$fileName;

//Print all Global varibles provided by PHP
echo '<b><br>Print all Global varibles provided by PHP</b>';
echo '<br><br>Global variables: ';
print_r($GLOBALS);
//Print the 'PHP' word from string 1 by traversing it using string functions

echo '<b><br>Print the "PHP" word from string 1 by traversing it using string functions</b>';
if(strstr($string1, 'PHP') == TRUE) {
	
	$occurance=substr_count($string1, 'PHP');
    echo '<br><br>"PHP"  found in string for '.$occurance.'times';
}

//Compare two dates. (12-4-2010 & 12-5-2011). Calculate the days between these two dates.
echo '<b><br>Compare two dates. (12-4-2010 & 12-5-2011). Calculate the days between these two dates.</b>';
$startDate = date_create('2010-4-12');
$endDate = date_create('2009-5-12');
$difference = date_diff($startDate, $endDate);
echo '<br><br>Difference between dates 2010-4-12 and 2009-5-12 is'.$difference->format('%R%a days');

//add 20 days to current date
echo '<b><br>add 20 days to current date</b>';
$date = strtotime("+20 day");
echo '<br><br>Date after 20 days from now: '.date('M d, Y', $date);
//date in array format
echo '<b><br>date in array format</b>';
$date=getdate();
echo '<br>'.$date['mday'].$date['month'].$date['year'];
?>

