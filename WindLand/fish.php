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

$pers = $db->sqla('SELECT `user`,`sp6` FROM `users`	WHERE `uid`='.intval($_COOKIE['uid']).' and `pass`="'.filter($_COOKIE['hashcode']).'" LIMIT 0,1;'); 
if ($pers == false) $pers = Array('user'=>'Не определено.', 'sp6'=>0);//die('Go Out;');

//echo 'У Вас <b>'.$pers['sp6'].'</b><br />';
/*
1 - Перловая каша
2 - Толстые черви
3 - Зеленая лягушка
4 - Толстый кольчатый червь
5 - Зеленый горошек
6 - Опарыш
7 - Красные черви
8 - Тесто
*/

$primanka = Array('Перловая каша', 'Толстые черви', 'Зеленая лягушка', 'Толстый кольчатый червь', 'Зеленый горошек', 'Опарыш', 'Красные черви', 'Тесто');

function HTML_selected_prim()
{
	GLOBAL $primanka;
	$r = '';
	for ($i=0; $i<count($primanka); $i++) $r.= '<option value="'.$i.'" '.((@$_GET['prim']==$i) ? 'selected' : '').'>'.$primanka[$i].'</option>';
	return $r;
}

function HTML_selected_locate()
{
	GLOBAL $db;
	$res = $db->sql('SELECT * FROM `nature` WHERE `fishing`>0 ORDER BY `fishing`');
	$r = '';
	if ( isset($_GET['loca']) )
	{
		$lo = explode('_',$_GET['loca']);
		$_x = intval($lo[1]);
		$_y = intval($lo[2]);
	} else {$_x=0;$_y=0;}
	
	while ( $re = mysql_fetch_assoc($res) )
	{
		$r.= '<option value="'.$re['fishing'].'_'.$re['x'].'_'.$re['y'].'" '.(($_x==$re['x'] and $_y==$re['y']) ? 'selected' : '').'>'.$re['name'].' ('.$re['x'].':'.$re['y'].')</option>';
	}
	return $r;
}

function HTML_selected_fisher()
{
	GLOBAL $db;
	$res = $db->sql('SELECT `id`,`name` FROM `fish` ORDER BY `skill`');
	$r = '';
	while ( $re = mysql_fetch_row($res) )
	{
		$r.= '<option value="'.$re[0].'" '.((@$_GET['fish']==$re[0]) ? 'selected' : '').'>'.$re[1].'</option>';
	}
	return $r;
}

function HTML_view_locate($id)
{
	GLOBAL $db;
	$res = $db->sql('SELECT `name`,`x`,`y` FROM `nature` WHERE `fishing`='.$id);
	$r = '';
	while( $re = mysql_fetch_row($res) )
	{
		$r.= '<option>'.$re[0].' ('.$re[1].':'.$re[2].')</option>';
	}
	return $r;
}

function HTML_view_primanka($id)
{
	GLOBAL $primanka;
	$id2 = (intval($id+1)%8+1);
	$r = ($id==$id2) ? $primanka[$id] : ($primanka[$id].', '.$primanka[$id2]);
	return $r;
}
?>
<HTML>
<HEAD>
<TITLE>Калькулятор рыбалки (<?php echo $pers['user'];?>)</TITLE>
<META Content='text/html; charset=windows-1251' Http-Equiv=Content-type>

<LINK href='/css/main_v2.css' rel=STYLESHEET type=text/css>
</HEAD>
<BODY style='overflow:hidden;'>

<h1 align="center">Калькулятор рыбалки</h1>
<h4 align="left">Ваше умение рыбалки: <b><?php echo $pers['sp6']?></b></h4>

<form action="?" method="GET" align="center">
	<input type="hidden" name="do" value="1">
	<select name="prim"><?php echo HTML_selected_prim();?></select>
	<select name="loca"><?php echo HTML_selected_locate();?></select>
	<input type="text" name="um" value="<?php echo (isset($_GET['um']) ? intval(abs($_GET['um'])) : $pers['sp6']);?>">
	<input type="submit">
</form>

<form action="?" method="GET" align="center">
	<input type="hidden" name="do" value="2">
	<select name="fish"><?php echo HTML_selected_fisher();?></select>
	<input type="text" name="um" value="<?php echo (isset($_GET['um']) ? intval(abs($_GET['um'])) : $pers['sp6']);?>">
	<input type="submit">
</form>
<br />
<div class="but">
<?php

if ( isset($_GET['do']) )
{
	if ($_GET['do']==1)
	{
		$resourses = '';
		$mrim = intval(abs($_GET['prim']));
		$lo = explode('_',$_GET['loca']);
		$loca = intval(abs($lo[0]));
		$um = intval(abs($_GET['um']));//$pers['sp6']
		
		$res = $db->sql("SELECT * FROM `fish` WHERE 
		`skill`<'".$um."' and 
		`place`='".$loca."' and 
		(
			`prim`=".$mrim." or 
			`prim`=".(intval($mrim+1)%8+1)."
		)
		");
		while ( $re = mysql_fetch_assoc($res) )
		{
			$pr = round($re['price']+sqrt(sqrt($re['price']/2)*(6)),2);
			$resourses.= '<tr> <td>'.$re['name'].'</td> <td>'.round($re['price'],2).' - '.$pr.'</td> </tr>';
		}
		if ( !empty($resourses) )
		{
			echo '<table width="50%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr class="user"> <td>Рыба</td> <td>Цена</td> </tr>';
			echo $resourses;
			echo '</table>';
		} else echo '<h3 align="center">Нет рыбы.</h1>';
	} elseif ($_GET['do']==2)
	{
		$id = intval(abs($_GET['fish']));
		$res = $db->sqla("SELECT * FROM `fish` WHERE `id`='".$id."'");
		if ($res==true)
		{
			$um = intval(abs($_GET['um']));//$pers['sp6']
			$pr = round($res['price']+sqrt(sqrt($res['price']/2)*(6)), 2);
			$nkl = round(($res['no_kl']-sqrt($um)+10), 2);//$pers['sp6']
			$sriv = round($res['skill']/10-2*sqrt($um), 2);
			
			echo'<div align="center">
			<img src="http://'.IMG.'/weapons/fish/'.$res['id'].'.gif" /><br />
			<b>Цена</b>: от '.round($res['price'],2).' до '.$pr.' LN<br />
			<b>Минимум умения</b>: <font color="'.(($res['skill']>$um) ? 'red' : 'green').'">'.$res['skill'].'</font><br />
			<b>Места ловли</b>: <select>'.HTML_view_locate($res['place']).'</select><br />
			<b>Возможная приманка</b>: '.HTML_view_primanka($res['prim']).'.<br />
			<b>Шанс отсутствия рыбы *</b>: '.(($nkl<0) ? 'Нет шансов.' : ($nkl.' %')).'<br />
			<b>Шанс срыва рыбы</b>: <font color="'.(($sriv<0 or $sriv<50) ? 'green' : 'red').'">'.(($sriv<0) ? 'Нет шансов.' : ($sriv.' %')).'</font><br />
			<br />* При ловле так же учитывается популяция рыбы в водоеме.
			</div>';
			
		} else echo '<div align="center">Ошибка.</div>';
	}
} else echo '<div align="center">Выберите параметры.</div>';

?>
</div>
</BODY>
</HTML>