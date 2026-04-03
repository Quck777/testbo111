<?php
// ALTER TABLE `users` ADD `instant` VARCHAR( 20 ) NOT NULL DEFAULT 'none'


$dragon = isset($http->get['dragon']) ? intval($http->get['dragon']) : 0;
$dragon = isset($http->post['dragon']) ? intval($http->post['dragon']) : $dragon;

if ( $http->_get('battle_action') )
{
	$ins = $db->sqla("SELECT * FROM instant WHERE ID = ".intval($http->post["id"]).";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ( $http->_post('inst_in') )
	{
		if ( substr_count($ins["team"],'|')<$ins["count"] )
			if ( substr_count($ins["team"],$player->pers["user"])==0 )
				if ( strlen($ins["team"])==0 ) $add=''; else $add='|';
				
		$db->sql("UPDATE `instant` SET `team`=concat(team,'".$add.$player->pers["user"]."') WHERE ID=".$http->post["id"].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$db->sql("UPDATE `users` SET `instant`='".$ins["type"]."' WHERE `uid` = ".$player->pers["uid"].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers['instant'] = $ins['type'];
		$ars = explode ('@',$player->pers["aura"]);
		for ($q=0,$w=count($ars)-1;$q<$w;$q++)
		{
			if (substr_count($ars[$q],'potion')>0)
			{
				$ar = explode ('|',$ars[$q]);
				if ($ar[14]>0 || $ar[13]>20)
				{
					$ar[1] = time()-5;
					$ars[$q] = implode('|',$ar);
				}
			}
		}
		
		$player->pers["aura"] = implode ('@',$ars);
		$db->sql("UPDATE users SET aura='".$player->pers["aura"]."' WHERE uid=".$player->pers["uid"].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$aura=explode ("@",$player->pers["aura"]);
		$i=0;
		foreach ($aura as $l)
		{
			$a = explode("|",$l);
			if (($a[1]<=time() and $a[1]>99999 and isset($a[1])) or ($a[1]<=99999 and ($player->pers["f_turn"]>=$a[1] or $player->pers["f_turn"]==0) and isset($a[1]))) 
			{
				$i++;
				$player->pers["s1"]-=$a[4];
				$player->pers["s2"]-=$a[5];
				$player->pers["s3"]-=$a[6];
				$player->pers["s4"]-=$a[7];
				$player->pers["s5"]-=$a[8];
				$player->pers["s6"]-=$a[9];
				$player->pers["kb"]-=$a[10];
				$player->pers["hp"]-=$a[11];
				$player->pers["ma"]-=$a[12];
				$player->pers["udmin"]-=$a[13];
				$player->pers["udmax"]-=$a[14];
				$player->pers["mf1"]-=$a[15];
				$player->pers["mf2"]-=$a[16];
				$player->pers["mf3"]-=$a[17];
				$player->pers["mf4"]-=$a[18];
				$player->pers["mf5"]-=$a[19];
				$player->pers["sp10"]-=$a[20];
				$player->pers["aura"]=str_replace($l,"",$player->pers["aura"]);
				$player->pers["aura"]=str_replace("@@","@",$player->pers["aura"]);
			}
		}
		if ($i>0) set_vars(aq($player->pers),$player->pers['uid']);
		unset($aura);
		unset($a);
		unset($l);	
	}
	elseif ( $http->_post('inst_out') )
	{
		if (substr_count($ins["team"],$player->pers["user"])>0)
		{
			$t = explode('|',$ins["team"]);
			foreach ($t as $user)
			{
				$team = '';
				if ( $user<>$player->pers["user"] )
				{
					if (strlen($team)>0) $team.='|';
					$team.=$user;
				}
			}
			$db->sql("UPDATE `instant` SET team='".$team."' WHERE `ID` = ".$http->post["id"].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$db->sql("UPDATE `users` SET `instant`='none' WHERE `uid` = ".$player->pers["uid"].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['instant'] = 'none';
		}
	}
}



echo '<div class="but2"><table border="0" cellspacing="0" width="80%" class="but"><tr>
	<td width="25%"><a href="main.php?do=1&dragon=1" class="'.(($dragon==1) ? 'bga' : 'blocked').'">Желтые драконы</a></td>
	<td width="25%"><a href="main.php?do=1&dragon=2" class="'.(($dragon==2) ? 'bga' : 'blocked').'">Красные драконы</a></td>
	<td width="25%"><a href="main.php?do=1&dragon=3" class="'.(($dragon==3) ? 'bga' : 'blocked').'">Зеленые драконы</a></td>
	<td width="25%"><a href="main.php?do=1&dragon=4" class="'.(($dragon==4) ? 'bga' : 'blocked').'">Черные драконы</a></td>
</tr></table>';

if ( $dragon and ($dragon>=1 or $dragon<=4) )
{
	$inst = $db->sql('SELECT * FROM `instant` WHERE `place` = "dungeon" and `level` = '.$dragon.';', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ( @mysql_num_rows($inst)>0 )
	{
		$width = array();
		$max = 0;
		for ($r=0,$o=@mysql_num_rows($inst);$r<$o;$r++)
		{
			$max = substr_count(mysql_result($inst,$r,'vs'),'|');
			$width[$r]= $max * 15;
			if ($r%2==1)
			{
				if ($width[$r]<$width[$r-1]) $width[$r]=$width[$r-1]; else $width[$r-1]=$width[$r];
			}
		}
		
		for ($c=0,$d=@mysql_num_rows($inst);$c<$d;$c++)
		{
			$inf = $db->sqla("SELECT * FROM instant WHERE ID=".mysql_result($inst,$c,'ID').";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$dinf = explode ('|',$inf["team"]);
			if ( substr_count($inf["team"],'|')>=$inf["count"]-1 and !empty($dinf[0]) )
			{
				begin_fight ($inf["team"],$inf["vs"],"Инстантовый бой &laquo;".$inf["name"]."&raquo;",100,300,1,1);
				$db->sql("DELETE FROM instant WHERE ID=".$inf["ID"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			}
		}
		
		echo '<table width="100%" border=0><tr>';
		for ($a=0,$k=@mysql_num_rows($inst);$a<$k;$a++)
		{
			if ($a>0 and $a%2==1) echo '<td></td>';
			elseif ($a>0 and $a%2==0) echo '</tr><tr><td></td></tr><tr>';
				
			$vs = '';
			$v = explode('|',mysql_result($inst,$a,'vs'));
			$m = 0;
			foreach ($v as $b)
			{
				if ($m%2 == 0) $s = 'F0F0F0'; else $s = 'EAEAEA';
				$bt = explode('=',$b);
				$bot = $db->sqla("SELECT `user`,`level` FROM `bots` WHERE `id` = ".$bt[1].";", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
				$vs.= '<div style="background-color:#'.$s.';"><b>'.$bot["user"].'</b>['.$bot["level"].'] <img src="/images/_i.gif" style="cursor:pointer;" onClick="window.open(\'/binfo.php?'.$bt[1].'\',\'_blank\');" border=0 height=16 /></div>';
				$m++;
			}
			$team = '';
			$v = explode('|',mysql_result($inst,$a,'team'));
			$m = 0;
			if ( !empty($v[0]) )
			{
				foreach ($v as $b)
				{
					if ($m%2 == 0) $s = 'F0F0F0'; else $s = 'EAEAEA';
					$ps = $db->sqla("SELECT `user`,`level`,`sign` FROM `users` WHERE `user` = '".$b."';", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
					$team.= '<div style="background-color:#'.$s.';">'.(($ps['sign']!='none') ? '<img src=/images/signs/'.$ps['sign'].'.gif width="15" height="12"> ' : '').'<b>'.$ps['user'].'</b> ['.$ps['level'].'] <a href="/info.php?p='.$b.'" target=_blank><img src="/images/_i.gif" border=0></a></div>';
					$m++;
				}
			} else $team = '<b>нет участников</b>';
			
			//if ( $player->pers['instant'] == mysql_result($inst,$a,'type') ) 
			
			$is_some = $db->sql("SELECT * FROM instant WHERE team like '%".$player->pers["user"]."%'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ( @mysql_num_rows($is_some)>0 )
			{
				$dis = ' disabled';
				if ( $player->pers['instant'] == mysql_result($inst,$a,'type') ) $dis2 = ''; else $dis2 = ' disabled';
			} else 
			{
				$dis = '';
				$dis2 = ' disabled';
			}
		//	$task = $db->sqla("SELECT * FROM quests WHERE uidp=".$player->pers["uid"]." and id='wizard_1' and task_to>".time()." and params<>'10|10|10';", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ( ($player->pers["rank_i"]/2) > mysql_result($inst,$a,'rank') ) $dis = 'disabled';
			echo '<td valign="top" class="but">
				<form action="main.php?do=1&dragon='.$dragon.'&battle_action=1" method="POST">
				<input type=hidden name="subroom" value="'.$dragon.'" />
				<input type=hidden name="id" value="'.mysql_result($inst,$a,'ID').'" />
				<table border="0" width="100%">
					<tr><td colspan="3" align="center"><b>&laquo;'.mysql_result($inst,$a,'name').'&raquo;</b></td></tr>
					<tr><td colspan="3" style="font-size:11px;">Количество участников: <b>'.mysql_result($inst,$a,'count').'</b></td></tr>
					<tr height="100%">
						<td valign="top" width="45%" style="padding-left:15px;font-size:11px">'.$team.'</td>
						<td width="10%" align="center" valign=middle><b>VS</b></td>
						<td width=45% style="padding-right:15px;font-size:11px" valign="top">'.$vs.'</td>
					</tr>
					<tr><td colspan="3" align="center"><br />
						<input type="submit"'.$dis.' name="inst_in" style="background-color:#F0F0F0;border:1px solid #000000; width:200px;" value="принять участие" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit"'.$dis2.' name="inst_out" style="background-color:#F0F0F0;border:1px solid #000000; width:200px;" value="отказаться от участия" />
					</td></tr>
				</table></form></td>';
		}
		echo '</tr></table>';
	} else echo '<b><i>Заявок на данный момент нет</i></b>';
}

?>
</div>