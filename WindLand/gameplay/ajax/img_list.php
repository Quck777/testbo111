<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################
	Error_Reporting(0);
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	$main_conn = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqlbase);
	$db->mysqli->select_db($mysqlbase);
	$db->sql("SET NAMES cp1251");
	
	$sql = $db->sql('SELECT `address` FROM `images` WHERE `stype`="'.addslashes($_GET['type']).'" ');
	
	$check = 1;
	while($s = $db->fetchRow($sql) and $check++)
		echo $s[0].'|';
	if ($check==1) echo 'none';
	
	if ($main_conn instanceof mysqli) $main_conn->close();
?>