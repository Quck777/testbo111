document.write('<LINK href=/css/ch_main_v2.css rel=STYLESHEET type=text/css><body topmargin="0" style="word-spacing: 0; margin-left: 0; margin-right: 0" leftmargin=0><form action="/msg.php" target="ChatRefresh" method=POST name=mess onsubmit="return top.mess();">');
function cler()
{
	document.mess.message.value = "";
}
function show_buttons(sign)
{// /public_content/butimg
	var send = "onclick=\"document.mess.submit();\" style=\"cursor:pointer\"";
	var smiles = "onclick=\"top.show_smiles();\" style=\"cursor:pointer\"";
	var refresh = "onclick=\"top.ch_refresh()\" style=\"cursor:pointer\"";
	var clear = "onclick=\"top.cl_chat()\" style=\"cursor:pointer\"";
	var tref = "<img src=/public_content/butimg/10_chat.gif onclick=\"top.change_chatspeed();\" name=chatspeed title=\"Скорость обновления (раз в 10 секунд)\">";
	var lat = "<img src=/public_content/butimg/translit_off.gif onclick=\"top.ruslat_c();\" name=translit title=\"Транслит выключен\">";
	var setup = "<img src=/public_content/butimg/chat_all.gif name=chatfyo onclick=\"top.change_chatsetup();\" title=\"Показывать все сообщения\">";
	var possib = "<img src=/public_content/butimg/q.gif name=sdfsss onclick=\"top.frames['main_top'].location='/main.php?addon=action'\" title=\"Возможности\">";
	var sizec = 330;//300
	document.write('<table border="0" width="100%" cellspacing="0" cellpadding="0" background="/public_content/butimg/bg_bc.gif" height="32"> <tr> <td width="19"><img border="0" src="/public_content/butimg/left_bc.gif" width="19" height="32"></td> <td style="width: 76px;cursor:pointer;" id=ttype onclick="ch_ttype(\''+sign+'\')">&nbsp;</td> <td><table border="0" width="100%" height="32" cellspacing="0" cellpadding="0"><tr><td height=8></td></tr><tr><td valign="top"><input type=hidden name="ttype" value="0"><input type=hidden name=type value=1><input class="laar" title="Сообщение" style="width: 100%; height: 20; background:transparent" size="256" name="message"><input type="image" height="0" width="0" src="/images/emp.gif" size="0"></td></tr></table></td> <td width="19"><img border="0" src="/public_content/butimg/lb_bc.gif" width="19" height="32"></td> <td width="148"> <table border="0" width="148" cellspacing="0" cellpadding="0" background="/public_content/butimg/buttons_bc.gif" height="32"> <tr> <td width="31" '+send+'>&nbsp;</td> <td width="39" '+clear+'>&nbsp;</td> <td width="36" '+refresh+'>&nbsp;</td> <td width="41" '+smiles+'>&nbsp;</td> </tr> </table> </td> <td width="230"> '+tref+''+setup+''+lat+''+possib+'<img border="0" src="/public_content/butimg/rb_bc.gif" width="22" height="32"></td> <td style="text-align: center" width="100" id="TIME" class=buttonc onclick="top.frames[\'main_top\'].location=\'/main.php\'" title="Часы показывают серверное время(Россия>Москва), при нажатии обновит игровое окно."><b id="jtimer"></b></td>	</tr> </table> ');
	
	ch_ttype(sign);
	clock();
}

function clock() { 
	jtime[2]++; var vt = [];
	if (jtime[2]>59) { jtime[2]=0; jtime[1]++; }
	if (jtime[1]>59) { jtime[1]=0; jtime[0]++; }
	if (jtime[0]>23) jtime[0]=0;
	if (jtime[0]<10) vt[0]="0"+jtime[0]; else vt[0]= jtime[0];
	if (jtime[1]<10) vt[1]="0"+jtime[1]; else vt[1]= jtime[1];
	if (jtime[2]<10) vt[2]="0"+jtime[2]; else vt[2]= jtime[2];
    ServerTime = vt[0] + ":" + vt[1] + ":" + vt[2]; 
	top.HOURS = jtime[0]; top.MINUTES = jtime[1]; top.SECONDS = jtime[2];
    document.getElementById('jtimer').innerHTML = ServerTime;
    Timer = setTimeout("clock()", 1000); 
}

function ch_ttype(sign,m)
{
	if (m===0)
	{
		document.mess.ttype.value = 'all';
		document.getElementById('ttype').innerHTML = '<b class=lall>ВСЕМ:</b>';
	}else
	if (document.mess.ttype.value == 'priv' && sign || m==2)
	{
		document.mess.ttype.value = 'clan';
		document.getElementById('ttype').innerHTML = '<b class=lclan>КЛАН:</b>';
	}else
	if (document.mess.ttype.value == 'all' || m==1)
	{
		document.mess.ttype.value = 'priv';
		document.getElementById('ttype').innerHTML = '<b class=lpriv>ПРИВАТ:</b>';
	}else
	{
		document.mess.ttype.value = 'all';
		document.getElementById('ttype').innerHTML = '<b class=lall>ВСЕМ:</b>';
	}
}