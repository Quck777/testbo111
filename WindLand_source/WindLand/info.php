<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

Error_Reporting(0);

// Делаем для пв ссылку
if (@$_GET["do_w"])
{
	include ("watchers.php");
	exit;
}

// Создаем переменную логина и если нету такого закрываем доступ
$login = !empty($_SERVER['QUERY_STRING']) ? htmlspecialchars(urldecode($_SERVER['QUERY_STRING'])) : false;
if ($login==false) {
	echo "<LINK href=/css/main_v2.css rel=STYLESHEET type=text/css><center class=but><center class=puns><br><br>Нет Такого персонажа.[".$login."]<br><br><br></center></center><SCRIPT LANGUAGE=\'JavaScript\' SRC=\'/js/c.js\'></SCRIPT>";
	exit; 
}
$login = str_replace("'","",$login);
$login = explode('&',$login);
$UNAME = str_replace('p=','',$login[0]);

//define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp();
############################## 

include (ROOT.'/inc/func.php');
include (ROOT.'/inc/func2.php');

DEFINE ('PINFO', true);

############################## 
include (ROOT.'/inc/class/Player.php');

// Проверяем, если ли юзер в базе) если есть, то делаем с ним все что нада
if ( $http->_get('id') ) $player = new Player(false, $http->_get('id'), false, false);
else $player = new Player(false, false, $UNAME, false);
if ( !$player->pers ) {echo "<LINK href=css/main_v2.css rel=STYLESHEET type=text/css><center class=but><center class=puns><br><br>Нет Такого персонажа.[".$UNAME."]<br><br><br></center></center><SCRIPT LANGUAGE=\'JavaScript\' SRC=\'js/c.js\'></SCRIPT>";exit;}


$locname = $db->sqla("SELECT * FROM `locations` WHERE `id`='".$player->pers["location"]."' ;");

// Если юзер баговый, правим его автоматически) больше не будем ждать пока он зайдет
if ($player->pers['action']==-10 or $player->pers['action']==-11)
{
	include(ROOT.'/gameplay/info/update.php');
}

#### Призраки для битвы на арене:
if ($player->pers["ctip"]==-1)
{
	$player->pers["block"] = '';
	$player->pers["prison"] = '';
	$player->pers["online"] = 1;
	$player->pers["tire"] = 0;
	$player->pers["lastom"] = tme();
	$player->pers["timeonline"] = 3600;
	$player->pers["lastvisits"] = tme()-800-rand(100,500);
	$player->pers["cfight"] = $player->pers["silence"];
	$player->pers["action"] = 0;
}
/*
if (substr_count($player->pers["aura"],"invisible"))
{
	$player->pers["online"]=0;
	$player->pers["chp"]=$player->pers["hp"];
	$player->pers["cma"]=$player->pers["hp"];
	$player->pers["cfight"]=0;
}
*/
// Определяем смотрителя
if ( $http->_cookie('hashcode') and $http->_cookie('uid') )
{
	$you = $db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($http->_cookie('uid')).' and `pass` = "'.$http->_cookie('hashcode').'" and `block`="";');
	if ( $you )
	{
		$_SESSION["sign"] = $you["sign"];
		$_SESSION["user"] = $you["user"];
		$_SESSION["rank"] = $you["rank"];
		DEFINE('UID', $you['uid']);
	}
} else $you = false;

$preveleg = @($you['sign']=='watchers' or $you['diler']==1 or $you['priveleged']==1) ? true : false;


if ( $preveleg and empty($_GET["no_watch"]))
{
	echo '<title>['.$player->pers["user"].']</title><frameset rows="*,20" FRAMEBORDER=0 FRAMESPACING=2 BORDER=0 id=frmset>';
	echo '<frame src="/info.php?id='.$player->pers["uid"].'&no_watch=1" scrolling=auto FRAMEBORDER=0 BORDER=0 FRAMESPACING=0 MARGINWIDTH=0 MARGINHEIGHT=0 style="border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #666666">';
	echo '<frame src="/watchers.php?id='.$player->pers["uid"].'" scrolling=auto FRAMEBORDER=0 BORDER=0 FRAMESPACING=0 MARGINWIDTH=0 MARGINHEIGHT=0>';
	echo '</frameset>';
	exit;
}else echo '<script type="text/javascript" src="/js/info_v2.js?4"></script>';

echo "<script>var img_pack = '".IMG."';</script>";

if ($player->pers["uid"] == 7) $player->pers = j_pers($player->pers);

if ( empty($_GET["self"]) ) include('gameplay/info/game.php');
else include('gameplay/info/self.php');
?>