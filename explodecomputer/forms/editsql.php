<?php include("password_protect.php");
require_once("../globals.php");
$deletedrecord = "DELETE FROM `webentry` WHERE `ID`='".$_POST[ID]."'";
$deleted = mysql_query($deletedrecord);
if($_POST['delete'] == 1)
{
	echo "post deleted..";
	exit();
}
echo "<h1>".$_POST['Title']."</h1>";
echo "<h2>".$_POST['Category'];
//DATE
if($_POST[Datecre] == '')
{
	$_POST[Datecre] = date("Y-m-d H:i:s");
	echo " - ".$_POST[Datecre];
	echo "</h2>";
}
$datemod = date("Y-m-d H:i:s");

// TAGS
$tagcount = count($_POST['Tags']);
if($_POST['Etags'] == '')
{
	if($tagcount > 0)
	{
		echo "<ul>";
		for($i = 0; $i < $tagcount; $i++)
		{
			echo "<li>".$_POST['Tags'][$i]."</li>";
		}
		echo "</ul>";
		$tags = implode(',',$_POST['Tags']);
		$alltags = $tags;
	}
} else {
	$newtags = $_POST['Etags'];
	$result=mysql_query('show columns from webentry;'); 
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
	$sql1 = 'ALTER TABLE `webentry` CHANGE `tags` `tags` SET('.$alltags.') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL';
	echo "<br>Altering existing tag list...";
	if (!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}
	echo "done!<br>";
	echo "<ul>";
	if($tagcount > 0)
	{
		for($i=0; $i < $tagcount; $i++)
		{
			echo "<li>".$_POST['Tags'][$i]."</li>";
		}
		$tags = implode(',',$_POST['Tags']);
		$alltags = $tags.",".$_POST['Etags'];
	}
	$temptags = explode(',',$_POST['Etags']);
	$tagcount = count($temptags);
	for($i=0; $i < $tagcount; $i++)
	{
		echo "<li><strong>".$temptags[$i]."</strong></li>";
	}
	echo "</ul>";
}

$entry = mysql_real_escape_string($_POST['Entry']);
$title = str_replace("'","''",$_POST[Title]);
$sql = "INSERT INTO `webentry` (`ID`, `title`, `category`, `entry`, `tags`, `datecre`, `datemod`)
VALUES
('$_POST[ID]', '$title', '$_POST[Category]', '$entry', '$alltags', '$_POST[Datecre]', '$datemod')";
echo $alltags;
if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}
$last_id = mysql_insert_id();
echo "<div style='padding:5px;border-style:solid;border-width:1px;'>".$_POST['Entry']."</div>";

// upload files to 'files' table
if($_POST['nfiles'] > 0)
{
	$nfiles = $_POST['nfiles'];
	if($nfiles == 1)
	{
		echo "<p>You've uploaded this file:</p>";
	} else {
		echo "<p>The following ".$nfiles." files have been uploaded:</p>";
	}
	for($i = 0; $i < $nfiles; $i++)
	{
		?><p><?
		$tmp = "upfile".$i;
		$fileName = mysql_real_escape_string($_FILES[$tmp]['name']);
		$tmpName = $_FILES[$tmp]['tmp_name'];
		$fileSize = $_FILES[$tmp]['size'];
		$fileType = $_FILES[$tmp]['type'];
		echo $fileName."<br>".$fileSize."<br>".$fileType."</p>";
		$fp = fopen($tmpName,'r');
		$content = fread($fp,filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}
		$last_id = addslashes($last_id);
		$sql = "INSERT INTO `files` (`id`, `web`, `filename`, `type`, `file`, `dateup`)
		VALUES
		('$_POST[ID]', '$last_id', '$fileName', '$fileType', '$content', '$_POST[Datecre]')";
		mysql_query($sql) or die('Error, query failed: '.mysql_error());
	}
}
mysql_close($con);
?>