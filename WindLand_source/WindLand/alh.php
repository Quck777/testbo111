<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp;
############################## 

include (ROOT.'/inc/func.php');

$ra = Array();

$h = $db->sql("SELECT `name`,`image` FROM `herbals` ORDER BY `image`");

while ( $r = mysql_fetch_row($h) )
{
	$ra[$r[1]] = $r[0];
}


function genet($d)
{
	GLOBAL $ra,$http;
	$s = '';
	foreach ( $ra as $k=>$v ) $s.= '<option value="'.$k.'" '.((@$http->get['k'.$d]==$k) ? 'selected' : '').'>'.$v.'</option>';
	return $s;
}

if ( isset($http->get['ins_zel']) and @$_COOKIE['uid']==7 )
{
	$puid = 7;
	foreach ( $ra as $k=>$v ) 
	{

		$herbal = $k;
		$rname = $v;
		$lastid = (int)$db->sqlr("SELECT MAX(id) FROM wp");
		$lastid = 1+$lastid;
		$db->sql("INSERT INTO `wp` ( `id` , `uidp` , `weared` ,`id_in_w`, `price` , `dprice` , `image` , `index` , `type` , `stype` , `name` , `describe` , `weight` , `where_buy` , `max_durability` , `durability` ,`p_type`, `timeout`) VALUES ('".$lastid."', '".$puid."', '0','','1', '0', 'herbals/".intval($herbal)."', '', 'herbal', 'herbal', '".$rname."', '', '1', '0', '1', '1','200',".(time()+1200000).");");
	}
}


$umelka = isset($http->get['um']) ? intval($http->get['um']) : 1000;
if ($umelka>2300) $umelka = 2300;

?>
<LINK href="/css/main_v2.css" rel=STYLESHEET type=text/css>
<form action="?" method="GET" align="center">
	<input type="hidden" name="do" value="1">
	<select name="k1"><option value="0"></option><?php echo genet(1);?></select>
	<select name="k2"><option value="0"></option><?php echo genet(2);?></select>
	<select name="k3"><option value="0"></option><?php echo genet(3);?></select>
	<select name="k4"><option value="0"></option><?php echo genet(4);?></select>
	<input type="text" name="um" value="<?php echo $umelka;?>">
	<input type="submit">
</form>
<?php

if ( !isset($http->get['do'])) exit; 

	foreach ( $_GET as $k=>$v ) $g[$k] = ($v>0) ? intval(abs($v)) : 0;
	
	$all = Array ($g['k1'], $g['k2'], $g['k3'], $g['k4']);
	
	$rcount = 0;
	if ($g['k1']>0) $rcount++;
	if ($g['k2']>0) $rcount++;
	if ($g['k3']>0) $rcount++;
	if ($g['k4']>0) $rcount++;
	
	
	$id1 = $all[0];
	$id2 = $all[1];
	$id3 = $all[2];
	$id4 = $all[3];
	
	
	$rsumm = $id1 + $id2 + $id3 + $id4;
	
//	for ($i=0; $i<count($all); $i++) $rsumm += intval($all[$i]);
	
	

	$z = 100;
	if ($id1==8 and $id2==19 and $id3==20 and $id4==33) $z=14;
	if ($id1==1 and $id2==28 and $id3==33 and $id4==89) $z=15;
	if ($id1==7 and $id2==34 and $id3==35 and $id4==36) $z=16;
	if ($id1==58 and $id2==63 and $id3==68 and $id4==82) $z=17;
	if ($id1==30 and $id2==39 and $id3==71 and $id4==99) $z=18;
	if ($id1==12 and $id2==72 and $id3==75 and $id4==83) $z=19;
	if ($id1==86 and $id2==24) $z=20;
	if ($id1==63 and $id2==93 and $id3==96) $z=21;
	
	if( $rcount>1 )
	{
		if ($z<>100)
			$z = $db->sqla("SELECT image,name,param FROM potions WHERE image=".$z."");
		else
			$z = $db->sqla("SELECT image,name,param FROM potions WHERE image%30=".($rsumm%30));
	}
	
	$koef = 0.4*sqrt($rcount/2);
	if ($id1%30==0)
	{
		if (($id1+$id4)%50==0)$koef+=0.5;
		if (($id1+$id3)%50==1)$koef+=0.5;
		if (($id1+$id2)%50==2)$koef+=0.5;
	}
	if ($id2<>0) $umelka+=10;
	if ($id3<>0) $umelka+=20;
	if ($id4<>0) $umelka+=30;
	if ($z["image"])
	{
		$a = 0;
		if (substr($z["param"],0,1)=='s')
		$a = $umelka/80+1;
		if (substr($z["param"],0,1)=='m' and $z["param"]<>'mf5')
		$a = $umelka/6.5+30;
		if ($z["param"]=='mf5' or $z["param"]=='udmax' or $z["param"]=='kb')
		$a = $umelka/65+5;
		if ($z["param"]=='hp' or $z["param"]=='ma')
		$a = intval($umelka/6+50);
		$a = $a*$koef;
		if ($id2==0) $a = $a*(1+floor($id1/60));
		$time = $umelka*4+300;
		if ($id1==1 or $z["image"]==20) $time+=1800;
		$price = rand(1,10)+$umelka/100+20;
		$a=round($a);
		$time = round($time);
		$price = round($price);
		$param[1] = $z["param"];
		if ($param[1]=="s1")$sk = "Сила";
		if ($param[1]=="s2")$sk = "Реакция";
		if ($param[1]=="s3")$sk = "Удача";
		if ($param[1]=="s4")$sk = "Здоровье";
		if ($param[1]=="s6")$sk = "Сила воли";
		if ($param[1]=="kb")$sk = "Класс брони";
		if ($param[1]=="hp")$sk = "HP";
		if ($param[1]=="ma")$sk = "МАНА";
		if ($param[1]=="udmax")$sk = "Удар";
		if ($param[1]=="mf1")$sk = "Сокрушение";
		if ($param[1]=="mf2")$sk = "Уловка";
		if ($param[1]=="mf3")$sk = "Точность";
		if ($param[1]=="mf4")$sk = "Стоикость";
		if ($param[1]=="mf5")$sk = "Ярость";
		if ($a>=0) $b="+".$a;
		if ($a<0) $b="-".abs($a);
		$sk = "".$sk." <b>".$b."</b>";
		if ($z["image"]>13)
		{
			$a = intval($umelka/35)*($koef+0.6);
		}
		$a = floor($a);
		$time = floor($time/(15*60))*15*60;
		if ($z["image"]==21) {$a*=2;$time=1;}
		if ($z["image"]==14) $sk = "Удар +<b>".$a."%</b>";
		if ($z["image"]==15) $sk = "Класс брони +<b>".$a."%</b>";
		if ($z["image"]==16) $sk = "Сила воли +<b>".$a."%</b><br>Мана +<b>".($a-5)."%</b>";
		if ($z["image"]==17) $sk = "Сила +<b>".$a."%</b><br>HP +<b>".($a-5)."%</b>";
		if ($z["image"]==18) $sk = "Реакция +<b>".$a."%</b><br>Удача +<b>".$a."%</b><br>Уловка +<b>".$a."%</b><br>Сокрушение +<b>".$a."%</b>";
		if ($z["image"]==19) $sk = "Невидимость";
		if ($z["image"]==21) $sk = "Усталость -<b>".$a."</b>";

		echo "<center class=but><font class=green><img src=http://".IMG."/weapons/potions/".$z["image"].".gif><br />Удачно сварено «".$z["name"]."»!</font><br /></b>";
		echo $sk;
		echo '<br />Цена: <b>'.$price.'</b> LN';
		echo '<br />Время действия: <b>'.tp($time).'</b>';
		echo "</center>";
	}
	else echo "<center class=but><b class=red>Неудачно подобранные компоненты</b></center>";
	
	echo "<br /><br /><center class=but>
	Компонент №1: <b>".$ra[$g['k1']]."</b><br />
	Компонент №2: <b>".$ra[$g['k2']]."</b><br />
	Компонент №3: <b>".$ra[$g['k3']]."</b><br />
	Компонент №4: <b>".$ra[$g['k4']]."</b><br />
	Умения: <b>".$umelka."</b><br />
	Элементов: <b>".$rcount."</b>";
	if (@$_COOKIE['uid']==7)
		echo '<br /><i>Компонент: <b>'.$rsumm.'</b></i>';
	echo "</center>";
	
	
	
	
	


?>