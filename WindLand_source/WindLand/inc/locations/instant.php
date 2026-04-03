<?php

$do = isset($http->get['do']) ? intval($http->get['do']) : 0;
$do = isset($http->post['do']) ? intval($http->post['do']) : $do;

echo '<div class="but" align="center"><table border="0" cellspacing="0" width="90%" class="but">
<tr>
	<td width="30%"><a href="main.php?do=1" class="'.(($do==1) ? 'bga' : 'blocked').'">В битву с драконом</a></td>
	<td width="30%"><a href="main.php?do=2" class="'.(($do==2) ? 'bga' : 'blocked').'">Лавка незнакомца</a></td>
	<td width="30%"><a href="main.php?do=3" class="'.(($do==3) ? 'bga' : 'blocked').'">Стражник у врат подземелья</a></td>
</tr>
</table>';

switch( $do )
{
	case 1: include('instant/dragons.php'); break;
	case 2: include('instant/lavka.php'); break;
	case 3: include('instant/vhod.php'); break;
	default: echo 'Выберите раздел.';
}
?>
</div>