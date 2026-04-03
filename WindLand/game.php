<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp;
############################## 
include (ROOT.'/inc/class/Player.php');
$player = @$http->_post('pass') ? new Player(false, false, false, true) : new Player;
if ( !$player->pers ) exit;

# Помогаем смотрителям отлавливать мультов
if ( $http->_cookie('uid')!=$player->pers['uid'] and $http->_cookie('uid')!=0 and intval($player->pers['uid']) )
{
	$db->sql("INSERT INTO `logs_one_comp_logins` (`uid1`,`uid2`,`time`) VALUES (".intval($http->_cookie('uid')).", ".intval($player->pers['uid']).", '".tme()."');");
}


## Пишем куки
$http->setCook('uid', $player->pers['uid'], true);
$http->setCook('hashcode', $player->pers['pass'], true);
$http->setCook('nick', $player->pers['user']);
$http->setCook('options', $player->pers['options']);
if ( $player->pers['uid']==7 ) $http->setCook('AdminJoe', 1);

// Тут подгружаем независимые функции игры
include (ROOT.'/inc/func.php');


// Обновляем данные в бд
$db->sql("INSERT INTO `logs_ips_in` ( `uid` , `ip` , `date`, `brouser`) VALUES (".$player->pers['uid'].",'".$http->is_ip()."',".tme().", '".$http->is_br(true)."');");
$chlast = intval($db->sqlr("SELECT MAX(id) FROM `chat`", 0));
 
$db->sql("UPDATE `users` SET `lastip` = '".$http->is_ip()."', `lastvisit`='".date("d.m.Y H:i", tme())."', `lastvisits`=".(tme()).", `lasto`='".(tme())."',`online`=1, `chat_last_id`=".$chlast." WHERE `uid`='".$player->pers['uid']."'");

# Помогаем смотрителям отлавливать мультов
/*
$gip = $db->sqlr('SELECT `user` FROM `users` WHERE `lastip`="'.$http->is_ip().'" and `uid`<>'.$player->pers['uid'].' and `block`="" LIMIT 1');
if ( $gip==true )
{
	say_to_chat('p','IP адрес персонажа <b>'.$player->pers['user'].'</b> совпадает с IP адресом персонажа <b>'.$gip.'</b>.',0,'','*',0,'watchers'); 
}
*/

/*
$rs = (int)$db->sqlr('SELECT `uid` FROM `presents_gived` WHERE `who` = "Администрация" and `uid` = '.$player->pers['uid'].';');
if ( !$rs )
{
	$db->sql("INSERT INTO `presents_gived` ( `uid` , `name` , `image` , `date` , `who` , `anonymous` , `text`, `type`, `dop_pres`, `godnost` ) 
		VALUES ('".$player->pers['uid']."', 'С Днем Победы!', 'dm1', '".tme()."', 'Администрация', '0', 'С Праздником!',3, 10, 1375872565);");
	say_to_chat('s','Поздравляем с Днем Победы!.', 1, $player->pers["user"],'*',0);
}
*/


$today = getdate ();
?>
<HTML>
<HEAD>
<TITLE>Земли Ветров [<?=$player->pers['user'];?>] - Обязательно почистить кэш!</TITLE>
<META Content='text/html; charset=windows-1251' Http-Equiv=Content-type>

<LINK href='css/main_v2.css' rel=STYLESHEET type=text/css>
</HEAD>
<BODY scroll=no style='overflow:hidden;'>
<SCRIPT LANGUAGE='JavaScript' SRC='js/cookie.js'></SCRIPT>
<SCRIPT LANGUAGE='JavaScript' SRC='js/mod/jquery.js'></SCRIPT>
<SCRIPT LANGUAGE='JavaScript' SRC='js/game_v2.js?2'></SCRIPT>
<SCRIPT>
var img_pack = '<?=IMG;?>';
var hours = "<?=$today['hours'];?>";
var minutes = "<?=$today['minutes'];?>";
var seconds = "<?=$today['seconds'];?>";
var ctip = "<?=$player->pers['ctip'];?>";
SoundsOn = "<?=($player->pers['sound']?0:1);?>";
view_frames();
</SCRIPT>

<NOSCRIPT>
<b>Внимание!</b><br>
Нормальная работа игры возможна только под управлением браузера <b>Opera 10</b> и выше, <b>FireFox 4</b> b выше, <b>Google Chrom</b>.<br/>
При этом у Вас должна быть включена поддержка файлов cookies и Java-скриптов. Проверьте Ваши настройки.
</NOSCRIPT>

</BODY>
</HTML>