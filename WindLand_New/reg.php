<?php
/**
 * WindLand - Регистрация нового пользователя
 * PHP 7.4+ | UTF-8
 */

define('MICROLOAD', true);
require_once __DIR__ . '/configs/config.php';

$db = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_BASE);

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? 'male';
    
    // Валидация
    if (strlen($login) < 3 || strlen($login) > 20) {
        $errors[] = 'Логин должен быть от 3 до 20 символов';
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
        $errors[] = 'Логин может содержать только латинские буквы, цифры и подчеркивание';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов';
    }
    if ($password !== $password2) {
        $errors[] = 'Пароли не совпадают';
    }
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }
    
    // Проверка существования пользователя
    if (empty($errors)) {
        $existing = $db->getRow("SELECT id FROM users WHERE login = '" . $db->escape($login) . "'");
        if ($existing) {
            $errors[] = 'Пользователь с таким логином уже существует';
        }
    }
    
    // Регистрация
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $regDate = time();
        
        $db->query("INSERT INTO users (login, password, email, gender, reg_date, last_visit, hp, max_hp, mana, max_mana, gold, location) 
                    VALUES (
                        '" . $db->escape($login) . "',
                        '" . $db->escape($passwordHash) . "',
                        '" . $db->escape($email) . "',
                        '" . $db->escape($gender) . "',
                        $regDate,
                        $regDate,
                        100, 100, 100, 100, 50, 'start'
                    )");
        
        $userId = $db->insertId();
        
        if ($userId) {
            // Выдаем стартовые предметы
            $db->query("INSERT INTO inventory (user_id, item_id, count) VALUES ($userId, 1, 1)"); // Ржавый меч
            
            $success = true;
        } else {
            $errors[] = 'Ошибка при регистрации';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - WindLand</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #1a1a2e url('/public_content/images/bg_reg.jpg') center/cover;
            min-height: 100vh;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .form-box {
            background: rgba(0,0,0,0.8);
            padding: 40px;
            border-radius: 10px;
            border: 2px solid #444;
        }
        h1 {
            text-align: center;
            color: #ffd700;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #aaa;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #555;
            border-radius: 5px;
            background: #222;
            color: #fff;
            font-size: 16px;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #ffd700;
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            border: none;
            border-radius: 5px;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .error {
            background: rgba(255,0,0,0.2);
            border: 1px solid red;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #ff6666;
        }
        .success {
            background: rgba(0,255,0,0.2);
            border: 1px solid green;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #66ff66;
            text-align: center;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #ffd700;
            text-decoration: none;
        }
        .gender-options {
            display: flex;
            gap: 20px;
        }
        .gender-option {
            flex: 1;
        }
        .gender-option input[type="radio"] {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>🎮 Регистрация</h1>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success">
                    <h2>✅ Регистрация успешна!</h2>
                    <p>Вы можете войти в игру под своим логином и паролем.</p>
                    <br>
                    <a href="/index.php" class="btn" style="display:inline-block;width:auto;text-decoration:none;">Войти в игру</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="login">Логин *</label>
                        <input type="text" id="login" name="login" required 
                               value="<?= htmlspecialchars($_POST['login'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               placeholder="Придумайте логин">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               placeholder="your@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Пароль *</label>
                        <input type="password" id="password" name="password" required 
                               placeholder="Минимум 6 символов">
                    </div>
                    
                    <div class="form-group">
                        <label for="password2">Подтверждение пароля *</label>
                        <input type="password" id="password2" name="password2" required 
                               placeholder="Повторите пароль">
                    </div>
                    
                    <div class="form-group">
                        <label>Пол *</label>
                        <div class="gender-options">
                            <label class="gender-option">
                                <input type="radio" name="gender" value="male" checked> Мужской
                            </label>
                            <label class="gender-option">
                                <input type="radio" name="gender" value="female"> Женский
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Зарегистрироваться</button>
                </form>
            <?php endif; ?>
            
            <div class="links">
                <a href="/index.php">← Вернуться на главную</a>
            </div>
        </div>
    </div>
</body>
</html>
