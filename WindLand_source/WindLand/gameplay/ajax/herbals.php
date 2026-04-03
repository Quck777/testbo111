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

$pers = $db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($http->_cookie('uid')).' and `pass` = "'.$http->_cookie('hashcode').'" and `block`="" and `location` = "out";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if ( !$pers ) {echo 'F5@1'; exit;}

$world = $db->sqla('SELECT `weather`,`weatherchange` FROM `world`');
define('WEATHER', $world["weather"]);

include (ROOT.'/inc/class/herbals.class.php');
$hr = new Herbals($pers);

if ( $http->_get('act')==1 ) echo $hr->view_hlist();
elseif ( $http->_get('act')==2 ) echo $hr->srezHerbal(intval($http->_get('rid')), $http->_get('code'));


?>