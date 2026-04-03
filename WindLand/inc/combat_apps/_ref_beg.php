<?php

if ($yapp["atime"]<=time() and $yapp["type"]==1)
{
	$player->pers["apps_id"] = 0;
	$db->sql("DELETE FROM app_for_fight WHERE id=".$yapp["id"]."");
	$db->sql("UPDATE users SET apps_id=0,fteam=0 WHERE apps_id=".$yapp["id"]."");
	$yapp["uid"] = 0;
	$yapp["type"]= 0;
}
if ($yapp["uid"]<>$player->pers["uid"] and $yapp["type"]==1 and @$http->get["refusem"])
{
	$player->pers["apps_id"] = 0;
	$db->sql("UPDATE app_for_fight SET pl2=0,atime=".(time()+300)." WHERE id=".$yapp["id"]."");
	set_vars("apps_id=0,fteam=0",UID);
	$yapp["uid"] = 0;
	$yapp["type"]= 0;
}
if ($yapp["uid"]==$player->pers["uid"] and $yapp["type"]==1 and @$http->get["refuse"])
{
	$player->pers["apps_id"] = 0;
	$db->sql("UPDATE app_for_fight SET pl2=0,atime=".(time()+300)." WHERE id=".$yapp["id"]."");
	$db->sql("UPDATE users SET apps_id=0,fteam=0,refr=1 WHERE apps_id=".$yapp["id"]." and fteam=2");
}
if ($yapp["uid"]==$player->pers["uid"] and $yapp["type"]==1 and @$http->get["get_back"])
{
	$player->pers["apps_id"] = 0;
	$db->sql("DELETE FROM app_for_fight WHERE id=".$yapp["id"]."");
	$db->sql("UPDATE users SET apps_id=0,fteam=0,refr=1 WHERE apps_id=".$yapp["id"]."");
	$yapp["uid"] = 0;
	$yapp["type"]= 0;
}
if ($yapp["uid"]==$player->pers["uid"] and $yapp["type"]==1 and $yapp["pl2"]==1 and @$http->get["begin"])
{
	$db->sql("DELETE FROM app_for_fight WHERE id=".$yapp["id"]."");
	$persvs = $db->sqla("SELECT user FROM users WHERE apps_id=".$yapp["id"]." and fteam=2");
	$db->sql("UPDATE users SET apps_id=0,fteam=0,refr=1 WHERE apps_id=".$yapp["id"]."");
	echo "da('Бой начался!');location='main.php';";
	if ($persvs)
		begin_fight ($player->pers["user"],$persvs["user"],"Дуэль на арене [".$yapp["comment"]."]",$yapp["travm"],$yapp["timeout"],$yapp["oruj"],$yapp["bplace"],1);
}
if ($yapp["uid"]==$player->pers["uid"] and $yapp["type"]==2 and @$http->get["get_back"])
{
	$player->pers["apps_id"] = 0;
	$db->sql("DELETE FROM app_for_fight WHERE id=".$yapp["id"]."");
	$db->sql("UPDATE users SET apps_id=0,fteam=0,refr=1 WHERE apps_id=".$yapp["id"]."");
	$yapp["uid"] = 0;
	$yapp["type"]= 0;
}
if ($yapp["uid"]==$player->pers["uid"] and $yapp["type"]==3 and @$http->get["get_back"])
{
	$player->pers["apps_id"] = 0;
	$db->sql("DELETE FROM app_for_fight WHERE id=".$yapp["id"]."");
	$db->sql("UPDATE users SET apps_id=0,fteam=0,refr=1 WHERE apps_id=".$yapp["id"]."");
	$yapp["uid"] = 0;
	$yapp["type"]= 0;
}
?>