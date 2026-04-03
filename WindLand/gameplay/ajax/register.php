<?php
##############################
#### Mod Joe. 13.04.2013 #####
##############################

session_start();
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
############################## 

//include (ROOT.'/inc/funcions.php');
DEFINE ('IS_REGISTER', true);

foreach ($_GET as $k => $v) $_GET[$k] = iconv("UTF-8", "cp1251", $v);
// Подключаем класс обработки входящих данных
$http = new Jhttp;


include (ROOT.'/inc/class/reg.class.php');
$login     = ( isset($_GET['login']) ) ? $_GET['login'] : false;
$email     = ( isset($_GET['email']) ) ? $_GET['email'] : false;
$pass      = ( isset($_GET['pass']) ) ? $_GET['pass'] : false;
$pass2    = ( isset($_GET['pass2']) ) ? $_GET['pass2'] : false;
$pol       = ( isset($_GET['pol']) ) ? $_GET['pol'] : false;
$code      = ( isset($_GET['code']) ) ? $_GET['code'] : false;
$law = ( isset($_GET['law']) ) ? $_GET['law'] : false;
$invitation = ( isset($_GET['invitation']) ) ? $_GET['invitation'] : false;
$captcha   = ( isset($_SESSION['captcha_keystring']) ) ? $_SESSION['captcha_keystring'] : false;
$ip		   = $http->is_ip();
$reg = new Reg();
echo $reg->verification();
?>