<?php
	if ($player->pers["skill_zeroing"])
	{
		echo "<center class=but>ќбнулени€ мирного умени€ <b>".$player->pers["skill_zeroing"]."</b> , <i class=timef>ƒл€ использовани€ этого обнулени€ пройдите в университет и выберите дл€ обучени€ нужную дл€ обнулени€ профессию.</i></center>";
	}
	echo "<center class=but>ѕонижение физического урона: <b>".DecreaseDamage($player->pers)."%</b></center>";
	include (ROOT.'/inc/inc/characters/ym.php');
?>