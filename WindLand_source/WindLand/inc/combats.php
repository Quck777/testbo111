<center>
<?php
	$tour1 = '';
	$tour2 = '';
	$tour3 = '';	
	include_once ('combat_apps/t_func.php');
	include_once ('combat_apps/t_tour1.php'); 
	include_once ('combat_apps/t_tour2.php');
	include_once ('combat_apps/t_tour3.php');
	
	if (empty($http->get["show_t1"]) and empty($http->get["show_t2"]) and empty($http->get["show_t3"]))
		echo "<table border=0><tr><td>".$tour1."</td><td>".$tour2."</td><td>".$tour3."</td></tr></table>";
?>
</center>
<script LANGUAGE="JavaScript" src="/js/apps_for_fight.js"></script>
<script>
<?
	if ($_FILTER["cat"] == 1) 	set_vars("help=4",UID);

	if($player->pers["sign"]=='watchers' or $player->pers["diler"]==1 or $player->pers["priveleged"])
		echo "var testing=1;\n";
	else
		echo "var testing=0;\n";
	echo "var your_nick = '".$player->pers["user"]."';\n";
	echo "var your_lvl = '".$player->pers["level"]."';\n";
	if ($_FILTER["cat"]) $cat = intval($_FILTER["cat"]); else $cat = 1;
	echo "apps_head(".$cat.",".$player->pers["chp"].",".$player->pers["hp"].",".$player->pers["cma"].",".$player->pers["ma"].",".intval($_FILTER["apps"]).");";
	if($player->pers["free_stats"]>5)
		echo "da('<a class=bga href=main.php?go=pers>Распределите очки, доступные для повышения!</a>');\n";
	if ($weared_count) echo "var orujd=1;\n"; else echo "var orujd=0;\n";
	if (!$player->pers["apps_id"] and $cat<>4) include_once ('combat_apps/_add.php');
	if (!$player->pers["apps_id"] and $cat<>4) include_once ('combat_apps/_join.php');
	if ($player->pers["apps_id"]) 
	{
		$yapp = $db->sqla("SELECT * FROM app_for_fight WHERE id=".$player->pers["apps_id"]."");
	include ("combat_apps/_ref_beg.php");
	if ($yapp["uid"]<>$player->pers["uid"] and $yapp["type"]==1)
	echo "da('Ожидаем подтверждения.<br><a class=bga href=main.php?cat=1&refusem=1>Отказать</a>');\n";
	elseif ($cat==1 and $yapp["uid"]==$player->pers["uid"] and $yapp["type"]==1)
	{
		if ($yapp["pl2"]==0) 
		echo "da('Ожидаем соперника.<br><a class=bga href=main.php?cat=1&get_back=1>Отозвать</a>');\n";
		else echo "da('<a class=bga href=main.php?cat=1&refuse=1>Отказать</a><a class=bga href=main.php?cat=1&begin=1>Начать бой</a>');\n";
	}
	elseif ($cat==2 and $yapp["type"]==2)
	{
		echo "da('Ожидаем начала боя. (<font class=time>".tp($yapp["atime"]-time())."</font>)');\n";
		if ($yapp["pl2"]==0 and $yapp["pl1"]==1 and $yapp["uid"]==$player->pers["uid"]) 
		echo "da('<a class=bga href=main.php?cat=2&get_back=1>Отозвать</a>');\n";
	}
	elseif ($cat==3 and $yapp["type"]==3)
	{
		echo "da('Ожидаем начала боя. (<font class=time>".tp($yapp["atime"]-time())."</font>)');\n";
		if ($yapp["pl1"]==1 and $yapp["uid"]==$player->pers["uid"]) 
		echo "da('<a class=bga href=main.php?cat=3&get_back=1>Отозвать</a>');\n";
	}
	}
	if (!@$yapp["uid"])echo "set_apps(1);\n"; else echo "set_apps(0);\n";
	if (!$player->pers["apps_id"] and $cat<>4) echo "do_app_".$cat."(1);\n";	
	echo "var can_join = ".intval(!$player->pers["apps_id"]).";\n";
	include_once ('combat_apps/_view.php');
?>
ins_HP(<?=$player->pers["chp"]?>,<?=$player->pers["hp"]?>,<?=$player->pers["cma"]?>,<?=$player->pers["ma"]?>, <?=intval($sphp)?>, <?=intval($spma)?>);
</script>