<?php include("password_protect.php"); ?>
require_once("globals.php");

if(!isset($_POST['upload']))
{
	die("no post");
}
if($_FILES['pic']['size'] == 0)
{
	die("no pic");
}

if($_FILES['thumb']['size'] == 0)
{
	die("no thumb");
}

// TAGS
if($_POST['Etags'] == '')
{
	echo "<br>No new tags..<br>";
	if(count($_POST[Tags]) > 0)
	{
		$tags = implode(',',$_POST['Tags']);
		echo "<br>Existing tags:<br>$tags<br>";
		$_POST['Etags'] = $tags;
	}

} else {
	$newtags = $_POST['Etags'];
	echo "<br>New tags:<br>$newtags<br>";
	$result=mysql_query('show columns from '.'photos'.';'); 
	while($tuple=mysql_fetch_assoc($result)) 
	{
		if($tuple['Field'] == "tags") 
		{ 
			$types=$tuple['Type'];
			$beginStr=strpos($types,"(")+1; 
			$endStr=strpos($types,")"); 
			$types=substr($types,$beginStr,$endStr-$beginStr);
			$newtags = "'".str_replace(",","','",$newtags)."'";
			$alltags = $types.",".$newtags;
		}
	}
	$sql1 = 'ALTER TABLE `photos` CHANGE `tags` `tags` SET('.$alltags.') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL';
	echo "<br>altering existing tag list...<br>";
	echo $sql1;
	if (!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}
	echo "<br>added new tag(s)<br>";
	if(count($_POST[Tags]) > 0)
	{
		$tags = implode(',',$_POST['Tags']);
		$_POST['Etags'] = $tags.",".$_POST['Etags'];
	}
	echo "<br>Full tag list:<br>";
	echo $_POST['Etags'];
	echo "<br>";
}

//DATE
if($_POST[Datecre] == '')
{
	$_POST[Datecre] = date("Y-m-d H:i:s");
	echo "<br>Date:<br>";
	echo $_POST[Datecre];
	echo "<br>";
}

$fileName = $_FILES['pic']['name'];
$tmpName  = $_FILES['pic']['tmp_name'];
$fileSize = $_FILES['pic']['size'];
$fileType = $_FILES['pic']['type'];

echo "<br>$fileName<br>$tmpName<br>$fileSize<br>$fileType<br>";

$fileNametn = $_FILES['thumb']['name'];
$tmpNametn  = $_FILES['thumb']['tmp_name'];
$fileSizetn = $_FILES['thumb']['size'];
$fileTypetn = $_FILES['thumb']['type'];

echo "<br>$fileNametn<br>$tmpNametn<br>$fileSizetn<br>$fileTypetn<br>";

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

$fp      = fopen($tmpNametn, 'r');
$contenttn = fread($fp, filesize($tmpNametn));
$contenttn = addslashes($contenttn);
fclose($fp);

if(!get_magic_quotes_gpc())
{
	$fileName = addslashes($fileName);
}

$title = str_replace("'","''",$_POST['Title']);
$notes = addslashes($_POST['Entry']);
$sql = "INSERT INTO `photos` (`id`, `fn`, `name`, `type`, `size`, `file`, `fn_tn`, `type_tn`, `size_tn`, `file_tn`, `category`, `tags`, `notes`, `datecre`, `datemod`)
VALUES
(NULL, '$fileName', '$title', '$fileType', '$fileSize', '$content', '$fileNametn', '$fileTypetn', '$fileSizetn', '$contenttn', '$_POST[Category]', '$_POST[Etags]', '$notes', '$_POST[Datecre]', '$_POST[Datecre]')";
mysql_query($sql) or die('Error, query failed: '.mysql_error());
echo "<br>$sql<br>";
?>