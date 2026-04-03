var weap, edit, out, nwtch, repr, uid, nmobey, glav, wget, sts;
var imglist = '';//['b','c','d','e','f','g','h','i','j','k'];
var c_showed=0;
var DJ = function(id){return d.getElementById(id);};
// for (var i=0; i<data.length; i++)

function view_watch_clans()
{
	d.write('<div style="position:absolute; left:-2px; top:-2px; z-index: 6; width:0px; height:0px; visibility:visible;" id="zcenter" class=inv></div><div style="position:absolute; left:0px; top:0px; z-index: 1; width:100%; height:200%; display:none; text-align:center;" id="center2" class=news onclick="wtwt()">&nbsp;</div>');
	d.write('<div class=inv><center><table border=0 cellspacing=0 width=600 class=but><tr><td width=160><a href=main.php?'+Math.random()+' class=blocked>Обновить</a></td><td width=160><a href=main.php?clan=glav&'+Math.random()+' class=blocked>Возможности</a></td><td width=160><a href=main.php?clan=w&'+Math.random()+' class=blocked>Казна</a></td><td width=160><a href=main.php?clan=wall&'+Math.random()+' class=blocked>Стена</a></td><td width=160><a href=main.php?clan=doc&'+Math.random()+' class=blocked>Документация</a></td></tr></table></center>');
	d.write('<center><table border=0 cellspacing=0 width=600 class=but><tr><td width=250><a href="javascript:give_money(\'ln\')" class=blocked> <img src=http://'+img_pack+'/money.gif> <b>'+watch[2]+' LN</b></a>'+((nmobey) ? '<a href="javascript:take_clan(\'ln\')" class=blocked>Снять деньги</a>' : '')+'</td><td width=250><div class=but align=center><a href="javascript:give_money(\'br\')" class=blocked> <img src=http://'+img_pack+'/signs/diler.gif> <b>'+watch[3]+' Бр</b></a>'+((nmobey) ? '<a href="javascript:take_clan(\'br\')" class=blocked>Снять валюту</a>' : '')+'</div></td></tr><tr><td class=but id="money" colspan=3 align=center></td></tr></table></center><div id="wclansrep"></div>');
	DJ('wclansrep').innerHTML = d.getElementById('wclsrep').innerHTML;
	if(wget=='') w_sostav();
	else if (wget=='wall') walls();
	else if (wget=='glav') w_editor();
	

	
}

function w_sostav()
{
	var wtis = '';
	d.write('<center><table class=combofight width=500 cellspacing=0 cellspadding=0><tr><td align=center>Вы состоите в клане <img src="http://'+img_pack+'/signs/watchers.gif"> <b class=user>Смотрители</b></div></td></tr><tr><td align=center class=but>Глава Смотрителей <font class=user>'+watch[0]+'</font><img src="http://'+img_pack+'/_i.gif" onclick=\"javascript:window.open(\'/info.php?'+watch[0]+'\',\'_blank\')\" style="cursor:pointer"> | <a href="http://'+watch[1]+'" target=_blank class=bold>'+watch[1]+'</a>'+((glav) ? ' | <a href="javascript:ch_site(\''+watch[1]+'\')" class=timef>Сменить</a>' : '')+'</td></tr></table></center>');
	d.write('<center><table class=but width=900>');
	for (var i=0; i<stv.length; i++)
	{
		w_sostav_for(stv[i][0], stv[i][1], stv[i][2], stv[i][3], stv[i][4], stv[i][5], stv[i][6], stv[i][7], stv[i][8]);
	}
	d.write('</table></center>');
	
	if(repr) wtis += '<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Массовое сообщение игрокам</td></tr><tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?'+Math.random()+'><p align="right"><input name="mass" size="100" class="laar" style="float: left; border-style: solid; border-width: 1px"><input type="submit" value="Отправить" class="inv_but"><input type="reset" value="Сброс" class="inv_but"></p></form></td></tr></table>';
	if(nwtch) wtis += '<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Регулирование состава Смотрителей</td></tr><tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action=main.php?><p align="right"><input name=go_in size=100 class=laar style="float: left"> <input type="submit" value="Принять в Смотрители" class=inv_but></p></form></td></tr>'+((glav) ? '<tr><td bgcolor="#F0F0F0" class="td"><form method="POST" action="main.php?"><p align="right"><input name=do_glav size=100 class=laar style="float: left"> <input type="submit" value="Сделать Главой Смотрителей" class=inv_but></p></form></td></tr>' : '')+'</table>';
	d.write(wtis);
}


function watch_user(id, upid, glv, get)
{
	var up = id.split('|');
	weap = (up[6]==1) ? 1 : 0;
	edit = (up[8]==1) ? 1 : 0;
	out = (up[1]==1) ? 1 : 0;
	nwtch = (up[0]==1) ? 1 : 0;
	repr = (up[9]==1) ? 1 : 0;
	glav = (glv=='wg') ? 1 : 0;
	nmobey = (up[4]==1) ? 1 : 0;
	sts = (up[2]==1) ? 1 : 0;
	uid = upid;
	wget = get;
}

function w_sostav_for(pr,sign,nick,lev,psign,sstatus,plnx,plid, czn)
{
	var priv = '<img src=http://'+img_pack+'/emp.gif width=16 height=16 align=absmiddle>';
	var all_si = '';
	var slink = '';
	var oncl = '';

	if(weap) slink += '<a href=main.php?clan_act=3&sn_all='+plid+'>Снять вещи</a>&nbsp;&nbsp;';
	if(edit) slink += '<a href=main.php?clan_act=2&who='+plid+'&clan=edit>Редактировать</a>&nbsp;&nbsp;';
	if(out) slink += '<a href="javascript: if(confirm(\'Выгнать Смотрителя '+nick+'?\')) { location=\'main.php?clan_act=1&go_out='+plid+'\' }">Выгнать</a>';
	if(sts) oncl = 'onclick=\'jqstate("'+nick+'", "'+sstatus+'", '+czn+', "'+psign+'")\' style="cursor:pointer"';
	
	switch(psign)
	{
		case 'wg':
			slink = '';
			oncl = '';
			var ssta = '<font color=#CC0000>Глава Смотрителей</font>';
		break;
		default:
			if(uid == plid) {slink = ''; oncl = '';}
			var ssta = sstatus;
      }
       
	if(pr == 1) priv = '<a href="javascript:top.say_private(\''+nick+'\')"><img src=http://'+img_pack+'/_p.gif width=16 height=16 border=0 align=absmiddle></a>';
	all_si += '<img src=http://'+img_pack+'/signs/watch/'+sign+'.gif width=15 height=12 border=0 align=absmiddle>';
	d.write('<tr><td>'+priv+'&nbsp;'+all_si+' <b class=user '+oncl+'>'+nick+'</b>['+lev+']<a href="/info.php?'+nick+'" target=_blank><img src=http://'+img_pack+'/_i.gif width=16 height=16 border=0 align=absmiddle></a></td><td><font class=nickname>&nbsp;&nbsp;<b>'+ssta+'</b></td><td nowrap><font class=hpfont>&nbsp;&nbsp;'+(pr ? '<font class=green>'+plnx+'</font>' : '<font class=hp>'+plnx+'</font>')+'</font></td><td><font class=text>&nbsp;&nbsp;'+slink+'</td></tr>');

}

function walls()
{
	var dwr = '<center><div style="width:600px" class=but><div id=report align=center><a href="javascript:report();" class=bg>Написать отзыв</a></div><div id=mainpers></div><table border=1 width=100% cellspacing=3 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF><tr><td class=brdr>ОТЗЫВЫ:<a href=\"main.php?clan=wall&all_reports=1\">(ВСЕ)</a></td></tr>';
	for (var i=0; i<data.length; i++)dwr += '<tr><td class=login><img src=http://'+img_pack+'/signs/'+data[i][2]+'.gif> <b>'+data[i][0]+'</b>[<font class=lvl>'+data[i][1]+'</font>] <img src="http://'+img_pack+'/i.gif" onclick="window.open(\'info.php?'+data[i][0]+'\',\'\',\'width=800,height=600,left=10,top=10,toolbar=no,scrollbars=yes,resizable=yes,status=no\');" style="cursor:pointer"> <font class=time>'+data[i][3]+'</font></td></tr><tr><td>'+data[i][4]+'</td></tr>';
	dwr += '</table></div></center>';
	d.write(dwr);
}

function new_glaw()
{
	if (confirm('Передать полномочия Главы Смотрителей?')) location='main.php?clan_act=4';
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

function wtwt(a)
{
	if (!c_showed)
	{
		$("#center2").css("display","block");
		c_showed=1;
		$("#zcenter").html('<a class=blocked href="javascript:wtwt()">Закрыть</a><center class=but>'+a+'</center>'); 	
		$("#zcenter").show(500);
	}
	else
	{
		$("#center2").css("display","none");
		$("#zcenter").hide(500);
		c_showed=0;
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

function jqstate(user, st, ccz, img)
{
	$("#zcenter").css({left:'40%',top:'80px',width:'210px',height:'200px'});
	$("#zcenter").hide(1);
	var txt = '';
	txt += '<b class=user>'+user+'</b>';
	txt += '<form action="main.php?clan_act=5&set_params='+user+'" method="post">';
	txt += 'Личный статус: <input type="text" class="but" name="state" value="'+st+'"><br>';
	txt += 'Казна'
	if (ccz==1) txt+= '<input type="checkbox" name="clan_tr" value="1" CHECKED>'; else txt+= '<input type="checkbox" name="clan_tr" value="1">';
	
	txt += '<br>Значёк <div id="znachek" style="cursor:pointer"><img src=http://'+img_pack+'/signs/watch/'+img+'.gif width=15 height=12 border=0 align="absmiddle" onClick=\'znachek_view("'+img+'");\'></div>';
	
	txt += '<center class=but2><input type=submit class=login value="Применить"></center></form>';
	wtwt(txt);
}

function znachek_view(z)
{
	var txt = '';
	for (var i=0; i<imglist.length; i++) txt+= '<img src="http://'+img_pack+'/signs/watch/'+imglist[i]+'.gif" onClick="get_img_new(\''+imglist[i]+'\');" title="'+namelist[i]+'" width=15 height=12 border=0 align=absmiddle>';
	$("#znachek").html(txt);
}

function get_img_new(im)
{
	var t = '';
//	alert(im);
	t+= '<input type="hidden" name="newimg" value="'+im+'">';
	t+= '<img src="http://'+img_pack+'/signs/watch/'+im+'.gif" width=15 height=12 border=0 align=absmiddle>';
	$("#znachek").html(t);
}

function w_editor()
{
	var td = ['','союз','вражда'],zarplata = '';
	var dwr = '<center><div style="width:900px" class=but><FIELDSET><LEGEND align="center"><b>Дипломатические отношения игры</b></LEGEND><table border=1 cellspacing=3 cellpadding=2 bordercolorlight=#C0C0C0 bordercolordark=#FFFFFF>';
	for ( var i in data )
	{
		if ( data[i][6]==2 ) war = true; if ( data[i][6]==1 ) alians = true;
		dwr+= '<tr><td>'+(!data[i][7] ? 'Заявка' : 'Действий: '+data[i][9])+'</td><td><img src="http://'+img_pack+'/signs/'+data[i][1]+'.gif" width=15 height=12 border=0 /><b onClick="top.Funcy(\'/clan.php?id='+data[i][1]+'\');" style="cursor:pointer;">'+data[i][2]+'</b></td><td class="'+((data[i][6]==2) ? 'hp' : 'ma')+'">'+td[data[i][6]]+'</td><td><img src="http://'+img_pack+'/signs/'+data[i][3]+'.gif" width=15 height=12 border=0 /><b onClick="top.Funcy(\'/clan.php?id='+data[i][3]+'\');" style="cursor:pointer;">'+data[i][4]+'</b></td><td>еще '+data[i][5]+'</td>';
		dwr+= '<td>'+((data[i][6]==2) ? 'контрибуция '+data[i][8]+' LN' : '')+'</td></tr>';
	}
	if ( !data.length ) dwr += '<tr><td>Дипломатические отношения отсутствуют.</dt></tr>';
	dwr += '</table><br />';
	if ( glav )
	{
		zarplata+= '<br /><form method="POST" action="main.php?clan=glav&'+Math.random()+'"><table border="0" width="200" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1"><tr><td align="center" class="user" bgcolor="#F9F9F9">Выдать зарплату сотруднику</td></tr>';
		zarplata+= '<tr><td bgcolor="#F0F0F0" class="td"><table>';
		zarplata+= '<tr><td>Логин:</td><td><input name="zp_login" size="30" class="laar" style="float: left; border-style: solid; border-width: 1px" /></td></tr>';
		zarplata+= '<tr><td>Сумма:</td><td><input name="zp_count" size="30" class="laar" style="float: left; border-style: solid; border-width: 1px"></td> </tr>';
		zarplata+= '</table><p align="center"><input type="submit" value="Выдать" class="inv_but"> <input type="reset" value="Сброс" class="inv_but"></p></td></tr></table></form>';
	}
	d.write(dwr+'</FIELDSET>'+zarplata+'</div></center>');
}
