<?php
##############################
#### Mod Joe. 07.05.2013 #####
##############################
// P.S. Автору кода руки оторвать нада) перепишите при первой же возможности MySQL Запросы [3996][1.56657 sec]

define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
############################## 

$cX = -22; $cY = -26;

echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="/css/mapinfo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>WindLand - Карта земель</title>

</head>
<body style="margin:0;">
<table border=1 cellpadding="0" cellspacing="0" align="center" width=4470>';
$startX+=$cX; $startY+=$cY;
for($y=0;$y<=36;$y++)
{
	echo'<tr>';
	for($x=0;$x<=53;$x++)
	{
	    $location = $db->sqla("SELECT * FROM nature WHERE x = ".($x+$startX)." AND y = ".($y+$startY)." ;");
//		$bots = $db->sqla("SELECT * FROM `nature_bots` WHERE `x` = '".$x."' AND `y` = '".$y."'"); // Руки оторвать автору кода
		$sign = $db->sqla("SELECT * FROM `bots` WHERE `id` = '".$location['bot']."'");		
		echo'<td background="/images/map/'.(($location)?'day':'night').'/'.$x.'_'.$y.'.jpg" width=80 height=80 valign="top">
			<b class="go-'.(($location)?'yes':'no').'">&nbsp;'.($x+$startX).":".($y+$startY).'&nbsp;</b>
			'.(($location["wood"])?'<br><font class="Bot-info">Деревья</font>':'').' 
			'.(($location["herbal"])?'<br><font class="Bot-info">Трава</font>':'').' 
			'.(($location["fishing"])?'<br><font class="Bot-info">Рыба</font>':'').'<br />
			'.(($sign)?'<font class="Bot-info">'.preg_replace("/, /","<br />",$sign['user']).' '.$location['blvlmin'].'-'.$location['blvlmax'].'</font>':'').' 
			'.(($location["name"])?'<br><font class="loc-info">'.$location["name"].'</font>':'').'</td>';
	}
	echo'</tr>';
}
echo'</table>
</body>
</html>';



//include (ROOT.'/inc/AdmOtladka.php');

?>