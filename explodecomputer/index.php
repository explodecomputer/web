<?php
require_once("globals.php");
require_once("func.php");
?>
<!DOCTYPE html>
<head>
<title>explodecomputer.com by Gib Hemani</title>
<script src="js/scroll.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/style.php" />
</head>


<body>
<div class=bar>
	<div class=title>
	<a href="http://www.explodecomputer.com/index.php">explodecomputer&#183com</a> by gibran hemani
	</div>
	
	<div class=scroll>
	<a href="javascript:pageScrollLeft();"><</a><a href="javascript:pageScrollRight();">></a>
	</div>
</div>


<div class=container>


<?
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

// tag pattern = string of 0s 1s that represent whether a tag is selected
// cat pattern = string of 0s 1s that represent whether a cat is selected

// initialise with all tags selected, 100 miles cat not selected
// if a tag is clicked then all 0s except that tag
// colour coordinate webentry divs for category?

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


for($i = ($nrows); $i > 0; $i--)
{
	$row = mysql_fetch_array($resweb);
	$tags = explode(",",$row['tags']);
	sort($tags);
	$n = count($tags);
?>
<div class=webentry id=entry<? echo $i; ?>>
<div class=webtitle>
<a href="page.php?id=<? echo $row['id']; ?>"><p><? echo $row['title']; ?></p></a>
</div>
<div class="webinfo">
<p><span class="picdate"><? echo $row['datecre']; ?></span><br/>
<?
for($j = 0; $j < $n; $j++)
{
?>
<a href="index.php?tag=<? echo $tagcodes[$tags[$j]]; ?>&amp;cat=<? echo implode("",$showcats); ?>"><? echo $tags[$j]; ?></a><?if($j != ($n-1)) echo "<br/>
";
}
?>
</p>
</div>
</div>

<?
}
?>
<div class=aboutentry id=entry0>

<div class=aboutinfo>
<a href="about.php?tag=<? echo implode("",$showtags); ?>&amp;cat=<? echo implode("",$showcats); ?>">_about</a>
</div>
</div>
</div>


<div class=settingsbox>
<a href="#"><div class=button>options</div></a>
<div class=settings>
<form action='redirect.php' name='choosetags' method='post' enctype="multipart/form-data">
<div class=cats><p>Categories:</p></div>
<div class=cats><p>
<?
$cats = new enum_values('webentry','category'); $cats = $cats->values;
$tags = new enum_values('webentry','tags'); $tags = $tags->values;

for($i = 0; $i < count($cats); $i++)
{
	if($showcats[$i] == 1)
	{
?>
	<input type=checkbox name ="chosencats[]" value=<? echo $cats[$i];?> checked=yes><? echo "$cats[$i]"; ?><br>
<?
	} else {
?>
	<input type=checkbox name ="chosencats[]" value=<? echo $cats[$i];?>><? echo "$cats[$i]"; ?><br>
<?
	}
}
?></p></div>
<div class=tags><p>Tags:</p></div>
<div class=tags><p>
<?
for($i = 0; $i < count($tags); $i++)
{
	if($showtags[$i] == 1)
	{
?>
	<input type=checkbox name ="chosentags[]" value=<? echo $tags[$i];?> checked=yes><? echo "$tags[$i]"; ?><br>
<?
	} else {
?>
	<input type=checkbox name ="chosentags[]" value=<? echo $tags[$i];?>><? echo "$tags[$i]"; ?><br>
<?
	}
	if(($i+1) % 4 == 0)
	{
?>
</p></div><div class=tags><p>
<?
	}
}
?>
</p></div><div class=tags><p><input type='submit' value='Update' class='btn' /></p></div></form></div></div>

</body>
</html>