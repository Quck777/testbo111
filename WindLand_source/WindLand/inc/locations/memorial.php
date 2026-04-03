<center>
<table border="0" width="600" cellspacing="0" cellpadding="0" class=but>
<tr>
<td align="center" height="55">
<table border="0" width="500" cellspacing="0" cellpadding="0">
<tr>
<td width="500" colspan="8" align=center>
<div style="border-color:#2B587A;border-bottom-style: solid; border-bottom-width: 1px; padding-bottom: 1px">
<h2>Рейтинги</h2>
</div>
</td>
</tr>
<tr>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=1>Рейтинг войнов</a></b>
</td>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=2>Рейтинг рыболовов</a></b>
</td>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=3>Рейтинг алхимиков</a></b>
</td>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=4>Рейтинг шахтёров</a></b>
</td>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=5>Рейтинг охотников</a></b>
</td>
<td width=16% class=but>
<b><a class=bg href=main.php?cat=6>Реферальный рейтинг</a></b>
</td>
</tr>
</table></td>
</tr>
<tr>
<td align="center" style="border-left-width: 1px; border-right-width: 1px; border-top-style: solid; border-top-width: 1px; border-bottom-width: 1px">
<script>
<?
if (empty($_GET["cat"]) or $_GET["cat"]==1)
	include(SERVICE_ROOT."/events/A".date("d-m-y").".txt");
if (@$_GET["cat"]==2)
	include(SERVICE_ROOT."/events/F".date("d-m-y").".txt");
if (@$_GET["cat"]==3)
	include(SERVICE_ROOT."/events/L".date("d-m-y").".txt");
if (@$_GET["cat"]==4)
	include(SERVICE_ROOT."/events/M".date("d-m-y").".txt");
if (@$_GET["cat"]==5)
	include(SERVICE_ROOT."/events/H".date("d-m-y").".txt");
if (@$_GET["cat"]==6)
	include(SERVICE_ROOT."/events/R".date("d-m-y").".txt");
?>

function show_list()
{
	document.write (sbox2b(1)+'<table width=500 border="0" cellspacing="0" cellpadding="0">');
	for (var i=0;i<list.length;i++) document.write(hero_string(list[i],i+1)); 
	document.write ('</table>'+sbox2e());
}
function hero_string (element,a) 
{
 var arr = element.split("|");
 var s;
 var info;
 var bg = '#EEEEEE';
 if(a%2) bg = '#F5F5F5';
  info = '<a href=\'info.php?'+arr[0]+'\' target=_blank> <img src=http://'+img_pack+'/_i.gif border=0> </a>';
 s = '<tr style="background-color:'+bg+'"><td class=items>'+a+'.</td><td><img src=http://'+img_pack+'/_p.gif onclick="javascript:top.say_private(\''+arr[0]+'\')" style="cursor:pointer"> </td><td> <img src=http://'+img_pack+'/signs/'+arr[2]+'.gif title=\''+arr[3]+'\'><font class=user onclick="javascript:top.say_private(\''+arr[0]+'\')"> '+arr[0]+'</font></td><td>[<font class=lvl>'+arr[1]+'</font>]</td><td>'+info+'</font>';
 s+='</td><td class=ma style="border-left-style: solid; border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-width: 1px"> &nbsp;Очки: '+arr[4];
 s+='</td></tr>';
 return s;
}
</script>
</td>
	</tr>
</table>
</center>