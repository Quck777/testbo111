<?php
/**
 * WindLand - Конфигурационный файл
 * PHP 7.4+ | UTF-8 | MySQLi
 */

// Контроль ошибок
if (@$_COOKIE['AdminJoe']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Константы путей
define('GLOBAL_START_TIME', microtime(true));
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('HOST', $_SERVER['HTTP_HOST']);

// Пути к изображениям (сохранены как в оригинале)
define('IMG', '/images');
define('IMG_ROOT', ROOT . '/images');
define('PUBLIC_IMG', '/public_content/images');
define('SERVICE_ROOT', ROOT . '/public_content/service');

// Настройки базы данных
define('SQL_HOST', 'localhost');
define('SQL_PORT', 3306);
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_BASE', 'windland_db');

// Кодировка
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
date_default_timezone_set('Europe/Moscow');

// Фильтрация входных данных
function filterInput($value) {
    if (is_array($value)) {
        return array_map('filterInput', $value);
    }
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

if (!defined('SKIP_FILTER')) {
    foreach ($_POST as $key => $value) $_POST[$key] = filterInput($value);
    foreach ($_GET as $key => $value) $_GET[$key] = filterInput($value);
    foreach ($_COOKIE as $key => $value) $_COOKIE[$key] = filterInput($value);
}

// Глобальное время
$GLOBAL_TIME = time();
function tme() {
    global $GLOBAL_TIME;
    return $GLOBAL_TIME;
}

// Подключение к БД будет выполнено через класс MySQL
require_once ROOT . '/inc/class/mysql.php';
