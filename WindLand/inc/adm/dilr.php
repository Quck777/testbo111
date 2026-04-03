<?php
if ( $player->pers['uid']==1 or $player->pers['uid']==7); else exit;

if ( isset($http->get['go_out']) ) 
{
	$go_out = $db->sqla("SELECT `uid`,`user`,`dreserv` FROM `users` WHERE `user`='".$http->get['go_out']."' and `diler`='1'");
	if ( $go_out==true )
	{
		$db->sql ("UPDATE `users` SET `diler`=0 WHERE `uid`=".$go_out['uid']."");
		echo"<center><font class=hp>Вы выгнали дилера ".$go_out['user'].".</font></center>";
	} else echo '<center><font class=hp>Ошибка.</font></center>';
}

if ( $http->_post('go_in') ) 
{
	$go_in = $db->sqla_id("SELECT `uid`, `user` FROM `users` WHERE `user`='".$http->post['go_in']."';");
	if ($go_in==true) 
	{
		if ($db->sql("UPDATE `users` SET `diler` = 1 WHERE `uid`= ".$go_in[0].";"))
		echo"<center><font class=hp>Персонаж ".$go_in[1]." назначен дилером проекта.</font></center>";
		else echo 'Ошибка.';
	} else echo"<center><font class=hp>Ошибка.</font></center>";
}

if ( isset($http->post['edits']) ) 
{
	$who = $db->sqla ("SELECT `uid`,`user`,`dreserv`,`dmoney` FROM `users` WHERE `uid`=".intval($http->post['edits'])."");
	if ($who['uid']==true)
	{
		if (!empty($http->post['ye_plus']))
		{
			$ye_plus = abs($http->post['ye_plus']);
			$db->sql("UPDATE `users` SET `dreserv`=dreserv+".$ye_plus." WHERE `uid`='".$who['uid']."'");
			echo"<center><font class=hp>Вы пополнили счет дилера ".$who['user']." на ".$ye_plus." y.e.</font></center>";
		}
		if (!empty($http->post['ye_minus']))
		{
			$ye_no = abs($http->post['ye_minus']);
			if ($who['dmoney']>=$dnw_no) 
			{
				$db->sql("UPDATE `users` SET `dreserv`=dreserv-".$ye_no." WHERE uid='".$who['uid']."'");
				echo"<center><font class=hp>С счета дилера ".$who['user']." снято ".$ye_no." y.e.</font></center>";
			}
		}
		if (!empty($http->post['dnw_plus']))
		{
			$dnw_plus = abs($http->post['dnw_plus']);
			$db->sql("UPDATE `users` SET `dmoney`=dmoney+".$dnw_plus." WHERE `uid`='".$who['uid']."'");
			echo"<center><font class=hp>Вы пополнили счет дилера ".$who['user']." на ".$dnw_plus." Бр.</font></center>";
		}
		if (!empty($http->post['dnw_minus']))
		{
			$dnw_no = abs($http->post['dnw_minus']);
			if ($who['dmoney']>=$dnw_no) 
			{
				$db->sql("UPDATE `users` SET `dmoney`=dmoney-".$dnw_no." WHERE `uid`='".$who['uid']."'");
				echo"<center><font class=hp>С счета дилера ".$who['user']." снято ".$dnw_no." Бр.</font></center>";
			}
		}
	} else echo"<center><font class=hp>Персонаж не найден.</font></center>";
}

unset($dst);
?>
<center class="inv">
<table width=80% class=but>
<tr><td class=but2 width=30% colspan=6><a class=bga href=main.php?go=administration>Назад</a></td></tr><tr>
<td class=but2 width=30%><a class=bg href=main.php?dil=sosr>Дилеры</a></td>
<!--<td class=but2 width=30%><a class=bg href=main.php?dil=log>Весь лог действий</a></td>
<td class=but2 width=30%><a class=bg href=main.php?dil=state>Статистика</a></td>-->
</tr></table>
<?php
if ( !isset($http->get['dil']) or $http->get['dil']=='sosr' )
{
	$dlrs = $db->sql("SELECT `user`,`dmoney`,`money`,`level`,`uid`,`sign`,`state`,`dreserv` FROM `users` WHERE `diler`='1' ORDER BY `dreserv` DESC");
	echo '<table class=but width=80%>';
	while ( $dst = mysql_fetch_assoc($dlrs) ) 
	{
		echo"<tr><td><font class=user>";
		echo"<img src='http://".IMG."/_p.gif' onclick=\"javascript:top.say_private('".$dst['user']."')\" style=cursor:hand> 
		<font class=user> &nbsp;&nbsp;";
		echo "<img src='http://".IMG."/signs/".$dst['sign'].".gif' title='".$dst['state']."'>";
		echo " ".$dst['user']."</font>[<font class=lvl>".$dst['level']."</font>]";
		echo "<img src='http://".IMG."/i.gif' onclick=\"javascript:window.open('info.php?p=".$dst['user']."','_blank')\" style=cursor:hand>";
		if ($dst['dreserv']<>0) echo "</font></td><td class=hp>&nbsp;".$dst['dreserv']." у.е.</td>"; else echo "</font></td><td class=hp>&nbsp;Нет у.е.</td>";
		if ($dst['dmoney']<>0) echo "<td class=ma>&nbsp;".$dst['dmoney']." Бр.</td>"; else echo "<td class=ma>&nbsp;Нет Бр.</td>";
		if ($dst['money']<>0) echo "<td class=inv_but>&nbsp;".$dst['money']." LN</td>"; else echo "<td class=ma>&nbsp;Нет LN</td>";
		echo "<td class=time><font class=time><a href='main.php?dil=edit&who=".$dst['user']."'>Возм-ти</a> | <a href=# onclick='go_out(\"".$dst['user']."\")'>Уволить</a> | <a href=main.php?dil=log&user=".$dst['uid'].">Отчет</a></font></td>";
		echo "</tr>";
	}
	echo '</table>';
	if (true) echo '<table border="0" width="80%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Назначение дилеров</td></tr><tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?><p align="right"><input name=go_in size=100 class=laar style="float: left"> <input type="submit" value="Сделать дилером" class=inv_but></p></form></td></tr></table>';
} 
elseif ( $http->get['dil']=='edit' and !empty($http->get['who']) ) 
{
	$who = $db->sqlr("SELECT `uid` FROM `users` WHERE `user`='".$http->get['who']."' and `diler`='1'");
	if ($who==true) 
	{
		?>
		<form method="POST" action=main.php>
		<center>
		<div style="width:70%" class=but>
		<div id=ye_pl align=center><a href="javascript:ye_pl();" class=bg>Добавить у.е.</a></div>
		<div id=ye_no align=center><a href="javascript:ye_no();" class=bg>Забрать у.е.</a></div>
		<div id=dnw_pl align=center><a href="javascript:dnw_pl();" class=bg>Добавить Бр.</a></div>
		<div id=dnw_no align=center><a href="javascript:dnw_no();" class=bg>Забрать Бр.</a></div>
		<div id=mainpers></div>

		<?php
	echo '<center><input type=hidden name=edits value='.$who.'><input type="submit" value="Сохранить" class=login></center></form>';
	}
}
elseif ($http->get['dil']=='log')
{
	if (empty($http->post['delete']) and false)
	{
		if (@$_POST)
		{
			$q = '';
			foreach($_POST as $key => $v)
			if ($v=="1") $q .= str_replace("del_","`date`=",$key).' or ';
			$q = substr($q,0,strlen($q)-3);
			$db->sql("DELETE FROM `dtransfer` WHERE `uidwho`=".intval($http->get['user'])." and (".$q.")");
		}
	}
	unset($logs);$vsego = 0;
	$logg = $db->sql("SELECT * FROM `dtransfer` WHERE `uidwho`=".intval($http->get['user'])."");
	echo '<form method=post action=main.php?dil=log&user='.intval($http->get['user']).'><table border="1" cellspacing="0" cellpadding="0" bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF bgcolor=#F5F5F5 align=center>';
	while( $logs = mysql_fetch_assoc($logg) )
	{
		$p = $db->sqla ("SELECT `user` FROM `users` WHERE `uid`='".$logs['uid']."'");
		$vsego += $logs['summ'];
		echo "<tr>";
		echo "<td width=10><input type=checkbox name=del_".$logs['date']." value=1></td>";
		echo "<td width=100 class=timef title=".$logs['text'].">".date("d.m.y H:i",$logs['date'])." </td>";
		echo "<td class=ma aling=center>Продано <font class=hp>".$logs['summ']."</font> Бр. персонажу <font class=user>".$p['user']."</font><a href=info.php?p=".$p['user']." target=_blank><img src=http://".IMG."/i.gif></a></td>";
		echo "</tr>";
	}
	echo "</table><center><input type=hidden name=delete value=0><input type=submit class=login value='Удалить выделенные'></form>
	<br>Продано всего: <b>".$vsego." y.e.</b>
	</center>";
}
?>
</center>

<script>
var d=document;
var $ = function(id){return d.getElementById(id);};

function ye_pl() {
	$('ye_pl').innerHTML = '<tr><td class=timef>Добавить </td><td><input type="text" name="ye_plus" size="10" title="Количество" class=login><font class=timef> y.e.</font></td></tr>';
}
function ye_no() {
	$('ye_no').innerHTML = '<form method="POST" action=main.php><tr><td class=timef>Забрать </td><td><input type="text" name="ye_minus" size="10" title="Количество" class=login><font class=timef> y.e.</font></td></tr>';
}
function dnw_pl() {
	$('dnw_pl').innerHTML = '<form method="POST" action=main.php><tr><td class=timef>Добавить </td><td><input type="text" name="dnw_plus" size="10" title="Количество" class=login><font class=timef> Бр.</font></td></tr>';
}
function dnw_no() {
	$('dnw_no').innerHTML = '<form method="POST" action=main.php><tr><td class=timef>Забрать </td><td><input type="text" name="dnw_minus" size="10" title="Количество" class=login><font class=timef> Бр.</font></td></tr>';
}
function go_out(user) {
	if (confirm('Вы действительно хотите уволить '+user+'?')) d.location='main.php?go_out='+user+'';
}
</script>