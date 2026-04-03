<?php
if (@$http->post["dk"])
{
	$dk = abs($http->post["dk"]);
	if ($dk<=$player->pers["dmoney"]){
	$db->sql("UPDATE users SET money=money+".($dk*$ye_to_ln).", dmoney=dmoney-".$dk." WHERE uid='".$player->pers["uid"]."'");
	$player->pers["money"]+=$dk*$ye_to_ln;
	$player->pers["dmoney"]-=$dk;
	}
	echo "<script>location='main.php';</script>";
}
if (@$http->post["dmoney"])
{
	$dk = abs($http->post["dmoney"]);
	if ($dk<=$player->pers["dmoney"]){
	$db->sql("UPDATE users SET dmoney=dmoney-".$dk." WHERE uid='".$player->pers["uid"]."'");
	$db->sql("UPDATE clans SET dmoney=dmoney+".$dk." WHERE sign='".$player->pers["sign"]."'");
	$player->pers["dmoney"]-=$dk;
	echo "<script>location='main.php';</script>";
	}
}
if (isset($http->get['gopers']) and $http->get["gopers"]=="service")
{
	if ( isset($http->get['do']) and $http->get["do"]=="healthy" and $player->pers["dmoney"]>=1)
	{
		if($player->pers["level"]<=15)
			$player->pers["dmoney"]-=0.25;
		else
			$player->pers["dmoney"]--;
		$player->pers["chp"]=$player->pers["hp"];
		$player->pers["cma"]=$player->pers["ma"];
		$db->sql("UPDATE users SET chp=hp,cma=ma,dmoney=".$player->pers["dmoney"]." WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="notravm" and $player->pers["dmoney"]>=1)
	{
		$player->pers["dmoney"]--;
			$db->sql("UPDATE p_auras SET esttime=0 WHERE uid=".$player->pers["uid"]." and special>2 and special<6 and esttime>".tme().";");
			$db->sql("UPDATE users SET dmoney=dmoney-1 WHERE uid=".$player->pers["uid"]);
			echo "<script>location='main.php';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="zeroing" and $player->pers["dmoney"]>=5)
	{
		$player->pers["dmoney"]-=5;
		$player->pers["zeroing"]++;
		$db->sql("UPDATE users SET zeroing=zeroing+1,dmoney=dmoney-5 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}	
	if ( isset($http->get['do']) and $http->get["do"]=="szeroing" and $player->pers["dmoney"]>=20)
	{
		$player->pers["dmoney"]-=20;
		$player->pers["zeroing"]++;
		$db->sql("UPDATE users SET skill_zeroing=skill_zeroing+1,dmoney=dmoney-20 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="fz" and $player->pers["dmoney"]>=10)
	{
		$player->pers["dmoney"]-=10;
		$db->sql("UPDATE users SET dmoney=dmoney-10,action=-11 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="obr" and $player->pers["dmoney"]>=1)
	{
		$player->pers["dmoney"]--;
		$player->pers["obr"]=0;
		$db->sql("UPDATE users SET obr=0,dmoney=dmoney-1 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php?gopers=options';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="tire" and $player->pers["dmoney"]>=1)
	{
		$player->pers["dmoney"]--;
		$player->pers["tire"]=0;
		$db->sql("UPDATE users SET tire=0,dmoney=dmoney-1 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php?gopers=options';</script>";
	}
	if ( isset($http->get['do']) and $http->get["do"]=="prg" and $player->pers["dmoney"]>=5)
	{
		$player->pers["dmoney"]-=5;
		$db->sql("UPDATE users SET coins=coins+10,dmoney=dmoney-5 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}
	/*
	if ( isset($http->get['do']) and $http->get["do"]=="bot" and $player->pers["dmoney"]>=0.05)
	{
		$player->pers["dmoney"]-=0.05;
		$db->sql("UPDATE users SET lb_attack=0,dmoney=dmoney-0.05 WHERE uid=".$player->pers["uid"]);
		echo "<script>location='main.php';</script>";
	}	
	if ( isset($http->get['do']) and $http->get["do"]=="bot3" and $player->pers["dmoney"]>=0.1)
	{
		$player->pers["dmoney"]-=0.1;
		$db->sql("UPDATE users SET dmoney=dmoney-0.1 WHERE uid=".$player->pers["uid"]);
		$SPECIAL_pers = $pers;
		$SPECIAL_count = 3;
		include("bots/attack.php");
	}
	if ( isset($http->get['do']) and $http->get["do"]=="bot6" and $player->pers["dmoney"]>=0.2)
	{
		$player->pers["dmoney"]-=0.2;
		$db->sql("UPDATE users SET dmoney=dmoney-0.2 WHERE uid=".$player->pers["uid"]);
		$SPECIAL_pers = $pers;
		$SPECIAL_count = 6;
		include("bots/attack.php");
	}
	*/
}
if (@$http->post["user"] and $player->pers["dmoney"]>=100 and false)
{
	$err=0;
	if (strlen($http->post["user"])<3 or strlen($http->post["user"])>21) {print "Некорректный Логин.(Величина)<hr>"; $err=1;}
	if (strpos(" ".$http->post["user"],"~")>0 or
		strpos(" ".$http->post["user"],"!")>0 or
		strpos(" ".$http->post["user"],"@")>0 or
		strpos(" ".$http->post["user"],"#")>0 or
		strpos(" ".$http->post["user"],"$")>0 or
		strpos(" ".$http->post["user"],"%")>0 or
		strpos(" ".$http->post["user"],"^")>0 or
		strpos(" ".$http->post["user"],"*")>0 or
		strpos(" ".$http->post["user"],"(")>0 or
		strpos(" ".$http->post["user"],")")>0 or
		strpos(" ".$http->post["user"],"№")>0 or
		strpos(" ".$http->post["user"],";")>0 or
		strpos(" ".$http->post["user"],"?")>0 or
		strpos(" ".$http->post["user"],":")>0 or
		strpos(" ".$http->post["user"],"`")>0 or
		strpos(" ".$http->post["user"],"'")>0 or
		strpos(" ".$http->post["user"],"\"")>0
		) {print "Некорректный Логин.(Нельзя использовать специальные символы в нике)<hr>"; $err=1;}
	if ($err==0)	
	{
		$db->sql("UPDATE users SET smuser=LOWER('".$http->post["user"]."'),user='".$http->post["user"]."',dmoney=dmoney-100 WHERE uid=".$player->pers["uid"]);
		$_SESSION["user"]=$http->post["user"];
	}
	echo "<script>location='main.php';</script>";
}

//echo "<center><a href='main.php?gopers=sms' class=Button>SMS-Сервис</a> для пополнения счёта.</center>";

	$req = $db->sqlr("SELECT `uid` FROM `avatar_request` WHERE uid=".$player->pers["uid"]);
	if (@$_FILES and !$req and $player->pers["dmoney"]>=30)
	{
	/*
		if ($_FILES['obr']['type']=='image/gif')
		{
			$im = @imagecreatefromgif ($_FILES['obr']['tmp_name']);
			if ($im) 
			{
				$filename = $_FILES['obr']['tmp_name'];
				list($width, $height) = getimagesize($filename);
				$newwidth = 115;
				$newheight = 255;
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagegif ($thumb, IMG_ROOT."/tmp/ava_".$player->pers["uid"].".gif");
				$db->sql("INSERT INTO `avatar_request` (`uid`) VALUES ('".$player->pers["uid"]."');");
				set_vars("dmoney=dmoney-30",$player->pers["uid"]);
				$req = 1;
			}
		}
		if (eregi('image/?jpeg',$_FILES['obr']['type']))
		{
			$im = imagecreatefromjpeg ($_FILES['obr']['tmp_name']);
			if ($im) 
			{
				$filename = $_FILES['obr']['tmp_name'];
				list($width, $height) = getimagesize($filename);
				$newwidth = 115;
				$newheight = 255;
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagegif($thumb,IMG_ROOT."/tmp/ava_".$player->pers["uid"].".gif");
				$db->sql("INSERT INTO `avatar_request` (`uid`)VALUES ('".$player->pers["uid"]."');");
				set_vars("dmoney=dmoney-30",$player->pers["uid"]);
				$req = 1;
			}
		}
	*/
		$imageinfo = getimagesize($_FILES["obr"]["tmp_name"]);
		if( $imageinfo["mime"] == "image/gif" or $imageinfo["mime"] == "image/jpeg" )
		{
			list($width, $height) = $imageinfo;
			
			if ( $width == 115 and $height == 255 )
			{
				if ( move_uploaded_file($_FILES['obr']['tmp_name'],IMG_ROOT."/tmp/ava_".$player->pers["uid"].".gif") )
				{
					$db->sql("INSERT INTO `avatar_request` (`uid`)VALUES ('".$player->pers["uid"]."');");
					set_vars("dmoney=dmoney-30",$player->pers["uid"]);
					echo 'Образ успешно загружен. Ожидайте подтверждения.';
				} else echo 'Ошибка загрузки.';
			} else echo 'Неверный размер изображения. Требуемый формат 115х255.';
		} else echo 'Неверный формат изображения. Принимаются только изображения .gif и .jpeg';
		if ($req==1) msg_admin('Персонаж <b>'.$player->pers['user'].'</b> загрузил индивидуальный образ!');
	}
	
	echo "<table border=0 class=but2 width=100%>";
	if(!$req)
	{
		echo '<tr>
			<td class=but><b class=ma>Загрузить образ<br>[30 БР.]</b><br><i class=gray>Если образ не будет одобрен - деньги вернутся назад.</i></td>
			<td class=but>
			<form enctype="multipart/form-data" method=post><input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input class="login" name="obr" type=file>
			';
		if($player->pers["dmoney"]>=30)
			echo '<input type=submit class=login value="Загрузить...">';
		else	
			echo '<input type=submit class=login value="Загрузить..." DISABLED>';
			echo '</form><br/>.gif или .jpeg 115х255, не более 50кб.</td>
		</tr>';
	}
	else
	{
		echo '<tr>
		<td class=but colspan=3 align=center valign=center>Ожидает одобрения:<br> <img src="http://'.IMG.'/tmp/ava_'.$player->pers["uid"].'.gif" height=100></td>
		</tr>';
	}
	echo "</table>";
	
echo '<form method="POST" action=main.php?gopers=service>
<table border="0" width="100%" cellspacing="5" class="but">
	<tr>
		<td class=timef>Обмен валюты: (1 Бр. = '.$ye_to_ln.' LN)</td>
		<td><input type="text" name="dk" size="10" class=login> Бр.
		<input type="submit" value="Обменять" class="login"></td>
	</tr>';
	/*
echo'<tr>
		<td class=timef>Смена ника (100 Бр.)</td>
		<td><input type="text" name="user" size="26" class=login><input type="submit" value="Сменить" class="login"></td>
	</tr>';
	*/
	if($player->pers["level"]<=15)
	echo '<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=healthy\';}" class=bg>Полное 
		восстановление HP и MA (0.25 Бр.), после 15 уровня (1 БР.)</a></td>
	</tr>';
	else
	echo '<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=healthy\';}" class=bg>Полное 
		восстановление HP и MA (1 Бр.)</a></td>
	</tr>';
	echo '<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=notravm\';}" class=bg>Полное 
		излечение всех травм (1 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=zeroing\'};" class=bg>Обнуление (5 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=szeroing\'};" class=bg>Обнуление мирного умения
		(20 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=tire\';}" class=bg>Снять всю усталость 
		(1 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="javascript:{if(confirm(\'Вы уверены?\')) location=\'main.php?gopers=service&do=prg\';}" class=bg>Купить 10 пергаментов 
		(5 Бр.)</a></td>
	</tr>
		<tr><td colspan=3><a href="javascript:{if(confirm(\'Вы уверены? Уровень станет 0, а все вещи кроме артовых пропадут, деньги обнулятся!\')) location=\'main.php?gopers=service&do=fz\';}" class=bg>Полное обнуление, для 0 уровня (10 Бр.)</a></td></tr>
	';
/*	
		<tr><td colspan=3><a href="main.php?gopers=service&do=bot" class=bg>Приманить существо (0.05 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="main.php?gopers=service&do=bot3" class=bg>Приманить 3 существа (0.1 Бр.)</a></td>
	</tr>
	<tr>
		<td colspan=3><a href="main.php?gopers=service&do=bot6" class=bg>Приманить 6 существ (0.2 Бр.)</a></td>
	</tr>
';
	*/

	if (@$player->pers["sign"]<>'none' and @$player->pers["sign"]<>'watchers') 
	echo "<tr><td class=timef>Вложить валюту в клан</td><td><input type='text' name='dmoney' size='6' class=login><input type='submit' value='Вложить' class='login'></td></tr>";
echo'</table></form>';

echo "<i>Бриллианты можно получить, пожертвовав немного реальных денег персонажам со значком<img src=/images/signs/diler.gif> после ника.</i>";

echo "<hr><center class=inv>Ещё раз предупреждаем, что администрация ни в коем случае не требует с вас каких-либо выплат. Игра была, есть и будет бесплатной онлайн игрой. Любые пожертвования на счёт своего персонажа, ваше личное решение.</center>";
?>