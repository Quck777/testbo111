<?php
	## Раз в сутки // 0	0	*	*	* root /usr/local/bin/php /home/www/gameplay/cron/online.update.php 
	Error_Reporting(0);
	ignore_user_abort(true);
	set_time_limit(0);
	DEFINE ('TMS', microtime(true));
	
	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 
	
	include (ROOT.'/inc/func.php');
	
	say_to_chat ('a','Внимание! Оптимизация и сохранение параметров. Возможен перебой в работе проекта на 2-10 секунд. Пожалуйста не покидайте наш мир, скоро всё нормализуется.',0,0,'*',0);
	
	function send_mail($to, $body, $title=false)
	{
		$email = 'robot@'.HOST;
		$subject = ($title==false) ? $_SERVER['SERVER_NAME'] : htmlspecialchars($title);
		$headers = "From: ".$_SERVER['SERVER_NAME']." <".$email.">\r\n";   
		$headers .= "Return-path: <".$email.">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=windows-1251;\r\n";
		
		$body.= '<br /><br />С Уважением, Администрация <a href=http://'.HTTP.'/>'.HTTP.'</a> &copy;';
		
		if( mail($to, $subject, $body, $headers) )
			return true;
		else
			return false;
	}
	
	### Обновляем время бекапа
	$db->sql('UPDATE `configs` SET `last_dump`='.time().', `last_rating_update`='.time());
	
	/*
	### Ищем и удаляем хреновых юзеров
	$bl = sql("SELECT `uid` FROM `users` WHERE `lastom`<(".time()."-(`level`+1)*1209600) and `lastom`>0 and `block`<>'' ORDER BY `uid`;");
	while ( $b = mysql_fetch_assoc($bl) )
	{
		if ($b!=false)
		{
			sql("DELETE FROM `users` WHERE `uid`=".$b['"uid']);
			sql("DELETE FROM `chars` WHERE `uid`=".$b['uid']);
			sql("DELETE FROM `wp` WHERE `uidp`=".$b['uid']);
			sql("DELETE FROM `p_auras` WHERE `uid`=".$b['uid']);
			sql("DELETE FROM `u_blasts` WHERE `uidp`=".$b['uid']);
			sql("DELETE FROM `u_auras` WHERE `uidp`=".$b['uid']);
			sql("DELETE FROM `u_blasts` WHERE `uidp`=".$b['uid']);
			sql("DELETE FROM `u_special_dmg` WHERE `uid`=".$b['uid']);
			sql("DELETE FROM `bank_account` WHERE `uid`=".$b['uid']);
			sql("DELETE FROM `presents_gived` WHERE `uid`=".$b['uid']);
		}
	}
	*/
	### Напоминаем юзерам о игре
	$isluser = $db->sql('SELECT `uid`,`user`,`email`,`pass`,`lastom` FROM `users` WHERE `lastom`<('.time().'-1814400) and `lastom`>0 and `block`="" and `action`<>-1 ORDER BY `uid`;');
	$admin = $db->sqlr("SELECT `user` FROM `users` WHERE `uid`=7 and `online`=1 LIMIT 0,1;");
	while ( $luser = mysql_fetch_assoc($isluser) )
	{
		if ( filter_var($luser['email'], FILTER_VALIDATE_EMAIL)==true )
		{
			$luser['pass'] = rand(10000,100000);
			send_mail($luser['email'], 'Здраствуйте! Вы слишком давно не заходили в игру. Сейчас вас ожидают интересные битвы, новая магия и вещи. А так же новые территории! Заходите и проведите время с удовольствием! <hr> <b>Никнэйм: <i>'.$luser['user'].'</i></b> <br> <b>Пароль: <i>'.$luser['pass'].'</i></b>', 'Напоминание');
			$db->sql('UPDATE `users` SET `pass`="'.md5($luser['pass']).'", `action`=-1 WHERE `uid`='.$luser['uid']);
			if ($admin) say_to_chat ('s','Отослано письмо на <b>'.$luser['email'].'</b>, для <b>'.$luser['user'].'</b> <b>Пароль: <i>'.$luser['pass'].'</i></b>. Время незахода в игру: '.tp(time()-$luser['lastom']).' ',1,$admin,'*',0);
		} elseif ($luser['user']==true) $db->sql('UPDATE `users` SET `action`=-1 WHERE `uid`='.$luser['uid']);
	}
	
	
	### Удаляем баговые вещи
	$db->sql('DELETE FROM `wp` WHERE `uidp`=0');
	### Удаляем логи, по желанию можно отключить, но вес БД значительно возрастет
	$db->sql('TRUNCATE TABLE `battle_logs`');
	$db->sql('TRUNCATE TABLE `fights`');
	$db->sql('TRUNCATE TABLE `fight_log`');
	### Очещаем логи ненужные
	$db->sql('TRUNCATE TABLE `bots_battle`');
	$db->sql('TRUNCATE TABLE `chat`');
	$db->sql('TRUNCATE TABLE `salings`');
	### Оптимизирует БД
	$db->sql('OPTIMIZE TABLE `users`');
	$db->sql('OPTIMIZE TABLE `wp`');
	$db->sql('OPTIMIZE TABLE `chars`');
	$db->sql('OPTIMIZE TABLE `mine`');
	$db->sql('OPTIMIZE TABLE `bots_cell`');
	$db->sql('OPTIMIZE TABLE `herbals_cell`');
	$db->sql('OPTIMIZE TABLE `bots`');
	$db->sql('OPTIMIZE TABLE `weapons`');
	$db->sql('OPTIMIZE TABLE `chat`');
	### Обновляем юзера
	$db->sql('UPDATE `users` SET `chat_last_id`=0');
	$db->sql('UPDATE `users` SET `cfight`=0 , `curstate`=0, `apps_id`=0, `tour`=0 WHERE `online`=0;');
	
	
	### Делаем обновление рейтингов
	include(ROOT.'/gameplay/ratings/rating.php');
	### Делаем бекап БД
	### Устанавливаем пароль на сохранение
	$pass = '12345';
	include(ROOT.'/gameplay/sql_dump.php');
	
	$rm = round((microtime(true)-TMS),4);
	echo $rm;
	$usr = $db->sql('SELECT `user` FROM `users` WHERE `priveleged`=1 and `online`=1 ORDER BY `uid`;');
	while ( $us = mysql_fetch_row($usr) ) say_to_chat ('m','Резервное копирование завершено. Затрачено времени <b>'.$rm.'</b> сек.',1,$us[0],'*',0);

//	mysql_close();
?>