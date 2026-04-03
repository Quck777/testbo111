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

?><SCRIPT LANGUAGE="JavaScript" src="/js/ch_v2.js?7"></SCRIPT>
<script>
<?php
Error_Reporting(0);

$server_state = tme()+microtime();
if ( $_POST['message'] ) 
{
	$_POST['type'] = intval($_POST['type']);
	$_POST['message']=trim($_POST['message']);
	if ($_POST['type']<>1 and $_POST['type']<>3) $_POST['type']=2;
	$_POST['message'] = str_replace("\\","",$_POST['message']);
	$_POST['message'] = str_replace(".х","//",$_POST['message']);
	$_POST['message'] = str_replace("/[","//",$_POST['message']);
	$_POST['message'] = str_replace("•",".",$_POST['message']);
	$m = $_POST["message"];
	$i = strlen($m)-1;
	while ($m[$i]<>'|' and $i>0) $i--;
	if ($i>0)$_POST['message'] = substr($m,$i+1,strlen($m)-$i);
	$_POST['towho'] = substr($m,0,$i).'|';
	if ($_POST['towho']=='|') $_POST['towho']='';
	unset($m); unset($i);
	if ($_POST['ttype']=='priv') $_POST['priv'] = 1; else $_POST['priv'] = 0; 
}
 
$info = 0;
$uid = intval($_COOKIE['uid']);
$opt = explode('|',$_COOKIE['options']);

	$pers = $db->sqla("SELECT * FROM `users` WHERE `uid`= ".$uid." and `pass`='".addslashes($_COOKIE['hashcode'])."' and `block`='' LIMIT 0,1;"); 
	if ($pers==false) exit;
	
	##############################Боты
	if( date('i')%4==0 and false)
	{
		$tepmjus = $pers;
		include (ROOT.'/inc/func.php');
		include (ROOT.'/inc/func2.php');
		include (ROOT.'/inc/func3.php');
		include (ROOT.'/inc/battle_func.php');
		include(ROOT.'/gameplay/bots/attack.php');
		$pers = $tepmjus;
	}
	###############################
	
	##
	if ($pers['location']<>'cherch') $pers['location'] = '--';
	else $_POST['priv']=0;
	##

	$a_m = $pers['a_m'];
	$flood = $pers['flood'];
	$chcolor = $opt[5];
	if ( $pers['invisible']<tme() ) $online='`online`=1, '; else $online='';
	if ( $pers['sign']=='watchers' or $pers['diler']==1 or $pers['uid']==7) $no_ogran = true; else $no_ogran = false;
	$VIP = (0) ? true : false;

//Добавляем сообщение
if ( isset($_POST['message']) and $pers['silence']<=tme() )  
{
	$m = $_POST['message'];
	if ( empty($m) ) ; // Нахер..
//	elseif ( is_rvs($m.' '.$_POST['towho']) ) molch_bot(120,'Подозрение на РВС');
//	elseif ( is_mat($m) ) molch_bot(600,'Подозрение на мат');
//	elseif ( is_rkp($m) ) molch_bot(600,'Подозрение на РКП');
	else
	{
		////////////////////////////////////
		if ( $_POST['type']<>3 )
		{
			if ( (tme())<($pers['lasto']+2) ) $flood++; else $flood=0;
			if ( $pers['priveleged']==1)
			{
			//	$m = bbcoder($m);
				$m = preg_replace("!(\[color=)(.*?)(\])(.*?)(\[\/])!si", '<font color="\\2">\\4</font>', $m);
				$m = preg_replace("!(\[t])(.*?)(\[\/t])!si", '<CENTER>\\2</CENTER>', $m);
				$m = preg_replace("!(\[b])(.*?)(\[\/b])!si", '<B>\\2</B>', $m);
				$m = preg_replace("!(\[i])(.*?)(\[\/i])!si", '<I>\\2</I>', $m);
				$m = preg_replace("!(\[u])(.*?)(\[\/u])!si", '<U>\\2</U>', $m);
				$m = preg_replace("!(\[q])(.*?)(\[\/q])!si", '<marquee>\\2</marquee>', $m);
				$m = preg_replace("!(\[sm])(.*?)(\[\/sm])!si", '<SMALL>\\2</SMALL>', $m);
				$m = preg_replace("!(\[\+1])(.*?)(\[\/])!si", '<font size="+1">\\2</font>', $m);
				$m = preg_replace("!(\[\+2])(.*?)(\[\/])!si", '<font size="+2">\\2</font>', $m);
			/*
				if ($m[1]=='u') $m = "<u>".substr($m,2,strlen($m))."</u>";
				if ($m[1]=='i') $m = "<i>".substr($m,2,strlen($m))."</i>";
				if ($m[1]=='h') $m = "<h3>".substr($m,2,strlen($m))."</h3>";
				if ($m[1]=='b' or $m[1]=='и') $m = "<b>".substr($m,2,strlen($m))."</b>";
				if ($m[1]=='g' or $m[1]=='п') $m = "<h2>".substr($m,2,strlen($m))."</h2>";
				if ($m[1]=='l' or $m[1]=='д') $m = "<a href=http://".substr($m,2,strlen($m))." target=_blank>".substr($m,2,strlen($m))."</a>";
				if ($m[1]=='m' or $m[1]=='ь') $m = "<img src=".substr($m,2,strlen($m))." />";
				if ($m[1]=='f' or $m[1]=='а') $m = "<SCRIPT>top.Funcy('".substr($m,2,strlen($m))."');</SCRIPT>";
			*/
			}
		
			$priv=0;
			if (@$_POST["ttype"]=="priv") $priv=1;
			if ( empty($_POST['towho']) ) $towho=''; else $towho = $_POST['towho'];
			$lt = date('H:i:s');
			if ( empty($towho) ) $priv=0;
			if ( !empty($chcolor) ) $color = str_replace('#','',$chcolor); else $color='000000';
			if ( $priv==0 and $_POST['ttype']!='clan' and $pers['invisible']>tme() )
			{
				$pers['user']='n='.$pers['user'];
				$color='000000';
			}
			
			if ($_POST['ttype']=="clan")	 
			{
				$clan = $pers['sign'];
				if ( $clan!='none' )
					$db->sql("INSERT INTO `chat` (`id`,`user`,`towho`,`private`,`location`,`message`,`time`,`telepat`,`clan`,`color`,`type`) VALUES (0,'".$pers['user']."','".$towho."','".$priv."','".$pers['location']."','".$m."','".$lt."','".$telepat."','".$clan."','".$color."',".$_POST['type'].");");
			}
			else $db->sql("INSERT INTO `chat` (`id`,`user`,`towho`,`private`,`location`,`message`,`time`,`telepat`,`color`,`type`) VALUES (0,'".$pers['user']."','".$towho."','".$priv."','".$pers['location']."','".$m."','".$lt."','".$telepat."','".$color."',".$_POST['type'].");");
			
			## Подключим чат бота
			if ( $towho == 'Наставник|' )
			{
				session_start();
				if ( $pers['invisible']>tme() ) $priv=1;
				include (ROOT.'/gameplay/ChatBot.php');
				if ( !empty($response) )
				{
					$db->sql("INSERT INTO `chat` (`id`,`user`,`towho`,`private`,`location`,`message`,`time`,`telepat`,`color`,`type`) 
						VALUES (0,'Наставник','".$pers['user']."|','".$priv."','".$pers['location']."','".$response."','".$lt."','".$telepat."','".$color."',".$_POST['type'].");");
				}
			}
			## Конец функций чат бота
		}
		else
		{
			$user = $pers['user'];
			if($pers["invisible"]>tme()) $user = 'Невидимка';
			$db->sql("INSERT INTO `fight_log` (`time`,`log`,`cfight`,`turn`) VALUES ('".date('H:i')."','".$user." : ".addslashes($m)."','".$pers['cfight']."','".round((time()+microtime()),2)."');");
		}
		echo "top.clearer = 1;";
	}
}
elseif ( $pers['silence']>tme() ) echo "top.clearer = 1;";

//Вывод сообщений...
if ($VIP==false)
	$res = $db->sql("SELECT * FROM `chat` WHERE (`id`>".$pers['chat_last_id'].") and (location='".$pers['location']."' or `user`='s' or `telepat`=1 or `clan`='".$pers['sign']."' or location='*')"); 
else 
	$res = $db->sql("SELECT * FROM `chat` WHERE `id`>".$pers['chat_last_id']); 

# Выводим сообщение от игры, рекламное
$cfgs = @$db->sqla_id('SELECT `a_message`,`m_frequency` FROM `configs`');
if ( $cfgs and $a_m < tme() and date('i')%$cfgs[1]==0 ) 
{
	$info = 1;
	$a_m = tme()+60;
	$tx['time']=date('H:i:s');
	$tx['user']='a';
	$tx['message'] = $cfgs[0];
	$tx['color']='000000';
} unset($cfgs);

# Составляем список игнора
$ignore = '';
$ign  = $db->sql("SELECT `nick` FROM `ignor` WHERE `uid`=".$pers['uid']);
while ( $ig = mysql_fetch_row($ign) ) $ignore.= '<'.$ig[0].'>';

## Вывод подсказок игры
if ( (50-$pers['level'])>rand(1,500) and false )
{
	$tip = $db->sqla("SELECT `id`,`title`,`text` FROM `tips` WHERE `maxlevel`>".$pers['level']." ORDER BY RAND()");
	$view = $db->sqlr("SELECT `uid` FROM `no_tips` WHERE `uid`=".$pers['uid']." and `tip_id`=".$tip['id']);
	if ($tip==true and $view==false) echo "show_tip('".$tip['title']."','".$tip['text']."',".intval($tip['id']).");";
}
##
 
$s = '';
while ( ($txt = mysql_fetch_assoc($res)) or $info==1 ) 
{
	if ( substr_count($ignore, '<'.$txt['user'].'>') ) continue;
	if ( $pers['chat_last_id']<$txt['id'] ) $pers['chat_last_id'] = $txt['id'];
	$k=0;
	if ( $no_ogran==true and $txt['user']!='n=Joe' ) ;
	elseif ( substr_count($txt['user'],'n=') ) $txt['user']='n';
	if ( empty($txt) and $info==1 ) 
	{
		$info = 0;
		$txt=$tx;
	}
	if ( empty($txt['time']) ) $txt['time'] = date('H:i:s');
	
	if ( $txt['private']==1 and ($txt['user']==$pers['user'] or substr_count('|'.$txt['towho'].'|','|'.$pers['user'].'|') or $VIP==true) ) $k = 1;
	if ( $txt['private']<>1 ) $k=1;
	if ( $txt['clan']==$pers['sign'] and !empty($txt['clan']) ) $txt['private']=2;
	if ($txt['clan']<>$pers['sign'] and !empty($txt['clan']) and $txt['clan']<>'none') $k=0;
	//if ($VIP==true) $k=1;
	
	// Системные сообщения
	
	if ( $txt['private']==1 and ($txt['towho']==$pers['user'] and $txt['user']=='s') )
	{
		$m = explode ('|',$txt['message']);
		$k=1;
		$m[1] = htmlspecialchars ($m[1]);
		if (substr_count($m[0],'saling#'))
		{
			echo "top.Funcy('salingFORM.php?id=".str_replace("saling#","",$m[0])."');";// - продажа
			$k=0;
		}
		elseif ($m[1])
		$txt['message']="Персонаж <b>".$m[0]."</b> передал вам <b>".$m[1]."</b> .";			// - передача
	}
	if ($txt["user"]=='#W') 
	{
		echo "top.frames['ch_list'].location='weather.php';";
		$k = 0;
	}
	// КОНЕЦ системным сообщениям
	$txt['message'] = str_replace('"',"",$txt['message']);
	$txt['message'] = str_replace("'","",$txt['message']);
	if ($k==1) 
	{
		$s.= "'".$txt['time']."•".$txt['user']."•".$txt['towho']."•".$txt['message']."•".$txt['private']."•".$txt['color']."•".$txt['type']."•',";
	}
}

if ($pers['curstate']==4)
{
	$res = $db->sql("SELECT `time`,`log` FROM `fight_log` WHERE `cfight`=".$pers['cfight']." and `turn`>".$pers['lasto']);
	while( $txt = mysql_fetch_row($res) ) $s.= "'".$txt[0]."•••".addslashes($txt[1])."•0•222222•3•',";
}

###########
/*
if($VIP==true or $uid==7)
{
	$s.= "'•Сервер••Время работы: ".round(time()+microtime()-$server_state,3)."•0•265•0•',";
}
*/
#############
 
echo "var t = new Array (".substr($s,0,strlen($s)-1).");\n";
unset($s);
unset($res);
unset($txt);

if ( $pers['refr']==1 ) echo "top.re_up_ref();";
if ( $flood>4 and $pers['silence']<=tme() ) molch_bot(900,'Флуд');


if ( $a_m<>$pers['a_m'] or $flood<>$pers['flood'] )
	$db->sql("UPDATE `users` SET `a_m`='".$a_m."', `flood`='".$flood."' WHERE `uid`='".$uid."'");

$db->sql("UPDATE `users` SET `online`=1, `lasto`='".(tme())."', `chat_last_id`=".$pers['chat_last_id']." WHERE `uid`='".$uid."';");
echo "var img_pack = '".IMG."';\n";
echo "edit_msg(";
echo round(time()+microtime()-$server_state,3);
if ( $_GET['timer'] ) echo date(',H,i,s'); 
echo ");";
?>
</script>
