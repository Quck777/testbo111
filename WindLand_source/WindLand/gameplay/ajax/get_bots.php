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



$pers = $db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($http->_cookie('uid')).' and `pass` = "'.$http->_cookie('hashcode').'" and `block`="" and `location` = "out";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if ( !$pers ) {echo 'F5@1'; exit;}


include (ROOT.'/inc/class/bots_map.class.php');

$mb = new MapBots($pers);

if ( $http->_get('act')==1 )
	echo $mb->viewlistBots();
elseif ( $http->_get('act')==2 )
{
	include (ROOT.'/inc/func.php');
	include (ROOT.'/inc/func2.php');
	include (ROOT.'/inc/battle_func.php');
	$mb->attacBots((int)$http->_get('bid'));
}
exit;

//[19:28:08.202] RemoveDialogDiv is not defined @ javascript:%20RemoveDialogDiv();:1




?>OK@[["Волк","11","123456",[1,2,3,4,5,6,7,8,9,1,2,3]],["Волк","11","123456",[1,2,3,4,5,6,7,8,9,1,2,3]]]