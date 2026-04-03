<?php
/**
 * WindLand - Конфигурационный файл
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

// Контроль ошибок
if (@$_COOKIE['AdminJoe']) {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Устанавливаем системные константы
define('GLOBAL_START_TIME', microtime(true));
define('IMG', ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/images');
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('IMG_ROOT', ROOT . '/images');
define('SERVICE_ROOT', ROOT . '/public_content/service');
define('WEAPON_UPLOADS', '');

define('HOST', $_SERVER['HTTP_HOST'] ?? 'localhost');
define('IMG_HOST', 'image.' . HOST);
define('LIB_HOST', 'lib.' . HOST);
define('SUP_HOST', 'support.' . HOST);
define('FOR_HOST', 'f.' . HOST);

// Настройка подключения к базе данных
define('SQL_HOST', 'localhost');
define('SQL_PORT', 3306);
define('SQL_USER', 'windland_user');
define('SQL_PASS', 'your_secure_password');
define('SQL_BASE', 'windland_db');
define('SQL_CHARSET', 'utf8mb4');

// Таймзона
date_default_timezone_set('Europe/Moscow');

// Глобальное время
$GLOBAL_TIME = time();

/**
 * Получение текущего времени
 * @return int
 */
function tme(): int
{
    global $GLOBAL_TIME;
    return $GLOBAL_TIME;
}

// Минифильтрация входных данных
if (!defined('MICROLOAD')) {
    include_once(ROOT . '/inc/class/http_check_v2.php');
}

// Подключение класса базы данных
include_once(ROOT . '/inc/class/mysql.php');
