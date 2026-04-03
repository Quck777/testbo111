<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################


$options = explode('|', $http->_cookie('options'));
if ( $http->_cookie('filter1') ) $f = explode('|', $http->_cookie('filter1'));
else $f = explode('|','shle|0|100|1000000|tlevel||elements||||||||');

if ( $http->_get('set_type') ) $f[0] = $http->_get('set_type');

if ( $http->_post('minlevel') )
{
	$f[1] = $http->_post('minlevel');
	$f[2] = $http->_post('maxlevel');
	$f[3] = $http->_post('maxcena');
	$f[4] = $http->_post('sort');
}

if ($http->_get('filter_f1'))		$f[5] = $http->_get('filter_f1');
if ($http->_get('filter_f2'))		$f[6] = $http->_get('filter_f2');
if ($http->_get('filter_f3'))		$f[7] = $http->_get('filter_f3');
if ($http->_get('filter_f4'))		$f[8] = $http->_get('filter_f4');
if ($http->_get('filter_f5'))		$f[9] = $http->_get('filter_f5');
if ($http->_get('filter_apps'))		$f[10]= $http->_get('filter_apps')-1;
if ($http->_get('cat'))				$f[11]= $http->_get('cat');
if ($http->_get('ar_loc'))			$f[12]= $http->_get('ar_loc');
if ($http->_get('filter_f6'))		$f[13]= $http->_get('filter_f6');
if ($http->_get('pers_sort'))		$f[14]= $http->_get('pers_sort');

$f = implode('|', $f);
if ( $http->_cookie('filter1') or $f<>$http->_cookie('filter1') )
{
	$http->setCook('filter1', $f);
	$http->cook['filter1'] = $f;
}

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html; charset=UTF-8");
?>