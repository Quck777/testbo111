var c_showed=0;
var DJ = function(id){return d.getElementById(id);};

function view_clans()
{
	d.write('<div style="position:absolute; left:-2px; top:-2px; z-index: 6; width:0px; height:0px; visibility:visible;" id="zcenter" class=inv></div><div style="position:absolute; left:0px; top:0px; z-index: 1; width:100%; height:200%; display:none; text-align:center;" id="center2" class=news onclick="wtwt()">&nbsp;</div>');
	d.write('<div class=inv><center><table border=0 cellspacing=0 width=600 class=but><tr><td width=160><a href=main.php?'+Math.random()+' class=blocked>Обновить</a></td><td width=160><a href=main.php?clan=glav&'+Math.random()+' class=blocked>Возможности</a></td><td width=160><a href=main.php?clan=w&'+Math.random()+' class=blocked>Казна</a></td><td width=160><a href=main.php?clan=wall&'+Math.random()+' class=blocked>Стена</a></td><td width=160><a href=main.php?clan=doc&'+Math.random()+' class=blocked>Документация</a></td></tr></table></center>');
	d.write('<center><table border=0 cellspacing=0 width=600 class=but><tr><td width=250><a href="javascript:give_money(\'ln\')" class=blocked> <img src=http://'+img_pack+'/money.gif> <b>'+iclan[4]+' LN</b></a>'+((pinfo[4]=='a' || pinfo[4]=='d') ? '<a href="javascript:take_clan(\'ln\')" class=blocked>Снять деньги</a>' : '')+'</td><td width=250><div class=but align=center><a href="javascript:give_money(\'br\')" class=blocked> <img src=http://'+img_pack+'/signs/diler.gif> <b>'+iclan[5]+' Бр</b></a>'+((pinfo[4]=='a') ? '<a href="javascript:take_clan(\'br\')" class=blocked>Снять валюту</a>' : '')+'</div></td></tr><tr><td class=but id="money" colspan=3 align=center></td></tr></table></center><div id="clansrep"></div>');
	DJ('clansrep').innerHTML = d.getElementById('clsrep').innerHTML;
	if (pinfo[6]==false) noget();
	else if (pinfo[6]=='glav') ;
	else if (pinfo[6]=='wall') walls();
	else if (pinfo[6]=='doc') var s;
}

function noget()
{
	var dwr = '<center><table class=combofight width=500 cellspacing=0 cellspadding=0><tr><td align=center>Вы состоите в клане <img src="http://'+img_pack+'/signs/'+pinfo[2]+'.gif"> <b class=user>'+iclan[0]+'['+iclan[1]+']</b></div></td></tr><tr><td class=but>Глава Клана <font class=user>'+iclan[2]+'</font><img src="http://'+img_pack+'/_i.gif" onclick=\"javascript:window.open(\'info.php?'+iclan[2]+'\',\'_blank\')\" style="cursor:pointer"> | <a href="http://'+iclan[3]+'" target=_blank class=bold>'+iclan[3]+'</a>'+((pinfo[4]=='a') ? ' | <a href="javascript:ch_site(\''+iclan[3]+'\')" class=timef>Сменить</a>' : '')+'</td></tr></table></center>';
	dwr += '<center><i class=user>Состав</i><table class=but width=900>';
	for (var i=0; i<data.length; i++)
	{
		if (pinfo[4]=='a' || pinfo[4]=='b' || pinfo[4]=='d') var _click = 'onclick=\'set_status("'+data[i][0]+'","'+data[i][3]+'","'+data[i][4]+'",'+data[i][6]+','+((data[i][5]==pinfo[5])?1:0)+', "'+pinfo[4]+'", '+data[i][5]+')\' style="cursor:pointer"'; else var _click = '';
		dwr += '<tr><td><img src="http://'+img_pack+'/pr.gif" onclick=\'javascript:top.say_private("'+data[i][0]+'")\' style="cursor:pointer" height=16>&nbsp;&nbsp;&nbsp;<img src="http://'+img_pack+'/signs/align/'+pinfo[3]+'.gif"><img src="http://'+img_pack+'/signs/'+pinfo[2]+'.gif"><font class=user '+_click+'>'+data[i][0]+'</font><font class=lvl>['+data[i][1]+']</font><img src="http://'+img_pack+'/_i.gif" onclick=\'javascript:window.open("info.php?'+data[i][0]+'","_blank")\' style="cursor:pointer"></td>';
		dwr += '<td><b style="color:'+clan_state_color(data[i][3])+'">'+clan_state(data[i][3])+'</b>['+data[i][4]+']</td>'+((data[i][2]==1) ? '<td class=green>'+data[i][7]+'</td>' : '<td class=hp>'+data[i][7]+'</td>')+''+((data[i][6]==1) ? '<td class=timef>Казна <i class=green>вкл</i></td>' : '<td class=timef>Казна <i class=hp>выкл</i></td>');
	}
	dwr += '</table></center><center><div class=but style="width:300px;"><i>Свободных очков клана:</i> <b>'+iclan[6]+'</b><br>';
	if (iclan[6]>0){var pl1 = '<a href=main.php?up_um=1>+</a>';var pl2 = '<a href=main.php?up_um=2>+</a>';var pl3 = '<a href=main.php?up_um=3>+</a>';}else{var pl1='';var pl2='';var pl3='';}
	dwr += pl1+'Вместимость казны: ['+((iclan[7]>iclan[8]) ? '<font class=hp>'+iclan[7]+'</font>' : '<font class=green>'+iclan[7]+'</font>')+'/'+iclan[8]+']<br>'+pl2+'Максимальное число членов клана: <b>'+iclan[9]+'</b><br>'+pl3+'Колодец клана: ['+((iclan[10]==1) ? 'Пусто<font class=hp>0</font>' : '<a href=main.php?well=on class=timef>Пить</a><font class=green>'+iclan[11]+'</font>')+'/<b>'+iclan[11]+'</b>]<br><marquee scrollamount=2 scrolldelay=14>'+iclan[12]+'</marquee></div></center>';
	dwr += '<center><div class=but style="width:300px;"><i>Персонажей в клане</i> : <b>'+iclan[13]+'</b><br><i>Персонажей онлайн</i> : <b>'+iclan[14]+'</b><br><i>Ранк у сильнейшего персонажа</i> : <b>'+iclan[15]+'</b><br><i>Средний уровень</i> : <b>'+iclan[16]+'</b><br></div></center>';
	if (iclan[17]==1) dwr += '<center class=return_win><hr><input type="button" value="Повысить уровень клана" class="laar" onclick="location=\'main.php?lvlup=1&'+Math.random()+'\'"><hr></center>';
	if (pinfo[4]=='a' || pinfo[4]=='b' || pinfo[4]=='e')
	{
		dwr += '<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Регулирование клана</td></tr>';
		if (iclan[13]<iclan[9]) dwr += '<tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?><p align="right"><input name=go_in size=100 class=laar style="float: left"> <input type="submit" value="Принять [200 LN]" class=inv_but></p></form></td></tr>';
		if (pinfo[4]=='a') dwr += '<tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?><p align="right"><input name=do_glav size=100 class=laar style="float: left"> <input type="submit" value="Сделать главой клана" class=inv_but></p></form></td></tr>';
		dwr += '</table>';
	}
	if (pinfo[4]=='a') dwr += '<a href=main.php?zero=1 class=bga>Обнулить клан[-500 LN со счета клана]</a><a href=main.php?tzero=1 class=bga>Пересчитать счётчик казны</a>';
	d.write(dwr);
}

function walls()
{
	var dwr = '<center><div style="width:600px" class=but><div id=report align=center><a href="javascript:report();" class=bg>Написать отзыв</a></div><div id=mainpers></div><table border=1 width=100% cellspacing=3 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF><tr><td class=brdr>ОТЗЫВЫ:<a href=\"main.php?clan=wall&all_reports=1\">(ВСЕ)</a></td></tr>';
	for (var i=0; i<data.length; i++)dwr += '<tr><td class=login><img src=http://'+img_pack+'/signs/'+data[i][2]+'.gif> <b>'+data[i][0]+'</b>[<font class=lvl>'+data[i][1]+'</font>] <img src="http://'+img_pack+'/i.gif" onclick="window.open(\'info.php?'+data[i][0]+'\',\'\',\'width=800,height=600,left=10,top=10,toolbar=no,scrollbars=yes,resizable=yes,status=no\');" style="cursor:pointer"> <font class=time>'+data[i][3]+'</font></td></tr><tr><td>'+data[i][4]+'</td></tr>';
	dwr += '</table></div></center>';
	d.write(dwr);
}



function is_status (x)
{
	var ret = '';
	switch (x)
	{
		case 'b': var ss; break;
	}
	return ret;
}

function set_status(user, s, st, tr, y, status, uid)
{
	$("#zcenter").css({left:'40%',top:'80px',width:'210px',height:'200px'});
	$("#zcenter").hide(1);
	var txt = '';
	txt += '<b class=user>'+user+'</b>';
	var ts;
	var sel;
	var tsa='',tsb='',tsc='',tsd='',tse='',tsf='';tsg='';tsh='';tsi='';tsj='';tsk='';
	switch (s)
	{
		case 'a': ts = 'Глава клана'; tsa = 'SELECTED'; break;
		case 'b': ts = 'Заместитель главы'; tsb = 'SELECTED'; break;
		case 'c': ts = 'Советник'; tsc = 'SELECTED'; break;
		case 'd': ts = 'Финансовый отдел'; tsd = 'SELECTED'; break;
		case 'e': ts = 'Отдел кадров'; tse = 'SELECTED'; break;
		case 'f': ts = 'Боевой отдел'; tsf = 'SELECTED'; break;
		case 'g': ts = 'Отдел Креатива'; tsg = 'SELECTED'; break;
		case 'h': ts = 'Отдел Алхимиков'; tsh = 'SELECTED'; break;
		case 'i': ts = 'Отдел Шахтеров'; tsi = 'SELECTED'; break;
		case 'j': ts = 'Отдел Лесорубов'; tsj = 'SELECTED'; break;
		case 'k': ts = 'Отдел Рыбаков'; tsk = 'SELECTED'; break;
	}
	if (status!='d')
	{
		if (s=='a' || y==1) 
			sel = '<div class="but"><b>'+ts+'</b></div>';
		else if (status=='a' || status=='b') 
			sel = '<select name="clan_state"><option value="b" '+tsb+'>Заместитель главы</option><option value="c" '+tsc+'>Советник</option><option value="d" '+tsd+'>Финансовый отдел</option><option value="e" '+tse+'>Отдел кадров</option><option value="f" '+tsf+'>Боевой отдел</option><option value="g" '+tsg+'>Отдел Креатива</option><option value=h '+tsh+'>Отдел Алхимиков</option><option value="i" '+tsi+'>Отдел Шахтеров</option><option value=j '+tsj+'>Отдел Лесорубов</option><option value="k" '+tsk+'>Отдел Рыбаков</option></select>';

			txt += '<form action="main.php?set_params='+user+'" method="post">'
			txt += 'Личный статус: <input type="text" class="but" name="state" value="'+st+'"><br>';
			txt += sel+'<br>';
		
		if ((s!='a' && y==0) || status=='b')
		{
			txt += 'Казна'
			if (tr) txt+= '<input type=checkbox name=clan_tr value=1 CHECKED>'; 
			else txt+= '<input type=checkbox name=clan_tr value=1>';
		}
		txt += '<center class=but2><input type=submit class=login value="Применить"></center></form>';
		if ((status=='a' || status=='b') && !y && s!='a')
		{
			txt += '<hr><a class=blocked href="javascript:if(confirm(\'Вы уверены?\'))location = \'main.php?go_out='+user+'\'">Выгнать</a>';
		}
	}
	if ((status=='a' || status=='d' || status=='b'))
	{
		txt += '<hr><a class=blocked href="main.php?sn_all='+uid+'">Раздеть</a>';
	}
	wtwt(txt);
}


function clan_state(s)
{
	if (s=='a') return 'Глава клана';
	if (s=='b') return 'Заместитель главы';
	if (s=='c') return 'Советник';
	if (s=='d') return 'Финансовый отдел';
	if (s=='e') return 'Отдел кадров';
	if (s=='f') return 'Боевой отдел';
	if (s=='g') return 'Отдел Креатива';
	if (s=='h') return 'Отдел Алхимиков';
	if (s=='i') return 'Отдел Шахтеров';
	if (s=='j') return 'Отдел Лесорубов';
	if (s=='k') return 'Отдел Рыбаков';
	return 'Член клана';
}

function clan_state_color (k)
{
    if (k=='a') return '#990000';
    if (k=='b') return '#DD0000';
    if (k=='c') return '#4B0082';
    if (k=='d') return '#009900';
    if (k=='e') return '#000099';
    if (k=='f') return '#009999';
    if (k=='g') return '#800080';
    if (k=='h') return '#1E90FF';
    if (k=='i') return '#D87093';
    if (k=='j') return '#688E23';
    if (k=='k') return '#00CED1';
    return '#333333';
}


function wtwt(a)
{
	if (!c_showed)
	{
	 $("#center2").css("display","block");
	 c_showed=1;
	 $("#zcenter").html('<a class=blocked href="javascript:wtwt()">Закрыть</a><center class=but>'+a+'</center>'); 	
	 $("#zcenter").show(500);
	 top.hide_logo();
	 }
	else
	{
	 $("#center2").css("display","none");
	 $("#zcenter").hide(500);
	 c_showed=0;
	 top.show_logo();
	}
}

function ch_site(url)
{
	$("#zcenter").css({left:'40%',top:'20px',width:'210px',height:'100px'});
	$("#zcenter").hide(1);
	var txt = '';
	txt = '<form action="main.php?'+Math.random()+'" method=post><input type=text class=but name=site value="'+url+'">';
	txt += '<center class=but2><input type=submit class=login value="Применить"></center>'+url+'';
	txt += '</form>';
	wtwt(txt);
}

function go_out(user)
{
	if (confirm('Вы действительно хотите выгнать '+user+' за 200LN?')) document.location='main.php?go_out='+user+'&'+Math.random();
}

function give_money(t)
{
	DJ('money').innerHTML = '<form action=main.php?'+Math.random()+' method=post><input type=text class=login size=20 name="money_'+t+'"><input class=login type=submit value="Пожертвовать"></form>';
}

function take_clan(t)
{
	DJ('money').innerHTML = '<form action=main.php?'+Math.random()+' method=post><input type=text class=login size=20 name="takemoney_'+t+'"><input class=login type=submit value="Забрать"></form>';
}

function report()
{
	DJ('report').innerHTML = '<form method=post><textarea name=report class=return_win rows=5></textarea><hr><input type=submit class=login value="Отправить"></form>';
}

function getaction(a)
{
	if (confirm('Вы уверены?')) document.location = a+'&'+Math.random();
}
