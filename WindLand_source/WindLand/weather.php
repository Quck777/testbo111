<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
############################## 
include (ROOT.'/inc/func.php');


	function Play($a,$b)
	{
		if (date("H")>21 or date("H")<7)
			echo "<script>top.Play".$a."('".$b."',1);</script>";
		else
			echo "<script>top.Play".$a."('".$b."');</script>";
	}
	$weather = $db->sqla("SELECT weather,weatherchange FROM world");
	$ww = $db->sqla("SELECT * FROM weather WHERE id=".$weather["weather"]."");

	if (date("m")>11 or date("m")<3)
	{
		$season_name = "Зима";
		$season_id = 1;
		if (date("m")==12)
		$changes = tp(mktime(0,0,0,3,1,date("Y")+1) - time());
		else
		$changes = tp(mktime(0,0,0,3,1,date("Y")) - time());
	}elseif (date("m")>2 and date("m")<6)
	{
		$season_name = "Весна";
		$season_id = 2;
		$changes = tp(mktime(0,0,0,6,1,date("Y")) - time());
	}
	elseif (date("m")>5 and date("m")<9)
	{
		$season_name = "Лето";
		$season_id = 3;
		$changes = tp(mktime(0,0,0,9,1,date("Y")) - time());
	}elseif (date("m")>8 and date("m")<12)
	{
		$season_name = "Осень";
		$season_id = 4;
		$changes = tp(mktime(0,0,0,12,1,date("Y")) - time());
	}
	$changew  = 'НЕИЗВЕСТНО';
	if ($weather['weatherchange']>time())
	$changew = tp($weather['weatherchange']-time());
	else
	{
		$ww = $db->sqla("SELECT * FROM weather WHERE season=5 or season=".$season_id." ORDER BY RAND()");
		$weather['weatherchange'] = time() + rand(1,3)*$ww["time"];
		$changew = tp($weather['weatherchange']-time());
		$db->sql("UPDATE world SET weather = ".$ww["id"].", weatherchange = ".$weather["weatherchange"]."");
		say_to_chat("a","Произошла смена погоды:)",0,'','*');
		$db->sql("UPDATE nature SET fish_population=fish_population+fish_population*0.5+".rand(0,100)." WHERE fishing>0 and fish_population<600");
	}
	/*
	$w = $weather["weather"];
	if ($w == 1)
	{
		Play("Summer","hot");
	}
	if ($w == 2)
	{
		Play("Summer","rain");
	}
	if ($w == 3)
	{
		Play("Summer","hrain");
	}
	if ($w == 4)
	{
		Play("Summer","wind");
	}
	if ($w == 5)
	{
		Play("Summer","storm");
	}
	if ($w == 6)
	{
		Play("Summer","fog");
	}
	if ($w == 7)
	{
		Play("Summer","gsnow");
	}
	if ($w == 8)
	{
		Play("Summer","snow");
	}

	*/
	if (date("H")>21 or date("H")<7) $ww["id"]+=10;
?>
<META HTTP-EQUIV="Page-Enter" CONTENT="BlendTrans(Duration=0.5)">
<LINK href="/css/main_v2.css" rel=STYLESHEET type=text/css>
<body style="background-color:transparent;">
<center>
<br>
<br>
<table border="0" width="95%" cellspacing="0" cellpadding="0" style="border-bottom-style: solid; border-top-style: solid; border-top-width: 3px; border-bottom-width: 2px; border-color:#777799" >
	<tr>
		<td align="center" valign="bottom"></td>
		<td align="center"><a href="/frames/ch.php" class=bga>НАЗАД</a></td>
		<td align="center" valign="bottom"></td>
	</tr>
	<tr>
		<td align="center" class="bnick" height="21">&nbsp;</td>
		<td align="center" class="dark" height="21"><b class=user><?= $ww["name"]; ?></b>[<?= $changew; ?>]<br>
		<img border="0" src="/images/weather/seasons/<?=$season_id;?>.gif" width="100" height="100"><img border="0" src="images/weather/<?= $ww["id"]; ?>.gif" width="100" height="100"><br><?= str_replace(';','<br>',$ww["describe"]); ?></td>
		<td align="center" class="bnick" height="21">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#AAAAAA" height=4></td>
		<td align="center" bgcolor="#AAAAAA" height=4></td>
		<td align="center" bgcolor="#AAAAAA" height=4></td>
	</tr>
	<tr>
		<td align="center" class="bnick" valign="top"></td>
		<td align="center" class="about"><b class=user><?=$season_name;?></b>[<?=$changes?>]<br>
		</td>
		<td align="center" class="bnick" valign="top"></td>
	</tr>
</table>
</center>
<script>
var interv = setTimeout("location = '/frames/ch.php?rand="+Math.random()+"'",15000);
</script>
</body>