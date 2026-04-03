
<table cellSpacing="0" cellPadding="0" border="0" cellspacing="5" cellspadding="5" width="660"><tr><td align="middle">
	<img title="Ножи" style="cursor: pointer" onclick="location='main.php?do=2&set_type=noji'" height="50" src="/images/weapons/set_knife.gif" width="40" border="0">
	<img title="Брони" style="cursor: pointer" onclick="location='main.php?do=2&set_type=bron'" height="50" src="/images/weapons/set_body.gif" width="40" border="0">
	<img title="Перчатки" style="cursor: pointer" onclick="location='main.php?do=2&set_type=perc'" height="50" src="/images/weapons/set_gloves.gif" width="40" border="0">
	<img title="Кольца" style="cursor: pointer" onclick="location='main.php?do=2&set_type=kolc'" height="50" src="/images/weapons/set_ring.gif" width="40" border="0">
	<img title="Расходники" style="cursor: pointer" onclick="location='main.php?do=2&set_type=zakl'" height="50" src="/images/weapons/set_decoct.gif" width="40" border="0">
</td></tr></table>
<br />
<?php echo '<center class="hp">У вас с собой <b>'.round($player->pers['imoney'],2).' IM</b></center>'; ?>

<table border="2" width="90%" cellspacing="2" cellpadding="2" bordercolorlight="#C0C0C0" bordercolordark="#FFFFFF">
<?php
$lavka = 1;

if ($_FILTER["lavkatype"]!='napad') $stype = "`stype`='".$_FILTER["lavkatype"]."'";
else $stype = "`type` = 'noji' ";
	
$enures = $db->sql("SELECT * FROM `weapons` WHERE  ".$stype." and `where_buy`='4' ORDER BY `price` ASC");
while ($v = mysql_fetch_array($enures))
{
	echo "<tr><td align=left class=weapons_box>";
	if ($v["q_s"]<1) echo "<font class=hp><b> Нет в наличии</b></font> ";
	if ($v["q_s"]>0 and $v["price"]<=$player->pers["imoney"]) echo "<input type=text class=login size=2 id='".$v["id"]."k' value=1 MAXLENGTH=2 > <input type=button class=inv_but onclick=\"w_buy('".$v["id"]."')\" value='Купить, Осталось: ".$v["q_s"]."'> <div class=inv_but id=id".$v["id"]."></div>";
	$vesh = $v;
	include (ROOT.'/inc/inc/weapon.php');
	echo "</td></tr>";
}

?></table>

<script>
var MAINID;
function w_buy(id)
{
	MAINID = 'id'+id;
	$('#'+MAINID).html('<img src=http://<?php echo IMG;?>/spinner.gif>');
	$.get('/gameplay/ajax/get_lavka_instant.php',{'buy':id, 'kolvo':$('#'+id+'k').val()},function(r)
	{
		arr = r.split('@');
		if ( arr[0]=='NO' ) $('#'+MAINID).html(arr[1]);
		else if (arr[0]=='OK') success(arr[1],arr[2],arr[3]);
	});
}
function success(name,price,kolvo)
{
	document.getElementById(MAINID).innerHTML = 'Вы удачно купили <b>"'+name+'"</b> за <b>'+price+'IM</b> в количестве '+kolvo+' шт.';
}
</script>
