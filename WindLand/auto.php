<?php
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp();

## Файлы функций
include (ROOT.'/inc/func.php');		// Функции частого использования в разных частях игры
include (ROOT.'/inc/func2.php');	// Функции реже используемые
include (ROOT.'/inc/func3.php');	// Функции специфического использования, вызов в редких файлах


function remove_weapon_orden($v,$uid)
 {
	//GLOBAL $pers;
	$pers = $db->fetchArray($db->sql("SELECT * FROM `users` WHERE `uid`='".$uid."' LIMIT 1"));
	if (!is_array($v)) $v = $db->fetchArray($db->sql("SELECT * FROM `wp` WHERE `id` = '".$v."' and `weared`=1 and `uidp`='".$pers["uid"]."' LIMIT 1"));
	if ($v){
	$r = all_params();
	foreach ($r as $a)
	if ($v[$a]) $pers[$a] -= $v[$a];
	$pers["hp"]-=5*$v["s4"];
	$pers["ma"]-=9*$v["s6"];
	if ($aq=aq($pers))
	$db->sql("UPDATE `users` SET ".$aq." WHERE `uid` = '".$uid."' ;");
	$db->sql("UPDATE wp SET weared=0 WHERE id=".$v["id"]."");
	}
 }

//$pers = $db->fetchAssoc($db->sql('SELECT * FROM `users` WHERE `uid` = '.$_COOKIE['uid'].' LIMIT 1;'));




/*UPDATE `wp` SET `type`='gavno',`tlevel`=50,`id_in_w`='000' WHERE `id_in_w`='' and `dprice`>0*/

if ($http->get["test"] == 1) {
$items = $db->sql("SELECT * FROM `wp` WHERE `id_in_w`='' and `dprice`>0 and `uidp`=731");
$kk = 0;
while ($i = $db->fetchArray($items)){    $kk++;
    ## Вещь существует, вещь одета, персонаж не в бою. Персонаж оффлайн.
	remove_weapon_orden ($i["id"],$i["uidp"]);
}


echo "СНято <b>".$kk." шт.</b> вещей.";
}
?>