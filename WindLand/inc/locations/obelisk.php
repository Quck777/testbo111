<table width="100%" background="/images/bg.gif" cellpadding="0" height="100%" cellspacing="0" border="0"><tr><td valign="top">
<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" height="55">
		<table border="0" width="500" cellspacing="0" cellpadding="0" id="table2">
			<tr>
				<td width="900" colspan="5">
				<div style="border-bottom-style: solid; border-bottom-width: 1px; padding-bottom: 1px">
					<p align="center"><b><font class=red>Рейтинги</font></b></div>
				</td>
			</tr>
			<tr>
				<td width="153">
				<p align="center"><b><a class=items href=main.php?cat=1>Рейтинг Игроков</a></b></td>
				<td width="179">
				<p align="center"><b><a class=items href=main.php?cat=2>Таблица рекордов</a></b></td>
				<td width="168">
				<p align="center"><b><a class=items href=main.php?cat=3>Сильнейшие существа</a></b></td>
				<td width="168">
				<p align="center"><b><a class=items href=main.php?cat=5>Рейтинг кланов</a></b></td>
				<td width="200">
				<p align="center"><b><a class=items href=main.php?cat=4>Реферальные ссылки</a></b></td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td align="center" style="border-left-width: 1px; border-right-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-width: 1px"><script>
<?
if (empty($_GET["cat"]) or $_GET["cat"]==1)
$res = $db->sql("SELECT user,level,victories,losses,sign,exp,money,rank,uid FROM `users` WHERE `sign`<>'sl' ORDER BY (level*1000+exp/(victories+losses+1)+exp*(victories-losses)+money-uid*20 + rank*exp) DESC LIMIT 0 , 100");

if ($_GET["cat"]==3)
$res = $db->sql("SELECT user,level,kb,udmax,id FROM `bots` ORDER BY (level*1000+kb*500+udmax+900) DESC LIMIT 0 , 30");



echo "var list=new Array(\n";
$i=0;
while ($row=$db->fetchArray($res)) 
{
if (empty($_GET["cat"]) or $_GET["cat"]==1)
 {
$stats = round(($row["level"]*1000+ $row["exp"]/($row["victories"]+$row["losses"]+1)+$row["exp"]*($row["victories"]-$row["losses"])+$row["money"]-$row["uid"]*20 + $row["exp"]*$row["rank"])/10000);
 $z=0;
 }
if ($_GET["cat"]==3)
 {
 $stats = round($row["level"]*1000+$row["kb"]*500+$row["udmax"]*900);	
 $z=1;
 }

 
 if ($i<>0) echo ",";
 $i++;
 if ($row["sign"]=='') $row["sign"]="none";
 echo "'".$row["user"]."|".$row["level"]."|".$row["sign"]."|".$row["state"]."|".$stats."|".$z."|".$row["id"]."|";
 echo "'";
}
echo ");";
echo "show_list ('0+');";


?>
function show_list()
{
	document.write ('<table width=400 border="0" cellspacing="0" cellpadding="0">');
	for (var i=0;i<list.length;i++) document.write(hero_string(list[i],i+1)); 
	document.write ('</table>');
}
function hero_string (element,a) 
{
 var arr = element.split("|");
 var s;
 var info;
 if (arr[5]==0)
  info = '<img src=images/i.gif onclick="javascript:window.open(\'info.php?p='+arr[0]+'\',\'_blank\')" style="cursor:hand">';
 else
  info = '<img src=images/i.gif onclick="javascript:window.open(\'binfo.php?'+arr[6]+'\',\'_blank\')" style="cursor:hand">';
 s = '<tr><td class=items>'+a+'.</td><td><img src=images/p.gif onclick="javascript:top.say_private(\''+arr[0]+'\')" style=cursor:hand> </td><td> <img src=images/signs/'+arr[2]+'.gif title=\''+arr[3]+'\'><font class=user onclick="javascript:top.say_private(\''+arr[0]+'\')"> '+arr[0]+'</font></td><td>[<font class=lvl>'+arr[1]+'</font>]</td><td>'+info+'</font>';
 s+='</td><td class=ma style="border-left-style: solid; border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-width: 1px"> &nbsp;Очки: '+arr[4];
 s+='</td></tr>';
 return s;
}
</script>
<?
if ($_GET["cat"]==2) 
 {
 $wins = $db->fetchArray($db->sql("SELECT MAX(victories) FROM `users` WHERE sign<>'sl'"));
 $wins_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE `victories`='".$wins[0]."'"));
 $lozes = $db->fetchArray($db->sql("SELECT MAX(losses) FROM `users` WHERE sign<>'sl'"));
 $lozes_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE `losses`='".$lozes[0]."'"));
 $hunt = $db->fetchArray($db->sql("SELECT MAX(round(sp10*10)) FROM `users` WHERE sign<>'sl'"));
 $hunt_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE round(sp10*10)='".$hunt[0]."'"));
 $money = $db->fetchArray($db->sql("SELECT MAX(money) FROM `users` WHERE sign<>'sl'"));
 $money_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE `money`='".$money[0]."'"));
 $f = $db->fetchArray($db->sql("SELECT MAX(victories+losses) FROM `users` WHERE sign<>'sl'"));
 $f_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE victories+losses='".$f[0]."'"));
 $exp = $db->fetchArray($db->sql("SELECT MAX(exp) FROM `users` WHERE sign<>'sl'"));
 $exp_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE exp='".$exp[0]."'"));
 $hp = $db->fetchArray($db->sql("SELECT MAX(hp) FROM `users` WHERE sign<>'sl'"));
 $hp_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE hp='".$hp[0]."'"));
 $ma = $db->fetchArray($db->sql("SELECT MAX(ma) FROM `users` WHERE sign<>'sl'"));
 $ma_u = $db->fetchArray($db->sql("SELECT user,level,sign FROM `users` WHERE ma='".$ma[0]."'"));
	echo '
	<table border="0" width="600" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		побед</span></td>
		<td align="center" class="items">'.$wins[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$wins_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$wins_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$wins_u[0].'\')"> '.$wins_u[0].'</font></td><td>[<font class=lvl>'.$wins_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$wins_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		поражений</span></td>
		<td align="center" class="items">'.$lozes[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$lozes_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$lozes_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$lozes_u[0].'\')"> '.$lozes_u[0].'</font></td><td>[<font class=lvl>'.$lozes_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$lozes_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		умений &quot;Охота&quot;</span></td>
		<td align="center" class="items">'.$hunt[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$hunt_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$hunt_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$hunt_u[0].'\')"> '.$hunt_u[0].'</font></td><td>[<font class=lvl>'.$hunt_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$hunt_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		Игровой Валюты</span></td>
		<td align="center" class="items">'.round($money[0],2).'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$money_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$money_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$money_u[0].'\')"> '.$money_u[0].'</font></td><td>[<font class=lvl>'.$money_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$money_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		боёв</span></td>
		<td align="center" class="items">'.$f[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$f_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$f_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$f_u[0].'\')"> '.$f_u[0].'</font></td><td>[<font class=lvl>'.$f_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$f_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество 
		опыта</span></td>
		<td align="center" class="items">'.$exp[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$exp_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$exp_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$exp_u[0].'\')"> '.$exp_u[0].'</font></td><td>[<font class=lvl>'.$exp_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$exp_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество
		</span><font class=hp>HP</font></td>
		<td align="center" class="items">'.$hp[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$hp_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$hp_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$hp_u[0].'\')"> '.$hp_u[0].'</font></td><td>[<font class=lvl>'.$hp_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$hp_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>
	<tr>
		<td width="294" class="items"><span lang="ru">Самое большое количество
		</span><font class=ma>MA</font></td>
		<td align="center" class="items">'.$ma[0].'</td>
		<td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$ma_u[0].'\')" style=cursor:hand> </td><td> <img src=images/signs/'.$ma_u[2].'.gif><font class=user onclick="javascript:top.say_private(\''.$ma_u[0].'\')"> '.$ma_u[0].'</font></td><td>[<font class=lvl>'.$ma_u[1].'</font>]</td><td><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$ma_u[0].'\',\'_blank\')" style="cursor:hand"></font></td>
	</tr>

</table>';
}




if ($_GET["cat"]==4) 
 {
echo '<div align=center> <table width="600" id="table1" border=0 cellspacing=0 cellpadding=2>';
$res = $db->sql("SELECT user,level,referal_counter,sign FROM `users` WHERE `sign`<>'sl' ORDER BY (referal_counter) DESC LIMIT 0 , 50");
$p=1;
while($row=$db->fetchArray($res))
{
$user=$row[user];
$level=$row[level];
$referal_counter=$row[referal_counter];
echo '<tr><td>'.$p.'.</td><td class="items"><img src=images/p.gif onclick="javascript:top.say_private(\''.$user.'\')" style=cursor:hand>      <b>'.$user.'</b><img src=images/i.gif onclick="javascript:window.open(\'info.php?p='.$user.'\',\'_blank\')" style="cursor:hand"></td><td>['.$level.']</td> <td>Количество переходов:<b>'.$referal_counter.'</b></td></tr>';
$p++;
}

echo '</table></div>'; 
 }


if ($_GET["cat"]==5) 
 {
echo '<div align=center> <table width="600" id="table1" border=0 cellspacing=0 cellpadding=2>';
//error_reporting(E_ALL);
$res = $db->sql("SELECT * FROM `clans` ORDER BY `clans`.`dmoney` DESC LIMIT 0 , 30");
$p=1;
while($row=$db->fetchArray($res))
{
$dmoney=(1234+$row[dmoney]*3)-1234;
$name=$row[name]; 
$level=$row[level]; 
$sait=$row[sait]; 
echo '<tr><td>'.$p.'.</td><td><b><a target=_blank href=http://'.$sait.'/>'.$name.'</a></b></td><td>['.$level.']</td><td>|Очки: '.$dmoney.' </td><td></td><td></td></tr>';
$p++;
}
echo '</table></div>'; 
 }
?>
</td></tr>
</table>
