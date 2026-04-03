<SCRIPT LANGUAGE='JavaScript' SRC='/js/mine.js'></SCRIPT>
<?php
$MINE_ID = 32;//($player->pers["x"]*$player->pers["y"])%65500;
$tr = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"]+1)." and y=".$player->pers["miney"]." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
$tl = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"]-1)." and y=".$player->pers["miney"]." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
$td = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"])." and y=".($player->pers["miney"]+1)." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
$tu = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"])." and y=".($player->pers["miney"]-1)." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);

	$t = tme();
	$timep = 600;
	$timed = 240; // 240
	$tper = 5;
	$no_make=0;
	/*
	if ($t%3000==0)
	{
		$mperses = sql("SELECT user,level FROM users WHERE location='mine' and cfight=0 and apps_id=0 and online=1");
		$bots_str = '';
		$users_str = '';
		while($mpers = mysql_fetch_array($mperses,MYSQL_ASSOC))
		{
			$a = $mpers["level"]+rand(-10,10);
			if ($a>99) $a=99;
			if ($a<1) $a = 1;
			$bots_str .= "bot=".(1000+$a)."|";
			$users_str .= $mpers["user"]."|";
		}
		begin_fight (substr($bots_str,0,strlen($bots_str)-1),substr($users_str,0,strlen($users_str)),"Атака подземных существ на шахтёров",100,180,0);
		say_to_chat ("s","Подземные существа атакуют шахтёров!!!",0,0,'*',0);
	}
	*/

	if ( @$http->get["minego"] and $player->pers["waiter"]<=$t and $player->jKey(1) )
	{
		$res = $db->sql("SELECT * FROM resources ORDER BY RAND()", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$r1 = mysql_fetch_array($res);
		$r2 = mysql_fetch_array($res);
		$r3 = mysql_fetch_array($res);
		$kr1 = floor(rand(10,2000)*sqrt($player->pers["minex"]+$player->pers["miney"])/$r1["price"]);
		$kr2 = floor(rand(10,2000)*sqrt($player->pers["minex"]+$player->pers["miney"])/$r2["price"]);
		$kr3 = floor(rand(10,2000)*sqrt($player->pers["minex"]+$player->pers["miney"])/$r3["price"]);
		if ($r1["image"]==3)
		{

		}

		if ($http->get["minego"]=='left')
		{
			$player->pers["minex"]=$player->pers["minex"]-1;
			$player->pers["miney"]=$player->pers["miney"];
			if (!$tl["mine"]) $db->sql("INSERT INTO `mine` (`x`,`y`,`time_ready`,`r1id`,`r2id`,`r3id` , `r1k` , `r2k` , `r3k`,`mine`,`countp`)
				VALUES ('".($player->pers["minex"])."', '".($player->pers["miney"])."', '".($t+$timep-$player->pers["sp7"])."','".$r1["image"]."', '".$r2["image"]."', '".$r3["image"]."', '".$kr1."', '".$kr2."', '".$kr3."', '".$MINE_ID."', '1');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			elseif ($tl["time_ready"]>$t)
				$db->sql("UPDATE mine SET time_ready=".($t+($tl["time_ready"]-$t)*($tl["countp"]-1)/$tl["countp"]).",countp=countp+1 WHERE x='".($player->pers["minex"])."' and y='".($player->pers["miney"])."' and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		}
		if ($http->get["minego"]=='right')
		{
			$player->pers["minex"]=$player->pers["minex"]+1;
			$player->pers["miney"]=$player->pers["miney"];
			if (!$tr["mine"]) $db->sql("INSERT INTO `mine` ( `x` , `y` , `time_ready` , `r1id` , `r2id` , `r3id` , `r1k` , `r2k` , `r3k` ,`mine` , `countp` ) 
				VALUES ('".($player->pers["minex"])."', '".($player->pers["miney"])."', '".($t+$timep-$player->pers["sp7"])."','".$r1["image"]."', '".$r2["image"]."', '".$r3["image"]."', '".$kr1."', '".$kr2."', '".$kr3."', '".$MINE_ID."', '1');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			elseif ($tr["time_ready"]>$t)
				$db->sql("UPDATE mine SET time_ready=".($t+($tr["time_ready"]-$t)*($tr["countp"]-1)/$tr["countp"]).",countp=countp+1 WHERE x='".($player->pers["minex"])."' and y='".($player->pers["miney"])."' and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		}
		if ($http->get["minego"]=='up')
		{
			$player->pers["minex"]=$player->pers["minex"];
			$player->pers["miney"]=$player->pers["miney"]-1;
			if (!$tu["mine"]) $db->sql("INSERT INTO `mine` ( `x` , `y` , `time_ready` , `r1id` , `r2id` , `r3id` , `r1k` , `r2k` , `r3k` ,`mine` , `countp` )
				VALUES ('".($player->pers["minex"])."', '".($player->pers["miney"])."', '".($t+$timep-$player->pers["sp7"])."','".$r1["image"]."', '".$r2["image"]."', '".$r3["image"]."', '".$kr1."', '".$kr2."', '".$kr3."', '".$MINE_ID."', '1');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			elseif ($tu["time_ready"]>$t)
			$db->sql("UPDATE mine SET time_ready=".($t+($tu["time_ready"]-$t)*($tu["countp"]-1)/$tu["countp"]).",countp=countp+1 WHERE x='".($player->pers["minex"])."' and y='".($player->pers["miney"])."' and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		}
		if ($http->get["minego"]=='down')
		{
			$player->pers["minex"]=$player->pers["minex"];
			$player->pers["miney"]=$player->pers["miney"]+1;
			if (!$td["mine"]) $db->sql("INSERT INTO `mine` ( `x` , `y` , `time_ready` , `r1id` , `r2id` , `r3id` , `r1k` , `r2k` , `r3k` ,`mine` , `countp` )
				VALUES ('".($player->pers["minex"])."', '".($player->pers["miney"])."', '".($t+$timep-$player->pers["sp7"])."','".$r1["image"]."', '".$r2["image"]."', '".$r3["image"]."', '".$kr1."', '".$kr2."', '".$kr3."', '".$MINE_ID."', '1');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			elseif ($td["time_ready"]>$t)
				$db->sql("UPDATE mine SET time_ready=".($t+($td["time_ready"]-$t)*($td["countp"]-1)/$td["countp"]).",countp=countp+1 WHERE x='".($player->pers["minex"])."' and y='".($player->pers["miney"])."' and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		}
		set_vars("minex=".$player->pers["minex"].",miney=".$player->pers["miney"].",waiter=".($t+$tper)."",$player->pers["uid"]);
		$player->pers["waiter"]=$t+$tper;

		$tr = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"]+1)." and y=".$player->pers["miney"]." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$tl = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"]-1)." and y=".$player->pers["miney"]." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$td = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"])." and y=".($player->pers["miney"]+1)." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$tu = $db->sqla("SELECT * FROM mine WHERE x=".($player->pers["minex"])." and y=".($player->pers["miney"]-1)." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);

	} elseif (@$http->get["minego"]) var_dump($player->jKey(1));
$tunnel = $db->sqla("SELECT * FROM mine WHERE x=".$player->pers["minex"]." and y=".$player->pers["miney"]." and mine=".$MINE_ID."");
############################################
/*
if (!$tunnel["r1k"] and !$tunnel["r2k"] and !$tunnel["r3k"] and $t%20==0)
sql("UPDATE mine SET r1k=r1k+".rand(1,30).",r2k=r2k+".rand(2,15).",r3k=r3k+".rand(15,40)." WHERE x=".$tunnel["x"]." and y=".$tunnel["y"]." and mine=".$tunnel["mine"]."");
*/
############################################
$inst = $db->sqla("SELECT id,udmin,udmax,durability,price FROM wp WHERE uidp=".$player->pers["uid"]." and weared=1 and p_type=5", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if (!$inst["id"]) $no_make=1;
if (@$http->get["beginr"] and !$no_make and $player->pers["waiter"]<$t and $player->pers["tire"]<100)
{
	include("mine/resource.php");
	$inst = $db->sqla("SELECT id,udmin,udmax,durability FROM wp WHERE uidp=".$player->pers["uid"]." and weared=1 and p_type=5", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
}
############################################

	$cursor = '';
	$help = '';
	if ($player->pers["minex"]==0 and $player->pers["miney"]==0)
	$help = '<b>Помощь:</b><br><p class=timef>Для того чтобы начать добычу нужно пройти к тунелю с ресурсами и начать добычу. Если ресурсы в тунеле закончились, вы можете раскопать новый тоннель. Это можно делать группой. Просто нажмите на белую стрелку и согласитесь , тогда ваш персонаж начнёт раскапывать новый тоннель. Если в это время этот тоннель кто-то уже раскапывал, то время раскопок снизиться и т.д. чем больше раскопщиков - тем быстрее создастся тоннель.</p><hr>';
	$help.='<p class=timef>Умение "ШАХТЁР" помогает разглядеть более дорогие ресурсы в стенах тунеля, а так же быстрее разрывать новые тунели.<br>Умение "ДОБЫЧА КАМНЕЙ" повышает кол-во добываемых ресурсов за единицу времени.</p><hr>';



	if (empty($tr["mine"]) or $tr["time_ready"]>$t) $cltr='class=fader onclick="go_confirm(\'right\')"'; else $cltr='onclick="location=\'main.php?minego=right&'.$player->jKey().'\'"';
	if (empty($tl["mine"]) or $tl["time_ready"]>$t) $cltl='class=fader onclick="go_confirm(\'left\')"'; else $cltl='onclick="location=\'main.php?minego=left&'.$player->jKey().'\'"';
	if (empty($tu["mine"]) or $tu["time_ready"]>$t) $cltu='class=fader onclick="go_confirm(\'up\')"'; else $cltu='onclick="location=\'main.php?minego=up&'.$player->jKey().'\'"';
	if (empty($td["mine"]) or $td["time_ready"]>$t) $cltd='class=fader onclick="go_confirm(\'down\')"'; else $cltd='onclick="location=\'main.php?minego=down&'.$player->jKey().'\'"';

$x = $player->pers["minex"];
$y = $player->pers["miney"];

	$cells_around = $db->sql("SELECT x,y,time_ready FROM mine WHERE x>=".($player->pers["minex"]-3)." and x<=".($player->pers["minex"]+3)." and y>=".($player->pers["miney"]-2)." and y<=".($player->pers["miney"]+2)." and mine=".$MINE_ID."", __FILE__,__LINE__,__FUNCTION__,__CLASS__);

$maked_str = Array();
while ($cc = mysql_fetch_array($cells_around))
if ($cc["time_ready"]<$t)
 $maked_str[$cc["x"]][$cc["y"]] = 'but';
else
 $maked_str[$cc["x"]][$cc["y"]] = 'inv';

	//if ()
	$cursor .= '<font class=user>Тоннель ['.($player->pers["minex"]).';'.$player->pers["miney"]*(-1).']</font>';

	$t=$t;
	if ($t<$player->pers["waiter"] or $tunnel["time_ready"]>$t)
	{
		if ($t<$tunnel["time_ready"])
		{
			$player->pers["waiter"]=$tunnel["time_ready"];
			set_vars ("waiter='".$tunnel["time_ready"]."'",$player->pers["uid"]);
			$cursor .= "<br><div id=waiter class=items align=center></div><script>waiter(".($player->pers["waiter"]-$t).");</script><br><font class=timef>Раскапывают этот тоннель: ".$tunnel["countp"]."</font>";
		}
		else
		$cursor .= "<br><div id=waiter class=items align=center></div><script>waiter(".($player->pers["waiter"]-$t).");</script>";
	$no_make=1;
	}
	else
	{
	if ($x==0 and $y==0) $mcell = '<b>0</b>'; else $mcell='&nbsp;';
	$cursor = $cursor.'<center><table border="0" width="210" cellspacing="0" cellpadding="0" height="150" class=return_win>
	<tr>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-3][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-2][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-1][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+1][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+2][$y-2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+3][$y-2].'">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-3][$y-1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-2][$y-1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-1][$y-1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x][$y-1].'">
		<img border="0" src="images/battle/up.gif" width="10" height="14" style="cursor:pointer" '.$cltu.'></td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+1][$y-1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+2][$y-1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+3][$y-1].'">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-3][$y].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-2][$y].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-1][$y].'">
		<img border="0" src="images/battle/l.gif" style="cursor:pointer" width="14" height="10" '.$cltl.'></td>
		<td align="center" width=30 height=30 class="inv_but" valign=center>'.$mcell.'</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+1][$y].'">
		<img border="0" src="images/battle/r.gif" style="cursor:pointer" width="14" height="10" '.$cltr.'></td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+2][$y].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+3][$y].'">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-3][$y+1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-2][$y+1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-1][$y+1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x][$y+1].'">
		<img border="0" src="images/battle/down.gif" width="10" height="14" style="cursor:pointer" '.$cltd.'></td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+1][$y+1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+2][$y+1].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+3][$y+1].'">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-3][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-2][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x-1][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+1][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+2][$y+2].'">&nbsp;</td>
		<td align="center" width=30 height=30 class="'.$maked_str[$x+3][$y+2].'">&nbsp;</td>
	</tr>
</table></center>';
	}

	if ($tunnel["r1id"]) $r1 = $db->sqla("SELECT * FROM resources WHERE image='".$tunnel["r1id"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$r1["k"]=$tunnel["r1k"];
	if ($tunnel["r2id"]) $r2 = $db->sqla("SELECT * FROM resources WHERE image='".$tunnel["r2id"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$r2["k"]=$tunnel["r2k"];
	if ($tunnel["r3id"]) $r3 = $db->sqla("SELECT * FROM resources WHERE image='".$tunnel["r3id"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$r3["k"]=$tunnel["r3k"];

if ($player->pers["tire"]>99) $no_make = 1;
$resources = '';
if ($inst) $resources .= '<center class=but>Долговечность кирки: <b>'.$inst["durability"].'</b><br>Шахтёр:<b>'.floor($player->pers["sp7"]).'</b><br>Добыча камней:<b>'.floor($player->pers["sp12"]).'</b></center>';
if ($r1["image"] and ($r1["price"]<2 or $r1["price"]<$player->pers["sp7"]/38) and mtrunc($r1["k"]))
{
if (!$no_make)
$begin = '<input class=login type=button value="[Начать добычу]" onclick="location=\'main.php?beginr='.$r1["image"].'\'">';
else $begin = '';
	$resources .= '<table border=0 width=100%>';
	$resources .= '<tr>';
	$resources .= '<td align=center width=60><img src=images/weapons/resources/'.$r1["image"].'.gif></td>';
	$resources .= '<td class=items><font class=user>[
	'.$r1["name"].']</font><br>Единица: <b>'.$r1["name_of_once"].'</b>';
	$resources .= '<br> Цена: <b>'.floor($r1["price"]).' LN</b><br> Обнаружено: <b>'.$r1["k"].'</b>&nbsp;единиц<br>'.$begin.'</td>';
	$resources .= '</tr>';
	$resources .= '</table>';
}
if ($r2["image"] and ($r2["price"]<2 or $r2["price"]<$player->pers["sp7"]/38) and mtrunc($r2["k"]))
{
if (!$no_make) $begin = '<input class=login type=button value="[начать добычу]" onclick="location=\'main.php?beginr='.$r2["image"].'\'">'; else $begin = '';
	$resources .= '<table border=0 width=100%>';
	$resources .= '<tr>';
	$resources .= '<td align=center width=60><img src=images/weapons/resources/'.$r2["image"].'.gif></td>';
	$resources .= '<td class=items><font class=user>[
	'.$r2["name"].']</font><br>Единица: <b>'.$r2["name_of_once"].'</b>';
	$resources .= '<br> Цена: <b>'.floor($r2["price"]).' <img src=images/money.gif></b><br> Обнаружено: <b>'.$r2["k"].'</b>&nbsp;единиц<br>'.$begin.'</td>';
	$resources .= '</tr>';
	$resources .= '</table>';
}
if ($r3["image"] and ($r3["price"]<2 or $r3["price"]<$player->pers["sp7"]/38) and mtrunc($r3["k"]))
{
if (!$no_make) $begin = '<input class=login type=button value="[начать добычу]" onclick="location=\'main.php?beginr='.$r3["image"].'\'">'; else $begin = '';
	$resources .= '<table border=0 width=100%>';
	$resources .= '<tr>';
	$resources .= '<td align=center width=60><img src=images/weapons/resources/'.$r3["image"].'.gif></td>';
	$resources .= '<td class=items><font class=user>[
	'.$r3["name"].']</font><br>Единица: <b>'.$r3["name_of_once"].'</b>';
	$resources .= '<br> Цена: <b>'.floor($r3["price"]).' <img src=images/money.gif></b><br> Обнаружено: <b>'.$r3["k"].'</b>&nbsp;единиц<br>'.$begin.'</td>';
	$resources .= '</tr>';
	$resources .= '</table>';
}
if (!$resources) $resources .= 'Вы не обнаружили здесь никаких ресурсов.';
$resources .= '<br><i class=timef>Уже добыто</i>';
$resources .= '<table border=0 width=100% class=LinedTable>';
$_r = $db->sql("SELECT * FROM wp WHERE type='resources' and uidp='".$player->pers["uid"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
while ($v = mysql_fetch_array($_r,MYSQL_ASSOC))
{
	$resources .= "<tr>";
	$resources .= "<td class=user>".$v["name"]."</td>";
	$resources .= "<td class=timef width=100><img src=images/money.gif> ".$v["price"]."</td>";
	$resources .= "</tr>";
}
$resources .= '</table>';
//else  $resources = '<img src="service/_gameplay_SYMBOLS.php?code='.md5($lastom_new).'"><br><input class=login type=text name=code value="" id=code>'.$resources;

?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td class=fightlong align=center width=30% valign=top>
<script>
show_only_hp(<?=$player->pers["chp"];?>,<?=$player->pers["hp"];?>,<?=$player->pers["cma"]?>,<?=$player->pers["ma"]?>);
ins_HP(<?=$player->pers["chp"]?>,<?=$player->pers["hp"]?>,<?=$player->pers["cma"]?>,<?=$player->pers["ma"]?>, <?=$sphp?>, <?=$spma?>);
</script>
<?
	echo "<font class=green>Усталость: <b>".floor($player->pers["tire"])."%</b></font><br>";
	if ($player->AuraSpecial[14] and $x==0 and $y==0)
		echo "<center class=but><input type=button class=login onclick=\"location='main.php?outmine=".$MINE_ID."&".$player->jKey()."'\" value='Подняться из шахты' style='width:80%'><br>Осталось ".tp($player->AuraSpecial[14]).".</center>";
	else

?>
<hr><?= $help;?></td>
<td align=center class=but width=300 valign=top style="background-image:url('../images/locations/mine<?php echo (date("i")%5+1);?>.jpg');background-repeat:no-repeat;"><div style="z-index:2;position:relative;width:100%;text-align:center;" class=alt id=mainbox><form method="POST" action=main.php><input type="submit" value="Обновить" class="login" style="width:96%"></form></div></td>
<td class=fightlong align=center width=30% valign=top><b><i>Обнаруженные ресурсы:</i></b><br>
<?
if ($player->pers["tire"]<100) echo $resources; else echo "Вы слишком устали.";
?>
</td>
</tr>
</table>
<div id=inf_from_php style="position:absolute;display:none;"><?= $cursor;?><?=$r_get;?></div>

<script>
build_mine();
function go_confirm(where)
{
	if (confirm("Вы действительно хотите раскопать новый тоннель?"))
	location = 'main.php?minego='+where+'&<?=$player->jKey();?>';
}
</script>
