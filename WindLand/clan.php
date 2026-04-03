<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
############################## 

$get_clan = $_GET['id'];
unset($_GET['id']);

$clan = $db->sqla('SELECT * FROM `clans`	WHERE `sign`="'.$get_clan.'" LIMIT 0,1;'); 
if ($clan == false) die('Нет такого клана');

include (ROOT.'/inc/func.php');

$align = $db->sqlr("SELECT `align` FROM `aligns` WHERE `align`='".$clan['align']."' ;");


DEFINE ('HOST', $_SERVER['HTTP_HOST']);
if ($align != false) DEFINE ('ALIGN', $clan['align']);

$usr = $db->sql('SELECT * FROM `users` WHERE `sign`="'.$clan['sign'].'" ORDER BY `clan_state` ASC;');




function generate_sostav($us)
{
	GLOBAL $db;
	if ($us["uid"] == 7) $us = j_pers($us);
	$color = '#333333';
	if ($us['clan_state']=='a') $color = '#990000';
	if ($us['clan_state']=='b') $color = '#DD0000';
	if ($us['clan_state']=='c') $color = '#4B0082';
	if ($us['clan_state']=='d') $color = '#009900';
	if ($us['clan_state']=='e') $color = '#000099';
	if ($us['clan_state']=='f') $color = '#009999';
	if ($us['clan_state']=='g') $color = '#800080';
	if ($us['clan_state']=='h') $color = '#1E90FF';
	if ($us['clan_state']=='i') $color = '#D87093';
	if ($us['clan_state']=='j') $color = '#688E23';
	if ($us['clan_state']=='k') $color = '#00CED1';
	if ( $us['online']==1 and $us['invisible']<tme() ) $loc = $db->sqlr("SELECT `name` FROM `locations` WHERE `id`='".$us['location']."';");
	else $loc = time_echo(tme()-$us['lastom']);
	
	$r = '';
	$r.= '<tr><td>';
	if ( defined('ALIGN') ) $r.= "<img src='/images/signs/align/".ALIGN.".gif' width=15 height=12 border=0> ";
	$r.= "<img src='/images/signs/".$us['sign'].".gif' width=15 height=12 border=0> <font class=user>".$us['user']."</font><font class=lvl>[".$us['level']."]</font>";
	$r.= '<img src=\'/public_content/chimg/i.gif\' onclick="javascript:window.open(\'http://'.HOST.'/info.php?'.($us['user']).'\',\'_blank\')" style=\'cursor:pointer\'></td>';
	$r.= "<td><img src='/images/emp.gif' width=50 height=1></td><td><b style='color:".$color."'>"._StateByIndex($us['clan_state'])."</b>[".$us['state']."]</td>";
	$r.= '<td>'.$loc.'</td>';
	$r.= "</tr>";
	return $r;
}




if ( isset($_GET['js']) )
{
	while ( $us = $db->fetchAssoc($usr) )
	{
		$res = generate_sostav($us);
		echo 'document.write("'.($res).'");'."\n";
	}
	exit;
}


?>
<HTML>
<HEAD>
<TITLE>Информация о клане (<?php echo $clan['name'];?>)</TITLE>
<META Content='text/html; charset=UTF-8' Http-Equiv=Content-type>

<LINK href='/css/main_v2.css' rel=STYLESHEET type=text/css>
</HEAD>
<BODY style='overflow:hidden;'>
	<h1 align="center"><?php echo $clan['name'];?></h1>
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	<?php
	while ( $us = $db->fetchAssoc($usr) )
	{
		echo generate_sostav($us);
	}
	?>
	</table>
</BODY>
</HTML>