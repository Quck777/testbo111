<?php
if (!file_exists(SERVICE_ROOT."/events/L".date("d-m-y").".txt"))
{
	$res = $db->sql("SELECT sign,user,aura,level,state,exp,losses,victories,money,uid,rank_i,sp11
	 FROM `users` WHERE 
	 priveleged = 0
	 and
	 block=''
	 and
	 lasto<>0
	  ORDER BY 
	  (sp11) DESC LIMIT 0 , 20");

	$top = "var list=new Array(\n";
	$i=0;
	while ($r=$db->fetchArray($res)) 
	{

	 $stats = floor($r["sp11"]);

	 if ($i<>0) $top .= ",";
	 $i++;
	 if ($r["sign"]=='') $r["sign"]="none";
	 $r["state"]=str_replace("|","",$r["state"]);
	 $top .= "'".$r["user"]."|".$r["level"]."|".$r["sign"]."|".$r["state"]."|".abs($stats)."|".$z."|".$r["id"]."|";
	 $top .= "'";
	}
	$top .= ");";
	$top .= "show_list ('0+');";
	$f = fopen (SERVICE_ROOT."/events/L".date("d-m-y").".txt","w");
	fwrite($f,$top);
	fclose($f);
}
?>