<?php
	## Раз N мин
	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ('../../configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 
	
	include (ROOT.'/inc/func.php');
	include (ROOT.'/inc/func2.php');
	include (ROOT.'/inc/func3.php');
	include (ROOT.'/inc/battle_func.php');
	
	$bss = $db->sql('UPDATE users set waiter=0 where uid=2506');
	while ($bs = mysql_fetch_assoc($bss) )
	{
		if ( $bs['invisible'] > tme() ) continue;
		$SPECIAL_pers = $bs;
		include(ROOT.'/');
	}
	
//	$usr = $db->sql('SELECT `user` FROM `users` WHERE `priveleged`=1 and `online`=1 ORDER BY `uid`;');
//	while ( $us = mysql_fetch_row($usr) ) say_to_chat ('m','Процесс атаки монстров прошел успешно.',1,$us[0],'*',0);
	
?>