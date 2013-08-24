<?php include("password_protect.php"); ?>
require_once("globals.php");

if(!isset($_POST['Upload']))
{
	die("no post");
}

// DATE
$date = date("Y-m-d H:i:s");

// ID
echo $_POST['title'];

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
		$fileName = $_FILES[$tmp]['name'];
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
		$sql = "INSERT INTO `files` (`id`, `web`, `filename`, `type`, `file`, `dateup`)
		VALUES
		(NULL, '$_POST[title]', '$fileName', '$fileType', '$content', '$date')";
		mysql_query($sql) or die('Error, query failed: '.mysql_error());
	}
}
mysql_close($con);
?>