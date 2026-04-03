<?php

if (UID!=1 and UID!=2509) die('Go..');

DEFINE ('LOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/images');

function listen_dir()
{
	$path = LOAD_DIR;
	$dirs = array();
	$files = array();
	$dir = opendir($path); 
	while ( ( $file = readdir($dir) ) !== false )
	{
		if ( $file=='.' or $file=='..' ) continue;
		if ( is_dir("$path/$file") ) $dirs[] = $file;
		else $files[] = $file;
	}
	closedir($dir);
	return Array('dirs'=>$dirs, 'files'=>$files);
}



$listen = listen_dir();




class Downloader
{
	private $file = Array();
	private $arr_type = Array('application/octet-stream', 'image/gif', 'image/jpeg', 'application/x-rar-compressed');
	private $size = 80000;
	private $path = '';
	private $fname = '';
	
	
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
		
		if ( copy ( $file['tmp_name'], LOAD_DIR.'/'.$this->path.'/'.$name) ) return '<br /><img src="/images/'.$this->path.'/'.$name.'"><br />Файл загружен успешно!';
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
			$crypt = substr($crypt,5,15);
		} else $crypt = filter_var($this->fname);
		
		if ( $this->arr_type[1] == $n )
			$r = 'gif';
		elseif ( $this->arr_type[2] == $n )
			$r = 'jpeg';
		
		return trim($crypt).'.'.$r;
	}
	
}

if ( isset($_POST['load']) )
{
	$f = new Downloader($_FILES, $_POST['dir'], $_POST['fname']);
	echo $f->loader('fl');
}


function for_select_cat()
{
	GLOBAL $listen;
	$cat = $listen['dirs'];
	$r = '';
	for ($i=0; $i<count($cat); $i++)
	{
		$n = $cat[$i];
		$nm = name_cat($n);
		if ( $nm == false ) continue;
		$r.= '<option value="'.$n.'">'.$nm.'</option>';
	}
	return $r;
}

function name_cat($n)
{
	$nm = Array (
		'signs'=>'Значки кланов',
		'weapons'=>'Обмундирование'
		);
	$r = ( $nm[$n]==true ) ? $nm[$n] : false;
	return $r;
}

?>

<form action="?" method="POST" enctype="multipart/form-data">

	<input type="hidden" name="load">
	Файл: <input type="file" name="fl"> <br />
	Директория:
	<select name="dir"><option value="">Выбрать</option><?php echo for_select_cat();?></select>
	
	<br />
	Имя файла (оставить пустым):<input type="text" name="fname"> <br />
	<input type="submit" value="Загрузить">

</form>
