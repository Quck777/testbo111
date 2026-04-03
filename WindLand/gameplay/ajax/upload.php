<?php

Error_Reporting(0);
require ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
include (ROOT.'/inc/functions.php');
$res = new mysqli($mysqlhost, $mysqluser, $mysqlpass);
$db->mysqli->select_db($mysqlbase);
$db->sql('SET NAMES cp1251');

	$you = catch_user(intval($_COOKIE['uid']),$_COOKIE["hashcode"],1);
	if ( $you['priveleged']==0 and $_GET['service']==false )
		die("<body>{"."\"error\": \"go off\",\n"."\"msg\": \"\"\n"."}</body>");
	
	include (ROOT.'/inc/class/downloader.php');
	
	$dw = new Downloader($_FILES, 'weapons/'.$_GET['type'], '');
	
	$res = $dw->loader('fileToUpload');
/*	
	session_start();
	if (@$_GET['act']==1)
	{
		$_SESSION['adm'][0] = $res;
		$_SESSION['adm'][1] = $_FILES;
		$_SESSION['adm'][2] = $_GET;
	} else $res = $_SESSION['adm'][0];

	if ( isset($_GET['otl']) ) die( print_r($_SESSION['adm']) );
*/
	
echo "<body>{"."\"error\": \"" . $error . "\",\n"."\"msg\": \"" . $res . "\"\n"."}</body>";
	
?>