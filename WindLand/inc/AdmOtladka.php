<?php

$tmescript = round(microtime(true)-GLOBAL_START_TIME, 5);

if ( isset($_GET['adm_clear']) )
{
	switch($_GET['adm_clear'])
	{
		case 'cookie': foreach ($_COOKIE as $k=>$v) @setcookie($k,'',time()-3600); break;
		case 'session': session_destroy(); break;
	}
}


function forlist($arr){foreach($arr as $k=>$v)echo'<strong>'.$k.'</strong> = '.$v.'<br />';}


echo "\n\n\n\n\n\n\n";

$server_dir = str_replace('/', '\\', substr(ROOT, 0, strlen(ROOT)-7)); 
//echo $server_dir;
?>
<!-- ##### ADMIN INFO ##### -->
<br /><br />	<br /><br />	<br /><br />	<br /><br />	<br /><br />
<div align='center'>
	<div align="left" id="debug">
		<div style='background:#1d3652 url() repeat-x left 50%;color:#fff'>Отладочная информация</div>
		<div style='padding:5px;background:#8394B2;'><br />
<?php
	echo '<div class="tableborder"><div class="subtitle">Debug сообщения</div><div style="padding:6px; background-color:#fafbfc">';
		echo ' <strong>Время выполнения скрипта</strong> - '.(($tmescript>1) ? '<span style="color:red">'.$tmescript.'</span>' : '<span style="color:blue">'.$tmescript.'</span>').' сек.<br />';
		echo ' <strong>Загрузка CPU</strong> - Undefined<br />';
		echo '<strong>Серверное время</strong> - '.date('d.m.Y H:i:s',time()).'<br />';
		if ( !empty($php_errormsg) ) echo '<strong>PHP ошибка</strong> - '.$php_errormsg.'<br />';
	echo '</div></div><br />';
	###
	if ( !empty($_GET) )
	{
		echo '<div class="tableborder"><div class="subtitle">!GET данные ['.count($_GET).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($_GET);
		echo '</div></div><br />';
	}	
	
	if ( !empty($_POST) )
	{
		echo '<div class="tableborder"><div class="subtitle">!POST данные ['.count($_POST).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($_POST);
		echo '</div></div><br />';
	}
	
	if ( !empty($_COOKIE) )
	{
		echo '<div class="tableborder"><div class="subtitle">!COOKIE данные ['.count($_COOKIE).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($_COOKIE);
		echo '</div></div><br />';
	}
	###
	if ( $http->get )
	{
		echo '<div class="tableborder"><div class="subtitle">***GET данные ['.count($http->get).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($http->get);
		echo '</div></div><br />';
	}	
	
	if ( $http->post )
	{
		echo '<div class="tableborder"><div class="subtitle">***POST данные ['.count($http->post).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($http->post);
		echo '</div></div><br />';
	}
	
	if ( $http->cook )
	{
		echo '<div class="tableborder"><div class="subtitle">***COOKIE данные ['.count($http->cook).']</div><div style="padding:6px; background-color:#fafbfc">';
		forlist($http->cook);
		echo '</div></div><br />';
	}
			
	if ( !empty($_SESSION) )
	{
		echo '<div class="tableborder"><div class="subtitle">SESSION данные ['.count($_SESSION).']</div><div style="padding:6px; background-color:#fafbfc">';
		foreach ($_SESSION as $k=>$v)
		{
			echo '<strong>'.$k.'</strong> = ';
			if (is_string($v)) echo $v.'<br />';
			else { print_r($v); echo '<br />'; }
		}
		echo '</div></div><br />';
	}
	
	$included_files = get_included_files();
	echo '<div class="tableborder"><div class="subtitle">('.count($included_files).') подключенных файлов</div><div style="padding:6px; background-color:#fafbfc">';
	$sea = Array($server_dir, 'www', 'inc', 'configs', 'class', 'gamelpay', 'templates'); 
	$rep = Array('path: ', '<i>www</i>', '<b>inc</b>', '<span style="color:red">configs</span>', '<span style="color:blue">class</span>', '<span style="color:green">gamelpay</span>', '<span style="color:violet">templates</span>');
	foreach ($included_files as $filename)
	{
		$filename = str_replace($sea, $rep ,$filename);
		echo '<strong>'.$filename.'</strong><br />';
	}
	echo '</div></div><br />';
/*
	if (@$tpl==true)
	{
		echo '<div class="tableborder"><div class="subtitle">Загруженные шаблоны ['.$tpl->all_time.' sec]</div><div style="padding:6px; background-color:#fafbfc">';
		$res = '';
		foreach($tpl->all_log as $a) $res.= $a.', ';
		echo '<strong>'.$res.'</strong><br /></div></div><br />';
	}
*/
	if ( isset($db) )
	{
		echo '<div class="tableborder" style="overflow:auto"><div class="subtitle">MySQL Запросы ['.$db->all.']['.round($db->tme, 5).' sec]</div><div style="padding:6px; background-color:#fafbfc">';
		foreach($db->sql_all as $arr)
		{
			$a = $arr[0];
			$a = str_replace('SELECT','<span style="color:red">SELECT</span>',$a);
			$a = str_replace('UPDATE','<span style="color:blue">UPDATE</span>',$a);
			$a = str_replace('LEFT OUTER JOIN','<span style="color:red">LEFT OUTER JOIN</span>',$a);
			$a = str_replace(' ON ','<span style="color:red"> ON </span>',$a);
			$a = str_replace('FROM','<span style="color:green">FROM</span>',$a);
			$a = str_replace('SET','<span style="color:green">SET</span>',$a);
			$a = str_replace('WHERE','<span style="color:green">WHERE</span>',$a);
			$a = str_replace('INSERT INTO','<span style="color:violet">INSERT INTO</span>',$a);
			$a = str_replace('LIMIT','<span style="color:orange">LIMIT</span>',$a);
			$a = str_replace('ORDER BY','<span style="color:orange">ORDER BY</span>',$a);
			
			$a = str_replace(' and ','<span style="color:pink"> and </span>',$a);
			$a = str_replace(' or ','<span style="color:orange"> or </span>',$a);
			
			echo '<p style="padding:6px;border-bottom:1px solid black" title="'.$arr[1].' ('.$arr[2].')">'.$a.'</p>';
			
			
		}
		echo '</div></div>';
	}
	
	if ( isset($dbl) and false )
	{
		echo '<div class="tableborder" style="overflow:auto"><div class="subtitle"> Запросы ['.$dbl->all.']['.round($dbl->tme, 5).' sec]</div><div style="padding:6px; background-color:#fafbfc">';
		foreach($dbl->sql_all as $arr)
		{
			$a = $arr;
			$a = str_replace('SELECT','<span style="color:red">SELECT</span>',$a);
			$a = str_replace('UPDATE','<span style="color:blue">UPDATE</span>',$a);
			$a = str_replace('LEFT OUTER JOIN','<span style="color:red">LEFT OUTER JOIN</span>',$a);
			$a = str_replace(' ON ','<span style="color:red"> ON </span>',$a);
			$a = str_replace('FROM','<span style="color:green">FROM</span>',$a);
			$a = str_replace('SET','<span style="color:green">SET</span>',$a);
			$a = str_replace('WHERE','<span style="color:green">WHERE</span>',$a);
			$a = str_replace('INSERT INTO','<span style="color:violet">INSERT INTO</span>',$a);
			$a = str_replace('LIMIT','<span style="color:orange">LIMIT</span>',$a);
			$a = str_replace('ORDER BY','<span style="color:orange">ORDER BY</span>',$a);
			
			$a = str_replace(' and ','<span style="color:pink"> and </span>',$a);
			$a = str_replace(' or ','<span style="color:orange"> or </span>',$a);
			
			echo '<p style="padding:6px;border-bottom:1px solid black"'.$a.'</p>';
		}
		echo '</div></div>';
	}
?>

		</div>
		<a href="?">Обновить</a>
		<a href="?adm_clear=cookie">Очистить cookie</a>
	</div>
</div>