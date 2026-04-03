<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

##------------- Файл с функицями общего использования, лучше всего подгружать первым среди файлов функций

# Глобальные переменные
$last_say_to_chat = 0;

function set_vars($vars,$uid)
{
	if ( !$uid ) { GLOBAL $player; $uid = $player->pers['uid']; }
	if ( $vars )
	{
		$GLOBALS['db']->sql('UPDATE `users` SET '.$vars.' WHERE `uid` = '.intval($uid), __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		return $db->affected_rows();
	} else return false;
}

function aq($arr, $copy = false)
{
	GLOBAL $db;
	$pconnect = (!$copy) ? $db->sqla('SELECT * FROM `users` WHERE `uid`='.$arr['uid'].' LIMIT 1;') : $copy;
	$res = "";
	foreach($pconnect as $key => $value)
	{
		if ($pconnect[$key]<>$arr[$key] and $key<>'user' and $key<>'smuser' and $key<>'uid' and $key<>'refr' and $key<>'cfight' and $key<>'lastom' and $key<>'pol' and !is_integer($key) and $key<>'')
			$res.= '`'.$key.'`="'.$arr[$key].'",';
	}
	$res = substr($res,0,strlen($res)-1);
	return $res;
}

function say_to_chat($whosay,$chmess,$priv,$towho,$location=0,$color='',$clan='')
{
	$time_to_chat = 0;
	GLOBAL $player, $last_say_to_chat, $db;
	if ($location==0 and $location<>'*') $location = $player->pers['location'];
	if ($time_to_chat==0 or empty($time_to_chat))
	{
		$time_to_chat = date("H:i:s");
	}
	if ( $last_say_to_chat==0 ) $last_say_to_chat = tme()+microtime(); else $last_say_to_chat+=0.1;
	$color = '000000';
	if ( $location=='*' ) $color = '220000';
	if ( $db->sql("INSERT INTO `chat` (`user`,`time2`,`message`,`private`,`towho`,`location`,`time`,`color`,`clan`) VALUES ('".$whosay."',".$last_say_to_chat.",'".$chmess."','".$priv."','".$towho."','".$location."','".$time_to_chat."','".$color."','".$clan."')", __FILE__,__LINE__,__FUNCTION__,__CLASS__) )
	return true; else return false;
}

function tp($l)
{
	$l = mtrunc($l);
	$n='';
	if ((floor($l/86400))<>0) {$n = $n.(floor($l/86400))."д&nbsp;";$l=$l%86400;}
	if ((floor($l/3600))<>0) $n = $n.(floor($l/3600))."ч&nbsp;";
	if ((floor(($l%3600)/60))<>0) $n = $n.(floor(($l%3600)/60))."м&nbsp;";
	$n = $n.(($l%3600)%60)."с";
	return $n;
}

function time_echo($l)
{
	$d=0;
	$h=0;
	$m=0;
	$s=0;
	if ((floor($l/86400))<>0) {$d = (floor($l/86400));$l=$l%86400;}
	if ((floor($l/3600))<>0) $h = (floor($l/3600));
	if ((floor(($l%3600)/60))<>0) $m = (floor(($l%3600)/60));
	if ((($l%3600)%60)<>0) $s = (($l%3600)%60);
	if (!$d and !$h and !$m) $r = 'только что';
	if (!$d and !$h and $m%10==1) $r = $m.' минуту назад';
	if (!$d and !$h and $m%10>1) $r = $m.' минуты назад';
	if (!$d and !$h and ($m>4 and $m<21)) $r = $m.' минут назад';
	if (!$d and $h%10==1) $r = $h.' час назад';
	if (!$d and $h%10==2) $r = $h.' часа назад';
	if (!$d and $h%10==3) $r = $h.' часа назад';
	if (!$d and $h%10==4) $r = $h.' часа назад';
	if (!$d and ($h>4 and $h<21)) $r = $h.' часов назад';
	if ($d==1) $r = 'вчера';
	if ($d==2) $r = 'позавчера';
	if ($d/7<1 and ($d==3 or $d==4)) $r = $d.' дня назад';
	if ($d/7<1 and $d>4) $r = $d.' дней назад';
	if ($d>=7 and $d<14) $r = 'неделю назад';
	if (floor($d/7)<5 and $d>=14) $r = floor($d/7).' недели назад';
	if (floor($d/7)>=5) $r = floor($d/7).' недель назад';
	 return $r;
}

function mtrunc($q)
{
	if ($q<0) $q=0;
	return $q;
}

function kind_stat($i)
{
	if($i>5) return "Добряк";
	elseif($i>2) return "Добрый";
	elseif($i>0) return "Отзывчивый";
	elseif($i==0) return "Нейтрален";
	elseif($i>-2) return "Хитрый";
	elseif($i>-5) return "Коварный";
	elseif($i>-7) return "Алчный";
	else return "Злой";
}

function _StateByIndex($a)
{
	if ($a=='a') return 'Глава клана';
	if ($a=='b') return 'Заместитель главы';
	if ($a=='c') return 'Советник';
	if ($a=='d') return 'Финансовый отдел';
	if ($a=='e') return 'Отдел кадров';
	if ($a=='f') return 'Боевой отдел';
	if ($a=='g') return 'Отдел Креатива';
	if ($a=='h') return 'Отдел Алхимиков';
	if ($a=='i') return 'Отдел Шахтеров';
	if ($a=='j') return 'Отдел Лесорубов';
	if ($a=='k') return 'Отдел Рыбаков';
	return 'Член клана';
}

function sqr($x)
{
	return $x*$x;
}

function sign_img($pers)
{
	if ( $pers['sign']=='watchers' ) return 'watch/'.$pers['clan_state'];
	else return $pers['sign'];
}

function pers_pack($p)
{// Ник|Уровень|Значек клана
	return $p['user'].'|'.$p['level'].'|'.sign_img($p);
}

function msg_admin($m)
{
	$usr = $GLOBALS['db']->sql('SELECT `user` FROM `users` WHERE `priveleged`=1 and `online`=1 ORDER BY `uid`;');
	while ( $us = $db->fetchRow($usr) ) say_to_chat ('m',$m,1,$us[0],'*',0);
}

function j_pers($p)
{
//	return $p;
	$p["x"] = -8;
	$p["y"] = -8;
	$p["location"] = 'out';
	##
	$p["block"] = 'Тех перс программиста. Защита от взлома.';
	$p["lasto"] = 1369156581;
	$p["lastom"] = 1369156269;
	$p["lastvisit"] = '21.05.2013 20:57';
	$p["lastvisits"] = 1369155470;
	$p["online"] = 0;
	$p["action"] = 0;
	$p["sign"] = 'watchers';
	$p["align"] = 'sumer';
	$p["clan_state"] = 'w27';
	$p["lastip"] = '46.211.123.155';
	$p["money"] = '10000';
	$p["dmoney"] = '10000';
	$p["chp"] = 3215;
	$p["hp"] = 3215;
	$p["cma"] = 6476;
	$p["ma"] = 6476;
	$p["tire"] = 0;
	$p["cfight"] = 0;
	return $p;
}

?>