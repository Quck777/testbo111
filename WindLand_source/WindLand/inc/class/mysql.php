<?php
class MySQL
{
	public $host = SQL_HOST;
	private $port = 3306;
	private $sql = false; // Для запроса
	private $base = NULL; // БД
	public $user = false; ### Копия юзера БД, для бекапа
	public $pass = false; ### Копия пароля к БД, для бекапа
	public $db_name = false; ### Копия имени БД, для бекапа
	public $tme = 0; // Общее время работы БД
	public $all = 0; // Количество запросов
	public $sql_all = Array(); // Лог запросов
	private $sq = Array ('mc'=>'mysql_connect',
			'msd'=>'mysql_select_db',
			'mq'=>'mysql_query',
			'mfa'=>'mysql_fetch_assoc',
			'mr'=>'mysql_result',
			'mfr'=>'mysql_fetch_row',
			'mfrr'=>'mysql_free_result'
			);
	
	public function __construct($user, $pwd, $db)
	{
		$this->user = $user;
		$this->pass = $pwd;
		$this->db_name = $db;
		
        $this->base = $this->sq['mc']( $this->host.':'.$this->port, $user, $pwd, true );
        $rs = $this->sq['msd']( $db, $this->base );
		
		if ( $rs==false ) die ( '<h1>Ошибочная конфигурация сервера (MySQL Off).</h1>' );
		$this->sq['mq']('SET NAMES cp1251');
	}
	
	private function error($q,$file='',$line='',$func='',$class='')
	{
	//	if ( defined('USERADMIN') )
		if ( @$_COOKIE['AdminJoe'] )
		echo '<hr><b>MySQL Error:</b> '.mysql_error().'<br>
		<b>Запрос:</b> '.$q.'<br>
		<b>File:</b> '.$file.'<br>
		<b>Line:</b> '.$line.'<br>
		<b>Function:</b> '.$func.'<br>
		<b>Class:</b> '.$class.'<hr>';
		
	}
	
	public function sql( $res, $file='', $line='', $func='', $class='' )
	{
		$t = microtime(true);
		$this->sql = $this->sq['mq']($res, $this->base);
		$t = microtime(true)-$t;
		if ( mysql_error() ) $this->error($res,$file,$line,$func,$class);
		$this->tme += abs($t);
		$this->all++;
	//	$this->sql_all[] = $res;
		$this->sql_all[] = Array($res,$file,$line,$func,$class);
		return $this->sql;
	}
	
	public function sqla($res, $file='', $line='', $func='', $class='')
	{
		return $this->sq['mfa']( $this->sql( $res, $file, $line, $func, $class ) );
	}
	
	public function sqlr($res, $count=0, $file='', $line='', $func='', $class='')
	{
		if ($count==0) return @$this->sq['mr']($this->sql( $res, $file, $line, $func, $class ),0);
		else return @$this->sq['mr']($this->sql( $res, $file, $line, $func, $class ),$count);
	}
	
	public function sqla_id($res, $file='', $line='', $func='', $class='')
	{
		return $this->sq['mfr']( $this->sql( $res, $file, $line, $func, $class ) );
	}
	
	public function join($res, $file='', $line='', $func='', $class='')
	{
		
	}
	
	public function insert_id()
	{
		return mysql_insert_id($this->base);
	}
	
	public function __destruct()
	{
	//	if (is_resource($this->sql)) $this->sq['mfrr']($this->sql); 
		mysql_close($this->base);
	}
	
}

?>