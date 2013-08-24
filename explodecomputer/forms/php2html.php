<?php include("password_protect.php");
?>
<head>
<title>explodecomputer.com by Gib Hemani</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
<?
require_once("../globals.php");

$id = (int) $_POST['title'];
$query  = sprintf('select * from webentry where id = %d', $id);
$result = mysql_query($query, $con);

$webentry = mysql_fetch_array($result);
$title = $webentry['title'];
?><p><?
echo $title;
?></p><?

$bad = array(" ");
$good = array("_");
$htmltitle = strtolower(str_replace($bad,$good,preg_replace("/[^a-zA-Z0-9\s]/", "", $title))).".html";
?><p><?
echo $htmltitle;
?></p><?
