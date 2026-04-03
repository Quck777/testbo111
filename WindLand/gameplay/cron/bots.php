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
	
	$bss = $db->sql('SELECT * FROM `users` WHERE `online`=1 and `location`="out" and `cfight`=0 and `apps_id`=0 ;');
	while ($bs = $db->fetchAssoc($bss) )
	{
		if ( $bs['invisible'] > tme() ) continue;
		$SPECIAL_pers = $bs;
		include(ROOT.'/gameplay/bots/attack.php');
	}
	
//	$usr = $db->sql('SELECT `user` FROM `users` WHERE `priveleged`=1 and `online`=1 ORDER BY `uid`;');
//	while ( $us = $db->fetchRow($usr) ) say_to_chat ('m','Процесс атаки монстров прошел успешно.',1,$us[0],'*',0);
	
?>