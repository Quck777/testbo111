<?php

if (!file_exists(SERVICE_ROOT."/events/A".date("d-m-y").".txt"))
{
$res = $db->sql("SELECT *
	FROM `users` WHERE 
	priveleged = 0
	and
	block=''
	and
	lasto<>0
	ORDER BY 
	( ((`victories`-`losses`)+`exp`+(`rank_i`*100)+(`timeonline`/`level`))*`level` ) DESC LIMIT 0, 200;");
//	(`victories`-`losses`)+(`rank_i`*100)+(`lastom`/50)+(`exp`/(`level`*30))+`timeonline` DESC LIMIT 0, 100;");
//	(level*3000+exp/(victories+losses+1)+(victories-losses) + rank_i*100) DESC LIMIT 0 , 100");
if (!isset($z)) $z = '';
$top = "var list=new Array(\n";
$i=0;
while ($r=mysql_fetch_array($res)) 
{

// $stats = floor(($r["level"]*3000+ $r["exp"]/($r["victories"]+$r["losses"]+1)+($r["victories"]-$r["losses"])+ 100*$r["rank_i"]));
	$stats = floor(($r['victories']-$r['losses'])+($r['rank_i']*100)+($r['rank_i']/50)+($r['exp']/$r['level']*30)+$r['timeonline']);
	if ($i<>0) $top .= ",";
	$i++;
	if ($r["sign"]=='') $r["sign"]="none";
	$r["state"]=str_replace("|","",$r["state"]);
	$top .= "'".$r["user"]."|".$r["level"]."|".$r["sign"]."|".$r["state"]."|".abs($stats)."|".$z."|".$r["uid"]."|";
	$top .= "'";
}
$top .= ");";
$top .= "show_list ('0+');";
$f = fopen (SERVICE_ROOT."/events/A".date("d-m-y").".txt","w");
fwrite($f,$top);
fclose($f);
}
?>