<?php
##############################
#### WindLand PHP 7.4+ #######
#### Updated: UTF-8 Support ##
##############################

// Контроль ошибок на php уровне
if ( @$_COOKIE['AdminJoe'] ) {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Устанавливаем системные константы
define('GLOBAL_START_TIME', microtime(true));
define('IMG', $_SERVER['HTTP_HOST'].'/images');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('IMG_ROOT', ROOT.'/images'); // Абсолютный путь
define('SERVICE_ROOT', ROOT.'/public_content/service'); // Абсолютный путь
define('WEAPON_UPLOADS', ''); // Абсолютный путь

define('HOST', $_SERVER['HTTP_HOST']);
define('IMG_HOST', 'image.'. HOST );
define('LIB_HOST', 'lib.'. HOST );
define('SUP_HOST', 'support.'. HOST );
define('FOR_HOST', 'f.'. HOST );

// Настройка подключения к базе данных
define('SQL_HOST', 'localhost');
define('SQL_USER', 'windlands_wl');
define('SQL_PASS', 'poppcpidar440whatis');
define('SQL_BASE', 'windland_db');

# Делаем минифильтрация всякой ВЦ
if ( defined('MICROLOAD') ) {
    function filter($v) {
        return str_replace("'", "", str_replace("\\", "", htmlspecialchars($v, ENT_QUOTES, 'UTF-8')));
    }
    foreach ($_POST as $key => $value) $_POST[$key] = filter($value);
    foreach ($_GET  as $key => $value) $_GET[$key]  = filter($value);
    foreach ($_COOKIE  as $key => $value) $_COOKIE[$key]  = filter($value);
} else {
    include_once (ROOT .'/inc/class/http_check_v2.php');
}

include_once (ROOT .'/inc/class/mysql.php');

# Сделаем переменную с временем и сделаем вывод через функцию) 
$GLOBAL_TIME = time();
function tme() {
    global $GLOBAL_TIME;
    return $GLOBAL_TIME;
}

// Установка UTF-8 кодировки
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
