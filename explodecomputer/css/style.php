<?php header("Content-type: text/css"); ?>


/* LAYOUT */

@font-face
{
    font-family: "Diavlolight";
    src: url('DiavloLight-Regular.ttf') format("truetype");
}

body
{
//	background-color: #292723;
	background-color: white;
	background-image:url('../unused/boatspain2.jpg');
	background-repeat:no-repeat;
	background-position: bottom right;
	background-attachment:fixed;

	margin: 0px;
	height: 100%;
	padding: 0px 0px 20px 0px;
	font-family: "Diavlolight", "Helvetica";
}


.container
{
	position: relative;
	height: 220px;
//	left: 0px;
//	top: 0px;
}

.settingsbox
{
	position: fixed;
	top: 345px;
	left: 0px;
	width: 0px;
	-webkit-transition: all .2s linear 0s;
	-moz-transition: all .2s linear 0s;
	-o-transition: all .2s linear 0s;
	transition: all .2s linear 0s;
}

.settings
{
	position: relative;
	float: left;
	width: 0px;
	height: 100px;
	color: #888888;
//	background-color: #ffeeee;
	opacity: 0.8;
	filter:alpha(opacity=80);
	-webkit-transition: all .2s linear 0s;
	-moz-transition: all .2s linear .2s;
	-o-transition: all .2s linear 0s;
	transition: all .2s linear 0s;
	overflow: hidden;
}

.settingsbox:hover;
{
	width: 1000px;
}

.settingsbox:hover .settings
{
	-webkit-transition: all .2s linear 0s;
	-moz-transition: all .2s linear 0s;
	-o-transition: all .2s linear 0s;
	transition: all .2s linear 0s;
	width: 800px;
}

.button
{
	font-size: 12px;
	color: #d86519;
	padding: 10px;
	float: left;
	margin-left: 10px;
//	background-color: white;
	border-radius: 15px;
	border: dotted 2px #888888;
}

.cats, .tags
{
	font-size: 10px;
	float: left;
}

.bar
{
	position: fixed;
	left: 0px;
	top: 300px;
}

.title
{
	margin-left: 10px;
	float: left;
	padding: 10px;
	font-size: 15px;
	color: #888888;
	border-radius: 15px 15px 15px 15px;	
	border-left: dotted 2px #888888;
	border-right: dotted 2px #888888;
	border-bottom: dotted 2px #888888;
	border-top: dotted 2px #888888;
}

.scroll
{
	float: left;
//	padding: 10px;
	padding: 0px 10px;
	font-size: 44px;
}

.title > p
{
	text-align: left;
}

.title > a
{
	color: black;
}


p
{
//	text-align: right;
	padding: 0 10px 0px 10px;
}

a
{
	text-decoration: none;
	color: #d86519;
}

a:focus
{
	outline: none;
}
a:hover
{
	color: orange;
}

.webtitle > a
{
	font-size: 15px;
//	color: #dddddd;
	color: #960f0f;
	text-decoration: none;
}
.webtitle > a:hover
{
	font-size: 15px;
	color: orange;
	text-decoration: none;
}

.webtitle 
{
	position: relative;
	height: auto;
//	border-bottom: 3px solid #960f0f;
	border-bottom: 3px solid black;
	-webkit-border-top-left-radius: 10px;
	-webkit-border-top-right-radius: 10px;
	-moz-border-radius-topleft: 10px;
	-moz-border-radius-topright: 10px;
	border-radius: 10px 10px 0px 0px;
}
.webinfo
{
	position: absolute;
	bottom: 0px;
	right: 0px;
	height: auto;
}
.webinfo > p
{
	font-size: 12px;
	color: black;
	padding-bottom: 10px;
}


.picdate
{
	color: black;
	font-size: 10;
}

.webentry, .aboutentry
{
	text-align: right;
	position: absolute;
//	background-color: #888888;
//	background-color: #ffeeee;
	background-color: white;
	top: 200px;
	width: 150px;
	height: 180px;
	border: solid 2px #292723;
	-webkit-transition: all .15s linear 0s;
	-moz-transition: all .1s linear .2s;
	-o-transition: all .1s linear 0s;
	transition: all .1s linear 0s;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
//	-webkit-box-shadow: 3px 0px 15px #292723;
//	-moz-box-shadow: 3px 0px 15px #292723;
//	box-shadow: 3px 0px 15px #292723;
//	opacity:0.8;
//	filter:alpha(opacity=80);
}

.webentry:hover, .aboutentry:hover
{
	overflow: hidden;
//	background-color: #ffffff;
	-webkit-transition: all .15s linear 0s;
	-moz-transition: all .15s linear .2s;
	-o-transition: all .15s linear 0s;
	transition: all .15s linear 0s;
	opacity:1;
	filter:alpha(opacity=100);
}

<?
require_once("../globals.php");
$query = "SELECT `id` FROM `webentry`";
$resweb = mysql_query($query);
$nrows = mysql_num_rows($resweb);
$left1 = -20;
$left2 = 0;
$space = 130;
for($i = ($nrows); $i >= 0; $i--)
{
?>
#entry<? echo $i; ?>
{
	left: <? $l = $left1 + $i*$space; echo $l; ?>px;
	margin-top: <? echo rand(-135,-165); ?>px;
	-webkit-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
	-moz-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
	-o-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
}

#entry<? echo $i; ?>:hover
{
	left: <? $l = $left2 + $i*$space; echo $l; ?>px;
	-webkit-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
	-moz-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
	-o-transform: rotate(<? echo rand(-10,10)/3; ?>deg);
}

<? } ?>

.aboutentry
{
	background-color: #666666;
	opacity: 0.5;
}
.aboutentry:hover
{
	background-color: #666666;
	opacity: 1;
}

#entry0 a
{
	margin-bottom: 20px;
	color: #ffeeee;
	font-size: 30px;
}

#entry0 a:hover
{
	text-decoration: underline;
}

.aboutinfo
{
	position: absolute;
	bottom: 10px;
	right: 10px;
}