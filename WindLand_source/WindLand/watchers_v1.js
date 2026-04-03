var d = document;
if (frameResizer==undefined) var frameResizer = '<a class=blocked href="javascript:show_wtch()" id=wtch>[Показать]Дополнительная информация о персонаже</a>';

var r=0;


function view_watchers(pip, plp, psp, plm, plz, pvr, pcl, pln, ppa, pre, pbo)
{
	var menu = '';
//	menu += '<script type="text/javascript" src="/js/mod/jquery.js?2"></script><center>';
	menu += '<table border="0" width="95%" cellspacing="0" cellpadding="0" class=but><tr><td colspan="5" class="but2" align="center">'+frameResizer+'</td></tr>';
	menu += '<tr> <td class="but2" align="center" width="25%"><a href="info.php?p='+nick+'&do_w=mpb&'+rnd()+'" class=bg>Возможности</a></td> <td class="but2" align="center" width="25%">'+((plp>0) ? '<a href="info.php?p='+nick+'&do_w=sells&'+rnd()+'"class=bg>Финансовые операции</a>' : '<i>Финансовые операции</i>')+'</td> <td class="but2" align="center" width="25%">'+((pcl>0) ? '<a href="info.php?p='+nick+'&do_w=sign&'+rnd()+'"class=bg>Клановая активность</a>' : '<i>Клановая активность</i>')+'</td> <td class="but2" align="center" width="25%">'+((ppa>0) ? '<a href="info.php?p='+nick+'&do_w=person&'+rnd()+'"class=bg>Проф. активность</a>' : '<i>Проф. активность</i>')+'</td></tr>';
	menu += '<tr> <td class="but2" align="center" width="25%">'+((pvr>0) ? '<a href="info.php?p='+nick+'&do_w=swatch&'+rnd()+'"class=bg>Проверки</a>' : '<i>Проверки</i>')+'</td> <td class="but2" align="center" width="25%">'+((pln>0) ? '<a href="info.php?p='+nick+'&do_w=rmpb&'+rnd()+'"class=bg>Правонарушения</a>' : '<i>Правонарушения</i>')+'</td> <td class="but2" align="center" width="25%">'+((plz>0) ? '<a href="info.php?p='+nick+'&do_w=w_z&'+rnd()+'"class=bg>Заметки смотрителей</a>' : '<i>Заметки смотрителей</i>')+'</td> <td class="but2" align="center" width="25%">'+((pre>0) ? '<a href="info.php?p='+nick+'&do_w=referal&'+rnd()+'"class=bg>Рефералы</a>' : '<i>Рефералы</i>')+'</td></tr>';
	menu += '<tr> <td class="but2" align="center" width="25%">'+((pip>0) ? '<a href="info.php?p='+nick+'&do_w=ip"class=bg>Просмотр IP адресов</a>' : '<i>Просмотр IP адресов</i>')+'</td> <td class="but2" align="center" width="25%">'+((plm>0) ? '<a href="info.php?p='+nick+'&do_w=onecomp&'+rnd()+'"class=bg>Заходы с одного комп.</a>' : '<i>Заходы с одного комп.</i>')+'</td> <td class="but2" align="center" width="25%">'+((psp>0) ? '<a href="info.php?p='+nick+'&do_w=pass&'+rnd()+'"class=bg>Смены пароля, E-Mail</a>' : '<i>Смены пароля</i>')+'</td> <td class="but2" align="center" width="25%">'+((pbo>0) ? '<a href="info.php?p='+nick+'&do_w=battles&'+rnd()+'"class=bg>Бои персонажа</a>' : '<i>Бои персонажа</i>')+'</td></tr>';
	menu += '<tr> <td class="but2" align="center" width="25%">'+((pbo>0) ? '<a href="info.php?p='+nick+'&do_w=quest"class=bg>Квесты персонажа</a>' : '<i>Квесты персонажа</i>')+'</td> <td class="but2" align="center" width="25%">  </td> <td class="but2" align="center" width="25%">  </td> <td class="but2" align="center" width="25%">  </td></tr>';
	
	d.write(menu+'<tr> <td class="inv" align="center" width="90%" colspan="9">');
}

function show_mpb(p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,dl)
{
	var smp = '';
	smp += '<form action="info.php?p='+nick+'&do_w=mpb" method=post name=mpb onsubmit="subm();return false;"><b class=about>Инструменты:</b><table border="0" cellpadding="0" cellspacing="0" id=tbl_main>';
	
	
	
	smp += '<tr><td align="center" width="450" class=gray>Молчание</td><td>';
	if (p1>0) smp += '<select style="width:140px" size="1" name="molch" class=items><option selected value="">Время</option><option  value="-1">Снять</option><option value="5">5 минут</option><option value="10">10 минут</option><option value="15">15 минут</option><option value="30">30 минут</option><option value="60">1 час</option><option value="120">2 часa</option><option value="180">3 часa</option><option value="360">6 часов</option><option value="720">12 часов</option><option value="1440">24 часа</option></select><input type=text class=but2 name=reason1 title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	
	smp += '<tr><td align="center" width="450" class=gray>Форумная молчанка</td><td>';
	if (p2>0) smp += '<select style="width:140px" size="1" name="fmolch" class=items><option selected value="">Время</option><option value="-1">Снять</option><option value="1">1 день</option><option value="3">3 дня</option><option value="7">1 неделя</option><option value="14">2 недели</option><option value="30">1 месяц</option><option value="60">2 месяца</option><option value="365">1 год</option></select><input type=text class=but2 name=fmolchp title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	
	smp += '<tr><td align="center" width="450" class=gray>Кара</td><td width="500">';
	if (p3>0) smp += '<select style="width:140px" size="1" name="punishment" class=items><option selected value="">Время</option><option value="-1">Снять</option><option value="5">5 минут</option><option value="10">10 минут</option><option value="15">15 минут</option><option value="30">30 минут</option><option value="60">1 час</option><option value="360">6 часов</option><option value="1440">24 часа</option><option value="2880">48 часов</option></select><input type=text class=but2 name=reason2 title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	
	smp += '<tr><td align="center" width="450" class=gray>Тюрьма</td><td>';
	if (p5>0) smp += '<select style="width:140px" size="1" name="prisontime" class=items><option selected value="">Время</option><option value="-1">Выпустить</option><option value="1">1 день</option><option value="3">3 дня</option><option value="7">1 неделя</option><option value="14">2 недели</option><option value="30">1 месяц</option><option value="60">2 месяца</option><option value="365">1 год</option></select><input type=text class=but2 name=prison title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	
	smp += '<tr><td align="center" width="450" class=gray>Блокирование</td><td width="500" colspan="2">';
	if (p6>0) smp += '<select style="width:140px" size="1" name="blockt" class=items><option selected value="">Выбор</option><option value="1">Заблокировать</option><option value="2">Разблокировать</option></select><input type=text class=but2 name=block title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	
	smp += '<tr><td align="center" width="450" class=gray>Блокирование информации</td><td width="500" colspan="2">';
	if (p4>0) smp += '<select style="width:140px" size="1" name="blockit" class=items><option selected value="">Выбор</option><option value="1">Заблокировать</option><option value="2">Разблокировать</option></select><input type=text class=but2 name=blocki title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	smp += '<tr><td align="center" width="450" class=gray>Благословление</td><td width="500">';
	if (p13>0) smp += '<select style="width:140px" size="1" name="wplagost" class=items><option selected value="">Время</option><option value="-1">Снять</option><option value="5">5 минут</option><option value="10">10 минут</option><option value="15">15 минут</option><option value="30">30 минут</option><option value="60">1 час</option><option value="360">6 часов</option><option value="1440">24 часа</option><option value="2880">48 часов</option></select><input type=text class=but2 name=wplagosrea title="Причина">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';	
	
	smp += '<tr><td align="center" width="450" class=gray>Проверить на чистоту</td><td colspan="2">';
	if (p10>0) smp += '<input type=button class=but value="Проверка пройдена" onclick="if (confirm(\'Персонаж прошел проверку на чистоту?\'))location = \'info.php?p='+nick+'&proverka=1&do_w=1\'">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	smp += '<tr><td align="center" width="450" class=gray>Выгнать</td><td colspan="2">';
	if (p11>0 && cc!='none') smp += '<input type=button class=but value="Выгнать из клана" onclick="if (confirm(\'Выгнать?\'))location = \'info.php?p='+nick+'&clan_go_out=1&do_w=1\'">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';

	smp += '<tr><td align="center" width="450" class=gray>Раздеть</td><td colspan="2">';
	if (p9>0) smp += '<input type=button class=but value="Раздеть" onclick="if(confirm(\'Раздеть?\'))location = \'info.php?p='+nick+'&wear_out=1&do_w=1\'">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	smp += '<tr><td align="center" width="450" class=gray>Пометка</td><td width="500" colspan="2">';
	if (p7>0) smp += '<input type=text class=but2 name=pometka>'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	smp += '<tr><td align="center" width="450" class=gray>Бракосочетания</td><td width="500" colspan="2">';
	if (p8>0) smp += (p8==1) ? '<input type=text class=but2 name=maridge title="На ком">' : '<input type=button class=but value="Развести" onclick="if(confirm(\'Развести?\'))location = \'info.php?p='+nick+'&maridge_out=1&do_w=1\'">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	smp += '<tr><td align="center" width="450" class=gray>Вытащить из бага</td><td width="500" align=center>';
	if (p12>0) smp += '<input type=button class=but  value="Вытащить" onclick="location = \'info.php?p='+nick+'&bug=1&do_w=1\'" style="width:90%">'; else smp += '<i>Недоступно</i>';
	smp += '</td></tr>';
	
	if (dl>0)
	{
		smp += '<tr><td align="center" width="450" class=gray>Комерческая проверка</td><td colspan="2">';
		if (r>5) smp += '<input type=button class=but value="Проверка пройдена" onclick="if (confirm(\'Персонаж прошел проверку на чистоту? Снимется 5 Бр.\'))location = \'info.php?p='+nick+'&comproverka=1&do_w=1\'">'; else smp += '<i>Недоступно</i>';
		smp += '</td></tr>';
		
		smp += '<tr><td align="center" width="450" class=about>Продать Бриллианты<br>[Доступно для продажи: <B>'+r+' Бр.</B>]</td><td width="500" colspan="2">';
		if (r>0) smp += '<input type=text class=but2 name=d_num title="Количество"> Коментарий: <input type=text class=but2 name=komentd_num title="Коментарий">'; else smp += '<i>Недоступно</i>';
		smp += '</td></tr>';
	}
	
	smp += '<tr><td align="center" width="914" colspan="3"><input type=submit class=login value="Применить" style="width:100%;height:50px;cursor:pointer;"></td></tr>';
	

	
	smp += '</table></form>';
	
	d.write(smp+'</td></tr></table>');
}

function subm()
{
	if (document.mpb.d_num)
		if (document.mpb.d_num.value)
			if (!confirm("Вы действительно хотите продать валюту???")) return;
	document.mpb.submit();
}

function show_message(message)
{
	document.write(message);
	document.write('</td></tr></table>');
}

function zametki(str)
{
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	var lines = str.split('@');
	var s;
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			document.write('<td><font class=time>'+s[0]+'</font></td><td> '+s[1]+' </td><td>(<b>'+s[2]+'</b>)</td>');
		}
		document.write('</tr>');
	}
	document.write('</table></td></tr></table>');
}

function rmpb(molch,kara,blocks)
{
	document.write('Молчания:<br />');
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	var lines = molch.split('@');
	var s;
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			if (s[1]==1)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Наложено, причина '+s[2]+' </td><td> (<b>'+s[3]+'</b>)</td>');
			else if (s[1]==2)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Снято </td><td> (<b>'+s[3]+'</b>)</td>');
		}
		document.write('</tr>');
	}
	document.write('</table><hr>');
	
	document.write('Блоки / тюрьмы:<br><table border="0" cellpadding="0" cellspacing="3">');
	lines = blocks.split('@');
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			if (s[1]>5)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Тюрьма, причина '+s[2]+'</td><td> (<b>'+s[3]+'</b>)</td>');
			if (s[1]==0)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Выпуск из тюрьмы </td><td>(<b>'+s[3]+'</b>)</td>');
			if (s[1]==1)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Блок, причина '+s[2]+' </td><td>(<b>'+s[3]+'</b>)</td>');
			if (s[1]==2)
				document.write('<td><font class=time>'+s[0]+'</font></td><td> Разблок </td><td>(<b>'+s[3]+'</b>)</td>');
		}
		document.write('</tr>');
	}
	document.write('</table></td></tr></table>');
}

function ip(str)
{
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	var lines = str.split('@');
	var s;
	for (var i=lines.length-1;i>=0;i--) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			document.write('<td><font class=time>'+s[0]+'</font></td><td> '+s[1]+' </td>');
		}
		document.write('</tr>');
	}
	document.write('</table></td></tr></table>');
}

function pass(str)
{
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	var lines = str.split('@');
	var s;
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
			document.write('<td><font class=time>'+lines[i]+'</font></td><td> Смена </td>');
		document.write('</tr>');
	}
	document.write('</table></td></tr></table>');
}

function sells(sales,tr)
{
	document.write('Продажи:<br>');
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	var lines = sales.split('@');
	var s;
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			document.write('<td><font class=time>'+s[0]+'</font></td><td>'+s[1]+'</td>');
		}
		document.write('</tr>');
	}
	document.write('</table><hr>Передачи:<br>');
	document.write('<table border="0" cellpadding="0" cellspacing="3">');
	lines = tr.split('@');
	for (var i=0;i<lines.length;i++) 
	{
		document.write('<tr>');
		if (lines[i]!='')
		{
			s=lines[i].split('|');
			if (s[1]==0)
				document.write('<td><font class=time>'+s[0]+'</font></td><td><<< Передано денег <b>'+s[2]+' LN</b> для '+s[3]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[3]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			if (s[1]==3)
				document.write('<td><font class=time>'+s[0]+'</font></td><td>>>> Принято денег <b>'+s[2]+' LN</b> от '+s[3]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[3]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			if (s[1]==1)
				document.write('<td><font class=time>'+s[0]+'</font></td><td><<< Передано <b>'+s[2]+'</b>(гос '+s[3]+') для '+s[4]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[4]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			if (s[1]==2)
				document.write('<td><font class=time>'+s[0]+'</font></td><td>>>> Принято <b>'+s[2]+'</b>(гос '+s[3]+') от '+s[4]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[4]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			if (s[1]==4)
			{
				if (s[2]==20) var travm='лёгкой';
				if (s[2]==50) var travm='средней';
				if (s[2]==80) var travm='тяжёлой';
				document.write('<td><font class=time>'+s[0]+'</font></td><td><<< Излечение '+travm+'   травмы для '+s[3]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[4]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			}
			if (s[1]==5)
			{
				if (s[2]==20) var travm='лёгкой';
				if (s[2]==50) var travm='средней';
				if (s[2]==80) var travm='тяжёлой';
				document.write('<td><font class=time>'+s[0]+'</font></td><td>>>> Излечение '+travm+'   травмы от '+s[3]+'<img style="CURSOR: hand" onclick="javascript:window.open(\'info.php?p='+s[4]+'\',\'_blank\')" src=http://'+img_pack+'/info.gif></td>');
			}
					 
		}
		document.write('</tr>');
	}
	document.write('</table></td></tr></table>');
}

function rnd()
{
	return 'rand='+Math.random();
}

function rmpb_filter(nick,c1,c2,c3,c4,c5,c6,from,to)
{
	c1 = (c1) ? 'CHECKED' : '';
	c2 = (c2) ? 'CHECKED'