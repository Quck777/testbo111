<?php
	####Новый год
	if($player->pers["new_year"]>1)
	{
	//	echo "<center class=fightlong><img src=images/persons/male_moroz.gif height=20> До нападения Деда осталось <b>".mtrunc($player->pers["new_year"]-tme())." сек.</b>!</center>";
	}
	
	if($player->pers["free_stats"]<5 and $player->pers["level"]<3  and $player->pers["chp"]/$player->pers["hp"]>0.75)
	{
		$bts = $db->sqlr("SELECT uid FROM users WHERE level=".($player->pers["level"])." and block<>'' and rank_i>5 and silence = 0 and lb_attack<".tme()." and s6=1 and s5=1 LIMIT 0,1");
		if($bts)
	 		echo "<a href=main.php?gopers=battle class=wbut>В бой!</a>";
	}
	if(mtrunc($player->pers["free_f_skills"]+$player->pers["free_m_skills"]) and !$player->pers["free_stats"])
	{
		echo "<center class=but><b class=red><a class=timef href=main.php?gopers=um>Распределите</a> очки умений, доступные для повышения!</b></center>";
	}
	if($player->pers["tour"])
	{
		echo "<center class=but><b class=red>Вы в турнире!</b></center>";
	}
	
	if($_NG)
	{
		echo "<center class=but><b class=green><img src='images/gameplay/1_1.png'>Новогодние скидки(-50%)</b><hr> Новогодние скидки на БР действуют до 15ого января, спешите!</center>";
	}
	
	
	//echo "<center class=but><b class=green>Новости</b><hr> Игра не работала 24-25 января, потому что была атака на сервер. В данный момент атаки нет, и игра работает в предыдущем режиме. Всем недолговечным вещам была добавлена долговечность, поэтому ваша рыба и ресуры и не пропадут. Так же продлён реферальный конкурс ещё на 2 дня. <b>С уважением, Администрация.</b></center>";
	$kindness_class = "dark";
	if($player->pers["kindness"]>0) $kindness_class = "green";
	else $kindness_class = "hp";
	echo "<center class=dark><b>Мораль:</b> <b class=".$kindness_class.">".kind_stat($player->pers["kindness"])."</b></center>";
	if (($duration=($player->pers["punishment"]-tme()))>0) echo "<b>На вас наложена кара смотрителя!</b><font class=timef>ещё ".tp($duration)."</font>(Опыт -50%)<br>";
	if ($GOOD_DAY&GD_HUMANHEAL)
	 echo "<center><b class=green>Хороший день.</b> Сегодня, после боев с людьми, ваш персонаж будет мгновенно излечиваться от травм.</center>";

		$all_weight = $db->sqla("SELECT SUM(weight) as w,COUNT(*) as c FROM `wp` WHERE uidp=".$player->pers["uid"]." AND in_bank=0");
		$all_wp = $all_weight["c"];
		$all_weight = $all_weight["w"];
		if (intval($all_weight)<>$player->pers["weight_of_w"])
			set_vars("weight_of_w=".intval($all_weight),UID);
		$player->pers["weight_of_w"] = intval($all_weight);
		if (abs(10+($player->pers["sm3"]+$player->pers["s4"])*10) < ($all_weight))
			echo " <center class=but><font class=hp>Вы перегружены!</font></center>";
###
	if ( $player->pers['level'] >= 5 )
	{
		$verif = (int)$db->sqlr('SELECT `date` FROM `watch_verification` WHERE `uid`='.UID.' and `date`>'.(tme()-432000).' LIMIT 1');
		if ( $verif )
			echo '<center class="but"><b class="green">Вы чисты перед законом, ещё '.tp(($verif+432000)-tme()).'!</b></center>';
	}
###
###			
//if ($player->pers["coins"]) echo "<center><table style='width: 90%' class=but> <tr> <td style='height: 58px; width: 40px; text-align: center; background-image: url(\"images/pgs.gif\")'><b>".$player->pers["coins"]."</b></td> <td class=items>Количество ваших пергаментов, полученных за проведение отличных боёв.<br /><i>Они могут вам понадобиться в университете.</i></td></tr></table></center>";
###
if ($player->pers["exp"]>1050)echo "<br><hr><div style='text-align: left; width:70%'><b class=ma>Приводи друзей в игру и зарабатывай по <b color=#00CC00 class=bnick>10LN и 1 Пергамент</b> за каждого!</b>[<a href=main.php?gopers=ref class=timef>Подробнее...</a>] <br></div>";
//if (!$player->pers["second_pass"] and $player->pers["level"]>1) echo "<br><div class=weapons_box align=center><i>Безопасность:</i><br>У вас не установлен второй пароль! Чтобы прочитать зачем он нужен, и установить его зайдите в раздел \"Пароль\"</div>";
//if (substr_count($player->pers["aura"],"doctor")>0) include('inc/inc/characters/doctor.php');
if( $http->_get("deny") )
{
	$pupil = $db->sqla("SELECT * FROM users WHERE uid = ".$player->pers["instructor"]);
	$db->sql("UPDATE users SET instructor=0 WHERE uid = ".$player->pers["uid"]);
	say_to_chat ('n',"Персонаж <b>".$player->pers["user"]."</b>[".$player->pers["level"]."] отказался от обучения.",1,$pupil["user"],'*',0);
	$player->pers["instructor"] = 0;
}
if($player->pers["level"]<5 and $player->pers["instructor"])
{
	$pupil = $db->sqla("SELECT * FROM users WHERE uid = ".$player->pers["instructor"]);
	if($pupil)
	{
		echo "<br><center>";
		echo "<center style='width:90%' class=combofight>";
		echo "<i class=gray>";
		echo "Вы обучаетесь у персонажа <b class=hp>[".$pupil["level"]."] уровня</b>";
		echo "</i>";
		echo "<div class=but><b class=user>".$pupil["user"]."</b> <b class=lvl>[".$pupil["level"]."]</b> <img src=images/i.gif onclick=\"javascript:window.open('info.php?p=".$pupil["user"]."','_blank')\" style='cursor:pointer' height=16> <input type=button class=login value='Отказаться от обучения' onclick=\"location = 'main.php?deny=1'\"></div>";
		echo "</center>";
		echo "</center>";
	}
}
?>