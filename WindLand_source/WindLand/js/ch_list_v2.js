var lines_count = 0;

var dwj = '<META Content=\'text/html; charset=windows-1251\' Http-Equiv=Content-type>';
	dwj+= '<LINK href=/css/ch_v2.css rel=STYLESHEET type=text/css>';
	dwj+= '<SCRIPT LANGUAGE="JavaScript" src="/js/mod/jquery.js"></SCRIPT>';
	dwj+= '<SCRIPT LANGUAGE="JavaScript" src="/js/ch_msg_v2.js"></SCRIPT>';
	dwj+= '<SCRIPT LANGUAGE="JavaScript" src="/js/mod/TollTips.js"></SCRIPT>';
	
document.write(dwj+'<body bgcolor="#F0F0F0" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0"><DIV id="smiles" style="visibility: hidden; top:0; position:absolute;"></DIV><center id="head" style="visibility: visible;"></center><div id="ch" style="text-align:center;width:100%;">&nbsp;</div><div style="position:absolute; left:0px; top:0px; z-index: 2; width:80 ; height:40; display:none;" class="menu" id="description"></div><div id=menu class="menu"></div><TEXTAREA id=cpnick style="display:none;"></TEXTAREA>');

function show_head()
{
document.getElementById('head').innerHTML = '<table style="width: 200px" cellspacing="0" cellpadding="0"> <tr> <td style="width: 5%"><img src="/public_content/chimg/0.png" onclick="show_srt_wth()" style="cursor:pointer"></td> <td style="width: 80%" id="head2" align="center"><img src="/public_content/chimg/r.gif" onclick="location=\'ch.php?a=1&'+MYrand()+'\'" style="cursor:pointer"></td> <td style="text-align: right; width: 5%"><img src="/public_content/chimg/01.png" onclick="location=\'/weather.php?a=1&'+MYrand()+'\'" style="cursor:pointer"></td> </tr> </table>'; 
}

function show_srt_wth()
{
document.getElementById('head2').innerHTML = "<table width=100% class=items><tr><td><a href='javascript:sort_on_fly (1)' class=bnick>lvl+</a></td><td><a href='javascript:sort_on_fly (2)' class=bnick>lvl-</a></td><td><a href='javascript:sort_on_fly (4)' class=bnick>z-a</a></td><td><a href='javascript:sort_on_fly (3)' class=bnick>a-z</a></td></tr></table>";
}

function show_list(sort_type,hr)
{
	var ch = document.getElementById('ch');
	var text;
	var _all = '';
	sort_type = parseInt(sort_type);
	if (sort_type == 0) sort_type == 2;
	if (priveleged || vsg) 
	{
		_all = '<a href=ch.php?view=all&sort='+sort_type+'&'+MYrand()+'>Всего:</a>'+' <b class=nums>'+vsg+'</b>';
	
	}else{
		if (vsg) _all = '<b>Всего:</b>'+' <b class=nums>'+vsg+'</b>';
	}
	document.getElementById('head').innerHTML += '<font class=cord>['+xy+']</font><b><a href=ch.php?view=this&sort='+sort_type+'&'+MYrand()+'>'+locname+'</a></b>: <b class=nums>'+zds+'</b> <br> '+_all;
	text = '<table border="0" width="100%" cellspadding=0 cellspacing="0">';
	if (zds==0 && vsg==0) text = '<center>'+locname+'</center>';
	var i;
	for (var i=residents.length-1;i>=0;i--) text += resident_string(residents[i],hr); 
	if (sort_type == 4 || sort_type == 3) list.sort();
	else sortnum(list);
	if (sort_type == 3) 
		for (var i=0;i<list.length;i++) text += hero_string(list[i],hr);
	else if (sort_type == 4) 
		for (var i=list.length-1;i>=0;i--) text += hero_string(list[i],hr); 
	else if (sort_type == 1)
		for (var i=0;i<list.length;i++) text+= hero_string(list[i],hr); 
	else
		for (var i=list.length-1;i>=0;i--) text += hero_string(list[i],hr); 
	text += '</table>';
	ch.innerHTML += text;
	if (hr==1) ch.innerHTML+='<hr>';
}

function hero_string (element,hr) 
{
	var arr = element.split("|");
	var s='<tr>';
	if (lines_count%2 == 0) s = '<tr style="background-color: #EAEAEA">';
	lines_count++;
	var inviz='';
	var uninviz='';
	if (arr[0].indexOf('n=')>-1)
	{
		arr[0]=arr[0].replace('n=','');
		inviz='<i>';
		uninviz='</i>';
	}
	if (hr!=1)
		s += '<td width="15" align="center"><img src=/public_content/chimg/p.gif onclick="javascript:top.say_private(\''+arr[0]+'\',1)" style="cursor:pointer" title="Приватное сообщение" height=16></td>';
	
	s += ' <td align="left"><img src=/images/emp.gif width=10 height=1>';
	
	if (arr[2]!='')
	{
		ar = arr[2].split(";");
		s += '<img src=/images/signs/align/'+ar[0]+'.gif '+mouser(ar[1])+' width="15" height="12"> ';
	}
	
	if (arr[3]!='none')
	{
		var cl = '';
		ar = arr[4].split(";");
		if ( ar[0] == 'Стражи Закона' )
		{
			cl += '<b><font style=color:#990000;>'+ar[0]+'</font></b>';
			if (ar[3]!='') cl += '<br /><i>'+ar[3]+'</i>';
			s += '<img src=/images/signs/watch/'+arr[3]+'.gif '+mouser(cl)+' width="15" height="12"> ';
		} else {
			cl += '<b>'+ar[0]+'</b>[<font class=lvl>'+ar[1]+'</font>]<br />';
			cl += c_state(ar[2]);
			if (ar[3]!='') cl += '<br /><i>'+ar[3]+'</i>';
			s += '<img src=/images/signs/'+arr[3]+'.gif '+mouser(cl)+' width="15" height="12" style="cursor:pointer" onclick="javascript:sign_info(\''+arr[3]+'\');"> ';
		}
	}
	
	s += inviz+'<font class=user onclick="javascript:top.say_private(\''+arr[0]+'\')" title="Сообщение" style="cursor:pointer">'+arr[0].substr(0,20)+'</font>'+uninviz+'[<font class=lvl>'+arr[1]+'</font>] <img src=/public_content/chimg/i.gif onclick="javascript:window.open(\'/info.php?'+arr[0]+'\',\'_blank\')" style="cursor:pointer" height=16> &nbsp; &nbsp; ';
	
	
	if (arr[5]!='') s+=' <img src=/images/signs/molch.gif '+mouser("Заклинание молчания, ещё "+arr[5]+".")+'>';
	if (arr[6]!='') s+=' <img src=/images/signs/travm.gif '+mouser(arr[6])+'>';
	
	if (arr[9]!='') 
	{
		var adm_st = ['','Комьюнити/','Помощники/','Создатели/'];
		ar = arr[9].split(";");
		s+= ' <img src="/images/signs/admin/'+ar[1]+'.png" '+mouser(adm_st[ar[1]]+''+ar[0])+'  style="cursor:pointer">';
	}
	if (arr[8]!='') s+=' <img src=/images/signs/ignore.gif '+mouser("Снять игнорирование")+'  style="cursor:pointer"" onclick="location=\'ch.php?ignore_unset='+arr[0]+'&'+MYrand()+'\'">';
	if (arr[7]==1) s+=' <img src=/images/signs/diler.gif '+mouser("Официальный дилер проекта")+'>';
	s+='</td></tr>';
	return s;
}

function c_state (st)
{
	var c='',s='Новичек';
	if (st=='') return '';
	
	else if (st=='a'){ c = '#990000'; s = 'Глава клана'; }
	else if (st=='b'){ c = '#DD0000'; s = 'Заместитель главы'; }
	else if (st=='c'){ c = '#4B0082'; s = 'Советник'; }
	else if (st=='d'){ c = '#009900'; s = 'Финансовый отдел'; }
	else if (st=='e'){ c = '#000099'; s = 'Отдел кадров'; }
	else if (st=='f'){ c = '#009999'; s = 'Боевой отдел'; }
	else if (st=='g'){ c = '#800080'; s = 'Отдел Креатива'; }
	else if (st=='h'){ c = '#1E90FF'; s = 'Отдел Алхимиков'; }
	else if (st=='i'){ c = '#D87093'; s = 'Отдел Шахтеров'; }
	else if (st=='j'){ c = '#688E23'; s = 'Отдел Лесорубов'; }
	else if (st=='k'){ c = '#00CED1'; s = 'Отдел Рыбаков'; }
	return '<b style=color:'+c+'>'+s+'</b>';
}


function resident_string (element,hr) 
{
 var arr = element.split("|");
 var s='<tr>';
 if (lines_count%2 == 0) s = '<tr style="background-color: #EAEAEA">';
 lines_count++;
 s += '<td width="15" align="center"><img src=/images/icons/eyeChat.png height=16></td>';
 s += ' <td align="left"><img src=/images/emp.gif width=10 height=1><span class=user onclick="javascript:speech(\''+arr[2]+'\')" title="Сообщение" style="cursor:pointer;color:#DD0000;">'+arr[0].substr(0,20)+'</span>[<font class=lvl>'+arr[1]+'</font>] <img src=/desing/img/i.gif onclick="javascript:window.open(\'binfo.php?'+arr[3]+'\',\'_blank\')" style="cursor:pointer" height=16> &nbsp; &nbsp; ';
 s+='</td></tr>';
 return s;
}

function sortnum(list1)
{
	var tmp;
	var w1,w2;
	for (var i=list1.length-1;i>0;i--)
	 for (var j=0;j<i;j++)
		{
			w1 = list1[j].substr(list1[j].indexOf("|")+1,3); w1 = parseInt(w1);
			w2 = list1[j+1].substr(list1[j+1].indexOf("|")+1,3); w2 = parseInt(w2);
			if (w1>w2) 
			 {
			 tmp = list1[j];
			 list1[j] = list1[j+1];
			 list1[j+1]=tmp;
			 }
		}
	list = list1;
}

function MYrand()
{
	return 'rand='+Math.random();
}

function sort_on_fly (sorttype)
{
	document.getElementById('ch').innerHTML = '';
	show_head();
	show_list (sorttype,'');
}

function speech(id)
{
	top.Funcy("speech.php?id="+id);
}

function sign_info(id)
{
	top.Funcy("clan.php?id="+id);
}