<?

	echo "<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=battles&last=day>За последний день</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=battles&last=3day>За последние 3 дня</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=battles&last=week>За последнюю неделю</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=battles&last=all>Все</a>";
	if (empty($http->get["last"]) or $http->get["last"]=='day') $last = " and time>".(tme()-86400);
	if ($http->get["last"]=='3day') $last = " and time>".(tme()-3*86400);
	if ($http->get["last"]=='week') $last = " and time>".(tme()-7*86400);
	if ($http->get["last"]=='all') $last = "";
	$bs = $db->sql("SELECT * FROM `battle_logs` WHERE uid=".$player->pers["uid"]." ".$last." ORDER BY `time` DESC;");
	echo '<table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>';
	while($b = mysql_fetch_assoc($bs))
	{
		echo "<tr>";
		echo "<td bgcolor=#DDFFDD class=timef>".date("d.m.y H:i:s",$b["time"])."</td>";
		echo "<td class=but><a class=timef href=battle_log.php?id=".$b["cfight"]." target=_blank>Лог боя</a>";
		echo "</td>";
		echo "<td>".$b["text"]."</td>";
		echo "</tr>";
	}
	echo '</table>';
?>