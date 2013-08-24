<?php
require_once("globals.php");
class enum_values
{
	public $values;
	public function __construct($table, $column)
	{
		$sql = "SHOW COLUMNS FROM $table LIKE '$column'";
		if ($result = mysql_query($sql)) { // If the query's successful			
			$enum = mysql_fetch_object($result);
			preg_match_all("/'([\w ]*)'/", $enum->Type, $values);
			$this->values = $values[1];
		} else {
			die("Unable to fetch enum values: ".mysql_error());	
		}
	}
}
function fast_in_array($elem, $array) 
{ 
	$top = sizeof($array) -1; 
	$bot = 0; 
	while($top >= $bot)
	{
		$p = floor(($top + $bot) / 2);
		if ($array[$p] < $elem) $bot = $p + 1;
		elseif ($array[$p] > $elem) $top = $p - 1;
		else return TRUE;
	}
	return FALSE;
}

$cats = new enum_values('webentry','category'); $cats = $cats->values;
$tags = new enum_values('webentry','tags'); $tags = $tags->values;

if(isset($_POST['chosentags']))
{
	$chosenT = $_POST['chosentags'];
	$showtags = $tags;
	$i = 0;
	foreach($showtags as $tag)
	{
		if(in_array($tag,$chosenT))
		{
			$showtags[$i] = 1;
		} else {
			$showtags[$i] = 0;
		}
		$i++;
	}
	$showtags = implode("",$showtags);

	$chosenC = $_POST['chosencats'];
	$showcats = $cats;
	$i = 0;
	foreach($showcats as $cat)
	{
		if(in_array($cat,$chosenC))
		{
			$showcats[$i] = 1;
		} else {
			$showcats[$i] = 0;
		}
		$i++;
	}
	$showcats = implode("",$showcats);

	$loc = "Location: http://www.explodecomputer.com/index.php?tag=".$showtags."&cat=".$showcats;
	header($loc);
	exit;
} else {
	header("Location: http://www.explodecomputer.com/index.php");
	exit;
}

