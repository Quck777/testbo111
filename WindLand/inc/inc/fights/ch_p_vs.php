<?php
$player->pers["chp"] = floor($player->pers["chp"]);
$player->pers["cma"] = floor($player->pers["cma"]);

$cans = $db->sql("SELECT uid2 FROM turns_f WHERE uid1=".$player->pers["uid"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
$uid_query = '';
while ($c = $db->fetchArray($cans)) $uid_query .= ' and uid<>'.$c["uid2"].'';

if ($player->pers["chp"]>0)
{
	if ( $http->_get("vs_id") )
	{
		$idvs = intval(base64_decode($http->get["vs_id"]));
		if ($idvs>0) $persvs = $db->sqla("SELECT * FROM users WHERE uid=".$idvs." and fteam<>".$player->pers["fteam"]." and chp>0".$uid_query, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		else $persvs = $db->sqla("SELECT * FROM bots_battle WHERE id=".$idvs." and chp>0 and fteam<>".$player->pers["fteam"]."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	}
	if (empty($http->get["vs_id"]) or !$persvs["user"])
	{
		$persvs = $db->sqla("SELECT * FROM users WHERE cfight=".$player->pers["cfight"]." and fteam<>".$player->pers["fteam"]." and chp>0".$uid_query, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		if (!$persvs["uid"]) 
			$persvs = $db->sqla("SELECT * FROM bots_battle WHERE cfight=".$player->pers["cfight"]." and fteam<>".$player->pers["fteam"]." and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	}
	//if (!$persvs["user"]) sql("UPDATE users SET cfight=0, curstate=0,refr=1,exp_in_f=0,kills=0,fexp=0 WHERE uid=".$player->pers["uid"]."");

	$persvs["chp"] = floor($persvs['chp']);
	$persvs["cma"] = floor($persvs['cma']);
}
?>