<?php

	#### Считаем ОД на удар
	$_W = Weared_Weapons($player->pers["uid"]);
	$OD_UDAR = $_W["OD"];
	
	$fight = $db->sqla("SELECT * FROM `fights` WHERE `id`='".$player->pers["cfight"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if (!$fight["id"]) set_vars("cfight=0,curstate=0,refr=1",$player->pers["uid"]);
	if ($fight["bplace"])$bplace = $db->sqla("SELECT * FROM battle_places WHERE id=".$fight["bplace"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ($fight['type']<>'f') include ("fights/ch_p_vs.php");
	$delta = floor(sqrt(sqr($player->pers["xf"]-$persvs["xf"])+sqr($player->pers["yf"]-$persvs["yf"]))); // Расстояние между игроками
	############@@@@@@@
	###### ПОВТОР
	if( $http->_get('repeat') and $player->pers["turn_before"] )
	{
		$arr = explode(";",$player->pers["turn_before"]);
		foreach($arr as $a)
		{
			if ($a<>'')
			{
				$z = explode("=",$a);
				if( $z[0]!="vs" ) $http->post[$z[0]]=$z[1];
			}
		}
		  $http->post["vs"] = @$persvs["uid"] + $persvs["id"]; 
	}
	####################
	########@@@@@@@@@@@@@@@@@@@@
	include ("fights/constants.php");
	include ("fights/od_counter.php");
	////////////////////////////// Тип боя:
	if ( ($http->_get('fstate')==1 or $player->pers["fstate"]== 0) and $player->pers["fstate"]<>1 and $player->pers["fstate"]=1) 
		set_vars("fstate=1",$player->pers["uid"]);
	if ( $http->_get('fstate')==2 and $player->pers["fstate"]<>2 and $player->pers["fstate"]=2) 
		set_vars("fstate=2",$player->pers["uid"]);
	if ( $http->_get('fstate')==3 and $player->pers["fstate"]<>3 and $player->pers["fstate"]=3) 
		set_vars("fstate=3",$player->pers["uid"]);
	if ( $http->_get('fstate')==4 and $player->pers["fstate"]<>4 and $player->pers["fstate"]=4) 
		set_vars("fstate=4",$player->pers["uid"]);
	
	if ($r != $OD_UDAR+3)
	{
		if (($player->pers["sb1"]+5)<$r or !$persvs["chp"]) 
		{
			unset($http->post);
		}
	}
	//////////////////////////////
	#####Лечимся за счёт маны
	if (@$http->get["up_health"] and 
		$player->pers["hp"]<>$player->pers["chp"] and 
		(($player->pers["hp"]-$player->pers["chp"])<=$player->pers["cma"]) and $player->pers["chp"] and $persvs)
	{
		set_vars("cma=cma-hp+chp,chp=hp",$player->pers["uid"]);
		if ($player->pers["invisible"]<=tme()) $nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]].">".$player->pers["user"]."</font>[".$player->pers["level"]."]";
		else $nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]]."><i>невидимка</i></font>[??]";
		add_flog($nvs." восстанавливает <font class=hp>".($player->pers["hp"] - $player->pers["chp"])." HP</font> за счёт маны.",$player->pers["cfight"]);
		$player->pers["cma"] = $player->pers["cma"] - $player->pers["hp"] + $player->pers["chp"];
		$player->pers["chp"] = $player->pers["hp"];
	}
	
	if (@$http->post["attack"] and @$http->post["defence"])
	{
		$player->pers["fight_request"] = intval($http->post["attack"]).":".intval($http->post["defence"]).":".intval($zid).":".intval($http->post["magic_koef"]);
		set_vars("fight_request='".$player->pers["fight_request"]."'");
	}
	
	if ( @$persvs["uid"] )
		$can = $db->sqla("SELECT * FROM turns_f WHERE uid2=".$player->pers["uid"]." and uid1=".$persvs["uid"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	// ^ Если противник человек , то загружаем его действия в данный ход против нас. $go - показывает, можно ходить (1) или нельзя если противник не сходил против нас(0).
	unset($go);
	if ( @!$persvs["uid"] or $can["idf"] ) $go = 1; else $go = 0;

	#############################################Задаём запрос для повтора
	if(@$http->post["vs"] and !$persvs["uid"])
	{
		foreach ($http->post as $key => $v)
			$str.=$key."=".$v.";";
		set_vars("turn_before='".$str."'",$player->pers["uid"]);
	}
	
	if ( @$_STUN ) 
	{
		$http->get["gotox"] = $player->pers["xf"];
		$http->get["gotoy"] = $player->pers["yf"];
	}
	// Хождение:: Если противник не сходил против нас, и мы перемещаемся по карте то добавляем наши действия в базу:
	if (@$http->get["gotox"] and $go == 0) 
		$db->sqla("INSERT INTO `turns_f` ( `idf` , `uid1` , `uid2` , `turn` ) VALUES (".$player->pers["cfight"].", ".$player->pers["uid"].", ".$persvs["uid"].", 'gotox=".intval($http->get["gotox"]).";gotoy=".intval($http->get["gotoy"]).";');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	########################################################################
	// Удар:: Если соперник не сходил против нас, то добавляем наше действие в базу против него::
	if (@$http->post["vs"] and $go==0)
	{
		$str='';
		foreach ($http->post as $key => $v)
			$str.=$key."=".$v.";";
		set_vars("turn_before='".$str."'",$player->pers["uid"]);
		$db->sqla("INSERT INTO `turns_f` ( `idf` , `uid1` , `uid2` , `turn` ) VALUES (".$player->pers["cfight"].", ".$player->pers["uid"].", ".$persvs["uid"].", '".$str."');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		unset($persvs);
	}
	elseif (@$http->post["vs"] and !$persvs["uid"])
	{
		set_vars("bg=".intval($http->post["bg"]).",bt=".intval($http->post["bt"]).",bj=".intval($http->post["bj"]).",bn=".intval($http->post["bn"])."",$player->pers["uid"]);
		$player->pers["bg"] = $http->post["bg"];
		$player->pers["bt"] = $http->post["bt"];
		$player->pers["bj"] = $http->post["bj"];
		$player->pers["bn"] = $http->post["bn"];
	}
	#########################################################################
	// Если противник сходил против нас, формируем массив значений его хода::
	if ($go==1 and @$persvs["uid"]) 
	{
		$req = array();
		$arr = explode(";",$can["turn"]);
		foreach($arr as $a)
		 if ($a<>'')
		  {
			$z = explode("=",$a);
			$req[$z[0]]=$z[1];
		  }
	}
	if($go == 0)
	{
		unset($http->get);
		unset($http->post);
	}
	
	#########################################################################
	// Узнаём делаем ли мы какое-либо действие, $action = 1 - значит действие совершается.
	if ( isset($http->post["vs"]) || isset($http->get["gotox"]) ) $action=1; else $action=0;
	##############
	// Блокирование ударов::

	#############

	#@##@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#
	if ($action) # Основной блок действий
	{
		#>> Переход собственный
		if (@$http->get["gotox"] and $go) 
		{
			$shagi=round(sqrt(sqr($player->pers["xf"]-$http->get["gotox"])+sqr($player->pers["yf"]-$http->get["gotoy"])));
			if ($shagi<=floor (1) and $http->get["gotox"]>0 and $http->get["gotox"]<$fight["maxx"] and $http->get["gotoy"]>=0 and $http->get["gotoy"]<$fight["maxy"] and !substr_count($bplace["xy"],"|".$http->get["gotox"]."_".$http->get["gotoy"]."|"))
			{
				$check_for_go = $db->sqla("SELECT uid FROM users WHERE cfight=".$player->pers["cfight"]." and xf=".intval($http->get["gotox"])." and yf=".intval($http->get["gotoy"])." and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				if (!$check_for_go[0])
				{
				$check_for_go = $db->sqla("SELECT id FROM bots_battle WHERE cfight=".$player->pers["cfight"]." and xf=".intval($http->get["gotox"])." and yf=".intval($http->get["gotoy"])." and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				if (!$check_for_go[0])
				{
					$player->pers["xf"] = intval($http->get["gotox"]);
					$player->pers["yf"] = intval($http->get["gotoy"]);
					set_vars("bg=0,bt=0,bj=0,bn=0,`xf`='".$player->pers["xf"]."' ,`yf`=".$player->pers["yf"]."",$player->pers["uid"]);
				}
				}
			}
		}
		
		#####<<<<< ###
		if (@$req["gotox"]) 
		{
			$shagi=round(sqrt(sqr($persvs["xf"]-$req["gotox"])+sqr($persvs["yf"]-$req["gotoy"])));
			if ($shagi<=floor (1) and $req["gotox"]>0 and $req["gotox"]<$fight["maxx"] and $req["gotoy"]>=0 and $req["gotoy"]<$fight["maxy"] and !substr_count($bplace["xy"],"|".$req["gotox"]."_".$req["gotoy"]."|"))
			{
				$check_for_go = $db->sqla("SELECT uid FROM users WHERE cfight=".$player->pers["cfight"]." and xf=".intval($req["gotox"])." and yf=".intval($req["gotoy"])."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				if (!$check_for_go[0])
				{
				$check_for_go = $db->sqla("SELECT id FROM bots_battle WHERE cfight=".$player->pers["cfight"]." and xf=".intval($req["gotox"])." and yf=".intval($req["gotoy"])."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				if (!$check_for_go[0])
				{
					$persvs["xf"] = intval($req["gotox"]);
					$persvs["yf"] = intval($req["gotoy"]);
					set_vars("bg=0,bt=0,bj=0,bn=0,`xf`='".$persvs["xf"]."' ,`yf`=".$persvs["yf"]."",$persvs["uid"]);
				}
				}
			}
		}
		
		###>> Включаем бота, если надо::
		$text='';
		$die = '';
		if ($fight["bplace"]==0) 
		{
			$player->pers["xf"] = $persvs["xf"];
			$player->pers["yf"] = $persvs["yf"];
		}
		if (!$persvs["uid"] and $persvs["chp"]) include("bots/bot_brain.php");
		########################################################
		############ - Тесный контакт людей - ############################
		$Checker = 0;
		if ($req["vs"] and $persvs["uid"] and $r and $persvs["chp"] and $player->pers["chp"]) $Checker = 1;
		if (!$persvs["uid"] and $persvs["chp"]) $Checker = 1;

		if ($Checker and $persvs["uid"])
		{
			$radius = $db->sqlr("SELECT MAX(radius) FROM wp WHERE uidp=".$persvs["uid"]." and weared=1 and type='orujie'",0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ($radius<1) $radius=1;
			if ($radius>=($delta) or $req["magic"] or !$fight["bplace"] or $req["aura_id"])
			{
				if (!$fight["bplace"]) $delta=1;
				##
				if ($persvs["invisible"]<=tme())
					$nvs = "<font class=bnick color=".$colors[$persvs["fteam"]].">".$persvs["user"]."</font>[".$persvs["level"]."]";
				else 
					$nvs = "<font class=bnick color=".$colors[$persvs["fteam"]]."><i>невидимка</i></font>[??]";
				##
				$persvs["damage_give"]=0;
				set_vars("damage_get=chp",$persvs["uid"]);
				set_vars("bg=".intval($http->post["bg"]).",bt=".intval($http->post["bt"]).",bj=".intval($http->post["bj"]).",bn=".intval($http->post["bn"])."",$player->pers["uid"]);
				$player->pers["bg"] = $http->post["bg"];
				$player->pers["bt"] = $http->post["bt"];
				$player->pers["bj"] = $http->post["bj"];
				$player->pers["bn"] = $http->post["bn"];
				$text .= human_udar ("ug",$persvs,$player->pers,$req,1,$delta);
				$text .= human_udar ("ut",$persvs,$player->pers,$req,1,$delta);
				$text .= human_udar ("uj",$persvs,$player->pers,$req,1,$delta);
				$text .= human_udar ("un",$persvs,$player->pers,$req,1,$delta);
				$text = substr($text,0,strlen($text)-1).'%';
				if (@$req["aura_id"])
				{
					$aid = intval($req["aura_id"]);
					$player->pers = $persvs;
					include ("battle_aura.php");
					$player->pers = catch_user(UID);
				}
				if ($text<>'') $text = $text."%";
			}
		}
	//	$_SESSION['bad'] = 2;
		## Наш удар::
		if ($Checker)
		{
			$radius = $db->sqlr("SELECT MAX(radius) FROM wp WHERE `uidp`=".$player->pers["uid"]." and `weared`=1 and type='orujie'",0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ($radius<1)$radius=1;
			if ($radius>=($delta) or $http->post["magic"] or !$fight["bplace"] or $http->post["aura_id"])
			{
				if (!$fight["bplace"]) $delta=1;
				##
				if ($player->pers["invisible"]<=tme())
				$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]].">".$player->pers["user"]."</font>[".$player->pers["level"]."]";
				else 
				$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]]."><i>невидимка</i></font>[??]";
				##
				$player->pers["damage_give"]=0;
				$player->pers["damage_get"]=$player->pers["chp"];
				set_vars("bg=".intval($req["bg"]).",bt=".intval($req["bt"]).",bj=".intval($req["bj"]).",bn=".intval($req["bn"])."",$persvs["uid"]);
				$persvs["bg"] = $req["bg"];
				$persvs["bt"] = $req["bt"];
				$persvs["bj"] = $req["bj"];
				$persvs["bn"] = $req["bn"];
				$text .= human_udar ("ug",$player->pers,$persvs,$http->post,0,$delta);
				$text .= human_udar ("ut",$player->pers,$persvs,$http->post,0,$delta);
				$text .= human_udar ("uj",$player->pers,$persvs,$http->post,0,$delta);
				$text .= human_udar ("un",$player->pers,$persvs,$http->post,0,$delta);
				$text = substr($text,0,strlen($text)-1).'%';
				set_vars("damage_get=".$player->pers["damage_get"]."",$player->pers["uid"]);
				if (@$http->post["aura_id"])
				{
					$aid = intval($http->post["aura_id"]);
					include ("battle_aura.php");
					$player->pers = catch_user(UID);
				}
			}
		}
		if ($die.$text)
		{
			add_flog($die.$text,$player->pers["cfight"]); 
			echo "<script>top.ch_refresh();</script>";
		}
		#############@@@@@@@@@@@@@@@@@@######################
		##############################################################
	}
#@##@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#@#

		
// Действие выполнено с человеком:
if ( @$can["idf"] and $action ) $db->sql("DELETE FROM turns_f WHERE uid1=".$can["uid1"]." and uid2=".$can["uid2"]."");
if ($action and $can["idf"]) $db->sqla("UPDATE users SET bg=0,bn=0,bj=0 WHERE uid=".intval($player->pers["uid"])." or uid=".intval($persvs["uid"])."");
//Итоговые преобразования:
if ($action) 
{
	$db->sql("UPDATE `users` SET  f_turn='".(++$player->pers["f_turn"])."'   WHERE `uid`='".$player->pers["uid"]."';");
	$fight["ltime"] = tme();
	$db->sql("UPDATE `fights` SET ltime=".$fight["ltime"]." WHERE `id`=".$player->pers["cfight"]."");
	if ($persvs["uid"]) $db->sql("UPDATE `users` SET `refr`=1 WHERE `uid`='".$persvs["uid"]."';");
}

if ($fight['type']<>'f' and $persvs["chp"]<1)include ("fights/ch_p_vs.php");
?>