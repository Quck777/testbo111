<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

if (@$http->get["use"] and $player->pers["cfight"]>10 and $player->pers["chp"])
{
	$v = $db->sqla("SELECT `id`,`index`,durability FROM `wp` WHERE `id`=".intval($http->get["use"])."");
	$index = $v["index"];
	if ($v["durability"]>0)
	{
		if (substr_count($index,"hp$"))
		{
			$hp_value = intval(str_replace("hp$","",$index));
			if ($hp_value>abs($player->pers["hp"]-$player->pers["chp"]))$hp_value=abs($player->pers["hp"]-$player->pers["chp"]);
			if ($hp_value>0)
			{
			set_vars("chp=chp+".$hp_value,$player->pers["uid"]);
			$player->pers["chp"]+=$hp_value;
			if ($player->pers["invisible"]<tme())
			$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]].">".$player->pers["user"]."</font>[".$player->pers["level"]."]";
			else
			$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]]."><i>невидимка</i></font>[??]";
			add_flog($nvs." восстанавливает <font class=hp>".$hp_value." HP</font>.",$player->pers["cfight"]);
			}
		}
		if (substr_count($index,"ma$"))
		{
			$ma_value = intval(str_replace("ma$","",$index));
			if ($ma_value>abs($player->pers["ma"]-$player->pers["cma"]))$ma_value=abs($player->pers["ma"]-$player->pers["cma"]);
			if ($ma_value>0)
			{
			set_vars("cma=cma+".$ma_value,$player->pers["uid"]);
			$player->pers["cma"]+=$ma_value;
			if ($player->pers["invisible"]<tme())
			$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]].">".$player->pers["user"]."</font>[".$player->pers["level"]."]";
			else
			$nvs = "<font class=bnick color=".$colors[$player->pers["fteam"]]."><i>невидимка</i></font>[??]";
			add_flog($nvs." восстанавливает <font class=ma>".$ma_value." MA</font>.",$player->pers["cfight"]);
			}
		}
		$db->sql("UPDATE wp SET durability=durability-1 WHERE id=".intval($http->get["use"])." and uidp='".$player->pers["uid"]."'");
	}
}

if (@$http->post["do"]=="wear")
{
	$chars = $db->sqla("SELECT complects FROM chars WHERE uid='".$player->pers["uid"]."'");
	$cc = explode("@",$chars["complects"]);
	$cc = $cc[$http->post["c"]];
	remove_all_weapons ();
	$ids = explode(":",$cc);
	$ids = explode("|",$ids[1]);
	foreach($ids as $id)
		if ($id)dress_weapon($id,1);
	unset($chars);
}

// Одеваем вещь >>>>>>>>>>>>>>>>>>>>>>>>
if (!empty($http->get["wear"]) and $http->get["wear"]<>'none' and !$player->pers["cfight"] and !@$player->pers["apss_id"] )
	dress_weapon(intval($http->get['wear']));

// Снимаем всё>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
//////////////////////////////////
if (@$http->get["snall"]=="all" and !$player->pers["cfight"])
remove_all_weapons ();

// Снимаем что-то одно >>>>>>>>>>>>
///////////////////////////////
if (!empty($http->get["sn"]) and !$player->pers["cfight"])
remove_weapon ($http->get["sn"],0);



//Проверка  требований одежды

$wears = array();
for ($i=0;$i<21;$i++)
 {
	$m = array();
	$m["image"]='slots/pob'.($i+1);
	$m["id"]="0";
	$wears[$i]=$m;
 }

$sh = $wears[0];
$na = $wears[8];
$oj = $wears[1];
$pe = $wears[9];
$or1 = $wears[2];
$or2 = $wears[10];
$po = $wears[3];
$z1 = $wears[4];
$z2 = $wears[5];
$z3 = $wears[6];
$sa = $wears[7];
$ko1 = $wears[11];
$ko2 = $wears[12];
$br = $wears[13];
$kam1 = $wears[14];
$kam2 = $wears[15];
$kam3 = $wears[16];
$kam4 = $wears[17];
$lo = $wears[18];
unset($wears);
unset($m);

$or1type = $or2type = "";

$ws1=0;
$ws2=0;
$ws3=0;
$ws4=0;
$ws5=0;
$ws6=0;


$res = $db->sql("SELECT * FROM `wp` WHERE uidp='".$player->pers["uid"]."' and weared=1");
$j=0;
$tt = time();
$weared_count=0;
$UD_ART = 1;
while ($v=$db->fetchArray($res))
{
	$z=1;

	if (($v["durability"]<1 and $v["max_durability"]>0) or ($v["timeout"]>0 and $v["timeout"]<$tt))
	{
		remove_weapon ($v["id"],$v);
		$z=0;
	}
	if ($z and $player->pers["curstate"]<>4)
		foreach ($v as $key => $value)
		{
			if ($key[0]=='t' and $key<>'timeout')
			 if ($value>0 and $player->pers[substr($key,1,strlen($key)-1)]<$value)
			 {
			  $z =0;
			  remove_weapon ($v["id"],$v);
			  break;
			 }
		}

	if ($z)
		{
			$ws1 += $v["s1"];
			$ws2 += $v["s2"];
			$ws3 += $v["s3"];
			$ws4 += $v["s4"];
			$ws5 += $v["s5"];
			$ws6 += $v["s6"];
			$dscr = $v["id"].'|';
			if ($v["name"]) $dscr .= '<b>'.str_replace(' ','&nbsp;',str_replace('"','*',$v["name"]))."</b>@";
			//if ($v["tlevel"]) $dscr .= '<b class=dark>Уровень: '.$v["tlevel"]."</b>@";
			if ( $v["clan_sign"] and UID == 7 ) $dscr .= 'Клан: <img src=/images/signs/'.$v["clan_sign"].'.gif><b>'.$v["clan_name"].'</b>@';
			//if ($v["price"]) $dscr .= '<b>'.$v["price"]." LN</b>@";
			//if ($v["dprice"]) $dscr .= '<b>'.$v["dprice"]." Бр.</b>@";
			//if ($v["dprice"]>100) $dscr .= "<font class=green>АРТЕФАКТ</font></i>@";
			if ($v["udmax"]+$v["udmin"]) $dscr .= 'Удар: '.$v["udmin"]."-".$v["udmax"]."@";
			if ($v["kb"]) $dscr .= 'Класс брони: '.plus_param($v["kb"])."@";
			if ($v["mf5"]) $dscr .= 'Пробой брони: '.plus_param($v["mf5"])."@";
			if ($v["hp"]) $dscr .= 'HP: '.plus_param($v["hp"])."@";
			if ($v["ma"]) $dscr .= 'Мана: '.plus_param($v["ma"])."@";

			//if ($v["slots"]) $dscr .= 'Слотов: <B>'.$v["slots"]."</B>@";
			//if ($v["radius"]) $dscr .= 'Радиус поражения: <B>'.$v["radius"]."</B>@";
			$dscr .= 'Долговечность:&nbsp;'.$v["durability"]."/".$v["max_durability"]."@";
		if ($v["type"]=="shlem" and $sh["image"]=$v["image"]) $sh["id"]=$dscr;
		if ($v["type"]=="ojerelie" and $oj["image"]=$v["image"]) $oj["id"]=$dscr;
		if ($v["type"]=="poyas" and $po["image"]=$v["image"]) $po["id"]=$dscr;
		if ($v["type"]=="sapogi" and $sa["image"]=$v["image"]) $sa["id"]=$dscr;
		if ($v["type"]=="naruchi" and $na["image"]=$v["image"]) $na["id"]=$dscr;
		if ($v["type"]=="perchatki" and $pe["image"]=$v["image"]) $pe["id"]=$dscr;
		if ($v["type"]=="bronya" and $br["image"]=$v["image"]) $br["id"]=$dscr;
			if ($v["type"]=="kolchuga" and $lo["image"]=$v["image"]) $lo["id"]=$dscr;
		if ($v["type"]=="orujie" and $or1["id"]=="0" and $or1["image"]=$v["image"]){$or1["id"]=$dscr;$or1type=$v["stype"];}
		if ($v["type"]=="orujie" and $or2["id"]<>"0") remove_weapon($v["id"],$v);
		if ($v["stype"]=='book')
		{
			define("BOOK_ID",$v["id"]);
			define("BOOK_SLOTS",$v["slots"]);
			define("BOOK_INDEX",$v["index"]);
		}
		if ($v["type"]=="orujie" and ($or1["id"]<>$dscr)
		and $or2["image"]=$v["image"]){$or2["id"]=$dscr;$or2type=$v["stype"];}
		if ($v["type"]=="kolco" and $ko1["id"]=="0" and $ko1["image"]=$v["image"] and $_ko1=true)
		$ko1["id"]=$dscr;
		if ($v["type"]=="kolco" and ($ko1["id"]<>$dscr)
		and $ko2["image"]=$v["image"])	$ko2["id"]=$dscr;
		if ($v["type"]=="kam")
		{
			for ($i=$j;$i<$j+1;$i++)
			if($i==0){$kam1["id"]=$dscr;$kam1["image"]=$v["image"];}
			elseif($i==1){$kam2["id"]=$dscr;$kam2["image"]=$v["image"];}
			elseif($i==2){$kam3["id"]=$dscr;$kam3["image"]=$v["image"];}
			elseif($i==3){$kam4["id"]=$dscr;$kam4["image"]=$v["image"];}
			$j++;
		}
		$weared_count++;
		if ($weared_count==1) {$weared_name=$v["name"];$weared_id=$v["id"];$weared_slots=$v["slots"];$weared_wp=$v;}
		//if ($v["dprice"]>100) $UD_ART += $v["dprice"]/5000;
		}
	}

if ($or1type=='noji' or $or1type=='shit')
{
	$tmp = $or1;
	$or1 = $or2;
	$or2 = $tmp;
}

$ws1 = plus_param($ws1);
$ws2 = plus_param($ws2);
$ws3 = plus_param($ws3);
$ws4 = plus_param($ws4);
$ws5 = plus_param($ws5);
$ws6 = plus_param($ws6);

if ($UD_ART<>$player->pers["is_art"]) set_vars("is_art=".$UD_ART."",UID);
define ("UD_ART",$UD_ART);
unset($v);
if ($res instanceof mysqli_result) $res->free();
unset($res);

if ($t%10==0)
{
$all_weight = intval($db->sqlr("SELECT SUM(weight) as ww FROM `wp` WHERE uidp=".$player->pers["uid"]."  and in_bank=0"));
if ($all_weight<>$player->pers["weight_of_w"])
$db->sql ("UPDATE `users` SET `weight_of_w`=".($all_weight)." WHERE `uid`='".$player->pers["uid"]."'");
}

// Вставляем руну>>>>>>>>>>>>>>>>>>>>>
///////////////////////////////
if (@$http->get["rune_join"])
{
	if ($weared_slots)
	{
	$rune = $db->sqla("SELECT * FROM wp WHERE id=".intval($http->get["rune_join"])."");
	if ($player->pers["sp5"]>$rune["tsp5"])
	{
		remove_weapon ($weared_id,$weared_wp);
		$sk = explode("_",$rune["id_in_w"]);
		$db->sql("UPDATE wp SET `".$sk[2]."`=`".$sk[2]."`+".$sk[1].",slots=slots-1,price=price+".sqrt($rune["price"]).",
		`name`='".$weared_name."[Р]' WHERE id=".$weared_id."");
		if ($sk[2]=="udmax")$db->sql("UPDATE wp SET `udmin`=`udmin`+1 WHERE id=".$weared_id."");
		$db->sql("DELETE FROM wp WHERE id=".intval($http->get["rune_join"])."");
		$_RETURN .= "Удачно вставлена \"".$rune["name"]."\" в \"".$weared_name."\"";
		dress_weapon($weared_id,1);
	}else
	$_RETURN .= "<font class=hp>Не хватает умения \"Кузнец\".</hp>";
	}else $_RETURN .= "Закончились слоты для рун.";
	unset($rune);
}


//rank_i
$rank_i = round(($player->pers["s1"]+$player->pers["s2"]+$player->pers["s3"]+$player->pers["s4"]+$player->pers["s5"]+$player->pers["s6"]+$player->pers["kb"])*0.3 + ($player->pers["mf1"]+$player->pers["mf2"]+$player->pers["mf3"]+$player->pers["mf4"])*0.03 + ($player->pers["hp"]+$player->pers["ma"])*0.04+($player->pers["udmin"]+$player->pers["udmax"])*0.3,2);

if ($rank_i<>round($player->pers["rank_i"],2))
{
	$player->pers["rank_i"]=$rank_i;
	set_vars("rank_i=".$player->pers["rank_i"]."",$player->pers["uid"]);
}
//
?>