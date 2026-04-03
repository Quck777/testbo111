<?php

if ($http->post["add_image"] == 1 and $player->pers["dmoney"]>=10)
{

	    switch ($http->post["type_name"])
		{
        case 'noji':
        $newwidth = 62;
        $newheight = 91;
        break;
        case 'mech':
        $newwidth = 62;
        $newheight = 91;
        break;
        case 'drob':
        $newwidth = 62;
        $newheight = 91 ;
        break;
        case 'topo':
        $newwidth = 62;
        $newheight = 91;
        break;
        case 'shit':
        $newwidth = 62;
        $newheight = 91;
        break;
        case 'shle':
        $newwidth = 62;
        $newheight = 65;
        break;
        case 'kolchuga':
        $newwidth = 62;
        $newheight = 90;
        break;
        case 'bron':
        $newwidth = 62;
        $newheight = 90;
        break;
        case 'naru':
        $newwidth = 62;
        $newheight = 40;
        break;
        case 'perc':
        $newwidth = 62;
        $newheight = 40;
        break;
        case 'poya':
        $newwidth = 60;
        $newheight = 30;
        break;
        case 'sapo':
        $newwidth = 62;
        $newheight = 60;
        break;
        case 'kolc':
        $newwidth = 31;
        $newheight = 31;
        break;
        case 'kylo':
        $newwidth = 62;
        $newheight = 35;
        break;
        }

        if ($newwidth>0 and $newheight>0)
		{
			/*
			if ($_FILES['image']['type']=='image/gif')
			{
				$im = @imagecreatefromgif ($_FILES['image']['tmp_name']);
				if ($im)
				{
					$filename = $_FILES['image']['tmp_name'];
					list($width, $height) = getimagesize($filename);
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagegif($thumb,"images/weapons/test/".$player->pers["uid"]."_".date("H:i:s", tme()).".gif");
					$db->sql("INSERT INTO `images` (`address`,`type`,`width`,`height`,`lavka`,`uid`,`tip`) VALUES ('test/".$player->pers["uid"]."_".date("H:i:s", tme()).".gif','1','".$newwidth."','".$newheight."','test','".$player->pers["uid"]."','".$http->post["type_name"]."');");
					set_vars("dmoney=dmoney-10",$player->pers["uid"]);
					$req = 1;
				}
			}
			if (eregi('image/?jpeg',$_FILES['image']['type']))
			{
				$im = @imagecreatefromjpeg ($_FILES['image']['tmp_name']);
				if ($im)
				{
					$filename = $_FILES['image']['tmp_name'];
					list($width, $height) = getimagesize($filename);
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagegif($thumb,"images/weapons/test/".$player->pers["uid"]."_".date("H:i:s", tme()).".gif");
					$db->sql("INSERT INTO `images` (`address`,`type`,`width`,`height`,`lavka`,`uid`,`tip`) VALUES ('test/".$player->pers["uid"]."_".date("H:i:s", tme()).".gif','1','".$newwidth."','".$newheight."','test','".$player->pers["uid"]."','".$http->post["type_name"]."');");
					set_vars("dmoney=dmoney-10",$player->pers["uid"]);
					$req = 1;
				}
			}
			*/

			$imageinfo = getimagesize($_FILES["image"]["tmp_name"]);
			if( $imageinfo["mime"] == "image/gif" or $imageinfo["mime"] == "image/jpeg" )
			{
				list($width, $height) = $imageinfo;

				if ( ($width == $newwidth and $height == $newheight) or UID == 7 )
				{
					if ( move_uploaded_file($_FILES['image']['tmp_name'],IMG_ROOT."/weapons/individual/".$player->pers["uid"]."_".date("H-i-s", tme()).".gif") )
					{
						$db->sql("INSERT INTO `images` (`address`,`type`,`width`,`height`,`lavka`,`uid`,`tip`) VALUES ('individual/".$player->pers["uid"]."_".date("H-i-s", tme()).".gif','1','".$newwidth."','".$newheight."','test','".$player->pers["uid"]."','".$http->post["type_name"]."');");
						set_vars("dmoney=dmoney-10",$player->pers["uid"]);
						echo 'Рисунок загружен <a href=?s=image>НАЗАД</a>.';
					} else echo 'Ошибка загрузки.';
				} else echo 'Неверный размер изображения. Требуемый формат '.$newwidth.'х'.$newheight.'.';
			} else echo 'Неверный формат изображения. Принимаются только изображения .gif и .jpeg';
		} else echo "Ошибка <a href=?s=image>НАЗАД</a>";

}

if ($http->get["s"] == 'image'){

echo '
<table cellpadding="4" cellspacing="0" border="0" align="center" width="100%">
<tr>
<td align="center" class="nickname" colspan="5">
<form method="POST" action="?" enctype="multipart/form-data">
<input type="hidden" name="add_image" value="1">
<select name="type_name" class="dd">
<option value="0">Категория</option>
<option value="noji">Нож</option>
<option value="mech">Меч</option>
<option value="drob">Дробящее</option>
<option value="topo">Топор</option>
<option value="shit">Щит</option>
<option value="shle">Шлем</option>
<option value="kolchuga">Кольчуга</option>
<option value="bron">Броня</option>
<option value="naru">Наручи</option>
<option value="perc">Перчатки</option>
<option value="poya">Пояс</option>
<option value="sapo">Сапоги</option>
<option value="kolc">Кольцо</option>
<option value="kylo">Кулон</option>
</select>
Изображение* <input type="file" name="image" class="dd">
<br /><br />
<input type="submit" value="Загрузить" class="dd">
<br /><b><img src="http://'.IMG.'/signs/diler.gif" align="absmiddle" alt="$"> 10 BR</b>
</form>
</td>
</tr>
<tr>
<td class="freetxt" colspan="5">
* Тип файлов: <b>GIF</b>. Размер файла: до <b>12</b> КБ.<br>
** Администрация не несет ответственности за содержимое изображений. При жалобах со стороны правообладателей или нарушении авторских прав, изображение может быть удалено с сервера.
</td>
</tr>
</table>

</div>
</td>
</tr>
</table>

</td></tr>
</table>
';

    $sql = $db->sql("SELECT * FROM `images` WHERE `uid`='".$player->pers["uid"]."'");
	$demos = '<table border="0" cellspacing="1" cellpadding="10" width="100%" align="center"><tr>';
	$igg = 0;
	while($s = $db->fetchArray($sql,MYSQL_ASSOC)){
	$igg ++;
	if (($igg+1)%4==0 and $igg!=0) $demos .=  '<tr>';
	$demos .= '<td align="center" width="20%"><img src="http://woe.by/images/weapons/'.$s["address"].'">';
	$demos .= '</td>';
	}
	$demos .= '</tr></table>';


	echo "Ваши загруженные рисунки :".$demos;
}

if ($http->get["base"] == 'information'){

echo '

<div style="text-align:center">
<div class="freemain" style="color:#3564A5">
<a href="?s=image">Индивидуальные изображения для Артефактов</a><br /><br />
<a href="?s=ind">Индивидуальный артефакт</a><br /><br />
<a href="?c=indap">Улучшение существующего артефакта</a><br /><br />
</div>
</div>
';

}else
if ($http->get["s"] == 'ind')
{
?>


<div style="text-align:center">
<div align="center"><font class="freemain"><b>Калькулятор индивидуальных артефактов</b></font></div>
<br><br>
<font class="freetxt">Этот калькулятор поможет Вам быстро подсчитать стоимость артефакта с нужными характеристиками. Существуют следущие классы артефактов: <b><font color="#00a610">WARRIOR</font></b> (артефакты для воина) и <b><font color="#de2f00">MAGICIAN</font></b> (артефакты для мага).<br><br></font>
<div align="center"><font class="freetxt"><b><font class="freemain">Шаг 1.</font></b> Для создания артефакта требуется выбрать класс и нажать кнопку "Продолжить". Если Вам требуется улучшить существующий артефакт, нажмите кнопку "Улучшение существующего артефакта" (только для артефактов, созданных в Доме Дилеров с помощью калькулятора).</font></div><br />
<font class="freemain"><b>
<a href="?class=war"><strong><font color="#00a610">WARRIOR</font></strong></a>&nbsp;
<a href="?class=mag"><strong><font color="#de2f00">MAGICIAN</font></strong></a>
</b></font>
<br /><br />
<a href="/?"><b class="freemain" style="color:#3564A5">Назад</b></a>

</div>


<?php
##  ШАГ №2 , ВЫБОР ТИПА ПРЕДМЕТА
}
elseif ($http->get["class"] == 'war')
{
echo '<br>
<form method="POST" action="?c=ind&class=warr">
<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1">
<tr>
<td align="center" class=user width="100%" colspan="2">Мастер сборки
индивидуальных артефактов</td>
</tr>
<tr>
<td bgcolor="#F0F0F0" class=ma align="center" width="100%" colspan="2">
Пожалуйста, выберите предполагаемый класс артефакта и
тип.</td>
</tr>
<tr>
<td bgcolor="#F0F0F0" align="right" width="50%">
<select size="1" name="type" class="return_win" style="width:200">
<option value="noji">Нож</option>
<option value="mech">Меч</option>
<option value="drob">Дробящее</option>
<option value="topo">Топор</option>
<option value="shit">Щит</option>
<option value="shle">Шлем</option>
<option value="kolchuga">Кольчуга</option>
<option value="bron">Броня</option>
<option value="naru">Наручи</option>
<option value="perc">Перчатки</option>
<option value="poya">Пояс</option>
<option value="sapo">Сапоги</option>
<option value="kolc">Кольцо</option>
<option value="kylo">Кулон</option>
</select></td>
<td bgcolor="#F0F0F0" width="50%">
<input type="submit" value=" Ок " class="login" style="width:100%"></td></tr>
</table>
</form>';
##  ШАГ №2 , ВЫБОР ТИПА ПРЕДМЕТА MAG
}
elseif ($http->get["class"] == 'mag')
{

echo '<br>
<form method="POST" action="?c=ind&class=maga">
<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1">
<tr>
<td align="center" class=user width="100%" colspan="2">Мастер сборки
индивидуальных артефактов</td>
</tr>
<tr>
<td bgcolor="#F0F0F0" class=ma align="center" width="100%" colspan="2">
Пожалуйста, выберите предполагаемый класс артефакта и
тип.</td>
</tr>
<tr>
<td bgcolor="#F0F0F0" align="right" width="50%">
<select size="1" name="type" class="return_win" style="width:200">
<option value="noji">Нож</option>
<option value="shle">Шлем</option>
<option value="kolchuga">Кольчуга</option>
<option value="bron">Броня</option>
<option value="naru">Наручи</option>
<option value="perc">Перчатки</option>
<option value="poya">Пояс</option>
<option value="sapo">Сапоги</option>
<option value="kolc">Кольцо</option>
<option value="kylo">Кулон</option>
</select></td>
<td bgcolor="#F0F0F0" width="50%">
<input type="submit" value=" Ок " class="login" style="width:100%"></td></tr>
</table>
</form>';
}


//if (!empty($http->get["buy"])){}

############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################

 elseif ($http->get["class"] == 'maga') {


	    switch ($http->post["type"]){
        case 'noji':
        $newwidth = 62;
        $newheight = 91;
        $name_typ = 'Нож';
        break;
        case 'shle':
        $newwidth = 62;
        $newheight = 65;
        $name_typ = 'Шлем';
        break;
        case 'kolchuga':
        $newwidth = 62;
        $newheight = 90;
        $name_typ = 'Кольчуга';
        break;
        case 'bron':
        $newwidth = 62;
        $newheight = 90;
        $name_typ = 'Броня';
        break;
        case 'naru':
        $newwidth = 62;
        $newheight = 40;
        $name_typ = 'Наручи';
        break;
        case 'perc':
        $newwidth = 62;
        $newheight = 40;
        $name_typ = 'Перчатки';
        break;
        case 'poya':
        $newwidth = 60;
        $newheight = 30;
        $name_typ = 'Пояс';
        break;
        case 'sapo':
        $newwidth = 62;
        $newheight = 60;
        $name_typ = 'Сапоги';
        break;
        case 'kolc':
        $newwidth = 31;
        $newheight = 31;
        $name_typ = 'Кольцо';
        break;
        case 'kylo':
        $newwidth = 62;
        $newheight = 35;
        $name_typ = 'Кулон';
        break;
        }


       ## new
    $http->get["type"] = 1;
    if (!$newheight) exit("Ошибка");
	$sql = $db->sql("SELECT `uid`,`address` FROM images WHERE `lavka`='test' and `type`=".intval($http->get["type"])." and `tip`='".$http->post["type"]."'");
	$demos = '<table align=center border=0 width=100% class="coll w100 mar user_info">';
	$im = 0;
	while($s = $db->fetchArray($sql,MYSQL_ASSOC))
	{
		$im ++;
		## Если  рисунок имеет айди перса, а айди перса != рисунку, убираем)
		if ($s["uid"]>0 and $s["uid"]!=$player->pers["uid"]) continue;
		if (($im+1)%4==0 and $im!=0) $demos .=  '<tr>';
		$demos .= '<td align="center" width="20%"><img src="http://'.IMG.'/weapons/'.$s["address"].'">';
		$demos .= '<br><input type="radio" name="imgdd" value='.$s["address"].'></td>';
	}
	$demos .= '</table>';
     ## new end
	$class = 1;
         ## МФ и ПРОБОЙ БРОНИ РАСЧЕТ.
        if ($http->post["type"] == 'noji'){  $basik = 10; $basikz = 10; $hpp=0;$stt = 10;}
        //if ($http->post["type"] == 'book'){  $basik = 12; $basikz = 10; $hpp=0;$stt = 10;}
        if ($http->post["type"] == 'shle'){$basik = 18; $basikz = 0; $hpp=30;$stt = 12;}
        if ($http->post["type"] == 'kolchuga'){$basik = 13; $basikz = 0; $hpp=25;$stt = 8;}
        if ($http->post["type"] == 'bron'){  $basik = 20; $basikz = 0; $hpp=30; $stt = 15;} //15
        if ($http->post["type"] == 'naru'){  $basik = 15; $basikz = 8; $hpp=25; $stt = 12;}
        if ($http->post["type"] == 'perc'){  $basik = 13; $basikz = 7; $hpp=23; $stt = 12;}
        if ($http->post["type"] == 'poya'){  $basik = 15; $basikz = 0; $hpp=18; $stt = 12;}
        if ($http->post["type"] == 'sapo'){  $basik = 17; $basikz = 6; $hpp=25; $stt = 10;}
        if ($http->post["type"] == 'kolc'){  $basik = 10; $basikz = 5; $hpp=13; $stt = 9;} //99
        if ($http->post["type"] == 'kylo'){  $basik = 10; $basikz = 0; $hpp=30; $stt = 12;}


	## Статы
	$stats = '';
	for ($i=0;$i<=$stt;$i++)
	{
	$st = $i;
	$stats .= '<option value='.$st.'>+'.$st.'</option>';
	}


	$hm = '';
	## ХП ДЛЯ ВОИНА
	if ($http->post["type"]<>"noji" and $http->post["type"]<>"book")
	{
		$hm .='<td class="hp" width="244">HP</td>';
		$hm .= '<td width="25%" align="center">  ';
		$hm .= '<select size="1" name="hp" class="real">';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$hpp;
		 $hm .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$hm .= '</select></td>';
    }



    ## МАНА ДЛЯ МАГА
	if ($http->post["type"]<>"noji"  and $http->post["type"]<>"book")
	{
		$mm .='<td class="ma" width="244">MA</td>';
		$mm .= '<td width="25%" align="center">  ';
		$mm .= '<select size="1" name="ma" class="real">';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$hpp;
		 $mm .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$mm .= '</select></td>';
    }

		## СОКРУШЕНИЕ
		$mf1 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf1 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## УЛОВКА
		$mf2 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf2 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## ТОЧНОСТЬ
		$mf3 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf3 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## СТОЙКОСТЬ
		$mf4 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf4 .= '<option value='.$st.'>+'.$st.'</option>';
		}

		$proff = '';
		for ($i=0;$i<=10;$i++)
		{
		 $pra = $i*10;
		 $proff .= '<option value='.$pra.'>+'.$pra.'</option>';
		}
		## ПРОБОЙ БРОНИ
		$mf5 = '';

	if ($http->post["type"]<>'kylo' and $http->post["type"]<>'shle' and $http->post["type"]<>'poya' and $http->post["type"]<>'bron' and $http->post["type"]<>'kolchuga'){
		$mf5 .= '<td width="25%">Пробой брони</td>';
		$mf5 .= '<td width="25%" align="center"><select size="1" name="mf5" class="real">';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basikz;
		 $mf5 .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$mf5 .= '</select></td>';
     }
		## ARMOR
 $kb = '';
## БРОНЯ
if ($http->post["type"] == 'bron'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="5">5</option>';
$kb .= '<option value="10">10</option>';
$kb .= '<option value="15">15</option>';
$kb .= '<option value="20">20</option>';
$kb .= '<option value="25">25</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="65">65</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
}
## КОЛЬЧУГА / НАРУЧИ / ПЕРЧАТКИ / ШЛЕМ
if ($http->post["type"] == 'kolchuga' or $http->post["type"] == 'naru' or $http->post["type"] == 'perc' or $http->post["type"] == 'shle'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="20">20</option>';
$kb .= '<option value="25">25</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="65">65</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
$kb .= '<option value="95">95</option>';
$kb .= '<option value="100">100</option>';
}
## ПОЯС
if ($http->post["type"] == 'poya'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="5">5</option>';
$kb .= '<option value="10">10</option>';
$kb .= '<option value="15">15</option>';
$kb .= '<option value="20">20</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
}
## САПОГИ
if ($http->post["type"] == 'sapo'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="20">20</option>';
$kb .= '<option value="25">25</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="65">65</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
$kb .= '<option value="100">100</option>';
$kb .= '<option value="105">105</option>';
$kb .= '<option value="110">110</option>';

}
## КОЛЬЦА / КУЛОНЫ
if ($http->post["type"] == 'kolc' or $http->post["type"] == 'kylo'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="5">5</option>';
$kb .= '<option value="10">10</option>';
$kb .= '<option value="15">15</option>';
$kb .= '<option value="20">20</option>';
$kb .= '<option value="25">25</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
}
        ## ЕСЛИ ЭТО, НЕ ОРУЖИЕ.
		if ($http->post["type"]<>"noji" and $http->post["type"]<>"book")
		{
		$ydar = '';
		## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop = '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="real">'.$kb.'
		</select></td>
		<td width="25%"></td>
		<td width="25%" align="center">
		</td>
	    </tr>';
		}else{

		## УДАР МИНИМУМ
		$ydar = '';
		    #### ЕСЛИ ЛЮБОЕ ОРУЖИЕ КРОМЕ НОЖА И КНИГИ.
			if ($http->post["type"]<>"noji" and $http->post["type"]<>"book"){
			$ydar .= '<option value="0-0">0</option>';
			$ydar .= '<option value="30-50">30-50</option>';
			$ydar .= '<option value="33-53">33-53</option>';
			$ydar .= '<option value="36-56">36-56</option>';
			$ydar .= '<option value="39-59">39-59</option>';
			$ydar .= '<option value="42-62">42-62</option>';
			$ydar .= '<option value="45-65">45-65</option>';
			$ydar .= '<option value="48-68">48-68</option>';
			$ydar .= '<option value="51-71">51-71</option>';
			$ydar .= '<option value="54-74">54-74</option>';
			$ydar .= '<option value="57-77">57-77</option>';
			$ydar .= '<option value="60-80">60-80</option>';
			$ydar .= '<option value="63-83">63-83</option>';
			$ydar .= '<option value="66-85">66-85</option>';
			$ydar .= '<option value="69-88">69-88</option>';
			$ydar .= '<option value="70-90">70-90</option>';
			$ydar .= '<option value="72-92">72-92</option>';
			$ydar .= '<option value="74-95">74-95</option>';
			$ydar .= '<option value="76-98">76-98</option>';
			$ydar .= '<option value="78-101">78-101</option>';
			$ydar .= '<option value="80-104">80-104</option>';
			$ydar .= '<option value="82-107">82-107</option>';
			$ydar .= '<option value="84-110">84-110</option>';
			$ydar .= '<option value="86-113">86-113</option>';
			$ydar .= '<option value="88-116">88-116</option>';
			$ydar .= '<option value="90-119">90-119</option>';
			$ydar .= '<option value="95-125">95-125</option>';
			$ydar .= '<option value="100-135">100-135</option>';
			$ydar .= '<option value="105-145">105-145</option>';
			$ydar .= '<option value="110-155">110-155</option>';
			$ydar .= '<option value="115-165">115-165</option>';
			$ydar .= '<option value="120-170">120-170</option>';
			}else{

            ## ЭТО НОЖ ИЛИ КНИГА
         $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="10-30">10-30</option>';
		 $ydar .= '<option value="12-32">12-32</option>';
		 $ydar .= '<option value="20-35">20-35</option>';
		 $ydar .= '<option value="14-34">14-34</option>';
		 $ydar .= '<option value="16-36">16-36</option>';
		 $ydar .= '<option value="22-36">22-36</option>';
		 $ydar .= '<option value="18-38">18-38</option>';
		 $ydar .= '<option value="24-37">24-37</option>';
		 $ydar .= '<option value="26-38">26-38</option>';
		 $ydar .= '<option value="28-39">28-39</option>';
		 $ydar .= '<option value="30-40">30-40</option>';
		 }

		$dop = '<tr>
		<td width="25%">Урон</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="real">'.$ydar.'</select></td>
		</tr>';
		}
		echo '<br><form method="POST" action="?c=ind">
        <table border=0 width="100%" cellspacing="0" cellspadding=0 class=LinedTable>
	<tr>
		<td align="center" class=user width="100%">Калькулятор индивидуальных артефактов</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class=ma align="center" width="100%">Шаг 3. Выбор параметров для артефакта ('.$name_typ.'). Класс артефакта: MAG</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" align="right" width="100%" class="ma">
<table border="1" width="100%" cellspacing="0"  bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0">
	<tr>
		<td width="244">Сила</td>
		<td width="25%" align="center"><select size="1" name="s1" class="real">'.$stats.'
		</select></td>
		<td width="25%">Сокрушение</td>
		<td width="25%" align="center"><select size="1" name="mf1" class="real">'.$mf1.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Реакция</td>
		<td width="25%" align="center"><select size="1" name="s2" class="real">'.$stats.'
		</select></td>
		<td width="25%">Уловка</td>
		<td width="25%" align="center"><select size="1" name="mf2" class="real">'.$mf2.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Удача</td>
		<td width="25%" align="center"><select size="1" name="s3" class="real">'.$stats.'
		</select></td>
		<td width="25%">Точность</td>
		<td width="25%" align="center"><select size="1" name="mf3" class="real">'.$mf3.'</select></td>
	</tr>

	<tr>
		<td width="244">Интеллект</td>
		<td width="25%" align="center"><select size="1" name="s5" class="real">'.$stats.'
		</select></td>
		<td width="25%"></td>
		<td width="25%" align="center"></td>
	</tr>

	<tr>
		<td width="244">Сила воли</td>
		<td width="25%" align="center"><select size="1" name="s6" class="real">'.$stats.'</select></td>
		<td width="25%">Стойкость</td>
		<td width="25%" align="center"><select size="1" name="mf4" class="real">'.$mf4.'</select></td>
	</tr>
	<tr>
		<td width="244"></td>
		<td width="25%" align="center"></td>
          '.$mf5.'

	</tr>
	<tr>
	 '.$hm.'
     '.$mm.'

	</tr>
    '.$dop.'


	<tr>
		<td width="244">Охотник</td>
		<td width="25%" align="center"><select size="1" name="sp10" class="real">'.$proff.'</select></td>
		<td width="25%">Рыбалка</td>
		<td width="25%" align="center"><select size="1" name="sp6" class="real">'.$proff.'</select></td>
	</tr>
	<tr>
		<td width="244">Орентирование</td>
		<td width="25%" align="center"><select size="1" name="sp8" class="real">'.$proff.'</select></td>
		<td width="25%">Алхимик</td>
		<td width="25%" align="center"><select size="1" name="sp11" class="real">'.$proff.'</select></td>
	</tr>



	<tr>
		<td class="ma" colspan="4" align="center">Название <input name="name" size="27" class="laar"></td>
	</tr>
     '.$demos.'
	<tr>
		<td class="ma" colspan="4" align="center">
		<input type="hidden" value="mag" name=class>
		<input type="hidden" value="'.$http->post["type"].'" name=type>
		<input style="width:150px;height:20px;" type="button" value="Назад" class="inv_but" onclick="location=\'?c=ind\'"> |
		<input style="width:150px;height:20px;" type="reset" value="Сброс" class="inv_but"> |
		<input style="width:150px;height:20px;" type="submit" value="Готово" class="inv_but"></td>
	</tr>


</table>
		</td>
	</tr>
</table>
</form>';


 }



############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################
############################################################################################################################




	## Шаг № 3 , ВЫБОР СТАТОВ
	elseif ($http->get["class"] == 'warr')
	{

	    switch ($http->post["type"]){
        case 'noji':
        $newwidth = 62;
        $newheight = 91;
        $name_typ = 'Нож';
        break;
        case 'mech':
        $newwidth = 62;
        $newheight = 91;
        $name_typ = 'Меч';
        break;
        case 'drob':
        $newwidth = 62;
        $newheight = 91 ;
        $name_typ = 'Дробящее';
        break;
        case 'topo':
        $newwidth = 62;
        $newheight = 91;
        $name_typ = 'Топор';
        break;
        case 'shit':
        $newwidth = 62;
        $newheight = 91;
        $name_typ = 'Щит';
        break;
        case 'shle':
        $newwidth = 62;
        $newheight = 65;
        $name_typ = 'Шлем';
        break;
        case 'kolchuga':
        $newwidth = 62;
        $newheight = 90;
        $name_typ = 'Кольчуга';
        break;
        case 'bron':
        $newwidth = 62;
        $newheight = 90;
        $name_typ = 'Броня';
        break;
        case 'naru':
        $newwidth = 62;
        $newheight = 40;
        $name_typ = 'Наручи';
        break;
        case 'perc':
        $newwidth = 62;
        $newheight = 40;
        $name_typ = 'Перчатки';
        break;
        case 'poya':
        $newwidth = 60;
        $newheight = 30;
        $name_typ = 'Пояс';
        break;
        case 'sapo':
        $newwidth = 62;
        $newheight = 60;
        $name_typ = 'Сапоги';
        break;
        case 'kolc':
        $newwidth = 31;
        $newheight = 31;
        $name_typ = 'Кольцо';
        break;
        case 'kylo':
        $newwidth = 62;
        $newheight = 35;
        $name_typ = 'Кулон';
        break;
        }
        ## new
    $http->get["type"] = 1;
    if (!$newheight) exit("Ошибка");
	$sql = $db->sql("SELECT `uid`,`address` FROM images WHERE `lavka`='test' and `type`=".intval($http->get["type"])." and `tip`='".$http->post["type"]."'");
	$demos = '<table align=center border=0 width=100% class="coll w100 mar user_info">';
	$im = 0;
	while($s = $db->fetchArray($sql,MYSQL_ASSOC)){
	$im ++;
	## Если  рисунок имеет айди перса, а айди перса != рисунку, убираем)
	if ($s["uid"]>0 and $s["uid"]!=$player->pers["uid"]) continue;
    if (($im+1)%4==0 and $im!=0) $demos .=  '<tr>';
	$demos .= '<td align="center" width="20%"><img src="http://'.IMG.'/weapons/'.$s["address"].'">';
	$demos .= '<br><input type="radio" name="imgdd" value='.$s["address"].'></td>';
	}
	$demos .= '</table>';
     ## new end
	$class = 1;
         ## МФ и ПРОБОЙ БРОНИ РАСЧЕТ.
        if ($http->post["type"] == 'noji'){  $basik = 10; $basikz = 10; $hpp=0;$stt = 10;}
        if ($http->post["type"] == 'mech'){  $basik = 12; $basikz = 10; $hpp=0;$stt = 10;}
        if ($http->post["type"] == 'drob'){  $basik = 13; $basikz = 10; $hpp=0;$stt = 10;} // 10
        if ($http->post["type"] == 'topo'){  $basik = 10; $basikz = 10; $hpp=0;$stt = 10;} // 15
        if ($http->post["type"] == 'shit'){  $basik = 25; $basikz = 10; $hpp=35;$stt = 18;}
        if ($http->post["type"] == 'shle'){$basik = 18; $basikz = 0; $hpp=30;$stt = 12;}
        if ($http->post["type"] == 'kolchuga'){$basik = 13; $basikz = 0; $hpp=25;$stt = 8;}
        if ($http->post["type"] == 'bron'){  $basik = 20; $basikz = 0; $hpp=30; $stt = 15;} //15
        if ($http->post["type"] == 'naru'){  $basik = 15; $basikz = 8; $hpp=25; $stt = 12;}
        if ($http->post["type"] == 'perc'){  $basik = 13; $basikz = 7; $hpp=23; $stt = 12;}
        if ($http->post["type"] == 'poya'){  $basik = 15; $basikz = 0; $hpp=18; $stt = 12;}
        if ($http->post["type"] == 'sapo'){  $basik = 17; $basikz = 6; $hpp=25; $stt = 10;}
        if ($http->post["type"] == 'kolc'){  $basik = 10; $basikz = 5; $hpp=13; $stt = 9;} //99
        if ($http->post["type"] == 'kylo'){  $basik = 10; $basikz = 0; $hpp=30; $stt = 12;}



    $sm3 = '<option value=0>Выберите</option>';
    $sm6 = '<option value=0>Выберите</option>';
    $sm7 = '<option value=0>Выберите</option>';

    $sm3 .= '<option value=10>+10</option>';
    $sm6 .= '<option value=10>+10</option>';
    $sm7 .= '<option value=10>+10</option>';


	## Статы
	$stats = '';
	for ($i=0;$i<=$stt;$i++)
	{
	$st = $i;
	$stats .= '<option value='.$st.'>+'.$st.'</option>';
	}


	$hm = '';
	## ХП ДЛЯ ВОИНА
	if ($http->post["type"]<>"noji" and $http->post["type"]<>"mech" and $http->post["type"]<>"topo" and $http->post["type"]<>"book" and $http->post["type"]<>"drob")
	{
		$hm .='<td class="hp" width="244">HP</td>';
		$hm .= '<td width="25%" align="center">  ';
		$hm .= '<select size="1" name="hp" class="real">';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$hpp;
		 $hm .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$hm .= '</select></td>';
    }



    ## МАНА ДЛЯ МАГА
	if ($http->get["class"]=="mag" and $http->post["type"]<>"noji" and $http->post["type"]<>"mech" and $http->post["type"]<>"topo" and $http->post["type"]<>"book" and $http->post["type"]<>"drob")
	{
		$mm .='<td class="ma" width="244">MA</td>';
		$mm .= '<td width="25%" align="center">  ';
		$mm .= '<select size="1" name="ma" class="real">';
		for ($i=0;$i<=30;$i++)
		{
		 $st = $i*10;
		 $mm .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$mm .= '</select></td>';
    }
		## СОКРУШЕНИЕ
		$mf1 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf1 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## УЛОВКА
		$mf2 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf2 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## ТОЧНОСТЬ
		$mf3 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf3 .= '<option value='.$st.'>+'.$st.'</option>';
		}
        ## СТОЙКОСТЬ
		$mf4 = '';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basik;
		 $mf4 .= '<option value='.$st.'>+'.$st.'</option>';
		}

		$proff = '';
		for ($i=0;$i<=10;$i++)
		{
		 $pra = $i*10;
		 $proff .= '<option value='.$pra.'>+'.$pra.'</option>';
		}
		## ПРОБОЙ БРОНИ
		$mf5 = '';

	if ($http->post["type"]<>'kylo' and $http->post["type"]<>'shle' and $http->post["type"]<>'poya' and $http->post["type"]<>'bron' and $http->post["type"]<>'kolchuga'){
		$mf5 .= '<td width="25%">Пробой брони</td>';
		$mf5 .= '<td width="25%" align="center"><select size="1" name="mf5" class="real">';
		for ($i=0;$i<=10;$i++)
		{
		 $st = $i*$basikz;
		 $mf5 .= '<option value='.$st.'>+'.$st.'</option>';
		}
		$mf5 .= '</select></td>';
     }




## ARMOR
$kb = '';
## ЩИТ
 if ($http->post["type"] == 'shit'){
 $kb .= '<option value=0 selected="selected">0</option>';
 $kb .= '<option value="35">35</option>';
 $kb .= '<option value="40">40</option>';
 $kb .= '<option value="45">45</option>';
 $kb .= '<option value="50">50</option>';
 $kb .= '<option value="55">55</option>';
 $kb .= '<option value="60">60</option>';
 $kb .= '<option value="70">70</option>';
 $kb .= '<option value="80">80</option>';
 $kb .= '<option value="90">90</option>';
 $kb .= '<option value="100">100</option>';
 $kb .= '<option value="110">110</option>';
 $kb .= '<option value="120">120</option>';
 $kb .= '<option value="130">130</option>';
 $kb .= '<option value="140">140</option>';
 $kb .= '<option value="150">150</option>';
 $kb .= '<option value="160">160</option>';
 $kb .= '<option value="170">170</option>';
 }
## БРОНЯ
if ($http->post["type"] == 'bron'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="65">65</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
$kb .= '<option value="95">95</option>';
$kb .= '<option value="100">100</option>';
$kb .= '<option value="110">110</option>';
$kb .= '<option value="120">120</option>';
$kb .= '<option value="130">130</option>';
$kb .= '<option value="140">140</option>';
$kb .= '<option value="150">150</option>';
$kb .= '<option value="160">160</option>';
$kb .= '<option value="170">170</option>';
$kb .= '<option value="180">180</option>';
$kb .= '<option value="190">190</option>';
$kb .= '<option value="200">200</option>';
$kb .= '<option value="210">210</option>';
$kb .= '<option value="220">220</option>';
$kb .= '<option value="230">230</option>';
$kb .= '<option value="240">240</option>';
$kb .= '<option value="250">250</option>';
$kb .= '<option value="260">260</option>';
$kb .= '<option value="270">270</option>';
$kb .= '<option value="280">280</option>';
$kb .= '<option value="290">290</option>';
$kb .= '<option value="300">300</option>';
}
## КОЛЬЧУГА / НАРУЧИ / ПЕРЧАТКИ / ШЛЕМ
if ($http->post["type"] == 'kolchuga' or $http->post["type"] == 'naru' or $http->post["type"] == 'perc' or $http->post["type"] == 'shle'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
$kb .= '<option value="95">95</option>';
$kb .= '<option value="100">100</option>';
$kb .= '<option value="105">105</option>';
$kb .= '<option value="110">110</option>';
$kb .= '<option value="115">115</option>';
$kb .= '<option value="120">120</option>';
}
## ПОЯС
if ($http->post["type"] == 'poya'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
}
## САПОГИ
if ($http->post["type"] == 'sapo'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="70">70</option>';
$kb .= '<option value="75">75</option>';
$kb .= '<option value="80">80</option>';
$kb .= '<option value="85">85</option>';
$kb .= '<option value="90">90</option>';
$kb .= '<option value="95">95</option>';
$kb .= '<option value="100">100</option>';
$kb .= '<option value="105">105</option>';
$kb .= '<option value="110">110</option>';
}
## КОЛЬЦА / КУЛОНЫ
if ($http->post["type"] == 'kolc' or $http->post["type"] == 'kylo'){
$kb .= '<option value=0 selected="selected">0</option>';
$kb .= '<option value="30">30</option>';
$kb .= '<option value="35">35</option>';
$kb .= '<option value="40">40</option>';
$kb .= '<option value="45">45</option>';
$kb .= '<option value="50">50</option>';
$kb .= '<option value="55">55</option>';
$kb .= '<option value="60">60</option>';
$kb .= '<option value="70">70</option>';
}
        ## ЕСЛИ ЭТО, НЕ ОРУЖИЕ.
		if ($http->post["type"]<>"shle" and $http->post["type"]<>"bron" and $http->post["type"]<>"poya" and $http->post["type"]<>"noji" and $http->post["type"]<>"mech" and $http->post["type"]<>"topo" and $http->post["type"]<>"book" and $http->post["type"]<>"drob")
		{
		 $ydar = '';



		 if ($http->post["type"] == 'kylo'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="5-10">5-10</option>';
		 $ydar .= '<option value="10-15">10-15</option>';
		 $ydar .= '<option value="15-20">15-20</option>';
		 $ydar .= '<option value="20-25">20-25</option>';
		 }else if ($http->post["type"] == 'sapo'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="7-11">7-11</option>';
		 $ydar .= '<option value="9-13">9-13</option>';
		 $ydar .= '<option value="11-15">11-15</option>';
		 $ydar .= '<option value="13-16">13-16</option>';
		 $ydar .= '<option value="15-17">15-17</option>';
		 $ydar .= '<option value="15-18">15-18</option>';
		 $ydar .= '<option value="16-20">16-20</option>';
		 $ydar .= '<option value="17-22">17-22</option>';
		 $ydar .= '<option value="18-24">18-24</option>';
		 $ydar .= '<option value="19-25">19-25</option>';
		 }else if ($http->post["type"] == 'naru'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="7-12">7-12</option>';
		 $ydar .= '<option value="9-14">9-14</option>';
		 $ydar .= '<option value="11-16">11-16</option>';
		 $ydar .= '<option value="13-18">13-18</option>';
		 $ydar .= '<option value="13-17">13-17</option>';
		 $ydar .= '<option value="15-20">15-20</option>';
		 $ydar .= '<option value="15-19">15-19</option>';
		 $ydar .= '<option value="17-21">17-21</option>';
		 $ydar .= '<option value="19-23">19-23</option>';
		 $ydar .= '<option value="21-25">21-25</option>';
		 $ydar .= '<option value="23-27">23-27</option>';
		 $ydar .= '<option value="25-30">25-30</option>';
		 }else if ($http->post["type"] == 'perc'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="7-12">7-12</option>';
		 $ydar .= '<option value="9-14">9-14</option>';
		 $ydar .= '<option value="11-16">11-16</option>';
		 $ydar .= '<option value="13-18">13-18</option>';
		 $ydar .= '<option value="15-20">15-20</option>';
		 $ydar .= '<option value="17-23">17-23</option>';
		 $ydar .= '<option value="19-26">19-26</option>';
		 $ydar .= '<option value="21-29">21-29</option>';
		 $ydar .= '<option value="23-32">23-32</option>';
		 $ydar .= '<option value="24-33">24-33</option>';
		 }else if ($http->post["type"] == 'kolchuga'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="7-12">7-12</option>';
		 $ydar .= '<option value="9-14">9-14</option>';
		 $ydar .= '<option value="11-16">11-16</option>';
		 $ydar .= '<option value="13-18">13-18</option>';
		 $ydar .= '<option value="13-17">13-17</option>';
		 $ydar .= '<option value="15-20">15-20</option>';
		 $ydar .= '<option value="15-19">15-19</option>';
		 $ydar .= '<option value="17-21">17-21</option>';
		 $ydar .= '<option value="19-23">19-23</option>';
		 $ydar .= '<option value="21-25">21-25</option>';
		 $ydar .= '<option value="23-27">23-27</option>';
		 $ydar .= '<option value="25-30">25-30</option>';
		 }else if ($http->post["type"] == 'shit'){
		 $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="10-14">10-14</option>';
		 $ydar .= '<option value="11-16">11-16</option>';
		 $ydar .= '<option value="12-18">12-18</option>';
		 $ydar .= '<option value="13-20">13-20</option>';
		 $ydar .= '<option value="18-22">18-22</option>';
		 $ydar .= '<option value="14-22">14-22</option>';
		 $ydar .= '<option value="19-24">19-24</option>';
		 $ydar .= '<option value="15-25">15-25</option>';
		 $ydar .= '<option value="20-26">20-26</option>';
		 $ydar .= '<option value="21-28">21-28</option>';
		 $ydar .= '<option value="22-30">22-30</option>';
		 $ydar .= '<option value="25-35">25-35</option>';
		 }


         ELSE{

         $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="5-8">5-8</option>';
		 $ydar .= '<option value="6-10">6-10</option>';
		 $ydar .= '<option value="7-12">7-12</option>';
		 $ydar .= '<option value="8-14">8-14</option>';
		 $ydar .= '<option value="9-16">9-16</option>';
		 $ydar .= '<option value="10-13">10-13</option>';
		 $ydar .= '<option value="11-15">11-15</option>';
		 $ydar .= '<option value="12-17">12-17</option>';
		 $ydar .= '<option value="13-19">13-19</option>';
		 $ydar .= '<option value="14-21">14-21</option>';
		 $ydar .= '<option value="15-23">15-23</option>';
         }

		## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop = '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="real">'.$kb.'
		</select></td>
		<td width="25%">Удар</td>
		<td width="25%" align="center">
		<select size="1" name="ydar" class="real">'.$ydar.'</select>
		</select></td>
	    </tr>';
		}else{

		   ## УДАР МИНИМУМ
		   $ydar = '';
		    #### ЕСЛИ ЛЮБОЕ ОРУЖИЕ КРОМЕ НОЖА И КНИГИ.
			if ($http->post["type"]<>"shle" and $http->post["type"]<>"bron" and $http->post["type"]<>"poya" and $http->post["type"]<>"noji" and $http->post["type"]<>"book"){
			$ydar .= '<option value="0-0">0</option>';
			$ydar .= '<option value="30-50">30-50</option>';
			$ydar .= '<option value="33-53">33-53</option>';
			$ydar .= '<option value="36-56">36-56</option>';
			$ydar .= '<option value="39-59">39-59</option>';
			$ydar .= '<option value="42-62">42-62</option>';
			$ydar .= '<option value="45-65">45-65</option>';
			$ydar .= '<option value="48-68">48-68</option>';
			$ydar .= '<option value="51-71">51-71</option>';
			$ydar .= '<option value="54-74">54-74</option>';
			$ydar .= '<option value="57-77">57-77</option>';
			$ydar .= '<option value="60-80">60-80</option>';
			$ydar .= '<option value="63-83">63-83</option>';
			$ydar .= '<option value="66-85">66-85</option>';
			$ydar .= '<option value="69-88">69-88</option>';
			$ydar .= '<option value="70-90">70-90</option>';
			$ydar .= '<option value="72-92">72-92</option>';
			$ydar .= '<option value="74-95">74-95</option>';
			$ydar .= '<option value="76-98">76-98</option>';
			$ydar .= '<option value="78-101">78-101</option>';
			$ydar .= '<option value="80-104">80-104</option>';
			$ydar .= '<option value="82-107">82-107</option>';
			$ydar .= '<option value="84-110">84-110</option>';
			$ydar .= '<option value="86-113">86-113</option>';
			$ydar .= '<option value="88-116">88-116</option>';
			$ydar .= '<option value="90-119">90-119</option>';
			$ydar .= '<option value="95-125">95-125</option>';
			$ydar .= '<option value="100-135">100-135</option>';
			$ydar .= '<option value="105-145">105-145</option>';
			$ydar .= '<option value="110-155">110-155</option>';
			$ydar .= '<option value="115-165">115-165</option>';
			$ydar .= '<option value="120-170">120-170</option>';

		}else if ($http->post["type"]<>"shle" and $http->post["type"]<>"bron" and $http->post["type"]<>"poya"){
        ## ЭТО НОЖ ИЛИ КНИГА
         $ydar .= '<option value="0-0">0</option>';
		 $ydar .= '<option value="20-26">20-26</option>';
		 $ydar .= '<option value="22-28">22-28</option>';
		 $ydar .= '<option value="24-30">24-30</option>';
		 $ydar .= '<option value="26-32">26-32</option>';
		 $ydar .= '<option value="28-34">28-34</option>';
		 $ydar .= '<option value="30-35">30-35</option>';
		 $ydar .= '<option value="32-37">32-37</option>';
		 $ydar .= '<option value="34-39">34-39</option>';
		 $ydar .= '<option value="36-41">36-41</option>';
		 $ydar .= '<option value="38-48">38-48</option>';
		 $ydar .= '<option value="40-50">40-50</option>';
		 $ydar .= '<option value="42-52">42-52</option>';
		 $ydar .= '<option value="44-54">44-54</option>';
		 $ydar .= '<option value="46-56">46-56</option>';
		 $ydar .= '<option value="48-58">48-58</option>';
		 $ydar .= '<option value="50-70">50-70</option>';
		 $ydar .= '<option value="60-80">60-80</option>';
		 }

        if ($http->post["type"]<>"shle" and $http->post["type"]<>"bron" and $http->post["type"]<>"poya")
		$dop = '<tr>
		<td width="25%">Урон</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="real">'.$ydar.'</select></td>
		</tr>';
		}
       if ($http->post["type"]=="shle" or $http->post["type"]=="bron" or $http->post["type"]=="poya") {
		$dop .= '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="real">'.$kb.'
		</select></td>
	    </tr>';
        }




		echo '<br><form method="POST" action="?c=ind">
        <table border=0 width="100%" cellspacing="0" cellspadding=0 class=LinedTable>
	<tr>
		<td align="center" class=user width="100%">Калькулятор индивидуальных артефактов</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class=ma align="center" width="100%">Шаг 3. Выбор параметров для артефакта ('.$name_typ.'). Класс артефакта: WARRIOR</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" align="right" width="100%" class="ma">
<table border="1" width="100%" cellspacing="0"  bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0">
	<tr>
		<td width="244">Сила</td>
		<td width="25%" align="center"><select size="1" name="s1" class="real">'.$stats.'
		</select></td>
		<td width="25%">Сокрушение</td>
		<td width="25%" align="center"><select size="1" name="mf1" class="real">'.$mf1.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Реакция</td>
		<td width="25%" align="center"><select size="1" name="s2" class="real">'.$stats.'
		</select></td>
		<td width="25%">Уловка</td>
		<td width="25%" align="center"><select size="1" name="mf2" class="real">'.$mf2.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Удача</td>
		<td width="25%" align="center"><select size="1" name="s3" class="real">'.$stats.'
		</select></td>
		<td width="25%">Точность</td>
		<td width="25%" align="center"><select size="1" name="mf3" class="real">'.$mf3.'</select></td>
	</tr>
	<tr>
		<td width="244"></td>
		<td width="25%" align="center"></td>
		<td width="25%">Стойкость</td>
		<td width="25%" align="center"><select size="1" name="mf4" class="real">'.$mf4.'</select></td>
	</tr>
	<tr>
		<td width="244"></td>
		<td width="25%" align="center"></td>
          '.$mf5.'

	</tr>
	<tr>
	 '.$hm.'

		<td width="25%"></td>
		<td width="25%" align="center"></td>
	</tr>
    '.$dop.'


	<tr>
		<td width="244">Охотник</td>
		<td width="25%" align="center"><select size="1" name="sp10" class="real">'.$proff.'</select></td>
		<td width="25%">Рыбалка</td>
		<td width="25%" align="center"><select size="1" name="sp6" class="real">'.$proff.'</select></td>
	</tr>
	<tr>
		<td width="244">Орентирование</td>
		<td width="25%" align="center"><select size="1" name="sp8" class="real">'.$proff.'</select></td>
		<td width="25%">Алхимик</td>
		<td width="25%" align="center"><select size="1" name="sp11" class="real">'.$proff.'</select></td>
	</tr>

	<tr>
		<td width="244">Тяжеловес</td>
		<td width="25%" align="center"><select size="1" name="sm3" class="real">'.$sm3.'</select></td>
		<td width="25%"></td>
		<td width="25%" align="center"></td>
	</tr>




	<tr>
		<td class="ma" colspan="4" align="center">Название <input name="name" size="27" class="laar"></td>
	</tr>
     '.$demos.'
	<tr>
		<td class="ma" colspan="4" align="center">
		<input type="hidden" value="'.$http->post["type"].'" name=type>
		<input type="hidden" value="warr" name=class>
		<input style="width:150px;height:20px;" type="button" value="Назад" class="inv_but" onclick="location=\'?c=ind\'"> |
		<input style="width:150px;height:20px;" type="reset" value="Сброс" class="inv_but"> |
		<input style="width:150px;height:20px;" type="submit" value="Готово" class="inv_but"></td>
	</tr>


</table>
		</td>
	</tr>
</table>
</form>';
     ## ШАГ №4 , покупка оружия.
	}elseif ($http->post["name"]=str_replace("'","",str_replace('"',"",$http->post["name"]))){

		$error = 0;

        if (!$http->post["imgdd"]) $error=1;

        switch($http->post["class"]){
        case 'warr' : $breks = 'WARRIOR'; break;
        case 'mag' : $breks = 'MAG'; break;
        default : $error = 1;
        }


		$dprice = 10;
		$p = $http->post;


		switch ($p["type"]){
        case 'noji': $name_typ = 'Нож'; $type = 'noji'; $stypes = 'orujie'; break;
        case 'mech': $name_typ = 'Меч'; $type = 'mech'; $stypes = 'orujie'; break;
        case 'drob': $name_typ = 'Дробящее'; $type = 'drob'; $stypes = 'orujie'; break;
        case 'topo': $name_typ = 'Топор'; $type = 'topo'; $stypes = 'orujie'; break;
        case 'shit': $name_typ = 'Щит'; $type = 'shit'; $stypes = 'orujie'; break;
        case 'shit': $name_typ = 'Книга'; $type = 'book'; $stypes = 'orujie'; break;
        case 'shle': $name_typ = 'Шлем'; $type = 'shlem'; $stypes = 'shlem'; break;
        case 'kolchuga': $name_typ = 'Кольчуга'; $type = 'kolchuga'; $stypes = 'kolchuga'; break;
        case 'bron': $name_typ = 'Броня'; $type = 'bronya'; $stypes = 'bronya'; break;
        case 'naru': $name_typ = 'Наручи'; $type = 'naruchi'; $stypes = 'naruchi'; break;
        case 'perc': $name_typ = 'Перчатки'; $type = 'perchatki'; $stypes = 'perchatki'; break;
        case 'poya': $name_typ = 'Пояс'; $type = 'poya'; $stypes = 'poyas'; break;
        case 'sapo': $name_typ = 'Сапоги'; $type = 'sapogi'; $stypes = 'sapogi'; break;
        case 'kolc': $name_typ = 'Кольцо'; $type = 'kolco'; $stypes = 'kolco'; break;
        case 'kylo': $name_typ = 'Кулон'; $type = 'kylo'; $stypes = 'ojerelie'; break;
        default : $error = 1;
        }

		foreach ($http->post as $key=>$value)
		if ($key<>'type' and $key<>'name')
		{
			$value = abs($value);
			if ($key[0]=='s' and $value>18) $value=18;
			if ($key[0]=='m' and $value>450) $value=450;
			if ($key[0]=='h' and $value>450) $value=450;
			if ($key[0]=='k' and $value>450) $value=450;
			if ($key[0]=='u' and $value>300) $value=300;
			if ($key[0]=='r' and $value>3) $value=3;
			$p[$key]=$value;
		}

		$p["name"] = substr($p["name"],0,20);
		$p["name"] = str_replace('"',"",$p["name"]);
		$p["name"] = str_replace("'","",$p["name"]);


		$ydars = explode('-', $http->post['ydar']);

        ## Если тип предмета не оружие.
        ## То урон не может быть больше 30.
		if ($http->post["type"]<>"noji" and $http->post["type"]<>"mech" and  $http->post["type"]<>"drob" and	$http->post["type"]<>"topo" and	$http->post["type"]<>"shit" and	$http->post["type"]<>"book")
		{
			if ($ydars[0]>50) $error = 1; //$ydars[0]=30;
			if ($ydars[1]>50) $error = 1; //$ydars[1]=30;
		}




		if ($ydars[1]<$ydars[0]) $error = 1; //$p["udmax"]=$p["udmin"];

      if ($error == 0){

		## расчет бабла за статы
		$dprice += $p["s1"]*10;
		$dprice += $p["s2"]*10;
		$dprice += $p["s3"]*10;
		$dprice += $p["s5"]*10;
		$dprice += $p["s6"]*10;
        ## расчет бабла за хп/мп
		$dprice += $p["hp"]*0.7;
		$dprice += $p["ma"]*0.7;
        ## расчет бабла за кб
		$dprice += $p["kb"];
        ## расчет бабла за мф
		$dprice += $p["mf1"]*0.5;
		$dprice += $p["mf2"]*0.5;
		$dprice += $p["mf3"]*0.5;
		$dprice += $p["mf4"]*0.5;
		$dprice += $p["mf5"]*0.5;

		$dprice += $http->post["sp6"]*2;
		$dprice += $http->post["sp8"]*2;
		$dprice += $http->post["sp10"]*2;
		$dprice += $http->post["sp11"]*2;


		/*** new ***/
		if ($p["sm3"]>0){$p["sm3"] = 10; $dprice += 50;}else{$p["sm3"] = 0;} ## Тяжеловес
		if ($p["sm6"]>0){$p["sm6"] = 10; $dprice += 50;}else{$p["sm6"] = 0;} ## Реген хп
		if ($p["sm7"]>0){$p["sm7"] = 10; $dprice += 50;}else{$p["sm7"] = 0;} ## Регенм мп

		## Расчет бабла за урон
		$dprice += $ydars[0]*$ydars[0]/16 + $ydars[0];
		$dprice += $ydars[1]*$ydars[1]/18 + $ydars[1];



		if ($type == "orujie")
		{
			if ($p["radius"]<1)$p["radius"]=1;
			$dprice *= $p["radius"];
		}


## Проверка урона
/*
$yrons = Array('20-26','22-28','24-30','26-32','28-34','30-35','32-37','34-39','36-41','38-48','40-50','42-52','44-54','46-56','48-58','50-70','60-80','30-50','33-53');
if (!in_array($http->post['yron'], $yrons)){
exit("Читерить не хорошо, пойдешь в блок");
die;
}
*/
## Позволенные типы предметов.
if ($http->post["class"] == 'warr'){
$acat = Array('noji','mech','drob','topo','shit','shle','kolchuga', 'bron', 'naru', 'perc', 'poya', 'sapo','kolc', 'kylo');
if (!in_array($http->post['type'], $acat)){
exit("Читерить не хорошо, пойдешь в блок");
die;
}
if ($http->post["s6"]>0 or $http->post["s5"]>0) exit("Читерить не хорошо, пойдешь в блок");
}


## Позволенные типы предметов.
if ($http->post["class"] == 'mag'){
$acat = Array('noji','book','shle','kolchuga', 'bron', 'naru', 'perc', 'poya', 'sapo','kolc', 'kylo');
if (!in_array($http->post['type'], $acat)){
exit("Читерить не хорошо, пойдешь в блок");
die;
}

}


        $img_test = $db->sqla("SELECT * FROM `images` WHERE `lavka` ='test' and `address`='".$db->real_escape_string($http->post["imgdd"])."' LIMIT 1");

        if (!$img_test){
        exit("Читерить не хорошо, пойдешь в блок");
        die;
        }

        $http->post["imgdd"] = str_replace('.gif',"",$http->post["imgdd"]);
        echo "<div align='center'><font class='freetxt'><b><font class='freemain'>Шаг 4.</font></b> Результат расчета артефакта (".$name_typ."). Класс артефакта:</font> <font class='freemain'><b><font color='#00a610'>".$breks."</font></strong></b></font></div>";

		$lastid = (int)$db->sqlr("SELECT MAX(id) FROM wp");
		$lastid = 1+$lastid;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    // stype
       $db->sql("INSERT INTO `wp` (`s5`,`s6`,`sp6`,`sp8`,`sp10`,`sp11`,`id`,`name`,`s1`,`s2`,`s3`,`mf1`,`mf2`,`mf3`,`mf4`,`mf5`,`kb`,`hp`,`ma`,`udmin`,`udmax`,`describe`,`dprice`,`image`,`type`,`where_buy`,`stype`,`weight`,`max_durability`,durability,`index`,`tlevel`,`sm3`) VALUES ('".$p["s5"]."','".$p["s6"]."','".$http->post["sp6"]."','".$http->post["sp8"]."','".$http->post["sp10"]."','".$http->post["sp11"]."','".$lastid."','".$p["name"]."','".$p["s1"]."','".$p["s2"]."','".$p["s3"]."','".$p["mf1"]."','".$p["mf2"]."','".$p["mf3"]."','".$p["mf4"]."','".$p["mf5"]."','".$p["kb"]."','".$p["hp"]."','".$p["ma"]."','".$ydars[0]."','".$ydars[1]."','Индивидуальный артефакт','".$dprice."','".$http->post["imgdd"]."','".$stypes."',1,'".$p["type"]."','1','1','1','','8','".$p["sm3"]."');");
       $vesh = $db->sqla("SELECT * FROM wp WHERE id='".$lastid."'");
       include(ROOT."/inc/inc/weapon2.php");
       echo "<script>".$text."</script>";
		echo "<center>";
		if ($player->pers["dmoney"]>=$dprice)
		echo "<input style='width:150px;height:20px;' type=button value=Купить class=inv_but onclick=\"location='?individs=".$lastid."'\">";

		if ($player->pers["dmoney"]>=$dprice and $player->pers["sign"]!='none')
		echo "<input style='width:150px;height:20px;' type=button value='Купить в клан казну' class=inv_but onclick=\"location='?cindivids=".$lastid."'\">";

		echo "<input style='width:150px;height:20px;' type=button value=Отменить class=inv_but onclick=\"location='?c=ind'\">";
		echo "</center>";
		}else{
		echo "<div align=center class=red>ОШИБКА</div>";
		}

	}
    ## Покупка индивид арта.
	elseif (@$http->get["individs"])
	{
		$vesh = $db->sqla("SELECT * FROM `wp` WHERE `id`='".intval($http->get["individs"])."' LIMIT 1");
		if ($vesh["dprice"] and $player->pers["dmoney"]>=$vesh["dprice"] and $vesh["uidp"]==0)
		{
		$db->sql("UPDATE `wp` SET `uidp`=".$player->pers["uid"].",`durability`=1 WHERE `id`='".intval($http->get["individs"])."' LIMIT 1");
		set_vars("dmoney=dmoney-".$vesh["dprice"]."",$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили '".$vesh["name"]."' за ".$vesh["dprice"]." БР</font>";
		include("inc/inc/weapon2.php");
		echo "<script>".$text."</script>";

## Записываем лог покупки (на всяк))
$fd = fopen('private_content/dhouse/create_art_'.date('Y_m_d', tme()), 'a+');
fwrite($fd, date("H:i:s", tme()).' Персонаж: ['.$player->pers["user"].'] ID: ['.$v["id"].'] ,  Вещь: ['.$v["name"].'] Цена -  ['.$vesh["dprice"].'] бр . СЕБЕ В РЮКЗАК@');
fclose($fd);

		}
	}
    ## Покупка в клан казну индивид арта.
	elseif (@$http->get["cindivids"])
	{
		$vesh = $db->sqla("SELECT * FROM `wp` WHERE `id`='".intval($http->get["cindivids"])."' LIMIT 1");
		if ($vesh["dprice"] and $player->pers["dmoney"]>=$vesh["dprice"] and $vesh["uidp"]==0)
		{
		$db->sql("UPDATE `wp` SET `clan_sign`='".$player->pers["sign"]."', `clan_name`='".$clan["name"]."',`present`='".$player->pers["user"]."',`uidp`=".$player->pers["uid"].",`durability`=1 WHERE `id`='".intval($http->get["cindivids"])."' LIMIT 1");
		set_vars("dmoney=dmoney-".$vesh["dprice"]."",$player->pers["uid"]);
		echo "<font class=hp>Вы удачно купили '".$vesh["name"]."' за ".$vesh["dprice"]." БР в казну клана</font>";
		include("inc/inc/weapon2.php");
		echo "<script>".$text."</script>";

			## Записываем лог покупки (на всяк))
			$fd = fopen('private_content/dhouse/create_art_'.date('Y_m_d', tme()), 'a+');
			fwrite($fd, date("H:i:s", tme()).' Персонаж: ['.$player->pers["user"].'] ID: ['.$v["id"].'] , Вещь: ['.$v["name"].'] Цена -  ['.$vesh["dprice"].'] бр . В КАЗНУ КЛАНА@');
			fclose($fd);

		}
	}
?>