<?php 

include "quests.php";

echo "<br><hr><br><b class=about>Речёвки</b>";
$sps = $db->sql("SELECT * FROM speech WHERE id_from=0");
echo "<table class=fightlong width=100% border=0>";
while($sp = $db->fetchArray($sps))
{
	echo show_speech($sp);
}
echo "</table><a class=nt href=main.php?newsp=1>Добавить речь</a>";

?>