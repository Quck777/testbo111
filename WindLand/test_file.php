<?

//echo "1) ".$_SERVER["DOCUMENT_ROOT"];
//error_reporting(0);
set_time_limit(180);
include ('inc/functions.php');
include ('inc/connect.php');
//db_open();

?>

<HTML>
<HEAD>
<LINK href="../../css/game.css" rel=STYLESHEET type=text/css>
<META Http-Equiv=Content-Type Content="text/html; charset=UTF-8">
<META Http-Equiv=Cache-Control Content=No-Cache>
<META Http-Equiv=Pragma Content=No-Cache>
<META Http-Equiv=Expires Content=0>
</HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Сравнение файлов</title>
</head>
<body class="nickname">
<a href="test_file.php">^^</a><br />
<br />
<br />
Осторожно сканирование может сильно нагрузить систему
<hr />
<form action="test_file.php" method="post"><input name="create" type="submit" value="Создать таблицу" /></form>
<form action="test_file.php" method="post"><input name="trunk" type="submit" value="Очистить таблицу" /></form>

<form action="test_file.php" method="post">
<input name="dir" type="text" value="/home/w/windlands/public_html/" />
<input name="scan" type="submit" value="Первичное сканирование" />
</form>

<form action="test_file.php" method="post">Показать опасные команды<input name="danger" type="checkbox" value="1">
Обновить изменения:<input name="add" type="checkbox" value="1">
<input name="find" type="submit" value="Искать изменения" /></form>
<form action="test_file.php" method="post">
<input name="dir" type="text" value="/home/w/windlands/public_html/"\> Добавить найденые:
<input name="add" type="checkbox" value="1">
<input name="findNew" type="submit" value="Искать новые файлы" /></form>
<hr />
<?

if(isset($_POST['create'])){
mysql_query("CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder` varchar(250) NOT NULL,
  `file` varchar(50) NOT NULL,
  `mod` int(11) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");

}
if(isset($_POST['trunk'])){ mysql_query("TRUNCATE TABLE `files`"); }

if(isset($_POST['scan']))scanFolder($_POST['dir']);

if(isset($_POST['find']))findMody(!isset($_POST['danger'])?false:true,!isset($_POST['add'])?false:true);

if(isset($_POST['findNew']))findNew($_POST['dir'],!isset($_POST['add'])?false:true);
?>
</body>
</html>
<?

	function findMody($t=false,$mod = false){
	$sql = mysql_query('SELECT * FROM files');
	while($file = $db->fetchAssoc($sql)){
		if(!file_exists($file['folder'].'/'.$file['file'])){
		if($mod){
			mysql_query("DELETE FROM files WHERE id = '".$file['id']."' LIMIT 1;");
			echo "<font color=blue>Удален файл ".$file['folder'].'/'.$file['file']."</font>(запись удалена из базы)<br>";
			}else{
		echo "<font color=blue>Удален файл ".$file['folder'].'/'.$file['file']."</font><br>";
		}
		continue;
		}
		$stat = stat($file['folder'].'/'.$file['file']);
		if($stat['size']!=$file['size']	|| $stat['mtime']!=$file['mod']){

			if($mod){
			mysql_query("UPDATE files SET `size`='".$stat['size']."', `mod`='".$stat['mtime']."' WHERE `id` = '".$file['id']."' LIMIT 1;");
			 echo "Файл ".$file['folder'].'/'.$file['file']." Был изменен ".date("d.m.Y H:i:s",$stat['mtime'])." (обновлен)</font><br>";
			}else{
			 echo "Файл ".$file['folder'].'/'.$file['file']." <font color=red>Был изменен ".date("d.m.Y H:i:s",$stat['mtime'])."</font><br>";
			}
		}
		if(substr($file['file'], -3)!='php')continue;
		$text = file_get_contents($file['folder'].'/'.$file['file']);
		if($t && preg_match('/eval|assert|create_function|base64_decode|gzuncompress|gzinflate|str_rot13|curl_exec/',$text,$arr)) echo $file['folder'].'/'.$file['file'].' <font color=green>Опасная команда!('.$arr[0].')</font><br>';
		}
	}

	function scanFolder($dir){
		$exclude = array('..','.','phpmyadmin','logs','test','inv','cache','cache.php');
		$files = @scandir($dir, 1);
		if(empty($files))return;
	foreach($files as $file){
		if(in_array($file,$exclude)||$file=='') continue;
	if(is_dir($dir.'/'.$file)){
		//if(in_array($file,$notScan))continue;
		scanFolder($dir.'/'.$file);}else
	if(is_file($dir.'/'.$file)){
		$stat = stat($dir.'/'.$file);
		mysql_query("INSERT INTO files VALUES(NULL,'$dir','$file','".$stat['mtime']."','".$stat['size']."');");
	} else continue;
	}
}

	function findNew($dir,$add = false){
		$exclude = array('..','.','phpmyadmin','logs','test','inv','cache','cache.php');
		$files = @scandir($dir, 1);
		if(empty($files))return;
		$sql = mysql_query("SELECT file FROM files WHERE folder='$dir';");
		while($row = $db->fetchAssoc($sql)){
			$find = array_search($row['file'],$files);
			if($find!==false) unset($files[$find]);
			}
		if(!empty($files)){
		foreach($files as $file){
			if(in_array($file,$exclude)||$file=='') continue;
			if(is_dir($dir.'/'.$file)){
				findNew($dir.'/'.$file,$add);}else
			if(is_file($dir.'/'.$file)){
			$stat = stat($dir.'/'.$file);
		echo 'найден новый фaйл'.$dir.'/'.$file.' (<b>'.$stat['size'].' байт</b> Дата изменения:'.date("d.m.Y H:i:s",$stat['mtime']).')<br>';
		if($add){

			mysql_query("INSERT INTO files VALUES(NULL,'$dir','$file','".$stat['mtime']."','".$stat['size']."');");
			}
		} else continue;

		}
		}

	}