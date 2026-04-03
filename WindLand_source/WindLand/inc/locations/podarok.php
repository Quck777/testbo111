<center>
  <img src='images/dajma.jpg' border="0" /><br />
<input type=button onClick="location='main.php?year=1'" style='width: 150;' value="Получить Подарок" title="Чтоб получить подарок, нажмите на кнопку" class=login>
<br />
<?
function item_name_ny($id)
{
	$itm= $GLOBALS['db']->sqla("SELECT name FROM weapons WHERE id='".$id."'");
	return $itm['name'];
}
if ($_GET["year"]=='1')
{
	$podarok = rand(1,4);
	if ($podarok=='1')
	{
		$prize='333358';
		$msg = item_name_ny(333358);
	}
	else if ($podarok=='2')
	{
		$prize='333351';
		$msg = item_name_ny(333351);
	}
	else if ($podarok=='3')
	{
		$prize='333357';
		$msg = item_name_ny(333357);
	}
	else if ($podarok=='4')
	{
		$prize='333356';
		$msg = item_name_ny(333356);
	}
	else if ($podarok=='5')
	{
		$prize='333349';
		$msg = item_name_ny(333349);
	}
	else if ($podarok=='6')
	{
		$pod = '`money`='.$player->pers['money'].'+"10000"';
		$msg = '10000 LN';
	}
	else if ($podarok=='7')
	{
		$pod = '`imoney`='.$player->pers['money'].'+"2000"';
		$msg = '2000 IM';
	}
	if ($player->pers['podarok']=='0')
	{
		$db->sql("UPDATE users SET podarok='1' WHERE uid='".$player->pers["uid"]."'");
		$db->sql("UPDATE wp SET timeout=".(tme()+604800)." WHERE id=".insert_wp($prize,$player->pers["uid"],-1,0,$player->pers["user"]));
		echo"<font color=green><b>Администрация <b>cb662053.tw1.ru</b> поздравляет Вас с регистрацией и вручает подарок:) <br>Вы получили в подарок: ".$msg."</b></font>";
	}
	else
	{
		echo"<font color=red><b>Вы уже получили подарок</b></font>";
	}
}
/*if($_GET["asd"]<>'')
{
sql("UPDATE wp SET timeout=".(time()+604800)." WHERE id=".insert_wp(836,1293,-1,0,"АриноЧка"));	
echo"Все удачно";
}*/
?>
</center>