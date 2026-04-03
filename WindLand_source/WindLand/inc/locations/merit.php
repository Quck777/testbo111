<?
error_reporting(0);
session_start();
$now=time();
include("configs/config.php");
mysql_select_db($mysqlbase, $res); mysql_query("/*!40101 SET NAMES 'cp1251' */") or die("Error: " . mysql_error());
mysql_query("SET NAMES cp1251");


//print "проверка прошла!!!!!";

     {

     echo"<link href='img/gamedw/css/main.css' rel='stylesheet' type='text/css'/>
<link href='img/gamedw/css/mainsity.css' rel='stylesheet' type='text/css'/>";
echo"
<body bgcolor=F5FFD9 leftmargin=0 topmargin=0>
<table width=100% cellspacing=0 cellpadding=5 border=0>
<tr>
        <td><font color=white><small><b>".$pers[money]."</b> <img src=images/money.gif> | <b>".$pers[dmoney]."</b> <img src=images/gameplay/1_1.png></small></font>
        </td>
<td align=right valign=top>";



echo"</td>
</tr>
</table>";

echo"<center><table cellspacing=0 cellpadding=0 border=0 width=900 background='images/about_b_c_bg.jpg'>
          <tr>
          	<td width=14 height=25 nowrap background=images/b_t.jpg valign=bottom><img src=images/b_t_1.jpg></td>
          	<td  nowrap background=images/b_t.jpg><img src=images/b_t_l.jpg></td>
          	<td  nowrap background=images/b_t.jpg align=right><img src=images/uinf_2_2.jpg></td>
          	<td  nowrap background=images/uinf_2_3.jpg style=font-size: 7pt; color: yellow; font-weight: bold; font-family: Verdana;><center><font color=yellow>ИГРОВОЙ ПЕРСОНАЖ</font></td>
          	<td  nowrap background=images/b_t.jpg><img src=images/uinf_2_4.jpg></td>
          	<td  nowrap background=images/b_t.jpg align=right><img src=images/b_m_1.jpg></td>
          	<td  nowrap background=images/b_t.jpg><img src=images/b_r_t.jpg></td>
          </tr>
          <tr>
          	<td nowrap background=images/b_l_bg.jpg valign=top></td>
			<td colspan=5>";
?>


			<table width="100%" height="100%%" cellpadding="0" cellspacing="0" border="0">
			<tr valign="bottom">
   <td>
   <img src="img/table/tab-tl.gif" width="15" height="15" alt=""></td><td style="background: transparent url('img/table/tab-ht.gif') repeat-x bottom;">

							</td><td width="15" class="vabottom"><img src="img/table/tab-tr.gif" width="15" height="15" alt=""></td></tr>
   <tr><td style="background: url('img/table/tab-vl.gif') repeat-y left"><!--  --></td>
			<td style="background: url('img/table/sand4.gif')" valign="top">



<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td valign="top" width="220"><table  width="100%" cellpadding="0" cellspacing="0" border="0">
<tr style="background: transparent url('img/table/stt2ht.gif') repeat-x bottom;" valign="bottom">
<td height="17" width="4"><img src="img/table/stt2tl.gif" width="4" height="17" alt=""><br></td><td align="center">
<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="img/table/stt1l.gif" width="17" height="17" alt=""><br></td><td style="color: #9c0000; font-weight: bold; background: transparent url('img/table/sttc.gif') repeat-x top; padding: 0 15 1 15;">
<?
echo'Мерит';


?>
</td><td><img src="img/table/stt1r.gif" width="17" height="17" alt=""><br></td></tr></table>
</td><td width="4"><img src="img/table/stt2tr.gif" width="4" height="17" alt=""><br></td>
</tr>
<tr><td style="background: url('img/table/stt2vl.gif') repeat-y left"><!--  --></td><td style="background: url('img/table/sand2.gif'); padding: 5px" valign="top"><!--  -->	  <center><img src="img/npc/
<?
echo'1002.gif"  title="Мерит" alt="Мерит"><br>';


?>

	  <div class="p2v">
    <?
echo'Мерит,Добрая девушка которой нужны Камни, которые она потеряла на берегу Озера не далеко от города Мемфис';

?>
   </div>

</td><td style="background: url('img/table/stt2vr.gif') repeat-y right"><!--  --></td></tr>
<tr style="background: transparent url('img/table/stt2hb.gif') repeat-x bottom;" valign="bottom">
<td height="4" width="4"><img src="img/table/stt2bl.gif" width="4" height="4" alt=""><br></td><td align="center"><!--  --></td><td width="4"><img src="img/table/stt2br.gif" width="4" height="4" alt=""><br></td>
</tr>
</table>
<br>
</td>
<td width="10"><img src="img/table/d.gif" width="10" height="1" alt=""><br></td><td valign="top">
<table  width="620" cellpadding="0" cellspacing="0" border="0">
<tr style="background: transparent url('img/table/stt2ht.gif') repeat-x bottom;" valign="bottom">
<td height="17" width="4"><img src="img/table/stt2tl.gif" width="4" height="17" alt=""><br></td><td align="center">
<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="img/table/stt1l.gif" width="17" height="17" alt=""><br></td><td style="color: #9c0000; font-weight: bold; background: transparent url('img/table/sttc.gif') repeat-x top; padding: 0 15 1 15;">Квесты</td><td><img src="img/table/stt1r.gif" width="17" height="17" alt=""><br></td></tr></table>
</td><td width="4"><img src="img/table/stt2tr.gif" width="4" height="17" alt=""><br></td>
</tr>
<tr><td style="background: url('img/table/stt2vl.gif') repeat-y left"><!--  --></td><td style="background: url('img/table/sand2.gif'); padding: 0px" valign="top"><!--  --> 	<img src="img/table/d.gif" width="1" height="10">
  <table>
   <tr title="">
				<td >
   <SCRIPT LANGUAGE="JavaScript" src='js/show_inf.js'></SCRIPT>
 	<DIV ID='MsgSheet'></DIV>

       <SCRIPT LANGUAGE="JavaScript">
		<!--
		var is_writer = 'КВЕСТЫ';
		var st_text = new Array();


        st_text[1.1] = '<?
      if ($kwest['stops'] == 0){

                if ($pers['qwest'] == 8){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start.gif\' alt=\'Доступный квест!\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"4.1\");\'><b>Камни Мерит!</b></A></td></tr></table><br>";}
        if ($pers['qwest'] == 9){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start3.gif\' alt=\'Квест выполняется...\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"4.2\");\'><b>Камни Мерит!</b></A></td></tr></table><br>";}
        if ($pers['qwest'] == 10){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start.gif\' alt=\'Квест выполнен!\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"4.3\");\'><font color=green><b>Камни Мерит!</b></font></A></td></tr></table><br>";}
                 if ($pers['qwest2'] == 0){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start.gif\' alt=\'Доступный квест!\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"5.1\");\'><b>Воины Сетха!</b></A></td></tr></table><br>";}
        if ($pers['qwest2'] == 1){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start3.gif\' alt=\'Квест выполняется...\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"5.2\");\'><b>Воины Сетха!</b></A></td></tr></table><br>";}
        if ($pers['qwest2'] == 2){echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td width=\'40\' background=\'i/npc_bg1.gif\'><IMG SRC=\'img/qst_start.gif\' alt=\'Квест выполнен!\'></td><td border=\'0\' align=\'top\' background=\'i/npc_bg1.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"5.3\");\'><font color=green><b>Воины Сетха!</b></font></A></td></tr></table><br>";}

        if ($pers['qwest'] < 7){echo"<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td background=\'i/npc_bg1.gif\' border=\'0\' align=\'center\'>&nbsp;&nbsp;НЕТ ДОСТУПНЫХ КВЕСТОВ...</td></tr></table><br>";}}
        else{echo "<table width=\"620\" cellspacing=0 cellpadding=0  bordercolor=\"Black\" border=0><tr><td border=\'0\' align=\'top\' background=\'i/15.jpg\'>&nbsp;&nbsp;<b><em>ИДИ В ЖОПУ БЛЯДСКИЙ ХАЦКЕР!!</em></b></td></tr></table><br>";}?>';

             st_text[4.1] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><b>Приветствую тебя!</b> Смотрю ты выполнил задание Небмаатра Зубастики <p>Мне хотелосьбы чтоб ты нашел мои камни на Озере Мемфиса .<br>Нажми кнопку Мир зайди в Лавку купи удочку и приманку,отправляйся на озеро и лови рыбу и там могут попадаться мои потеряные камни, насобираешь 30 камней,после этого приходи ко мне!<br> Награда : Опыта 3500 и 500 <img src=images/money.gif> </td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'?act=3_0\'>Я это сделаю!</A></td></tr></table>';
        st_text[4.2] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><font color=gray><b><em>* Вам необходимо Выловить камни Мерит и принести 30 камней , после чего возвращайтесь к Мерит. *</em></b></font></td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<a href=\'main.php\'>Ясно...</A></td></tr></table>';
        st_text[4.3] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'>Что, мое задание уже выполнено?</td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"4.31\");\'>Да Мерит, это те камни что ты растеряла!</A></td></tr></table>';
        st_text[4.31] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><b>А ты молодец! Похвально.</b><br>Да это они спасибо тебе! Забирай свою Награду</td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'?act=3_2\'>Спасибо!</A></td></tr></table>';

               st_text[5.1] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><b>Приветствую тебя!</b>  <p>Мне хотелосьбы чтоб ты уничтожал врагов Мемфиса проклятых Воинов Сетха .<br>Нажми кнопку Мир Выйди на Арену у убивай Воинов Сетха они доступны с 10 уровня нужно принести 20 сердец <br> Награда : Опыта 3500 и 500 <img src=images/money.gif> и Элитное кольцо Мерит на 3 дня. </td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'?act=4_0\'>Я это сделаю!</A></td></tr></table>';
        st_text[5.2] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><font color=gray><b><em>* Вам необходимо убить Воинов Сетха и принести 20 сердец , после чего возвращайтесь к Мерит. *</em></b></font></td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<a href=\'main.php\'>Ясно...</A></td></tr></table>';
        st_text[5.3] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'>Что, мое задание уже выполнено?</td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'#\' OnClick=\'Messaging(\"5.31\");\'>Да Мерит, я уничтожил Воинов Сетха!</A></td></tr></table>';
        st_text[5.31] = '<table width="620"  bordercolor="#D8C792" border=0><td background=\'i/npc_bg1.gif\'><b>А ты молодец! Похвально.</b><br> Спасибо тебе! Забирай свою Награду</td><tr><td background="i/inman_fon.gif"><IMG SRC=\'img/qst_talk2.gif\'>&nbsp;&nbsp;<A HREF=\'?act=4_2\'>Спасибо!</A></td></tr></table>';







		Messaging(1.1);
		//-->
		</SCRIPT>
  <?




 /////// КВСЕТ №3 Мерит
//////////////////////////////////
if ($pers['kamen'] >= 30 && $pers['qwest'] == 9  ) {
mysql_query("UPDATE `users` set `qwest`='10' where `user` = '".$pers['user']."'");
mysql_query("UPDATE `users` set `kamen`= `kamen`-'30' where `user` = '".$pers['user']."'");
 echo"<script>location='main.php?goloc=jrec'</script>";
}


if ($act=="3_0") {
mysql_query("UPDATE `users` set `qwest`='9' where `user` = '".$pers['user']."'");
// Работаем с чатом
mysql_query("
INSERT INTO
chat
SET
user = 's',
towho = '".$pers['user']."',
private = '1',
location = '*',
message = '<img src=img/msys.gif> <b>Внимание!</b> Для Вас начался квест <b>\"Камни Мерит!\"</b>.',
time = '".date("H:i:s")."',
telepat = '',
type = '0',
color = '333333'");
 echo"<script>location='main.php'</script>";

}

////////////////////////////////////
if ($act=="3_2") {
mysql_query("UPDATE `users` set `money`=`money`+'500', `exp`=`exp`+'3500' where `user` = '".$pers['user']."'");
mysql_query("UPDATE `users` set `qwest`='11' where `user` = '".$pers['user']."'");
	$v = sqla("SELECT id,name FROM weapons WHERE id='14564'");
		$id = insert_wp($v["id"],$pers["uid"]);
 mysql_query("
INSERT INTO
chat
SET
user = 's',
towho = '".$pers['user']."',
private = '1',
location = '*',
message = '<img src=img/msys.gif> <b>Внимание!</b> Для Вас закончился квест <b>\"Камни Мерит!\"</b>. Опыта 3500 и 500 <img src=images/money.gif>' ,
time = '".date("H:i:s")."',
telepat = '',
type = '0',
color = '333333'");
 echo"<script>location='main.php'</script>";
}


 /////// КВСЕТ Сердца Воинов Сетха Мерит
//////////////////////////////////
if ($pers['heart'] >= 20 && $pers['qwest2'] == 1  ) {
mysql_query("UPDATE `users` set `qwest2`='2' where `user` = '".$pers['user']."'");
mysql_query("UPDATE `users` set `heart`= `heart`-'20' where `user` = '".$pers['user']."'");
 echo"<script>location='main.php?goloc=jrec'</script>";
}


if ($act=="4_0") {
mysql_query("UPDATE `users` set `qwest2`='1' where `user` = '".$pers['user']."'");
// Работаем с чатом
mysql_query("
INSERT INTO
chat
SET
user = 's',
towho = '".$pers['user']."',
private = '1',
location = '*',
message = '<img src=img/msys.gif> <b>Внимание!</b> Для Вас начался квест <b>\"Воины Сетха!\"</b>.',
time = '".date("H:i:s")."',
telepat = '',
type = '0',
color = '333333'");
 echo"<script>location='main.php'</script>";

}

////////////////////////////////////
if ($act=="4_2") {
mysql_query("UPDATE `users` set `money`=`money`+'500', `exp`=`exp`+'3500' where `user` = '".$pers['user']."'");
mysql_query("UPDATE `users` set `qwest2`='0' where `user` = '".$pers['user']."'");
	 $v = sqla ("SELECT name,id FROM `weapons` WHERE `id`='15286'");
	$id = insert_wp($v["id"],$pers["uid"],$pers["user"]);
	sql("UPDATE wp SET timeout=".(time()+3600*72)." WHERE id=".$id);


 mysql_query("
INSERT INTO
chat
SET
user = 's',
towho = '".$pers['user']."',
private = '1',
location = '*',
message = '<img src=img/msys.gif> <b>Внимание!</b> Для Вас закончился квест <b>\"Воины Сетха!\"</b>. Опыта 3500 и 500 <img src=images/money.gif> Элитное кольцо Мерит на 3 дня' ,
time = '".date("H:i:s")."',
telepat = '',
type = '0',
color = '333333'");
 echo"<script>location='main.php'</script>";
}





?>
    </td>
			</tr>
		</table>
  </td><td style="background: url('img/table/stt2vr.gif') repeat-y right"><!--  --></td></tr>
<tr style="background: transparent url('img/table/stt2hb.gif') repeat-x bottom;" valign="bottom">
<td height="4" width="4"><img src="img/table/stt2bl.gif" width="4" height="4" alt=""><br></td><td align="center"><!--  --></td><td width="4"><img src="img/table/stt2br.gif" width="4" height="4" alt=""><br></td>
</tr>
</table>
<br>
</td>
</tr>
</table>

			</td>
			<td style="background: url('img/table/tab-vr.gif') repeat-y right"><!--  --></td></tr>
			<tr valign="bottom"><td height="15" width="15"><img src="img/table/tab-bl.gif" width="15" height="15" alt=""><br></td><td style="background: transparent url('img/table/tab-hb.gif') repeat-x bottom;" align="center"><!--  --></td><td width="15"><img src="img/table/tab-br.gif" width="15" height="15" alt=""><br></td></tr>
		</table>


</body>
</html>



<?
   echo"</td>
			<td nowrap background=images/b_r_bg.jpg></td>
		  </tr>
          <tr>
          	<td height=13 nowrap background=images/b_b_bg.jpg valign=bottom><img src=images/b_b_1.jpg></td>
          	<td background=images/b_b_bg.jpg><img src=images/b_b_l.jpg></td>
          	<td background=images/b_b_bg.jpg> </td>
          	<td background=images/b_b_bg.jpg> </td>
          	<td background=images/b_b_bg.jpg> </td>
          	<td background=images/b_b_bg.jpg align=right><img src=images/b_m_lb.jpg></td>
          	<td nowrap background=images/b_b_bg.jpg><img src=images/b_r_b.jpg></td>
          </tr>
		</table>";
}
        ?>



