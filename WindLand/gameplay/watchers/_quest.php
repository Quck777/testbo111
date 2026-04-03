<?php
if ($p26<>1) exit;

function qjob_type($qu)
{
	$r = '';
	switch ($qu['job_type'])
	{
		case 1: $r = 'отобрать у <a href="/binfo.php?name='.$qu['job_botname'].'" target="_blank"><b>'.$qu['job_botname'].'</b></a>'; break;
		case 2: $r = 'охота на <a href="/binfo.php?name='.$qu['job_botname'].'" target="_blank"><b>'.$qu['job_botname'].'</b></a>'; break;
		case 3: $r = 'принести <b>'.$qu['job_botname'].'</b>'; break;
		case 4: $res = explode('|', $qu['job_botname']);
				$r = 'посетить <b>'.$qu['job_lutname'].'</b>';
			break;
	}
	return $r;
}

function qjob_result($qu)
{
	$r = '';
	switch ($qu['job_type'])
	{
		case 1: $r = $qu['job_result'].'/'.$qu['job_count']; break;
		case 2: $r = $qu['job_result'].'/'.$qu['job_count']; break;
		case 3: $r = (($qu['job_result']==$qu['job_count']) ? $qu['job_result'] : '?/'.$qu['job_count']); break;
		case 4: $r = (($qu['job_result']==$qu['job_count']) ? 'готово': 'не выполнено'); break;
	}
	return $r;
}

$quest_user = $db->sql('SELECT * FROM `jQuest_users` WHERE `uid` = '.$player->pers['uid'].' ORDER BY `start_time` DESC;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
echo '<table width="90%" border="1" cellspacing="0" cellpadding="0" class="but" style="text-align: center;">';
while ( $qu = mysql_fetch_assoc($quest_user) )
{
	switch ($qu['finish'])
	{
		case 0: $color = '#FFDDDD';$tt = '¬ыполн€етс€'; break;
		case 1: $color = '#DDAAAA';$tt = '«авершен'; break;
	}
	
	echo '<tr>';
	echo '<td bgcolor="'.$color.'">'.date('d.m.y H:i', $qu['start_time']).'</td>';
	echo '<td>'.$qu['name'].'</td>';
	echo '<td>'.$tt.' '.($qu['finish']?date('d.m.y H:i', $qu['finish_time']):'').'</td>';
	echo '<td>'.(!$qu['finish']?($qu['runtime']? tp($qu['start_time']-tme()+$qu['runtime']) : 'не ограничено'):'').'</td>';
	echo '<td>'.qjob_type($qu).'</td>';
	echo '<td>'.qjob_result($qu).'</td>';
	echo '</tr>';
}
echo '</table>';


?>