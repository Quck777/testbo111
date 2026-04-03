<?php

// Класс работы с http


class Jhttp
{
	public $get  = Array();
	public $post = Array();
	public $cook = Array();
	
	private $inj = Array('DROP', 'SELECT', 'UPDATE', 'DELETE', 'drop', 'select', 'update', 'delete', 'WHERE', 'where', '-1', '-2', '-3','-4', '-5', '-6', '-7', '-8', '-9', '-0');
	
	private $ip = false;
	private $br = false;
	
	private $TIME_COOKIE = 3600;
	
	
	public function __construct()
	{
		$this->TIME_COOKIE = tme()+ $this->TIME_COOKIE*24;
		$this->check('a');
	//	unset($_GET);unset($_POST);unset($_REQUEST);unset($_COOKIE);
	}
	
	public function _get($v, $e = false)
	{
		if( !isset($this->get[$v]) ) return false;
		if( !$e ) return $this->get[$v];
	}
	
	public function _post($v, $e = false)
	{
		if( !isset($this->post[$v]) ) return false;
		if( !$e ) return $this->post[$v];
	}
	
	public function _cookie($v, $e = false)
	{
		if( !isset($this->cook[$v]) ) return false;
		if( !$e ) return $this->cook[$v];
	}
	
	public function check($type='a')
	{
		switch ($type)
		{
			case 'g': foreach ( $_GET as $k=>$v ) $this->get[$k] = $this->micro_filter($v, 'g'); break;
			case 'p': foreach ( $_POST as $k=>$v ) $this->post[$k] = $this->micro_filter($v, 'p'); break;
			case 'c': foreach ( $_COOKIE as $k=>$v ) $this->cook[$k] = $this->micro_filter($v, 'c'); break;
			case 'a': 	foreach ( $_GET as $k=>$v ) $this->get[$k] = $this->micro_filter($v, 'g'); 
						foreach ( $_POST as $k=>$v ) $this->post[$k] = $this->micro_filter($v, 'p');
						foreach ( $_COOKIE as $k=>$v ) $this->cook[$k] = $this->micro_filter($v, 'c'); 
				break;
		}
	}
	
	public function filter($value, $type=null)
	{
		if ( is_numeric($value) ) return intval($value);
		elseif ( is_string($value) )
		{
			if ( empty($value) ) return '';
			elseif ( in_array($value, $this->inj) )
			{
				$this->logs($value, $type);
				return '';
			} else {
				$value = trim($value);
				$value = htmlspecialchars( $value, ENT_NOQUOTES );
				$value = str_replace( '&', '&#38', $value );
				$value = str_replace( '"', '&#34', $value );
				$value = str_replace( "'", '&#39', $value );
				$value = str_replace( '<', '&#60', $value );
				$value = str_replace( '>', '&#62', $value );
				$value = str_replace( '\0', '', $value );
				$value = str_replace( '', '', $value );
				$value = str_replace( '\t', '', $value );
				$value = str_replace( '../', '. . / ', $value );
				$value = str_replace( '..', '. . ', $value );
				$value = str_replace( ';', '&#59', $value );
				$value = str_replace( '/*', '', $value );
				$value = str_replace( ' \ ', '', $value );
				$value = str_replace( '%00', '', $value );
				$value = stripslashes( $value );
				$value = str_replace( '\\', '&#92', $value );
				return $value;
			}
		}
	}
	
	public function micro_filter($value)
	{
		if ( is_numeric($value) ) return intval($value);
		elseif ( is_string($value) )
		{
			if ( empty($value) ) return '';
			elseif ( in_array($value, $this->inj) )
			{
				$this->logs($value, 'microfilter');
				return '';
			} else {
				$value = trim($value);
				$value = htmlspecialchars( $value, ENT_NOQUOTES );
				$value = str_replace( '"', '&#34', $value );
				$value = str_replace( "'", '&#39', $value );
				$value = stripslashes( $value );
				return $value;
			}
		}
	}
	
	private function logs($val, $type)
	{
		
	}
	
	public function is_ip()
	{
		if ( $this->ip ) return $this->ip;
		$ip = '';
		if( $ip_add=GetEnv('HTTP_CLIENT_IP') );
		elseif( $ip_add=GetEnv('HTTP_X_FORWARDED_FOR') );
		else $ip_add=GetEnv('REMOTE_ADDR');
		
		$_ip = explode('.',$ip_add);
		foreach ($_ip as $i) $ip .= (!empty($ip) ? '.' : '').intval($i);
		$this->ip = $ip;
		return $ip;
	}
	
	public function is_br($m = false)
	{
		if ( $this->br ) return $this->br;
		if ($m) $br = $this->micro_filter($_SERVER['HTTP_USER_AGENT']);
		else {
			$br = explode(' ', $_SERVER['HTTP_USER_AGENT']);
			$br = $this->filter($br[0]);
		}
		$this->br = $br;
		return $br;
	}
	
	public function setCook($name, $value, $type=true)
	{
		setcookie($name, $value, $this->TIME_COOKIE, '/', HOST, 0);
		if ($type)
		{
			setcookie($name, $value, $this->TIME_COOKIE, '/', FOR_HOST, 0);
			setcookie($name, $value, $this->TIME_COOKIE, '/', SUP_HOST, 0);
			setcookie($name, $value, $this->TIME_COOKIE, '/', LIB_HOST, 0);
		}
	}
	
	public function delCook($name)
	{
		setcookie($name, '', -1, '/', HOST, 0);
		setcookie($name, '', -1, '/', FOR_HOST, 0);
		setcookie($name, '', -1, '/', SUP_HOST, 0);
		setcookie($name, '', -1, '/', LIB_HOST, 0);
	}
	
	public function head($par, $die = false)
	{
		@Header($par);
		if ( $die ) exit;
	}
	
}


?>