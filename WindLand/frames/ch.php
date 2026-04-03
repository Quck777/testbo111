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
include (ROOT.'/inc/class/Player.php');
$player = new Player;
if ( !$player->pers ) exit;

// Подгружаем функции 
include (ROOT.'/inc/func.php');

# Обрабатываем конфиг с куков
$opt = explode('|', $http->cook['options']);
if ( $http->_get('sort') )
{
	if ($http->_get('sort')=='2') $opt[2]='0+'; 
	if ($http->_get('sort')=='1') $opt[2]='+0'; 
	if ($http->_get('sort')=='z') $opt[2]='z';
	if ($http->_get('sort')=='a') $opt[2]='a';
	$http->setCook('options', implode('|',$opt));
}
if ($opt[2]=='0+')$http->get['sort']='2';
if ($opt[2]=='+0')$http->get['sort']='1';
if ($opt[2]=='z')$http->get['sort']='z';


############################## 

	## Управление
	$place = $player->pers['location'];
	if ( $http->_get('ignore') )
	{
		$db->sql('INSERT INTO `ignor` (`uid` , `nick`) VALUES ('.$player->pers['uid'].', "'.$http->_get('ignore').'");');
	}
	if ( $http->_get('ignore_unset') )
	{
		$db->sql('DELETE FROM `ignor` WHERE `uid` = '.$player->pers['uid'].' and `nick` = "'.$http->_get('ignore_unset').'" ;');
	}
	if ( $http->_get('no_tip') )
	{
	//	$db->sql("INSERT INTO `no_tips` (`uid` , `tip_id`) VALUES (".$player->pers["uid"].", ".intval($_GET["no_tip"]).");");
	}
	###############################################################################
	
	
$preveleg = ($player->pers['sign']=='watchers' or $player->pers['diler'] or $player->pers['priveleged']) ? true : false;

if ($place<>'out') $locname = $db->sqlr('SELECT `name` FROM `locations` WHERE `id` = "'.$place.'" ;'); else $locname = $db->sqlr('SELECT `name` FROM `nature` WHERE `x`="'.$player->pers['x'].'" and `y`="'.$player->pers['y'].'" ;');
if ($player->pers['location']=='out') $arrloc = '`x`='.$player->pers['x'].' and `y`='.$player->pers['y'].';'; else $arrloc = '`location`="'.$player->pers['location'].'" ;';
$tyt = $db->sqlr('SELECT COUNT(uid) FROM `users` WHERE `online` = 1 and '.$arrloc);
$vsego = $db->sqlr('SELECT COUNT(uid) FROM `users` WHERE `online`= 1;');

// Получаем список NPS
/* $r = ''; 
if ($place<>'out') $rsds = $db->sql('SELECT * FROM `residents` WHERE `location`="'.$place.'";');
else $rsds = $db->sql('SELECT * FROM `residents` WHERE `x` = '.$player->pers['x'].' and `y`='.$player->pers['y'].' and `location`="out" ;');
while($rs = $db->fetchAssoc($rsds))
{
	$b = $db->sqlr("SELECT `level` FROM `bots` WHERE `id`=".$rs['id_bot']);
	$r.= "'".$rs['name']."|".$b."|".$rs['id']."|".$rs['id_bot']."'";
	$r.= ",\n";
}
*/


// Получаем список игрора
$ignore = '';
$ign = $db->sql('SELECT `nick` FROM `ignor` WHERE `uid`='.$player->pers['uid']);
while ($ig = $db->fetchAssoc($ign)) $ignore.= $ig['nick'].'|';


// Начинаем вывод контента
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: text/html; charset=UTF-8");
?>
<SCRIPT type="text/javascript" language="javascript" src="/js/ch_list_v2.js?2"></SCRIPT>
<SCRIPT type="text/javascript" language="javascript" src="/js/mod/jquery.js"></SCRIPT>
<DIV id=menu class="menu"  style="display:none;"></DIV>
<script>
<?php
echo "var img_pack = '".IMG."';\n";
echo "var locname = '".$locname."';\n";
echo "var xy='".($player->pers["x"])." : ".($player->pers["y"])."';\n";
echo "var vsg=".$vsego.";\n";
if ($preveleg) echo "var priveleged=1;\n"; else echo "var priveleged=0;\n";

$i = 0;
$s = "'Наставник|100|light;Истинный Свет|none||||0|||',\n";
if ( $http->_get('view') == 'this')
{
	if ( $place<>'out' ) $res = $db->sql('SELECT sign,align,user,level,state,diler,clan_name,uid,priveleged,silence,invisible,clan_state FROM `users` WHERE `online`=1 and (`location` = "'.$place.'");'); 
	else $res = $db->sql('SELECT sign,align,user,level,state,diler,clan_name,uid,priveleged,silence,invisible,clan_state FROM `users` WHERE `online` = 1 and `location` = "out" and `x` = '.$player->pers['x'].' and `y` = '.$player->pers['y'].';'); 
} else $res = $db->sql('SELECT sign,align,user,level,state,diler,clan_name,uid,priveleged,silence,invisible,clan_state FROM `users` WHERE `online`=1;');


while ( $row = $db->fetchAssoc($res) ) 
{
	## Убераем себя с онлайна, запарили
	if ( $row['uid'] == 7) continue;
	##
	
	$i++;
	$tr='';
	$trs = $db->sql("SELECT `special`,esttime FROM `p_auras` WHERE `uid`=".$row['uid']." and (`special`=3 or `special`=4 or `special`=5 or `special`=50) and `esttime`>".time()); 
	while($ttt = $db->fetchAssoc($trs))
	{
		if ($ttt['special']==3) $tr .= 'Легкая травма, еще '.tp($ttt['esttime']-time()).'<br />';
		if ($ttt['special']==4) $tr .= 'Средняя травма, еще '.tp($ttt['esttime']-time()).'<br />';
		if ($ttt['special']==5) $tr .= 'Тяжёлая травма, еще '.tp($ttt['esttime']-time()).'<br />';
		if ($ttt['special']==50) $tr .= 'Боевая травма, еще '.tp($ttt['esttime']-time()).'<br />';
	} substr($r,0,strlen($r)-2);
	$tr = ( strlen($tr)>5 ) ? substr($tr,0,strlen($tr)-6) : '';
	unset($clan);
	//$row["sign"] = 'watchers';
	if ( $row['sign']<>'none' and !empty($row['sign']) )
	{
		//if ($player->pers['clan_name'])
		$clan = $db->sqla_id('SELECT `name`,`level`,`align` FROM `clans` WHERE `sign`="'.$row["sign"].'" ;');
		$row['clan_name'] = $clan[0];
		$row['align'] = $clan[2];
		//sql("UPDATE `users` SET `clan_name`='".$row["clan_name"]."' WHERE `uid`=".$row["uid"]." ;");
		$row['state'] = $row['clan_name'].';'.$clan[1].';'.$row['clan_state'].';'.str_replace('|','!',str_replace(':',';',$row['state']));
		$row['sign'] = ($row['sign']=='watchers') ? $row['clan_state'] : $row['sign'];
	} else $row['state'] = '';
	
	unset($align);
	if (!empty($row['align']))
	{
		$align = $db->sqla_id('SELECT `align`,`name` FROM `aligns` WHERE `align` = "'.$row['align'].'" ;');
		$row['align'] = $align[0].';'.$align[1];
	} else $row['align'] = '';
	
	if ( $row['invisible']<=time() or $row['user']==$player->pers['user'] or $preveleg ) $inv = 1; else $inv=0;
	if ( $row['priveleged'] ) 
	{
		$prv = $db->sqla_id('SELECT `status`,`level` FROM `priveleges` WHERE `uid`='.$row['uid']);
		$prv = $prv[0].';'.$prv[1];
	} else $prv = '';
	if ($inv)
	{
		$row["state"] = str_replace("'","&quot;",$row["state"]);
		if ($row["invisible"]>time()) $row["user"]="n=".$row["user"];
		
		$s.= "'";
		
		$s.= $row['user']."|"; // Имя																	0
		$s.= $row['level']."|"; // Уровень																1
		$s.= $row['align']."|"; // Склонность															2
		$s.= $row['sign']."|"; // Клан																	3
		$s.= $row['state']."|"; // Должность в клане													4
		if ($row["silence"]>time()) $s.= tp($row["silence"]-time())."|"; else $s.= "|"; // Молчанка		5
		$s.= $tr."|"; // Травма																			6
		$s.= $row["diler"]."|"; // Дилер ли																7
		if (substr_count("|".$ignore,"|".$row["user"]."|")) $s.= ".|"; else $s.= "|"; // Есть ли игнор	8
		$s .= $prv."|"; // Есть ли значек админа														9
		
		$s .= "'";
	}
	if ($inv) $s.= ",\n";
}
echo "var list=new Array(\n";
echo substr($s,0,strlen($s)-2);
echo ");\n";
echo "var residents=new Array(\n";
echo substr($r,0,strlen($r)-2);
echo ");\n";

echo "var zds=".$tyt.";\nshow_head();\n";
echo "show_list ('".@intval($http->_get('sort'))."','".@$http->_get('view')."');\n";

if ($preveleg) echo "var molch=1;\n"; else echo "var molch=0;\n";
?>
</script>