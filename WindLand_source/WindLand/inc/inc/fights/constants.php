<?
// ЦВЕТА
	$colors[1] = "#087C20";
	$colors[2] = "#0052A6";
	$colors[3] = "#444400";
	$colors[4] = "#002222";
	$colors[5] = "#FF0088";
	$colors[6] = "#800080";
	$colors[7] = "#077777";
	$colors[8] = "#900900";
///////////////////////////
	// Лог боя. Половой признак
	if ($player->pers["pol"]=='female') $male='а'; else $male='';
		if ($male=='а') 
		$pitalsa = 'пыталась';
		else
		$pitalsa = 'пытался';
		
		if ($persvs["pol"]=='female')
		 {
			$pogib = 'погибла';
			$malevs='а';
			$yvvs = 'увернулась';
		 }
		else
		 {
			$pogib = 'погиб';
			$malevs='';
			$yvvs = 'увернулся';
		 }
/////////////////////////////
$magic=0;
 if ( $http->_post('p') )
 {
	if ($http->_post('ug')){$point="ug";$http->post[$point] = 'magic';$http->post[$point."p"] = $http->post["p"];$http->post["magic"]=1;}
	if ($http->_post('ut')){$point="ut";$http->post[$point] = 'magic';$http->post[$point."p"] = $http->post["p"];$http->post["magic"]=1;}
	if ($http->_post('uj')){$point="uj";$http->post[$point] = 'magic';$http->post[$point."p"] = $http->post["p"];$http->post["magic"]=1;}
	if ($http->_post('un')){$point="un";$http->post[$point] = 'magic';$http->post[$point."p"] = $http->post["p"];$http->post["magic"]=1;}
	$magic=1;
 }
 if (@$http->post["ap"]) $magic = 2;
 // ^ Преобразование магического удара
?>