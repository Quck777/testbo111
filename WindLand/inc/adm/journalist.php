<?php
if ($priv['ejour']==0) exit;

$reprt = '';

if ($priv['ejour']==2)
{
	function send_mail($to, $body, $title=false)
	{
		$email = 'robot@'.HOST;
		$subject = ($title==false) ? HOST : htmlspecialchars($title);
		$headers = "From: ".HOST." <".$email.">\r\n";   
		$headers .= "Return-path: <".$email.">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=windows-1251;\r\n";
		
		$body.= '<br /><br />С Уважением, Администрация <a href=http://'.HOST.'/>'.HOST.'</a> &copy;';
		
		if( mail($to, $subject, $body, $headers) )
			return true;
		else
			return false;
	}
	
	if ( isset($http->post['newpasswduser']) and !empty($http->post['newpasswduser']) )
	{
		$usr = $db->sqla ('SELECT `user`, `uid`, `email` FROM `users` WHERE `user`="'.$http->post['newpasswduser'].'" and `priveleged`<>1');
		if ($usr['uid']>0)
		{
			$pass = rand(10000,100000);
			$flsh = "`pass`=MD5('".$pass."')";
			if ($http->post['newpasswdtype']==1) # На майл
			{
				if( send_mail($usr['email'], 'Пароль для <b>'.$usr['user'].'</b> успешно изменён на '.$pass, 'Восстановление пароля') )
					$reprt = 'Пароль успешно высталн на E-Mail: '.$usr['email'];
				else $reprt = 'Ошибка, ';
			}
			elseif ( $http->post['newpasswdtype']==2 ) # Вывод пароля
			{
				$reprt = $usr['user']." ::  Пароль успешно изменён на ".$pass;
			}
			elseif ( $http->post['newpasswdtype']==3 ) # Обнул флеша
			{
				$flsh = '`flash_pass`=0';
				$reprt = 'Флеш пароль обнулен.';
			}
			$db->sql("UPDATE `users` SET ".$flsh." WHERE `uid`='".$usr['uid']."' and `priveleged`<>1");
		} else $reprt = 'Персонаж не найден.';
	}

	function bbcode($str)
	{	
		# Преобразуем ссылки, лучше нечего не придумал.. тупо обрезать эту фигню, однако..
		$url = Array('http://','https://','ftp://');
		$str = str_replace($url,'',$str);
		$str = preg_replace('/\[URL\](.*?)\[\/URL\]/is','<a href=\'http://$1\' rel=nofollow target=_blank>http://$1</a>', $str);
		# Заменяем BB коды, на HTML сущности.. Таких тегов, думаю будет вполнее достаточно
		$code = Array('[B]','[/B]','[I]','[/I]','[U]','[/U]');
		$rep = Array('<strong>', '</strong>','<i>','</i>','<u>','</u>');
		$str = str_replace($code,$rep,$str);
		return $str;
	}



	if ( isset($http->post['ntitle']) )
	{
		$txt = bbcode($http->post['ntext']);
		if ( $db->sql("INSERT INTO `lib_news` ( `date` , `title` , `text`, `autor` ) VALUES ('".tme()."', '".($http->post['ntitle'])."', '".$txt."', '".$player->pers['user']."');")) 
			$reprt.= "Новость добавлена!<br />";
		if ($http->post['mail']==1)
		{
			set_time_limit(0);
			$tm = microtime(true);
			$i = 0;
			$i2 = 0;
			$ml = '';
			//  WHERE `uid`>0 ORDER BY `uid` LIMIT 0,1
			$mails = $db->sql ('SELECT `email`, `user` FROM `users` WHERE `block`="" and `mail_good`=1  ORDER BY `uid`;');
			while ( $m = mysql_fetch_row($mails) )
			{
				if ( filter_var($m[0], FILTER_VALIDATE_EMAIL)==true )
				{
					$mtxt = 'Здравствуйте, <b>'.$m[1].'</b>! Вы получили это письмо, так как являетесь зарегистрированным пользователем онлайн игры '.$_SERVER['SERVER_NAME'].'.<br /><br />'.nl2br($txt);
					$i++;
					if ( send_mail($m[0], $mtxt, $http->post['ntitle']) )
					{
						$i2++;
						echo $m[0].'<br />';
					}
				}
			}
			unset($m); unset($mtxt);
		//	$reprt.= 'Новость удачно отправлено на E-Mail. <br />Удачных отправок:'.$i2.'<br />Всего попыток:'.$i.'<br />';
		//	$reprt.= $ml;
			printf('Затрачено времени: <b>%f</b> сек.', microtime(true)-$tm);
		}
		say_to_chat('a','Опубликована новость «<b>'.($http->post['ntitle']).'</b>», <a href="/" target="_blank">подробнее..</a> (<b>'.$player->pers['user'].'</b>).',0,'','*',0); 
	}
	
	if ( isset($http->post['suplogin']) and !empty($http->post['suplogin']) )
	{
		$mai = $db->sqla_id ('SELECT `email`, `user` FROM `users` WHERE `user`="'.addslashes($http->post['suplogin']).'" ');
		if ( $mai[1]==$http->post['suplogin'] )
		{
			$txt = bbcode($http->post['supmsege']);
			$mtxt = 'Здравствуйте, <b>'.$mai[1].'</b>! Вы получили это письмо, так как являетесь зарегистрированным пользователем онлайн игры AloneIslands.Ru.<br /><br />'.nl2br($txt);
			if ( send_mail($mai[0], $mtxt, 'Support') )
				$reprt = 'Сообщение на E-Mail успешно отправлено для <b>'.$mai[1].'</b>.';
			else $reprt = 'Ошибка.';
		} else $reprt = 'Ошибка. Персонаж не найден.';
		unset($mai); unset($mtxt);
	}
	
	
	
	
	
}
?>
<center class="inv">
	<table width="90%" class="but">
		<tr>
			<td class=but2 width=30% colspan=6><a class=bga href=main.php?go=administration>Назад</a></td>
		</tr>
		<tr>
			<td class=but2 width=25%><a class=bg href=main.php?jo=news>Новости</a></td>
			<td class=but2 width=25%><a class=bg href=main.php?jo=helps>Подсказки</a></td>
			<td class=but2 width=25%><a class=bg href=main.php?jo=mails>E-mail</a></td>
			<td class=but2 width=25%><a class=bg href=main.php?jo=supp>Суппорт</a></td>
		</tr>
	</table>
</center>
<DIV class="inv">
<?php
if (!empty($reprt)) echo '<center class="but">'.$reprt.'</center>';


if ($http->get['jo']=='news') ### Новости
{
	$news = $db->sql('SELECT * FROM `lib_news` ORDER BY `date` DESC');
	if ( !isset($http->get['edit']) )
	{
		$jonewshlp = 'Вы можете использовать сервис добавления новостей, отправку новостей на E-Mail игрокам проекта. Помните, каждая добавленая Вами новость, будет прочитана нашими уважаемыми игроками. <br />Вы можете использовать ВВ коды, для выделения текста.<br />Доступные теги: <br />[B]<b>жирный</b>[/B], [I]<i>курсивный</i>[/I], [U]<u>подчеркнутый</u>[/U]';
		echo'<center><table width="90%" class="but"><form method=post action=main.php?jo=news>
		<tr><td>Тема: <input class=login name=ntitle size=50></td></tr>
		<tr><td>Отправить новость на e-mail игрокам, после добавления? <input type=checkbox name=mail value=1></td></tr>
		<tr><td><textarea name=ntext class=inv_button cols=50 rows=5></textarea></td><td>'.$jonewshlp.'</td></tr>
		<tr><td><center><input type=submit class=login value="Добавить новость"></center></td></tr>
		</form></table>';
		unset($new);
	}
	elseif ( isset($http->get['edit']) and empty($_POST) and $priv['ejour']==2 )
	{
		$new = $db->sqla_id("SELECT `title`, `text` FROM `lib_news` WHERE date='".intval($http->get['edit'])."'");
		$jonewshlp = 'Вы можете использовать сервис добавления новостей, отправку новостей на E-Mail игрокам проекта. Помните, каждая добавленая Вами новость, будет прочитана нашими уважаемыми игроками. <br />Вы можете использовать ВВ коды, для выделения текста.<br />Доступные теги: <br />[B]<b>жирный</b>[/B], [I]<i>курсивный</i>[/I], [U]<u>подчеркнутый</u>[/U]';
		echo'<center><table width="90%" class="but"><form method=post action=main.php?jo=news&edit='.$http->get['edit'].'>
		<tr><td>Тема: <input class=login name=edittitle size=50 value="'.$new[0].'"></td></tr>
		<tr><td><textarea name=edittext class=inv_button cols=50 rows=5>'.$new[1].'</textarea></td><td>'.$jonewshlp.'</td></tr>
		<tr><td><center><input type=submit class=login value="Отредактировать новость"></center></td></tr>
		</form></table>';
		unset($new);
	}
	if ( isset($http->get['delete']) and !empty($http->get['delete']) and $priv['ejour']==2 )
	{
		echo '<center><table width="90%" class="but">';
		if ($db->sql("DELETE FROM `lib_news` WHERE `date`='".intval($http->get['delete'])."'")) 
			echo "<tr><td><center class=time>Новость удачно удалена!</center></tr></td>";
		else
			echo "<tr><td><center class=time>Что-то не так.</center></tr></td>";
		echo '</table><center>';
		unset($new);
	}
	
	
	echo '<table width="90%" class="but">';
	while ( $new = mysql_fetch_assoc($news) )
	{
		echo "<tr>";
		echo "<td class=login width=105>".substr($new['title'],0,20)."</td>";
		echo "<td class=login width=20>".date('d.m.y H:i',$new['date'])."</td>";
		echo "<td class=login width=60%>".substr($new['text'],0,400)."</td>";
		echo "<td class=login width=25><a class=timef href=main.php?jo=news&edit=".$new['date']."><img src='http://".IMG."/icons/edit.png' title='Редактировать новость'></a> <a class=timef href=main.php?jo=news&delete=".$new['date']."><img src='http://".IMG."/icons/del.png' title='Удалить новость'></a></td>";
		echo "</tr>";
	}
	echo '</table>';
	
	echo '</center>';
} 
elseif ($http->get['jo']=='helps') ### Подсказки
{
	echo 'Подсказки';
}
elseif ($http->get['jo']=='mails') ### Рассылки на мыльник
{
	$jomailpers = 'Вы можете использовать сервис отправки сообщений на E-Mail.<br />Вы можете использовать ВВ коды, для выделения текста.<br />Доступные теги: <br />[B]<b>жирный</b>[/B], [I]<i>курсивный</i>[/I], [U]<u>подчеркнутый</u>[/U]';
	
	echo'<center><table width="90%" class="but"><form method=post action=main.php?jo=mails>
	<tr><td>Отправить сообщение на E-Mail персонажу</td></tr>
	<tr><td>Логин персонажа: <input class=login name=suplogin size=49></td></tr>
	<tr><td><textarea name=supmsege class=inv_button cols=50 rows=5></textarea></td><td>'.$jomailpers.'</td></tr>
	<tr><td><center><input type=submit class=login value="Отправить сообщение"></center></td></tr>
	</form></table>';

	echo '<table width="90%" class="but2"><form action=main.php method=post>
	<tr><td>Восстановление пароля: <select name=newpasswdtype><option value=1>Выслать на E-Mail</option><option value=2>Распечатать</option><option value=3>Обнулить Flash пароль</option></select></tr></td>
	<tr><td>Логин <input class=login type=text name=newpasswduser> <input type=submit value="Ок"> </tr></td>
	</form></table>';

	
}
elseif ($http->get['jo']=='supp')
{
	if ( isset($http->get['del']) ) $db->sql('DELETE FROM `support` WHERE `date` = '.intval(abs($http->get['del'])).' ;');
	if ( isset($http->get['ok']) ) $db->sql('UPDATE `support` SET `closed`='.UID.' WHERE `date`='.intval(abs($http->get['ok'])).' ;');
	
	$drs = isset($http->get['close']) ? '`closed`>0' : '`closed`=0';
	
	$res = $db->sql('SELECT * FROM `support` WHERE '.$drs.' ORDER BY `date` DESC;');
	echo "<table border=1 width=90% cellspacing=3 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF align=center><tr><td class=brdr><a href='main.php?jo=supp&close=1'>Отобразить проверенные</a></td></tr>";
	while ( $r = mysql_fetch_assoc($res) )
	{
		$who = $db->sqla('SELECT `user` FROM `users` WHERE `uid`='.$r['uid']);
		echo '<tr><td class=login><font class=ma  align=left>'.$r['title'].'</font> <div align=right>(<b>'.$who['user'].'</b>) '.date("d.m.Y H:i:s",$r['date']).'</div><a href=\'javascript:if(confirm("Удалить?")) location="main.php?jo=supp&del='.$r['date'].'";\'><img src=http://'.IMG.'/icons/del.png></a> <a href="main.php?jo=supp&ok='.$r['date'].'"><img src=http://'.IMG.'/icons/edit.png></a></td></tr><tr><td>'.str_replace("\n",'<br />',str_replace("\r",'',$r['text'])).'</td></tr>';
		unset($who);
	}
	echo "</table>";
}

?>

</DIV>
