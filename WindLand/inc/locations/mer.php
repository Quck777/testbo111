<div class="but" width="100%">

<table align="center"><tr> 
	<td><img src="http://<?=IMG;?>/locations/mer.jpg" width="760" /></td>
	<td width="100%" valign="top">
		<a href="?reg_clan=1" class="bga">Регистрация клана</a>
		<?php 
		if ( $player->pers['sign']=='watchers' or UID == 7 ) echo '<a href="#" '.build_go_string('watch',$player->lastom_new).' class="bga">Обитель закона</a>';
		
		?>
	</td>
</tr></table>

</div>