<?php
if ($priv['equests']==0) exit;

$noatcion = true;

// Добавить нпс
if ( $http->_post('new_nps') and $priv['equests']==2 )
{
	$db->sql("INSERT INTO `jQuest_nps` (`x`, `y`, `img`, `active`,`name`) 
		VALUES ('".$http->_post('x')."', '".$http->_post('y')."', '".$http->_post('img')."', '".$http->_post('active')."', '".$http->_post('name')."');");
}
// удалить пнс
if ( $http->_get('del_nps') and $priv['equests']==2 )
{
	$rs = $db->sql('SELECT `id` FROM `jQuest_list` WHERE `nps_id` = '.$http->_get('del_nps').';');
	while ( $r = mysql_fetch_row($rs) ) $db->sql("DELETE FROM `jQuest_users` WHERE `qid` = ".$r[0].";");
	
	$db->sql("DELETE FROM `jQuest_nps` WHERE `qid` = ".$http->_get('del_nps')." LIMIT 1");
	$db->sql("DELETE FROM `jQuest_list` WHERE `nps_id` = ".$http->_get('del_nps').";");
	
}
// удалить квест
if ( $http->_get('del_quest') and $priv['equests']==2 )
{
	$db->sql("DELETE FROM `jQuest_list` WHERE `id` = ".$http->_get('del_quest')." LIMIT 1");
	$db->sql("DELETE FROM `jQuest_users` WHERE `qid` = ".$http->_get('del_quest').";");
}
// создать квест
if ( $http->_post('new_quest') and $priv['equests']==2 )
{
	$db->sql("INSERT INTO `jQuest_list` (`nps_id`, `name`, `min_level`, `max_level`, `repetition`, `runtime`, `text_start`, `text_action`, `text_finish`, `pre_quest`, `job_type`, `job_botname`, `job_lutname`, `job_success`, `job_count`, `priz_array`) 
		VALUES ('".$http->_post('new_quest')."', '".$http->_post('name')."', '".$http->_post('min_level')."', '".$http->_post('max_level')."', '".$http->_post('repetition')."', '".$http->_post('runtime')."', '".$http->_post('text_start')."', '".$http->_post('text_action')."', '".$http->_post('text_finish')."', '".$http->_post('pre_quest')."', '".$http->_post('job_type')."', '".$http->_post('job_botname')."', '".$http->_post('job_lutname')."', '".$http->_post('job_success')."', '".$http->_post('job_count')."', '".$http->_post('priz_array')."');");
}
// Редактировать нпс
if ( $http->_post('nps_edit') and $priv['equests']==2 )
{
	$db->sql("UPDATE `jQuest_nps` SET `x` = '".$http->_post('x')."', `y` = '".$http->_post('y')."', `img` = '".$http->_post('img')."', `active` = '".$http->_post('active')."', `name` = '".$http->_post('name')."' WHERE `qid` = '".(int)$http->_post('nps_edit')."' LIMIT 1;");
}
// отредактировать квест
if ( $http->_post('quest_eqit') and $priv['equests']==2 )
{
	$db->sql("UPDATE `jQuest_list` SET `name` = '".$http->_post('name')."', `min_level` = '".$http->_post('min_level')."', `max_level` = '".$http->_post('max_level')."', `repetition` = '".$http->_post('repetition')."', `runtime` = '".$http->_post('runtime')."', `text_start` = '".$http->_post('text_start')."', `text_action` = '".$http->_post('text_action')."', `text_finish` = '".$http->_post('text_finish')."', `pre_quest` = '".$http->_post('pre_quest')."', `job_type` = '".$http->_post('job_type')."', `job_botname` = '".$http->_post('job_botname')."', `job_lutname` = '".$http->_post('job_lutname')."', `job_success` = '".$http->_post('job_success')."', `job_count` = '".$http->_post('job_count')."', `priz_array` = '".$http->_post('priz_array')."' WHERE `id` = '".(int)$http->_post('quest_eqit')."' LIMIT 1;");
}

?>
<div class="inv" align="center">
	<table width="90%" class="but">
		<tr>
			<td class="but2"><a class="bga" href="main.php?new_nps=1">Создать NPS</a></td>
			<td class="but2"><a class="bga" href="main.php?go=administration">Вернутся в главное меню</a></td>
		</tr>
	</table>

<?php

if ( $http->_get('new_nps') and $priv['equests']>0 )
{
	$noatcion = false;
	echo '<form action="/main.php?" method="post"><input type="hidden" name="new_nps" value="1" /><table width="70%" class="but" style="text-align: center; border-collapse:collapse;">';
		echo '<tr> <td>X:</td> <td><input type="text" name="x" value="" /></td> </tr>';
		echo '<tr> <td>Y:</td> <td><input type="text" name="y" value="" /></td> </tr>';
		echo '<tr> <td>Картинка:</td> <td><input type="text" name="img" value="*.jpg" /></td> </tr>';
		echo '<tr> <td>Активен? (0-нет, 1-да)</td> <td><input type="text" name="active" value="1" /></td> </tr>';
		echo '<tr> <td>Имя NPS</td> <td><input type="text" name="name" value="" /></td> </tr>';
	echo '</table><input type="submit" value="Создать" /></form>';
}

if ( $http->_get('new_quest') and $priv['equests']>0 )
{
	$noatcion = false;
	echo '<form action="/main.php?" method="post"><input type="hidden" name="new_quest" value="'.$http->_get('new_quest').'" /><table width="70%" class="but" style="text-align: center; border-collapse:collapse;">';
		echo '<tr> <td>Название:</td> <td><input type="text" name="name" value="" /></td> </tr>';
		echo '<tr> <td>Мин. уровень: (0-любой)</td> <td><input type="text" name="min_level" value="0" /></td> </tr>';
		echo '<tr> <td>Макс. уровень: (0-любой)</td> <td><input type="text" name="max_level" value="0" /></td> </tr>';
		echo '<tr> <td>Повторение: (-1 - да, 0 - нет, 1+ - через N дней)</td> <td><input type="text" name="repetition" value="0" /></td> </tr>';
		echo '<tr> <td>Время на выполнение в секундах? (0-неограничено)</td> <td><input type="text" name="runtime" value="0" /></td> </tr>';
		echo '<tr> <td>Стартовый текст: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_start" ></textarea></td> </tr>';
		echo '<tr> <td>Текст актив. квеста: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_action" ></textarea></td> </tr>';
		echo '<tr> <td>Финальный текст: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_finish" ></textarea></td> </tr>';
		echo '<tr> <td>Предквест: (0-нету, указать ID квеста)</td> <td><input type="text" name="pre_quest" value="0" /></td> </tr>';
		echo '<tr> <td>Тип квеста:</td> <td><input type="text" name="job_type" value="1" /></td> </tr>';
		echo '<tr> <td>Имя бота, ресурка, локации ID (точное!)</td> <td><input type="text" name="job_botname" value="" /></td> </tr>';
		echo '<tr> <td>Имя дропа, для локаций указать имя:</td> <td><input type="text" name="job_lutname" value="" /></td> </tr>';
		echo '<tr> <td>Нашс выпадения:(1-100)</td> <td><input type="text" name="job_success" value="100" /></td> </tr>';
		echo '<tr> <td>Требуемое количество:</td> <td><input type="text" name="job_count" value="10" /></td> </tr>';
		echo '<tr> <td>Вознаграждение:</td> <td><textarea style="width:100%" rows=8 class=inv name="priz_array" ></textarea></td> </tr>';
	echo '</table><input type="submit" value="Создать квест" /></form>';
	echo '<div class="but" style="text-align: left;" width="70%">*Тип квеста: 1 - выбить предмет с бота, 2 - убить бота, 3 - примести ресурс, 4 - посетить локацию<br/><br />';
	echo '**Вознаграждение:<br />
		1 - лн, количество<br />
		2 - бр, количество<br />
		3 - вещь навсегда, ид вещи | время в секундах, для навсегда 0<br />
		4 - опыт, количество<br />
		5 - обнул, количество<br />
		Можно создавать несколько вариантов награды и несколько предметов в награду<br />
		Пример кода для 2х вариантов приза состоящего с 3х частей:<br />
		1|500,4|10000,3|1009|3600@2|50,5|1,3|1009|0<br />
		Первый вариант - 500 лн, 10к опыта, вещь на 1 час; второй вариант - 50 бр, 1 обнул, вещь навсегда
	</div>';
}

if ( $http->_get('nps_edit') and $priv['equests']>0 )
{
	$nps = $db->sqla('SELECT * FROM `jQuest_nps` WHERE `qid` = '.$http->_get('nps_edit').' LIMIT 1;');
	if ( $nps )
	{
		echo '<form action="/main.php?" method="post"><input type="hidden" name="nps_edit" value="'.$http->_get('nps_edit').'" /><table width="70%" class="but" style="text-align: center; border-collapse:collapse;">';
			echo '<tr> <td>X:</td> <td><input type="text" name="x" value="'.$nps['x'].'" /></td> </tr>';
			echo '<tr> <td>Y:</td> <td><input type="text" name="y" value="'.$nps['y'].'" /></td> </tr>';
			echo '<tr> <td>Картинка:</td> <td><input type="text" name="img" value="'.$nps['img'].'" /></td> </tr>';
			echo '<tr> <td>Активен? (0-нет, 1-да)</td> <td><input type="text" name="active" value="'.$nps['active'].'" /></td> </tr>';
			echo '<tr> <td>Имя NPS</td> <td><input type="text" name="name" value="'.$nps['name'].'" /></td> </tr>';
		echo '</table><input type="submit" value="Отредактировать" /></form>';
		$noatcion = false;
	}
}

if ( $http->_get('quest_eqit') and $priv['equests']>0 )
{
	$quest = $db->sqla('SELECT * FROM `jQuest_list` WHERE `id` = '.$http->_get('quest_eqit').' LIMIT 1;');
	if ( $quest )
	{
		echo '<form action="/main.php?" method="post"><input type="hidden" name="quest_eqit" value="'.$http->_get('quest_eqit').'" /><table width="70%" class="but" style="text-align: center; border-collapse:collapse;">';
			echo '<tr> <td>Название:</td> <td><input type="text" name="name" value="'.$quest['name'].'" /></td> </tr>';
			echo '<tr> <td>Мин. уровень: (0-любой)</td> <td><input type="text" name="min_level" value="'.$quest['min_level'].'" /></td> </tr>';
			echo '<tr> <td>Макс. уровень: (0-любой)</td> <td><input type="text" name="max_level" value="'.$quest['max_level'].'" /></td> </tr>';
			echo '<tr> <td>Повторение: (-1 - да, 0 - нет, 1+ - через N дней)</td> <td><input type="text" name="repetition" value="'.$quest['repetition'].'" /></td> </tr>';
			echo '<tr> <td>Время на выполнение в секундах? (0-неограничено)</td> <td><input type="text" name="runtime" value="'.$quest['runtime'].'" /></td> </tr>';
			echo '<tr> <td>Стартовый текст: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_start" >'.$quest['text_start'].'</textarea></td> </tr>';
			echo '<tr> <td>Текст актив. квеста: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_action" >'.$quest['text_action'].'</textarea></td> </tr>';
			echo '<tr> <td>Финальный текст: (акты разделить знаком @)</td> <td><textarea style="width:100%" rows=8 class=inv name="text_finish" >'.$quest['text_finish'].'</textarea></td> </tr>';
			echo '<tr> <td>Предквест: (0-нету, указать ID квеста)</td> <td><input type="text" name="pre_quest" value="'.$quest['pre_quest'].'" /></td> </tr>';
			echo '<tr> <td>Тип квеста:</td> <td><input type="text" name="job_type" value="'.$quest['job_type'].'" /></td> </tr>';
			echo '<tr> <td>Имя бота: (точное!)</td> <td><input type="text" name="job_botname" value="'.$quest['job_botname'].'" /></td> </tr>';
			echo '<tr> <td>Название дропа:</td> <td><input type="text" name="job_lutname" value="'.$quest['job_lutname'].'" /></td> </tr>';
			echo '<tr> <td>Нашс выпадения:(1-100)</td> <td><input type="text" name="job_success" value="'.$quest['job_success'].'" /></td> </tr>';
			echo '<tr> <td>Требуемое количество:</td> <td><input type="text" name="job_count" value="'.$quest['job_count'].'" /></td> </tr>';
			echo '<tr> <td>Вознаграждение:</td> <td><textarea style="width:100%" rows=8 class=inv name="priz_array" >'.$quest['priz_array'].'</textarea></td> </tr>';
		echo '</table><input type="submit" value="Отредактировать" /></form>';
		$noatcion = false;
	}
}




// Отображение главной таблички
if ( $noatcion )
{
	echo '<table width="90%" class="but" style="text-align: center; border-collapse:collapse;">';
	echo '<tr><td width="140" style="border: 1px solid #222222;">NPS</td><td style="border: 1px solid #222222;"><table width="100%" style="text-align:center;"><tr><td>ID</td><td>Название</td><td>От-до</td><td>Режим выполнения</td><td>Ограничение времени</td><td>Предквест</td><td>#</td></tr></table></td></tr>';
	$arr_nps = $db->sql('SELECT * FROM `jQuest_nps` ORDER BY `qid` ASC;');
	while ( $nps = mysql_fetch_assoc($arr_nps) )
	{
		echo '<tr valign="top" style="border: 1px solid #222222;"><td width="140" style="border: 1px solid #222222; padding: 5px;">
			<b>'.$nps['name'].'</b><br />
			<img src="http://'.HOST.'/public_content/faces/'.$nps['img'].'" width="130" height="130" border="0" style="cursor:pointer;" onClick="location = \'?nps_edit='.$nps['qid'].'\';" title="Редактировать NPS" /><hr>
			Коорд: '.$nps['x'].' : '.$nps['y'].'<br />
			Статус: '.($nps['active'] ? 'Активен' : 'Выкл').'<br />
			<a href="/main.php?new_quest='.$nps['qid'].'" class="bga">Добавить квест</a>
			<a href="javascript:if(confirm(\'Вы уверены что хотите удалить NPS? Так же удалятся и все квесты NPSa.\'))location=\'main.php?del_nps='.$nps['qid'].'\';" class="bga">Удалить NPS</a>
			</td><td style="border: 1px solid #222222; padding: 5px;"><table width="100%" style="text-align:center;">';
			$qs = $db->sql('SELECT * FROM `jQuest_list` WHERE `nps_id` = '.$nps['qid'].' ORDER BY `id` ASC;');
			while ( $q = mysql_fetch_assoc($qs) )
			{
				echo '<tr >';
				echo '<td><b>'.$q['id'].'</b></td>';
				echo '<td><a href="main.php?quest_eqit='.$q['id'].'" class="bg">'.$q['name'].'</a></td>';
				echo '<td>От '.$q['min_level'].' до '.$q['max_level'].'</td>';
				echo '<td>'.(($q['repetition']==-1) ? 'Можно повторить' : (($q['repetition']>0) ? 'Раз в '.$q['repetition'].' дней' : 'Нельзя повторить')).'</td>';
				echo '<td>'.($q['runtime'] ? 'Выполнить за '.tp($q['runtime']) : 'Не ограничено').'</td>';
				echo '<td>'.($q['pre_quest']?'Да':'Нет').'</td>';
				echo '<td><a href="javascript:if(confirm(\'Вы уверены что хотите удалить квест?\'))location=\'main.php?del_quest='.$q['id'].'\';" class="bga">Удалить</a></td>';
				echo '</tr>';
			}
		echo '</table></td></tr>';
	}
	echo '</table>*У одного NPS одновременно можно взять только 1 квест.';
}
?>
</div>