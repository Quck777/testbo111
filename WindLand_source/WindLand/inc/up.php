<?php
// Для захвата тер, удаляем потом
// if ( $player->pers['gain_time']>(tme()-1200) ) $http->get['go'] = false;

if (tme()<$player->pers['waiter'] and !$player->pers['cfight'])
{
	$player->pers['cfight']		= 10;
	$player->pers['apps_id']	= 1;
}

if ( $player->pers['cfight']==0 and !$player->pers['apps_id'] )
{
	if ($http->_get('go')=='pers') {
		$db->sql("UPDATE `users` SET `curstate` = 0 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers['curstate']=0;
	}
	elseif ($http->_get('go')=="inv") {
		$db->sql("UPDATE `users` SET `curstate` = 1 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=1;
	}
	elseif ($http->_get('go')=="back" and !@$player->AuraSpecial[5]){
		if ($player->pers["help"]==2 and $player->pers["level"]==0)
		{
			set_vars("chp=hp,cma=ma",UID);
			$player->pers["chp"] = $player->pers["hp"];
			$player->pers["cma"] = $player->pers["ma"];
		}
		$db->sql("UPDATE `users` SET `curstate` = 2, help=3 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=2;
		$player->pers["help"] = 3;
	}else
	## Панель клана.
	if ($http->_get('go')=="orden" and $player->pers["cfight"]==0) {
		$db->sql("UPDATE `users` SET `curstate` = 3 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=3;
	}else
	## Панель клана.
	if ($http->_get('go')=="zakon" and $player->pers["cfight"]==0 and $player->pers["sign"]=="watchers") {
		$db->sql("UPDATE `users` SET `curstate` = 35 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=35;
	}
	elseif ($http->_get('go')=="self"  and !$player->AuraSpecial[5]) {
		$db->sql("UPDATE `users` SET `curstate` = 5 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=5;
	}
	elseif ($http->_get('go')=="friends"  and !$player->AuraSpecial[5]) {
		$db->sql("UPDATE `users` SET `curstate` = 6 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		$player->pers["curstate"]=6;
	}
 	############################### Адм
	elseif ( $player->pers['priveleged']==true and $priv['level']>0 )
	{
		if ($http->_get('go')=='map_edit' and $priv['emap']) {
			$db->sql("UPDATE `users` SET `curstate` = 301 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=301;
		}else
		if ($http->_get('go')=='administration') {
			$db->sql("UPDATE `users` SET `curstate` = 300 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=300;
		}else
		if ($http->_get('go')=='weapons'  and $priv['ewp'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 302 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=302;
		}
		if ($http->_get('go')=='magic'  and $priv['emagic'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 303 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=303;
		}
		if ($http->_get('go')=='bots'  and $priv['ebots'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 304 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=304;
		}
		if ($http->_get('go')=='ministers' and $priv['emain'] and $priv['level']==3) {
			$db->sql("UPDATE `users` SET `curstate` = 305 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers["curstate"]=305;
		}
		if ($http->_get('go')=='users' and $priv['eusers'] and $priv['level']==3) {
			$db->sql("UPDATE `users` SET `curstate` = 306 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=306;
		}
		if ($http->_get('go')=='quests' and $priv['equests'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 311 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=311;
		}
		/*
		if ($http->_get('go')=='questsR' and $priv['equests'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 312 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=312;
		}
		if ($http->_get('go')=='questsS' and $priv['equests'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 313 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=313;
		}
		if ($http->_get('go')=='questsQ' and $priv['equests'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 314 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=314;
		}
		*/
		if ($http->_get('go')=='ava_req' and $priv['level']>=1) {
			$db->sql("UPDATE `users` SET `curstate` = 307 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=307;
		}
		if ($http->_get('go')=='aclans' and $priv['eclans'] and $priv['level']>=2) {
			$db->sql("UPDATE `users` SET `curstate` = 308 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=308;
		}
		if ($http->_get('go')=='jour' and $priv['ejour'] and $priv['level']>=1) {
			$db->sql("UPDATE `users` SET `curstate` = 309 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=309;
		}
		if ($http->_get('go')=='admdlr') {
			$db->sql("UPDATE `users` SET `curstate` = 310 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=310;
		}
		if ($http->_get('go')=='admchat' and $priv['level']==3 ) {
			$db->sql("UPDATE `users` SET `curstate` = 315 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=315;
		}
		if ($http->_get('go')=='imgloader' and $priv['level']==3 ) {
			$db->sql("UPDATE `users` SET `curstate` = 316 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=316;
		}
		if ($http->_get('go')=='tavern' and $priv['etavern'] and $priv['level']>=1) {
			$db->sql("UPDATE `users` SET `curstate` = 317 WHERE `uid`=".UID." ;", __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$player->pers['curstate']=317;
		}
	}
}

########################################


if ($player->pers['location']<>'out')
{
	$location = $db->sqla('SELECT `go_id`,`name` FROM `locations` WHERE `id`="'.$player->pers['location'].'";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
	if ($location['go_id']) $out = $db->sqla('SELECT `name` FROM `locations` WHERE `id`="'.$location['go_id'].'";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);

} else $location = false;
##
if($player->pers['prison'])
{
	$prison = explode ('|', $player->pers['prison']);
	if ( $prison[0]<tme() and $player->pers["curstate"]<>4 and $player->pers["prison"] ) set_vars('`prison`=""', $player->pers['uid']);
	if ( $prison[0]>tme() )
	{
		$out['name']='';
		$location['go_id']='';
	}
}
##

if ( empty($out['name']) ) $out['name'] = '';

if ( abs(10+($player->pers['sm3']+$player->pers['s4'])*10) < $player->pers['weight_of_w'] and $player->pers['location']!='out' ) $_OVERWEIGHT = 1;
else $_OVERWEIGHT = 0;


@header("Cache-Control: no-cache, must-revalidate");
@header("Pragma: no-cache");
@header("Content-type: text/html; charset=windows-1251");

?>
<html>
<head>
	<title><?=$player->pers['user'];?></title>
	
	<link href="/css/main_v2.css" rel="stylesheet" type="text/css"/>
	<link href="/css/selectbox.css" rel="stylesheet" type="text/css"/>
	
	<script src="./js/mod/jquery.js" type="text/javascript"></script>
	<script src="./js/mod/scrollto.js" type="text/javascript"></script>
	<script src="./js/yourpers_v2.js" type="text/javascript"></script>
	<script src="./js/pers_v2.js" type="text/javascript"></script>
	<script src="./js/statsup_v2.js" type="text/javascript"></script>
	<script src="./js/sell.js" type="text/javascript"></script>
	<script src="./js/w.js" type="text/javascript"></script>
	<script src="./js/fightn.js" type="text/javascript"></script>
	<script src="./js/up_v2.js" type="text/javascript"></script>

</head>
<body topmargin="0" style="word-spacing: 0; margin-left: 0; margin-right: 0" leftmargin="0" onresize="on_resize()">
	
	<div class="but" style="position:absolute; left:-5px; top:-5px; z-index: 65000; width:0px; height:0px;display:none;" id="ec">&nbsp;</div>

	<script>
	<?php
	echo "var img_pack = '".IMG."';\n";
	echo "show_head('".$player->pers['curstate']."','".$out['name']."','".addslashes(build_go_string($location['go_id'], $player->lastom_new))."',".intval($player->pers['apps_id']).",".@($player->AuraSpecial[5]+$_OVERWEIGHT).",".intval($player->pers['help']).");\n";
	?>
	</script>

<!-- up end -->

