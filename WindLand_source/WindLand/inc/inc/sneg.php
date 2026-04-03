<?
// Снежинки - хуячинье на НГ))
if (isset($_POST["snejok"]) and isset($_POST["fornickname"])) // юзанье снежка
{
$v = $db->sqla("SELECT `id`,`index`,`type` FROM `wp` WHERE `id`='".intval($_POST["snejok"])."' and durability>0"); // есть ли снежок в рюкзаке

$persto = $db->sqla ("SELECT uid,user,location,x,y,chp FROM `users`	WHERE `user` = '".$_POST["fornickname"]."'"); // проверка на локу, координаты перса

if (isset($_POST["snejok"]) and $player->pers["location"]==$persto["location"] and $player->pers["x"]==$persto["x"] and $player->pers["y"]==$persto["y"]) // юзанье
$snejok = rand(1,9);   // рендом ниже

if ($snejok=='1')
	{
$db->sql("UPDATE users SET chp=chp-100 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','Нагло ухмыльшувшись <b>'.$player->pers["user"].'</b> швырнул(а) снежок в  <b>'.$persto["user"].'</b>, стукнув его по уху.<font class=red> ХП - 100 .</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
if ($snejok=='2')
	{
$db->sql("UPDATE users SET chp=chp-60 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','<b>'.$player->pers["user"].'</b> ласково пульнул(а) куском льда в застывшего <b>'.$persto["user"].'</b> <font class=red> ХП - 60.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
if ($snejok=='3')
	{
$db->sql("UPDATE users SET chp=chp-70 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','Закричав:"С Новым годом!!!" <b>'.$player->pers["user"].'</b> запустил(а) снежком в  <b>'.$persto["user"].'</b> <font class=red> ХП - 70.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
if ($snejok=='4')
	{
$db->sql("UPDATE users SET chp=chp-120 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','Выпив коньяк и закусив носом снеговика  <b>'.$player->pers["user"].'</b> засадил(а) снежок в <b>'.$persto["user"].'</b>,точно попав в лоб <font class=red> ХП -120 .</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
 	else
if ($snejok=='5')
	{
$db->sql("UPDATE users SET chp=chp-50 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','С криком:"Ура!!!"  <b>'.$player->pers["user"].'</b> швырнул(а) большой снежок в  <b>'.$persto["user"].'</b>,поставив синяк под глазом <font class=red> ХП - 50 .</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
    	else
if ($snejok=='6')
	{
$db->sql("UPDATE users SET chp=chp-30 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','<b>'.$player->pers["user"].'</b> рассмеявшись, запулил(а) что-то белое и шарообразное в застывшего <b>'.$persto["user"].'</b> <font class=red> ХП - 30.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }


    	else
if ($snejok=='7')
	{
$db->sql("UPDATE users SET chp=chp-30 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','<b>'.$player->pers["user"].'</b> хихикая бросил(а) снежный ком в неуклюжего  <b>'.$persto["user"].'</b>, попав прямо в яблочко <font class=red> ХП - 30.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }


    	else
if ($snejok=='8')
	{
$db->sql("UPDATE users SET chp=chp-140 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','<b>'.$player->pers["user"].'</b> красиво запулил(а) снежный шар в спокойного <b>'.$persto["user"].'</b><font class=red> ХП - 140.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }

    	else
if ($snejok=='9')
	{
$db->sql("UPDATE users SET chp=chp-80 WHERE uid=".$persto["uid"]."");
say_to_chat ('Олень Рудольф сообщает','Пробурчав:"Не надо было съедать мою конфету!"  <b>'.$player->pers["user"].'</b> запустил(а) снежок в  <b>'.$persto["user"].'</b>, точно попав в глаз <font class=red> ХП - 80.</font>',0,'','*',0);
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }

	else
	 $_RETURN .= "<font class=puns>Нет такого персонажа<b>(".$_POST["fornickname"].")</b> в данном месте</font>"; // трах тибидох :D

unset($v);
unset($persto);
}

if (isset($_POST["antinevid"]) and isset($_POST["fornickname"])) // юзанье снежка
{
$v = $db->sqla("SELECT `id`,`index`,`type` FROM `wp` WHERE `id`='".intval($_POST["antinevid"])."' and durability>0"); // есть ли снежок в рюкзаке

$persto = $db->sqla ("SELECT uid,user,location,x,y,chp FROM `users`	WHERE `user` = '".$_POST["fornickname"]."'"); // проверка на локу, координаты перса

if (isset($_POST["antinevid"]) and $player->pers["location"]==$persto["location"] and $player->pers["x"]==$persto["x"] and $player->pers["y"]==$persto["y"]) // юзанье
$antinevid = rand(1,2);   // рендом ниже

if ($antinevid=='1')
	{
	       $db->sql("UPDATE p_auras SET esttime=0
			WHERE uid=".$player->pers["uid"]." and special>1 and special<3 and esttime>".tme().";");
$db->sql("UPDATE users SET invisible=0 WHERE uid=".$persto["uid"]."");
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }
	else
if ($antinevid=='2')
	{
	       $db->sql("UPDATE p_auras SET esttime=0
			WHERE uid=".$player->pers["uid"]." and special>1 and special<3 and esttime>".tme().";");
$db->sql("UPDATE users SET invisible=0 WHERE uid=".$persto["uid"]."");
$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
    }

	else
	 $_RETURN .= "<font class=puns>Нет такого персонажа<b>(".$_POST["fornickname"].")</b> в данном месте</font>"; // трах тибидох :D

unset($v);
unset($persto);
}


//приманка
if ( $http->_post('prim') )
{
	$v = $db->sqla("SELECT `id`,`index`,`type` FROM `wp` WHERE `id`='".intval($http->_post('prim'))."' and `durability` > 0 and `type` = 'prim';"); // есть ли снежок в рюкзаке
	if ( $v )
	{
		$prim = rand(1,2);   // рендом ниже
		if ($prim==1)
		{
			$SPECIAL_pers = $player->pers;
			$SPECIAL_count = 3;
			include(ROOT."/gameplay/bots/attack.php");
			$db->sql("UPDATE `wp` SET `durability`=durability-1 WHERE `id`=".$v["id"]."");
		}
		elseif ($prim==2)
		{
			$SPECIAL_pers = $player->pers;
			$SPECIAL_count = 6;
			include(ROOT."/gameplay/bots/attack.php");
			$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".$v["id"]."");
		}
		$_RETURN.= '<font class=puns>Приманка успешно использована.</font><script>location = "/main.php?refresh=1";</script>';
	} else $_RETURN .= "<font class=puns>Нет приманки.</font>"; 
	unset($v);
}
?>