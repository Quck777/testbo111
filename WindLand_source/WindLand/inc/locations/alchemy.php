<center>
<?php
	if (@$http->get["buy_alchemy"] and $http->get["buy_alchemy"]==1 and $player->pers["s5"]>14 and $player->pers["money"]>99)
	{
		$db->sql("UPDATE users SET alchemy_d=alchemy_d+30, money=money-100 WHERE uid=".$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили дистиллятор.</font>";
	}
	if (@$http->get["buy_alchemy"] and $http->get["buy_alchemy"]==2 and $player->pers["s5"]>29 and $player->pers["money"]>299)
	{
		$db->sql("UPDATE users SET alchemy_d=alchemy_d+100, money=money-300 WHERE uid=".$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили дистиллятор.</font>";
	}
	if (@$http->get["buy_alchemy"] and $http->get["buy_alchemy"]==3 and $player->pers["s5"]>17 and $player->pers["money"]>119)
	{
		$db->sql("UPDATE users SET alchemy_m=alchemy_m+100, money=money-120 WHERE uid=".$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили ступку.</font>";
	}
	if (@$http->get["buy_alchemy"] and $http->get["buy_alchemy"]==4 and $player->pers["money"]>=4*abs(intval($http->get["count"])) and mtrunc($http->get["count"]))
	{
		$db->sql("UPDATE users SET alchemy_b=alchemy_b+".abs(intval($http->get["count"])).", money=money-".abs(intval($http->get["count"]))."*4 WHERE uid=".$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили ".abs(intval($http->get["count"]))." шт. пустых ёмкостей.</font>";
	}
?>
</center>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="54" class="lbutton">
		<img border="0" src="http://<?php echo IMG;?>/weapons/potions/d.gif" width="54" height="100"></td>
		<td class="lbutton">Дистиллятор. Долговечность [30/30]<p>
		Стоимость 100<b>LN</b><br>Интеллект 15<br>
		<?
			if ($player->pers["s5"]>14 and $player->pers["money"]>99)
			echo "<input type=button class=laar value=Купить onclick='location=\"main.php?buy_alchemy=1\"'>";
		?>
		</td>
		<td width="54" class="lbutton">
		<img border="0" src="http://<?php echo IMG;?>/weapons/potions/d.gif" width="54" height="100"></td>
		<td class="lbutton">Дистиллятор. Долговечность [100/100]<p>
		Стоимость 300<b>LN</b><br>Интеллект 30<br>
		<?
			if ($player->pers["s5"]>29 and $player->pers["money"]>299)
			echo "<input type=button class=laar value=Купить onclick='location=\"main.php?buy_alchemy=2\"'>";
		?></td>
	</tr>
	<tr>
		<td width="54" class="lbutton">
		<img border="0" src="http://<?php echo IMG;?>/weapons/potions/m.gif" width="70" height="70"></td>
		<td class="lbutton">Ступка. Долговечность [100/100]<p>
		Стоимость 120<b>LN</b><br>Интеллект 18<br>
		<?
			if ($player->pers["s5"]>17 and $player->pers["money"]>119)
			echo "<input type=button class=laar value=Купить onclick='location=\"main.php?buy_alchemy=3\"'>";
		?></td>
		<td width="54" align="center" class="lbutton"><img border="0" src="http://<?php echo IMG;?>/weapons/potions/0.gif" width="37" height="60"></td>
		<td class="lbutton">Пустая ёмкость для зелья.<p>Стоимость 4<b>LN</b></p>
		<br>
		<?
			if ($player->pers["money"]>0)
			echo "<input type=text id=count value=1 class=laar size=2><input type=button class=laar value=Купить onclick=\"sbm();\">";
		?></td>
	</tr>
</table>
<Script>
function sbm()
{
	location = 'main.php?buy_alchemy=4&count='+document.getElementById('count').value;
}
</script>
<div class=but>
<p>Помощь: Дистиллятор нужен для приготовления зелий из растительных 
ингредиентов (1 приготовленное зелье убавляет 1 долговечности у дистиллятора).<br> Cтупка 
требуется для размягчение стеблей растений и плодов. <br><i>В случае если у вас уже есть дистиллятор или ступка, то долговечность купленного дистиллятора прибавится к долговечности вашего дистиллятора</i><br>
<b>Если у вас имеется рабочий дистиллятор ,ступка и пустые ёмкости ,то вы можете видеть активную кнопку в вашем инвентаре ("Алхимия").</b></p>
</div>