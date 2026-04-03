var d=document;
var HELP = 0;
var upSc = '112';
var resize_f = 0;

//d.write('<SCRIPT src="/js/mod/jquery.js?'+upSc+'"></SCRIPT>');
//d.write ('<script type="text/javascript" src="/js/yourpers_v2.js?'+upSc+'"></script><LINK href=/css/main_v2.css?'+upSc+' rel=STYLESHEET type=text/css><LINK href=/css/selectbox.css?'+upSc+' rel=STYLESHEET type=text/css><script language=javascript src=/js/pers_v2.js?'+upSc+'></script><script language=javascript src=/js/statsup_v2.js?'+upSc+'></script><SCRIPT language=javascript src="/js/sell.js?'+upSc+'"></SCRIPT><SCRIPT  language=javascript SRC="/js/w.js?'+upSc+'"></SCRIPT><SCRIPT src="/js/fightn.js?'+upSc+'"></SCRIPT><SCRIPT src="/js/mod/scrollto.js"></SCRIPT>');


function BodyScroll() {if(document.body.scrollTop>10)	top.hide_logo();
if(document.body.scrollTop<=10)	top.show_logo();}

function exit()
{
	if (confirm("Вы действительно хотите выйти из игры?"))top.location='/exit.php?rand='+Math.random();
}

var curTimeFor;
var curTimeInt;
var allTime;

function waiter(time,upd,info)
{
	if (!info) info = '';
	   clearInterval(curTimeInt);
	if (!upd) upd = 1; else upd = 0;
	   allTime = time;
       curTimeFor = time;
	   //if (time>10 && top.ctip && top._duration) setTimeout("show_tip(0)",7000);
		//$('.head').get(7).disabled = true;
		var addtxt = '';
		  addtxt = '<table width=190 border=0 cellspacing=0 cellspadding=0><tr><td align=right><img src=/public_content/upimg/skill.gif height=8 width=0 id=waiter_on></td><td align=left>';
		  addtxt += '<img src=/public_content/upimg/no.png height=8 width=190 id=waiter_off></td></table>';
		  if (info!=undefined && info!='') addtxt+= '<br>'+info;
        document.getElementById("waiter").innerHTML = 'Действие, ещё <i><b id=waiter_time>'+allTime+'</b> сек...</i><br>'+addtxt;
		  
		  allTime = allTime-1;
		$(function(){$("#waiter_on").animate({width:190},1000*allTime);$("#waiter_off").animate({width:0},1000*allTime);});

       curTimeInt = setInterval("winterv("+upd+",'"+info+"')",1000);
		 
		if($('.head').get(0))
		{
		$('.head').get(0).disabled = true;
		$('.head').get(1).disabled = true;
		$('.head').get(2).disabled = true;
		$('.head').get(4).disabled = true;
		$('.head').get(5).disabled = true;
		}
}

function winterv(upd,info)
{
	if (!document.getElementById("waiter")) return;
       if(curTimeFor>0 || (!upd && curTimeFor==0))
       {
         document.getElementById("waiter_time").innerHTML = Math.round(curTimeFor);
	      curTimeFor = curTimeFor - 1;
       }
       else if (upd)
       {
		// 	top.Sound("misc8",1,0);
			clearInterval(curTimeInt);
			document.getElementById("waiter").innerHTML = '<a href=main.php class=timef>Обновление...</a></i>';
			window.location = "/main.php";
       }
	   else 
       {
			clearInterval(curTimeInt);
			document.getElementById("waiter").innerHTML = '';
			$('.head').get(0).disabled = false;
			$('.head').get(1).disabled = false;
			$('.head').get(2).disabled = false;
			$('.head').get(4).disabled = false;
			$('.head').get(5).disabled = false;
			//$('.head').get(7).disabled = false;
       }
}

function set_apps(on)
{
if (on) 
{
for (var i=1;i<=7;i++)
	if ($('but'+i)) $('but'+i).disabled = false;
}
else
{
for (var i=1;i<=7;i++)
	if ($('but'+i)) $('but'+i).disabled = true;
}
}

function show_head(curstate,fourthname,code,apps,trvm,help)
{
//	d.write ('<body topmargin="0" style="word-spacing: 0; margin-left: 0; margin-right: 0" leftmargin=0 onresize="on_resize()">');
	if (curstate!=4)
	{
		var pers='';
		var inv='';
		var add='';
		var fght='';
		var fourth='';
		var back = '';
		if (fourthname!='' && !trvm && !apps)
			fourth = "<input class=head type=button value='"+fourthname+"' "+code+" style='width: 160; height: 16' id=but7>";
			else
			fourth = "<input class=head type=button value='' "+code+" style='width: 110; height: 16' id=but7  DISABLED>";
		if (curstate==0 || apps) pers='DISABLED';
		if (curstate==1 || apps) inv='DISABLED';
		if (curstate==5 || apps || trvm) fght='DISABLED';
		if (curstate==3 || apps || trvm) add='DISABLED';
		if (curstate==2 || apps || trvm) back='DISABLED';

		d.write('<table border="0" width="100%" cellspacing="0" cellpadding="0" background="/public_content/upimg/bg_top_up.gif" height=58> <tr> <td width="50%"> <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" background="/public_content/upimg/left_top_up2.gif" style="background-repeat:no-repeat"> <tr> <td height="24">&nbsp;</td> <td height="24">&nbsp;</td> <td height="24">&nbsp;</td> </tr> <tr> <td align="center"><input class="head" type="button" value="Персонаж" onclick="location=\'main.php?go=pers\'" style="width: 160; height: 18" '+pers+' id=but1></td> <td align="center"><input class="head" type="button" value="Рюкзак" onclick="location=\'main.php?go=inv\'" style="width: 160; height: 18" '+inv+' id=but2></td> <td align="center"></td> </tr> <tr> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> </tr> </table> </td> <td><table border="0" width="375" height="58" background="/public_content/upimg/middle_top_up.gif" cellspacing="0" cellpadding="0"> <tr> <td width="124">&nbsp;</td> <td width="118">&nbsp;</td> <td>&nbsp;</td> </tr> <tr> <td width="124" align="right" valign="top" height="29"><input class="head" type="button" value="Обновить" onclick="location=\'main.php\'" style="width:68; height: 20; font-size:11;" id=but9 ></td> <td width="118" height="29">&nbsp;</td> <td height="29" valign="top"><input class="head" type="button" value="Выход" onclick="exit();" style="width: 68; height: 20; font-size:11" id=but8></td> </tr> </table> </td> <td width="50%" background="/public_content/upimg/bg_top_up.gif"> <table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%" background="/public_content/upimg/right_top_up2.gif" style="background-repeat:no-repeat;background-position: right center;"> <tr> <td height="23"></td> <td height="23"></td> <td height="23"></td> </tr> <tr> <td align="center"></td> <td align="center">'+fourth+'</td> <td align="center"  id=but5td><input class="head" type="button" value="Назад" onclick="location=\'main.php?go=back\'" style="width: 70; height: 20" id=but5  '+back+'></td> </tr> <tr> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> </tr> </table> </td> </tr> </table> '); 
		// Вывод инфы
		d.write("<div id=_top style='width:100%; margin-top:2px;'></div>");
	}
	if(help==2)
	{
		document.getElementById('but5td').innerHTML += '<img src="/public_content/upimg/warningred.gif" />';
	}
	HELP = help;
}


function sbox(t)
{
	return '<div align=left><div class="corners"><div class="inner"><div class="content">'+t+'</div></div></div></div>';
}

function sbox2(t,c)
{
	return sbox2b(c)+t+sbox2e(); 
}

function sbox2b(c)
{
	if (c) c = 'text-align:center;';
	return '<table cellspacing="0" cellpadding="0" style="position:relative;top:-8px;width: 100%;"> <tr> <td style="width: 18px; height: 18px"> <img src="/public_content/upimg/left_top.png" width="18" height="18"></td> <td style="height: 18px;background-image: url(\'/public_content/upimg/top.png\');">&nbsp;</td> <td style="width: 18px; height: 18px"> <img src="/public_content/upimg/right_top.png" width="18" height="18"></td> </tr> <tr> <td style="width: 18px;background-image: url(\'/public_content/upimg/left.png\');">&nbsp;</td> <td style="background-image: url(\'/public_content/upimg/bg.png\');'+c+'">';
}

function sbox2e()
{
	return '</td> <td style="width: 18px;background-image: url(\'/public_content/upimg/right.png\');">&nbsp;</td> </tr> <tr> <td style="width: 18px; height: 18px"> <img src="/public_content/upimg/left_bottom.png" width="18" height="18"></td> <td style="height: 18px;background-image: url(\'/public_content/upimg/bottom.png\');">&nbsp;</td> <td style="width: 18px; height: 18px"> <img src="/public_content/upimg/right_bottom.png" width="18" height="18"></td> </tr> </table>';
}

function sbox3(t,c)
{
	return sbox3b(c)+t+sbox3e(); 
}

function sbox3b(c)
{
	if (c) c = 'text-align:center;';
	return '<table style="width: 100%" cellspacing="0" cellpadding="0"> <tr> <td class=sbox3> </td> <td class=sbox3>&nbsp;</td> <td class=sbox3></td> </tr> <tr> <td class=sbox3>&nbsp;</td> <td class=sbox3c '+c+'">';
}

function sbox3e()
{
	return '</td> <td class=sbox3>&nbsp;</td> </tr> <tr> <td class=sbox3></td> <td class=sbox3>&nbsp;</td> <td class=sbox3> </td> </tr> </table>';
}

function too_fast(a)
{
	d.write("<center style='width:100%;height:100%;'><center class=but><center class=puns>Слишком часто!</center>Обновление страницы не чаще чем раз в секунду.<a href='main.php?"+a+"' class=Blocked>Назад</a></center></center>");
	setTimeout("location='main.php?"+a+"';",1100);
}

function sbox4b(c){}
function sbox4e(){}

function on_resize()
{
	if(resize_f) scroll_def();
}