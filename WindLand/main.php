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
include (ROOT.'/inc/class/Player.php');
$player = new Player;
if ( !$player->pers ) exit;

## Делаем защиту от закликивания, нехрен грузить сервер
/*
	if ( $player->pers['lastom'] >= tme() )
	{
		include (ROOT.'/inc/mnogoclick.php');
		exit;
	}
*/
## Конец


$t = tme();

## Файл настроек фильтров
include (ROOT.'/inc/connect.php');

## Файлы функций
include (ROOT.'/inc/func.php');		// Функции частого использования в разных частях игры
include (ROOT.'/inc/func2.php');	// Функции реже используемые
include (ROOT.'/inc/func3.php');	// Функции специфического использования, вызов в редких файлах
include (ROOT.'/inc/battle_func.php');
//include (ROOT.'/inc/functions.php');

// Обновляем юзера
$player->mainactProcess();
$lastom_new = $player->lastom_new;
$lastom_old = $player->lastom_old;
#
include (ROOT.'/inc/prov.php');


// ---------------------------------- Начинаем вывод страничек персонажа
include (ROOT.'/inc/up.php');
############################## Чуть модифицируем загрузку
if ( isset($http->get['addon']) and $http->get['addon']=='action' )
{
	switch ($http->get['addon'])
	{
		case 'action': $up_fls = 'possibilities.php'; break;
		default: $up_fls = '';
	}
} else {
	switch ($player->pers['curstate'])
	{
		case 0:   $up_fls = 'pers.php'; break;
		case 1:   $up_fls = 'inv.php'; break;
		case 2:   $row = $db->sqla_id("SELECT `inc` FROM `locations` WHERE `id` = '".$player->pers['location']."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__); $up_fls = 'locations/'.$row[0]; unset($row); break;
		case 3:   $up_fls = 'inc/clans/in.php'; break;
		case 4:   $up_fls = 'battle.php'; break;
		case 5:   $up_fls = 'self.php'; break;
		case 6:   $up_fls = 'friends/list.php'; break;
		case 35:  $up_fls = 'zakon/zakon_panel.php'; break;
		
		## Админ
		case 300: $up_fls = 'adm/administration.php'; break;
		case 301: $up_fls = 'adm/map_edit.php'; break;
		case 302: $up_fls = 'adm/weapons.php'; break;
		case 303: $up_fls = 'adm/magic.php'; break;
		case 304: $up_fls = 'adm/bots.php'; break;
		case 305: $up_fls = 'adm/ministers.php'; break;
		case 306: $up_fls = 'adm/users.php'; break;
		case 307: $up_fls = 'adm/ava_req.php'; break;
		case 308: $up_fls = 'adm/clans.php'; break;
		case 309: $up_fls = 'adm/journalist.php'; break;
		case 310: $up_fls = 'adm/dilr.php'; break;
		case 311: $up_fls = 'adm/new_quests.php'; break;
//		case 312: $up_fls = 'adm/questsR.php'; break;
//		case 313: $up_fls = 'adm/questsS.php'; break;
		case 314: $up_fls = 'adm/questsQ.php'; break;
		case 315: $up_fls = 'adm/msg_history.php'; break;
		case 316: $up_fls = 'adm/downloader.php'; break;
		case 317: $up_fls = 'adm/taverna.php'; break;
	#	case 314: $up_fls = 'adm/'; break;
		## \\
		
		default: $up_fls = '';
	}
}
## Загружаем сам файл
if ( file_exists(ROOT.'/inc/'.$up_fls) ) include (ROOT.'/inc/'.$up_fls);
else {
	if ( $priv ) echo '<b>'.$up_fls.'</b> File not found!';
	else echo 'Ошибка!';
}



##########################
echo "\n\n";
if ( $player->pers["uid"]==1 or $player->pers["uid"]==7 or @$_COOKIE['AdminJoe'] )
{
	include (ROOT.'/inc/AdmOtladka.php');
	exit;
}
?>
<center>


<script language="javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--


a+';rand='+Math.random()+'" alt="Рейтинг@Mail.ru" border="0" '+
'height="40" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=2011637">
<img src="http://d1.cb.be.a1.top.mail.ru/counter?js=na;id=2011637;t=130"
height="40" width="88" border="0" alt="Рейтинг@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--