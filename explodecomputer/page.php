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


if(isset($_GET['id']))
{
	$id = $_GET['id'];
} else {
	header("Location: http://www.explodecomputer.com/index.php");
	exit;
}
if(isset($_GET['tag']))
{
	$currenttag = $_GET['tag'];
} else {
	$currenttag = 0;
}
if(isset($_GET['cat']))
{
	$currentcat = $_GET['cat'];
} else {
	$currenttag = 0;
}

$query = "SELECT `id`, `title`, `entry`, `tags`, `category`, `datecre` FROM `webentry` WHERE `id` = ".$id;
$resweb = mysql_query($query);
$entry = mysql_fetch_array($resweb);
$tags = new enum_values('webentry','tags'); $tags = $tags->values;

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

?>
<!DOCTYPE html>
<head>
<title><? echo $entry['title']; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id=container>

<div id=a>
<h1><? echo $entry['title']; ?></h1>
</div>

<div id=b>
<? echo $entry['entry']; ?>
</div>

<div id=c>
<p>Typing and design by <a href="mailto:explodecomputer@gmail.com">Gib Hemani</a></p>
<p><? echo $entry['datecre']; ?></p>
<div class=tags>|
<?
	$tags = explode(",",$entry['tags']);
	sort($tags);
	$n = count($tags);
	for($i = 0; $i < $n; $i++)
	{?>
		<a href="index.php?tag=<? echo $tagcodes[$tags[$i]]; ?>&amp;cat=<? echo $currentcat; ?>"><? echo $tags[$i]; ?></a> |
	<?}
?>
</div>


</div>

</div>
</body>
</html>