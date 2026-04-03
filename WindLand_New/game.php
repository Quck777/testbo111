<?php
/**
 * WindLand - Обработка входа в игру
 * PHP 7.4+ | UTF-8
 */

define('MICROLOAD', true);
require_once __DIR__ . '/configs/config.php';

$db = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_BASE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        die('<h1>Ошибка: Введите логин и пароль</h1><a href="/index.php">Назад</a>');
    }
    
    // Поиск пользователя
    $user = $db->getRow("SELECT * FROM users WHERE login = '" . $db->escape($login) . "'");
    
    if (!$user) {
        die('<h1>Ошибка: Пользователь не найден</h1><a href="/index.php">Назад</a>');
    }
    
    // Проверка пароля
    if (!password_verify($password, $user['password'])) {
        // Для совместимости со старыми паролями (admin)
        if (md5($password . 'SALT') !== $user['password']) {
            die('<h1>Ошибка: Неверный пароль</h1><a href="/index.php">Назад</a>');
        }
    }
    
    // Проверка бана
    if ($user['ban_until'] > time()) {
        $banTime = date('d.m.Y H:i', $user['ban_until']);
        die("<h1>Вы забанены до {$banTime}</h1><a href=\"/index.php\">Назад</a>");
    }
    
    // Установка куки
    $userHash = md5($user['password'] . 'SALT');
    setcookie('user_id', $user['id'], time() + 86400 * 30, '/');
    setcookie('user_login', $user['login'], time() + 86400 * 30, '/');
    setcookie('user_hash', $userHash, time() + 86400 * 30, '/');
    
    // Обновление последнего визита
    $db->query("UPDATE users SET last_visit = " . time() . ", is_online = 1, ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = " . (int)$user['id']);
    
    // Перенаправление в игру
    header('Location: /main.php');
    exit;
}

// Если GET запрос - просто показываем форму
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - WindLand</title>
    <style>
        body { font-family: Arial; background: #1a1a2e; color: #fff; text-align: center; padding: 50px; }
        .form-box { background: rgba(0,0,0,0.8); padding: 40px; border-radius: 10px; display: inline-block; }
        input { padding: 10px; margin: 10px; width: 250px; }
        button { padding: 12px 30px; background: #ffd700; border: none; cursor: pointer; font-weight: bold; }
        a { color: #ffd700; }
    </style>
</head>
<body>
    <div class="form-box">
        <h1>🔐 Вход в игру</h1>
        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <button type="submit">Войти</button>
        </form>
        <p><a href="/index.php">← На главную</a></p>
    </div>
</body>
</html>
