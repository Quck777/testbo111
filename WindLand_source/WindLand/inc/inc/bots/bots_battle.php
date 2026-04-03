<?php
$die = '';
$text = '';
echo "/*";
$persTEMP = $player->pers;
for($i=0;$i<3;$i++)
{
	//Битва ботов между собой
	$bot1 = $db->sqla("SELECT * FROM bots_battle WHERE cfight='".$fight["id"]."' and fteam=1 and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$bot2 = $db->sqla("SELECT * FROM bots_battle WHERE cfight='".$fight["id"]."' and fteam=2 and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$bot1["xf"]=$bot2["xf"]=$bot1["yf"]=$bot2["yf"]=0;
	$player->pers = $bot2;
	$persvs = $bot1;
	if($player->pers and $persvs) include("bot_brain.php");
	else break;
	if ($die.$text)
	{
		add_flog($die.$text,$player->pers["cfight"]);
		$die = '';
		$text = ''; 
	}
	$bot1 = $db->sqla("SELECT * FROM bots_battle WHERE cfight='".$fight["id"]."' and fteam=1 and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$bot2 = $db->sqla("SELECT * FROM bots_battle WHERE cfight='".$fight["id"]."' and fteam=2 and chp>0", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$bot1["xf"]=$bot2["xf"]=$bot1["yf"]=$bot2["yf"]=0;
	$player->pers = $bot1;
	$persvs = $bot2;
	if($player->pers and $persvs) include("bot_brain.php");
	else break;
	if ($die.$text)
	{
		add_flog($die.$text,$player->pers["cfight"]); 
	}
}
echo "*/\n";
$player->pers = $persTEMP;
?>