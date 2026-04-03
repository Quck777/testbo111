<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

$ye_to_ln = 2500;
$max_obr = ($player->pers['pol']=='male') ? 20 : 10;


###
if ( isset($http->post['support']) and isset($http->post['title']) )
{
	$sup = substr($http->post['support'],0,1500);
	$tt = substr($http->post['title'],0,50);
	
	if ( $sup == true and $tt == true )
	{
		$db->sql('INSERT INTO `support` (`date`, `uid`, `title`, `text`) VALUES ('.tme().', '.UID.', "'.$tt.'", "'.$sup.'");');
		echo '<div align="center">Спасибо, Ваше сообщение будет рассмотрено в ближайшее время.</div>';
	} else echo '<div align="center">Ошибка! Сообщение не отправлено.</div>';
}
###
?>
<script><?
	if(empty($http->get["gopers"]))
		echo "var _SHOW_EXP = 1;"; 
	else
		echo "var _SHOW_EXP = 0;";
?></script>
<div id=inf_from_php style='display:none;'>
<?
		$level = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($player->pers["level"]+1));
		$level1 = $db->sqla("SELECT * FROM `exp` WHERE `level`=".($player->pers["level"]));

if ($_RETURN)echo "<br><center class=fightlong style='width:60%'><b class=user>".$_RETURN."</b></center>";

if(@$http->get["gopers"]=='battle' and $player->pers["free_stats"]<5 and $player->pers["level"]<3 and $player->pers["chp"]/$player->pers["hp"]>0.75)
{
	$player->pers["waiter"] = tme() + 10;
	echo "<div class=lightblock style='width:70%;'>Сейчас мы подыщем для вас подходящего соперника...</div>";
	
	$bts = $db->sqlr("SELECT uid FROM users WHERE level=".($player->pers["level"])." and block<>'' and rank_i>5 and silence = 0 and lb_attack<".tme()." and s6=1 and s5=1 LIMIT 0,1");
	include("combat_apps/_begin_ghost_fight.php");
	begin_ghost_fight($bts,$player->pers["user"],"Битва на арене",50,120,1,0);
}

	if ($player->pers["priveleged"]) echo '<a class=bg href=main.php?go=administration>Возможности министра['.$priv["status"].']</a>';
	
	if ($t<$player->pers["waiter"]) {echo "<center class=items><b>".$player->pers["user"]."</b></center><hr><div id=waiter class=items align=center></div>";}
	if ($player->pers['mail_good']<>1) echo '<div align="center" class="but" width="90%"><font class=hp>Подтвердите свой E-Mail адрес, <a href="/mail.php" target="_blank">подробнее</a>..</font></div>';
	


if (@$http->post["newchatcolor"] or @$http->post["selectob"]<>"")
{
	if (@$http->post["selectob"]<>0 and $player->pers["obr"]==0 and $http->post["selectob"]<$max_obr) 
	{
		$db->sql ("UPDATE `users` SET `obr`='".$http->post["selectob"]."' WHERE `uid` = ".UID);
		$player->pers["obr"] = $http->post["selectob"];
	}
	if (@$http->post["newchatcolor"])
	{
		$player->pers["options"] = $http->post["inv"]."|".$http->post["zak"]."|".$http->post["sort"]."|".$http->post["chat"]."|".$http->post["dur"]."|".$http->post["newchatcolor"]."|".intval($http->post["design"])."|".$http->post["fchat"];
		$options = explode("|",$player->pers["options"]);
		$db->sql ("UPDATE `users` SET `options`='".$player->pers["options"]."' WHERE `uid` = ".UID);
		echo "<script> top.location = '/game.php?rand=".microtime()."';</script>";
	}
}

if (@$http->post["pass"] and md5($http->post["pass"])==$player->pers["pass"] and $http->post["newpass"]==$http->post["newpass2"] and $player->pers["noaction"]<time()) 
{
	set_vars("`pass`='".(md5($http->post["newpass"]))."', `noaction`=UNIX_TIMESTAMP()+86400");
	$player->pers['noaction'] = time()+86400;
	echo "<font class=red> Ваш Пароль изменён! <br></font>"; 
	$db->sql('INSERT INTO `watch_passmail` (`uid`, `date`, `type`, `text`, `ip`) VALUES ('.$player->pers['uid'].', '.time().', 2, "Главный пароль", "'.show_ip().'");');
	$http->get["gopers"]="parol";	
}
elseif (@$http->post["pass"] and md5($http->post["pass"])<>$_pers["pass"]and $player->pers["noaction"]<time()) echo  "Ваш пароль<font class=red> НЕ </font> изменён. Неверный старый пароль.<br>";
elseif (@$http->post["pass"] and $http->post["newpass"]<>$http->post["newpass2"]and $player->pers["noaction"]<time()) echo  "Ваш пароль<font class=red> НЕ </font> изменён. Пароли не совпадают.<br>";
if (@$http->post["snewpass"] and @$http->post["snewpass"]==$http->post["snewpass2"]and $player->pers["noaction"]<time()) 
{
	set_vars("`second_pass` = '".(md5($http->post["snewpass"]))."',noaction=UNIX_TIMESTAMP()+86400");
	$player->pers["noaction"] = time()+86400;
	echo "<font class=red> Ваш ВТОРОЙ Пароль изменён! <br></font>"; 
	$http->get["gopers"]="parol";
	$db->sql('INSERT INTO `watch_passmail` (`uid`, `date`, `type`, `text`, `ip`) VALUES ('.$player->pers['uid'].', '.time().', 3, "Второй пароль", "'.show_ip().'");');
}
elseif (@$http->post["snewpass"]and $player->pers["noaction"]<tme()) echo  "Ваш пароль<font class=red> НЕ </font> изменён. Пароли не совпадают.<br>";

if (@$http->post["set_flash"]==1 and $player->pers["noaction"]<tme())
{
	$player->pers["flash_pass"] = rand(10000,99999);
	$http->get["gopers"]="parol";
	echo "<div class=return_win>ВНИМАНИЕ!!!<br>Запишите ваш цифровой пароль, и запомните его. При следущем заходе, игра попросит вас ввести его, и если вы его не сможете ввести - вы не сможете управлять персонажем.</div><font class=bnick color=#990000>ТЕКУЩИЙ ПАРОЛЬ: <b>".$player->pers["flash_pass"]."</b></font><br>";
}elseif (@$http->post["set_flash"]==2 and $player->pers["noaction"]<time())
{
	$player->pers["flash_pass"] = 0;
	$http->get["gopers"]="parol";	
}
if (@$http->post["set_flash"]==2 or @$http->post["set_flash"]==1 and $player->pers["noaction"]<time())
{
	$db->sql('INSERT INTO `watch_passmail` (`uid`, `date`, `type`, `text`, `ip`) VALUES ('.$player->pers['uid'].', '.time().', 4, "Flash пароль", "'.show_ip().'");');
	set_vars("flash_pass=".$player->pers["flash_pass"].",noaction=UNIX_TIMESTAMP()+86400");
	$player->pers["noaction"] = time()+86400;
}
if (@$http->post["post_id"]==2)
{
$vcod=$http->post['vcod'];
$con=$db->sql('SELECT * FROM `birja` WHERE `id`='.$vcod.' LIMIT 1;');
$pokup=$db->fetchArray($con);
set_vars ("`dmoney`=dmoney+'".$pokup['dnv']."'",$player->pers['uid']);
$db->sql('UPDATE `users` SET `dmoney`=dmoney+'.$pokup['dnv'].' WHERE `uid`="'.$player->pers['uid'].'"');
		$db->sql('DELETE FROM `birja` WHERE `id`="'.$pokup['id'].'"');
		/*$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Вы убрали ваше предложение о продажи ".$pokup['dnv_kol']." DWL за ".$pokup['dnv_kol']*$pokup['kurs_nv']." WL.</font></b></font>";*/
}
if (@$http->post["test"]==2)
{
$con=$db->sql('SELECT * FROM `birja` WHERE `uid`='.$player->pers['uid'].' LIMIT 1;');
$coun=$db->fetchArray($con);
	$dnv=$http->post['dnv'];
	$kurs=$http->post['kurs'];
	$login = $player->pers['login'];
	
        if($coun>='1'){
		$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Выставлять на продажу больше 1-го лота нельзя</font></b></font>";
	    }elseif(!preg_match("/^[0-9\-_ ]*$/",$dnv)){
		$msg="<b><font class=proce><b>Ошибка! </b><font color=black><b>Мы принимаем только числа</font></b></font>";
		$err=1;
		}elseif(!preg_match("/^[0-9\-_ ]*$/",$kurs)){
		$msg="<b><font class=proce><b>Ошибка! </b><font color=black><b>Мы принимаем только числа</font></b></font>";
		$err=1;
		}elseif($player->pers['dmoney']<$dnv){
		$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Не хватает DWL.</font></b></font>";
		$err=1;
		}
		elseif($dnv<3){
		$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Минимальная сумма для продажи 3 DWL</font></b></font>";
		$err=1;
		}elseif($kurs<500){
		$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Минимальный курс 500 WL</font></b></font>";
		$err=1;
		}elseif($kurs>5000){
		$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Максимальный курс 5000 WL</font></b></font>";
		$err=1;
		}elseif($err != 1){
	$db->sql('UPDATE `users` SET `dmoney`=`dmoney`-"'.$dnv.'" WHERE  `id`="'.$player->pers['uid'].'"');
 $db->sql('INSERT INTO `birja` (`uid_player`,`dnv_kol`,`kurs_nv`,`login`) VALUES ("'.$player->pers['uid'].'","'.$dnv.'","'.$kurs.'","'.$login.'") LIMIT 1;');
			/*$msg="<b><font class=proce><b>Внимание! </b><font color=black><b>Вы сдали на продажу ".$dnv." DWL по курсу ".$kurs." WL</font></b></font>";*/
} 
}



//include("hero/_referal.php");

switch (@$http->get['gopers'])
{
	case 'student': if ($player->pers["level"]>9) include ("hero/student.php"); break;
	case 'info': include("pers/help.html"); break;
	case 'um': include('pers/um.php'); break;
	case 'abilities': include ('inc/inc/characters/abilities.php'); break;
	case 'referals': include ('inc/hero/referals.php'); break;
	case 'parol': include('pers/parol.php'); break;
	case 'options': include('pers/options.php'); break;
	case 'service': include("hero/service.php"); break;
	case 'sms': include("hero/sms.php"); break;
	case 'ref': include('pers/ref.php'); break;
	case 'concurs': include('pers/concurs.php'); break;
	case 'birja': include('pers/birja.php'); break;
	default: include('pers/noact.php'); break;
}

?></div>
<script>
var REF_COMP = false;
<?php
$zv = '';//$db->sqlr ("SELECT name FROM `zvanya` WHERE `id` = '".$player->pers["zvan"]."'");

echo "var DecreaseDamage = ".DecreaseDamage($player->pers).";\n";
$sign_img = ($player->pers['sign']=='watchers') ? 'watch/'.$player->pers['clan_state'] : $player->pers['sign'];
echo "build_pers('".$sh["image"]."','".$sh["id"]."','".$oj["image"]."','".$oj["id"]."','".$or1["image"]."','".$or1["id"]."','".$po["image"]."','".$po["id"]."','".$z1["image"]."','".$z1["id"]."','".$z2["image"]."','".$z2["id"]."','".$z3["image"]."','".$z3["id"]."','".$sa["image"]."','".$sa["id"]."','".$na["image"]."','".$na["id"]."','".$pe["image"]."','".$pe["id"]."','".$or2["image"]."','".$or2["id"]."','".$ko1["image"]."','".$ko1["id"]."','".$ko2["image"]."','".$ko2["id"]."','".$br["image"]."','".$br["id"]."','".$player->pers["pol"]."_".$player->pers["obr"]."',0,'".$sign_img."','".$player->pers["user"]."','".$player->pers["level"]."','".$player->pers["chp"]."','".$player->pers["hp"]."','".$player->pers["cma"]."','".$player->pers["ma"]."',".$player->pers["tire"].",'".$kam1["image"]."','".$kam2["image"]."','".$kam3["image"]."','".$kam4["image"]."','".$kam1["id"]."','".$kam2["id"]."','".$kam3["id"]."','".$kam4["id"]."',".intval($hp).",".$player->pers["hp"].",".intval($ma).",".$player->pers["ma"].",".intval($sphp).",".intval($spma).",".$player->pers["s1"].",".$player->pers["s2"].",".$player->pers["s3"].",".$player->pers["s4"].",".$player->pers["s5"].",".$player->pers["s6"].",".$player->pers["free_stats"].",".round($player->pers["money"],2).",".$player->pers["dmoney"].",".$player->pers["kb"].",".$player->pers["mf1"].",".$player->pers["mf2"].",".$player->pers["mf3"].",".$player->pers["mf4"].",".$player->pers["mf5"].",".$player->pers["udmin"].",".$player->pers["udmax"].",".$player->pers["rank_i"].",'".$zv."',".$player->pers["victories"].",".$player->pers["losses"].",".$player->pers["exp"].",".$player->pers["peace_exp"].",".($level["exp"] - $player->pers["exp"]-$player->pers["peace_exp"]).",".$player->pers["zeroing"].",0,'".$player->pers["diler"]."',".round(($level["exp"]-$player->pers["exp"])*100/($level["exp"]-($level1["exp"]+1))).",'".$ws1."','".$ws2."','".$ws3."','".$ws4."','".$ws5."','".$ws6."',".intval($player->pers["free_f_skills"] + $player->pers["free_p_skills"] + $player->pers["free_m_skills"]).",".intval($player->pers["help"]).",".intval(($player->pers['refc']+$player->pers['referal_counter'])?1:0).",".$player->pers['coins'].",'".$lo['id']."','".$lo['image']."','".$lo['id']."','".$lo['image']."','".$player->pers['imoney']."');";

if(mtrunc($player->pers["waiter"]-$t))
	echo "waiter(".($player->pers["waiter"]-$t).");";

//mod_st_fin();
?>
</script>
<?
$as = $db->sql("SELECT * FROM p_auras WHERE uid=".$player->pers["uid"]."");
$txt = '';
while($a = $db->fetchArray($as))
{
	$txt .= $a["image"].'#<b>'.$a["name"].'</b>@';
	$txt .= 'Осталось <i class=timef>'.tp($a["esttime"]-time()).'</i>';
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
?>