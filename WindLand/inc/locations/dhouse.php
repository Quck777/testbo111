<table width="100%" background="/images/bg.gif" cellpadding="0" height="100%" cellspacing="0" border="0"><tr><td valign="top">
<center><table border=0 width=80%>
<tr>
<td class=return_win align=center>
<?php
//if ($player->pers["user"]!='А вдруг медведь?') exit;

$clan = $player->getClan();

echo "<center class=but>У вас с собой <b>".$player->pers["dmoney"]."  Бр.</b></center>";
echo "<center class=but>На счету клана <b>".$clan["dmoney"]."  Бр.</b></center>";


if (@$http->post["dk2"])
{
	$k=abs(intval($http->post["dk2"]));
	$ye = floor($k/10000);
	if ($k>0 and $k<$player->pers["money"] and $ye>0)
	{
		$k = $ye*10000;
		$db->sql("UPDATE users SET money=money-".$k.", dmoney=dmoney+".$ye." WHERE uid=".$player->pers["uid"]."");
		echo "<div class=return_win>Вы удачно обменяли ".$k."<img src=images/money.gif> на ".$ye." БР.</div>";
	}
}

if (@$http->post["dk"])
{
	$k=abs(intval($http->post["dk"]));
	$ye = floor($k/30);
	if ($k>0 and $k<$player->pers["money"] and $ye>0)
	{
		$k = $ye*30;
		$db->sql("UPDATE users SET money=money-".$k.", coins=coins+".$ye." WHERE uid=".$player->pers["uid"]."");
		echo "<div class=return_win>Вы удачно обменяли ".$k."<img src=images/money.gif> на ".$ye." Паргамент(ов)</div>";
	}
}

//if (@$http->get["c"]=='clan') include("inc/clans_arts.php");
//elseif (@$http->get["c"]=='individual') include("inc/individual.php");
if (@$http->get["c"]=='indap') include("dhouse/indap.php");
//elseif (@$http->get["c"]=='gravirovka') include("inc/gravirovka.php");
else
{

	## Покупаем  вещь
	if (isset($http->get["buy"]))
	{
		$v = $db->sqla("SELECT * FROM `weapons` WHERE `id`='".addslashes($http->get["buy"])."'");
		if ($v["where_buy"]==1) 
		{
			if ($player->pers["dmoney"]<$v["dprice"]) echo "<b><font class=hp>Не хватает денег.</b></font>"; else
			insert_wp($v["id"],$player->pers["uid"],-1,0,$player->pers["user"]);
			$player->pers["dmoney"]-= $v["dprice"];
			set_vars ("`dmoney`='".$player->pers["dmoney"]."'",UID);
			echo "<br><font class=hp>Вы удачно купили \"".$v["name"]."\" за ".$v["dprice"]." y.e.</font>";
		}
	}
	## В клан казну
	if (isset($http->get["sbuy"]) and $clan["treasury"]<($clan["maxtreasury"]+30))
	{
		$v = $db->sqla("SELECT * FROM `weapons` WHERE `id`='".addslashes($http->get["sbuy"])."'");
		if ($v["where_buy"]==1)
		{
			if ($player->pers["dmoney"]<$v["dprice"]) echo "<b><font class=hp>Не хватает денег.</b></font>"; else
			$db->sql("UPDATE wp SET clan_sign='".$player->pers["sign"]."' , clan_name='".$clan["name"]."', present='".$player->pers["user"]."' WHERE id=".insert_wp($v["id"],$player->pers["uid"],-1,0,$player->pers["user"]));
			$player->pers["dmoney"]-= $v["dprice"];
			set_vars ("`dmoney`='".$player->pers["dmoney"]."'",UID);
			$db->sql("UPDATE clans SET treasury=treasury+1 WHERE sign='".$player->pers["sign"]."'");
			echo "<br><font class=hp>Вы удачно купили \"".$v["name"]."\" за ".$v["dprice"]." Бр. в клан казну!</font>";
		}
	}
	## В казну клана
	if (isset($http->get["sfbuy"]) and $clan["treasury"]<($clan["maxtreasury"]+30))
	{
		$v = $db->sqla ("SELECT * FROM `weapons` WHERE `id`='".addslashes($http->get["sfbuy"])."'");
		if ($v["where_buy"]==1 and ($status=='a' or $status=='wg'))
		{
			if ($clan["dmoney"]<$v["dprice"]) echo "<b><font class=hp>Не хватает денег.</b></font>";
			else
			{
				$db->sql("UPDATE wp SET clan_sign='".$player->pers["sign"]."' , clan_name='".$clan["name"]."', present='".$player->pers["user"]."' WHERE id=".insert_wp($v["id"],$player->pers["uid"],-1,0,$player->pers["user"]));
				$clan["dmoney"]-= $v["dprice"];
				$db->sql("UPDATE clans SET `dmoney`='".$clan["dmoney"]."',treasury=treasury+1 WHERE sign='".$player->pers["sign"]."'");
				echo "<br><font class=hp>Вы удачно купили \"".$v["name"]."\" за ".$v["dprice"]." Бр. в клан казну (за счёт клана)!</font>";
			}
		}
	}

	## Аренда.
	if (isset($http->get["ar"]))
	{
		$v = $db->sqla("SELECT * FROM `weapons` WHERE `id`='".addslashes($http->get["ar"])."'");
		if ($v["type"]<>'napad' and $v["type"]<>'zakl' and $v["type"]<>'teleport' and $v["stype"]<>'instrument' and ($vesh["type"]!='prim' or $vesh["index"]!='invis'))
		{
			if ($v["where_buy"]==1)
			{
				if (@$http->get["t"]==1) {$ft = 86400;$kk=0.05;}
				elseif (@$http->get["t"]==3) {$ft = 3*86400;$kk=0.1;}
				elseif (@$http->get["t"]==7) {$ft = 7*86400;$kk=0.15;}
				else {echo "go out!";exit;}
				if ($player->pers["dmoney"]<$v["dprice"]*$kk) echo "<b><font class=hp>Не хватает денег.</b></font>";
				else
				{
					$db->sql("UPDATE wp SET timeout=".(time()+$ft)." WHERE id=".insert_wp($v["id"],$player->pers["uid"],-1,0,$player->pers["user"]));
					$player->pers["dmoney"]-= $v["dprice"]*$kk;
					set_vars("dmoney=".$player->pers["dmoney"]."",$player->pers["uid"]);
					echo "<br><font class=hp>Вы удачно арендовали \"".$v["name"]."\" за ".$v["dprice"]*$kk." Бр.!</font>";
				}
			}
		}
	}
	
	$ti=tme();

	echo '<table border="0" cellpadding="0" width=100%>
		<tr>
			<td align="center" style="border-left-width: 1px; border-right-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px"></td>
		</tr>
		<tr>
			<td align="center">';

	if ($_FILTER["lavkatype"]=="")
	{
		$_FILTER["lavkatype"]='shle';
		$_FILTER["lavkaminlevel"]=0;
		$_FILTER["lavkamaxlevel"]=$player->pers["level"];
		$_FILTER["lavkamaxcena"]=5000;
		$_FILTER["lavkasort"]="price";
	}
?>

<p class=weapons_box>
<img src='images/locations/dd.jpg'>
</p>
<table cellSpacing="0" cellPadding="0" border="0" id="table1" width="510">
<tr>
<td align="middle">
<nobr>
<img title="Ножи" style="cursor: pointer" onclick="location='main.php?set_type=noji'" height="40" src="images/gameplay/shop_icons/noz.png" width="40" border="0">
<img title="Мечи" style="cursor: pointer" onclick="location='main.php?set_type=mech'" height="40" src="images/gameplay/shop_icons/me4i.png" width="40" border="0">
<img title="Дробящее" style="cursor: pointer" onclick="location='main.php?set_type=drob'" height="40" src="images/gameplay/shop_icons/drobja6ee.png" width="40" border="0">
<img title="Топоры" style="cursor: pointer" onclick="location='main.php?set_type=topo'" height="40" src="images/gameplay/shop_icons/topory.png" width="40" border="0">
<img title="Книги заклинаний" style="cursor: pointer" onclick="location='main.php?set_type=book'" height="40" src="images/gameplay/shop_icons/book.png" width="40" border="0">
<img title="Щиты" style="cursor: pointer" onclick="location='main.php?set_type=shit'" height="40" src="images/gameplay/shop_icons/6it.png" width="40" border="0">
<img title="Шлемы" style="cursor: pointer" onclick="location='main.php?set_type=shle'" height="40" src="images/gameplay/shop_icons/6lemi.png" width="40" border="0">

<img title="Кольчуга" style="cursor: pointer" onclick="location='main.php?set_type=kolchuga'" height="40" src="images/gameplay/shop_icons/bronja.png" width="40" border="0">
<img title="Брони" style="cursor: pointer" onclick="location='main.php?set_type=bron'" height="40" src="images/gameplay/shop_icons/bronja.png" width="40" border="0">
<img title="Наручи" style="cursor: pointer" onclick="location='main.php?set_type=naru'" height="40" src="images/gameplay/shop_icons/naru4i.png" width="40" border="0">
<img title="Перчатки" style="cursor: pointer" onclick="location='main.php?set_type=perc'" height="40" src="images/gameplay/shop_icons/per4atki.png" width="40" border="0">
<img title="Пояса" style="cursor: pointer" onclick="location='main.php?set_type=poya'" height="40" src="images/gameplay/shop_icons/pojas.png" width="40" border="0">
<img title="Сапоги" style="cursor: pointer" onclick="location='main.php?set_type=sapo'" height="40" src="images/gameplay/shop_icons/sapogi.png" width="40" border="0">
<img title="Кольца" style="cursor: pointer" onclick="location='main.php?set_type=kolc'" height="40" src="images/gameplay/shop_icons/kolco.png" width="40" border="0">
<img title="Кулоны" style="cursor: pointer" onclick="location='main.php?set_type=kylo'" height="40" src="images/gameplay/shop_icons/kulon.png" width="40" border="0">
</nobr>
</td></tr><tr><td align="middle">
<img title="Свитки заклинаний" style="cursor: pointer" onclick="location='main.php?set_type=zakl'" height="40" src="images/gameplay/shop_icons/svitki.png" width="40" border="0">
<img title="Свитки нападений" style="cursor: pointer" onclick="location='main.php?set_type=napad'" height="40" src="images/gameplay/shop_icons/napadenija.png" width="40" border="0">
<img title="Свитки телепортации" style="cursor: pointer" onclick="location='main.php?set_type=teleport'" height="40" src="images/gameplay/shop_icons/teleport.png" width="40" border="0">
<img title="Руны" style="cursor: pointer" onclick="location='main.php?set_type=rune'" height="40" src="images/gameplay/shop_icons/rune.png" width="40" border="0">
<img title="Фляги восстановления в бою" style="cursor: pointer" onclick="location='main.php?set_type=kam'" height="40" src="images/gameplay/shop_icons/zaklinanija.png" width="40" border="0">
<img title="Зелья алхимические" style="cursor: pointer" onclick="location='main.php?set_type=potion'" height="40" src="images/gameplay/shop_icons/zaklinanija.png" width="40" border="0">
<img title="Рыба и снасти" style="cursor: pointer" onclick="location='main.php?set_type=fishing'" height="40" src="images/gameplay/shop_icons/fish.png" width="40" border="0">
<img title="Инструменты" style="cursor: pointer" onclick="location='main.php?set_type=instrument'" height="40" src="images/gameplay/shop_icons/instruments.png" width="40" border="0">

<img title="Инструменты" style="cursor: pointer" onclick="location='main.php?base=information'" height="40" src="http://legendworld.ru/image/gameplay/shop/other.gif" width="40" border="0">

<!--
<img title="Приманка" style="cursor: pointer" onclick="location='main.php?go=orden&action=items&set_type=primanka'" height="40" src="images/gameplay/shop_icons/primanka.png" width="40" border="0">
<img title="Еда" style="cursor: pointer" onclick="location='main.php?go=orden&action=items&set_type=eda'" height="40" src="images/gameplay/shop_icons/eda.png" width="40" border="0">
<img title="Алкоголь" style="cursor: pointer" onclick="location='main.php?go=orden&action=items&set_type=byxlo'" height="40" src="images/gameplay/shop_icons/byxlo.png" width="40" border="0">
-->
</td>
</tr>
</table>


</td>
</tr>

<tr><td valign="top">
<?php

echo '
<form method="POST" action=main.php>
<table border="0" width="100%" cellspacing="0" class="fightlong">
	<tr>
		<td width="356">Обмен валюты: (30 <img src=images/money.gif> = 1 Пeргамент)</td>
		<td>&nbsp;<input type="text" name="dk" size="10" class=laar>
		LN
		<input type="submit" value="Обменять" class="login"></td>
	</tr>
    	<tr>
		<td width="356">Обмен валюты: (10000 <img src=images/money.gif> = 1 БР.)</td>
		<td>&nbsp;<input type="text" name="dk2" size="10" class=laar>
		LN
		<input type="submit" value="Обменять" class="login"></td>
</tr>
</table>
</form><br>';

if (!$http->get["base"] == 'information' and !$http->get["s"] and !$http->get["class"] and !$http->post["add_image"] and !$http->post["name"] and !$http->get["individs"] and !$http->get["cindivids"])
{
	$lavka = 1;
	if ($_FILTER["lavkatype"]!='napad') $stype = "`stype`='".$_FILTER["lavkatype"]."'";
	else $stype = "`type` = 'napad' ";

	if ($_FILTER["lavkasort"]!='tlevel') $_FILTER["lavkasort"]='price';
	$enures= $db->sql("SELECT * FROM `weapons` WHERE `tlevel`>='".$_FILTER["lavkaminlevel"]."' and `tlevel`<='".$_FILTER["lavkamaxlevel"]."' and `dprice`<='".$_FILTER["lavkamaxcena"]."' and ".$stype." and `where_buy`='1' ORDER BY `".$_FILTER["lavkasort"]."` ASC");
	while ($vesh = $db->fetchArray($enures))
	{
		echo "<div class=weapons_box>";
		$disabled = '';
		if ($vesh["dprice"]>$player->pers["dmoney"]) $disabled = 'DISABLED';
		echo "<div class=but2><input type=button class=inv_but onclick=\"w_buy('".$vesh["id"]."')\" value='Купить' ".$disabled."></div>";
		echo "<div class=but>";
		if ($vesh["type"]<>'napad' and $vesh["type"]<>'zakl' and $vesh["type"]<>'teleport' and $vesh["stype"]<>'instrument' and $vesh["stype"]<>'rune' and $vesh["type"]<>'prim')
		{
			$disabled = '';
			if ($vesh["dprice"]*0.05>$player->pers["dmoney"]) $disabled = 'DISABLED';
			echo "<input type=button class=inv_but onclick=\"location='main.php?ar=".$vesh["id"]."&t=1'\" value='Аренда 1 день [".($vesh["dprice"]*0.05)." Бр.]' ".$disabled."> ";
			$disabled = '';
			if ($vesh["dprice"]*0.1>$player->pers["dmoney"]) $disabled = 'DISABLED';
			echo "<input type=button class=inv_but onclick=\"location='main.php?ar=".$vesh["id"]."&t=3'\" value='Аренда 3 дня [".($vesh["dprice"]*0.1)." Бр.]' ".$disabled."> ";
			$disabled = '';
			if ($vesh["dprice"]*0.15>$player->pers["dmoney"]) $disabled = 'DISABLED';
			echo "<input type=button class=inv_but onclick=\"location='main.php?ar=".$vesh["id"]."&t=7'\" value='Аренда 7 дней [".($vesh["dprice"]*0.15)." Бр.]' ".$disabled."> ";
		}

		$disabled = '';
		if($vesh["dprice"]<=$player->pers["dmoney"] and $player->pers["clan_tr"] and $clan["treasury"]<($clan["maxtreasury"]+30));else $disabled = 'DISABLED';
		echo "<input type=button class=inv_but onclick=\"s_buy('".$vesh["id"]."')\" value='Купить в клан казну' ".$disabled.">";

		$disabled = '';
		if($vesh["dprice"]<=$clan["dmoney"] and ($status=='a' or $status=='wg') and $clan["treasury"]<($clan["maxtreasury"]+30));else $disabled = 'DISABLED';
		echo "<input type=button class=inv_but onclick=\"sf_buy('".$vesh["id"]."')\" value='Купить в клан казну(за счёт клана)' ".$disabled.">";
		echo "</div>";
		include (ROOT.'/inc/inc/weapon.php');
		echo "</div>";
	}
	echo "</td></tr></table>";
}

} ## end base inforomation
## new module starting
include(ROOT."/inc/locations/dhouse/create.php");
?>


<script>
function w_buy (id) {
if (confirm("Вы точно хотите купить эту вещь?"))
location = 'main.php?buy='+id;
}
function s_buy (id) {
if (confirm("Вы точно хотите купить эту вещь в клан-казну?"))
location = 'main.php?sbuy='+id;
}
function sf_buy (id) {
if (confirm("Вы точно хотите купить эту вещь в клан-казну(за счёт клана)?"))
location = 'main.php?sfbuy='+id;
}
</script>
</td>
	</tr>
</table></center>