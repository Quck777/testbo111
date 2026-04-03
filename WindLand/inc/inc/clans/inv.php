<?php
if ( defined('CLANS')==false ) {echo '<center>Ошибка.</center>'; exit;}
$player->pers['sign'] = $clan['sign'];

$url = '';
if( @$delete_button1==false )
{ 
	$delete_button1 = '';
	$delete_button2 = '';
	$url = 'clan=w&';
}


if ( $http->_get('get_item') and $player->pers['clan_tr']==true )
{
	$v = $db->sqla("SELECT * FROM `wp` WHERE `id`=".intval($http->get['get_item'])." and `clan_sign`='".$clan['sign']."'");
	if ( $v['id']==true and $v['weared']==0 )
		$db->sql("UPDATE `wp` SET `uidp`=".$player->pers['uid'].", `user`='".$player->pers['user']."' WHERE `id`=".intval($http->get['get_item'])." and `clan_sign`='".$clan['sign']."'");
}
?>
<center><table border=0 width=800 class=but>
<tr><td align=center><script> show_imgs_sell('<?=$url;?>inv=<?=$clan["sign"];?>'); </script></td></tr><tr><td valign="top">
<?php
	if ( $_FILTER['lavkatype']!='napad' )
		$stype = "`stype`='".$_FILTER["lavkatype"]."'";
	else
		$stype = "`type` = 'napad' ";

	if ( $_FILTER['lavkatype']<>'all' )
		$enures = $db->sql("SELECT * FROM `wp` WHERE ".$stype." and `clan_sign`='".$player->pers['sign']."'");
	else
		$enures = $db->sql("SELECT * FROM `wp` WHERE `clan_sign`='".$player->pers['sign']."'");
$check = 0;
while ( $v=$db->fetchAssoc($enures) ) 
{
	if( $v['max_durability']==true and $v['durability']==false ) continue;
	echo "<div class=but2>";
	$check++;
	if ( $v['weared']==0 and $player->pers['clan_tr']==true ) echo "<a href='info.php?p=".$v['user']."' class=user target=_blank>".$v['user']."</a> <input type=button class=but onclick=\"location='main.php?clan=w&get_item=".$v['id']."'\" value='Взять'>";
	elseif( $player->pers['clan_tr']==true ) echo "<font class=hp>Вещь надета на персонаже </font><a href='info.php?".$v['user']."' class=user target=_blank>".$v['user']."</a>";
	
	if($delete_button1==true) echo $delete_button1.$v['id'].$delete_button2;
	echo "</div>";
	$vesh = $v;
	include (ROOT.'/inc/inc/weapon.php');

}
if ( $clan['treasury']<$check )
{
	$tr = $db->sqlr("SELECT COUNT(*) FROM `wp` WHERE `clan_sign`='".$player->pers['sign']."'",0);
	$db->sql("UPDATE `clans` SET `treasury`=".$tr." WHERE `sign`='".$player->pers['sign']."'");
}
?>
</table></center>