<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

// Передача денег
if (isset($http->post["money"])
	and isset($http->post["fornickname"])
	and $player->pers["punishment"]<$time)
{
	$k = mtrunc(intval($http->post["kolvo"]));
	if ($k>500000) $k=500000;
	if ($k>0 and $k<=$player->pers["money"])
	{
		$persto = $db->sqla("SELECT location,user,money,uid,lastip FROM users WHERE user='".$http->post["fornickname"]."'");
		if ($persto["user"]<>$player->pers["user"])
		{
		if ($persto["location"]==$player->pers["location"])
		{
			$_RETURN .= "Вы передали ".$k." <img src=images/money.gif> для ".$persto["user"]."";
			$m = $player->pers["user"]."|".$k." //268| ||";
			say_to_chat('s',$m,1,$persto["user"],'*',0);
			$player->pers["money"] -= $k;
			$persto["money"]+=$k;
			set_vars("money=".$player->pers["money"],$player->pers["uid"]);
			set_vars("money=".$persto["money"],$persto["uid"]);
			transfer_log(6,$persto["uid"],$player->pers["user"],$k,0,$http->post["reason"],$persto["lastip"],$player->pers["lastip"]);
			transfer_log(3,$player->pers["uid"],$persto["user"],0,$k,$http->post["reason"],$player->pers["lastip"],$persto["lastip"]);
		}else $_RETURN .= "Нет такого персонажа в данном месте либо у вас нет такой суммы.";
		}
		else
		$_RETURN .= "Нельзя ничего передавать себе.";
	}
}


?>