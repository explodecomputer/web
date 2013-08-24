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

<div id="containall">
<div id="container">
<form name="files" method="post">
	<p>How many files to upload: <input name="nfiles" type="text" id="nfiles" maxlength="2" size=3/><input type="submit" name="Go" value="Go"/></p>
</form>

<form action='fileinsert.php' method='post' enctype="multipart/form-data">
<p>
<?
if($_POST['nfiles'] > 0)
{
	$nfiles = $_POST['nfiles'];
	for($i=0;$i<$nfiles;$i++)
	{
	?><input name="upfile<? echo $i;?>" type="file" id="upfile<? echo $i;?>" style="color:white;"/><br><?
	}
	?>
	</p>
	<p><input name="nfiles" type="hidden" value="<? echo $nfiles;?>"/>
	<p><select name="title">
	<?
		$count = count($values);
		for($i = 0; $i < $count; $i++)
		{
			echo "<option value=".$values[$i].">".$titles[$i]."</option>";
		}
	?>
	</select><br>
	<input name="Upload" type="submit" value="Upload"/>
<?
}
?>
</div>
</div>
</div>
</body>
</html>