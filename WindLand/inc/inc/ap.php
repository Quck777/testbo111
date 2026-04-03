<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

$zeroyed=0;
if ( isset($http->get['fz']) and $player->pers['level']>=5 ) $http->get['fz'] = false;
if ( $player->pers["action"]==-10 ) $http->get["gopers"]="obnyl";
if ( $player->pers["action"]==-11 ) $http->get["fz"]="obnyl";
if ( $http->_get('fz') or $http->_get('gopers')=='obnyl' )
{
	include (ROOT.'/inc/inc/obnyl.php');
	$http->get['gopers'] = false;
}

//завершаем бой
if ( (@$http->get["eff"]==1 or $player->pers["gain_time"]>(tme()-1200)) and $player->pers["curstate"]==4 )
	$player->pers = end_battle($player->pers);


## Получение уровня для клана ( News module) 			// это пиздец.. (с) Джо
if ( $player->is_clan_check() )
{
	$my_clan = $player->getClan();   ## freestats
	$clevel = $db->sqla('SELECT `level`,`exp`,`stats` FROM  `exp_clan` WHERE `level`='.($my_clan['level']+1));
	$ci = 0;
	$cfree_stats = 0;
	$clevels = 0;
	while ($my_clan["exp"]>=$clevel["exp"] and $clevel["exp"]>0)
	{
		$cfree_stats +=$clevel["stats"];
		$clevels++;
		$clevel = $db->sqla('SELECT `level`,`exp`,`stats` FROM `exp_clan` WHERE `level`='.($clevel['level']+1));
		$ci++;
	}
	if ($ci>0)
	{
		$my_clan["level"]+=$clevels;
		$my_clan["freestats"]+=$cfree_stats;
		$db->sql("UPDATE `clans` SET level=level+".$clevels.",freestats=freestats+".$cfree_stats." WHERE `id`='".$my_clan["id"]."'");
		say_to_chat("s","Клан <b>".$my_clan["name"]."</b> достиг ".$my_clan["level"]." уровня!",0,'','*',0);

	}

}
## end check my pers and my clan


//Получение уровня
$level = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($player->pers["level"]+1));
$i = 0;
$free_stats = 0;
$free_f_skills = 0;
$free_p_skills = 0;
$free_m_skills = 0;
$levels = 0;
$money = 0;
$coins = 0;
while ( ($player->pers["exp"]+$player->pers["peace_exp"])>=$level["exp"] and $level["exp"]>0 )
{
	$free_stats +=$level["stats"];
	$free_f_skills+=$level["free_f_skills"];
	$free_p_skills+=$level["free_p_skills"];
	$free_m_skills+=$level["free_m_skills"];
	$levels++;
	if (!$zeroyed) $money+=$level["money"];
	if (!$zeroyed) $coins+=$player->pers["level"]*2;
	$level = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($level["level"]+1));
	$i++;
}

if ($i>0)
{
	$player->pers["level"]+=$levels;
	$player->pers["free_stats"]+=$free_stats;
	$player->pers["free_f_skills"]+=$free_f_skills;
	$player->pers["free_p_skills"]+=$free_p_skills;
	$player->pers["free_m_skills"]+=$free_m_skills;
	$player->pers["money"]+=$money;
	$player->pers["coins"]+=$coins;
	$db->sql ("UPDATE `users` SET level=level+".$levels.", free_stats=free_stats+".$free_stats.",free_f_skills=free_f_skills + ".$free_f_skills.", free_m_skills=free_m_skills+".$free_m_skills.",money=money+".$money.",coins=coins+".$coins." WHERE `uid`='".$player->pers["uid"]."'");
}


if (!$zeroyed and $i>0)
{
	if ($player->pers["invisible"]<tme())
		say_to_chat ("a","Персонаж <font class=user onclick=\"top.say_private(\'".$player->pers["user"]."\')\">".$player->pers["user"]."</font> достиг ".$player->pers["level"]." уровня! //035",0,'','*',0);
	else
		say_to_chat ("a","Персонаж <i class=user>Невидимка</i> достиг ?? уровня! //035",0,'','*',0);
	if($player->pers["instructor"])
	{
		$pupil = $db->sqla("SELECT `user` FROM users WHERE uid = ".$player->pers["instructor"]);
		say_to_chat ('^',"Ваш ученик <b>".$player->pers["user"]."</b>[".$player->pers["level"]."] достиг ".$player->pers["level"]." уровня!",1,$pupil["user"],'*',0);
	}
	if($player->pers['level']==10)
	{
		set_vars("`zeroing`=zeroing+1",UID);
		$player->pers['zeroing']+= 1;
	}
	if ($player->pers["level"]==3 and $player->pers["referal_nick"])
	{
		$db->sql("UPDATE users SET referal_rcounter=referal_rcounter+1 WHERE uid=".$player->pers["referal_uid"]);
	}
	if($player->pers["level"]>=5 and $player->pers["instructor"])
	{
		$pupil = $db->sqla("SELECT * FROM users WHERE uid = ".$player->pers["instructor"]);
		say_to_chat ('^',"Вы закончили обучение <b>".$player->pers["user"]."</b>[".$player->pers["level"]."] и получаете 200 LN и 10 пергаментов, поздравляем!",1,$pupil["user"],'*',0);
		set_vars("money=money+200,coins=coins+10,good_pupils_count=good_pupils_count+1",$pupil["uid"]);
		if(($pupil["good_pupils_count"]+1)%5==0)
			set_vars("money=money+100",$pupil["uid"]);
		say_to_chat ('^',"Вы закончили обучение, поздравляем!",1,$player->pers["user"],'*',0);
		$db->sql("UPDATE `users` SET `instructor`=0 WHERE `uid` = ".$player->pers["uid"]);
	}
	if ($player->pers["level"]%5==0 and $player->pers["level"]<>0 and $player->pers["referal_nick"])
	{
		$db->sql("UPDATE users SET money=money+50 WHERE uid=".$player->pers["referal_uid"]."");
		say_to_chat ("s","Вы привели в игру персонажа <font class=user onclick=\"top.say_private(\'".$player->pers["user"]."\')\">".$player->pers["user"]."</font> и он достиг ".$player->pers["level"]." уровня! Вам на счёт зачислено 50 LN",1,$player->pers["referal_nick"],'*',0);
	}
	if ($player->pers["level"]==15 and $player->pers["referal_nick"])
	{
		$db->sql("UPDATE users SET money=money+200 WHERE uid=".$player->pers["referal_uid"]."");
		say_to_chat ("s","Вы привели в игру персонажа <font class=user onclick=\"top.say_private(\'".$player->pers["user"]."\')\">".$player->pers["user"]."</font> и он достиг 15 уровня! Вам на счёт зачислено 200 LN.",1,$player->pers["referal_nick"],'*',0);
	}
}


//Получение Звания // выключаем
if(@$http->get["eff"]==1 and false)
{
	$zvan = $db->sqla("SELECT * FROM `zvanya` WHERE `id`='".($player->pers["zvan"]+1)."' ");
	if ($zvan["cena"]<=($player->pers["victories"]-$player->pers["losses"]) and $zvan["cena"]<>0)
	{
		$player->pers["zvan"]=$zvan["id"];
		$db->sql("UPDATE `users` SET `zvan`=".$player->pers["zvan"]." WHERE `uid`=".$player->pers["uid"]." ;");
		say_to_chat ("s","Вы получили новое звание: <b>".$zvan["name"]."</b>, поздравляем!",1,$player->pers["user"],'*',0);
	}
}




if ( $player->pers["curstate"]<>4 and $player->pers["cfight"]<5 )
{
	if ($player->pers["level"]<6) {$player->pers["sm6"]+=60;$player->pers["sm7"]+=60;}
	$db->sql("UPDATE `users` SET ".hp_ma_up($player->pers["chp"],$player->pers["hp"],$player->pers["cma"],$player->pers["ma"],$player->pers["sm6"],$player->pers["sm7"],$player->lastom_old,$player->pers["tire"])." WHERE `uid` =".$player->pers["uid"].";");
	if ($player->pers["level"]<6) {$player->pers["sm6"]-=60;$player->pers["sm7"]-=60;}
	$player->pers["chp"] = floor($hp);
	$player->pers["сma"] = floor($ma);
}
### Очень важно
//	update_user(UID); // C фига ли важно?) вообще бредовая функция
$player->ReUserKey();


$p = @$http->post;
if ( @$p["hjkl"] )
{
	$summ = $p["nbs"] + $p["nss"];
	for ($i=1;$i<15;$i++)$summ += $p["bs".$i];
	for ($i=1;$i<8;$i++)$summ += $p["ss".$i];
	$summ2 = $player->pers["free_f_skills"] + $player->pers["free_m_skills"];
	for ($i=1;$i<15;$i++)$summ2 += $player->pers["sb".$i];
	for ($i=1;$i<8;$i++)$summ2 += $player->pers["sm".$i];

	if ($summ == $summ2 and $p["nbs"]>=0 and $p["nss"]>=0)
	{
		$player->pers["hp"]+=($p["ss1"]-$player->pers["sm1"])*4;
		$player->pers["ma"]+=($p["ss2"]-$player->pers["sm2"])*3;
		$player->pers["sb1"] = $p["bs1"];
		$player->pers["sb2"] = $p["bs2"];
		$player->pers["sb3"] = $p["bs3"];
		$player->pers["sb4"] = $p["bs4"];
		$player->pers["sb5"] = $p["bs5"];
		$player->pers["sb6"] = $p["bs6"];
		$player->pers["sb7"] = $p["bs7"];
		$player->pers["sb8"] = $p["bs8"];
		$player->pers["sb9"] = $p["bs9"];
		$player->pers["sb10"] = $p["bs10"];
		$player->pers["sb11"] = $p["bs11"];
		$player->pers["sb12"] = $p["bs12"];
		$player->pers["sb13"] = $p["bs13"];
		$player->pers["sb14"] = $p["bs14"];
		$player->pers["sm1"] = $p["ss1"];
		$player->pers["sm2"] = $p["ss2"];
		$player->pers["sm3"] = $p["ss3"];
		$player->pers["sm4"] = $p["ss4"];
		$player->pers["sm5"] = $p["ss5"];
		$player->pers["sm6"] = $p["ss6"];
		$player->pers["sm7"] = $p["ss7"];
		$player->pers["free_f_skills"] = $p["nbs"];
		@$player->pers["free_p_skills"] = $p["nms"];
		$player->pers["free_m_skills"] = $p["nss"];
		if(($player->pers["free_f_skills"]+$player->pers["free_p_skills"]+$player->pers["free_m_skills"])==0)
		{
			$player->pers["chp"] = $player->pers["hp"];
			$player->pers["cma"] = $player->pers["ma"];
			echo "<script>location = '/main.php';</script>";
			$db->sql("UPDATE p_auras SET esttime=0 WHERE uid=".$player->pers["uid"]." and special>2 and special<6 and esttime>".tme().";");
			say_to_chat('s',"<i><b>Вы полностью исцелены!</b></i>",1,$player->pers["user"],'*',0);
		}
		set_vars(aq($player->pers),$player->pers["uid"]);
	}
}

?>