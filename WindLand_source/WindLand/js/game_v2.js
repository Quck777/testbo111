var ruslat = 0;
var fr_size = 200;
var ChatTimerID = -1;
var ChatDelay = 10;
var ChatClearTimerID = -1;
var ChatClearDelay = 600;
var ChatClearSize = 12228;
var ChatFyo=0;
var is_ctrl = 0;
var is_alt = 0;
var chlistref=0;
var RefresherID = -1;
var MRefresherID = -1;
var p = 0;
var button = 0;
var refer = 0;
var clearer = 0;
var chlistr=0;
var smiles_text = '';
var error_ch=0;
var ch_menu_opened=0;
var ChatTxt_ALL = '';
var ChatTxt_ECONOM = '';
var ChatTxt_BATTLE = '';
var chat_turn=1;
var RETURN_win = '';
var loading_interval = -1;
var loading_faze = 0;
var ID_return='';
var statusMSG=1;
var HOURS = 0;
var MINUTES = 0;
var SECONDS = 0;
var latency=0;
var latency_m = 0;
var refreshers = 0;
var SERVER_STATE = 0;
var latencyTM = -1;
var Smiles_OPENED = false;
var mode = 1;
var Msg_Sended = false;
var scroll_progress=0;
var intervscroll = -1;
var maxscroll = 80;
var step=5;
var _duration = 120;
var game_tips = 1;
var laws_tips = 1;
var ready = 1;
var ch_size_interv = -1;
var Resizing = 0;
var SoundsOn = 1;
var SoundsVol = 50;
var DH = document.body.clientHeight;
var PrevMessage = '';
var ResizeVal;
var TmRs = '';
	
var map_en = new Array('s`h','S`h','S`H','s`Х','sh`','Sh`','SH`',"'o",'yo',"'O",'Yo','YO','zh','w','Zh','ZH','W','ch','Ch','CH','sh','Sh','SH','e`','E`',"'u",'yu',"'U",'Yu',"YU","'a",'ya',"'A",'Ya','YA','a','A','b','B','v','V','g','G','d','D','e','E','z','Z','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','r','R','s','S','t','T','u','U','f','F','h','H','c','C','`','y','Y',"'")
var map_ru = new Array('сх','Сх','СХ','сХ','щ','Щ','Щ','ё','ё','Ё','Ё','Ё','ж','ж','Ж','Ж','Ж','ч','Ч','Ч','ш','Ш','Ш','э','Э','ю','ю','Ю','Ю','Ю','я','я','Я','Я','Я','а','А','б','Б','в','В','г','Г','д','Д','е','Е','з','З','и','И','й','Й','к','К','л','Л','м','М','н','Н','о','О','п','П','р','Р','с','С','т','Т','у','У','ф','Ф','х','Х','ц','Ц','ъ','ы','Ы','ь')

function set_return_win(ID_r)
{
	ID_return=ID_r;
	top.frames["main_top"].document.getElementById(ID_return).innerHTML = 'Загрузка<br><img src=/images/progress.gif>';
}

function show_return(text)
{
	top.frames["main_top"].document.getElementById(ID_return).innerHTML = text;
}

function say_private(login,privat)
{
	 var actionlog = top.frames['main_top'].ActionFormUse;
	 if((actionlog != null) && (actionlog != ""))
	 {
		top.frames['main_top'].document.getElementById(actionlog).value=login;
		top.frames['main_top'].document.getElementById(actionlog).focus();
	 }
	 else
	  if(is_ctrl)
	  {
		while(login.indexOf(' ') >=0) login = login.replace (' ', '%20');
		while(login.indexOf('+') >=0) login = login.replace ('+', '%2B');
		while(login.indexOf('#') >=0) login = login.replace ('#', '%23');
		while(login.indexOf('=') >=0) login = login.replace ('=', '%3D');
		window.open('pinfo.php?p='+login, '_blank');
	  }
	  else
	  {
		if(is_alt) 
			top.frames['ch_buttons'].ch_ttype('',1); 
		else 
			top.frames['ch_buttons'].ch_ttype('',0);
		top.frames['ch_buttons'].document.mess.message.focus();
		if(top.frames['ch_buttons'].document.mess.message.value.length < 255)
			top.frames['ch_buttons'].document.mess.message.value = login+'|'+top.frames['ch_buttons'].document.mess.message.value;
	  }
	if (privat==1) top.frames['ch_buttons'].ch_ttype('',1);
	if (privat==2) top.frames['ch_buttons'].ch_ttype('z',2);
	is_ctrl = 0;
	is_alt = 0;
}

function group_private(group)
{
	top.frames['ch_buttons'].ch_ttype('',1);
	if(top.frames['ch_buttons'].document.mess.message.value.length < 255)
	  top.frames['ch_buttons'].document.mess.message.value = group+top.frames['ch_buttons'].document.mess.message.value;
	top.frames['ch_buttons'].document.mess.message.focus();
}

function start()
{   
	if (readCookie("ChatDelay"))
	{
		ChatDelay = readCookie("ChatDelay");
		change_chatspeed();
	}
	if (readCookie("Translit"))
	{
		ruslat = readCookie("Translit");
		ruslat_c();
	}
	if (readCookie("ChatFyo"))
	{
		ChatFyo = readCookie("ChatFyo");
		change_chatsetup();
	}
	if (readCookie("SoundsVol"))
	{
		SoundsVol = readCookie("SoundsVol");
	}
	
	setTimeout("top.frames['ch_list'].location = 'weather.php'",5000);
	MRefresherID = setInterval('main_refresher()', 1000);  
}

function ch_list_ref() 
{
	if (chlistr == 1) 
		chlistr=0; 
	else 
		chlistr=1;
}

function ch_refresh()
{      
	if(ChatFyo != 2 && statusMSG) 
	{
		if (!(refreshers%90))
		top.frames['ChatRefresh'].location = 'msg.php?fio='+ChatFyo+'&timer=1&rand='+Math.random();
		else
		top.frames['ChatRefresh'].location = 'msg.php?fio='+ChatFyo+'&rand='+Math.random();
		refreshers++;
		statusMSG = 0;
	}
}

function ruslat_c()
{
	createCookie("Translit",ruslat);
	if(ruslat == 0)
	{
		ruslat = 1;
		top.frames['ch_buttons'].document.images['translit'].src = '/public_content/butimg/translit_on.gif';
		top.frames['ch_buttons'].document.images['translit'].title = 'Транслит включён';
	}
	else
	{
		ruslat = 0;
		top.frames['ch_buttons'].document.images['translit'].src = '/public_content/butimg/translit_off.gif';
		top.frames['ch_buttons'].document.images['translit'].title = 'Транслит выключен';
	}
}

function main_refresher()
{
	SECONDS++;
	if (SECONDS>59) {SECONDS=0;MINUTES++;}
	if (MINUTES>59) {MINUTES=0;HOURS++;}
	if (HOURS>23) HOURS=0;
	TmRs = '<b>'+transform_time(HOURS)+':'+transform_time(MINUTES)+':'+transform_time(SECONDS)+'</b>';
	window.status = 'Приятной игры!';
	// 
	top.frames['ch_buttons'].document.getElementById('TIME').innerHTML = TmRs;
}	 
  
function transform_time(intt)
{
if (intt<10) return '0'+intt; else return intt;
}

function change_chatspeed()
{
	 createCookie("ChatDelay",ChatDelay);
	 if(ChatDelay == 10) ChatDelay = 30;
	 else if(ChatDelay == 30) ChatDelay = 60;
	 else ChatDelay = 10;
	 clearInterval(ChatTimerID);
	 ChatTimerID = setInterval('ch_refresh()', ChatDelay*1000);
	 top.frames['ch_buttons'].document.images['chatspeed'].src = '/public_content/butimg/'+ChatDelay+'_chat.gif';
	 top.frames['ch_buttons'].document.images['chatspeed'].title = 'Скорость обновления (раз в '+ChatDelay+' секунд)';
	 top.frames['ch_buttons'].document.mess.message.focus();
}

function mess(){
if(PrevMessage == top.frames['ch_buttons'].document.mess.message.value) 
{
	top.frames['ch_buttons'].document.mess.message.value = '';
	return false;
}
if (!Msg_Sended && top.frames['ch_buttons'].document.mess.message.value)
{
PrevMessage = top.frames['ch_buttons'].document.mess.message.value;
var str = top.frames['ch_buttons'].document.mess.message.value;
top.frames['chmain'].changeChatOrientation(top.frames['ch_buttons'].document.mess.type.value);
if (ruslat == 1) 
 {
		var exploded = str.split("|");
		str = exploded[exploded.length-1];
		for (var i = 0; i <map_en.length; ++i)
		while (str.indexOf (map_en[i]) >= 0)
		str = str.replace (map_en[i], map_ru[i]);
		exploded[exploded.length-1] = str;
		str = exploded.join("|");
 }
top.frames['ch_buttons'].document.mess.message.value = str;
clearInterval (ChatTimerID);
ChatTimerID = setInterval('ch_refresh()', ChatDelay*1000);
	
Msg_Sended = true;
top.frames['ch_buttons'].document.mess.message.focus();
return true;
}
}

function cl_chat(){
if (confirm("Вы точно хотите стереть чат?"))
{
if (chat_turn == 1) top.frames['chmain'].document.getElementById('c1').innerHTML = '';
else if (chat_turn == 2) top.frames['chmain'].document.getElementById('c2').innerHTML = '';
else if (chat_turn == 3) top.frames['chmain'].document.getElementById('c3').innerHTML = '';
}
}

function change_chatsetup()
{
		 createCookie("ChatFyo",ChatFyo);
       if(ChatFyo == 0)
       {
         ChatFyo = 1;
         top.frames['ch_buttons'].document.images['chatfyo'].src = '/public_content/butimg/chat_my.gif';
         top.frames['ch_buttons'].document.images['chatfyo'].title = 'Показывать только личные сообщения';
       }
       else if(ChatFyo == 1)
       {
          ChatFyo = 2;
          top.frames['ch_buttons'].document.images['chatfyo'].src = '/public_content/butimg/chat_no.gif';
          top.frames['ch_buttons'].document.images['chatfyo'].title = 'Не показывать сообщения';
       }
       else
       {
          ChatFyo = 0;
          top.frames['ch_buttons'].document.images['chatfyo'].src = '/public_content/butimg/chat_all.gif';
          top.frames['ch_buttons'].document.images['chatfyo'].title = 'Показывать все сообщения';
       }
	   top.frames['ch_buttons'].document.mess.message.focus();
}

function index(){
top.location ='index.php';
}

function goloc(location,time) {
top.frames['main_top'].location='main.php?goloc='+location+'&time='+time;
chlistref = 1;
}

function sm_ins (sm)
{
top.frames['ch_buttons'].document.mess.message.value += '//'+sm+' ';
}

function re_up_ref () {
top.frames['main_top'].location='main.php';	  
}

function add_msg (msg,ttt,add)
{
	if (!top.frames['chmain'].document.getElementById('chat')) return false;
	if ((msg != ""))
	{
		if (clearer == 1) 
		{
		  top.frames['ch_buttons'].document.mess.message.value = "";
		  Msg_Sended = false;
		 clearer=0;
		}
		  top.frames['ch_buttons'].document.mess.message.disabled = false;

		if (ttt == 1)
		{
			var tmpLen = top.frames['chmain'].jQuery("#c1 > *").length;
			var tmpI = 0;
			if (tmpLen>52)
			{
				top.frames['chmain'].jQuery("#c1 > *").each(function(){tmpI++;if (tmpI<(tmpLen-52)){top.frames['chmain'].jQuery(this).remove();}});
			}
			top.frames['chmain'].document.getElementById('c1').innerHTML += msg;
		}
		else if (ttt == 2)
		{
			var tmpLen = top.frames['chmain'].jQuery("#c2 > *").length;
			var tmpI = 0;
			if (tmpLen>32)
			{
				top.frames['chmain'].jQuery("#c2 > *").each(function(){tmpI++;if (tmpI<(tmpLen-32)){top.frames['chmain'].jQuery(this).remove();}});
			}
			top.frames['chmain'].document.getElementById('c2').innerHTML += msg;
		}
		else if (ttt != 0) top.frames['chmain'].document.getElementById('c3').innerHTML += msg;
		if (ttt==0) top.frames['chmain'].document.getElementById('c1').innerHTML += msg;
	}

	if (add)
	{
		if (chat_turn == 1) 
		{
			top.frames['chmain'].document.getElementById('c1').style.display = 'block';
			top.frames['chmain'].document.getElementById('c2').style.display = 'none';
			top.frames['chmain'].document.getElementById('c3').style.display = 'none';
		}
		else if (chat_turn == 2) 
		{
		top.frames['chmain'].document.getElementById('c2').style.display = 'block';
		top.frames['chmain'].document.getElementById('c1').style.display = 'none';
		top.frames['chmain'].document.getElementById('c3').style.display = 'none';
		}
		else if (chat_turn == 3) 
		{
			top.frames['chmain'].document.getElementById('c3').style.display = 'block';
			top.frames['chmain'].document.getElementById('c2').style.display = 'none';
			top.frames['chmain'].document.getElementById('c1').style.display = 'none';
		}
		top.frames['chmain'].scroll_chat();
	}
}

function helpwin(page)
{
       url = '/help/'+page;
       viewwin = open(url,"helpWindow","width=420, height=400, status=no, toolbar=no, menubar=no, resizable=no, scrollbars=yes");
}

function show_smiles()
{
	var sm = top.frames['ch_list'].document.getElementById('smiles');
	var ch = top.frames['ch_list'].document.getElementById('head');
	if (sm.style.visibility == 'visible') {hide_smiles();Smiles_OPENED=false;return false;}
	ch.style.visibility='hidden';
	if (smiles_text == ''){
	var i=0;
	var num=0;
	for (i=1;i<268;i++){num=i;
	if (num/100<1) if (num/10<1) num='00'+num;
	else if (num/100<1) if (num/10>=1) num='0'+num;
	smiles_text += '<img src="/images/smiles/smile_'+num+'.gif" onclick="top.sm_ins(\''+num+'\');" style="cursor:hand;" title="//'+num+'">';
	}
	}
	sm.innerHTML = smiles_text;
	sm.top = 0;
	sm.style.visibility = 'visible';
	ch.style.visibility = 'hidden';
	Smiles_OPENED=true;;
}


function hide_smiles(){
var sm = top.frames['ch_list'].document.getElementById('smiles');
var ch = top.frames['ch_list'].document.getElementById('head');
sm.style.visibility = 'hidden';
ch.style.visibility = 'visible';
sm.top = -10000;
top.frames['ch_list'].scrollBy(0,-65000);
}

function flog_clear()
{
	top.frames['chmain'].document.getElementById('c3').innerHTML = '';
}

function flog_set()
{
top.frames['chmain'].changeChatOrientation(3);
}

function flog_unset()
{
top.frames['chmain'].changeChatOrientation(1);
}

function aready ()
{
	ready = 1;
}

function dw(t)
{
	document.write(t);
}
function view_frames()
{
	dw("<table border=0 cellspacing=0 cellspadding=0 width=100% height=100%>");
	dw("<tr>");
	 dw("<td colspan=10 style='width:100%; height:70%;' valign=top align=center id=maintd>");
		dw("<iframe src='/main.php' id=main_top name=main_top scrolling=auto noResize frameborder=0 border=0 framespacing=0 marginwidth=0 marginheight=0 style='width:100%;height:100%' class=iframe>Обновите браузер.</iframe>");
	 dw("</td>");
	dw("</tr>");
	dw("<tr>");
	 dw("<td colspan=10 style='width:100%; height:4px;cursor:move;background-color:#CCCCCC;' valign=top align=center onmousedown='InitResize();'>");
	 dw("</td>");
	dw("</tr>");
	dw("<tr>");
	 dw("<td style='width:70%;' colspan=2 align=center class=inv_but id=chtd1>");
		dw("<iframe src='/frames/chat.php' id=chmain name=chmain scrolling=auto noResize frameborder=0 border=0 framespacing=0 marginwidth=0 marginheight=0 style='width:100%;height:100%; height:100%;' class=iframe2>Обновите браузер.</iframe>");
	 dw("</td>");
	 dw("<td style='width:30%;' colspan=2 align=center class=inv_but id=chtd2>");
		dw("<iframe src='/frames/ch.php' id=ch_list name=ch_list scrolling=auto noResize frameborder=0 border=0 framespacing=0 marginwidth=0 marginheight=0 style='width:100%;height:100%; height:100%;' class=iframe2>Обновите браузер.</iframe>");
	 dw("</td>");
	dw("</tr>");
	dw("<tr>");
	 dw("<td colspan=10 style='width:100%; height:32px;' valign=top align=center>");
		dw("<iframe src='/frames/but.php' id='ch_buttons' name='ch_buttons' scrolling=no noResize frameborder=0 border=0 framespacing=0 marginwidth=0 marginheight=0 style='width:100%;height:100%;border:0;'>Обновите браузер.</iframe>");
	 dw("</td>");
	dw("</tr>");
	dw("</table>");
	
		dw("<iframe style='display:none;' src='' name='updater' id='updater'></iframe>");
		dw("<iframe style='display:none;' src='' name='ChatRefresh' id='ChatRefresh'></iframe>");
		dw("<iframe style='display:none;' src='' name='returner' id='returner'></iframe>");
		
		dw('<div class=news style="position:absolute;top:0px;left:0px;width:100%;height:100%;display:none;z-index:5;opacity:0.2;filter:alpha(opacity=20);cursor:move;" id=bgblack onmouseup="DestrResize()"  onMouseMove="Resizer(event)"></div>');
		
		dw('<div class=news style="position:absolute;top:0px;left:0px;width:100%;height:100%;display:none;z-index:5;opacity:0.4;filter:alpha(opacity=70);cursor:pointer;" id=bgblack2 onclick="FuncyOff()"></div>');
		dw('<div class=inv style="position:absolute;top:10%;left:10%;width:80%;height:80%;display:none;z-index:6;" id=frame></div>');
		
		dw('<SCRIPT type="text/javascript" src="/js/mod/sm2.js"></SCRIPT>');
		dw('<SCRIPT type="text/javascript" src="/js/mod/soundMixes.js"></SCRIPT>');
		
		
		ResizeVal = 330;
		DH = document.body.clientHeight;
		document.getElementById('maintd').style.height = ResizeVal;
		jQuery("iframe.iframe2").css({height:(DH-ResizeVal-42+'px')});
	
	
		ChatTimerID = setInterval('ch_refresh()', ChatDelay*1000);		
		
}

function Funcy(url)
{
	jQuery("#bgblack2").css({display:"block"});
	jQuery("#frame").fadeIn(500);
	jQuery("#frame").html("<iframe src='"+url+"' scrolling=auto noResize frameborder=0 border=0 framespacing=0 marginwidth=0 marginheight=0 style='width:100%;height:100%' class=iframe>Обновите браузер.</iframe>");
}

function FuncyOff()
{
	jQuery("#bgblack2").css({display:"none"});
	jQuery("#frame").css({display:"none"});
}

function InitResize()
{
	Resizing = 1;
	jQuery("#bgblack").css({display:"block"});
	jQuery("iframe.iframe").css({display:"none"});
	DH = (DH > document.height)?document.height:DH;
}

function DestrResize()
{
	Resizing = 0;
	jQuery("#bgblack").css({display:"none"});
	jQuery("iframe.iframe").css({display:"block"});
}

function Resizer(event)
{
	if (!event) var event = window.event;
	if (Resizing && event.clientY<(DH-48))
	{
		document.getElementById('maintd').style.height = event.clientY-2+'px';
		jQuery("iframe.iframe2").css(
		{height:(DH-event.clientY-44+'px')});
		top.frames['chmain'].document.getElementById('chat').scrollTop += 6500;
	}
}
function soundsVol(a)
{
	SoundsVol = parseFloat(SoundsVol);
	var tmp = SoundsVol;
	var ttmp;
	SoundsVol += a/20;
	if (SoundsVol<=0) 
	{
		SoundsVol = 0;
		StopMixes();
		top.frames['chmain'].document.getElementById('VolumeDown').className = 'Fader';
		return true;
	}
	else
		top.frames['chmain'].document.getElementById('VolumeDown').className = '';
	
	if (SoundsVol>10) 
	{
		SoundsVol = 10;
		top.frames['chmain'].document.getElementById('VolumeUp').className = 'Fader';
	}
	else
		top.frames['chmain'].document.getElementById('VolumeUp').className = '';
		
	for (var i=0;i<SoundCount;i++)
	{
		ttmp = (tmp!=0)?soundManager.getSoundById(SoundsList[i]).volume*SoundsVol/tmp:SoundsVol;
		if (ttmp>100) ttmp = 100;
		if (ttmp<1) 
		{
			soundManager.pauseAll();
			break;
		}
		else
		{
			soundManager.resumeAll();
		}
		soundManager.getSoundById(SoundsList[i]).setVolume(ttmp);
	}
	
	createCookie("SoundsVol",SoundsVol,0);
}


SoundsList = new Array();
var SoundCount = 0;

function Sound(a,b,loop)
{
if (b==undefined) b = 1;
if (!SoundsOn) return;
if (!soundManager.getSoundById(a))
{
	soundManager.createSound({
 id: a, // required
 url: 'sounds/'+a+'.mp3', // required
 // optional sound parameters here, see Sound Properties for full list
 volume: b*SoundsVol,
 autoPlay: true,
 onfinish: (loop==1)?function(){soundManager.play(a);}:null
	});
	SoundsList[SoundCount] = a;SoundCount++;	
}
if (soundManager.getSoundById(a).playState)
{
		soundManager.createSound({
 id: a+'_2', // required
 url: 'sounds/'+a+'.mp3', // required
 // optional sound parameters here, see Sound Properties for full list
 volume: b*SoundsVol,
 autoPlay: true,
 onfinish: (loop==1)?function(){soundManager.play(a);}:null
	});
	SoundsList[SoundCount] = a+'_2';SoundCount++;
	return soundManager.play(a+'_2');
}
else 
	return soundManager.play(a);
}