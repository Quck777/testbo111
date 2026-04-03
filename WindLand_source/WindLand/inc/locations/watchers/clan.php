<?php

if ($rk[52]==0 and $status!='wg') exit('Доступ запрещен');

	function generate_sostav($us)
	{
		GLOBAL $db;
		$r = '';
		$r.= '<tr><td>';
		if ( defined('ALIGN') ) $r.= "<img src='http://".IMG."/signs/align/".ALIGN.".gif' width=15 height=12 border=0> ";
		$r.= "<img src='http://".IMG."/signs/".$us['sign'].".gif' width=15 height=12 border=0> <font class=user>".$us['user']."</font><font class=lvl>[".$us['level']."]</font>";
		$r.= '<img src=\'http://'.IMG.'/i.gif\' onclick="javascript:window.open(\'/info.php?'.$us['user'].'\',\'_blank\');" style=\'cursor:pointer\'></td>';
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
		$r.= "<td><img src='http://".IMG."/emp.gif' width=50 height=1></td><td><b style='color:".$color."'>"._StateByIndex($us['clan_state'])."</b>[".$us['state']."]</td>";
		if ($us['online']==1) 
		{
			$loc = $db->sqlr("SELECT `name` FROM `locations` WHERE `id`='".$us['location']."' ;");
			$r.= "<td class=green>".$loc."</td>";
		} else $r.= "<td class=hp>".time_echo(tme()-$us['lastom'])."</td>";
		$r.= "</tr>";
		return $r;
	}
	
	if ( !isset($http->get['do']))
	{
		$cl = $db->sql("SELECT * FROM `clans` WHERE `sign`<>'watchers'");
		echo "<table class=but width='90%'>";
		$i = 1;
		while($c = mysql_fetch_assoc($cl))
		{
			$alg = $db->sqlr("SELECT `align` FROM `aligns` WHERE `align`='".$c['align']."' ;");
			$aimg = ($alg != false) ? "<img src='http://".IMG."/signs/align/".$alg.".gif' width=15 height=12> " : '';
			echo "<tr>";
			echo "<td>".($i++)."</td>";
			if (!empty($c['staus']))
			{
				echo "<td class=user>".$aimg."<img src=http://".IMG."/signs/".$c['sign'].".gif>".$c['name']."</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td class=user title='".$c['staus']."'><a class=bga href=\"main.php?w=clan&do=".$c['sign']."\">Расформирован</a></td>";		
			} else {
				echo "<td class=user>".$aimg."<img src=http://".IMG."/signs/".$c['sign'].".gif>".$c['name']."[".$c['level']."]</td>";
				echo "<td class=green><a href=info.php?".$c['glav']." target=_blank>".$c['glav']."</a></td>";
				echo "<td><a class=bg href=http://".$c['sait']." target=_blank>".$c['sait']."</a></td>";
				echo "<td><a class=bga href=\"main.php?w=clan&do=".$c['sign']."\">Состав</a></td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	} elseif ( isset($http->get['do']) )
	{
		$get_clan = $http->get['do'];
		unset($http->get['do']);

		$clan = $db->sqla('SELECT * FROM `clans`	WHERE `sign`="'.$get_clan.'" LIMIT 0,1;'); 
		if ($clan == false) die('Нет такого клана');

		$align = $db->sqlr("SELECT `align` FROM `aligns` WHERE `align`='".$clan['align']."' ;");
		
		if ($align != false) DEFINE ('ALIGN', $align);

		$usr = $db->sql('SELECT * FROM `users` WHERE `sign`="'.$clan['sign'].'" ORDER BY `clan_state` ASC;');
		echo '<table border="0" cellpadding="0" cellspacing="0" align="center">';
		while ( $us = mysql_fetch_assoc($usr) )
		{
			echo generate_sostav($us);
		}
		echo '</table>';
	}
	

?>