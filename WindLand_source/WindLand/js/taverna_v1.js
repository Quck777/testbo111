var count = 0;
var c_showed = 0;

function view_taverna()
{
	d.write('<div style="position:absolute; left:-2px; top:-2px; z-index: 6; width:0px; height:0px; visibility:visible;" id="zcenter" class=inv></div><div style="position:absolute; left:0px; top:0px; z-index: 1; width:100%; height:200%; display:none; text-align:center;" id="center2" class=news onclick="windmenu()">&nbsp;</div>');
	d.write('<table cellpadding="0" cellspacing="0" border="0" align="center" width="760"><tr><td><img src="http://'+img_pack+'/emp.gif" width="1" height="2"></td></tr><tr><td bgcolor="#CCCCCC"><table cellpadding="4" cellspacing="1" border="0" width="100%"><tr><td align="center" class="inv" bgcolor="#FFFFFF"><B>У Вас с собой '+usr[0]+' LN</B></td></tr>'+(usr[1] ? ('<tr><td align="center" class="inv" bgcolor="#FFFFFF">'+usr[1]+'</td></tr>') : '')+'</table></td></tr></table><table cellpadding="0" cellspacing="1" border="0" align="center" width="760" id="ResTableData"></table>');
	gen_view_resourses();
}

function gen_view_resourses()
{
	var r = '<tr><td bgcolor="#CCCCCC" align="center">Название</td><td bgcolor="#CCCCCC" align="center">Характеристики</td><td bgcolor="#CCCCCC" align="center" width="100">Количество</td><td bgcolor="#CCCCCC" align="center" width="100">Цена</td><td bgcolor="#CCCCCC" align="center" width="100"> </td></tr>';
	var rs;
	
	
	for (var i=0; i<res.length; i++)
	{
		clr = (count%2==0) ? '#FFFFFF' : '#EAEAEA';
		count++;
		rs = res[i];
		r+= '<tr><td bgcolor="'+clr+'" align="center">'+rs[1]+'</td><td bgcolor="'+clr+'" align="center">'+gen_param(rs[2])+'</td><td bgcolor="'+clr+'" align="center">'+rs[3]+' шт.</td><td bgcolor="'+clr+'" align="center">'+rs[4]+' LN</td><td bgcolor="'+clr+'" align="center">'+Button_clicker(rs[0], ((rs[3]>0 && usr[0]>rs[4] && usr[2]<5) ? 1 : 0), rs[5])+'</td></tr>';
	}
	
	$('#ResTableData').html(r);
}

function gen_param(p)
{
	var gp = '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
	var i,p1,p2,s;
	p1 = p[0].split('@');
	p2 = p[1].split('@');
	
	for (i=0; i<p1.length; i++)
	{
		s = p1[i].split('=');
		gp+= '<tr>'+params(s[0], s[1])+'</tr>';
	}
	gp+= '</table>';
	return gp;
}

function windmenu(a)
{
	if (!c_showed)
	{
		$('#center2').css("display","block");
		c_showed=1;
		$('#zcenter').html('<a class=blocked href="javascript:windmenu()">Закрыть</a><center class=but>'+a+'</center>'); 	
		$('#zcenter').show(500);
	}
	else
	{
		$('#center2').css("display","none");
		$('#zcenter').hide(500);
		c_showed=0;
	}
}

function Button_clicker(id, dis, tp)
{
	var Butt = '<input type=button class="login" onclick="go_actopner('+id+', '+dis+','+tp+');"';
	Butt += '\'" value="Использовать">';
	return Butt;
}

function go_actopner(id,dis,tp)
{
	$("#zcenter").css({left:'40%',top:'80px',width:'210px'});
	$("#zcenter").hide(1);
	var r = '';
	if (dis==1) r+= '<a href="javascript://" onClick="sebe_buhlo('+id+');" class="bga">Употребить</a>'; else r+= 'Вы слишком пьяны.';
	if (tp==1) r+= '<a href="javascript://" onClick="go_friend('+id+')" class="bga">Угостить</a>';
	windmenu(r);
}

function sebe_buhlo(id)
{
	location = 'main.php?go_res='+id;
}


function go_friend(id)
{
	c_showed = 0;
	$("#zcenter").css({left:'40%',top:'80px',width:'210px'});
	$("#zcenter").hide(1);
	var r = '<form action=main.php?go_friend='+id+' method=POST>Логин:<INPUT TYPE="text" name=fornickname id=fornickname  maxlength=25 class=laar><input type=submit value="Угастить" class=login style="width:100%"></FORM>';
	windmenu(r);
}

function params(id, val)
{
	var rt = '';
	switch (id)
	{
		case 's1': rt='<td width="50%" align="center">Сила:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 's2': rt='<td width="50%" align="center">Реакция:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 's3': rt='<td width="50%" align="center">Удача:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 's5': rt='<td width="50%" align="center">Интеллект:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 's6': rt='<td width="50%" align="center">Сила Воли:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 'kb': rt='<td width="50%" align="center">Класс Брони:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 'hp': rt='<td width="50%" align="center" class="hp">HP:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case 'ma': rt='<td width="50%" align="center" class="ma">MA:</td><td width="50%" align="center">+ <b>'+Math.round(val*0.5)+'-'+val+'</b></td>'; break;
		case '': rt=''; break;
		case '': rt=''; break;
		case '': rt=''; break;
		case '': rt=''; break;
		case '': rt=''; break;
		case '': rt=''; break;
		case 'time': rt='<td width="50%" align="center"><font color="#CC0000">Время действия</font>:</td><td width="50%" align="center"><b>'+(val/(60*60))+'</b>ч</td>'; break;
	}
	return rt;
}