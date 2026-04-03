<?php

function zodiak($month, $day)
{
	$r = '';
	if (($day>20 and $month==03) or ($day<21 and $month==04) )		$r = 'Овен';
	elseif (($day>20 and $month==04) or ($day<21 and $month==05))	$r = 'Телец';
	elseif (($day>20 and $month==05) or ($day<22 and $month==06))	$r = 'Близнецы';
	elseif (($day>21 and $month==06) or ($day<23 and $month==07))	$r = 'Рак';
	elseif (($day>22 and $month==07) or ($day<24 and $month==08))	$r = 'Лев';
	elseif (($day>23 and $month==08) or ($day<24 and $month==09))	$r = 'Дева';
	elseif (($day>23 and $month==09) or ($day<24 and $month==10))	$r = 'Весы';
	elseif (($day>23 and $month==10) or ($day<23 and $month==11))	$r = 'Скорпион';
	elseif (($day>22 and $month==11) or ($day<22 and $month==12))	$r = 'Стрелец';
	elseif (($day>21 and $month==12) or ($day<21 and $month==01))	$r = 'Козерог';
	elseif (($day>20 and $month==01) or ($day<21 and $month==02))	$r = 'Водолей';
	elseif (($day>20 and $month==02) or ($day<21 and $month==03))	$r = 'Рыбы';
	return $r;
}



$INFO_TEXT = '';
//rank_i
$rank_i = ($player->pers["s1"]+$player->pers["s2"]+$player->pers["s3"]+$player->pers["s4"]+$player->pers["s5"]+$player->pers["s6"]+$player->pers["kb"])*0.3 + ($player->pers["mf1"]+$player->pers["mf2"]+$player->pers["mf3"]+$player->pers["mf4"])*0.03 + ($player->pers["hp"]+$player->pers["ma"])*0.04+($player->pers["udmin"]+$player->pers["udmax"])*0.3;
if ($rank_i<>$player->pers["rank_i"] and $player->pers["rank_i"]=$rank_i)
//
?>
<div id=inf_from_php style='visibility:hidden;position:absolute;top:0px;height:0;'>
<?
$prison = explode('|',$player->pers["prison"]);
if ($player->pers["punishment"]>=tme()) $punished = tp($player->pers["punishment"]-tme()); else $punished = '';
if ($player->pers["silence_forum"]>=tme()) $fm = tp($player->pers['silence_forum']-tme()); else $fm = '';
$_PUNISHMENT = "['".$player->pers["block"]."','".@$prison[1]."','".@tp($prison[0]-tme())."','".$punished."',".(($player->pers['image_in_info']=='X') ? 1 : 0).",'".$fm."']";

if ($player->pers["invisible"]>tme()) 
{
	$tmi = $player->pers['invisible']-tme();
	$_INV = 1;
	$player->pers["cfight"]=0;
	$player->pers["online"]= $preveleg ? 1 : 0;
	$player->pers["chp"]=$player->pers["hp"];
	$player->pers["cma"]=$player->pers["ma"];
	$player->pers["lastvisits"] = tme()-$tmi;
	$player->pers["lastom"] = tme()-$tmi;
} else $_INV = 0;


if ($player->pers["curstate"]<>4 and $player->pers["cfight"]<5 and $_INV==0) 
{
	hp_ma_up($player->pers["chp"],$player->pers["hp"],$player->pers["cma"],$player->pers["ma"],$player->pers["sm6"],$player->pers["sm7"],$player->pers["lastom"],$player->pers["tire"]);
	$player->pers["chp"] = $hp;
	$player->pers["cma"] = $ma;
}
	
if ($player->pers["online"]==1) 
{
	if ($player->pers["location"]<>'out') $location = $db->sqla("SELECT name FROM `locations` WHERE `id`='".$player->pers["location"]."'");
	else $location = $db->sqla("SELECT name FROM `nature` WHERE `x`='".$player->pers["x"]."' and `y`='".$player->pers["y"]."' ;");
	$_ONLINE = "[".$player->pers["online"].",'".tp($curtimeonline=(tme()-$player->pers["lastvisits"]))."','".$location["name"]."',".$player->pers["x"].",".$player->pers["y"].",".$player->pers["cfight"]."]";
}
else
{
	$location["name"] = '';
	if ($preveleg) 
	{
		if ($player->pers["location"]<>'out')
		$location = $db->sqla("SELECT name FROM `locations` WHERE `id`='".$player->pers["location"]."'");
		else 
		$location = $db->sqla("SELECT name FROM `nature` WHERE `x`='".$player->pers["x"]."' and `y`='".$player->pers["y"]."' ;");
		if ($player->pers["invisible"]>tme()) $_INV = 1; else $_INV = 0;
	}
	$_ONLINE = "[".$player->pers["online"].",'0','".$location["name"]."',0,0,".$player->pers["cfight"].",0]";
}
	
if($player->pers["level"]>9)
{
	$pupil = $db->sqla("SELECT * FROM users WHERE instructor = ".$player->pers["uid"]);
	if($pupil)
	{
		$INFO_TEXT .= "<center>";
		$INFO_TEXT .= "<center style='width:90%' class=combofight>";
		$INFO_TEXT .= "<i class=gray>";
		$INFO_TEXT .= "Обучает персонажа <b class=ma>[".$pupil["level"]."] уровня</b>";
		$INFO_TEXT .= "</i>";
		$INFO_TEXT .= "<div class=but><b class=user>".$pupil["user"]."</b> <b class=lvl>[".$pupil["level"]."]</b> <img src=http://".IMG."/i.gif onclick=\"javascript:window.open('info.php?p=".$pupil["user"]."','_blank')\" style='cursor:pointer' height=16></div>";
		$INFO_TEXT .= "</center>";
		$INFO_TEXT .= "</center>";
	}
}

if($player->pers["level"]<5 and $player->pers["instructor"])
{
	$pupil = $db->sqla("SELECT * FROM users WHERE uid = ".$player->pers["instructor"]);
if($pupil)
{
	$INFO_TEXT .= "<center>";
	$INFO_TEXT .= "<center style='width:90%' class=combofight>";
	$INFO_TEXT .= "<i class=gray>";
	$INFO_TEXT .= "Обучается у персонажа <b class=hp>[".$pupil["level"]."] уровня</b>";
	$INFO_TEXT .= "</i>";
	$INFO_TEXT .= "<div class=but><b class=user>".$pupil["user"]."</b> <b class=lvl>[".$pupil["level"]."]</b> <img src=http://".IMG."/i.gif onclick=\"javascript:window.open('info.php?p=".$pupil["user"]."','_blank')\" style='cursor:pointer' height=16></div>";
	$INFO_TEXT .= "</center>";
	$INFO_TEXT .= "</center>";
}
}
####################################### Склонки подключаем
if ($player->pers["sign"]<>'none')
{
	$clan = $db->sqla("SELECT name,dmoney,sait,level,`align` FROM `clans` WHERE sign='".$player->pers["sign"]."'");
	$player->pers['align'] = $clan['align'];
}
if ( !empty($player->pers['align']) )
{
	$align = $db->sqla_id("SELECT `align`,`name` FROM `aligns` WHERE `align`='".$player->pers['align']."' ;");
	$player->pers['align'] = ($align) ? ($align[0].';'.$align[1]) : '';
} else $player->pers['align'] = '';
#########################################

//$pres["state"] = "[".$row["state"]."]";
  
  
$color = '#333333';
if ($player->pers['clan_state']=='a') $color = '#990000';
if ($player->pers['clan_state']=='b') $color = '#DD0000';
if ($player->pers['clan_state']=='c') $color = '#4B0082';
if ($player->pers['clan_state']=='d') $color = '#009900';
if ($player->pers['clan_state']=='e') $color = '#000099';
if ($player->pers['clan_state']=='f') $color = '#009999';
if ($player->pers['clan_state']=='g') $color = '#800080';
if ($player->pers['clan_state']=='h') $color = '#1E90FF';
if ($player->pers['clan_state']=='i') $color = '#D87093';
if ($player->pers['clan_state']=='j') $color = '#688E23';
if ($player->pers['clan_state']=='k') $color = '#00CED1';

if ($player->pers['sign']<>'none')
{
	
	if ($player->pers['sign']=='watchers')
		$INFO_TEXT .= "<font class=babout>Клан</font><center class=but><font class=items>Персонаж состоит в клане <b><img src='http://".IMG."/signs/".$player->pers['sign'].".gif'>".$clan["name"]."</b></font><br>Должность: ".(($player->pers['clan_state']=='wg') ? "<b style='color:#CC0000'>".$player->pers['state']."</b>" : "<b>".$player->pers['state']."</b>")."<br><a href='http://".$clan["sait"]."/' class=blocked target=_blank>Сайт клана</a></center>";
	else
		$INFO_TEXT .= "<font class=babout>Клан</font><center class=but><font class=items>Персонаж состоит в клане <b><img src='http://".IMG."/signs/".$player->pers["sign"].".gif'>".$clan["name"]."</b>[".$clan["level"]."].</font><br>Должность: <b style='color:".$color."'>"._StateByIndex($player->pers["clan_state"])."</b>[".$player->pers['state']."]<br><a href='http://".$clan["sait"]."/' class=blocked target=_blank>Сайт клана</a></center>";
	
}

$INFO_TEXT .= "<font class=babout>Время онлайн</font><div class=laar><font class=gray>Последний визит:<b> ";
if ($_INV==1 and $preveleg) $INFO_TEXT .= '<font class=hp>невидимка</font>'; else $INFO_TEXT .= time_echo(tme()-$player->pers["lastom"]);
$INFO_TEXT .= "</b></font><br><font class=gray>Время онлайн:<b> ".tp($player->pers["timeonline"]+$curtimeonline)."</b></font></div>";

if ($preveleg) 
{
		$bank = $db->sqlr('SELECT `money` FROM `bank_account` WHERE `uid`='.$player->pers["uid"]);
		$level = $db->sqla("SELECT exp FROM exp WHERE level=".($player->pers["level"]+1));
		$INFO_TEXT .= "<font class=babout>Смотрителям</font>
		<table border=0 cellspacing=0 cellspadding=0 class=LinedTable id=wttable>
		<tr>
		<td class=gray>ID:</td><td class=user>".$player->pers["uid"]."</td></tr><tr>
		<td class=gray>Текущий IP:</td><td class=babout><a href=http://www.ripe.net/fcgi-bin/whois?form_type=simple&full_query_string=&searchtext=".$player->pers["lastip"]." target=_blank><b>".$player->pers["lastip"]."</b></a></td></tr>";
		if ( !empty($player->pers["dr"]) ) 
		{
			$dd = explode('.', $player->pers["dr"]);
			$vz = floor((tme()-(mktime(0, 0, 0, $dd[1], $dd[0], $dd[2]))) / (86400*365.242199));
			$dr = $player->pers["dr"].', '.$vz.' ('.zodiak($dd[1], $dd[0]).')';
			$INFO_TEXT .= "<tr><td class=gray>Дата рождения:</td><td class=babout>".$dr."</td></tr>";
		}
		$INFO_TEXT .= "<tr><td class=gray>Дата регистрации:</td><td class=babout>".$player->pers["ds"]."</td></tr><tr>
		<td class=gray>E-mail:</td><td class=".(($player->pers['mail_good']<>1) ? 'hp title="Нет подтверждения"' : 'ma title="Подтвержден"').">".$player->pers["email"]."</td></tr><tr>
		<td class=gray>Деньги:</td><td class=babout>".$player->pers["money"]." LN</td></tr><tr>";
		if ($player->pers["imoney"]>0) $INFO_TEXT .= "<td class=gray>Золото драконов:</td><td class=babout>".$player->pers["imoney"]." IM</td></tr><tr>";
		if ($bank>0) $INFO_TEXT .= "<td class=gray>Деньги в банке:</td><td class=babout>".$bank." LN.</td></tr><tr>";
		$INFO_TEXT .= "<td class=gray>Валюта:</td><td class=babout>".$player->pers["dmoney"]." Бр.</td></tr><tr>
		<td class=gray>Обнуления:</td><td class=hp>".$player->pers["zeroing"]."</td></tr><tr>
		<td class=gray>Опыт:</td><td class=ma>".($player->pers["exp"]+$player->pers["peace_exp"])."</td></tr><tr>
		<td class=gray>До уровня:</td><td class=green>".($level["exp"] - $player->pers["exp"]-$player->pers["peace_exp"])."</td></tr>
		<td class=hp>Пергаменты:</td><td class=babout>".$player->pers["coins"]."</td></tr><tr>";
		if ( $player->pers['referal_nick'] ) $INFO_TEXT .= "<tr><td class=gray>Старший реферал:</td><td class=babout>".$player->pers["referal_nick"]."</td></tr>";
		if ( $player->pers['refc'] ) $INFO_TEXT .= "<tr><td class=gray>Рефералов:</td><td class=babout>".$player->pers["refc"]."</td></tr>";
		$INFO_TEXT .= "<tr><td class=gray>Просматриваемая страница:</td><td class=babout>";
		
		if ($player->pers["curstate"]==0) $INFO_TEXT .= "Персонаж";
		elseif ($player->pers["curstate"]==1) $INFO_TEXT .= "Инвентарь";
		elseif ($player->pers["curstate"]==2) $INFO_TEXT .= "Локация";
		elseif ($player->pers["curstate"]==3) $INFO_TEXT .= "Возможности";
		elseif ($player->pers["curstate"]==4) $INFO_TEXT .= "Бой";
		
		$INFO_TEXT .= "</td></tr><tr>";
		if ($player->pers["sms"]) $INFO_TEXT .= "<td class=gray>Пользовался смс-сервисом</td><td class=babout>".$player->pers["sms"]."</b> раз. Последний мобильный номер <b>+".$player->pers["phone_no"]."</b></td></tr><tr>";
		if ($clan["dmoney"]) $INFO_TEXT .= "<td class=gray>Денег на счету клана:</td><td class=babout>".$clan["dmoney"]."</td></tr><tr>";

		for($sp = 1;$sp<15; $sp++)
		{
			$color = "#DDDDDD";
			if($sp%2==0) $color = "#EEEEEE";
			$INFO_TEXT .= "<tr bgcolor=".$color."><td class=timef nowrap>".name_of_skill("sp".$sp).":</td><td class=ma>".round($player->pers["sp".$sp],2)."</td></tr>";
		}
		$INFO_TEXT .= "</table>";
}
//if ($player->pers["image_in_info"]) $INFO_TEXT .= "<center><img src='".$player->pers["image_in_info"]."'></center>";
?>
</div><div id=inf_from_php2 style='visibility:hidden;position:absolute;top:0px;height:0;'><? echo $INFO_TEXT;?></div>
<script><?php

$alce = '';
$alc = $db->sql('SELECT `esttime`, `type` FROM `p_alcohol` WHERE `uid`='.$player->pers['uid'].' and `esttime`>'.tme());
while ( $al = $db->fetchRow($alc) ) $alce.= '['.$al[1].', "'.tp($al[0]-tme()).'"],';
$alce = substr($alce,0,strlen($alce)-1);
echo "var alcohol = [".$alce."];";

if ($preveleg) $_WT = true; else $_WT = false;
	
if( $player->pers['maridge'] )
{
	$M = $db->sqla_id("SELECT `user`, `level`, `online`, `invisible` FROM `users` WHERE `uid`=".$player->pers['maridge']);
	if ( $M )
	{
		if ($M[3]>tme()) $M[2]=0;
		echo "var maridge = ['".$M[0]."', ".$M[1].", ".$M[2].", '".$player->pers['pol']."'];";	
	}else echo "var maridge = false;\n";
} else echo "var maridge = false;\n";	

#################################### Профессии
if ( false )
{
	// Кузнец (sp5): Рыбак (sp6): Шахтер (sp7): Ориентирование на местности (sp8): Экономист (sp9): Охотник (sp10): Алхимик (sp11): Добыча камней (sp12): Дровосек (sp13): Выделка кожи (sp14): 
	$asum = 0; $pcount = 5; $pcount2 = 14; $rlist = '';
	for ( $i=$pcount; $i<=$pcount2; $i++ )
	{
		$u = $player->pers['sp'.$i];
	//	$asum+= $u; // Подсчитываем общее значение бонуса
		if ($u > 99)
		{
			if ($u >= 100 and $u < 350) $flevel = 1;
			if ($u >= 350 and $u < 700) $flevel = 2;
			if ($u >= 700) $flevel = 3;
		} else $flevel = '0';
		if ( $rlist == '' ) $rlist.= $flevel; else $rlist.= ','.$flevel; 
	} echo "var mirum = [".$rlist."];\n";
} else echo "var mirum = false;\n";
####################################

	
include(ROOT.'/inc/inc/p_clothes.php');
$zv = '';//$db->sqla("SELECT name FROM `zvanya` WHERE `id` = '".$player->pers["zvan"]."'");
$hp = $player->pers["chp"];
$ma = $player->pers["cma"];
$sphp = 9999;
$spma = 9999;
$player->pers["money"]=-1;
$player->pers["dmoney"]=-1;
$player->pers["udmax"]=-1;
if ($player->pers["main_present"]==1) $player->pers["main_present"]='<img src="http://'.IMG.'/presents/m.jpg" title="Мужицкая медаль +15% к опыту.">';
elseif ($player->pers["main_present"]==2) $player->pers["main_present"]='<img src="http://'.IMG.'/presents/58.jpg" title="Женская медаль +15% к опыту.">';
elseif ($player->pers["main_present"]) $player->pers["main_present"] = '<img src="http://'.IMG.'/presents/'.$player->pers["main_present"].'.jpg" title="Новогодняя медаль">';
else $player->pers["main_present"]='';

$sign_img = ($player->pers['sign']=='watchers') ? 'watch/'.$player->pers['clan_state'] : $player->pers['sign'];
echo "build_pers('".$sh["image"]."','".$sh["id"]."','".$oj["image"]."','".$oj["id"]."','".$or1["image"]."','".$or1["id"]."','".$po["image"]."','".$po["id"]."','".$z1["image"]."','".$z1["id"]."','".$z2["image"]."','".$z2["id"]."','".$z3["image"]."','".$z3["id"]."','".$sa["image"]."','".$sa["id"]."','".$na["image"]."','".$na["id"]."','".$pe["image"]."','".$pe["id"]."','".$or2["image"]."','".$or2["id"]."','".$ko1["image"]."','".$ko1["id"]."','".$ko2["image"]."','".$ko2["id"]."','".$br["image"]."','".$br["id"]."','".$player->pers["pol"]."_".$player->pers["obr"]."',0,'".$player->pers["align"]."','".$sign_img."','".$player->pers["user"]."','".$player->pers["level"]."','".$player->pers["chp"]."','".$player->pers["hp"]."','".$player->pers["cma"]."','".$player->pers["ma"]."',".$player->pers["tire"].",'".$kam1["image"]."','".$kam2["image"]."','".$kam3["image"]."','".$kam4["image"]."','".$kam1["id"]."','".$kam2["id"]."','".$kam3["id"]."','".$kam4["id"]."',".$hp.",".$player->pers["hp"].",".$ma.",".$player->pers["ma"].",".$sphp.",".$spma.",".$player->pers["s1"].",".$player->pers["s2"].",".$player->pers["s3"].",".$player->pers["s4"].",".$player->pers["s5"].",".$player->pers["s6"].",".$player->pers["free_stats"].",".$player->pers["money"].",0,".$player->pers["kb"].",".$player->pers["mf1"].",".$player->pers["mf2"].",".$player->pers["mf3"].",".$player->pers["mf4"].",".$player->pers["mf5"].",".$player->pers["udmin"].",".$player->pers["udmax"].",".$player->pers["rank_i"].",'".$zv."',".$player->pers["victories"].",".$player->pers["losses"].",0,0,0,".$player->pers["zeroing"].",2,".intval($player->pers["diler"]).",0,'".$ws1."','".$ws2."','".$ws3."','".$ws4."','".$ws5."','".$ws6."','".$player->pers["main_present"]."',".intval($you["uid"]).",".$_PUNISHMENT.",".$_ONLINE.");\n";
?>
</script>
<?
if (!$_INV)
{
	$as = $db->sql("SELECT * FROM p_auras WHERE uid=".$player->pers["uid"]." and (esttime>".tme()." or turn_esttime>".$player->pers["f_turn"].") and special<>2");
	$txt = '';
	while($a = $db->fetchArray($as))
	{
		$txt .= $a["image"].'#<b>'.$a["name"].'</b>@';
		$txt .= 'Осталось <i class=timef>'.tp($a["esttime"]-tme()).'</i>';
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
}

?>