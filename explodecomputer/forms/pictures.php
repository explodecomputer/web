<?php include("password_protect.php");
include ("top.php");
?>
<head>
<title>explodecomputer.com by Gib Hemani</title>
<?
include ("meta.php");
?>
<link rel="stylesheet" type="text/css" href="general.css" />
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<?
include ("logo.php");

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
$cats = new enum_values('webentry','category'); $cats = $cats->values;
$types = new enum_values('webentry','tags'); $types = $types->values;
?>

<div id="containall">
<div id="container">

<form action="picinsert.php" method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box"><tr><td width="246">
	<p>Picture:</p><td width="246">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	<p><input name="pic" type="file" id="pic" style="color:white"></p> </td></tr><tr><td width="246">
	<p>Thumbnail:</p><td width="246">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	<p><input name="thumb" type="file" id="thumb" style="color:white"></p></td></tr></table>

	<p>Title:<br>
	<input type='text' name='Title' size=60/><br><br>
	Notes:<br>
	<textarea name='Entry' cols=80 rows=20></textarea></p>
</div>
</div>
<div id="sidebar">

	<p>Category:<br>
<?
foreach($cats as $cat)
{
?>	<input type='radio' name='Category' value='<? echo $cat; ?>'/> <? echo $cat; ?><br><?
}?>
	</p><p>Tags:<br>
<?php
foreach($types as $tag)
{
	echo "\t<input type='checkbox' name='Tags[]' value='$tag' /> $tag<br>".PHP_EOL;
}
?>
	<input type='text' name='Etags' /><br><br>
	YYYY-MM-DD hh:mm:ss:<br>
	<input type='text' name='Datecre' /><br><br>
	<input name="upload" type="submit" class="box" id="upload" value="Upload ">
</form>
</div>
</body>
</html>
