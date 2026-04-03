<table width="100%" background="/images/bg21.gif" cellpadding="0" height="100%" cellspacing="0" border="0"><tr><td valign="top">
<center><div style="width:525px; height:25px; background-image:url(/interface/clan_top2.gif); background-repeat:no-repeat; vertical-align:top; padding-top:5px;"><a href="/main.php?room=quests"><strong> весты</strong></a></div></center>
<center>
<? if ($_REQUEST["room"]=='quests'):
require (ROOT.'/globals/functions/QUEST.php'); ?>
<table border="0" width="100%" cellpadding="5">
		<tr><td width="150" align="center" valign="top"><img src="/images/persons/unknown.gif" border="0"></td>
		<td valign="top">
		<?=check_quests($pers,$_REQUEST,$quest_add_info)?>
		</td>
			</tr></table>
<? endif; ?>
</center>
