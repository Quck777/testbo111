<?php
if ($player->pers['sign']!='watchers' and !$priv) exit('5');

DEFINE ('WN_CURS', 100);

$rk = explode('|', $player->pers['rank']);



echo '<center><table width="90%" class="but"><tr><td><a class=bg href=main.php?w=shop>Лавка</a></td>';
if ($rk[50] or $status=='wg') echo '<td><a class=bg href=main.php?w=modr>Модерация</a></td>';
if ($rk[51] or $status=='wg') echo '<td><a class=bg href=main.php?w=werf>Проверки</a></td>';
if ($rk[52] or $status=='wg') echo '<td><a class=bg href=main.php?w=clan>Кланы</a></td>';
echo'</tr></table>';


switch ($http->_get('w'))
{
	case 'shop': $inc = 'shop'; break;
	case 'modr': $inc = 'moder'; break;
	case 'werf': $inc = 'werif'; break;
	case 'pers': $inc = ''; break;
	case 'clan': $inc = 'clan'; break;
#	case '':  $inc = ''; break;
#	case '':  $inc = ''; break;
#	case '':  $inc = ''; break;
#	case '':  $inc = ''; break;
	default: $inc = 'defailt';
}

include ('watchers/'.$inc.'.php');

?>