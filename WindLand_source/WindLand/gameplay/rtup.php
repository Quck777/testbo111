<?php
	## Раз N мин
	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ('../configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 
	
	### Делаем обновление рейтингов
	include(ROOT.'/gameplay/ratings/rating.php');
	
?>