<?
	#View all apps::
	$allapps = $db->sql("SELECT * FROM app_for_fight WHERE type=".$cat."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$s = '';
	$UNIXtime = tme();
	$counter = 0;
	while($app = mysql_fetch_array($allapps,MYSQL_ASSOC))
	{
		if (!$app["id"]) continue;
		if (intval($_FILTER["apps"])==0)
		{
			if ($app["type"]==1 and $player->pers["level"]<>$app["minlvl1"]) continue;
			if ($app["type"]==2 and 
				($player->pers["level"]<$app["minlvl1"] or $player->pers["level"]>$app["maxlvl1"]) and
				($player->pers["level"]<$app["minlvl2"] or $player->pers["level"]>$app["maxlvl2"])
				) continue;
			if ($app["type"]==3 and 
				($player->pers["level"]<$app["minlvl1"] or $player->pers["level"]>$app["maxlvl1"])
				)continue;
		}
		$write_this = false;
		$p1 = '';
		$p2 = '';
		$p = $db->sql("SELECT sign,invisible,user,level,state,clan_name,fteam,rank_i FROM users WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		if ($app["pl1"]==$app["count1"] and $app["pl2"]==$app["count2"] 
		and $app["type"]==2) include ("_begin_group.php");
		elseif ($app["pl1"]==$app["count1"] 
		and $app["type"]==3) include ("_begin_haot.php");
		else
		{
			while($a = mysql_fetch_array($p))
			{
				$write_this = true;
				if ($a["invisible"]>tme() and $a["user"]<>$player->pers["user"])
				{
					$a["sign"] = 'none';
					$a["user"] = 'невидимка';
					$a["level"] = '??';
				}
				$a["state"] = $a["clan_name"].'['.$a["state"].']';
				if ($a["fteam"]==1)
					$p1 .= $a["sign"].'|'.$a["user"].'|'.$a["level"].'|'.$a["state"].'Х';
				else
					$p2 .= $a["sign"].'|'.$a["user"].'|'.$a["level"].'|'.$a["state"].'Х';
				$counter++;
			}
		
			if ($app["atime"]>$UNIXtime and $write_this) 
			{
			$s .= "'".$app["travm"].':'.$app["oruj"].':'.$app["timeout"].':';
			$s .= $app["count1"].':'.$app["count2"].':'.$app["minlvl1"].':';
			$s .= $app["minlvl2"].':'.$app["maxlvl1"].':'.$app["maxlvl2"].':';
			$s .= ($app["atime"]-$UNIXtime).':'.$app["comment"].':';
			$s .= substr($p1,0,strlen($p1)-1).':'.substr($p2,0,strlen($p2)-1).':'.$app["id"]."".':'.$app["bplace"]."'".',';
			}
			elseif (!$write_this) $db->sql("DELETE FROM app_for_fight WHERE id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			elseif ($app["atime"]<=$UNIXtime)
			{
				if ($app["type"]==1) 
				{
					$db->sql("DELETE FROM app_for_fight WHERE id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
					$db->sql("UPDATE users SET apps_id=0,refr=1 WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				}
				if ($app["type"]==2) 
				{
					if ($app["pl2"]) 
						{
						$p = $db->sql("SELECT sign,aura,user,level,state,clan_name,fteam FROM users WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
						include ("_begin_group.php");
						}
					else
					{
						$db->sql("DELETE FROM app_for_fight WHERE id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
						$db->sql("UPDATE users SET apps_id=0,refr=1 WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
					}
				}
				if ($app["type"]==3) 
				{

					if ($app["pl1"]>1) 
					{
						$p = $db->sql("SELECT user,rank_i FROM users WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
						include ("_begin_haot.php");
					}
					else
					{
						$db->sql("DELETE FROM app_for_fight WHERE id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
						$db->sql("UPDATE users SET apps_id=0,refr=1 WHERE apps_id=".$app["id"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
					}
				}
			}
		}
	}
	
	$lb_attack = 0;
	if ($cat == 1)
    {
        if ($player->pers["level"]<20 and $player->pers["level"]>1)
        {
            $lb = $db->sqlr("SELECT b_frequency FROM configs",0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
            if (($player->pers["lb_attack"]+$lb)<=tme())
            {
                $bts = $db->sql("SELECT id,user,level FROM bots WHERE level>".($player->pers["level"]-2)." and level<".($player->pers["level"]+2)." and rank_i<".($player->pers["rank_i"]+140)." and special=0 ORDER BY RAND() LIMIT 0,3", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
                while($bt = mysql_fetch_array($bts))
                {
                    $s .= '\'50:1:60:';
                    $s .= '1:1:1:';
                    $s .= '1:1:1:';
                    $s .= '0:“ренировочный бой:';
                    $s .= 'none|'.$bt["user"].'|'.$bt["level"].'|'.'::-'.$bt["id"]."".':0'."'".',';
                }
            }
            else
            {
                $lb_attack = $player->pers["lb_attack"] + $lb - tme();
            }
        }
        if ($player->pers["level"]<2 and $player->pers["level"]>=0)
        {
            $lb = $db->sqlr("SELECT b_frequency FROM configs",0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
            if (($player->pers["lb_attack"]+$lb)<=tme())
            {
                $bts = $db->sql("SELECT id,user,level FROM bots WHERE level>=0 and level<".($player->pers["level"]+2)." and rank_i<".($player->pers["rank_i"]+140)." and special=0 ORDER BY RAND() LIMIT 0,3", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
                while($bt = mysql_fetch_array($bts))
                {
                    $s .= '\'50:1:60:';
                    $s .= '1:1:1:';
                    $s .= '1:1:1:';
                    $s .= '0:“ренировочный бой:';
                    $s .= 'none|'.$bt["user"].'|'.$bt["level"].'|'.'::-'.$bt["id"]."".':0'."'".',';
                }
            }
            else
            {
                $lb_attack = $player->pers["lb_attack"] + $lb - tme();
            }
        }
        /*if ($player->pers["level"]<=2 and $counter<2)
        {
            $bts = sql('SELECT uid,user,level,ctip FROM users WHERE ctip=-1 and level='.($player->pers["level"]).' and silence=0 LIMIT 0,'.rand(2,3).'');
            if(!$bts)
                $bts = sql("SELECT uid,user,level,ctip FROM users WHERE level=".($player->pers["level"])." and block<>'' and rank_i>5 and s6=1 and s5=1 and silence = 0 LIMIT 0,".rand(2,3)."");
            while($bt = mysql_fetch_array($bts))
            {
                $s .= '\'50:1:20:';
                $s .= '1:1:1:';
                $s .= '1:1:1:';
                $s .= '0::';
                $s .= 'none|'.$bt["user"].'|'.$bt["level"].'|'.'::!'.$bt["uid"]."".':0'."'".',';
                if($bt["ctip"]!=-1)
                    set_vars("location='arena',x=-1,y=-3,ctip=-1",$bt["uid"]);
                set_vars("online=1,lasto=".tme(),$bt["uid"]);
            }
        }*/
    }  

	
	if($player->pers["sign"]=='watchers' or $player->pers["diler"]==1 or $player->pers["priveleged"])
	if($cat==4)
	{
		include("_testing_view.php");
	}
	
	echo "\nvar lb_attack = ".$lb_attack.";";	
	echo "\nvar apps=new Array(";
	echo substr($s,0,strlen($s)-1);
	echo ");\n";
	echo "show_apps_".$cat."();\n";
?>
