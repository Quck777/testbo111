var GlobalSupport = false;
if (REF_COMP==undefined) var REF_COMP = false;

function build_pers(sh,shd,oj,ojd,or1,or1d,po,pod,z1,z1d,z2,z2d,z3,z3d,sa,sad,na,nad,pe,ped,or2,or2d,ko1,ko1d,ko2,ko2d,br,brd,pers,inv,sign,nick,level,hp,mhp,ma,mma,tire,kam1,kam2,kam3,kam4,kam1d,kam2d,kam3d,kam4d,curh,maxh,curm,maxm,hp_int,ma_int,ss,sl,su,szd,szn,sp,sup,MONEY,dmoney,KB,gray1,gray2,gray3,gray4,gray5,udmin,udmax,rank_i,calling,victories,losses,experience,peace_experience,exp_to_lvl,zeroing,inv,dil,exp_proc,ws1,ws2,ws3,ws4,ws5,ws6,free_skills,help,ref,coins,lo,lod,zub,sss,imoney)
{
	var d=document;
	var ss1=ss;
	var sl1=sl;
	var su1=su;
	var szd1=szd;
	var szn1=szn;
	var sp1=sp;
	var ExpText = '';

	if (parseInt(ss)<1) ss=1;
	if (parseInt(sl)<1) sl=1;
	if (parseInt(su)<1) su=1;
	if (parseInt(szd)<1) szd=1;
	if (parseInt(szn)<1) szn=1;
	if (parseInt(sp)<1) sp=1;
	if (ws1!='0' && ws1!=undefined)ss='<b class=user>'+ss+'</b>'+' ('+(ss-ws1)+'<font color=green>'+ws1+'</font>)';else ss='<b class=user>'+ss+'</b>';
	if (ws2!='0' && ws2!=undefined)sl='<b class=user>'+sl+'</b>'+' ('+(sl-ws2)+'<font color=green>'+ws2+'</font>)';else sl='<b class=user>'+sl+'</b>';
	if (ws3!='0' && ws3!=undefined)su='<b class=user>'+su+'</b>'+' ('+(su-ws3)+'<font color=green>'+ws3+'</font>)';else su='<b class=user>'+su+'</b>';
	if (ws4!='0' && ws4!=undefined)szd='<b class=user>'+szd+'</b>'+' ('+(szd-ws4)+'<font color=green>'+ws4+'</font>)';else szd='<b class=user>'+szd+'</b>';
	if (ws5!='0' && ws5!=undefined)szn='<b class=user>'+szn+'</b>'+' ('+(szn-ws5)+'<font color=green>'+ws5+'</font>)';else szn='<b class=user>'+szn+'</b>';
	if (ws6!='0' && ws6!=undefined)sp='<b class=user>'+sp+'</b>'+' ('+(sp-ws6)+'<font color=green>'+ws6+'</font>)';else sp='<b class=user>'+sp+'</b>';
	
	d.write('<table border="1" width="100%" cellspacing="0" cellpadding="0" class=inv><tr>');
	var givem = 'javascript:peredatm()';
	if (level<5) givem = 'javascript:void(0)';
	if (MONEY) MONEY='<a href="'+givem+'" class=blocked>'+MONEY+' LN&nbsp;<img src="/images/gameplay/1_2.png" /></a>'; else MONEY='<a href="'+givem+'" class=blocked>'+MONEY+' LN&nbsp;<img src="/images/gameplay/1_2.png" /></a>';

	var MoneyText = '<b class=about>Деньги<img src="/images/emp.gif" width=180 height=3><img src="/images/DS/hr.png" width=180 height=3></b><center><table border=0 cellspacing=0 cellspadding=0 width=90% class=table_solid> <tr> <td class=gray>Игровые деньги:</td> <td>'+MONEY+'</td> </tr>';
	if (dmoney>0) MoneyText += '<tr> <td class=gray>Бриллианты:</td> <td><a href=main.php?go=pers&gopers=service class=blocked title="Бриллианты">'+dmoney+'&nbsp;<img src="/images/gameplay/1_1.png"></a></td> </tr>';
	if (coins>0) MoneyText += ' <tr> <td class=gray>Пергаменты:</td> <td class=ma>'+coins+'<img src=/images/gameplay/1_3.png height=12 title="Количество ваших пергаментов , полученных за проведение отличных боёв. Они могут вам понадобиться в университете."></td> </tr>';
	if (zub>0) MoneyText += ' <tr> <td class=gray>Зубки:</td> <td class=ma>'+zub+'<img src=/images/gameplay/1_3.png height=12 title="Количество ваших пергаментов , полученных за проведение отличных боёв. Они могут вам понадобиться в университете."></td> </tr>';
	if (imoney>0) MoneyText += '<tr> <td class=gray>IM:</td> <td class=blocked title="Количество ваших IM.">'+imoney+'<img src="/images/gameplay/im.png"></td> </tr>';
	MoneyText += '</table></center><img src=/images/emp.gif height=5><br>';

	d.write('<td valign="top" width="200" class=inv>');
	//d.write(sbox2b());
	//d.write(''+MONEY+'');

	var TIP_s1 = 'onmouseover="s_des(event,\'|Сила влияет на урон, наносимый при физическом контакте в бою.\')" onmouseout="h_des()" onmousemove=move_alt(event)';
	var TIP_s2 = 'onmouseover="s_des(event,\'|Реакция влияет на шанс увернуться в бою от ударов противника, а так же уменьшает шанс противнику на уворот.\')" onmouseout="h_des()" onmousemove=move_alt(event)';
	var TIP_s3 = 'onmouseover="s_des(event,\'|Удача влияет на шанс нанести сокрушительный удар в бою.\')" onmouseout="h_des()" onmousemove=move_alt(event)';
	var TIP_s4 = 'onmouseover="s_des(event,\'|Здоровье повышает вашу жизнь, броню и влияет на массу, которую может носить ваш персонаж.\')" onmouseout="h_des()" onmousemove=move_alt(event)';
	var TIP_s5 = 'onmouseover="s_des(event,\'|Интеллект позволяет осваивать мирные профессии. Интеллект не влияет в бою.\')" onmouseout="h_des()" onmousemove=move_alt(event)';
	var TIP_s6 = 'onmouseover="s_des(event,\'|Сила воли повышает количество маны и увеличивает урон ваших заклинаний.\')" onmouseout="h_des()" onmousemove=move_alt(event)';

	d.write(MoneyText);
	d.write('<b class=about>Основные</b><center><table border=0 width=90% cellspacing=1 cellspadding=1 class=table_solid><tr> <td width=50% class=stats '+TIP_s1+' style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Сила:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=sila>'+ss+'</div></td> </tr> <tr></tr> <tr> <td width=50% class=stats '+TIP_s2+' style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Реакция:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=lovk>'+sl+'</div></td> </tr><tr></tr> <tr> <td width=50% class=stats '+TIP_s3+' style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Удача:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=udacha>'+su+'</div></td> </tr> <tr></tr> <tr> <td width=50% class=stats '+TIP_s4+' style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Здоровье:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=zdorov>'+szd+'</div></td> </tr><tr></tr> <tr> <td width=50% class=stats '+TIP_s5+' style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Интеллект:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=znanya>'+szn+'</div></td> </tr> <tr> <td width=50% class=stats '+TIP_s6+' nowrap style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'>Сила Воли:</td> <td style=\'border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;\'><div id=power>'+sp+'</div></td> </tr> <tr></tr> <tr> <td colspan=6 align=center><div id=ups class=timef></div></td></tr></table></center>');
	if (inv!=2 && sup>0)start(ss1,sl1,su1,szd1,szn1,sp1,sup,level);
	if (sup>0 && inv!=2) d.write('<div id=SAVEstats bgcolor="#F5F5F5" align=center><a onclick="save()" class=bga href="javascript:void(0)">Сохранить</a></div>');
	/*if (DecreaseDamage) KB += ' [<i class=timef title="Понижение физического урона '+DecreaseDamage+'%">'+DecreaseDamage+'%</i>]';*/
	d.write('<b class=about>Модификаторы</b><center><table border="0" width="90%" cellspacing="0" class=table_solid>');
	d.write("<tr><td class=gray style='border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;'>Класс&nbsp;Брони:</td><td class=green width=90% align=center style='border-bottom-style: solid;border-bottom-color: #DFDFDF;border-bottom-width:1px;'>"+KB+"</td></tr>");
	if (udmax>2) d.write("<tr><td class=gray>Удар:</td><td class=mfb width=90%>"+udmin+"-"+udmax+"</td></tr>");
	if (gray1!=0) d.write("<tr><td class=gray>Сокрушение:</td><td class=mfb width=90%>"+gray1+"%</td></tr>");
	if (gray2!=0) d.write("<tr><td class=gray>Уловка:</td><td class=mfb width=90%>"+gray2+"%</td></tr>");
	if (gray3!=0) d.write("<tr><td class=gray>Точность:</td><td class=mfb width=90%>"+gray3+"%</td></tr>");
	if (gray4!=0) d.write("<tr><td class=gray>Стойкость:</td><td class=mfb width=90%>"+gray4+"%</td></tr>");
	if (gray5!=0) d.write("<tr><td class=gray>Пробой:</td><td class=mfb width=90%>"+gray5+"%</td></tr>");
	if (rank_i>15)d.write("<tr><td class=gray>Коэффициент:</font></td><td class=mfb width=90%>"+rank_i+"</td></tr>");
	if (calling!="")d.write("<tr><td><font class=gray>Звание:</font></td><td align=center class=gray>"+calling+"</td></tr>");
	d.write("</table></center>");
	if(inv!=2)
	{
		if (exp_proc>100) exp_proc=100;
		ExpText += ("<center class=but><font class=ma>Линия Опыта  ["+exp_proc+"%]</font></center>");
		exp = exp_proc;
		if (exp<0) exp=0;
		ExpText +=('<center class=but><table border="0" width="90%" cellspacing="0" cellpadding="0"><tr><td align=center><img src="/public_content/ypimg/ma.png" width='+(97-exp)+'% height=9><img src="/public_content/ypimg/no.png" width='+(exp-3)+'% height=9></td></tr></table></center>');

		ExpText += ("<center class=but><table border=0 width=90% cellspacing=0 cellspadding=0><tr><td class=exp>Побед:</td><td class=exp><b>"+victories+"</b></td></tr><tr><td class=exp>Поражений:</td><td class=exp><b>"+losses+"</b><tr><td></td></tr><tr><td class=exp><font color=#800000>Боевой опыт:</font></td><td class=exp><font color=#800000><b>"+experience+"</b></font></td></tr><tr><td class=exp><font color=#334BBB>Мирный опыт:</font></td><td class=exp><font color=#004BBB><b>"+peace_experience+"</b></font></td></tr><tr><td class=exp><font color=#0A8900>До уровня:</font></td><td class=exp><font color=#0A8900><b>"+exp_to_lvl+"</b></font></td></tr></table></center>");
	}
	//d.write(sbox2e());
	d.write('</td>');
	d.write('<td valign="top" width=250 align=center class=inv>');
	show_pers_new(sh,shd,oj,ojd,or1,or1d,po,pod,z1,z1d,z2,z2d,z3,z3d,sa,sad,na,nad,pe,ped,or2,or2d,ko1,ko1d,ko2,ko2d,br,brd,pers,inv,sign,nick,level,hp,mhp,ma,mma,tire,kam1,kam2,kam3,kam4,kam1d,kam2d,kam3d,kam4d,inv,dil,lo,lod);
	d.write('<div id=aurasc class=aurasc></div></td>');
	
	d.write('<td align="left" valign="top" class=inv id=weapons height=100%>');
	if(inv!=1 && inv!=2)
	{
		var helpimg = ''; //if (help == 0) helpimg = '<img src="/images/warningred.gif" width=10/>';
		var lawimg = ''; //if (help == 1) lawimg = '<img src="/images/warningred.gif" width=10/>';
		var warnimg = ''; //if (!sup && free_skills) warnimg = '<img src="/images/warningblue.gif" />';
		d.write(sbox2b()+'<table border=0 width=100% height=100% cellspacing=0 cellspadding=0><tr><td><table border=0 width=100% height=100% cellspacing=0 cellspadding=0 class=inv_but><tr><td width=20% align=center><a href=main.php?gopers=info class=Blocked>'+helpimg+'Помощь</a></td><td width=20% align=center> <a href=main.php?gopers=um class=Blocked>'+warnimg+'Умения</a> </td><td width=20% align=center> <a href=main.php?gopers=parol class=Blocked>Пароль</a></td><td width=20% align=center> <a href=main.php?gopers=options class=Blocked>Настройки</a></td><td width=20% align=center> <a href="javascript:support();" class=Blocked>Суппорт</a></td></tr></table></td></tr><tr><td align=center><a href="http://f.cb662053.tw1.ru/" target=_blank class=nt>Форум</a> ');
	//	if (zeroing>0) d.write("| <a href=# onclick=\"obnyl()\" class=nt>Обнулиться ["+zeroing+"]</a> ");
	//	d.write("| <a href=main.php?go=possibilities class=nt>Возможности</a> ");
		if (sign!='none') d.write("| <a href=main.php?go=orden class=nt>Клан </a> ");
	//	if (dil==1) d.write("| <a href=main.php?gopers=diler class=nt>Реклама </a> ");
		if(level > 1)  d.write("| <a href=main.php?gopers=service class=nt>Сервис [<img src=/images/signs/diler.gif>]</a> ");
		if (ref>0)d.write("| <a href=main.php?gopers=referals class=nt>Рефералы</a> ");
		if(level > 9) d.write('| <a href=main.php?gopers=student class=nt>Ученик</a> ');
	//	if (sign=='watchers') d.write('| <a href=main.php?go=zakon class=nt>Проверки</a> ');
		d.write('| <a href=main.php?go=self class=nt>Личное</a> ');
		d.write('| <a href=main.php?gopers=birja class=nt>Биржа БР</a> ');
		if (REF_COMP==true) d.write('| <a href=main.php?gopers=concurs class=hp>Конкурс</a> ');
		d.write('| <a href=main.php class=nt>Назад</a></td></tr></table>'+sbox2e()+'<div id="support"></div><table border=0 width=100% height=100% cellspacing=0 cellspadding=0><tr><td valign="top" height=100%><div style="width:98%"  id=information></div></td></tr></table>');
	}
	d.write('</td></tr></table>');
	if (inv!=1 && inv!=2) d.getElementById('information').innerHTML = ExpText+d.getElementById('inf_from_php').innerHTML;
	else d.getElementById('weapons').innerHTML = d.getElementById('inf_from_php').innerHTML;
	d.getElementById('inf_from_php').innerHTML = '';
	
	if (inv!=2) ins_HP(curh, maxh, curm, maxm, hp_int, ma_int);
}

function obnyl (){
	if (confirm ('Вы действительно хотите обнулиться?')) {location='main.php?gopers=obnyl';}
}
function conf(url) {
	if (confirm('Вы действительно хотите выкинуть этот предмет?')) location = url;
}
function confc(url) {
	if (confirm('Вы действительно хотите пожертвовать клану этот предмет?')) location = url;
}
function conf_sale(url) {
	if (confirm('Вы действительно хотите сдать этот предмет?')) location = url;
}

var AuraCounts = 0;
function view_auras(text,where)
{
	var ars = text.split('|');
	var ar,t;
	for(var i=0;i<ars.length;i++)
	{
	if (ars[i]!='')
	{
	ar = ars[i].split('#');
	if (ar[0].indexOf('.gif')!=-1) ar[0] = ar[0].substr(0,ar[0].length-4);
	t = '<img src="/images/magic/'+ar[0]+'.gif" onmouseover="s_des(event,\'0|<img src=/images/magic/'+ar[0]+'.gif align=left>'+ar[1]+'\')" onmouseout="h_des()" onmousemove=move_alt(event) height=30>';
	AuraCounts++;
	if ((i+1)%5==0 && i!=0) t+= '<br>';
	if (where)
	 document.getElementById(where).innerHTML += t;
	else
	 document.getElementById('aurasc').innerHTML += t;
	}
	}
}

function support()
{
	var s = '';
	if (GlobalSupport==false)
	{
		s+= sbox2b();
		s+= 'Вы можете известить Администрацию проекта о найденой ошибке, либо выдвинуть Ваше предложение относительно проекта. Ограничение по символам - 1500.';
		s+= '<br /><br /><form method="post" align="center">Заголовок <input type="text" class="login" name="title" maxlength="50" size="59"><textarea name="support" class="inv" rows="7" cols=70></textarea><br /><input type="submit" class="login" value="Отправить"></form>';
		s+= '<br />P.S. За флуд можно получить блок ;)';
	//	s+= 'Не актуально..';
		s+= sbox2e();
		GlobalSupport = true;
	} else GlobalSupport = false;
	$('#support').html(s);
}