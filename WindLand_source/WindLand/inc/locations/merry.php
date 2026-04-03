<?
function get_uid($user)
{
$row=mysql_fetch_array(mysql_query("SELECT `uid` FROM `users` WHERE `user`='".htmlspecialchars($user)."'"));
return $row[0];
}
function get_merry($user)
{
$row=mysql_fetch_array(mysql_query("SELECT `merry` FROM `users` WHERE `user`='".htmlspecialchars($user)."'"));
return $row[0];
}
//Выполняем Посты by Enternet Acum
if(!empty($_POST))
	{
	$err="0";
	if(!get_uid($_POST["merry1"])){$err="1";$msg="Логин парня не найден";}
	if(!get_uid($_POST["merry2"])){$err="1";$msg="Логин девушки не найден";}
	if($_POST["merry2"]==$_POST["merry1"]){$err="1";$msg="Логины парня и девушки одинаковы";}
	// пункт 1
	if($_POST["cat"]=="1")
	{
	}
	// пункт 2
	else if($_POST["cat"]=="2")
	{
	
	}
	// пункт 3
	else if($_POST["cat"]=="3" and strpos(" ".$pers["rank"],"merry")>"0")
	{
	if($err!="1")
	{
	mysql_query("UPDATE `users` SET `merry`='".get_uid($_POST["merry2"])."' WHERE `uid`='".get_uid($_POST["merry1"])."'");
	mysql_query("UPDATE `users` SET `merry`='".get_uid($_POST["merry1"])."' WHERE `uid`='".get_uid($_POST["merry2"])."'");
	$msg="Заключен брак между ".$_POST["merry1"]." и ".$_POST["merry2"]."";
	say_to_chat ("a","Заключены узы брака между <b>".$_POST["merry1"]."</b> и <b>".$_POST["merry2"]."</b>. //035 ",0,'','*',0);
	}
	}
	// пункт 4
	else if($_POST["cat"]=="4" and strpos(" ".$pers["rank"],"merry")>"0")
	{
	if($err!="1")
	{
	mysql_query("UPDATE `users` SET `merry`='0' WHERE `uid`='".get_uid($_POST["merry1"])."'");
	mysql_query("UPDATE `users` SET `merry`='0' WHERE `uid`='".get_uid($_POST["merry2"])."'");
	$msg="Разорвали узы брака ".$_POST["merry1"]." и ".$_POST["merry2"]."";
	say_to_chat ("a","Разорвали узы брака <b>".$_POST["merry1"]."</b> и <b>".$_POST["merry2"]."</b>. //006 ",0,'','*',0);
	}
	}
	}
?>
<table border="0" width="700" cellspacing="9" cellpadding="0" class="weapons_box" align="center">
  <tr>
    <td align="center" colspan="2"><img src="images/locations/cherch.jpg" width="600" /></td>
  </tr>
<!--  <tr>
    <td align="center" width="50%"><a class="bg" href="main.php?cat=1">Подать документы на свадьбу</a></td>
    <td align="center" width="50%"><a class="bg" href="main.php?cat=2">Подать документы на развод</a></td> 
  </tr> -->
  <?
if(strpos(" ".$pers["rank"],"merry")>"0")
{
 echo'<tr>
    <td align="center" width="50%"><a class="bg" href="main.php?cat=3">Устроить свадьбу</a></td>
    <td align="center" width="50%"><a class="bg" href="main.php?cat=4">Устроить развод</a></td>
  </tr>';
}
?>
  <tr>
    <td class="but" align="center" colspan="2"><?
	if(!empty($msg)){echo'<font class="hp">'.$msg.'</font>';}
	if(!empty($_GET["cat"]))
	{
	if($pers["pol"]=="male"){$ends='цы';}else{$ends='ка';}
	echo'<table cellspacing="0" cellpadding="0" width="70%" align="center">
  <form method="post" action="">
    <tr>';
      if($_GET["cat"]>2)
	  {echo'<td width="30%"><b>Логин парня: </b></td>';}
	  else
	  {echo'<td width="30%"><b>Ваш логин: </b></td>';}
      echo'<td width="70%"><input type="text" name="merry1" value="'.htmlspecialchars($_POST["merry1"]).'" class="but2" style="width:100%" /></td>
    </tr>
    <tr>';
	  if($_GET["cat"]>2)
	  {echo'<td width="30%"><b>Логин девушки: </b></td>';}
	  else
	  {echo'<td width="30%"><b>Логин избранни'.$ends.': </b></td>';}
      echo'<td width="70%"><input type="text" name="merry2" value="'.htmlspecialchars($_POST["merry2"]).'" class="but2" style="width:100%" /></td>
    </tr>
    <tr>
	 <td colspan="2" align="center">';
      if($_GET["cat"]>2)
	  {echo'<input name="submit" type="submit" value="Выполнить" class="but2" style="width:90%;cursor:pointer;" />';}
	  else
	  {echo'<input name="submit" type="submit" value="Подать заявку" class="but2" style="width:90%;cursor:pointer;" />';}
      echo'</td>
    </tr>
    <input type="hidden" name="cat" value="'.htmlspecialchars($_GET["cat"]).'" />
  </form>
</table>';
	}
	?>
    </td>
  </tr>
</table>
