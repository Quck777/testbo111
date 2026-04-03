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

$player->pers = $db->sqla('SELECT * FROM `users` WHERE `uid`="'.abs(intval($_COOKIE['uid'])).'" and `pass`="'.addslashes($_COOKIE['hashcode']).'" and `block`="" LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if ( !$player->pers ) exit;

	include (ROOT.'/inc/func.php');
	include (ROOT.'/inc/func2.php');
	include (ROOT.'/inc/battle_func.php');

?>
<META Content="text/html; Charset=windows-1251" Http-Equiv=Content-type>
<META Http-Equiv=Cache-Control Content=No-Cache>
<META Http-Equiv=Pragma Content=No-Cache>
<META Http-Equiv=Expires Content=0>
<LINK href="/css/main_v2.css" rel=STYLESHEET type=text/css>
<title>Wind Land</title>

<body topmargin="15" leftmargin="15" rightmargin="15" bottommargin="15" class=fightlong style="overflow:hidden;">

<?php

function ykind_stat($i)
{
	if($i>5) return "Настроен враждебно";
	elseif($i>3) return "Презирает вас";
	elseif($i>2) return "Не любит вас";
	elseif($i>0) return "Недолюбливает вас";
	elseif($i==0) return "Относится к вам нейтрально.";
}

$id = intval($_GET["id"]);
$rs = $db->sqla("SELECT * FROM residents WHERE id=".$id." and location='".$player->pers["location"]."'", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if (!$rs) exit('NPS не найден.');
$b = $db->sqlr("SELECT level FROM bots WHERE id=".$rs["id_bot"],0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);

$rel = $db->sqla("SELECT * FROM relationship WHERE uid=".$player->pers["uid"]." and rid=".$rs["id"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if(!$rel)
{
	$R = 0;	
	$db->sql("INSERT INTO `relationship` (`uid` ,`rid` ,`rel` )VALUES ('".$player->pers["uid"]."', '".$rs["id"]."', '0');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
}else $R = $rel["rel"];

$R += $player->pers["kindness"];

$_SPEECH = $rs["speechid"];

if(isset($_GET["say"]))
{
	$s = $db->sqla("SELECT * FROM speech WHERE id_from=".$player->pers["speechid"]." and id=".intval($_GET["say"]), __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if($s)
	{
		if($s["showcounts"] and !$player->pers["priveleged"])
		{
			if(mtrunc($s["showcounts"]-intval($db->sqlr("SELECT `count` FROM u_speech WHERE uid=".$player->pers["uid"]." and sid=".$s["id"]))))
				$_SPEECH = $s["id"];
		}
		else
			$_SPEECH = $s["id"];
	}
}
 
if(isset($_GET["tsay"]))
{
	$sp = $db->sqla("SELECT * FROM speech WHERE id=".intval($player->pers["speechid"]), __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$s = $db->sqla("SELECT * FROM speech WHERE id=".intval($_GET["tsay"]), __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if($s and $s["id"]==$sp["value"] and $sp["action"]==1)
	{
		if($s["showcounts"] and !$player->pers["priveleged"])
		{
			if(mtrunc($s["showcounts"]-intval($db->sqlr("SELECT `count` FROM u_speech WHERE uid=".$player->pers["uid"]." and sid=".$s["id"],0, __FILE__,__LINE__,__FUNCTION__,__CLASS__))))
				$_SPEECH = $s["id"];
		}
		else
			$_SPEECH = $s["id"];
	}
}

echo "<div style='float:left;height:100%;width:200px;border-right-style: solid; border-right-color: #2B587A; border-right-width:1px;'><table class=but width=100% height=100%><tr><td valign=center align=center>
<b class=timef>".kind_stat($rs["kindness"])."</b>
<b class=user>".$rs["name"]."</b> <b class=lvl>[".$b."]</b><br><span class=gray>".$rs["description"]."</span>
<img src='images/persons/".$rs["image"].".gif'><br>
<span class=about>".ykind_stat(abs($R))."</span>
</td></tr></table>
</div>";


echo "<div style='float:right;height:100%;width:70%;'><table width=100% height=80%><tr><td valign=center>";

if($player->pers["cfight"])
	echo "<span class=about>Вы не можете разговаривать в бою.</span>";
else

if(!$_SPEECH)
	echo "<span class=about>Мне нечего тебе сказать.</span>";
else
{
	echo "<div style='width:80%'>";
	$sp = $db->sqla("SELECT * FROM speech WHERE id=".$_SPEECH, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$prehistory = $sp["prehistory"];
	$text = $sp["text"];
	$text = str_replace("%s",$player->pers["user"],$text);
	$text = str_replace("%l",$player->pers["level"],$text);
	
	if($R==-7)
		begin_fight ("bot=".$rs["id_bot"],$player->pers["user"],"Нападение",80,100,1,0);
	
	if(($sp["relation"]>0 and $R>$sp["relation"]) or ($sp["relation"]<0 and $R<$sp["relation"]) or $sp["relation"]==0)
	{
	
	if($sp["showcounts"])
	{
		$c = $db->sqlr("SELECT COUNT(*) FROM u_speech WHERE uid=".$player->pers["uid"]." and sid=".$sp["id"],0, __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		if($c)
			$db->sql("UPDATE u_speech SET `count`=`count`+1 WHERE uid=".$player->pers["uid"]." and sid=".$sp["id"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		else
			$db->sql("INSERT INTO `u_speech` (`uid` ,`sid` ,`count` )VALUES ('".$player->pers["uid"]."', '".$sp["id"]."', '1');", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	}
		
	## Делаем действие здесь
	
	/*
		$atype = '<select name=atype id=atype onchange="atype_ch()">';
		$atype .= '<option value=0 SELECTED>Ничего</option>';
		$atype .= '<option value=1>Перейти на речёвку</option>';
		$atype .= '<option value=2>Закрыть окно общения</option>';
		$atype .= '<option value=3>Выдать квест</option>';
		$atype .= '<option value=4>Написать фразу в чат</option>';
		$atype .= '<option value=5>Начать бой с говорящим</option>';
		$atype .= '<option value=6>Выдать опыта</option>';
		$atype .= '<option value=7>Выдать денег</option>';
		$atype .= '<option value=8>Выдать бриллиантов</option>';
		$atype .= '<option value=9>Выдать пергаментов</option>';
		$atype .= '<option value=10>Вылечить травму</option>';
		$atype .= '<option value=11>Телепортировать</option>';
		$atype .= '</select>';
		
		*/
		
	if($sp["action"]==2)
		echo "<script>top.FuncyOff();</script>";
	if($sp["action"]==1)
		echo "<script>location = 'speech.php?id=".$id."&tsay=".$s["value"]."';</script>";
	if($sp["action"]==4)
		say_to_chat($rs["name"],$sp["value"],1,$player->pers["user"],'*');
	if($sp["action"]==5)
	{
		begin_fight ("bot=".$rs["id_bot"],$player->pers["user"],"Сражение",80,2,1,0);
		echo "<script>top.FuncyOff();</script>";
	}
	if($sp["action"]==6)
		{
			set_vars("exp=exp+".intval($sp["value"]),$player->pers["uid"]);
			say_to_chat('a',"<b>".$rs["name"]."</b> подарил вам ".intval($sp["value"])." опыта.",1,$player->pers["user"],'*');
		}
	if($sp["action"]==7)
		{
			set_vars("money=money+".intval($sp["value"]),$player->pers["uid"]);
			say_to_chat('a',"<b>".$rs["name"]."</b> подарил вам ".intval($sp["value"])." LN.",1,$player->pers["user"],'*');
		}
	if($sp["action"]==8)
		{
			set_vars("dmoney=dmoney+".intval($sp["value"]),$player->pers["uid"]);
			say_to_chat('a',"<b>".$rs["name"]."</b> подарил вам ".intval($sp["value"])." БР.",1,$player->pers["user"],'*');
		}
	if($sp["action"]==9)
		{
			set_vars("coins=coins+".intval($sp["value"]),$player->pers["uid"]);
			say_to_chat('a',"<b>".$rs["name"]."</b> подарил вам ".intval($sp["value"])." перг.",1,$player->pers["user"],'*');
		}
	if($sp["action"]==10)
		{
			$a = $db->sqlr("SELECT name FROM p_auras WHERE uid=".$player->pers["uid"]." and special>=3 and special<=5 and esttime>".tme()." LIMIT 1;");
			$db->sql("UPDATE p_auras SET esttime=0 WHERE uid=".$player->pers["uid"]." and special>=3 and special<=5 and esttime>".tme()." LIMIT 1;");
			if($a)	
				say_to_chat('a',"<b>".$rs["name"]."</b> вылечил вас от <b>".$a."</b>.",1,$player->pers["user"],'*');
		}
	if($sp["action"]==11)
		{
			list($loc,$x,$y) = explode("|",$sp["value"]);
			set_vars("location='".$loc."',x=".$x.",y=".$y,$player->pers["uid"]);
			say_to_chat('a',"<b>".$rs["name"]."</b> телепортировал вас.",1,$player->pers["user"],'*');
		}
		//
	#####
	
	if($prehistory)
	echo "<i>".$prehistory."</i><br><br>";
		
	if($sp["answer"])
		echo "<span class=gray><b>Вы:</b> -".$sp["answer"]."</span><br>";
	echo "<span class=about><b>".$rs["name"].":</b> -".$text."</span>";	
	
	$sps = $db->sql("SELECT * FROM speech WHERE id_from=".$sp["id"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$table = '<center><br><br><table border=0 width=80% cellspacing=0 cellspadding=0>';
	while($s = mysql_fetch_array($sps))
	{
		if($s["showcounts"])
		{
			if(!mtrunc($s["showcounts"]-intval($db->sqlr("SELECT `count` FROM u_speech WHERE uid=".$player->pers["uid"]." and sid=".$s["id"]))))
			{ 
				if(!$player->pers["priveleged"])	continue;
			}
			$table .= "<tr><td class=gray valign=center style='height:30px'>[ЗАКОНЧИЛОСЬ]<a class=nt href=speech.php?id=".$id."&say=".$s["id"]."><img src=images/icons/right.png> &nbsp; <u>".$s["answer"]."</u></a></td></tr>";
		}
		else
		$table .= "<tr><td class=gray valign=center style='height:30px'><a class=nt href=speech.php?id=".$id."&say=".$s["id"]."><img src=images/icons/right.png> &nbsp; <u>".$s["answer"]."</u></a></td></tr>";
	}
	$table .= "<tr><td class=gray valign=center style='height:30px'><a class=nt href='javascript:top.FuncyOff();'><img src=images/icons/right.png> &nbsp; <u>Я, пожалуй, пойду...</u></a></td></tr>";
	$table .= '</table></center>';
	echo $table;
	echo "</div>";
	}elseif($sp["relation"]>0)
	{
		echo "Я тебя не уважаю, чтобы разговаривать с тобой на такие темы!";
	}
	elseif($sp["relation"]<0)
	{
		echo "Ты мне слишком симпатичен, чтобы говорить с тобой об этом.";
	}
	$db->sql("UPDATE relationship SET rel=rel+".$sp["kindup"]." WHERE uid=".$player->pers["uid"]." and rid=".$rs["id"], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	$player->pers["kindness"] += $sp["kindup"]/$db->sqlr("SELECT COUNT(*) FROM `residents`");
	set_vars("speechid=".$sp["id"].",kindness=".$player->pers["kindness"],$player->pers["uid"]);
}
echo "</td></tr></table>
</div>";
?>

</body>