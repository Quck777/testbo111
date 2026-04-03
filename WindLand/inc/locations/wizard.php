<?
require (ROOT.'/globals/functions/QUEST.php');
?>
<table width="100%" background="/images/bg21.gif" cellpadding="0" height="100%" cellspacing="0" border="0"><tr><td valign="top">

<center>
<table width="950" border="1" style="border-width:1px; border-color:#666666;" cellspacing="0">
<tr><td align="center">
<input type="button" value=" квесты " onClick="location='?room=quests'" style="background-color:#d6cab2;border:1px solid #000000; font-weight:bold; width:200px;"></td></tr>
<? if(isset($_REQUEST["room"]) && !empty($_REQUEST["room"])): ?>
	<tr><td>
	<? if ($_REQUEST["room"]=='quests'):  ?>
		<table border="0" width="100%" cellpadding="5">
		<tr><td width="150" align="center" valign="top"><img src="/images/persons/male_wizard.gif" border="0"></td>
		<td valign="top">
		<?=check_quests($pers,$_REQUEST,$quest_add_info)?>
		</td>
			</tr></table>
	<? endif; ?>
	</td></tr>
<? endif; ?>
</table>