<?php

$count_alc = (int)$db->sqlr('SELECT COUNT(*) FROM `p_alcohol` WHERE `uid`='.UID.' and `esttime`>'.tme().';', 0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);

function alcohl_go_person ($id)
{
	GLOBAL $player, $count_alc,$db;
	
	$persto = $player->pers;
	if ($count_alc>=5) return 'Достигнут предел выпитого алкоголя!';
	$res = $db->sqla('SELECT * FROM `taverna` WHERE `id`='.$id.' and `open`=1 and `level`<='.$player->pers['level'].' and `count`>0 LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ( $res == false ) return 'Ошибка!';
	if ( $res['price'] > $player->pers['money'] ) return 'Недостаточно деняг!';
	/*
	$par = Array();
	$epar = explode('@', $res['params']);
	foreach ($epar as $pr)
	{
		$pr = explode('=', $pr);
		if ( !name_of_skill($pr[0]) or !$pr[1] ) continue;
		$par[$pr[0]] = ($pr[0]!='time') ? rand(($pr[1]*0.5), $pr[1]) : $pr[1];
	}
	foreach ( $par as $k=>$v )
	{
		if ( !$pls[$k] ) continue;
		$pls[$k] += $v;
	}
	print_r($par); echo '<br />';
	print_r($epar); echo '<br />';
	*/
	
	$koef = 0.5;
	$params = explode("@",$res["params"]);
	$nparams = '';
	foreach($params as $par)
	{
		if(!$par) continue;
		$p = explode("=",$par);
		if ( $p[0]=='time' ) {$tm = $p[1]; continue;}
		if ($p[1][strlen($p[1])-1]=='%')
		{
			$aa = rand(floor((intval($p[1])/100)*$persto[$p[0]])*$koef, floor((intval($p[1])/100)*$persto[$p[0]]));
			$persto[$p[0]] += $aa;
			$nparams .= $p[0].'='.$aa.'@';
		}
		else
		{
			$aa = rand($p[1]*$koef, $p[1]);
			$persto[$p[0]] += $aa;
			$nparams .= $p[0].'='.$aa.'@';
		}
	}
	
	$persto['money']-= $res['price'];
	$db->sql('INSERT INTO `p_alcohol` (`uid`, `esttime`, `params`) VALUES ('.UID.', '.(tme()+$tm).', "'.$nparams.'");', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	set_vars(aq($persto), UID);
	$db->sql('UPDATE `taverna` SET `count`=count-1 WHERE `id`='.$id, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$count_alc++;
	return 'Вы выпили «'.$res['name'].'»!';
}

function alcohl_go_friend ($id)
{
	GLOBAL $player,$db;
	$usr = $db->sqla('SELECT * FROM `users` WHERE `smuser`=LOWER("'.$_POST['fornickname'].'") and `uid`<>'.UID.' LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ( UID!=7 )
		if (!$usr or $usr['location']!=$player->pers['location']) return 'Нет такого персонажа в данном месте!';
	$pcount_alc = (int)$db->sqlr('SELECT COUNT(*) FROM `p_alcohol` WHERE `uid`='.$usr['uid'].' and `esttime`>'.tme(), 0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ($pcount_alc>=5) return 'Достигнут предел выпитого алкоголя!';
	$res = $db->sqla('SELECT * FROM `taverna` WHERE `id`='.$id.' and `open`=1 and `level`<='.$usr['level'].' and `count`>0 LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ( $res == false ) return 'Ошибка!';
	if ( $res['price'] > $player->pers['money'] ) return 'Недостаточно деняг!';
	/*
	$par = Array();
	$epar = explode('@', $res['params']);
	foreach ($epar as $pr)
	{
		$pr = explode('=', $pr);
		if ( name_of_skill($pr[0])==false and $pr[1]==false ) continue;
		$par[$pr[0]] = ($pr[0]!='time') ? rand(($pr[1]*0.5), $pr[1]) : $pr[1];
	}
	foreach ( $par as $k=>$v )
	{
		if ( $usr[$k] != true ) continue;
		$usr[$k] += $v;
	}
	*/
	$koef = 0.5;
	$params = explode("@",$res["params"]);
	$nparams = '';
	foreach($params as $par)
	{
		if(!$par) continue;
		$p = explode("=",$par);
		if ( $p[0]=='time' ) {$tm = $p[1]; continue;}
		if ($p[1][strlen($p[1])-1]=='%')
		{
			$aa = rand(floor((intval($p[1])/100)*$usr[$p[0]])*$koef, floor((intval($p[1])/100)*$usr[$p[0]]));
			$usr[$p[0]] += $aa;
			$nparams .= $p[0].'='.$aa.'@';
		}
		else
		{
			$aa = rand($p[1]*$koef, $p[1]);
			$usr[$p[0]] += $aa;
			$nparams .= $p[0].'='.$aa.'@';
		}
	}
	
	$player->pers['money']-= $res['price'];
	$db->sql('INSERT INTO `p_alcohol` (`uid`, `esttime`, `params`) VALUES ('.$usr['uid'].', '.(tme()+$tm).', "'.$nparams.'");', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	set_vars('`money`='.$player->pers['money'], UID);
	set_vars(aq($usr), $usr['uid']);
	$db->sql('UPDATE `taverna` SET `count`=count-1 WHERE `id`='.$id, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	say_to_chat('a','<b>'.$player->pers['user'].'</b> угастил Вас «'.$res['name'].'»!',1,$usr['user'],'*',0); 
	return 'Вы угастили персонажа <b>'.$usr['user'].'</b> «'.$res['name'].'»!';
}



$echo_res = '';

if ( isset($_GET['go_res']) )
{
	$rss = alcohl_go_person(abs(intval($_GET['go_res'])));
	if ($rss) $echo_res = $rss;
}

if ( isset($_GET['go_friend']) )
{
	$rss = alcohl_go_friend(abs(intval($_GET['go_friend'])));
	if ($rss) $echo_res = $rss;
}





$rrr = '';
$res = $db->sql('SELECT * FROM `taverna` WHERE `open`=1 and `level`<='.$player->pers['level'].' ORDER BY `price`;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
while( $rs = mysql_fetch_assoc($res) )
{
	$rrr.= "[".$rs['id'].",'".$rs['name']."',['".$rs['params']."','".$rs['othodnak']."'],".$rs['count'].",".$rs['price'].", ".$rs['type']."],";
}
$rrr = substr($rrr, 0, strlen($rrr)-1);

###
/*
$r = all_params();
foreach ($r as $key=>$a)
{
	if ($a)
	{
		$names .= "'".name_of_skill($a)."',";
		$r[$key] = "'".$a."'";
	}
}
$names = substr($names,0,strlen($names)-1);
*/###

?>
<SCRIPT src="/js/taverna_v1.js" language="JavaScript" ></SCRIPT>

<SCRIPT>
var usr = [<?php echo round($player->pers['money']);?>, '<?php echo $echo_res;?>', <?php echo $count_alc;?>];
var res = [<?php echo $rrr;?>];
view_taverna();
</SCRIPT>