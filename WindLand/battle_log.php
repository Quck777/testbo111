<?php

	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 
	
	$bid = intval($_GET["id"]);
	$page = intval($_GET["page"]);
	$results = intval($_GET["results"]);
	define("C_LIST",12);
	$pages = $db->sqlr("SELECT COUNT(*) FROM fight_log WHERE cfight=".$bid." ");
	$limits = $page*C_LIST; 
	if (!$results)
	{
		$res = $db->sql("SELECT * FROM fight_log WHERE cfight=".$bid." ORDER BY turn ASC LIMIT ".$limits.",".C_LIST."");
		while( $txt = $db->fetchAssoc($res) )
			$s.= "['".$txt["time"]."','".str_replace("'",'"',$txt["log"])."'],";
	}
	
	$battle = $db->sqla("SELECT travm,oruj,type,result,ltime,timeout FROM fights WHERE id=".$bid."");
	if ($results)
	{
		echo "<div id=info style='visibility:hidden;height:0px;top:-10000;position:absolute;z-index:2;'>".$battle["result"]."</div>";
	}
	$s = substr($s,0,strlen($s)-1);
	$injury = $battle["travm"];
	$ins = $battle["oruj"];
	$finished = ($battle["type"] == 'f')? 1 : 0;
	$ltime = $battle["timeout"] + $battle["ltime"] - tme();
	echo "<script>
			var bid = ".$bid.";
			var page = ".$page.";
			var pages = ".intval($pages/C_LIST).";
			var log = [".$s."];
			var inj = ".$injury.";
			var ins = ".$ins.";
			var fin = ".$finished.";
			var ltime = ".$ltime.";
			var results = ".$results.";
	</script>";		
?>
<SCRIPT src="/js/battle_log.js?12"></SCRIPT>
<SCRIPT SRC='js/c.js'></SCRIPT><SCRIPT SRC='js/end.js'></SCRIPT>