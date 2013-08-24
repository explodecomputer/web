<?php

require_once('globals.php');

try {
	if (!isset($_GET['name']))
	{
		throw new Exception('Name not specified');
	}

	$name = $_GET['name'];
	$query  = sprintf('SELECT *  FROM `files` WHERE `filename` = CONVERT(_utf8 \'%s\' USING latin1) COLLATE latin1_swedish_ci', $name);
	$result = mysql_query($query, $con);
	if (mysql_num_rows($result) == 0)
	{
		throw new Exception('Image with specified name not found');
	}

	$image = mysql_fetch_array($result);
}
catch (Exception $ex)
{
	header('HTTP/1.0 404 Not Found');
	exit;
}
header('Content-type: ' . $image['type']);
header('Content-disposition: attachment; filename='.$image['filename']);
print $image['file'];
?>
