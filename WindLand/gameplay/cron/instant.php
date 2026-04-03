<?php
	## Раз N мин
	define('MICROLOAD', true);
	// Загружаем файл конфига, ВАЖНЫЙ.
	include ('../../configs/config.php');
	// Подключаемся к SQL базе
	$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
	############################## 
	include (ROOT.'/inc/func.php');
	
$db->sql("DELETE FROM `instant`");
$dragons[1] = array ('6002','6002');
$dragons[2] = array ('6000','6001');
$dragons[3] = array ('6004','6005');
for ($m=1,$n=3; $m<=$n; $m++)
{
	for ($a=1,$b=4; $a<=$b; $a++)
	{
		$type = round(rand(0,100));
		if ($type<25) $type=1;
		elseif ($type>=25 and $type<50) $type=2;
		elseif ($type>=50 && $type<75) $type=3;
		else $type=4;
		
		$bots = '';
		if ($type==1)
		{
			$t = round(rand(10,16));
			for ($g=0,$h=15; $g<$h; $g++)
			{
				if ($g>0) $bots.='|';
				$bots.='bot='.$dragons[$m][round(rand(0,count($dragons[$m])-1))];
			}
			$name = 'БИТВА ЗА ВЫЖИВАНИЕ';
			$count = 5;
			$insttype = 'alive';
		}
		elseif ($type==2)
		{
			$t = round(rand(8,14));
			for ($g=0,$h=11; $g<$h; $g++)
			{
				if ($g>0) $bots.='|';
				$bots.='bot='.$dragons[$m][round(rand(0,count($dragons[$m])-1))];
			}
			$name = 'МАРОДЕРЫ';
			$count=6;
			$insttype = 'murders';
		}
		elseif ($type==3)
		{
			$bots ='bot='.$dragons[$m][0];
			$t = round(rand(5,10));
			for ($g=0,$h=$t;$g<$h;$g++)
			{
				$bots.='|bot='.$dragons[$m][round(rand(1,count($dragons[$m])-1))];
			}
			$name = 'ОХОТНИКИ ЗА ДРАКОНАМИ';
			$count=4;
			$insttype = 'hunters';
		}
		elseif ($type==4)
		{
			$bots ='bot='.$dragons[$m][0];
			$t = 5;
			for ($g=0,$h=$t;$g<$h;$g++)
			{
				$bots.='|bot='.$dragons[$m][round(rand(1,count($dragons[$m])-1))];
			}
			$name = 'ПОСВЯЩЕНИЕ В ВОИНЫ';
			$count=1;
			$insttype = 'alone';
		}
		if ($m==1) $maxrank = 200;
		elseif ($m==2) $maxrank = 750;
		else $maxrank = 50000;
		$db->sql("INSERT INTO instant (`name`,`vs`,`count`, `level`, `place`, `rank`, `type`) VALUES ('".$name."','".$bots."','".$count."','".$m."', 'dungeon', '".$maxrank."', '".$insttype."')");
	}
}
say_to_chat('s',"В Подземелье драконов ведётся набор групп для похода на драконов!",0,'','*',0);

?>