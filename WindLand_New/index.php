<?php
/**
 * WindLand - Главная страница входа
 * PHP 7.4+ | UTF-8
 */

define('MICROLOAD', true);
require_once __DIR__ . '/configs/config.php';

// Подключение к БД
$db = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_BASE);

// Проверка авторизации
$userId = $_COOKIE['user_id'] ?? 0;
$userLogin = $_COOKIE['user_login'] ?? '';
$userHash = $_COOKIE['user_hash'] ?? '';

if ($userId && $userLogin && $userHash) {
    $user = $db->getRow("SELECT id, login, password FROM users WHERE id = " . (int)$userId);
    if ($user && $user['login'] === $userLogin && md5($user['password'] . 'SALT') === $userHash) {
        header('Location: /main.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WindLand - Земля Ветров</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #1a1a2e url('/public_content/images/bg_main.jpg') center/cover;
            min-height: 100vh;
            color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 0;
        }
        .header h1 {
            font-size: 48px;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            margin-bottom: 10px;
        }
        .header p {
            font-size: 18px;
            color: #ccc;
        }
        .auth-forms {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        .form-box {
            background: rgba(0,0,0,0.7);
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            border: 2px solid #444;
        }
        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffd700;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #aaa;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background: #222;
            color: #fff;
            font-size: 16px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ffd700;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            border: none;
            border-radius: 5px;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: scale(1.02);
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #ffd700;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 60px;
            flex-wrap: wrap;
        }
        .feature {
            background: rgba(0,0,0,0.6);
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
        }
        .feature img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .feature h3 {
            color: #ffd700;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏰 WindLand</h1>
            <p>Добро пожаловать в Землю Ветров!</p>
        </div>

        <div class="auth-forms">
            <!-- Форма входа -->
            <div class="form-box">
                <h2>Вход в игру</h2>
                <form action="/game.php" method="POST">
                    <div class="form-group">
                        <label for="login">Логин:</label>
                        <input type="text" id="login" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn">Войти</button>
                </form>
                <div class="links">
                    <a href="/reg.php">Регистрация</a> | 
                    <a href="/recover.php">Забыли пароль?</a>
                </div>
            </div>

            <!-- Информация -->
            <div class="form-box">
                <h2>О игре</h2>
                <p style="color: #ccc; line-height: 1.6;">
                    WindLand - это многопользовательская ролевая игра в браузере.<br><br>
                    🗡️ Сражайся с монстрами<br>
                    💰 Зарабатывай золото<br>
                    🏆 Создавай свой клан<br>
                    🤝 Находи друзей<br>
                    🎮 Исследуй мир
                </p>
            </div>
        </div>

        <div class="features">
            <div class="feature">
                <img src="/public_content/images/icons/sword.png" alt="Битвы" onerror="this.src='/images/sword.png'">
                <h3>Битвы</h3>
                <p>Участвуй в эпических сражениях с монстрами и игроками</p>
            </div>
            <div class="feature">
                <img src="/public_content/images/icons/gold.png" alt="Торговля" onerror="this.src='/images/gold.png'">
                <h3>Торговля</h3>
                <p>Покупай и продавай предметы на рынке</p>
            </div>
            <div class="feature">
                <img src="/public_content/images/icons/clan.png" alt="Кланы" onerror="this.src='/images/clan.png'">
                <h3>Кланы</h3>
                <p>Создай свой клан или вступи в существующий</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?= date('Y') ?> WindLand. Все права защищены.</p>
            <p>Игра работает на PHP <?= PHP_VERSION ?> с поддержкой UTF-8</p>
        </div>
    </div>
</body>
</html>
