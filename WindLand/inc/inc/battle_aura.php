<?php

if ($player->pers["user"] == 'lastdays')
{
	if ($player->pers["invisible"]>tme()){$player->pers["user"] = '<i>невидимка</i>';$invyou=1;$player->pers["pol"]='female';} else $invyou=0;
	if (!$invyou)
		$nyou = "<font class=bnick color=".$colors[$player->pers["fteam"]].">".$player->pers["user"]."</font>[".$player->pers["level"]."]";
	else
		$nyou = "<font class=bnick color=".$colors[$player->pers["fteam"]]."><i>невидимка</i></font>[??]";

	$a = $db->sqla("SELECT * FROM u_auras WHERE uidp=".$player->pers["uid"]." and id=".intval($aid)."");
	if ($a and
		$a["manacost"]<=$player->pers["cma"] and
		$a["tlevel"]<=$player->pers["level"]	and
		$a["ts6"]<=$player->pers["s6"] and
		$a["tm1"]<=$player->pers["m1"] and
		$a["tm2"]<=$player->pers["m2"] and
		$a["cur_colldown"]<=tme() and
		$a["cur_turn_colldown"]<=$player->pers["f_turn"])
	{
		if ($a["forenemy"])
		 $ps = sql("SELECT * FROM users WHERE cfight=".$player->pers["cfight"]." and fteam<>".$player->pers["fteam"]." and chp>0");
		else
		 $ps = sql("SELECT * FROM users WHERE cfight=".$player->pers["cfight"]." and fteam=".$player->pers["fteam"]." and chp>0");

		$text2 = '';
		$p1 = false;
		while (true)
		{
			if (!$p1) $p1 = mysql_fetch_array($ps);
			else $p1 = $p2;
			$p2 = mysql_fetch_array($ps);
			if ($p1) $textFill = 1;

			if ($p1["invisible"]<=tme())
				$nvs = "<font class=bnick color=".$colors[$p1["fteam"]].">".$p1["user"]."</font>[".$p1["level"]."]";
			else
				$nvs = "<font class=bnick color=".$colors[$p1["fteam"]]."><i>невидимка</i></font>[??]";

			if ($p2)
			{
				aura_on($a["id"],$pers,$p1,0);
				$text2 .= $nvs.",";
			}
			else
			{
				aura_on($a["id"],$pers,$p1);
				$text2 .= $nvs.".";
				break;
			}
		}
	}

	if ($textFill)
	$text .= $nyou." накладывает заклинание «<img src='images/magic/".$a["image"].".gif' height=12><font class=user>".$a["name"]."</font>» на ".$text2;

 }


?>