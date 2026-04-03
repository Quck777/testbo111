<?php

	if ($http->post["C1"].$http->post["C2"].$http->post["C3"])
	{
		$c1 = intval($http->post["C1"]);
		$c2 = intval($http->post["C2"]);
		$c3 = intval($http->post["C3"]);
		$from = explode(".",$http->post["from"]);
		$to = explode(".",$http->post["to"]);
		$from = mktime(0,0,0,$from[1],$from[0],$from[2]);
		$to = mktime(0,0,0,$to[1],$to[0],$to[2]);
	}else
	{
		$c1 = 1;
		$c2 = 1;
		$c3 = 1;
		$from = mktime(0,0,0,1,1,2007);
		$to = tme()+86400;
	}
		echo "<script>transfer('".$player->pers["user"]."',$c1,$c2,$c3,'".date("d.m.y",$from)."','".date("d.m.y",$to)."');</script>";
		
	$q = "date>".$from." and date<".$to." and (";
	if ($c1) $q.='type=1 or type=4 or ';
	if ($c2) $q.='type=2 or type=5 or ';
	if ($c3) $q.='type=3 or type=6 or ';
	$q = substr($q,0,strlen($q)-3).")";
	if (@$http->get["nick"]) $q.=" and who='".$http->get["nick"]."'";
	
	$trs = $db->sql("SELECT * FROM transfer WHERE uid=".$player->pers["uid"]." and ".$q."");
	
	$st = Array();
	$summ_in = 0;
	$summ_out = 0;
	
	echo '<table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center><tr><td>ДАТА</td><td>ТИП</td><td>НИК ТРАНЗАНКЦИИ</td><td>Пришло LN</td><td>Ушло LN</td><td>IP клиента</td><td>IP транзанкции</td><td>Описание</td><td></td></tr>';
	while($tr = $db->fetchAssoc($trs))
	{
		if ($tr["type"]==1) {$color = '#FFCCCC';$tt = 'ПРОДАЖА(вещь)>>';}
		if ($tr["type"]==2) {$color = '#AADDAA';$tt = 'ПЕРЕДАЧА(вещь)>>';}
		if ($tr["type"]==3) {$color = '#AAAADD';$tt = 'ПЕРЕДАЧА(LN)>';}
		if ($tr["type"]==4) {$color = '#FFEEEE';$tt = 'покупка(вещь)<<';}
		if ($tr["type"]==5) {$color = '#CCFFCC';$tt = 'принятие(вещь)<<';}
		if ($tr["type"]==6) {$color = '#CCCCFF';$tt = 'принятие(LN)<';}
		$st[$tr["who"]] += $tr["transfer_in"] - $tr["transfer_out"];
		$summ_in += $tr["transfer_in"];
		$summ_out += $tr["transfer_out"];
		echo "<tr>";
		echo "<td bgcolor=".$color." class=timef>".date("d.m.y H:i:s",$tr["date"])."</td>";
		echo "<td class=items>".$tt."</td>";
		echo "<td class=user><a href='info.php?p=".$player->pers["user"]."&do_w=sells&nick=".$tr["who"]."' class=timef>".$tr["who"]."</a>";
		echo " <a href='info.php?".$tr["who"]."' target=_blank>";
		echo "<img src=images/i.gif></a>&nbsp;";
		echo "</td>";
		if ($tr["ip1"]==$tr["ip2"]) $ip_equality = "ПОДОЗРЕНИЕ"; else $ip_equality="&nbsp;";
		echo "<td class=green>".$tr["transfer_in"]."</td>";
		echo "<td class=red><b>".$tr["transfer_out"]."</b></td>";
		echo "<td class=timef>".$tr["ip1"]."</td>";
		echo "<td class=timef>".$tr["ip2"]."</td>";
		echo "<td class=login>".$tr["title"]."</td>";
		echo "<td class=hp>".$ip_equality."</td>";
		echo "</tr>";
	}
	echo '</table>';
	foreach ($st as $key=>$value)
	echo "<br> Сумма от <b>".$key."</b> : ".$value;
	echo "<hr>";
	echo "Приход: ".$summ_in." LN ; Уход: ".$summ_out." LN ; Разница: ".($summ_in-$summ_out);
?>