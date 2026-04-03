<?
//Сдаём вещь в лавку
###############
if (isset($http->get["lavkasdat"]) and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"lavka"))
{
	$v = $db->sqla("SELECT * FROM wp
	WHERE weared=0 and id=".intval($http->get["lavkasdat"])." and uidp=".$player->pers["uid"]." and where_buy<>1");

	if (@$v["id"] and ($v["clan_name"]=="" or $player->pers["clan_state"]=='g'))
	{
	$koef_cur = 1;
	if ($v["present"]) $koef_cur = 0.5;
	$koef=1;
	if ($player->pers["level"]>4) $koef =0.8;
	if ($koef<1) $koef += $player->pers["sp9"]/1000;
	if ($koef>0.99) $koef=0.99;
	if ($_ECONOMIST) $koef=0.99;

	$player->pers["money"]+= $koef*$koef_cur*$v["price"]*($v["durability"]+1)/($v["max_durability"]+1);
	$db->sql("UPDATE `weapons` SET `q_s`=q_s+1 WHERE `id`='".$v["id_in_w"]."'");
	$db->sql("DELETE FROM wp WHERE id=".$v["id"]." and uidp=".$player->pers["uid"]."");
	set_vars("`money`='".$player->pers["money"]."', sp9=sp9+1/(sp9+1),`weight_of_w`=weight_of_w-".($v["weight"]),$player->pers["uid"]);
	$player->pers["weight_of_w"]-=$v["weight"];
	$_RETURN .= "Вещь удачно сдана в лавку. (Комиссия <b>".round($v["price"]-$koef*$koef_cur*$v["price"]*($v["durability"]+1)/($v["max_durability"]+1),2)."</b> LN)";
	}
	unset($v);
}
###############
//Сдаём вещь в банк
###############
if (isset($http->get["bank"]) and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"bank") and $player->pers["money"]>=round(($v["price"]*0.1),2))
{
	$v = $db->sqla("SELECT id_in_w,price,durability,max_durability,weight,id FROM wp
	WHERE weared=0 and id=".intval($http->get["bank"])." and uidp=".$player->pers["uid"]." and where_buy<>1 and in_bank=0");

	if (@$v["id"])
	{
	$player->pers["money"]-= round($v["price"]*0.1,2);
	$db->sql("UPDATE wp SET in_bank=1 WHERE id=".$v["id"]." and uidp=".$player->pers["uid"]."");
	set_vars("`money`='".$player->pers["money"]."',`weight_of_w`=weight_of_w-".($v["weight"]),$player->pers["uid"]);
	$player->pers["weight_of_w"]-=$v["weight"];
	$_RETURN .= "Вещь удачно сдана в банк на хранение. (Комиссия <b>".round($v["price"]*0.1,2)."</b> LN)";
	}
	unset($v);
}


#######################
if (isset($http->get["getbank"]) and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"bank"))
{
	$v = $db->sqla("SELECT id_in_w,price,durability,max_durability,weight,id FROM wp
	WHERE weared=0 and id=".intval($http->get["getbank"])." and uidp=".$player->pers["uid"]." and where_buy<>1 and in_bank=1");

	if (@$v["id"])
	{
	$db->sql("UPDATE wp SET in_bank=0 WHERE id=".$v["id"]."");
	set_vars("`weight_of_w`=weight_of_w+".($v["weight"]),$player->pers["uid"]);
	$player->pers["weight_of_w"]+=$v["weight"];
	}
	unset($v);
}
###############
//Сдаём  всю рыбу
###############
if (@$http->get["give"]=='allfish' and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"lavka"))
{
	$koef=1;
	if ($player->pers["level"]>4) $koef =0.8;
	if ($koef<1) $koef+=$player->pers["sp9"]/1000;
	if ($koef>0.99) $koef=0.99;
	if ($_ECONOMIST) $koef=0.99;
	$price = $db->sqlr("SELECT SUM(price) FROM wp
	WHERE uidp=".$player->pers["uid"]." and type='fish' and weared=0",0);
	if($price)
	{
		$player->pers["money"]+= $koef*$price;
		$db->sql("DELETE FROM wp WHERE uidp=".$player->pers["uid"]." and type='fish' and weared=0");
		set_vars("sp9=sp9+1/(sp9+1),money=money+".($koef*$price),$player->pers["uid"]);
		$_RETURN .= "Вся рыба удачно сдана в лавку. (Выручка <b>".round($koef*$price,2)."</b> LN)";
	}
}
###############
//Сдаём  приманки
###############
if (@$http->get["give"]=='allfishing' and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"lavka"))
{
	$koef=1;
	if ($player->pers["level"]>4) $koef =0.8;
	if ($koef<1) $koef+=$player->pers["sp9"]/1000;
	if ($koef>0.99) $koef=0.99;
	if ($_ECONOMIST) $koef=0.99;
	$price = $db->sqlr("SELECT SUM(price) FROM wp
	WHERE uidp=".$player->pers["uid"]." and type='fishing' and weared=0",0);
	if($price)
	{
		$player->pers["money"]+= $koef*$price;
		$db->sql("DELETE FROM wp WHERE uidp=".$player->pers["uid"]." and type='fishing' and weared=0");
		set_vars("sp9=sp9+1/(sp9+1),money=money+".($koef*$price),$player->pers["uid"]);
		$_RETURN .= "Все приманки удачно сданы в лавку. (Выручка <b>".round($koef*$price,2)."</b> LN)";
	}
}

###############
###############
//Сдаём  все деревья
###############
if (@$http->get["give"]=='alltrees' and $player->pers["punishment"]<$time and strpos(" ".$player->pers["location"],"lavka"))
{
	$koef=1;
	if ($player->pers["level"]>4) $koef =0.8;
	if ($koef<1) $koef+=$player->pers["sp9"]/1000;
	if ($koef>0.99) $koef=0.99;
	if ($_ECONOMIST) $koef=0.99;
	$price = $db->sqlr("SELECT SUM(price) FROM wp
	WHERE uidp=".$player->pers["uid"]." and id_in_w='res..tree' and weared=0",0);
	$player->pers["money"]+= $koef*$price;
	$db->sql("DELETE FROM wp WHERE uidp=".$player->pers["uid"]." and type='fish' and weared=0");
	set_vars("sp9=sp9+1/(sp9+1),money=".$player->pers["money"],$player->pers["uid"]);
	$_RETURN .= "Все деревья удачно сданы в лавку. (Выручка <b>".round($koef*$price,2)."</b> LN)";
}
###############

// Сдаём в ДД
######################
if (@$http->get["dhousesdat"]) {
$v = $db->sqla("SELECT durability,max_durability,weight,dprice,id FROM wp
WHERE uidp=".$player->pers["uid"]." and id=".intval($http->get["dhousesdat"])." and weared=0 and timeout=0");
if ($v["dprice"]>5)
{
$db->sql("DELETE FROM wp WHERE id=".$v["id"]."");
$player->pers["dmoney"] += ($v["dprice"]*DD_STND_KOEF)*(($v["durability"]+1)/($v["max_durability"]+1));
$player->pers["weight_of_w"]-=$v["weight"];
set_vars ("`dmoney`='".$player->pers["dmoney"]."',weight_of_w=weight_of_w-".($v["weight"]),$player->pers["uid"]);
$_RETURN .= "Вещь удачно сдана в Дом Дилеров. (Комиссия <b>".round($v["dprice"]-($v["dprice"]*DD_STND_KOEF)*(($v["durability"]+1)/($v["max_durability"]+1)),2)."</b> y.e.)";
}
else
$_RETURN .= "Нельзя сдать эту вещь.";
unset($v);
}
######################

//Сдаём вещь в ДД (Клановая)
if (@$http->get["dchousesdat"] and ($status=='a' or $status=='wg')) {
$v = $db->sqla("SELECT durability,max_durability,weight,dprice,id FROM wp
WHERE uidp=".$player->pers["uid"]." and id=".intval($http->get["dchousesdat"])." and weared=0 and timeout=0 and clan_sign='".$player->pers["sign"]."'");
if (@$v["dprice"])
{
$db->sql("DELETE FROM wp WHERE id=".$v["id"]."");
$db->sql("UPDATE `clans` SET `dmoney`=dmoney+".floor(($v["dprice"]*DD_CLAN_KOEF)*(($v["durability"]+1)/($v["max_durability"]+1)))." WHERE `sign`='".$player->pers["sign"]."'");
set_vars ("weight_of_w=weight_of_w-".($v["weight"]),$player->pers["uid"]);
$player->pers["weight_of_w"]-=$v["weight"];
$_RETURN .= "Вещь удачно сдана в Дом Дилеров. (Комиссия <b>".round($v["dprice"]-($v["dprice"]*DD_CLAN_KOEF)*(($v["durability"]+1)/($v["max_durability"]+1)),2)."</b> y.e.)";
}
unset($v);
}
######################


//Сдаём вещь в клан-казну
#########################
if (@$http->get["to_clan"] and $player->pers["clan_tr"] and $player->pers["punishment"]<$time)
{
	$v = $db->sqla("SELECT id,name,price,dprice FROM wp WHERE id=".intval($http->get["to_clan"])." and uidp=".$player->pers["uid"]." and weared=0 and where_buy=0 and clan_name=''");
	if(@$v["id"])
	{
		$clan = $db->sqla ("SELECT * FROM `clans` WHERE `sign`='".$player->pers['sign']."'");
		if ($clan["treasury"]<($clan["maxtreasury"]+30))
		{
			$db->sql("UPDATE wp SET clan_sign='".$player->pers["sign"]."' , clan_name='".$clan["name"]."', present='".$player->pers["user"]."' WHERE id=".$v["id"]." and uidp=".$player->pers["uid"]);
			$db->sql("UPDATE clans SET treasury=treasury+1 WHERE sign='".$player->pers["sign"]."'");
		}

	transfer_log(2,$player->pers["uid"],'',0,0,$v["name"]."[".$v["price"]."LN,".$v["dprice"]."y.e.] в клан казну",show_ip(),'');
	$_RETURN .= "Вещь удачно сдана в клан казну.";
	}
unset($v);
}
#########################



// Продажа вещи
########################
if (@$http->get["sell"]=='yes' and $player->pers["punishment"]<$time)
{
	$t=tme ()-1;
	$sale = $db->sqla ("SELECT * FROM `salings` WHERE `id`=".intval($http->get["hash"])."");
	$persto = $db->sqla("SELECT uid,money,user,lastip FROM `users` WHERE `uid`=".intval($sale["uidp"])."");
	$v = $db->sqla("SELECT price,name,weight,`id` FROM `wp` WHERE `id`='".$sale["idw"]."' and uidp=".$sale["uidp"]." and weared=0");
	if ($v["id"])
	{
		if ($player->pers["money"]>$sale["price"])
		{
			$player->pers["money"]-=$sale["price"];
			$persto["money"]+=$sale["price"];
			set_vars("sp9=sp9+1/(sp9+3),money=".$player->pers["money"].",weight_of_w=weight_of_w+".($v["weight"]),$player->pers["uid"]);
			set_vars("sp9=sp9+1/(sp9+3),money=".$persto["money"].",`refr`=1,weight_of_w=weight_of_w-".($v["weight"]),$persto["uid"]);
			$db->sql("UPDATE wp SET uidp=".$player->pers["uid"]." WHERE id=".$sale["idw"]."");
			say_to_chat ('s',"Сделка удачно завершена",1,$persto["user"],'*',0);
			transfer_log(1,$persto["uid"],$player->pers["user"],$sale["price"],$v["price"],$v["name"],$persto["lastip"],$player->pers["lastip"]);
			transfer_log(4,$player->pers["uid"],$persto["user"],$v["price"],$sale["price"],$v["name"],$player->pers["lastip"],$persto["lastip"]);
			$_RETURN .= "Вещь удачно куплена.(Ушло <b>".$sale["price"]."</b> LN)";
		}
		else
		{
			say_to_chat ('s',"У персонажа нет таких денег",1,$persto["user"],'*',0);
			$_RETURN .= "Вещь не куплена. Недостаточно денег. Требуется <b>".$sale["price"]."</b> LN.";
		}
	}
	unset($v);
}
############################


// Подача заявки на продажу
#####################
if (isset($http->post["fornickname"]) and intval(@$http->post["forprice"])>0 and $http->post["fornickname"]<>$player->pers["user"] and $player->pers["punishment"]<$time)
{

	$v = $db->sqla("SELECT name,id,where_buy FROM wp WHERE uidp=".$player->pers["uid"]." and weared=0 and id=".intval($http->post["id"])." and where_buy=0");

	if (@$v["id"])
	{
		$persto = $db->sqla ("SELECT uid,location,x,y FROM `users` WHERE `smuser` = LOWER('".$http->post["fornickname"]."')");
		if ($player->pers["location"]==$persto["location"])
		{
			$db->sql("INSERT INTO `salings` (`id`,`idw`,`uidp`,`price`, `uidwho`) VALUES (0,'".$v["id"]."','".$player->pers["uid"]."','".$http->post["forprice"]."',".$persto["uid"].") ");
			$idf =  $db->insert_id();
			$m = "saling#".$idf;
			say_to_chat ('s',$m,1,$http->post["fornickname"],'*',0);
			$_RETURN .= "Ожидаем подтверждения.";
		}
		else $_RETURN .= "Нет такого персонажа в данном месте";
	}
	unset($v);
}
elseif (@$http->post["fornickname"]==$player->pers["user"] and intval(@$http->post["forprice"])>0)$_RETURN .= "Нельзя ничего продавать себе.";
#######################


// Передача вещи
#######################
if (intval(@$http->post["forprice"])==0 and @isset($http->post["fornickname"]) and empty($http->post["money"]) and $http->post["fornickname"]<>$player->pers['user'] and isset($http->get["ids"]) and $player->pers["punishment"]<$time)
{
	$ids = explode("!",$http->get["ids"]);
	$persto = $db->sqla ("SELECT uid,money,user,lastip,location,x,y FROM `users` WHERE `smuser` = LOWER('".$http->post["fornickname"]."')");
	foreach($ids as $id)
	{
	if(!$id) continue;
	$v = $db->sqla("SELECT weight,price,name,id FROM `wp` WHERE uidp=".$player->pers["uid"]." and weared=0 and id=".intval($id)." and where_buy=0");

if ($player->pers["location"]==$persto["location"] and $v)
{
	$db->sql("UPDATE wp SET uidp=".$persto["uid"]." WHERE id=".$id."");
	set_vars ("weight_of_w=weight_of_w-".($v["weight"]),$player->pers["uid"]);
	$player->pers["weight_of_w"]-=$v["weight"];
	$m = $player->pers["user"]."|".$v["name"]."|"." "."|".$v["id"]."|";
	say_to_chat('s',$m,1,$http->post["fornickname"],'*',0);
	transfer_log(5,$persto["uid"],$player->pers["user"],$v["price"],0,$v["name"],$persto["lastip"],$player->pers["lastip"]);
	transfer_log(2,$player->pers["uid"],$persto["user"],0,$v["price"],$v["name"],$player->pers["lastip"],$persto["lastip"]);
	$_RETURN .= "Вещь передана[".$v["name"]."]<br>";
}
	elseif($v)
	{
		$_RETURN .= "Нет такого персонажа в данном месте";
		break;
	}
	else
		break;

	unset($v);
	}
}elseif (@$http->post["fornickname"]==$player->pers["user"] and isset($http->post["id"]))$_RETURN .= "Нельзя ничего передавать себе.";
#########################

// Передача всех трав
#######################
if (@$http->get["giveallH"] and isset($http->post["fornickname"]) and $http->post["fornickname"]<>$player->pers['user'] and $player->pers["punishment"]<$time)
{
	$persto = $db->sqla ("SELECT uid,money,user,lastip,location,x,y FROM `users` WHERE `smuser` = LOWER('".$http->post["fornickname"]."')");
	$herbals = $db->sql("SELECT weight,price,name,id FROM `wp` WHERE uidp=".$player->pers["uid"]." and weared=0 and type='herbal'");
	if ($player->pers["location"]==$persto["location"])
	{
	while($v = $db->fetchArray($herbals,MYSQL_ASSOC))
	{
		$db->sql("UPDATE wp SET uidp=".$persto["uid"]." WHERE id=".$v["id"]."");
		set_vars ("weight_of_w=weight_of_w-".($v["weight"]),$player->pers["uid"]);
		$player->pers["weight_of_w"]-=$v["weight"];
		$m = $player->pers["user"]."|".$v["name"]."|"." "."|".$v["id"]."|";
		say_to_chat('s',$m,1,$http->post["fornickname"],'*',0);
		transfer_log(5,$persto["uid"],$player->pers["user"],$v["price"],0,$v["name"],$persto["lastip"],$player->pers["lastip"]);
		transfer_log(2,$player->pers["uid"],$persto["user"],0,$v["price"],$v["name"],$player->pers["lastip"],$persto["lastip"]);
		$_RETURN .= "Вещь передана[".$v["name"]."]<br>";
	}
	}
	else
		$_RETURN .= "Нет такого персонажа в данном месте";
}
elseif (@$http->post["fornickname"]==$player->pers["user"] and isset($http->post["id"]))$_RETURN .= "Нельзя ничего передавать себе.";
#########################

//Выкидывание предмета
##########################
/*
if (isset($http->get["drop"]))
{
	$v = $db->sqla("SELECT `weight`,`clan_sign`,`dprice`,`price` FROM `wp` WHERE `id` = ".intval($http->get["drop"])." and dprice=0 and (where_buy<>1 and where_buy<>1 or p_type=13) and `uidp` = ".$player->pers["uid"]." and `weared`=0");
	if ($v["clan_sign"]=="" or ($v["clan_sign"]<>"" and $v["price"]<1400 and $v["dprice"]<1 and ($status=='a' or $status=='wg')))
	{
		if ( $v["clan_sign"] ) $db->sql("UPDATE clans SET treasury=treasury-1 WHERE sign='".$player->pers["sign"]."'");
		set_vars("weight_of_w=weight_of_w-".intval($v["weight"]),$player->pers["uid"]);
		$player->pers["weight_of_w"]-=$v["weight"];
		$db->sql("DELETE FROM wp WHERE id=".intval($http->get["drop"])." and uidp=".$player->pers["uid"]."");
		$_RETURN .= "Вы выкинули предмет.";
	}
}*/

if ( $http->_get('drop') )
{
	function jdel_weapons($v)
	{
		GLOBAL $db,$player,$status;
		if ( $v['clan_sign'] and ($status!='a' or $status!='wg') ) return 'Выкинуть вещь клана может только глава.';
		if ( $v['clan_sign'] and $v['dprice']>0 ) return 'Выкинуть клановую вещь с ДД нельзя.';
		if ( $v['weared'] ) return 'Нельзя выкинуть одетую вещь.';
//		if ( $v['where_buy']==1 or $v['where_buy']==2 ) return 'Нельзя выкинуть особую вещь.';
		if ( $v['p_type']==13 ) return 'Нельзя выкинуть телегу.';
		### Выкидываем
		if ( $v["clan_sign"] ) $db->sql("UPDATE `clans` SET `treasury`=treasury-1 WHERE `sign`= '".$player->pers["sign"]."';");
		$player->pers['weight_of_w']-=$v['weight'];
		set_vars('`weight_of_w` = '.$player->pers['weight_of_w'], $player->pers['uid']);
		$db->sql('DELETE FROM `wp` WHERE `id` = '.$v['id'].';');
		return 'Вы выкинули предмет.';
	}
	
	$v = $db->sqla('SELECT `id`,`weight`,`clan_sign`,`dprice`,`price`,`where_buy`,`p_type`,`weared` FROM `wp` WHERE `id` = '.(int)$http->_get('drop').' and `uidp` = '.UID.' LIMIT 1;');
	if ( $v ) $_RETURN .= jdel_weapons($v);
	else $_RETURN .= "Предмет не существует.";
}


##########################




/// блаж
if (isset($http->post["ustal"]) and isset($http->post["fornickname"])) 
{
$v = $db->sqla("SELECT `id`,`index`,`type` FROM `wp` WHERE `id`='".intval($http->post["ustal"])."' and durability>0"); // есть ли снежок в рюкзаке

$persto = $db->sqla ("SELECT uid,user,location,x,y,chp FROM `users`	WHERE `user` = '".$http->post["fornickname"]."'"); // проверка на локу, координаты перса

if (isset($http->post["ustal"]) and $player->pers["location"]==$persto["location"] and $player->pers["x"]==$persto["x"] and $player->pers["y"]==$persto["y"]) // юзанье
$ustal = rand(1,2);   // рендом ниже

if ($ustal=='1')
	{
$db->sql("UPDATE users SET tire=0 WHERE uid=".$persto["uid"]."");
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
if ($ustal=='2')
	{
$db->sql("UPDATE users SET tire=0 WHERE uid=".$persto["uid"]."");
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
	 $_RETURN .= "<font class=puns>Нет такого персонажа<b>(".$http->post["fornickname"].")</b> в данном месте</font>"; 

unset($v);
unset($persto);
}



?>