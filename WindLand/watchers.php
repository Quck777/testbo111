<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp();
############################## 


?><META Content="text/html; charset=windows-1251" Http-Equiv="Content-type">
<LINK href="/css/main_v2.css" rel="STYLESHEET" type="text/css">
<?php

//if ( (@$_GET['p']=='Joe' or @$_GET['id']==7) and (@$_COOKIE['uid']!=7 or @$_COOKIE['nick']!='Joe') ) unset($_GET);

############################## 
include (ROOT.'/inc/class/Player.php');
// Проверяем, если ли юзер в базе) если есть, то делаем с ним все что нада
if ( $http->_get('id') ) $player = new Player(false, $http->_get('id'), false, false);
elseif ( $http->_get('p') ) 
{
	$player = new Player(false, false, $http->_get('p'), false);
//	echo "<script>var frameResizer = '<b class=user>".$player->pers['user']."</b>';</script>";
} else die('die no method;');
if ( !$player->pers ) die("<center><b>Нет такого персонажа.</b></center>");

$chars = $db->sqla("SELECT * FROM `chars` WHERE `uid`='".$player->pers["uid"]."'");
$locname = $db->sqla ("SELECT * FROM `locations` WHERE `id`='".$player->pers["location"]."' ;");

include (ROOT.'/inc/func.php');
include (ROOT.'/inc/func2.php');

$_GET['id'] = $player->pers['uid'];


// Определяем смотрителя
if ( $http->_cookie('hashcode') and $http->_cookie('uid') )
{
	$you = $db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($http->_cookie('uid')).' and `pass` = "'.$http->_cookie('hashcode').'" and `block`="";');
	if ( $you )
	{
		$_SESSION["sign"] = $you["sign"];
		$_SESSION["user"] = $you["user"];
		$_SESSION["rank"] = $you["rank"];
	}
} else $you = false;
//if ( $you['mail_good']<>1 ) die("<center><b class='hp'>Подтвердите E-Mail!</b></center>");

if ( $you['uid']==7 )
{
	$you['sign'] = 'watchers';
	$you['diler'] = 1;
	$you['invisible'] = tme()+100;
	$you['clan_state'] = 'wg';
}


####
if ($you['sign']=='watchers' or $you['diler']==1 )
{
	DEFINE ('WATCHERS', true);
	$rk = explode('|', $you['rank']);
	$CAN_DO_EVR = 0;
	if ( ($you['clan_state']=='wg' and $you['sign']=='watchers') or $you['uid']==1 )
		$CAN_DO_EVR = 1;
		
	$d = ($you['diler']==1) ? 1 : 0;
	
	$p1 = ($rk[0]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Молчанка
	$p2 = ($rk[1]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Форумка
	$p3 = ($rk[2]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Кара смотров
	$p4 = ($rk[3]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Блок инфы
	$p5 = ($rk[4]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Трюм		
	$p6 = ($rk[5]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Блок
	$p7 = ($rk[6]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Пометка
	$p8 = ($rk[7]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Женить
	$p9 = ($rk[8]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Раздевать
	$p10 = ($rk[9]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Проверять на чистоту
	$p11 = ($rk[10]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Выгонять из клана
	$p12 = ($rk[11]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Вытаскивать из бага
	$p13 = ($rk[12]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Благославлять
	
	$p14 = ($rk[13]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Регистрировать мульта
	
	$p15 = ($rk[14]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просмотр IP адресов
	$p16 = ($rk[15]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Очищать лог IP адресов
	$p17 = ($rk[16]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог переводов
	$p18 = ($rk[17]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог смен пароля
	$p19 = ($rk[18]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог заходов с одного компа
	$p20 = ($rk[19]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог пометок смотрителей
	$p21 = ($rk[20]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог проверок на чистоту
	$p22 = ($rk[21]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Просматривать лог клановой активности
	$p23 = ($rk[22]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Правонарушения
	$p24 = ($rk[23]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Проф. активность
	$p25 = ($rk[24]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Рефералы
	$p26 = ($rk[25]==1 or $CAN_DO_EVR==1) ? 1 : 0; // Бои персонажа
	
	echo "<script>var img_pack = '".IMG."';var nick='".$player->pers["user"]."';</script>";
	echo '<script type="text/javascript" src="/js/mod/jquery.js"></script><script type="text/javascript" src="/js/watchers_v1.js"></script>';
	echo "<SCRIPT>view_watchers(".$p15.",".$p17.",".$p18.",".$p19.",".$p20.",".$p21.",".$p22.",".$p23.",".$p24.",".$p25.",".$p26.");\n</SCRIPT>";


	include_once (ROOT.'/gameplay/watchers/functions.php');
	
	if (@$_GET['do_w']=='mpb') include(ROOT.'/gameplay/watchers/buttons.php');
	elseif (@$_GET['do_w']=='swatch' and $p21) include(ROOT.'/gameplay/watchers/_verification.php');
	elseif (@$_GET['do_w']=='ip' and $p15) include(ROOT.'/gameplay/watchers/_show_ips.php');
	elseif (@$_GET['do_w']=='sign' and $p22) include(ROOT.'/gameplay/watchers/_show_sign.php');
	elseif (@$_GET['do_w']=='referal' and $p25) include(ROOT.'/gameplay/watchers/referal.php');
	elseif (@$_GET['do_w']=='rmpb' and $p23) include(ROOT.'/gameplay/watchers/_rmpb.php');
	elseif (@$_GET['do_w']=='person' and $p24) include(ROOT.'/gameplay/watchers/_pactiv.php');
	elseif (@$_GET['do_w']=='w_z' and $p20) include(ROOT.'/gameplay/watchers/_zametci.php');
	elseif (@$_GET['do_w']=='pass' and $p18) include(ROOT.'/gameplay/watchers/_pass.php');
	
	elseif (@$_GET['do_w']=='sells' and $p17) include(ROOT.'/gameplay/watchers/_sells.php');
	elseif (@$_GET['do_w']=='onecomp' and $p19) include(ROOT.'/gameplay/watchers/_onecomp.php');
	elseif (@$_GET['do_w']=='battles' and $p26) include(ROOT.'/gameplay/watchers/_battles.php');
	elseif (@$_GET['do_w']=='quest' and $p26) include(ROOT.'/gameplay/watchers/_quest.php');
	
//	if (@$_GET['do_w']=="w_z") include("services/wt/_w_z.php");
//	if (@$_GET['do_w']=="pass") include("services/wt/_pass.php");
//	if (@$_GET['do_w']=="sells") include("services/wt/_sells.php");
	if (@$_GET['do_w']=="battles") include("services/wt/_battles.php");
//	if (@$_GET['do_w']=="onecomp") include("services/wt/_onecomp.php");
	
	
	
	# Вытащить с бага
	if (isset($_GET['bug']) and $p12) 
	{
		echo 'BUG OFF : % <b>'.$player->pers["user"].'</b>"';
		set_vars ("`cfight`=0 , `curstate`=0, `apps_id`=0, `tour`=0",$player->pers["uid"]);
	}
	# Выгоняем с клана
	if (isset($_GET['clan_go_out']) and $p11) 
	{
		if ($player->pers['sign']=='watchers')echo 'Смотрителей можно выгонять только через клан.';
		else
		{
			echo 'CLAN OFF : % <b>'.$player->pers['user'].'</b>"';
			set_vars ("`sign`='none', `state`='' , `rank`='', `clan_state`='', `clan_prev`=''",$player->pers['uid']);
			$db->sql("INSERT INTO `clans_log` (`uid`, `who`, `type`, `date`, `sign`, `text`) VALUES (".$player->pers['uid'].", '".$you['user']."', 2, ".tme().", '".$player->pers['sign']."', '');");
		}
	}
	# Раздеваем перса
	if (isset($_GET['wear_out']) and $p9) 
	{
		echo 'Wear out : % <b>'.$player->pers["user"].'</b>"';
		remove_all_weapons();
	}
	# Снимаем женатость
	if (isset($_GET['maridge_out']) and $p8) 
	{
		echo 'Maridge out : % <b>'.$player->pers["user"].'</b>"';
		set_vars("maridge=0",$player->pers["maridge"]);
		set_vars("maridge=0",$player->pers["uid"]);
	}
	# Ставим проверку
	if (isset($_GET['proverka']) and $p10)
	{
		$isprow = $db->sqlr('SELECT count(*) FROM `watch_verification` WHERE `uid`='.$player->pers['uid'].' and `date`>'.(tme()-432000).'');
		if ($isprow==true) echo 'Проверка уже пройдена.';
		elseif($player->pers['level']>4) 
		{
			$db->sql("INSERT INTO `watch_verification` (`uid`, `who`, `date`, `type`) VALUES (".$player->pers['uid'].", '".$you['user']."', ".tme().", 0);");
			say_to_chat('z','Проверка пройдена успешно. Действительна до: <b class=hp>'.date("d.m.Y H.i", tme()+432000).'</b> (<b>'.$you['user'].'</b>).',1,$player->pers['user'],'*',0); 
			echo 'Проверка пройдена. Чист.';
		} else echo 'Проверка невозможна, персонаж не достиг 5-го уровня.';
		unset($isprow);
	}
	# Ставим ком проверку
	if (isset($_GET['comproverka']) and $d==1 and $you['dreserv']>5)
	{
		$isprow = $db->sqlr('SELECT count(*) FROM `watch_verification` WHERE `uid`='.$player->pers['uid'].' and `date`>'.(tme()-432000).'');
		if ($isprow==true) echo 'Проверка уже пройдена.';
		elseif($player->pers['level']>4) 
		{
			$you['dreserv']-=5;
			$db->sql("INSERT INTO `watch_verification` (`uid`, `who`, `date`, `type`) VALUES (".$player->pers['uid'].", '".$you['user']."', ".tme().", 1);");
			set_vars("`dreserv`=dreserv-5", $you['uid']);
			say_to_chat('z','<b>Коммерческая проверка пройдена успешно</b>. Действительна до: <b class=hp>'.date("d.m.Y H.i", tme()+432000).'</b> (<b>'.$you['user'].'</b>).',1,$player->pers['user'],'*',0); 
			echo 'Комерческая проверка пройдена. Чист. С Вашего счета снято 5 резерва.';
		} else echo 'Проверка невозможна, персонаж не достиг 5-го уровня.';
		unset($isprow);
	}
}
?>