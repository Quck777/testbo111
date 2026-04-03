<?php
if ( $priv['eclans']==2 ) //; else exit;
	$adm = true; else $adm = false;

?>
<center class="inv">
	<table width="90%" class="but">
		<tr>
			<td class=but2 width=30% colspan=6><a class=bga href=main.php?go=administration>Назад</a></td>
		</tr>
	</table>
<?php
if( empty($http->get['editor']) )
{
	$cl = $db->sql("SELECT * FROM `clans` WHERE `sign`<>'watchers'");
	echo "<table class=but width='90%'>";
	$i = 1;
	while($c = $db->fetchAssoc($cl))
	{
		echo "<tr>";
		echo "<td>".($i++)."</td>";
		if (!empty($c['staus']))
		{
			echo "<td class=user><img src=http://".IMG."/signs/".$c['sign'].".gif>".$c['name']."</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td class=user title='".$c['staus']."'><a class=bga href=\"main.php?editor=".$c['sign']."\">Расформирован</a></td>";		
		} else {
			echo "<td class=user><img src=http://".IMG."/signs/".$c['sign'].".gif>".$c['name']."[".$c['level']."]</td>";
			echo "<td class=green><a href=info.php?".$c['glav']." target=_blank>".$c['glav']."</a></td>";
			echo "<td><a class=bg href=http://".$c['sait']." target=_blank>".$c['sait']."</a></td>";
			echo "<td><a class=bga href=\"main.php?editor=".$c['sign']."\">Возм-ти</a></td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}
elseif ( isset($http->get['editor']) and !empty($http->get['editor']) )
{
	if(@$http->get['delete'])
	{
		$db->sql("UPDATE wp SET `durability`=0 WHERE `id`=".intval($http->get['delete']));
		echo "Удалено.";
	}
	
	$sign = $http->get['editor'];
	$clan = $db->sqla("SELECT * FROM `clans` WHERE `sign`='".$sign."' and `sign`<>'watchers'");
	
	echo'<table border=0 cellspacing=0 width=70% class=but>
		<tr>
			<td width=20% colspan=6><a class=blocked href=main.php?editor='.$sign.'&act=sostav>Состав</a></td>
			<td width=20% colspan=6><a class=blocked href=main.php?editor='.$sign.'&act=inv>Казна</a></td>
			<td width=20% colspan=6><a class=blocked href=main.php?editor='.$sign.'&act=stena>Стена</a></td>
			<td width=20% colspan=6><a class=blocked href=main.php?editor='.$sign.'&act=edits>Возм-ти</a></td>
			<td width=20% colspan=6><a class=blocked href=main.php>Назад</a></td></tr></table>';
	if ($clan==false) {echo 'Нет такого клана.'; exit;}
	
	if ( isset($http->post['delclan']) and !empty($http->post['delclan']) and $adm==true )
	{
		/*
		if ($clan['glav']==true)
		{
			if (sql('UPDATE `users` SET `money`=money+'.$clan['money'].', `dmoney`=dmoney+'.$clan['dmoney'].' WHERE `user`="'.$clan['glav'].'"'))
				sql('UPDATE `clans` SET `money`=0, `dmoney`=0 WHERE `sign`="'.$clan['sign'].'"');
		}
		*/
		$db->sql('UPDATE `users` SET `sign`="none", `state`="", `rank`="", `clan_state`="" WHERE `sign`="'.$clan['sign'].'" ;');
		$db->sql('UPDATE `clans` SET `staus`="'.$http->post['delclan'].'" WHERE `sign`="'.$clan['sign'].'"');
		//sql('DELETE FROM `wp` WHERE `sign`="'.$clan['sign'].'"');
		say_to_chat('a','Клан <img src="http://'.IMG.'/signs/'.$clan['sign'].'.gif"> <b>'.$clan['name'].'</b> расформирован (<b>'.$player->pers['user'].'</b>). <b>Причина</b>: '.$http->post['delclan'],0,'','*',0); 
		echo 'Клан <img src="http://'.IMG.'/signs/'.$clan['sign'].'.gif"> <b>'.$clan['name'].'</b> расформирован (<b>'.$player->pers['user'].'</b>). <b>Причина</b>: '.$http->post['delclan'];
	//	echo '<br /><b>Казна удалена.</b>';
		exit;
	}
	
	echo "<center><table border=0 cellspacing=0 width=500 class=but><tr><td width=250><a href='javascript:give_money()' class=blocked> <img src=http://".IMG."/money.gif> <b>".$clan["money"]." LN</b></a><a href='javascript:take_clan()' class=blocked>Снять деньги</a></td><td width=250><div class=but align=center> <img src=http://".IMG."/signs/diler.gif> <b>".$clan["dmoney"]."</b> Бр.</div></td></tr><tr><td class=but id=money colspan=3 align=center></td></tr></table></center>";
	$ch_site = ' | <a href="javascript:ch_site(\''.$clan['sait'].'\')" class=timef>Сменить</a>';
	echo "<center><table class=combofight width=500 cellspacing=0 cellspadding=0><tr><form method=POST><td align=center><input type=text name=delclan class=login size=40><input type=submit class=login value='Расформировать'></td></form></tr><tr><td align=center>Администрирование клана <img src='http://".IMG."/signs/".$clan['sign'].".gif'> <b class=user>".$clan['name']."[".$clan['level']."]</b></div></td></tr><tr align=center><td class=but>Глава Клана <font class=user>".$clan['glav']."</font><img src='http://".IMG."/info.gif' onclick=\"javascript:window.open('info.php?p=".$clan['glav']."','_blank')\" style='cursor:pointer'> | <a href='http://".$clan['sait']."' target=_blank class=bold>".$clan['sait']."</a>".$ch_site."</td></tr></table></center>";
	
	if (!isset($http->get['act']) or $http->get['act']=='sostav')
	{

		echo "<center><i class=user>Состав</i><table class=but width=800>";
		$sostav = $db->sql("SELECT user,rank,online,location,state,level,aura,uid,rank_i,clan_state,lastom,clan_tr FROM `users` WHERE `sign`='".$clan['sign']."' ORDER BY `clan_state` ASC");

		while ($perssost = $db->fetchAssoc($sostav)) 
		{
				
			//if ($status=='g' or $status=='z') 
				$onclick = "onclick=\"set_status('".$perssost["user"]."','".$perssost["clan_state"]."','".$perssost["state"]."',".$perssost["clan_tr"].",".(($perssost["uid"]==$player->pers["uid"])?1:0).",'".$status."',".(($player->pers["sign"]=="watchers")?1:0).",".$perssost["uid"].")\" style='cursor:pointer'";
			//	else $onclick = '';
				
			echo"<tr><td>";
			echo"<img src='http://".IMG."/pr.gif' onclick=\"javascript:top.say_private('".$perssost["user"]."')\" style='cursor:pointer' height=16> 
			<font class=user  ".$onclick.">";
			echo " ".$perssost["user"]."</font><font class=lvl>[".$perssost["level"]."]</font>";
			echo "<img src='http://".IMG."/i.gif' onclick=\"javascript:window.open('info.php?p=".$perssost["user"]."','_blank')\" style='cursor:pointer'>";
			$color = '#333333';
			
			if ($perssost["clan_state"]=='a') $color = '#990000';
			if ($perssost["clan_state"]=='b') $color = '#DD0000';
			if ($perssost["clan_state"]=='c') $color = '#4B0082';
			if ($perssost["clan_state"]=='d') $color = '#009900';
			if ($perssost["clan_state"]=='e') $color = '#000099';
			if ($perssost["clan_state"]=='f') $color = '#009999';
			if ($perssost["clan_state"]=='g') $color = '#800080';
			if ($perssost["clan_state"]=='h') $color = '#1E90FF';
			if ($perssost["clan_state"]=='i') $color = '#D87093';
			if ($perssost["clan_state"]=='j') $color = '#688E23';
			if ($perssost["clan_state"]=='k') $color = '#00CED1';
			
			
			echo "</font></td><td><b style='color:".$color."'>"._StateByIndex($perssost["clan_state"])."</b>[".$perssost['state']."]</td>";
			if ($perssost["online"]==1) 
				{
					$loc = $db->sqla("SELECT name FROM `locations` WHERE `id`='".$perssost['location']."'");
					$loc = $loc["name"];
					echo "<td class=green>".$loc."</td>";
				}
				else 
					echo "<td class=hp>".time_echo(tme()-$perssost["lastom"])."</td>";
			if ($perssost["clan_tr"]) 
				echo "<td class=timef>Казна <i class=green>вкл</i></td>";
			else
				echo "<td class=timef>Казна <i class=hp>выкл</i></td>";
				
			echo "</tr>";
		}		
		echo "</table></center>";
		echo'<table border="0" width="90%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Регулирование клана</td></tr>';
		echo '<tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?editor='.$clan['sign'].'&act=sostav><p align="right"><input name=adm_go_in size=100 class=laar style="float: left"> <input type="submit" value="Принять в клан" class=inv_but></p></form></td></tr>';
		echo '<tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?editor='.$clan['sign'].'&act=sostav><p align="right"><input name=adm_do_glav size=100 class=laar style="float: left"> <input type="submit" value="Сделать главой клана" class=inv_but></p></form></td></tr>';
	
		echo '</table>';
	}
	elseif ($http->get['act']=='inv') 
	{
		if ( $http->get['get_item']==true and $adm==true )
		{
			$v = $db->sqla("SELECT * FROM `wp` WHERE `id`=".intval($http->get['get_item'])." and `clan_sign`='".$clan['sign']."'");
			if ( $v['id']==true and $v['weared']==0 )
			$db->sql("UPDATE `wp` SET `uidp`=".$player->pers['uid'].", `user`='".$player->pers['user']."' WHERE `id`=".intval($http->get['get_item'])." and `clan_sign`='".$clan['sign']."'");
		}
		if( isset($http->get['delete']) and !empty($http->get['delete']) and $adm==true )
		{
			$db->sql("UPDATE `wp` SET `durability`=0 WHERE `id`=".intval($http->get['delete']));
			echo "Удалено.";
		}
		?>
		<center><table border=0 width=600 class=but>
		<tr><td align=center><script> show_imgs_sell('editor=<?=$clan['sign'];?>&act=inv'); </script></td></tr><tr><td valign="top">
		<?php
		if ( $_FILTER['lavkatype']!='napad' )
			$stype = "`stype`='".$_FILTER["lavkatype"]."'";
		else
			$stype = "`type` = 'napad' ";

		if ( $_FILTER['lavkatype']<>'all' )
			$enures = $db->sql("SELECT * FROM `wp` WHERE ".$stype." and `clan_sign`='".$clan['sign']."'");
		else
			$enures = $db->sql("SELECT * FROM `wp` WHERE `clan_sign`='".$clan['sign']."'");
		$check = 0;
		while ( $v=$db->fetchAssoc($enures) ) 
		{
			if( $v['max_durability']==true and $v['durability']==false ) continue;
			echo "<div class=but2>";
			$check++;
			if ( $v['weared']==0 )
				echo "<a href='info.php?p=".$v['user']."' class=user target=_blank>".$v['user']."</a> <input type=button class=but onclick=\"location='main.php?editor=".$clan['sign']."&act=inv&get_item=".$v['id']."'\" value='Взять'>";
			else echo "<font class=hp>Вещь надета на персонаже </font><a href='info.php?".$v['user']."' class=user target=_blank>".$v['user']."</a>";
			
			 echo "<input type=button class=but onclick=\"location='main.php?editor=".$clan['sign']."&act=inv&delete=".$v['id']."'\" value='Удалить'>";
				echo "</div>";
			$vesh = $v;
			include ('inc/inc/weapon.php');
		
		}
		if ( $clan['treasury']<$check )
		{
			$tr = $db->sqlr("SELECT COUNT(*) FROM `wp` WHERE `clan_sign`='".$clan['sign']."'",0);
			$db->sql("UPDATE `clans` SET `treasury`=".$tr." WHERE `sign`='".$clan['sign']."'");
		}
		?>
		</table></center>	
		<?php
	}
	elseif ( $http->get['act']=='stena' and $adm==true )
	{
	?>
		<center>
		<div style="width:500px" class=but>
		<div id=report align=center><a href="javascript:report();" class=bg>Написать отзыв</a></div>
		<div id=mainpers></div>
		<script>
		var d=document;
		var $ = function(id){
			return d.getElementById(id);
		};
		var rep_text='';

		function report()
		{
			$('report').innerHTML = '<form method=post><textarea name=report class=return_win rows=5></textarea><hr><input type=submit class=login value="Отправить"></form>';
		}

		function pr_r(WHO,LVL,SIGN,DATE,text,DLDT)
		{
			if (SIGN!= 'none') SIGN = '<img src=http://'+img_pack+'/signs/'+SIGN+'.gif>'; else SIGN='';
			rep_text += '<tr><td class=login>'+SIGN+' <b>'+WHO+'</b>[<font class=lvl>'+LVL+'</font>] <img src="http://'+img_pack+'/i.gif" onclick="window.open(\'info.php?p='+WHO+'\',\'\',\'width=800,height=600,left=10,top=10,toolbar=no,scrollbars=yes,resizable=yes,status=no\');" style="cursor:pointer"> <font class=time>'+DATE+'</font> <a href="main.php?editor=<?=$clan['sign'];?>&act=stena&delmsg='+DLDT+'">Удалить</a></td></tr><tr><td>'+text+'</td></tr>';
			return true;
		}
		</script>
		<?php
		#Добавить отзыв:
		
		if ( isset($http->get['delmsg']) and !empty($http->get['delmsg']) and $adm==true )
		{
			$isr = $db->sqla("SELECT `date` FROM `reports_for_clans` WHERE `csign`='".$clan['sign']."' and `date`=".intval($http->get['delmsg'])."");
			if ( $isr['date']>0 ) 
			$db->sql("DELETE FROM `reports_for_clans` WHERE `csign`='".$clan['sign']."' and `date`=".$isr['date']."");
			unset($r);
		}
		
		if (@$http->post["report"])
		{
			$db->sql("INSERT INTO 
			`reports_for_clans` ( `csign` , `lvl` , `sign` , `date` , `who` , `text` ) 
			VALUES ('".$clan["sign"]."', '".$player->pers["level"]."', '".$player->pers["sign"]."', '".tme()."'
			, '".$player->pers["user"]."', '".str_replace("'","",$http->post["report"])."');");
		}
			# Отзывы
		echo "<script>";
		if (empty($http->get["all_reports"]))
		$rep = $db->sql("SELECT * FROM reports_for_clans WHERE csign='".$clan["sign"]."' ORDER BY date DESC LIMIT 7;");
		else
		$rep = $db->sql("SELECT * FROM reports_for_clans WHERE csign='".$clan["sign"]."' ORDER BY date DESC");

		echo "rep_text +='<table border=1 width=100% cellspacing=3 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF><tr><td class=brdr>ОТЗЫВЫ:<a href=\"main.php?editor=".$clan['sign']."&act=stena&all_reports=1\">(ВСЕ)</a></td></tr>';";
		$k = 0;
while($r = $db->fetchArray($rep))
{
	$k++;
	echo "pr_r('".$r["who"]."',".$r["lvl"].",'".$r["sign"]."','".date("d.m.Y H:i",$r["date"])."','".str_replace('
','<br>',$r["text"])."', ".$r['date'].");";
}
		if ($k==0) echo "rep_text +='<tr><td class=time>Здесь пока никто не написал</td></tr>';";
		echo "rep_text +='</table>';";
		echo "$('mainpers').innerHTML += rep_text;";
		echo "</script>";
		?>
		</div>
		</center>
	<?php
	}
	
	
	
	
	
	
	
}
?>
</center>