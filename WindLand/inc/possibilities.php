<?php
//if (UID!=7) exit;

$do = isset($http->get['do']) ? intval($http->get['do']) : 0;
$do = isset($http->post['do']) ? intval($http->post['do']) : $do;

if ( isset($http->get['flush']) and $http->get['flush']=='obraz' and $player->pers['zeroing']>0)
{
	set_vars('`zeroing`=zeroing-1, `obr`=0', UID);
	$player->pers['zeroing']-=1;
}




echo '<center><table border="0" cellspacing="0" width="90%" class="but">
<tr>
	<td width="30%"><a href="main.php?addon=action&do=1" class="'.(($do==1) ? 'bga' : 'blocked').'">Возможности</a></td>
	<td width="30%"><a href="main.php?addon=action&do=2" class="'.(($do==2) ? 'bga' : 'blocked').'">Проверка на чистоту</a></td>
	<td width="30%"><a href="main.php?addon=action&do=3" class="'.(($do==3) ? 'bga' : 'blocked').'">Отчет безопасности</a></td>
	<td width="30%"><a href="main.php?addon=action&do=4" class="'.(($do==4) ? 'bga' : 'blocked').'">Квесты</a></td>
</tr>
</table>';

switch ($do)
{
	case 0: echo '<div align="center" class="but" width="90%">Выберите раздел</div>'; break;
	case 1: include('possibilities/vozm.php'); break;
	case 2: include('possibilities/verific.php'); break;
	case 3: include('possibilities/guard.php'); break;
	case 4: include('possibilities/quest_info.php'); break;
}


?>
