<?php
/**
 * WindLand - Выход из игры
 * PHP 7.4+ | UTF-8
 */

define('MICROLOAD', true);
require_once __DIR__ . '/configs/config.php';

$db = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_BASE);

$userId = (int)($_COOKIE['user_id'] ?? 0);

if ($userId) {
    $db->query("UPDATE users SET is_online = 0 WHERE id = $userId");
}

// Удаление кук
setcookie('user_id', '', time() - 3600, '/');
setcookie('user_login', '', time() - 3600, '/');
setcookie('user_hash', '', time() - 3600, '/');

header('Location: /index.php');
exit;
