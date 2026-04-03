<?php

	if ($cat==1 and intval($http->_get("id")) <0 )
	{
		if ($player->pers["level"]<20)
		{
			$lb = $db->sqla("SELECT b_frequency FROM configs");
			if (($player->pers["lb_attack"]+$lb["b_frequency"])<=tme())
			{
				$b = $db->sqla("SELECT id,level,user,rank_i FROM bots WHERE id=".abs(intval($http->get["id"]))."");
				if ($b["level"]>$player->pers["level"]-2 and $b["level"]<$player->pers["level"]+2 and $b["rank_i"]<$player->pers["rank_i"]+140)
				{
					$lb_attack = $player->pers["level"]*30;
					if ($player->pers["level"]<20) $lb_attack/= 2;
						else
					$lb_attack += 100;
					$lb_attack += tme();
					$rnd = rand(1,$player->pers["level"]/3+1);
					$bb = '';
					for ($i=1;$i<=$rnd;$i++)$bb.="bot=".$b["id"]."|";
					$bb = substr($bb,0,strlen($bb)-1);
					begin_fight ($player->pers["user"],$bb,"Битва на арене",50,300,1,0);
					echo "location='main.php';";
					$db->sql("UPDATE users SET lb_attack=".$lb_attack." WHERE uid=".$player->pers["uid"]);
				}
			}
		}
	}
	if ( @$http->get["id"][0]!="!" and intval($http->_get("id"))>0)
	{
		$app = $db->sqla("SELECT * FROM app_for_fight WHERE type=".$cat." and id=".intval($http->get["id"])."");
		if ($app)
		{
			if ($cat==1 and $app["pl2"]==0) 
			{
				set_vars("apps_id=".$app["id"].",fteam=2",UID);
				$db->sql("UPDATE app_for_fight SET pl2=1,atime=".(time()+300)." WHERE id=".$app["id"]."");
				$db->sql("UPDATE users SET refr=1 WHERE apps_id=".$app["id"]."");
				$player->pers["apps_id"] = $app["id"];
			}
			if ($cat==2) 
			{
				if ($http->get["fteam"]==1 and $app["count1"]>$app["pl1"] and
				$player->pers["level"]>=$app["minlvl1"] and $player->pers["level"]<=$app["maxlvl1"])
				{
					set_vars("apps_id=".$app["id"].",fteam=1",UID);
					$db->sql("UPDATE app_for_fight SET pl1=pl1+1 WHERE id=".$app["id"]."");
					$player->pers["apps_id"] = $app["id"];
				}
				if ($http->get["fteam"]==2 and $app["count2"]>$app["pl2"] and
				$player->pers["level"]>=$app["minlvl2"] and $player->pers["level"]<=$app["maxlvl2"])
				{
					set_vars("apps_id=".$app["id"].",fteam=2",UID);
					$db->sql("UPDATE app_for_fight SET pl2=pl2+1 WHERE id=".$app["id"]."");
					$player->pers["apps_id"] = $app["id"];
				}
			}
			if($cat==3) 
			{
				if ($app["count1"]>$app["pl1"] and
				$player->pers["level"]>=$app["minlvl1"] and $player->pers["level"]<=$app["maxlvl1"])
				{
					set_vars("apps_id=".$app["id"].",fteam=1",UID);
					$db->sql("UPDATE app_for_fight SET pl1=pl1+1 WHERE id=".$app["id"]."");
					$player->pers["apps_id"] = $app["id"];
				}		
			}
		}
	}
	elseif( @$http->get["id"][0]=="!" )
	{
		$uid = intval(substr($http->get["id"],1));
		include("_begin_ghost_fight.php");
		begin_ghost_fight($uid,$player->pers["user"],"Битва на арене",50,120,1,0);
	}
?>