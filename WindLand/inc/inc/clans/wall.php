<?php
if ( defined('CLANS')==false ) {echo '<center>Ошибка.</center>'; exit;}

if ( isset($http->post["report"]) and !empty($http->post['report']) )
{
	$umg = ( $player->pers['sign'] == 'watchers' ) ? 'watch/'.$player->pers['clan_state'] : $player->pers['sign'];
	$db->sql("INSERT INTO `reports_for_clans` ( `csign` , `lvl` , `sign` , `date` , `who` , `text` ) 
	VALUES ('".$player->pers["sign"]."', '".$player->pers["level"]."', '".$umg."', '".tme()."', '".$player->pers["user"]."', '".$http->post['report']."');");
}

if (empty($http->get['all_reports']))
	$rep = $db->sql("SELECT * FROM `reports_for_clans` WHERE `csign`='".$player->pers["sign"]."' ORDER BY `date` DESC LIMIT 7;");
else
	$rep = $db->sql("SELECT * FROM `reports_for_clans` WHERE `csign`='".$player->pers["sign"]."' ORDER BY `date` DESC");
while( $r = mysql_fetch_assoc ($rep) )
{
	if ( isset($repr) ) $repr .= ",['".$r['who']."', ".$r['lvl'].", '".$r['sign']."', '".date("d.m.Y H:i", $r['date'])."', '".str_replace("\n",'<br>',str_replace("\r",'',$r['text']))."']";
	else $repr = "['".$r['who']."', ".$r['lvl'].", '".$r['sign']."', '".date("d.m.Y H:i", $r['date'])."','".str_replace("\n",'<br>',str_replace("\r",'',$r['text']))."']";
}
$data = "var data = [".$repr."];\n";
?>