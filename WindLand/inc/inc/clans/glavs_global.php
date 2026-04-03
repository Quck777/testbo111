<?php
if ( defined('CLANS')==false ) {echo '<center>Ошибка.</center>'; exit;}
$TIME_NO = Array( ((24*3600)*1), ((24*3600)*30) ); // 30 дней заявка, 1 день время на подтверждение


if ( $http->_post('zp_login') and $http->_post('zp_count') and $status=='wg' )
{
	$pr = $db->sqla('SELECT `uid`, `sign`, `wmoney` FROM `users` WHERE `user` = "'.$http->_post('zp_login').'";');
	if ( $pr['sign']=='watchers' )
	{
		$pr['wmoney']+= (int)$http->_post('zp_count');
		$db->sql('UPDATE `users` SET `wmoney` = '.$pr['wmoney'].' WHERE `uid` = '.$pr['uid'].';');
		report('Выплачено.');
	} else report('Нет такого персонажа или он не состоит в клане.');
}





####### Начинаем обработку клиентской части
$e_res = '';
$res = $db->sql('SELECT * FROM `clans_souz` ORDER BY `date`;');
while ( $r = $db->fetchAssoc($res) )
{
	$conets = ($r['date']+$TIME_NO[$r['status']]) - tme();
	$e_res.= (empty($e_res) ? '' : ',').'["'.$r['id'].'","'.$r['sign'].'","'.$r['name'].'","'.$r['sign2'].'","'.$r['name2'].'","'.tp($conets).'",'.$r['type'].','.$r['status'].','.$r['gonorar'].','.$r['count'].']';
}
?>
<script>
var data = [<?=$e_res;?>];
</script>
