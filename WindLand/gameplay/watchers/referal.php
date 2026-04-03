<?php
if ($p25<>1) exit;

	echo "<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=referal&sort=lvl>Выше 0-го уровня</a> | 
	<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=referal&sort=lvls>С 5-го уровня</a> | 
	<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=referal&sort=ips>Совпадение IP</a> |
	<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=referal&sort=all>Все</a>";
	if (isset($http->get['sort'])) $refiss=true; else $refiss=false;
	if ($refiss==true and $http->get['sort']=='lvl') $last = " and `level`>0";
	if ($refiss==true and $http->get['sort']=='lvls') $last = " and `level`>4";
	if ($refiss==true and $http->get['sort']=='ips') $last = " and `lastip`='".$player->pers['lastip']."'";
	if (empty($http->get['sort']) or $http->get['sort']=='all') $last = '';
	
	$frs = $db->sql('SELECT `uid` FROM `log_referals` WHERE `whoref`='.$player->pers['uid'].' ORDER BY `date`;');
	echo '<table border="0" width="60%" cellspacing="0" cellpadding="0" class=LinedTable>';
	$count = 0;
	while ( $per = $db->fetchAssoc($frs) ) 
	{
		$perssost = $db->sqla("SELECT `user`,`online`,`block`,`location`,`state`,`level`,`sign`,`ds`,`lastip` FROM `users` WHERE `uid`=".$per['uid']." ".$last);
		if ($perssost==false) continue;
		$count++;
		echo"<tr>";
		echo "<td class=ym>".$count.".&nbsp;</td>";
		echo "<td class=timef>".$perssost['ds']."</td>";
		echo "<td class=user>";
		echo "<img src='http://".IMG."/signs/".$perssost['sign'].".gif' title='".$perssost['state']."'>";
		echo " ".$perssost['user']."[<font class=lvl>".$perssost['level']."</font>]";
		echo "<img src='http://".IMG."/i.gif' onclick=\"javascript:window.open('info.php?".$perssost['user']."','_blank')\" style=cursor:pointer>";
		echo "</td>";
		if ($perssost['online']==1) 
		{
			$loc = $db->sqla_id ("SELECT `name` FROM `locations` WHERE `id`='".$perssost['location']."'");
			echo "<td class=green>&nbsp;".$loc[0]."</td>";
		}
		else 
			echo "<td class=items> оффлайн</td>";
		if (!empty($perssost['block'])) echo "<td class=hp title='".$perssost['block']."' style='cursor:pointer'>Заблокирован</td>"; else echo "<td></td>";
		if ($perssost['lastip']==$player->pers['lastip']) echo "<td class=hp title='".$perssost['lastip']."' style='cursor:pointer'>Совпадение IP</td>"; else echo "<td></td>";
		echo "</tr>";
		
	}
	echo '</table>';
	if ($count==0) echo 'Рефералов нет.';
?>