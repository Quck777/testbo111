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
$player = new Player;
if ( !$player->pers ) exit;


if ( $http->_get('x')==$player->pers['x'] and $http->_get('y')==$player->pers['y'] ) die('NO@cord');
$world = $db->sqla('SELECT `weather`,`weatherchange` FROM `world`');
define('WEATHER', $world["weather"]);

include (ROOT.'/inc/func.php');
include (ROOT.'/inc/class/map.class.php');

$map = new Naturen($player->pers);

// Перемещение
if ( isset($http->get['x']) and isset($http->get['y']) )
	$map->goloc_to_newcord((int)$http->get['x'], (int)$http->get['y']);
elseif ( isset($http->get['istel']) ) $map->is_teleport_list();
elseif ( isset($http->get['gotel']) ) $map->go_teleport(intval($http->_get('tx')), intval($http->_get('ty')));

?>