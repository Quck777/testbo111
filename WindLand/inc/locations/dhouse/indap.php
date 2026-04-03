<div class=return_win><input type="button" value="Назад" class="inv_but" onclick="location='main.php'" style="width:500">
<input type="button" value="Улучшить" class="inv_but" onclick="location='main.php?c=indap'" style="width:500"></div>
<?php
error_reporting(0);
	if (empty($http->post) and empty($http->get["buy"]))
	{
		echo '<div class=weapons_box><form action=main.php?c=indap method=post>Выберите вещь: <select size="1" name="id" class="return_win"> ';
		$r = $db->sql("SELECT name,id FROM wp WHERE uidp='".$player->pers["uid"]."' and where_buy=1 and id_in_w='' and clan_sign='' and weared=0");
		$i=0;
			while ($p = $db->fetchArray($r))
			{
				$i++;
				echo "<option value=".$p["id"].">".$p["name"]."</option>";
			}
			echo '</select><input type="submit" value=" Ok " class="login"></form></div>';
			if ($i==0) echo "<div class=return_win>Вещь должна быть снята для улучшения.</div>";
	}
	elseif (empty($http->post["idd"]) and empty($http->get["buy"]))
	{
			$vesh = $db->sqla("SELECT * FROM wp WHERE id='".$http->post["id"]."' and uidp='".$player->pers["uid"]."' and where_buy=1 and id_in_w='' and clan_sign='' and weared=0");
			include("inc/inc/weapon2.php");
			$type  = $vesh["stype"];
			echo "<script>".$text."</script>";

        /*
		if ($type == 'noji'){ $stat_max = 10;}
		if ($type == 'mech'){ $stat_max = 10;}
		if ($type == 'drob'){ $stat_max = 10;}
		if ($type == 'topo'){ $stat_max = 10;}
		if ($type == 'shit'){ $stat_max = 18;}
		if ($type == 'book'){ $stat_max = 10;}
		*/

        if ($type == 'noji'){$maxkb = 0; $basik = 10*10; $basikz = 10*10; $hpp=10*0; $stat_max = 10;}
        if ($type == 'mech'){$maxkb = 0;  $basik = 10*12; $basikz = 10*10; $hpp=10*0; $stat_max = 10;}
        if ($type == 'drob'){$maxkb = 0;  $basik = 10*13; $basikz = 10*10; $hpp=10*0; $stat_max = 10;} // 10
        if ($type == 'topo'){$maxkb = 0;  $basik = 10*10; $basikz = 10*10; $hpp=10*0; $stat_max = 10;} // 15
        if ($type == 'shit'){$maxkb = 10*17;  $basik = 10*25; $basikz = 10*10; $hpp=10*35;$stat_max = 18;}
        if ($type == 'book'){$maxkb = 0;  $basik = 10*12; $basikz = 10*10; $hpp=10*0; $stat_max = 10;}
        if ($type == 'shle'){$maxkb = 10*12; $basik = 10*18; $basikz = 10*0; $hpp=10*30;   $stat_max = 12;}
    if ($type == 'kolchuga'){$maxkb = 10*12; $basik = 10*13; $basikz = 10*0; $hpp=10*25; $stat_max = 8;}
        if ($type == 'bron'){$maxkb = 10*30;  $basik = 10*20; $basikz = 10*0; $hpp=10*30;  $stat_max = 15;} //15
        if ($type == 'naru'){$maxkb = 10*12;  $basik = 10*15; $basikz = 10*8; $hpp=10*25; $stat_max = 12;}
        if ($type == 'perc'){$maxkb = 10*12;  $basik = 10*13; $basikz = 10*7; $hpp=10*23; $stat_max = 12;}
        if ($type == 'poya'){$maxkb = 10*8;  $basik = 10*15; $basikz = 10*0; $hpp=10*18; $stat_max = 12;}
        if ($type == 'sapo'){$maxkb = 10*11;  $basik = 10*17; $basikz = 10*6; $hpp=10*25; $stat_max = 10;}
        if ($type == 'kolc'){$maxkb = 10*7;  $basik = 10*10; $basikz = 10*5; $hpp=10*13; $stat_max = 9;} //99
        if ($type == 'kylo'){$maxkb = 10*7;  $basik = 10*10; $basikz = 10*0; $hpp=10*30; $stat_max = 12;}

		## Сила
		$s1 = '';
		for ($i=$vesh["s1"];$i<=$vesh["s1"]+$stat_max and $i<=$stat_max;$i++)
		 $s1 .= '<option value='.$i.'>+'.$i.'</option>';
		## Реакция
		$s2 = '';
		for ($i=$vesh["s2"];$i<=$vesh["s2"]+$stat_max and $i<=$stat_max;$i++)
		 $s2 .= '<option value='.$i.'>+'.$i.'</option>';
		## Удача
		$s3 = '';
		for ($i=$vesh["s3"];$i<=$vesh["s3"]+$stat_max and $i<=$stat_max;$i++)
		 $s3 .= '<option value='.$i.'>+'.$i.'</option>';
        ## Интеллект
		$s5 = '';
		for ($i=$vesh["s5"];$i<=$vesh["s5"]+$stat_max and $i<=$stat_max;$i++)
		 $s5 .= '<option value='.$i.'>+'.$i.'</option>';
        ## Сила воли
		$s6 = '';
		for ($i=$vesh["s6"];$i<=$vesh["s6"]+$stat_max and $i<=$stat_max;$i++)
		 $s6 .= '<option value='.$i.'>+'.$i.'</option>';




        ## ХП
		$hp = '';
		for ($i=$vesh["hp"];$i<=$vesh["hp"]+$hpp and $i<=$hpp;$i+=5)
		 $hp .= '<option value='.$i.'>+'.$i.'</option>';
		## МАНА
		$ma = '';
		for ($i=$vesh["ma"];$i<=$vesh["ma"]+$hpp and $i<=$hpp;$i+=5)
		 $ma .= '<option value='.$i.'>+'.$i.'</option>';

		## КБ  (лагс)
		$kb = '';
		for ($i=$vesh["kb"]; $i<=$vesh["kb"]+$hpp and $i<=$maxkb; $i+=5)
		 $kb .= '<option value='.$i.'>+'.$i.'</option>';


		 ## КРИТ
		$mf1 = '';
		for ($i=$vesh["mf1"];$i<=$vesh["mf1"]+$basik and $i<=$basik;$i+=10)
		 $mf1 .= '<option value='.$i.'>+'.$i.'</option>';
		 ## УЛОВКА
		$mf2 = '';
		for ($i=$vesh["mf2"];$i<=$vesh["mf2"]+$basik and $i<=$basik;$i+=10)
		$mf2 .= '<option value='.$i.'>+'.$i.'</option>';
		## ТОЧНОСТЬ
		$mf3 = '';
		for ($i=$vesh["mf3"];$i<=$vesh["mf3"]+$basik and $i<=$basik;$i+=10)
		 $mf3 .= '<option value='.$i.'>+'.$i.'</option>';
		 ## СТОЙКОСТЬ
		$mf4 = '';
		for ($i=$vesh["mf4"];$i<=$vesh["mf4"]+$basik and $i<=$basik;$i+=10)
		 $mf4 .= '<option value='.$i.'>+'.$i.'</option>';
		 ## ПРОБОЙ БРОНИ
		$mf5 = '';
		for ($i=$vesh["mf5"];$i<=$vesh["mf5"]+$basikz and $i<=$basikz;$i+=10)
		 $mf5 .= '<option value='.$i.'>+'.$i.'</option>';

		$ps10 = '';
		for ($i=$vesh["sp10"];$i<=$vesh["sp10"]+100 and $i<=100;$i+=10)
		 $ps10 .= '<option value='.$i.'>+'.$i.'</option>';

		 $ps8 = '';
		for ($i=$vesh["sp8"];$i<=$vesh["sp8"]+100 and $i<=100;$i+=10)
		 $ps8 .= '<option value='.$i.'>+'.$i.'</option>';

		$ps6 = '';
		for ($i=$vesh["sp6"];$i<=$vesh["sp6"]+100 and $i<=100;$i+=10)
		$ps6 .= '<option value='.$i.'>+'.$i.'</option>';

		 $ps11 = '';
		for ($i=$vesh["sp11"];$i<=$vesh["sp11"]+100 and $i<=100;$i+=10)
		 $ps11 .= '<option value='.$i.'>+'.$i.'</option>';

         /********************************************************/


         if ($vesh["s5"]>0 or $vesh["s6"]>0) {
         $typs = 'mag';
         }else{
         $typs = 'war';
         }


         $sm3 = '';
         if ($vesh["sm3"]==10){
         $sm3 .= '<option value="0">10</option>';
         }
		 if ($vesh["sm3"]<=0){
		 $sm3 .= '<option value="0">Выберите</option>';
		 $sm3 .= '<option value="10">10</option>';
		 }


        /*********************************************************/


        if ($typs == 'mag'){




        ## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		if ($type=="noji")
		{
		 $ydar = '';
         if ($vesh["udmin"]<=0)  $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=20 and $vesh["udmax"]<=30) $ydar .= '<option value="10-30">10-30</option>';
		 if ($vesh["udmin"]<=12 and $vesh["udmax"]<=32) $ydar .= '<option value="12-32">12-32</option>';
		 if ($vesh["udmin"]<=20 and $vesh["udmax"]<=35) $ydar .= '<option value="20-35">20-35</option>';
		 if ($vesh["udmin"]<=14 and $vesh["udmax"]<=34) $ydar .= '<option value="14-34">14-34</option>';
		 if ($vesh["udmin"]<=16 and $vesh["udmax"]<=36) $ydar .= '<option value="16-36">16-36</option>';
		 if ($vesh["udmin"]<=22 and $vesh["udmax"]<=36) $ydar .= '<option value="22-36">22-36</option>';
		 if ($vesh["udmin"]<=18 and $vesh["udmax"]<=38) $ydar .= '<option value="18-38">18-38</option>';
		 if ($vesh["udmin"]<=24 and $vesh["udmax"]<=37) $ydar .= '<option value="24-37">24-37</option>';
		 if ($vesh["udmin"]<=26 and $vesh["udmax"]<=38) $ydar .= '<option value="26-38">26-38</option>';
		 if ($vesh["udmin"]<=28 and $vesh["udmax"]<=39) $ydar .= '<option value="28-39">28-39</option>';
		 if ($vesh["udmin"]<=30 and $vesh["udmax"]<=40) $ydar .= '<option value="30-40">30-40</option>';
         ## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop = '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="items">'.$kb.'
		</select></td>
		<td width="25%">Удар</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="items">'.$ydar.'
		</select></td>
	    </tr>';
	     }
        }



   $dop = '';
   if ($typs == 'war') {






    if ($type=="poya" or $type=="bron" or $type=="shle" or $type=="perc"){
   	$dop .= '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="items">'.$kb.'
		</select></td>
		<td width="25%"></td>
		<td width="25%" align="center"></td>
	</tr>';
    }
        ## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		if ($type<>"kylo" and $type<>"sapo" and $type<>"kolchuga" and $type<>"naru" and $type<>"perc" and $type<>"poya" and $type<>"bron" and $type<>"shle" and $type<>"noji" and $type<>"mech" and $type<>"topo" and $type<>"book" and $type<>"drob")
		{
		 $ydar = '';
         if ($vesh["udmin"]<=0)  $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=5)  $ydar .= '<option value="5-8">5-8</option>';
		 if ($vesh["udmin"]<=6)  $ydar .= '<option value="6-10">6-10</option>';
		 if ($vesh["udmin"]<=7)  $ydar .= '<option value="7-12">7-12</option>';
		 if ($vesh["udmin"]<=8)  $ydar .= '<option value="8-14">8-14</option>';
		 if ($vesh["udmin"]<=9)  $ydar .= '<option value="9-16">9-16</option>';
		 if ($vesh["udmin"]<=10) $ydar .= '<option value="10-13">10-13</option>';
		 if ($vesh["udmin"]<=11) $ydar .= '<option value="11-15">11-15</option>';
		 if ($vesh["udmin"]<=12) $ydar .= '<option value="12-17">12-17</option>';
		 if ($vesh["udmin"]<=13) $ydar .= '<option value="13-19">13-19</option>';
		 if ($vesh["udmin"]<=14) $ydar .= '<option value="14-21">14-21</option>';
		 if ($vesh["udmin"]<=15) $ydar .= '<option value="15-23">15-23</option>';


         ## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop .= '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="items">'.$kb.'
		</select></td>
		<td width="25%">Удар</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="items">'.$ydar.'
		</select></td>
	</tr>';



  }else if ($type == 'kolchuga'){
         $ydar = '';
		 if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=7) $ydar .= '<option value="7-12">7-12</option>';
		 if ($vesh["udmin"]<=9) $ydar .= '<option value="9-14">9-14</option>';
		 if ($vesh["udmin"]<=11) $ydar .= '<option value="11-16">11-16</option>';
		 if ($vesh["udmin"]<=13 and $vesh["udmax"]==18) $ydar .= '<option value="13-18">13-18</option>';
		 if ($vesh["udmin"]<=13 and $vesh["udmax"]==17) $ydar .= '<option value="13-17">13-17</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==20) $ydar .= '<option value="15-20">15-20</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==19) $ydar .= '<option value="15-19">15-19</option>';
		 if ($vesh["udmin"]<=17) $ydar .= '<option value="17-21">17-21</option>';
		 if ($vesh["udmin"]<=19) $ydar .= '<option value="19-23">19-23</option>';
		 if ($vesh["udmin"]<=21) $ydar .= '<option value="21-25">21-25</option>';
		 if ($vesh["udmin"]<=23) $ydar .= '<option value="23-27">23-27</option>';
		 if ($vesh["udmin"]<=25) $ydar .= '<option value="25-30">25-30</option>';





  }else if ($type == 'kylo'){
         $ydar = '';
		 if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=5) $ydar .= '<option value="5-10">5-10</option>';
		 if ($vesh["udmin"]<=10) $ydar .= '<option value="10-15">10-15</option>';
		 if ($vesh["udmin"]<=15) $ydar .= '<option value="15-20">15-20</option>';
		 if ($vesh["udmin"]<=20) $ydar .= '<option value="20-25">20-25</option>';
  }else if ($type == 'sapo'){
         $ydar = '';
		 if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=7) $ydar .= '<option value="7-11">7-11</option>';
		 if ($vesh["udmin"]<=9) $ydar .= '<option value="9-13">9-13</option>';
		 if ($vesh["udmin"]<=11) $ydar .= '<option value="11-15">11-15</option>';
		 if ($vesh["udmin"]<=13) $ydar .= '<option value="13-16">13-16</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==17) $ydar .= '<option value="15-17">15-17</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==18) $ydar .= '<option value="15-18">15-18</option>';
		 if ($vesh["udmin"]<=16) $ydar .= '<option value="16-20">16-20</option>';
		 if ($vesh["udmin"]<=17) $ydar .= '<option value="17-22">17-22</option>';
		 if ($vesh["udmin"]<=18) $ydar .= '<option value="18-24">18-24</option>';
		 if ($vesh["udmin"]<=19) $ydar .= '<option value="19-25">19-25</option>';















		}else if ($type == 'perc'){
		 if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=7) $ydar .= '<option value="7-12">7-12</option>';
		 if ($vesh["udmin"]<=9) $ydar .= '<option value="9-14">9-14</option>';
		 if ($vesh["udmin"]<=11) $ydar .= '<option value="11-16">11-16</option>';
		 if ($vesh["udmin"]<=13) $ydar .= '<option value="13-18">13-18</option>';
		 if ($vesh["udmin"]<=15) $ydar .= '<option value="15-20">15-20</option>';
		 if ($vesh["udmin"]<=17) $ydar .= '<option value="17-23">17-23</option>';
		 if ($vesh["udmin"]<=19) $ydar .= '<option value="19-26">19-26</option>';
		 if ($vesh["udmin"]<=21) $ydar .= '<option value="21-29">21-29</option>';
		 if ($vesh["udmin"]<=23) $ydar .= '<option value="23-32">23-32</option>';
		 if ($vesh["udmin"]<=24) $ydar .= '<option value="24-33">24-33</option>';
              ## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop .= '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="items">'.$kb.'
		</select></td>
		<td width="25%">Удар</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="items">'.$ydar.'
		</select></td>
	</tr>';

		}else if ($type == 'naru'){
		 if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=7) $ydar .= '<option value="7-12">7-12</option>';
		 if ($vesh["udmin"]<=9) $ydar .= '<option value="9-14">9-14</option>';
		 if ($vesh["udmin"]<=11) $ydar .= '<option value="11-16">11-16</option>';
		 if ($vesh["udmin"]<=13 and $vesh["udmax"]==18) $ydar .= '<option value="13-18">13-18</option>';
		 if ($vesh["udmin"]<=13 and $vesh["udmax"]==17) $ydar .= '<option value="13-17">13-17</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==20) $ydar .= '<option value="15-20">15-20</option>';
		 if ($vesh["udmin"]<=15 and $vesh["udmax"]==19) $ydar .= '<option value="15-19">15-19</option>';
		 if ($vesh["udmin"]<=17) $ydar .= '<option value="17-21">17-21</option>';
		 if ($vesh["udmin"]<=19) $ydar .= '<option value="19-23">19-23</option>';
		 if ($vesh["udmin"]<=21) $ydar .= '<option value="21-25">21-25</option>';
		 if ($vesh["udmin"]<=23) $ydar .= '<option value="23-27">23-27</option>';
		 if ($vesh["udmin"]<=25) $ydar .= '<option value="25-30">25-30</option>';
		## УРОН ДЛЯ ВЕЩЕЙ КРОМЕ ОРУЖИЯ
		$dop .= '<tr>
		<td width="244">Класс брони</td>
		<td width="25%" align="center"><select size="1" name="kb" class="items">'.$kb.'
		</select></td>
		<td width="25%">Удар</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="items">'.$ydar.'
		</select></td>
	</tr>';

		}

		else{
		## УДАР МИНИМУМ
		$ydar = '';
		    #### ЕСЛИ ЛЮБОЕ ОРУЖИЕ КРОМЕ НОЖА И КНИГИ.
			if ($type<>"shle" and $type<>"bron" and $type<>"poya" and $type<>"noji" and $type<>"book"){
			if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
			if ($vesh["udmin"]<=30) $ydar .= '<option value="30-50">30-50</option>';
			if ($vesh["udmin"]<=33) $ydar .= '<option value="33-53">33-53</option>';
			if ($vesh["udmin"]<=36) $ydar .= '<option value="36-56">36-56</option>';
			if ($vesh["udmin"]<=39) $ydar .= '<option value="39-59">39-59</option>';
			if ($vesh["udmin"]<=42) $ydar .= '<option value="42-62">42-62</option>';
			if ($vesh["udmin"]<=45) $ydar .= '<option value="45-65">45-65</option>';
			if ($vesh["udmin"]<=48) $ydar .= '<option value="48-68">48-68</option>';
			if ($vesh["udmin"]<=51) $ydar .= '<option value="51-71">51-71</option>';
			if ($vesh["udmin"]<=54) $ydar .= '<option value="54-74">54-74</option>';
			if ($vesh["udmin"]<=57) $ydar .= '<option value="57-77">57-77</option>';
			if ($vesh["udmin"]<=60) $ydar .= '<option value="60-80">60-80</option>';
			if ($vesh["udmin"]<=63) $ydar .= '<option value="63-83">63-83</option>';
			if ($vesh["udmin"]<=66) $ydar .= '<option value="66-85">66-85</option>';
			if ($vesh["udmin"]<=69) $ydar .= '<option value="69-88">69-88</option>';
			if ($vesh["udmin"]<=70) $ydar .= '<option value="70-90">70-90</option>';
			if ($vesh["udmin"]<=72) $ydar .= '<option value="72-92">72-92</option>';
			if ($vesh["udmin"]<=74) $ydar .= '<option value="74-95">74-95</option>';
			if ($vesh["udmin"]<=76) $ydar .= '<option value="76-98">76-98</option>';
			if ($vesh["udmin"]<=78) $ydar .= '<option value="78-101">78-101</option>';
			if ($vesh["udmin"]<=80) $ydar .= '<option value="80-104">80-104</option>';
			if ($vesh["udmin"]<=82) $ydar .= '<option value="82-107">82-107</option>';
			if ($vesh["udmin"]<=84) $ydar .= '<option value="84-110">84-110</option>';
			if ($vesh["udmin"]<=86) $ydar .= '<option value="86-113">86-113</option>';
			if ($vesh["udmin"]<=88) $ydar .= '<option value="88-116">88-116</option>';
			if ($vesh["udmin"]<=90) $ydar .= '<option value="90-119">90-119</option>';
			if ($vesh["udmin"]<=95) $ydar .= '<option value="95-125">95-125</option>';
			if ($vesh["udmin"]<=100) $ydar .= '<option value="100-135">100-135</option>';
			if ($vesh["udmin"]<=105) $ydar .= '<option value="105-145">105-145</option>';
			if ($vesh["udmin"]<=110) $ydar .= '<option value="110-155">110-155</option>';
			if ($vesh["udmin"]<=115) $ydar .= '<option value="115-165">115-165</option>';
			if ($vesh["udmin"]<=120) $ydar .= '<option value="120-170">120-170</option>';
			}

		else if ($type<>"shle" and $type<>"bron" and $type<>"poya"){

         ## ЭТО НОЖ ИЛИ КНИГА
         if ($vesh["udmin"]<=0) $ydar .= '<option value="0-0">0</option>';
		 if ($vesh["udmin"]<=20) $ydar .= '<option value="20-26">20-26</option>';
		 if ($vesh["udmin"]<=22) $ydar .= '<option value="22-28">22-28</option>';
		 if ($vesh["udmin"]<=24) $ydar .= '<option value="24-30">24-30</option>';
		 if ($vesh["udmin"]<=26) $ydar .= '<option value="26-32">26-32</option>';
		 if ($vesh["udmin"]<=28) $ydar .= '<option value="28-34">28-34</option>';
		 if ($vesh["udmin"]<=30) $ydar .= '<option value="30-35">30-35</option>';
		 if ($vesh["udmin"]<=32) $ydar .= '<option value="32-37">32-37</option>';
		 if ($vesh["udmin"]<=34) $ydar .= '<option value="34-39">34-39</option>';
		 if ($vesh["udmin"]<=36) $ydar .= '<option value="36-41">36-41</option>';
		 if ($vesh["udmin"]<=38)  $ydar .= '<option value="38-48">38-48</option>';
		 if ($vesh["udmin"]<=40) $ydar .= '<option value="40-50">40-50</option>';
		 if ($vesh["udmin"]<=42) $ydar .= '<option value="42-52">42-52</option>';
		 if ($vesh["udmin"]<=44) $ydar .= '<option value="44-54">44-54</option>';
		 if ($vesh["udmin"]<=46) $ydar .= '<option value="46-56">46-56</option>';
		 if ($vesh["udmin"]<=48) $ydar .= '<option value="48-58">48-58</option>';
		 if ($vesh["udmin"]<=50) $ydar .= '<option value="50-70">50-70</option>';
		 if ($vesh["udmin"]<=60) $ydar .= '<option value="60-80">60-80</option>';
		 }


      } ## end typs war



   $zzs = '';
    if ($type=="perc" or $type=="naru" ){


    $zz1 = 'Класс брони';
    $zz2 = '<select size="1" name="kb" class="items">'.$kb.'</select>';

    }


		if ($type<>"shle" and $type<>"bron" and $type<>"poya")
		$dop = '<tr>
		<td width="244">'.$zz1.'</td>
		<td width="25%" align="center">'.$zz2.'</td>
		<td width="25%">Удар</td>
		<td width="25%" align="center"><select size="1" name="ydar" class="items">'.$ydar.'</select>
		</select></td>
		</tr>';
		}
		echo '<br><form method="POST" action="main.php?c=indap">
<table border="0" width="100%" style="border-style: solid; border-width: 1px; border-color: #777777" cellspacing="1">
	<tr>
		<td align="center" class=user width="100%">Мастер сборки
		индивидуальных артефактов</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" class=ma align="center" width="100%">
		Пожалуйста, выберите предполагаемые параметры артефакта.</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" align="right" width="100%" class="ma">
<table border="1" width="100%" cellspacing="1"  bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0">
	<tr>
		<td width="244">Сила</td>
		<td width="25%" align="center"><select size="1" name="s1" class="items">'.$s1.'
		</select></td>
		<td width="25%">Сокрушение</td>
		<td width="25%" align="center"><select size="1" name="mf1" class="items">'.$mf1.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Реакция</td>
		<td width="25%" align="center"><select size="1" name="s2" class="items">'.$s2.'
		</select></td>
		<td width="25%">Уловка</td>
		<td width="25%" align="center"><select size="1" name="mf2" class="items">'.$mf2.'
		</select></td>
	</tr>
	<tr>
		<td width="244">Удача</td>
		<td width="25%" align="center"><select size="1" name="s3" class="items">'.$s3.'
		</select></td>
		<td width="25%">Точность</td>
		<td width="25%" align="center"><select size="1" name="mf3" class="items">'.$mf3.'</select></td>
	</tr>
	<tr>
	';
	  if ($vesh["s5"]>=1){
		echo '<td width="244">Интеллект</td>
		<td width="25%" align="center"><select size="1" name="s5" class="items">'.$s5.'</select></td>
		';
		}
	echo '
		<td width="25%">Стойкость</td>
		<td width="25%" align="center"><select size="1" name="mf4" class="items">'.$mf4.'</select></td>
	</tr>
	<tr>
       ';
      if ($vesh["s6"]>=1){
       echo'
		<td width="244">Сила воли</td>
		<td width="25%" align="center"><select size="1" name="s6" class="items">'.$s6.'</select>
		</td>';
       }
      echo '
		<td width="25%">Пробой брони</td>
		<td width="25%" align="center"><select size="1" name="mf5" class="items">'.$mf5.'</select></td>


	</tr>
			<tr>
		<td width="25%">Охотник</td>
		<td width="25%" align="center"><select size="1" name="ps10" class="items">'.$ps10.'</select></td>

		<td width="25%">Орентирование на местности</td>
		<td width="25%" align="center"><select size="1" name="ps8" class="items">'.$ps8.'</select></td>
		</tr>
		<tr>
		<td width="25%">Рыбак</td>
		<td width="25%" align="center"><select size="1" name="ps6" class="items">'.$ps6.'</select></td>

		<td width="25%">Алхимик</td>
		<td width="25%" align="center"><select size="1" name="ps11" class="items">'.$ps11.'</select></td>
		</tr>

	<tr>
		<td class="hp" width="244">HP</td>
		<td width="25%" align="center"><select size="1" name="hp" class="items">'.$hp.'
		</select></td>
		<td width="25%"></td>
		<td width="25%" align="center">
		</td>
	</tr>
	';

	if ($vesh["s6"]>=1 or $vesh["ma"]>=1){
	echo '
	<tr>
		<td class="ma" width="244">MA</td>
		<td width="25%" align="center"><select size="1" name="ma" class="items">'.$ma.'
		</select></td>
		<td width="25%">&nbsp;</td>
		<td width="25%" align="center"></td>
	</tr>
	';
	}

echo '
'.$dop.'
<tr>
		<td width="244">Тяжеловес</td>
		<td width="25%" align="center"><select size="1" name="sm3" class="items">'.$sm3.'
		</select></td>
		<td width="25%"></td>
		<td width="25%" align="center"></td>
		</tr>
	<tr>
		<td class="ma" colspan="4" align="center">
			<input type="hidden" value="'.$http->post["id"].'" name=idd>
		<input type="button" value="Назад" class="inv_but" onclick="location=\'main.php?c=individual\'"> |
		<input type="reset" value="Сброс" class="inv_but"> |
		<input type="submit" value="Готово" class="inv_but"></td>
	</tr>
</table>
		</td>
	</tr>
</table>
</form>';
	}
	elseif (empty($http->get["buy"]))
	{
			$lastid = (int)$db->sqlr("SELECT MAX(id) FROM wp");
			$lastid = 1+$lastid;
			$vesh = $db->sqla("SELECT * FROM wp WHERE id='".$http->post["idd"]."' and uidp='".$player->pers["uid"]."' and where_buy=1 and id_in_w='' and clan_sign=''");
			$type  = $vesh["stype"];
			//$oldp = $vesh["dprice"];
			$oldp = 0;
			$oldid = $vesh["id"];


		$dprice = 20;

		$p = $http->post;

		foreach ($p as $key=>$value)
		if ($key<>'type' and $key<>'gr')
		{
			$value = abs($value);
			if ($key[0]=='p' and $value>450) $value=450;
			if ($key[0]=='s' and $value>15) $value=15;
			if ($key[0]=='m' and $value>450) $value=450;
			if ($key[0]=='h' and $value>450) $value=450;
			if ($key[0]=='k' and $value>450) $value=450;
			if ($key[0]=='u' and $value>450) $value=450;
			if ($key[0]=='r' and $value>3) $value=3;
			$p[$key]=$value;
		}

		$p["gr"] = substr($p["gr"],0,20);
		$p["gr"] = str_replace('"',"",$p["gr"]);
		$p["gr"] = str_replace("'","",$p["gr"]);

		//if ($p["udmax"]<$p["udmin"])$p["udmax"]=$p["udmin"];



		if ($p["s1"]>0 and $p["s1"]!=$vesh["s1"]){$p["s1"] = $p["s1"]; $dprice += $p["s1"]*10;   } else {$p["s1"] = $vesh["s1"];}
		if ($p["s2"]>0 and $p["s2"]!=$vesh["s2"]){$p["s2"] = $p["s2"]; $dprice += $p["s2"]*10;   } else {$p["s2"] = $vesh["s2"];}
		if ($p["s3"]>0 and $p["s3"]!=$vesh["s3"]){$p["s3"] = $p["s3"]; $dprice += $p["s3"]*10;   } else {$p["s3"] = $vesh["s3"];}
		if ($p["s5"]>0 and $p["s5"]!=$vesh["s5"]){$p["s5"] = $p["s5"]; $dprice += $p["s5"]*10;   } else {$p["s4"] = $vesh["s4"];}
		if ($p["s6"]>0 and $p["s6"]!=$vesh["s6"]){$p["s6"] = $p["s6"]; $dprice += $p["s6"]*10;   } else {$p["s6"] = $vesh["s6"];}
		if ($p["hp"]>0 and $p["hp"]!=$vesh["hp"]){$p["hp"] = $p["hp"]; $dprice += $p["hp"]*0.7;  } else {$p["hp"] = $vesh["hp"];}
		if ($p["ma"]>0 and $p["ma"]!=$vesh["ma"]){$p["ma"] = $p["ma"]; $dprice += $p["ma"]*0.7;  } else {$p["ma"] = $vesh["ma"];}
		if ($p["kb"]>0 and $p["kb"]!= $vesh["kb"]){$p["kb"] = $p["kb"]; $dprice += $p["kb"];      } else {$p["kb"] = $vesh["kb"];}
		if ($p["mf1"]>0 and $p["mf1"]!=$vesh["mf1"]){$p["mf1"] = $p["mf1"]; $dprice += $p["mf1"]*0.5;} else {$p["mf1"] = $vesh["mf1"];}
		if ($p["mf2"]>0 and $p["mf2"]!=$vesh["mf2"]){$p["mf2"] = $p["mf2"]; $dprice += $p["mf2"]*0.5;} else {$p["mf2"] = $vesh["mf2"];}
		if ($p["mf3"]>0 and $p["mf3"]!=$vesh["mf3"]){$p["mf3"] = $p["mf3"]; $dprice += $p["mf3"]*0.5;} else {$p["mf3"] = $vesh["mf3"];}
		if ($p["mf4"]>0 and $p["mf4"]!=$vesh["mf4"]){$p["mf4"] = $p["mf4"]; $dprice += $p["mf4"]*0.5;} else {$p["mf4"] = $vesh["mf4"];}
		if ($p["mf5"]>0 and $p["mf5"]!=$vesh["mf5"]){$p["mf5"] = $p["mf5"]; $dprice += $p["mf5"]*0.5;} else {$p["mf5"] = $vesh["mf5"];}

		if ($p["ps6"]>0 and $p["ps6"]!=$vesh["sp6"]){$p["ps6"] = $p["ps6"]; $dprice += $p["ps6"]*2;  } else {$p["ps6"] = $vesh["sp6"];}
		if ($p["ps8"]>0 and $p["ps8"]!=$vesh["sp8"]){$p["ps8"] = $p["ps8"]; $dprice += $p["ps8"]*2;  } else {$p["ps8"] = $vesh["sp8"];}
		if ($p["ps10"]>0 and $p["ps10"]!=$vesh["sp10"]){$p["ps10"] = $p["ps10"]; $dprice += $p["ps10"]*2;} else {$p["ps10"] = $vesh["sp10"];}
		if ($p["ps11"]>0 and $p["ps11"]!=$vesh["sp11"]){$p["ps11"] = $p["ps11"]; $dprice += $p["ps11"]*2;} else {$p["ps11"] = $vesh["sp11"];}

        $ydars = explode('-', $http->post['ydar']);
		if ($ydars[0]>0 and $ydars[0]!=$vesh["udmin"]){$ydars[0] = $ydars[0]; $dprice += $ydars[0]*$ydars[0]/16 + $ydars[0];}else{$ydars[0] = $vesh["udmin"];}
		if ($ydars[1]>0 and $ydars[1]!=$vesh["udmax"]){$ydars[1] = $ydars[1]; $dprice += $ydars[1]*$ydars[1]/18 + $ydars[1];}else{$ydars[1] = $vesh["udmax"];}

        if ($p["sm3"]>0){$p["sm3"] = 10; $dprice += 50;}else{$p["sm3"] = $vesh["sm3"] ;} ## Тяжеловес

		$dprice = round($dprice);

		$db->sql ("INSERT INTO `wp` (`id`,`name`,`s1`,`s2`,`s3`,`s5`,`s6`,`mf1`,`mf2`,`mf3`,`mf4`,`mf5`,`sp10`,`sp8`,`sp6`,`sp11`,`sp7`,`sp12`,`kb`,`hp`,`ma`,`udmin`,`udmax`,`describe`,`dprice`,`image`,`type`,`where_buy`,`stype`,`weight`,`max_durability`,durability,`index`,`sm3`) VALUES
('".$lastid."','".$vesh["name"]."','".$p["s1"]."','".$p["s2"]."','".$p["s3"]."','".$p["s5"]."','".$p["s6"]."','".$p["mf1"]."','".$p["mf2"]."','".$p["mf3"]."','".$p["mf4"]."','".$p["mf5"]."','".$p["ps10"]."','".$p["ps8"]."','".$p["ps6"]."','".$p["ps11"]."','".$p["ps7"]."','".$p["ps12"]."','".$p["kb"]."','".$p["hp"]."','".$p["ma"]."','".$ydars[0]."','".$ydars[1]."','Индивидуальный артефакт','".$dprice."','".$vesh["image"]."','".$vesh['type']."',1,'".$vesh["stype"]."','1','1','1','','".$p["sm3"]."');
");
		$vesh = $db->sqla("SELECT * FROM wp WHERE id='".$lastid."'");
		include("inc/inc/weapon2.php");
		echo "<script>".$text."</script>";
		echo "<center>";
		if ($player->pers["dmoney"]>=floor($dprice-$oldp))
		## ЦЕНА АРТА ^ ".round($dprice)." НАДО ЗАПЛАТИТЬ ".$oldp."
		echo "<input type=button value='Усилить[".floor($dprice-$oldp)." БР]' class=inv_but onclick=\"location='main.php?c=indap&buy=".$lastid."&old=".$oldid."'\">";
		else echo "<input type=button value='Усилить[".abs(floor($dprice-$oldp))." БР]' class=inv_but DISABLED>";
		echo "<input type=button value=Отменить class=inv_but onclick=\"location='main.php?c=indap'\">";
	}
	else
	{
		$vesh = $db->sqla("SELECT * FROM wp WHERE id='".$http->get["buy"]."'");
		$old = $db->sqla("SELECT * FROM wp WHERE id='".$http->get["old"]."'");
		if ($old["image"]==$vesh["image"])
		{
			if ($old["dprice"] and $player->pers["dmoney"]>=abs($vesh["dprice"]-$old["dprice"]) and $vesh["uidp"]==0)
			{
				$db->sql("UPDATE wp SET uidp=".$player->pers["uid"].",durability=1 WHERE id='".$http->get["buy"]."'");
				$db->sql("DELETE FROM wp WHERE id='".$old["id"]."' and weared=0 and uidp=".$player->pers["uid"]."");
				set_vars("dmoney=dmoney-".abs($vesh["dprice"]-$old["dprice"])."",$player->pers["uid"]);
				echo "<font class=hp>Вы удачно усилили '".$vesh["name"]."' за ".abs($vesh["dprice"]-$old["dprice"])." БР.</font>";
				include("inc/inc/weapon2.php");
				echo "<script>".$text."</script>";

				## Записываем лог покупки (на всяк))
				$fd = fopen('private_content/dhouse/edit_art_'.date('Y_m_d', tme()), 'a+');
				fwrite($fd, date("H:i:s", tme()).' Персонаж: ['.$player->pers["user"].'] ID: ['.$vesh["id"].'] ,  Вещь: ['.$vesh["name"].'] Цена -  ['.$vesh["dprice"].'] бр . СНЯЛОСЬ С ЮЗЕРА ['.abs($vesh["dprice"]-$old["dprice"]).'] бр@');
				fclose($fd);

			}
		}else echo "Hacking attempt!";

	}
?>