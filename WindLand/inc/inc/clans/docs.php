<?php // style="text-align: center;"
if ( defined('CLANS')==false ) {echo '<center>Ошибка.</center>'; exit;}

$glava = ($status == 'a' or $status == 'wg') ? true : false;

# Добавить
if ( isset($http->post['texta']) and $glava )
{
	$db->sql("INSERT INTO `document_orden` ( `puttime` , `tema` , `text` , `sign` ) 
	VALUES ('".tme()."', '".$http->post['texta']."', '".$http->post['textr']."', '".$clan["sign"]."');");
}
# Удалить
if ( isset($http->get['del']) and $glava )
{
	$db->sql('DELETE FROM `document_orden` WHERE `id` = "'.intval($http->get['del']).'" and `sign` = "'.$clan["sign"].'" ');
}

?>
<center>
<div style="width:800px" class="but">

<table width="100%">
<?php

$res = $db->sql('SELECT * FROM `document_orden` WHERE `sign` = "'.$clan['sign'].'";');
while ( $r = mysql_fetch_assoc($res) )
{
	echo '<tr><td width="30%" valign="top">
			<div style="text-align: center;">'.date('d.m.Y', $r['puttime']).'</div>
			<div style="text-align: center;">'.$r['tema'].'</div>
			<a href="?clan=doc&del='.$r['id'].'">Удалить</a> 
		</td><td>'.nl2br($r['text']).'</td></tr>';
	echo '<tr><td><hr/></td><td><hr/></td></tr>';
}
?>
</table>
<?php
if ($glava)
{
	echo '<form method="post">
		<input type="text" size="100" class="return_win" name="texta" />
		<textarea name="textr" class=return_win cols="100" rows="10"></textarea>
		<hr>
		<input type="submit" class="login" value="Отправить"></form>';
}
?>
</div>
</center>