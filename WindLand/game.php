<?php
/**
 * WindLand - Страница игры (вход и основной интерфейс)
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/configs/config.php');

// Проверка авторизации
$auth_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    if (!empty($user) && !empty($pass)) {
        $db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
        $hashed_pass = md5($pass);

        $user_data = $db->sqla(
            "SELECT * FROM `users` WHERE `user` = ? AND `pass` = ? LIMIT 1",
            __FILE__, __LINE__, __FUNCTION__, __CLASS__
        );

        // Для совместимости со старыми паролями используем подготовленные данные
        $stmt = $db->base->prepare("SELECT * FROM `users` WHERE `user` = ? AND `pass` = ? LIMIT 1");
        $stmt->bind_param("ss", $user, $hashed_pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        $stmt->close();

        if ($user_data) {
            if (!empty($user_data['block'])) {
                $auth_error = 'Ваш аккаунт заблокирован.';
            } else {
                // Успешный вход
                $hashcode = md5($user_data['uid'] . $user_data['pass'] . time());
                setcookie('uid', (string)$user_data['uid'], time() + 86400 * 30, '/');
                setcookie('hashcode', $hashcode, time() + 86400 * 30, '/');

                // Обновление статуса онлайн
                $db->sql("UPDATE `users` SET `online` = " . time() . ", `last_visit` = " . time() . " WHERE `uid` = " . (int)$user_data['uid']);

                header('Location: /main.php');
                exit;
            }
        } else {
            $auth_error = 'Неверное имя пользователя или пароль.';
        }
    } else {
        $auth_error = 'Введите имя пользователя и пароль.';
    }
}

// Если уже авторизован - перенаправляем в игру
if (isset($_COOKIE['uid']) && isset($_COOKIE['hashcode'])) {
    $db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
    $uid = (int)$_COOKIE['uid'];
    $hashcode = $_COOKIE['hashcode'];

    $user_data = $db->sqla("SELECT * FROM `users` WHERE `uid` = $uid LIMIT 1");

    if ($user_data && empty($user_data['block'])) {
        header('Location: /main.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>WindLand - Вход в игру</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/index_v2.css"/>
</head>
<body>
<div class="login-page">
    <div class="login-container">
        <h1>WindLand</h1>

        <?php if ($auth_error): ?>
            <div class="error-message"><?= htmlspecialchars($auth_error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="user">Имя персонажа:</label>
            <input type="text" id="user" name="user" required autofocus>

            <label for="pass">Пароль:</label>
            <input type="password" id="pass" name="pass" required>

            <button type="submit">Войти</button>
        </form>

        <div class="links">
            <a href="/index.php">На главную</a> |
            <a href="/reg.php">Регистрация</a>
        </div>
    </div>
</div>
</body>
</html>
