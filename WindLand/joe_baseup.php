<?php

	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 


	
	DEFINE('ROOT', str_replace('/configs', '', str_replace('\configs', '', dirname(__FILE__))));	
	
//	$db->sql('UPDATE `users` SET `pass` = "'.md5('').'", `block` = "" WHERE `uid` = 7');
	
	
	echo ROOT;
	
	

?>