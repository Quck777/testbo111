<?php
if ($p18<>1) exit;

	$res = $db->sql("SELECT * FROM `watch_passmail` WHERE `uid`=".$player->pers["uid"]." ORDER BY `date` DESC");
	echo '<table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>';
	
	while($rs = $db->fetchAssoc($res))
	{
		echo "<tr>";
		echo "<td bgcolor=#DDFFDD class=timef>".date("d.m.y H:i:s",$rs['date'])."</td>";
		echo "<td class=items>".$rs['ip'];
		echo "</td>";
		echo "<td class=return_win>".$rs['text']."</td>";
		echo "</tr>";
	}
	echo '</table>';
?>