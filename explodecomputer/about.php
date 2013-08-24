<!DOCTYPE html> 
<head> 
<title>Emerging from the variance</title> 
<link rel="stylesheet" type="text/css" href="css/style.css" /> 
</head> 
<body> 
<div id=container> 
 
<div id=a> 
<h1>About</h1> 
</div>

<?php
require_once("globals.php");
class enum_values
{
	public $values;
	public function __construct($table, $column)
	{
		$sql = "SHOW COLUMNS FROM $table LIKE '$column'";
		if ($result = mysql_query($sql))
		{
			$enum = mysql_fetch_object($result);
			preg_match_all("/'([\w ]*)'/", $enum->Type, $values);
			$this->values = $values[1];
		} else {
			die("Unable to fetch enum values: ".mysql_error());	
		}
	}
}
$cats = new enum_values('webentry','category'); $cats = $cats->values;
$tags = new enum_values('webentry','tags'); $tags = $tags->values;

if(isset($_GET['tag']))
{
	$showtags = $_GET['tag'];
	$showtags = preg_split('//', $showtags, -1, PREG_SPLIT_NO_EMPTY);
} else {
	$showtags = $tags;
	for($i = 0; $i < count($showtags); $i++)
	{
		$showtags[$i] = 1;
	}
}

if(isset($_GET['cat']))
{
	$showcats = $_GET['cat'];
	$showcats = preg_split('//', $showcats, -1, PREG_SPLIT_NO_EMPTY);
} else {
	$showcats = $cats;
	for($i = 0; $i < count($showcats); $i++)
	{
		if($cats[$i] != "locavorism")
		{
			$showcats[$i] = 1;
		} else {
			$showcats[$i] = 0;
		}
	}
}

$showtagnames = array();
for($i = 0; $i < count($showtags); $i++)
{
	if($showtags[$i] == 1)
	{
		$showtagnames[] = $tags[$i];
	}
}
$query = $query . ') AND ( ';
$showcatnames = array();
for($i = 0; $i < count($showcats); $i++)
{
	if($showcats[$i] == 1)
	{
		$showcatnames[] = $cats[$i];
	}
}

$query = "SELECT `id`, `title`, `tags`, `datecre` FROM `webentry` WHERE (FIND_IN_SET('";
$query = $query.implode("',category) > 0 OR FIND_IN_SET('",$showcatnames);
$query = $query."',category) > 0) AND (FIND_IN_SET('";
$query = $query.implode("',tags) > 0 OR FIND_IN_SET('",$showtagnames);
$query = $query."',tags) > 0) ORDER BY `datecre` ASC";
$resweb = mysql_query($query);
$nrows = mysql_num_rows($resweb);
?>
			<div id=b>
			<p>Hello.</p>
			<p>This site has been awkwardly knitted together with a litte bit of PHP and a little bit of MySQL. If you are here then you were probably looking for this specifically, and if you were looking for this specifically then I probably know you in person. Hi. How's it going? Remember that time with the thing in the place? Yeah, you still owe me money from that.</p>
			
			<p>Things yet to be done:</p>
			<ul>
				<li>Gallery</li>
				<li>Automatic html generation</li>
				<li>Error checking and admin login</li>
				<li>Macros for including pictures in posts</li>
				<li>Horizontal scrolling</li>
				<li>Make it look better</li>
			</ul>
			
			<p>Below are some boxes that you can tick. They will choose which tags and categories will be displayed on the main page. It took me ages when I should have been doing something else, so please try it out.</p>
			<form action='redirect.php' name='choosetags' method='post' enctype="multipart/form-data">
			<div class=cats>
			<p>Categories:</p>
			</div><div class=cats><p>
<?
for($i = 0; $i < count($cats); $i++)
{
	if($showcats[$i] == 1)
	{
?>
			<input type=checkbox name ="chosencats[]" value=<? echo $cats[$i];?> checked=yes> <? echo " $cats[$i]"; ?><br><?
	} else {
?>
			<input type=checkbox name ="chosencats[]" value=<? echo $cats[$i];?>> <? echo " $cats[$i]"; ?><br><?
	}
}
?>
			</p>
			</div>
			<div class=tags>
			<p>Tags:</p></div>
			<div class=tags><p>
<?
for($i = 0; $i < count($tags); $i++)
{
	if($showtags[$i] == 1)
	{
?>
			<input type=checkbox name ="chosentags[]" value=<? echo $tags[$i];?> checked=yes> <? echo " $tags[$i]"; ?><br><?
	} else {
?>
			<input type=checkbox name ="chosentags[]" value=<? echo $tags[$i];?>> <? echo " $tags[$i]"; ?><br><?
	}
	if(($i+1) % 4 == 0)
	{
?>
			</p></div><div class=tags><p>
<?
	}
}
?>
			</p></div><div class=tags><input type='submit' value='Update' /></div></form>

</div>
<div id=c>
</div>
<?
$tagcodes = array();
for($i = 0; $i < count($tags); $i++)
{
	$code = array();
	for($j = 0; $j < count($tags); $j++)
	{
		if($j == $i)
		{
			$code[] = 1;
		} else {
			$code[] = 0;
		}
	}
	$code = implode("",$code);
	$tag = $tags[$i];
	$tagcodes[$tag] = $code;
}
