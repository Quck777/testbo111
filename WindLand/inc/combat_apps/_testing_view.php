<?
	if (@$http->get["attack"])
	{
			$bid = $db->sqlr("SELECT id FROM bots WHERE user='".$http->post["name"]."' and level=".intval($http->post["lvl"])." and special=0");
			begin_fight ($player->pers["user"],"bot=".$bid."|","Тестирующий бой",-1,300,1,0);
			echo "location='main.php';";
	}
	
	echo '</script><script type="text/javascript" src="/js/admin_script/adm_bots.js?3"></script><script>';
	$allbots_names = $db->sql("SELECT user,id,obr,pol FROM bots GROUP BY user;");
	$txt = '';
	$txt .= "<center class=fightlong><table class=LinedTable border=0 width=100%>";
	while ($bn = mysql_fetch_array($allbots_names,MYSQL_ASSOC))
	{
		$lvls = $db->sqla("SELECT MAX(level) as maxlvl, MIN(level) as minlvl,MAX(rank_i) as maxrank, MIN(rank_i) as minrank FROM bots WHERE user='".$bn["user"]."'");
		$txt .= "<tr>";
		$txt .= "<td><img src=images/persons/male_".$bn["obr"].".gif height=50 onclick=\"javascript:window.open(\'binfo.php?".$bn["id"]."\',\'_blank\')\" style=\"cursor:pointer\">";
		$txt .= "</td>";
		$txt .= "<td class=user>".$bn["user"];
		$txt .= "<input type=button value=\"Hапасть\" class=but onclick=\"Attack(\'".$bn["user"]."\',".$lvls["minlvl"].",".$lvls["maxlvl"].");\">";
		$txt .= "</td>";
		$txt .= "<td class=ym><b>".$lvls["minlvl"]."</b>[<i>".intval($lvls["minrank"])."</i>] - <b>".$lvls["maxlvl"]."</b>[<i>".intval($lvls["maxrank"])."</i>]</td>";
		$txt .= "</tr>";
	}
	$txt .= "</table></center>";
	
	echo "var text = '".$txt."';";
?>