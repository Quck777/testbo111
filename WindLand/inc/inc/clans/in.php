<?php
$stm = microtime(true);

if ( !$player->getClan() ) {echo '<center>Вы не состоите в клане.</center>'; exit;}

$clan = $player->getClan();

if ($clan==false) {echo '<center>Вашего клана не существует, обратитесь к Смотрителям.</center>'; exit;}

DEFINE ('CLANS', true); // Идентификатор клана

$ppr = explode('|', $player->pers['clan_prev']);
/*
	1|1|1|1|1|1|1|1|1|1|
	$ppr[0] = Принимать в клан
	$ppr[1] = Выгонять из клана
	$ppr[2] = Менять статус соклана
	$ppr[3] = Менять должность соклана
	$ppr[4] = Брать деньги из казны
	$ppr[5] = Удалять вещи из казны
	$ppr[6] = Снимать вещи с соклана
	$ppr[7] = Управлять возможностями клана
	$ppr[8] = Устанавливать права сокланов
	$ppr[9] = Использовать рупор
*/

function clans_log($uid, $who, $type, $sign)
{
	GLOBAL $db;
	/*
	1 - Принятие
	2 - Исключение
	3 - Пожертвовано в клан
	4 - Забрано из клана
	5 - Пожертвование вещи в казну
	6 - Передача клана
	7 - Смена клан-сайта
	8 - Кладем бр
	9 - Снимаем бр
	
	10- Объявляем войну
	11- Заявка на альянс
	12- Заключение альянса
	13- Выплата контребуции
	14- Расторжение альянса
	*/
	if ($type==1 or $type==2 or $type==6) $txt = ''; else {$txt = $who; $who = '';}
	$db->sql("INSERT INTO `clans_log` (`uid`, `who`, `type`, `date`, `sign`, `text`) VALUES (".$uid.", '".$who."', ".$type.", ".tme().", '".$sign."', '".$txt."');");
}

//sql("INSERT INTO `watch_verification` (`uid`, `who`, `date`) VALUES (5164, 'RICH', ".time().");");


if ( $clan['sign']=='watchers' )
	include ('_watch.php');
else
	include ('_info.php');

?>