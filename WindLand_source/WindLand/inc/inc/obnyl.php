<?php

if (@$http->get["gopers"]=="obnyl" and ($player->pers["zeroing"]>0 or $player->pers["action"]==-10)) 
{
	$db->sql("UPDATE p_auras SET esttime=0, turn_esttime=0 WHERE `uid`='".$player->pers["uid"]."'");
	$player->remove_all_auras();
	remove_all_weapons ();
	$zeroyed = 1;
	$db->sql ("UPDATE `users` SET zeroing=zeroing-1, `s1` =1, `s2` =1, `s3` =1, `s4` =1, `s5` =1, `s6` =1, `free_stats` =14, mf1=0, mf2=0, mf3=0, mf4=0, mf5=0, `level` =0, `udmin`=1, `udmax`=1, `hp`=5, `ma`=9, `kb`=0, sb1=0,sb2=0,sb3=0,sb4=0,sb5=0,sb6=0,sb7=0,sb8=0,sb9=0,sb10=0,sb11=0,sb12=0,sb13=0,sb14=0,sm1=0,sm2=0,sm3=0,sm4=0,sm5=0,sm6=0,sm7=0, `free_f_skills` =5, `free_m_skills` =5, `refr`=1, `aura`='',action=0 WHERE `uid`='".$player->pers["uid"]."'");
	if ($player->pers["action"]==-10) $db->sql("UPDATE `users` SET zeroing=zeroing+1 WHERE `uid`='".$player->pers["uid"]."'");
	$player->pers["action"] = 0;
}
if (@$http->get["fz"])
{
	$zeroyed = 1;
	$db->sql("UPDATE p_auras SET esttime=0, turn_esttime=0 WHERE `uid`='".$player->pers["uid"]."'");
	$player->remove_all_auras();
	remove_all_weapons ();
	$db->sql("DELETE FROM wp WHERE uidp=".$player->pers["uid"]." and dprice=0 and clan_sign=''");
	$db->sql("UPDATE wp SET weared=0 WHERE uidp=".$player->pers["uid"].";");
	$db->sql("UPDATE `users` SET `s1` =1, `s2` =1, `s3` =1, `s4` =1, `s5` =1, `s6` =1, `free_stats` =14, mf1=0, mf2=0, mf3=0, mf4=0, mf5=0, `level` =0, `udmin`=1, `udmax`=1, `hp`=5, `ma`=9, `kb`=0, sb1=0,sb2=0,sb3=0,sb4=0,sb5=0,sb6=0,sb7=0,sb8=0,sb9=0,sb10=0,sb11=0,sb12=0,sb13=0,sb14=0,sm1=0,sm2=0,sm3=0,sm4=0,sm5=0,sm6=0,sm7=0, `free_f_skills` =5, `free_m_skills` =5, `refr`=1, `aura`='',exp=0, losses=0, victories = 0, peace_exp=0,action=0,money=0 WHERE `uid`=".$player->pers["uid"]."");
	if($player->pers["level"]<2) $db->sql("UPDATE `users` SET coins=0 WHERE `uid`=".$player->pers["uid"]."");
	$db->sql("UPDATE `bank_account` SET money=0 WHERE `uid`=".$player->pers["uid"]."");
	$player->pers["action"] = 0;
}

$player->pers = catch_user (UID);
?>
