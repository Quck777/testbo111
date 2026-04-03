<center><font class=hp><?php

//if (UID!=7) exit('Closed.');

DEFINE ('TYPE', 0); # 0 Обычные, 1 - НГ, 2 - 8 Марта

function rand_wp($i)
{
	return $i[rand(0,(count($i)-1))];
}


if ( isset($http->post['id']) )
{
	$id = $db->sqla("SELECT * FROM `presents` WHERE `id`='".intval($http->post['id'])."'");
	if ( isset($id['id']) )
	{
		$persto = $db->sqla("SELECT `uid`,`user`,`location` FROM `users` WHERE `user`='".addslashes($http->post['towho'])."' and `uid` <> ".UID." LIMIT 1");
		if (@$persto['uid'] and $player->pers['money']>$id['price'] )
		{
			$type = 0; // 0 - нечего, 1 - вещь, 2 - деньги обычные, 3 - уе
			$dop_pres = 0; // Сумма либо ID вещи
			$godnost = tme()+(3600*24*90);
			$pr = $id['price'];
			if (TYPE==1 and $pr>100)
			{
				//int hour, int minute, int second, int month, int day, int year, int is_dst
				//$godnost = tme()+(3600*24*30);// 1293915600;//mktime(0, 0, 0, 1, 2, 2011);
				if ($pr<=300)
				{
					$type = 2;
					$dop_pres = rand_wp(Array(3, 1000, 2000, 3, 3000, 4000, 3, 5000, 3)); // Суммы в LN
				}elseif ($pr<=1000){
					$type = 1;
					$dop_pres = rand_wp(Array(1095, 0, 14546, 17912)); // Мощь предков - Мощь Охотника - Новогодний эликсир Алисы
				}elseif ($pr<=2000){
					$type = 1;
					$dop_pres = rand_wp(Array(1040, 0, 1041, 17912)); // Серп лучшего алхимика - Удочка профеcсионала - Новогодний эликсир Алисы
				}elseif ($pr<=5000){
					$type = 1;
					$dop_pres = rand_wp(Array(17903, 0, 17904, 17912)); // Фляга магии(ma$5000) - Фляга жизни(hp$5000) - Новогодний эликсир Алисы
				}elseif ($pr<=7000){
					$type = 1;
					$dop_pres = rand_wp(Array(0, 17911, 0, 17912, 17907)); // Кольцо Мороза - Новогодний эликсир Алисы - Варежки Мороза
				}elseif ($pr<=10000){
					$type = 1;
					$dop_pres = rand_wp(Array(0, 17911, 0, 17910, 17907)); // Кольцо Мороза - Колон Мороза - Варежки Мороза
				}elseif ($pr<=30000){
					$type = 1;
					$dop_pres = rand_wp(Array(17909, 17911, 0, 17910, 17906, 0, 17905)); // Шапка Мороза - Кольцо Мороза - Колон Мороза - Сапожки Мороза - Шуба Мороза
				}elseif ($pr<=100000){
					$type = 1;
					$dop_pres = rand_wp(Array(17909, 17911, 17908, 17910, 17906, 17905, 17907, 1108)); // Шапка Мороза - Кольцо Мороза - Посох Мороза - Колон Мороза - Сапожки Мороза - Шуба Мороза - Варежки Мороза - Меч Ангела
				}
			}
			elseif (TYPE==4 and $pr>100)
			{
				if ($pr<=50000)
				{
					$type = 2;
					$dop_pres = rand_wp(Array(20000, 30000, 100000, 50000, 150000, 1)); // Суммы в LN
				}elseif ($pr<=70000)
				{
					$type = 2;
					$dop_pres = rand_wp(Array(30000, 40000, 150000, 60000, 200000, 1)); // Суммы в LN
				}elseif ($pr<=100000)
				{
					$type = 3;
					$dop_pres = rand_wp(Array(20, 50, 150, 100, 1, 200)); // Суммы в БР
				}elseif ($pr<=200000)
				{
					$type = 1;
					$dop_pres = rand_wp(Array(245757, 333480, 245694, 333481, 333482, 0)); // Приманка 500  -- Боевая аптечка 300, Благ ангела 200, гдев локара 100 ///подарки за рекламу
				}
				
			}
			
			$db->sql("INSERT INTO `presents_gived` ( `uid` , `name` , `image` , `date` , `who` , `anonymous` , `text`, `type`, `dop_pres`, `godnost` ) 
				VALUES ('".$persto["uid"]."', '".$id["name"]."', '".$id["image"]."', '".tme()."', '".$player->pers['user']."', '".intval($http->post["anonymous"])."', '".$http->post["p"]."',".$type.", ".$dop_pres.", ".$godnost.");");
			$db->sql("UPDATE `users` SET `money`=money-".$id['price']." WHERE `uid`='".$player->pers['uid']."'");
			echo "Вы подарили подарок для ".$persto["user"];
			say_to_chat('s','Вам подарен подарок.',1,$persto["user"],'*',0);
		} else echo "Нет такого персонажа.";
	} else echo "Hacking attempt, go out!!!";
}
?></font></center>
<center>
<hr>
<form action=main.php method=post>
<table border="0" width="800" cellspacing="0" cellpadding="0" class="but2">
<tr>
<td width="100">Для&nbsp;кого</td>
<td width="100"><input type=text class=laar name=towho></td>
<td width="28">&nbsp;</td>
<td width="46">Подпись</td>
<td width="358"><input type=text class=laar name=p style="width: 100%" size="100"></td>
<td width="11">&nbsp;</td>
<td width="56">Анонимно</td>
<td width="20"><input type="checkbox" name="anonymous" value="1"></td>
<td width="172" align="right"><input type="submit" value="Отправить" class="submit"></td>
</tr>
<tr>
<td width="800" colspan="9" class="fightlong" height="17">
<table  border="1" width="100%" cellspacing="0" cellpadding="0" bordercolorlight="#C0C0C0" bordercolordark="#FFFFFF">
<?php
/*	0 - Обычные подарки
	1 - НГ
	2 - 8 Марта
*/

	$presents = $db->sql("SELECT * FROM `presents` WHERE `type`=". TYPE ." ORDER BY `price` ASC");
	$i=0;
	while( $p = mysql_fetch_assoc($presents) )
	{
		if ($i%4==0) echo "<tr>";
		echo "<td class=but width=200 align=center><font class=user>".$p['name']."</font><br><img src='http://".IMG."/presents/".$p['image'].".jpg'><br><font class=items><b>".$p['price']." LN</b></font><br><input type=radio value=".$p['id']." name=id></td>";
		if ($i%4==4) echo "</tr>";
		$i++;
	}
//	echo tme()+(3600*24*90);
?>		
</table>
</td>
</tr>
</table>
</form>
</center>