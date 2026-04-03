<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

?><div id=inf_from_php style='display:none;position:absolute;top:0px;height:0;'>

<center class=timef width=100%>
<table border=0 class=lightblock width=98%>
<tr>
<td colspan=10 align=center>
<?php
		$status = $player->pers['clan_state'];

		$all_weight = $db->sqla("SELECT SUM(weight) as w,COUNT(*) as c FROM `wp` WHERE uidp=".$player->pers["uid"]." and in_bank=0 and `auction` = 0;");
		$all_wp = $all_weight["c"];
		$all_weight = $all_weight["w"];
		if (intval($all_weight)<>$player->pers["weight_of_w"])
			set_vars("weight_of_w=".intval($all_weight),UID);
		$player->pers["weight_of_w"] = intval($all_weight);
		echo "Масса вещей: [".($player->pers["weight_of_w"])."/".abs(10+($player->pers["sm3"]+$player->pers["s4"])*10)."] из ".$all_wp." ваших вещей.";
		if (abs(10+($player->pers["sm3"]+$player->pers["s4"])*10) < ($all_weight))
		echo "<br><b class=hp>Вы перегружены!</b>";

		
		if (@$http->get["zzz"])
		{
			$zz = $db->sqla("SELECT * FROM wp WHERE uidp='".$player->pers["uid"]."' and id='".addslashes($http->get["zzz"])."' AND `auction` <> '1'");
			set_vars("money=money-".(($zz["arrows_max"]-$zz["arrows"])*$zz["arrow_price"])."",$player->pers["uid"]);
			$db->sql ("UPDATE wp SET arrows=arrows_max WHERE uidp='".$player->pers["uid"]."' and id='".addslashes($http->get["zzz"])."'");
		}
		if ($player->pers["sign"]<>'none')
		$clan = $db->sqla ("SELECT * FROM `clans` WHERE `sign`='".$player->pers['sign']."'");
?>
</td></tr>
<tr>
<Td><a href="javascript:inv_conf()" class=Blocked><img src="http://<?php echo IMG;?>/icons/0_on.png"></a></Td>
<?php
if ($weared_count) echo "<td><a href=main.php?snall=all class=Blocked>Снять всё</a></td>"; 
?>
<Td><a href="main.php?inv=weapons" class=Blocked>Вещи</a></Td>
<Td><a href="main.php?inv=magic" class=Blocked>Магия</a></Td>
<Td><a href="main.php?inv=presents" class=Blocked>Подарки</a></Td>
<Td><a href="main.php?inv=cat3" class=Blocked>Комплекты</a></Td>
<?php

if ($player->pers["alchemy_d"]>0 and $player->pers["alchemy_b"]>0 and $player->pers["alchemy_m"]>0) echo "<td><a href=main.php?inv=cat5 class=bg>Алхимия</a></td>";
elseif($player->pers["alchemy_d"] == 0)
	echo "<td><a class=bg onclick=\"alert('Кончилась долговечность дистиллятора.')\">Алхимия</a></td>";
elseif($player->pers["alchemy_b"] == 0)
	echo "<td><a class=bg onclick=\"alert('Кончились пустые ёмкости.')\">Алхимия</a></td>";
elseif($player->pers["alchemy_m"] == 0)
	echo "<td><a class=bg onclick=\"alert('Кончилась долговечность ступки.')\">Алхимия</a></td>";

?>
</tr>
</table>
<div id=container1 class=but></div>
<?php
	$r = types();
	$types = '';
	foreach($r as $key=>$value)
	{
		$types .= $key.'='.$value."|";
	}
?>

<script>
	var _type = '<?=$_FILTER["sorti"];?>';
	var _group = '<?=$_FILTER["filter_f6"];?>';
	var _sort = '<?=$_FILTER["sortp"];?>';
	var __types = '<?=$types;?>';
	var _herbal = <?=$db->sqlr("SELECT COUNT(*) FROM wp WHERE uidp=".$player->pers["uid"]." and type='herbal'");?>;
	var _resources = <?=$db->sqlr("SELECT COUNT(*) FROM wp WHERE uidp=".$player->pers["uid"]." and type='resources'");?>;
	var _fish = <?=$db->sqlr("SELECT COUNT(*) FROM wp WHERE uidp=".$player->pers["uid"]." and type='fish'");?>;
</script>
<script type="text/javascript" src="/js/inv.js"></script>
<?php

$fish = $db->sqlr("SELECT COUNT(id) FROM wp WHERE type='fish' and weared=0 and uidp=".$player->pers["uid"]."");
if ($fish>1 and strpos(" ".$player->pers["location"],"lavka")>0) echo "<input type=button class=loc value='Сдать всю рыбу' onclick=\"location='main.php?give=allfish'\">";

$trees = $db->sqlr("SELECT COUNT(id) FROM wp WHERE id_in_w='res..tree' and weared=0 and uidp=".$player->pers["uid"]."");
if ($trees>1 and strpos(" ".$player->pers["location"],"lavka")>0) echo "<input type=button class=loc value='Сдать все деревья' onclick=\"location='main.php?give=alltrees'\">";

$herbals = $db->sqlr("SELECT COUNT(id) FROM wp WHERE type='herbal' and weared=0 and uidp=".$player->pers["uid"]."");
if ($herbals>1) echo "<input type=button class=but value='Передать все травы' onclick=\"giveallH(".$herbals.")\">";

if ($_RETURN)echo "<br><center><center class=but style='width:60%'><b class=user>".$_RETURN."</b></center></center>";

?>
</center>
<?php
if ( isset($http->get['inv']) and $http->get['inv']=='presents' )
{
	include_once("inv/presents.php");	
}
elseif ( isset($http->get['inv']) and $http->get["inv"]=="magic")
{
	include_once("inv/magic.php");	
}
elseif ( isset($http->get['inv']) and $http->get["inv"]=="cat3")
{
	include_once("inv/complect.php");
}
elseif ( isset($http->get['inv']) and $http->get["inv"]=="cat4")
{
	# include_once("inv/craft_fish.php");
}
elseif ( isset($http->get['inv']) and $http->get["inv"]=="cat5" and $player->pers["alchemy_d"]>0 and $player->pers["alchemy_b"]>0 and $player->pers["alchemy_m"]>0)
{
	include (ROOT.'/inc/inc/alchemy.php');
}
else
{

//// ПОКАЗЫВАЕМ ИНВЕНТАРЬ

######################

$counter=0;
$type_sort='';

if (@$_FILTER["sorti"] and $_FILTER["sorti"]<>'all')
	$type_sort="(`type`='".addslashes($_FILTER["sorti"])."')and";
elseif($_FILTER["sorti"]=='all')
	$type_sort="(`type`<>'herbal' and `type`<>'resources' and `type`<>'fish')and";

if (empty($_FILTER["sortp"]) or $_FILTER["sortp"]=="price") 
	$sort="price";
else 
	$sort = "tlevel";


$koef=1;
if ($player->pers["level"]>4) $koef =0.8;
if ($koef<1) $koef+=$player->pers["sp9"]/1000;
if ($koef>0.99) $koef=0.99;
if ($_ECONOMIST) $koef=0.99;


$res =$db->sql ("SELECT * FROM `wp` WHERE ".$type_sort."(`uidp`=".$player->pers["uid"].") and weared=0 AND `auction` <> '1' AND in_bank<>1 ORDER BY `".$sort."` DESC");

$wp_sht = '';
$shtukes = '';


echo "<center><table border=2 width=98% cellspacing=2 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF>";

$counter=0;

if ($player->pers["level"]>4) $koeff=0.9; else $koeff=1;

while ($vesh=mysql_fetch_array($res))
{
	$sht = 1;
	$item_lib = $vesh["id"];
	
	if (($vesh["durability"]>0 or $vesh["max_durability"]==0) and ($vesh["timeout"]==0 or $vesh["timeout"]>time()))
	{
		if ($_FILTER["filter_f6"]<>2 and $shtt = substr_count($wp_sht,'<'.$vesh["image"].'_'.$vesh["durability"].'_'.$vesh["price"].'_'.$vesh["index"].'>'))
		{
			$shtukes .= "document.getElementById('".$vesh["image"].'_'.$vesh["durability"].'_'.$vesh["price"].'_'.$vesh["index"]."').innerHTML = '".($shtt+1)." шт.';\n";
			$wp_sht .= '<'.$vesh["image"].'_'.$vesh["durability"].'_'.$vesh["price"].'_'.$vesh["index"].'>';
		}
		else
		{
			echo "<tr><td align=left class=weapons_box>";
			include ("inc/weapon.php");
			$wp_sht .= '<'.$vesh["image"].'_'.$vesh["durability"].'_'.$vesh["price"].'_'.$vesh["index"].'>';
		}

		if ($shtt==0)
		{
			if ($v["present"]) $koef_cur = 0.5; else $koef_cur = 1;
			$counter++;
			$buttons = '';
			###
			$no_uz = true;//($v['sign']=='watchers') ? false : true;
			$claner = ( !empty($v['clan_sign']) and $v['clan_sign']!=$player->pers['sign'] ) ? false : true;
//			if (UID==7) $claner = true;
			###
			if ( $claner==true )
			{
				if ( $z==1 and $napad=='' and ($v["type"]=='shlem' or $v["type"]=='orujie' or $v["type"]=='kolco' or $v["type"]=='bronya' or $v["type"]=='naruchi' or $v["type"]=='perchatki' or $v["type"]=='ojerelie' or $v["type"]=='sapogi' or $v["type"]=='poyas' or $v["type"]=='kam' or $v["type"]=='kolchuga') and ($no_uz or $player->pers['sign']=='watchers'))
					$buttons .= "<td><img title='Надеть' src=http://".IMG."/icons/upload.png onclick=\"location='main.php?wear=".$vesh["id"]."'\" style='cursor:pointer'></td>";
				if ( $v["arrows_max"]<>$v["arrows"])
					$buttons .= "<td><input type=button class=inv_but value='Зарядить[".($v["arrows_max"]-$v["arrows"])." > ".(($v["arrows_max"]-$v["arrows"])*$v["arrow_price"])." LN]' onclick=\"location='main.php?zzz=".$vesh["id"]."'\"></td>";
				if ( $weared_count==1 and $v["type"]=='rune')
					$buttons .= "<td><input type=button class=inv_but value='Вставить в ".$weared_name."' onclick=\"location='main.php?rune_join=".$v["id"]."'\"></td>";
				if ( $z==1 and $napad==1 and $vesh["index"]!="invis" and $vesh["index"]!="k" and $vesh["index"]!="k_z" and $vesh["index"]!="b" and $vesh["index"]!="b_z")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"napad('".$item_lib."')\"></td>";
				if ( $z==1 and $napad==2 and $vesh["index"]!="invis" and $vesh["index"]!="k" and $vesh["index"]!="k_z" and $vesh["index"]!="b" and $vesh["index"]!="b_z")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"zakl('".$item_lib."','".$v['name']."','1')\"></td>";
				if ( $z==1 and $vesh["type"]=="ustal")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"ustal('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and $vesh["type"]=="teleport")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"teleport('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and $vesh["index"]=="invis") // Свитки анти невид.
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"scroll('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and ($vesh["index"]=="k" or $vesh["index"]=="k_z") ) //  Кулачка
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"napad_new('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and ($vesh["index"]=="b" or $vesh["index"]=="b_z") ) // Боевое
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"napad_b('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and $vesh["type"]=="potion")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"potion('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and $vesh["type"]=="antinevid")
					$buttons .= "<td><input type=button class=inv_but value=Использовать onclick=\"antinevid('".$item_lib."','".$v['name']."')\"></td>";
				if ( $z==1 and $vesh["type"]=="prim" )
					$buttons .= "<td><input type=button class=inv_but value=Приманить onclick=\"prim('".$item_lib."','".$v['name']."')\"></td>";

				
				
				if ( ($v["where_buy"]<>1 and $v["where_buy"]<>2 or $v["type"]=="rune") and $v["clan_name"]=="" and $player->pers["level"]>4 and $player->pers["punishment"]<time() and $no_uz) 
				{
					$buttons .= "<td><input type=button class=inv_but value=Передать onclick=\"peredat('".$vesh["id"]."','".$v["name"]."')\"></td>";
					$buttons .= "<td><input type=button class=inv_but value='Продать' onclick=\"sellingform('".$vesh["id"]."','".$v["name"]."')\" ></td>";
				}
				if ( strpos(" ".$player->pers["location"],"lavka")>0 and $v["where_buy"]<>1 and ($v["where_buy"]<>2 or $v["p_type"]==5 or $v["p_type"]==6 or $v["type"]=="rune") and ($v["clan_name"]=="" or $status=='a' or $status=='wg') and $no_uz)
					$buttons .= "<td><input type=button class=inv_but value='Сдать за ".round(($v["price"]*$koef*$koef_cur)*(($v["durability"]+1)/($v["max_durability"]+1)),2)."' onclick=\"conf_sale('main.php?lavkasdat=".$vesh["id"]."')\"></td>";
				if ( strpos(" ".$player->pers["location"],"bank")>0 and $v["where_buy"]<>1 and ($v["where_buy"]<>2 or $v["p_type"]==5 or $v["p_type"]==6 or $v["type"]=="rune") and $v["clan_name"]=="" and $player->pers["money"]>=round(($v["price"]*0.1),2) and $no_uz)
					$buttons .= "<td><input type=button class=inv_but value='Сдать в банк на хранение [".round(($v["price"]*0.1),2)." LN]' onclick=\"conf_sale('main.php?bank=".$vesh["id"]."')\"></td>";
				if ( strpos(" ".$player->pers["location"],"dhouse")>0 and $v["where_buy"]=='1' and $v["clan_name"]=="" and $v["timeout"]==0 and $v["dprice"]>5 and $no_uz)
					$buttons .= "<td><input type=button class=inv_but value='Сдать за ".($v["dprice"]*1)*(($v["durability"]+1)/($v["max_durability"]+1))." y.e.' onclick=\"conf_sale('main.php?dhousesdat=".$vesh["id"]."')\"></td>";
				if ( strpos(" ".$player->pers["location"],"dhouse")>0 and $v["where_buy"]=='1' and $v["clan_name"]<>"" and $v["timeout"]==0	and ($status=='a' or $status=='wg') and $no_uz)
					$buttons .= "<td><input type=button class=inv_but value='Сдать за ".($v["dprice"]*1)*(($v["durability"]+1)/($v["max_durability"]+1))." y.e.' onclick=\"conf_sale('main.php?dchousesdat=".$vesh["id"]."')\"></td>";
				if ( $v["where_buy"]<>1 and $v["where_buy"]<>2 and $v["clan_name"]=="" and $player->pers["clan_tr"] and $clan["treasury"]<($clan["maxtreasury"]+30) and $v["p_type"]<>200) 
				{
					$buttons .= "<td><input type=button class=inv_but value='Сдать клану' onclick=\"confc('main.php?to_clan=".$vesh["id"]."')\" title='Сдать клану'></td>";
				}
				if ( (($v["where_buy"]<>1 and $v["where_buy"]<>2) or $v["p_type"]!=13) and ($v["clan_name"]=="" or ($v["clan_name"]<>"" and $v["price"]<1400 and $v["dprice"]<1 and ($status='a' or $status=='wg'))) and $no_uz) 
				{
					$buttons .= "</td><td align=right width=50%><img src=http://".IMG."/icons/delete.png onclick=\"conf('main.php?drop=".$vesh["id"]."')\" title='Выкинуть' style='cursor:pointer'></td>";
				}
			}
			###
			if ( !empty($buttons) ) echo "<table border=0 width=100%><tr><td>".$buttons."</td></tr></table></td></tr>";
		}
	}
	else
	{
		$db->sql("DELETE FROM wp WHERE id='".$vesh["id"]."'");
		if ($vesh["clan_sign"]) $db->sql("UPDATE clans SET treasury=treasury-1 WHERE sign='".$player->pers["sign"]."'");
	}
}
unset($res);

echo "</table></center>";

if ($counter==0) Echo "<i class=timef>У вас нет с собой вещей.</i>";	

}

?>
</font>
</div>
<script>
<?php
echo $shtukes;

$level = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($player->pers["level"]+1));
$level1 = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($player->pers["level"]));
$zv= ''; //$db->sqlr("SELECT name FROM `zvanya` WHERE `id` = '".$player->pers["zvan"]."'");
$sign_img = ($player->pers['sign']=='watchers') ? 'watch/'.$player->pers['clan_state'] : $player->pers['sign'];

echo "var DecreaseDamage = ".DecreaseDamage($player->pers).";\n";
echo "build_pers('".$sh["image"]."','".$sh["id"]."','".$oj["image"]."','".$oj["id"]."','".$or1["image"]."','".$or1["id"]."','".$po["image"]."','".$po["id"]."','".$z1["image"]."','".$z1["id"]."','".$z2["image"]."','".$z2["id"]."','".$z3["image"]."','".$z3["id"]."','".$sa["image"]."','".$sa["id"]."','".$na["image"]."','".$na["id"]."','".$pe["image"]."','".$pe["id"]."','".$or2["image"]."','".$or2["id"]."','".$ko1["image"]."','".$ko1["id"]."','".$ko2["image"]."','".$ko2["id"]."','".$br["image"]."','".$br["id"]."','".$player->pers["pol"]."_".$player->pers["obr"]."',0,'".$sign_img."','".$player->pers["user"]."','".$player->pers["level"]."','".$player->pers["chp"]."','".$player->pers["hp"]."','".$player->pers["cma"]."','".$player->pers["ma"]."',".$player->pers["tire"].",'".$kam1["image"]."','".$kam2["image"]."','".$kam3["image"]."','".$kam4["image"]."','".$kam1["id"]."','".$kam2["id"]."','".$kam3["id"]."','".$kam4["id"]."',".$hp.",".$player->pers["hp"].",".$ma.",".$player->pers["ma"].",".$sphp.",".$spma.",".$player->pers["s1"].",".$player->pers["s2"].",".$player->pers["s3"].",".$player->pers["s4"].",".$player->pers["s5"].",".$player->pers["s6"].",".$player->pers["free_stats"].",".round($player->pers["money"],2).",".$player->pers["dmoney"].",".$player->pers["kb"].",".$player->pers["mf1"].",".$player->pers["mf2"].",".$player->pers["mf3"].",".$player->pers["mf4"].",".$player->pers["mf5"].",".$player->pers["udmin"].",".$player->pers["udmax"].",".$player->pers["rank_i"].",'".$zv."',".$player->pers["victories"].",".$player->pers["losses"].",".$player->pers["exp"].",".$player->pers["peace_exp"].",".($level["exp"] - $player->pers["exp"] - $player->pers["peace_exp"]).",".$player->pers["zeroing"].",1,'".$player->pers["diler"]."',".round(($level["exp"]-$player->pers["exp"])*100/($level["exp"]-$level1["exp"])).",'".$ws1."','".$ws2."','".$ws3."','".$ws4."','".$ws5."','".$ws6."',".intval($player->pers["free_f_skills"] + $player->pers["free_p_skills"] + $player->pers["free_m_skills"]).",".intval($player->pers["help"]).",".intval(($player->pers["refc"]+$player->pers["referal_counter"])?1:0).",".$player->pers["coins"].",'".$lo["id"]."','".$lo["image"]."','".$lo["id"]."','".$lo["image"]."','".$player->pers["imoney"]."');";

?>
</script>
<?php
$as = $db->sql("SELECT * FROM p_auras WHERE uid=".$player->pers["uid"]."");
$txt = '';
while($a = mysql_fetch_array($as))
{
	$txt .= $a["image"].'#<b>'.$a["name"].'</b>@';
	$txt .= 'Осталось <i class=timef>'.tp($a["esttime"]-time()).'</i>';
	$params = explode("@",$a["params"]);
		foreach($params as $par)
		{
			$p = explode("=",$par);
			$perc = '';
			if (substr($p[0],0,2)=='mf') $perc = '%';
			if ($p[1] and $p[0]<>'cma' and $p[0]<>'chp')
			$txt .= '@'.name_of_skill($p[0]).':<b>'.plus_param($p[1]).$perc.'</b>';
		}
	$txt .= '|';
}
echo "<script>view_auras('".$txt."');</script>";
?>