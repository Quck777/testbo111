<?php
if ($p22<>1) exit;

	$pst = Array(); $dmt = Array();

	$wclan = $db->sql("SELECT * FROM `clans_log` WHERE `uid`=".$player->pers['uid']."  ORDER BY `date` DESC");
	while( $wc = mysql_fetch_assoc($wclan) )
	{
		$cln = $db->sqlr('SELECT `name` FROM `clans` WHERE `sign`="'.$wc['sign'].'"');
		if ($wc['type']==3 or $wc['type']==4) 
			$pst[$cln] += (($wc['type']==3) ? $wc['text'] : 0)-(($wc['type']==4) ? $wc['text'] : 0);
			
		if ($wc['type']==8 or $wc['type']==9) 
			$dmt[$cln] += (($wc['type']==8) ? $wc['text'] : 0)-(($wc['type']==9) ? $wc['text'] : 0);
			
		
		$txt = ($wc['type']==1 or $wc['type']==2 or $wc['type']==6) ? $wc['who'] : $wc['text'];
		
		if ( isset($p22h) )
			$p22h .= ",['".date('d.m.y H:i:s',$wc['date'])."','".$txt."',".$wc['type'].", '".$wc['sign']."', '".$cln."']";
		else $p22h = "['".date('d.m.y H:i:s',$wc['date'])."','".$txt."',".$wc['type'].", '".$wc['sign']."', '".$cln."']";
	}
	unset($wc);
	
	
	echo "<SCRIPT>
	var date = [".$p22h."];
	view_signslog ();
	</SCRIPT>";
	foreach ($pst as $key=>$value)echo "<br>Баланс с кланом <b>".$key."</b> : ".$value.' LN';
	foreach ($dmt as $key=>$value)echo "<br>Баланс с кланом <b>".$key."</b> : ".$value.' Бр';
	echo '<br />';


?>