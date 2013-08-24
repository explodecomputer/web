<?php include("password_protect.php");
?>
<head>
<title>explodecomputer.com by Gib Hemani</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
<?
require_once("../globals.php");

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

<div id="textarea">

<form name="files" method="post">
	<p>How many files to upload: <input name="nfiles" type="text" id="nfiles" maxlength="2" size=3/>
	<input type="submit" name="Go" value="Go"/></p>
</form>


<form action='websql.php' method='post' enctype="multipart/form-data">
<?
if($_POST['nfiles'] > 0)
{
	$nfiles = $_POST['nfiles'];
	for($i=0;$i<$nfiles;$i++)
	{
	?>
		<input name="upfile<? echo $i;?>" type="file" id="upfile<? echo $i;?>" style="color:white;"/><br>
	<?
	}
	?>
	<p><input name="nfiles" type="hidden" value="<? echo $nfiles;?>"/>
<?
}
?>
	<p>Title:<br>
	<input type='text' name='Title' size=60/><br><br>
	Entry:<br>
	<textarea name='Entry' cols=75 rows=30></textarea></p>
</div>
<div id="partition" style="text-align: right;"><p>
	Category:<br>
<?
foreach($cats as $cat)
{
	echo "\t$cat <input type='radio' name='Category' value='$cat'/><br>".PHP_EOL;
}
echo "\t<br>Tags:<br>".PHP_EOL;
foreach($types as $tag)
{
	echo "\t$tag <input type='checkbox' name='Tags[]' value='$tag'/><br>".PHP_EOL;
}
?>
	<input type='text' name='Etags' size='15'/><br><br>
	YYYY-MM-DD<br>hh:mm:ss:<br>
	<input type='text' name='Datecre' size='15'/><br></p>
	<p><input type='submit' value='MAKE THIS PAGE'/></p>



</div>

</form>
</body>
</html>
