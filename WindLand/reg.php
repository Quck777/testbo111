<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

error_reporting(0);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<LINK href="/css/main_v2.css" rel="stylesheet" type="text/css">
	<title>Регистрация</title>
	<meta http-equiv=content-type content='text/html; charset=windows-1251'>
	<SCRIPT src="/js/reg.js"></SCRIPT>
</head>
<body>

<table border="0" width="100%">
<tr>
	<td class="items"> <span class="hp">Логин персонажа</span></td>
	<td><input type="text" style="width: 100%;" class="login" onchange="iSs(0)" id="login" onClick="help_msg(1);"></td>
	<td><div id="iS0"></div></td>
</tr>
<tr>
	<td class="items"> <span lang="en-us" class="hp">E-Mail</span></td>
	<td><input type="text" style="width: 100%;" class="login" onchange="iSs(1)" id="inp_email" onClick="help_msg(2);"></td>
	<td><div id="iS1"></div></td>
</tr>
<tr>
	<td class="items">Пароль</td>
	<td><input type="password" style="width: 100%;" class="login"  onchange="iSs(2)" id="inp_pass"  onClick="help_msg(3);"></td>
	<td><div id="iS2"></div></td>
</tr>
<tr>
	<td class="items">Пароль ещё раз</td>
	<td><input type="password" style="width: 100%" class="login" onchange="iSs(3)" id="inp_pass2" onClick="help_msg(4);"></td>
	<td><div id="iS3"></div></td>
</tr>
<tr>
	<td class="items">Пол</td>
	<td>
	<select size="1" id="pol" class="items" style="width: 100%" onClick="help_msg(0);">
	<option value="0" SELECTED></option>
	<option value="1">Мужской</option>
	<option value="2">Женский</option> </select>
	</td>
	<td></td>
</tr>

<tr>
	<td class="items">Цифры на картинке</td>
	<td>
	<table width="100%"><tr>
		<td width="45px"><img border="0" src="./gameplay/code/reg_code.php?<?php echo session_name()?>=<?php echo session_id()?>" alt="Код" id="captcha" ></td>
		<td>
			<input type="text" id="code" size="8" class="login" maxlength="5" style="width: 100%;" onClick="help_msg(0);">
			<a href="javascript:ch_cpth()" class=timef>обновить</a>
		</td>
		<td><div id="iS4"></div></td>
	</tr></table>
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="items">Я согласен с <a href="justice.htm" target="_blank"> законами игры</a></td>
	<td><input type="checkbox" id="law" value=1 onClick="help_msg(0);"></td>
	<td>&nbsp;</td>
</tr>
<?php
/*
<tr>
	<td class="items"> <p><span lang="en-us" class="hp">Пригласительный ключ</span></p></td>
	<td><input type="text" style="width: 100%;" class="login" id="invitation"></td>
	<td>&nbsp;</td>
</tr>
*/
?>
</table>

<div align="center">
	<a href="javascript:RegIster();" class="bg" style="width:80%">Зарегистрироваться</a>
</div>
<br />
<div class="hp" align="center" id="whow_msg"></div>
<br />
<div class="ma" align="center" id="help_msg"></div>

</body>
</html>