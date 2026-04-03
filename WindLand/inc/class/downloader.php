<?php

class Downloader
{
	private $file = Array();
	private $arr_type = Array('application/octet-stream', 'image/gif', 'image/jpeg', 'application/x-rar-compressed');
	private $size = 80000;
	private $path = '';
	private $fname = '';
	private $gname = '';
	
	public function __construct($fl, $ld, $nm)
	{
		$this->file = $fl;
		$this->path = $ld;
		$this->fname = $nm;
	}	
	
	public function loader($name)
	{
		$file = @$this->file[$name];
		if ( $file == false ) return false;
		if ( $file['error']>0 ) return $this->error_msg($file['error']);
		if ( $file['size'] > $this->size ) return 'Размер файла слишком большой!';
		
		$name = $this->gen_filename($file['type']);
		
		if ( copy ( $file['tmp_name'], IMG_ROOT.'/'.$this->path.'/'.$name) ) return $this->gname;
		else return 'Ошибка!';
	}
	
	private function error_msg($err)
	{
		switch ($err)
		{
			case 0: $r = ''; break;
			
			default: $r = '';
		}
		return $r;
	}
	
	private function gen_filename($n)
	{
		$r = '';
		if ( empty($this->fname) )
		{
			$crypt = md5(crypt(time()));
			$crypt = substr($crypt,5,10);
		} else $crypt = filter_var($this->fname);
		
		if ( $this->arr_type[1] == $n )
			$r = 'gif';
		elseif ( $this->arr_type[2] == $n )
			$r = 'jpeg';
		$this->gname = trim($crypt);
		return $this->gname.'.'.$r;
	}
	
}

?>