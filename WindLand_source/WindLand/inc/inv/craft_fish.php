<?php


	if (@$http->get["delete_making"] and substr_count("|".$player->pers["making"]."|",$http->get["delete_making"]."|"))

		{

		$player->pers["making"]=str_replace("|".$http->get["delete_making"]."|","","|".$player->pers["making"]."|");

		set_vars("making='".$player->pers["making"]."'",$player->pers["uid"]);

		echo "<br>Инструкция по сборке стерта из вашего блокнота";

		}

	if ($player->pers["making"]=="") echo "Вы не изучили ни одной инструкции по сборке.";

	$player->pers["making"]=str_replace("||","|",$player->pers["making"]);

	$making = explode("|",$player->pers["making"]);

	$making = array_unique($making);

	foreach($making as $a)

	{

			$z = 1;

		if ($a<>'')

		{

		$a = $db->sqla("SELECT * FROM `making` WHERE `id`=".$a);

		echo "<table class=fightlong border=0 width=100%>";

		echo "<tr><td class=laar align=center><b>".$a["name"]."</b></td></tr>";

		$v = $db->sqla("SELECT * FROM weapons WHERE id='".$a["id_weapon"]."'");

		echo "<tr><td class=lbutton>Результат: <b>".$v["name"]."</b> 

		".$v["price"]."LN</td></tr>";

		echo "<tr><td class=items><input type=button class=submit value='Просмотр' onclick=\"location='main.php?show_making=".$a["id"]."'\"></td></tr></table><br>";

		}

	}
	
	
	
	#############
	
	if (@$http->get["do_making"] and substr_count("|".$player->pers["making"]."|",$http->get["do_making"]."|"))
	{
		$a = $db->sqla("SELECT * FROM `making` WHERE `id`=".$http->get["do_making"]);
		if ($player->pers["money"]>=$a["price"] and $player->pers["s5"]>=$a["sm5"])
		{
			$z=1;
			$clot = explode ("|",$a["weapons_ids"]);
			$str='';
			foreach ($clot as $vesh) 
			{
				if (@$vesh)
				{
					$g = $db->sqla("SELECT id FROM wp WHERE id_in_w='".$vesh."' and uidp=".$player->pers["uid"]."");
					if (empty($g["id"]))$z=0;
					$db->sql("DELETE FROM wp WHERE uidp=".$player->pers["uid"]." and weared=0 and id_in_w='".$vesh."' LIMIT 1;");
				}
			}
			$str = substr($str,0,strlen($str)-3);
			if ($z==1)
				insert_wp($a["id_weapon"],$player->pers["uid"],-1,0);
			set_vars("money=money-".$a["price"],$player->pers["uid"]);
		}
	}

	if (@$http->get["show_making"])
	{

		$z=1;

		$a = $db->sqla("SELECT * FROM `making` WHERE `id`=".intval($http->get["show_making"]));

		echo "<table class=fightlong border=0 width=100%>";

		echo "<tr><td class=laar align=center><b>".$a["name"]."</b></td></tr>";

		$v = $db->sqla("SELECT * FROM weapons WHERE id='".$a["id_weapon"]."'");

		echo "<tr><td class=lbutton>Результат: <b>".$v["name"]."</b> ".$v["price"]."LN</td></tr>";

		echo "<tr><td class=items>Ингридиенты:</td></tr>";

		$b = explode("|",$a["weapons_ids"]);

		$i=0;

		foreach($b as $id)

		{

			if ($id<>"") 

			{

			$i++;

			$v = $db->sqla("SELECT name,id FROM weapons WHERE id='".$id."'");

			echo "<tr><td>$i) <b>".$v["name"]."</b> ";

			$your = $db->sqla("SELECT id FROM wp WHERE uidp=".$player->pers["uid"]." and id_in_w='".$id."'");

			if (@$your["id"]) echo "<font class=green>Есть

			в инвентаре</font></td></tr>";

			else {echo "<b><font class=red>Отсутствует</font></b></td></tr>";$z=0;}

			}

		}

		echo "<tr><td><hr><font class=time>Требования:</font><br>Деньги: <b>".$a["price"]."LN</b><br>Интелект: <b>".$a["sm5"]."</b>";

			if( $a["sp1"]>0)echo"<br>Целитель: <b>".$a["sp1"]."</b>";

			if( $a["sp2"]>0)echo"<br>Тёмное искусство: <b>".$a["sp2"]."</b>";

			if( $a["sp5"]>0)echo"<br>Кузнец: <b>".$a["sp5"]."</b>";

			if( $a["sp6"]>0)echo"<br>Рыбак: <b>".$a["sp6"]."</b>";

			if( $a["sp7"]>0)echo"<br>Шахтёр: <b>".$a["sp7"]."</b>";

			if( $a["sp9"]>0)echo"<br>Торговец: <b>".$a["sp9"]."</b>";

		if ($player->pers["money"]<$a["price"] or $player->pers["s5"]<$a["sm5"] or $player->pers["sp1"]<$a["sp1"] or $player->pers["sp2"]<$a["sp2"] or $player->pers["sp5"]<$a["sp5"] or $player->pers["sp6"]<$a["sp6"] or $player->pers["sp7"]<$a["sp7"] or $player->pers["sp9"]<$a["sp9"]) $z=0;

		if ($z==1)

		echo "<tr><td class=laar align=center><input type=button class=submit value='Собрать' onclick=\"location='main.php?do_making=".$a["id"]."'\">";

		echo "<tr><td class=laar align=center><input type=button class=submit value='Удалить' onclick=\"location='main.php?delete_making=".$a["id"]."&inv=cat4'\">";

		echo "<tr><td class=laar align=center> ";

		echo "</td></tr></table><br>";

	}
	
	
	
	
	
	
	
	


?>