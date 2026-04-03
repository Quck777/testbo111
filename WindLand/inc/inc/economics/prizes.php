<?php


// Снежинки - хуячинье на НГ))
if (isset($_POST["prikol"]) and isset($_POST["fornickname"])) // юзанье снежка
{
$vgg = sqla("SELECT `id`,`index`,`type` FROM `wp` WHERE `id`='".intval($_POST["prikol"])."' and durability>0"); // есть ли снежок в рюкзаке

$perstos = sqla ("SELECT uid,user,location,x,y,chp FROM `users` WHERE `user` = '".$_POST["fornickname"]."'"); // проверка на локу, координаты перса

if (isset($_POST["prikol"])/* and $pers["loc"]==$persto["loc"] and $pers["x"]==$persto["x"] and $pers["y"]==$persto["y"]*/) // юзанье

$snejok = rand(1,3);   // рендом ниже


if ($snejok=='1')
	{
sql("UPDATE users SET chp=chp-10 WHERE uid=".$perstos["uid"]."");
say_to_chat ('Информация','Хитрый <b>'.$pers["user"].'</b> бросил(а) размякший апельсин в  <b>'.$perstos["user"].'</b>, точно попав в глаз.<font class=red> ХП - 10 .</font>',0,'','*',0);
sql("UPDATE wp SET durability=durability-1 WHERE id=".$vgg["id"]."");
    }
	else
if ($snejok=='2')
	{
sql("UPDATE users SET chp=chp-6 WHERE uid=".$perstos["uid"]."");
say_say_to_chatall ('Информация','<b>'.$pers["user"].'</b> метко пульнул(а) полугнилой апельсин в застывшего <b>'.$perstos["user"].'</b> <font class=red> ХП - 6.</font>',0,'','*',0);
sql("UPDATE wp SET durability=durability-1 WHERE id=".$vgg["id"]."");
    }
	else
if ($snejok=='3')
	{
sql("UPDATE users SET chp=chp-7 WHERE uid=".$perstos["uid"]."");
say_to_chat ('Информация','Ловкий <b>'.$pers["user"].'</b> запустил(а) коркой апельсина в  <b>'.$perstos["user"].'</b> <font class=red> ХП - 7.</font>',0,'','*',0);
sql("UPDATE wp SET durability=durability-1 WHERE id=".$vgg["id"]."");
    }
	else
	$message = '<strong>Нет такого персонажа<b>('.$_POST["fornickname"].')</b> в данном месте</strong>';

unset($vgg);
unset($perstos);
}

?>


