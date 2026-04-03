<link rel="stylesheet" type="text/css" href="main.css" />
<center>
<h2><?
if ($pers['sign']<>$pers['location']) { sql("UPDATE users SET location='out' WHERE uid=".$pers["uid"]); die('<b><center>Это не ваш замок</b></center>'); echo "<script>location.href='main.php'</script>"; }
echo"Здравствуйте ".$pers["user"].". Вы находитесть в клан замке.";?></h2>
</center>
<center>
<img src="images/locations/kz.jpg">
</center>
<?
if( isset($_POST['healthy'])) sql("UPDATE users SET chp=hp,cma=ma WHERE uid=".$pers["uid"]);	
$sostav = sql ("SELECT user,online,location FROM `users` WHERE `sign`='".$pers['sign']."'");
$online = 0;
$allpers = 0;

while ($perssost = mysql_fetch_array($sostav)) 
{
$online += $perssost["online"];
$allpers ++;
}

echo"
<center><div class=but style='width:300px;'><i>"; 
 if($pers["hp"]<=1){
              echo"<div id=healthy class=but align=center></div>
              <script>healthy(".($pers["hp"]>=10).");</script>";
              }else{ 
			 echo'<form method="post" action=""><center>
              <input name="healthy" class="laar" type="submit" " value="Восстановить HP и MP" title="Чтобы восстановить нажмите на кнопку"  />
              </form></center>';}
echo"<br>
<marquee scrollamount=2 scrolldelay=14><i>Возможности клана будут тестироваться и дорабатываться (by Миросоздатель...).</i></marquee></div></center>

<center><div class=but style='width:300px;'><i>Персонажей в клане</i> : <b>".$allpers."</b><br>
<i>Персонажей онлайн</i> : <b>".$online."</b><br>";


?>

