<?php
/**
 * WindLand - Выход из игры
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

// Очистка куки
setcookie('uid', '', time() - 3600, '/');
setcookie('hashcode', '', time() - 3600, '/');

// Перенаправление на главную
header('Location: /index.php');
exit;
