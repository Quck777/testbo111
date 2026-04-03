<?
$lo=1;
$couns = $db->sql('SELECT * FROM `birja` WHERE `id`>="'.$lo.'"  ORDER BY `dnv_kol` ASC LIMIT 20;');

echo'
<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td bgcolor=#E0D6BB><table cellpadding=5 cellspacing=1 border=0 width=100%><tr><td colspan=4 align=center class=ftxt><b>Биржа покупки DNV за NV</b></td></tr><tr><td bgcolor=#FCFAF3 align=center class=ftxt><b>Сумма DNV</b></td><td bgcolor=#FCFAF3 align=center class=ftxt><b>Курс NV/DNV</b></td><td bgcolor=#FCFAF3 align=center class=ftxt><b>Итого NV</b></td><td bgcolor=#FCFAF3></td></tr>
<tr><td colspan=4 bgcolor=#FFFFFF align=center class=forumne></td></tr>';
while($birja = $db->fetchAssoc($couns)) {
echo'<tr><td bgcolor=#FCFAF3 class=nickname align=center><b>'.$birja['dnv_kol'].'</b></td><td bgcolor=#FCFAF3 class=forumne align=center>'.$birja['kurs_nv'].'</td><td bgcolor=#FCFAF3 class=forumne align=center>'.$birja['dnv_kol']*$birja['kurs_nv'].'</td><td bgcolor=#FCFAF3 align=center>
'.(($player->pers['uid']==$birja['uid_player'])?'<form action="main.php?gopers=birja" method=POST><input type=hidden name=post_id value=2><input type=hidden name=vcod value="'.$birja['id'].'"><input type=hidden name=vcode value="'.$lastom_new.'"><input type=submit value="Удалить" class=lbut></form>':'<form action="main.php?gopers=birja" method=POST><input type=hidden name=post_id value=3><input type=hidden name=vcod value="'.$birja['id'].'"><input type=hidden name=vcode value="'.$lastom_new.'"><input type=submit value="Оплатить" class=lbut></form>').'</td></tr>';
}
echo'
<tr><td colspan=4 align=center class=ftxt><b>Выставить DNV на продажу</b></td></tr><tr><td colspan=4 class=forumne bgcolor=#FFFFFF align=center><form action="main.php?gopers=birja" method=POST><input type=hidden name=test value=2><input type=hidden name=vcode value="'.$lastom_new.'"> Сумма DNV <input type=textbox name=dnv> Курс NV/DNV <input type=textbox name=kurs> <input type="submit" value="Применить" class="login"></form><br><font class=freetxt><font color=#999999>Курс за <b>1 DNV</b> может быть от <b>500 NV</b> до <b>5000 NV</b> с шагом в 50 NV. Минимальная сумма - <b>3 DNV</b>. Выводится <b>20</b> самых выгодных предложений. Предложение для покупателей появляется с задержкой. Покупка DNV за NV только c <b>16</b>-ого уровня.<br><b><font color=#dd0000>Комиссия при удалении заявки составляет 10% от суммы.</font></b></font></font></td></tr></table></td></tr></table>';
?>
