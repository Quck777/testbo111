<center width="100%" class="but"><b>Возможности министра</b>
<?php
if ($priv['level']>0)
{
	$_max = $db->sqla_id("SELECT `max_online`,`time_max_online` FROM `configs` LIMIT 0,1");
	$online = "Макс. Онлайн: <b>".$_max[0]."</b> | <span class=gray>".date("d.m.Y H:i",$_max[1])."</span>";
	
	$abb = '';
	$links = '';
	
	if ($priv['emain'] and $priv['level']==3) 
	{
		$abb .= "Вы <b>можете</b> управлять кабинетом министров.<br>";
		$links .= "<li><a class=bg href=main.php?go=ministers><img src=http://".IMG."/signs/admin/3.png> Кабинет министров</a></li>";
	}
	if ($priv['eusers'] and $priv['level']==3) 
	{
		$abb .= "Вы <b>можете</b> управлять населением мира.<br>";
		$links .= "<li><a class=bg href=main.php?go=users><img src=http://".IMG."/signs/admin/3.png> Население</a></li>";
	}
	
	if ($priv['emap'] and $priv['level']>=2) 
	{
		$abb .= 'Вы <b>можете</b> просматривать карту.<br>';
		if ($priv['emap']==2) $abb .= 'Вы <b>можете</b> изменять карту.<br>';
		$links .= '<li><a class=bg href=main.php?go=map_edit><img src=http://'.IMG.'/signs/admin/2.png> Редактор карты</a></li>';
	}
	if ($priv['ewp'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> просматривать вещи.<br>";
		if ($priv['ewp']==2) $abb .= "Вы <b>можете</b> изменять вещи.<br>";
		$links .= "<li><a class=bg href=main.php?go=weapons><img src=http://".IMG."/signs/admin/2.png> Редактор вещей</a></li>";
	}

	if ($priv['eclans'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> просматривать кланы.<br>";
		if ($priv['eclans']==2) $abb .= "Вы <b>можете</b> изменять кланы.<br>";
		$links .= "<li><a class=bg href=main.php?go=aclans><img src=http://".IMG."/signs/admin/2.png> Редактор кланов</a></li>";
	}
	
	if ($priv['emagic'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> управлять магией в мире.<br>";
		$links .= "<li><a class=bg href=main.php?go=magic><img src=http://".IMG."/signs/admin/2.png> Магия</a></li>";
	}
	if ($priv['equests'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> управлять квестами.<br>";
		$links .= "<li><a class=bg href=main.php?go=quests><img src=http://".IMG."/signs/admin/2.png> Квесты</a></li>";
	}
	if ($priv['ebots'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> управлять существами мира.<br>";
		$links .= "<li><a class=bg href=main.php?go=bots><img src=http://".IMG."/signs/admin/2.png> Боты</a></li>";
	}
	if ($priv['etavern'] and $priv['level']>=2) 
	{
		$abb .= "Вы <b>можете</b> управлять таверной.<br>";
		$links .= "<li><a class=bg href=main.php?go=tavern><img src=http://".IMG."/signs/admin/2.png> Таверна</a></li>";
	}	
	if ($priv['ejour'] and $priv['level']>=1) 
	{
		$jms = (int)$db->sqlr('SELECT COUNT(date) FROM `support` WHERE `closed`>0 ;',0);
		$abb .= "Вы <b>можете</b> управлять средствами масс-медиа.<br>";
		$links .= "<li><a class=bg href=main.php?go=jour><img src=http://".IMG."/signs/admin/1.png> Масс-медиа (журналистика) [{$jms}]</a></li>";
		unset($jms);
	}
	
	$req = $db->sqlr("SELECT COUNT(*) FROM `avatar_request`");
	$links .= "<li><a class=bg href=main.php?go=ava_req><img src=http://".IMG."/signs/admin/1.png> Одобрить образ [<b class=user>".$req."</b>]</a></li>";
	if (UID==1 or UID==7) $links .= "<li><a class=bga href=main.php?go=admdlr><img src=http://".IMG."/signs/diler.gif> Управление дилерами</a></li>";
	if (UID==1 or UID==7) $links .= "<li><a class=bga href=main.php?go=imgloader>Загрузчик картинок</a></li>";
	
	
	echo "<br>Должность: Создатель мира назначил вас на должность <b>".$priv['status']."</b><br>";
	echo "<center class=but>".$online."<div style='width:60%'><ul class=but>".$links."</ul></div><p>".$abb."</p></center>";
}
/*
if ($_GET['reGHesh']==1)
{
	$hesh = rand(10000, 10000000);
	if(sql('INSERT INTO `invitation` ( `hesh`, `you`) VALUES ('.$hesh.', '.$pers['uid'].');'))
	echo 'Создан новый пригласительный ключ № <b>'.$hesh.'</b>';
	else echo 'Ошибка.';
}

echo '<br /><br /><a class=bg href=main.php?reGHesh=1>Сгенерировать пригласительный ключ</a><br />';
*/
?>
</center>