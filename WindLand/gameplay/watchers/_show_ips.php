<?php
if ($p15<>1) exit;

	if (empty($http->post["mlt"]))
	{
		if (@$_POST and $p16)
		{
			$tg = tme() - (3600 * 24 * 7);
			$q = '';
			foreach($_POST as $key => $v)
			{
				if ($v!="1") continue;
				$dt = (int)str_replace('ip_','',$key);
				if ( $dt > $tg ) continue;
				$q.= str_replace("ip_","`date`=",$key).' or ';
			}
			$q = substr($q,0,strlen($q)-3);
			if ( !empty($q) )
				$db->sql("DELETE FROM `logs_ips_in` WHERE `uid`=".$player->pers["uid"]." and (".$q.");");
		}
		
		echo "<form method=post name=ips><table border='1' cellspacing='0' cellpadding='0' bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>";
		$ips = $db->sql("SELECT * FROM `logs_ips_in` WHERE `uid`=".$player->pers["uid"]." ORDER BY `date` DESC;");
		while( $ip = $db->fetchAssoc($ips) )
		{
			echo "<tr align=center>";
			echo "<td width=10><input type=checkbox name=ip_".$ip['date']." value=1></td>";
			echo "<td width=100 class=timef bgcolor='#".((date('d', tme()) == date('d', $ip['date'])) ? 'FFCCCC' : 'FFDDDD')."'>&nbsp;".date("d.m.y H:i",$ip['date'])."&nbsp;</td>";
			echo "<td width=100 class=items aling=center>&nbsp;".$ip['ip']."&nbsp;</td>";
			echo "<td width=500 class=timef aling=center>&nbsp;".$ip['brouser']."&nbsp;</td>";
			echo "</tr>";
		}
		echo "</table><input type=hidden name=mlt value=0><input type=button class=login value='Выделить все' onclick='select_all_checks()'><input type=submit class=login value='Удалить выделенные'><input type=button class=login value='Найти мультов с выделенными адресами' onclick='document.ips.mlt.value=1;document.ips.submit();'></form>";
	}
	else
	{
		if (@$_POST)
		{
			$q = '';
			foreach($_POST as $key => $v)
			if ($v=="1" and $key<>'mlt') $q .= str_replace("ip_","`date`=",$key).' or ';
			
			$q = substr($q,0,strlen($q)-3);
			$ips = $db->sql("SELECT `ip` FROM `logs_ips_in` WHERE uid=".$player->pers["uid"]." and (".$q.")");
			$q = '';
			$ch_str = '';
			while ($ip = $db->fetchAssoc($ips))
			if (!substr_count($ch_str,"<".$ip["ip"].">"))
			{
				$q.= "`ip`='".$ip["ip"]."' or ";
				$ch_str .= "<".$ip["ip"].">";
			}
			
			$q = substr($q,0,strlen($q)-3);
			$mults = $db->sql("SELECT uid,date FROM logs_ips_in WHERE uid<>".$player->pers["uid"]." and (".$q.")");
			$counter = 0;
			echo '<table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>';
			while ($mult = $db->fetchAssoc($mults) and ($counter++ +1))
			{
				$m = $db->sqla("SELECT `user`,`level`,`sign` FROM `users` WHERE `uid`=".$mult["uid"]."");
				echo"<tr>";
				echo "<td width=100 class=timef>".date("d.m.y H:i",$mult["date"])."</td>";
				echo"<td width=200 align=center>";
				echo "<img src=/images/signs/".$m["sign"].".gif><font class=user>".$m["user"]."</font>";
				echo "[<font class=lvl>".$m["level"]."</font>]";
				echo "<a href=info.php?".$m["user"]." target=_blank>";
				echo "<img src=images/i.gif></a>";
				echo"</td>";
				echo"</tr>";
			}
			if ($counter == 0)
			echo "<tr><td>Не найдено ниодного мульта!</td></tr>";
			echo "</table>";
		}
	}
?>
