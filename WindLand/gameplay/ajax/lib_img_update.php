<?php
	error_reporting(0);
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	include (ROOT.'/inc/functions.php');
	$main_conn = mysql_connect ($mysqlhost,$mysqluser,$mysqlpass,$mysqlbase);
	mysql_select_db($mysqlbase, $main_conn);
	mysql_query('SET NAMES cp1251');
	
	$you = catch_user(intval($_COOKIE['uid']),$_COOKIE['hashcode'],1);
	if(!$you["priveleged"]) die("<script>location='index.php';</script>");
	
	$stype = isset($_GET['type']) ? str_replace('/','',$_GET['type']) : false;
	if (!$stype) die("<script>alert('Не выбран тип картинок!');</script>");
	
	$bufer = array();
	function ext($file)
	{
		$e = explode(".",$file);
		return $e[count($e)-1];
	}
	function return_allfiles($_dir)
	{
		GLOBAL $bufer;
		$dir = @opendir ($_dir);
		while ( false !== ($file = readdir ($dir)) )
		{	
			if ( $file=='.' or $file=='..' ) continue;
			if ( ext($file)!=$file )  $bufer[] = $_dir."/".$file;
			else return_allfiles($_dir."/".$file);
		}
	}
	
	sql('DELETE FROM `images` WHERE `stype` = "'.$stype.'"');
	return_allfiles(IMG_ROOT.'/weapons/'.$stype);
	foreach($bufer as $b)
	{
		$file = str_replace(IMG_ROOT.'/weapons/','',$b);
		$w = sqlr("SELECT COUNT(*) FROM `images` WHERE `address`='".$file."' and `stype`='".$stype."';");
		if (!$w)
		{
			sql("INSERT INTO `images` (`address`,`stype`) VALUES ('".$file."', '".$stype."');");
		}
	}
	
	echo "<script>alert('Картинки обновлены!');</script>";
?>