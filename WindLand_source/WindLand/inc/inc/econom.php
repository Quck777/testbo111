<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

$status = $player->pers["clan_state"];
define("DD_STND_KOEF",1);
define("DD_CLAN_KOEF",1);
$_RETURN = '';
$time = tme();
//Фильтры
if (@$http->post["fornickname"]) $http->post["fornickname"] = trim($http->post["fornickname"]);
if (@$http->post["forprice"]) $http->post["forprice"] = abs(intval($http->post["forprice"]));
##
if ($player->pers["punishment"]>=$time)$_RETURN .= "На вас наложена кара смотрителей. Некоторые действия недоступны.";


$tmp = $db->sqlr("SELECT COUNT(esttime) FROM p_auras WHERE uid=".$player->pers["uid"]." and special=6 and esttime>".tme());
$_ECONOMIST = ($tmp)?1:0;

include ("economics/weapons.php");
include ("economics/money.php");
include ("economics/attack.php");
include ("economics/auras.php");
include ("economics/sneg.php");
//include ("economics/prizes.php");


?>