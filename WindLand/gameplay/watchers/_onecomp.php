<?
	echo "<a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=onecomp&last=day>За последний день</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=onecomp&last=3day>За последние 3 дня</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=onecomp&last=week>За последнюю неделю</a> | <a class=timef href=info.php?id=".$player->pers["uid"]."&do_w=onecomp&last=all>Все</a>";
	if ($http->get["last"]=='day') $last = " and time>".(tme()-86400);
	if ($http->get["last"]=='3day') $last = " and time>".(tme()-3*86400);
	if ($http->get["last"]=='week') $last = " and time>".(tme()-7*86400);
	if (empty($http->get["last"]) or $http->get["last"]=='all') $last = "";
	$bs = $db->sql("SELECT * FROM `logs_one_comp_logins` WHERE (uid1=".$player->pers["uid"]." or uid2=".$player->pers["uid"].") ".$last);
	echo '<table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>';
	while($b = $db->fetchAssoc($bs))
	{
		$another = ($player->pers["uid"]==$b["uid1"])?$b["uid2"]:$b["uid1"];
		$another = $db->sqlr("SELECT `user` FROM `users` WHERE `uid`=".intval($another));
		echo "<tr>";
		echo "<td bgcolor=#DDFFDD class=timef>".date("d.m.y H:i:s",$b["time"])."</td>";
		echo "<td class=but>".$player->pers["user"];
		echo "</td>";
		echo "<td class=but>".$another."<a href=info.php?".$another." target=_blank><img src=images/i.gif></a></td>";
		echo "</tr>";
	}
	echo '</table>';
?>