<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

class Player
{
	private $db = false;
	public $pers = false;
	private $http = false;
	public $lastom_old = false;
	public $lastom_new = false;
	public $AuraSpecial = Array();
	private $MyClan = false;
	
	public function __construct($pc=true, $uid=false, $login=false, $new=false)
	{
		$this->db = $GLOBALS['db']; $this->http = $GLOBALS['http'];
		if ($pc)
		{
			$this->pers = $this->db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($this->http->_cookie('uid')).' and `pass` = "'.$this->http->_cookie('hashcode').'" LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ( !$this->pers ) $this->http->head('Location: index.php?e=nouserc', true);
			if ( !empty($this->pers['block']) ) $this->http->head('Location: index.php?e=blockc', true);
		}
		elseif($new)
		{
			$this->pers = $this->db->sqla('SELECT * FROM `users` WHERE `user` = "'.$this->http->_post('user').'" and `pass` = "'.md5($this->http->_post('pass')).'" LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			if ( !$this->pers ) $this->http->head('Location: index.php?e=nouserp', true);
			if ( !empty($this->pers['block']) ) $this->http->head('Location: index.php?e=blockp', true);
		}
		elseif($uid) $this->pers = $this->db->sqla('SELECT * FROM `users` WHERE `uid` = '.$uid.' LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		elseif($login) $this->pers = $this->db->sqla('SELECT * FROM `users` WHERE `user` = "'.$login.'" or `smuser`=LOWER("'.$login.'") LIMIT 1;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		else die('err');
	}
	
	public function mainactProcess()
	{
		$this->ReUserKey();
		$this->remove_all_auras();
		$this->getAurasSpecial();
		$this->remove_all_alcohol();
	}
	
	public function ReUserKey()
	{
		if ( $this->pers['cfight']!=1 or $this->pers['action']==-1 )
		{
			$t = tme();
			$this->db->sql('UPDATE `users` SET `online` = 1, `refr` = 0, `lastom` = '.$t.' WHERE `uid`='.$this->pers['uid'], __FILE__,__LINE__,__FUNCTION__,__CLASS__);
			$this->lastom_new = $t;
			$this->lastom_old = $this->pers['lastom'];
		}
	}
	
	private function getAurasSpecial()
	{ // 5, 50 - осложненные травмы, 14 - лицензия шахты, 15 - отдышка после шахты, 
		$res = $this->db->sql('SELECT `special`, `esttime` FROM `p_auras` WHERE `uid` = '.$this->pers['uid'].' and (`special`=5 or `special`=50 or `special`=14 or `special`=15) and `esttime` >'.tme().' ORDER BY `esttime` ASC;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		while ( $r = $this->db->fetchAssoc($res) )
		{
			if ( !$this->AuraSpecial[$r['special']] ) $this->AuraSpecial[$r['special']] = abs($r['esttime'] - tme());
		}
	}
	
	public function remove_all_auras()
	{
		$old_copy = $this->pers;
		$count = 0;
		$modified = 0;
		$as = $this->db->sql('SELECT * FROM `p_auras` WHERE `uid`= '.$this->pers['uid'].' and `esttime` <= '.tme().' and `turn_esttime`<='.$this->pers['f_turn'].';', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		while($a = $this->db->fetchArray($as))
		{
			$count++;
			$params = explode('@',$a['params']);
			foreach($params as $par)
			{
				$p = explode('=',$par);
				if ( $p[0]<>'cma' and $p[0]<>'chp' and intval($p[1])!=0 )
				{
					$this->pers[$p[0]] -= $p[1];
					$modified = 1;
				}
			}
			if ($a['special']==14)
			{
				$a['image'] = 68;
				$a['params'] = '';
				$a['esttime'] = 18000 - (tme() - $a['esttime']);
				$a['name'] = 'Отдышка после шахты';
				$a['special'] = 15;
				light_aura_on($a, $this->pers['uid']);
			}
		}
		if ($modified)
		{
			if( set_vars(aq($this->pers, $old_copy),$this->pers['uid']) )
				$this->db->sql('DELETE FROM `p_auras` WHERE `uid` = '.$this->pers['uid'].' and `esttime` <= '.tme().' and `turn_esttime`<='.$this->pers['f_turn'].' and `autocast`=0;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		}
		elseif($count) $this->db->sql('DELETE FROM `p_auras` WHERE `uid` = '.$this->pers['uid'].' and `esttime`<='.tme().' and `turn_esttime`<='.$this->pers['f_turn'].' and `autocast`=0;', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		unset($old_copy);
	}
	
	private function remove_all_alcohol()
	{
		$as = $this->db->sql('SELECT * FROM `p_alcohol` WHERE `uid`='.$this->pers['uid'].' and `esttime`<='.tme());
		$count = 0;
		$modified = 0;
		while( $a = $this->db->fetchAssoc($as) )
		{
			$count++;
			$params = explode('@',$a['params']);
			foreach($params as $par)
			{
				$p = explode('=',$par);
				if ($p[0]<>'cma' and $p[0]<>'chp' and intval($p[1])!=0 and $p[0]<>'time')
				{
					$this->pers[$p[0]] -= $p[1];
					$modified = 1;
				}
			}
		}
		if ($modified)
		{
			if ( set_vars(aq($this->pers), $this->pers['uid']) )
				$this->db->sql("DELETE FROM `p_alcohol` WHERE `uid`=".$this->pers['uid']." and `esttime`<=".tme());
		}
		elseif ($count) $this->db->sql("DELETE FROM `p_alcohol` WHERE `uid`=".$this->pers['uid']." and `esttime`<=".tme());
	}
	
	public function is_clan_check()
	{
		return ( $this->pers['sign']!='none' and !empty($this->pers['sign']) ) ? true : false;
	}
	
	public function getClan()
	{
		if ( $this->MyClan ) return $this->MyClan;
		$this->MyClan = $this->db->sqla('SELECT * FROM `clans` WHERE `sign` = "'.$this->pers["sign"].'";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
		return $this->MyClan;
	}
	
	public function jKey($t=0)
	{
		$new = md5($this->lastom_new); $old = md5($this->lastom_old);
		switch($t)
		{
			case 0: return 'jkey='.$new;
			case 1: return ($this->http->_get('jkey')==$old) ? true : false;
		}
	}
	
}


?>