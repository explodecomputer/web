<?php include("password_protect.php"); ?>
<head>
<title>explodecomputer.com by Gib Hemani</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
<?
require_once("../globals.php");

$sql = "SELECT `id`, `title` FROM `webentry`";
$result = mysql_query($sql);
$values = array(0);
$titles = array("NULL");
while($enum = mysql_fetch_array($result))
{
	array_push($values,$enum[0]);
	array_push($titles,$enum[1]);
}
?>
<div id="textarea">
<form action='editentry.php' method='post' enctype="multipart/form-data">
<p><select name="title">
<?
	$count = count($values);
	for($i = 0; $i < $count; $i++)
	{
		echo "<option value=".$values[$i].">".$titles[$i]."</option>";
	}
?>
</select><br>
<input name="Upload" type="submit" value="Edit"/>
</form>
</div>
</body>
</html>