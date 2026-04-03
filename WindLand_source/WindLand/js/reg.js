var d = document;
var detect = false;
var dclose = false;
var mls = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
var intv = /^[\d]{1,5}$/;
var xmlhttp = false;
var _res;

function GHR(){var xmlHttpObj = false;if(window.XMLHttpRequest){xmlHttpObj = new XMLHttpRequest();}else if(window.ActiveXObject){try{xmlHttpObj = new ActiveXObject('Microsoft.XMLHTTP');}catch(e){try{xmlHttpObj = new ActiveXObject('Msxml2.XMLHTTP');}catch(e){}}}return xmlHttpObj;}
function APC(){if(xmlhttp.readyState == 4){if(xmlhttp.status == 200){var ret = xmlhttp.responseText;if(ret != 'ERR') {_res = ret.split('@');ReadFile();}}}}

ReadFile = function()
{
    if(_res[0] == 'OK') show_warn('Поздравляем! Регистрация прошла успешно!');
    else
    {
		var msg = '';
		var err;
		for(var i=1; i<_res.length; i++)
		{
			err = -1;
            switch(_res[i])
            {
				case '1': if(!msg) msg = 'Такой логин уже существует!'; err = 0; break;
				case '2': if(!msg) msg = 'Недопустимый формат E-mail, либо такой E-mail уже существует!'; err = 1; break;
				case '3': if(!msg) msg = 'Пароли не совпадают!'; err = 2; break;
				case '4': if(!msg) msg = 'Пароль должен содержать не менее 8 символов!'; err = 2; break;
				case '5': if(!msg) msg = 'Примите условия пользовательского соглашения!'; break;
				case '6': if(!msg) msg = 'Введите защитный код!'; err = 4; break;
                case '7': if(!msg) msg = 'Введите верный код с картинки.'; err = 4; break;
                case '8': if(!msg) msg = 'Данный IP был недавно использован при регистрации.'; break;
                case '9': if(!msg) msg = 'Системная ошибка! Попробуйте зайти позже.'; break; 
				case '10': if(!msg) msg = 'Введите правильный пригласительный ключ!'; break; 
            }
            if(err != -1) d.getElementById('iS'+err).innerHTML = '<img src=/public_content/regimg/invalid.png>';
		}
		show_warn(msg);
	}
}

function iSs(s)
{
	var lg;
	switch(s)
	{
		case 0: lg = d.getElementById('login').value.length > 2 ? 1 : 0; break;
		case 1: lg = d.getElementById('inp_email').value.match(mls) ? 1 : 0; break;
		case 2: lg = d.getElementById('inp_pass').value.length > 7 ? 1 : 0; break;
		case 3: lg = d.getElementById('inp_pass2').value == d.getElementById('inp_pass').value ? 1 : 0; break;
		case 4: lg = d.getElementById('code').value.match(intv) ? 1 : 0; break;
	}
    d.getElementById('iS'+s).innerHTML = '<img src="/public_content/regimg/'+(lg ? '' : 'in')+'valid.png">';
}

RegIster = function()
{
	show_warn('');
    var erm = '';
	var login = d.getElementById("login").value;
    var email = d.getElementById("inp_email").value;
    var pass = d.getElementById("inp_pass").value;
    var pass2 = d.getElementById("inp_pass2").value;
    var code = d.getElementById("code").value;
    var law = d.getElementById("law");
    var invitation = 12345;//d.getElementById("invitation").value;
	var pol = d.getElementById("pol").value
	
	if(login.length < 3) erm = 'Логин не меньше 3-х символов!';
    else if(!email.match(mls)) erm = 'Введите Ваш E-mail!';
    else if(pass.length < 8) erm = 'Пароль должен содержать не менее 8 символов!';
    else if(pass != pass2) erm = 'Пароли не совпадают!';
    else if(!code.match(intv)) erm = 'Введите код с картинки!';
    else if(!law.checked) erm = 'Примите условия пользовательского соглашения!';
	else if (invitation.length < 5) erm = 'Введите пригласительный ключ!';
	else if (pol == 0) erm = 'Выбирете пол.';
	
	if (erm == '') AGS('/gameplay/ajax/register.php?login='+encodeURIComponent(login)+'&invitation='+encodeURIComponent(invitation)+'&email='+encodeURIComponent(email)+'&pass='+encodeURIComponent(pass)+'&pass2='+encodeURIComponent(pass2)+'&pol='+pol+'&code='+code+'&law='+(law.checked ? 1 : 0)+'&'+Math.random());
	else show_warn(erm);
}

AGS = function(script)
{
    if(!xmlhttp) 
    {
        xmlhttp = GHR();
        if(!xmlhttp) return;
    }
    xmlhttp.open('GET',script,true);
    xmlhttp.onreadystatechange = APC;
    xmlhttp.send(null);
}

show_warn = function(msg) {d.getElementById('whow_msg').innerHTML = msg;}

function ch_cpth() {d.getElementById('captcha').src += '&'+Math.random();}

function help_msg(id)
{
	var r = '';
	switch (id)
	{
		case 1: r = 'Логин персонажа может быть от 3-х до 20-и символов'; break;
		case 2: r = 'Администрация не рекомендует использовать бесплатные сервисы такие как mail.ru, rambler.ru, yandex.ru'; break;
		case 3: r = 'Пароль должен быть не менее 8-ми символов'; break;
		case 4: r = 'Повторите пороль, убедитесь в правельности ввода'; break;
	}
	d.getElementById('help_msg').innerHTML = r;
}