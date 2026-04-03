<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);

$pers = $db->sqla("SELECT `user`, `sign`, `diler`, `priveleged` FROM `users` WHERE `uid`=".intval($_COOKIE['uid']));

?>
<META Content="text/html; Charset=windows-1251" Http-Equiv=Content-type>
<LINK href="/css/main_v2.css" rel=STYLESHEET type=text/css>
<LINK href="/css/ch_main_v2.css" rel=STYLESHEET type=text/css>

<script type="text/javascript" language="javascript" src="/js/mod/jquery.js"></script>
<SCRIPT type="text/javascript" language="javascript" src="/js/mod/scrollto.js"></SCRIPT>

<body LeftMargin=0 TopMargin=0 RightMargin=0 MarginHeight=0 MarginWidth=0 bgcolor=F5F5F5 scroll="no">
<div style="position:absolute;width:30%;z-index:3;text-align:right;height:14px;top:0px;left:68%;display:block;"><div id="tbox" onmouseover="jQuery('#tbox').stop();jQuery('#tbox').animate({opacity:'1'},200);" onmouseout="jQuery('#tbox').stop();jQuery('#tbox').animate({opacity:'0.2'},200);"><a class=ActiveBc href="javascript:changeChatOrientation(1)" id=ch1>Общий</a> <a class=ActiveBc href="javascript:changeChatOrientation(2)" id=ch2>Торговый</a> <a class=ActiveBc href="javascript:changeChatOrientation(3)" id=ch3>Лог&nbsp;Боя</a></div></div>

<DIV id=menu class="menu"  style="display:none;"></DIV>

<script LANGUAGE="JavaScript" src="/js/chat_v2.js"></script>

<div id="chat" style="position:absolute;z-index:0;overflow-x:hidden;overflow-y:auto;display:block;width:100%;height:100%;"><div id=c1 style="display:none;"></div><div id=c2 style="display:none;"></div><div id=c3 style="display:none;"></div><div id=scrollitem style="display:block;"></div></div>


<SCRIPT LANGUAGE="JavaScript">
<?php
if (!$pers) echo "\jQuery(\"#chat\").html(\"Error:: Authentification;\");";
echo "var nick = '".$pers['user']."';";
if ( $pers['sign']=='watchers' or $pers['diler'] or $pers['priveleged'] ) echo "var molch=1;"; else echo "var molch=0;";
?>
changeChatOrientation(1);
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript" src="/js/ch_msg_v2.js"></SCRIPT>
</body>