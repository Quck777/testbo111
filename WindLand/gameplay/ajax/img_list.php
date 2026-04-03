<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################
	Error_Reporting(0);
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	$main_conn = mysql_connect ($mysqlhost,$mysqluser,$mysqlpass,$mysqlbase);
	mysql_select_db($mysqlbase, $main_conn);
	mysql_query("SET NAMES cp1251");
	
	$sql = mysql_query('SELECT `address` FROM `images` WHERE `stype`="'.addslashes($_GET['type']).'" ');
	
	$check = 1;
	while($s = $db->fetchRow($sql) and $check++)
		echo $s[0].'|';
	if ($check==1) echo 'none';
	
	mysql_close($main_conn);
?>