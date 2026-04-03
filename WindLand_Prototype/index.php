<?php
/**
 * WindLand Prototype - PHP 7.4+ / UTF-8 / MySQLi
 * Единый файл для быстрого запуска прототипа
 */

// Настройки
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Укажите ваш пароль
define('DB_NAME', 'windland_proto');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

// Заголовок UTF-8
header('Content-Type: text/html; charset=utf-8');

// Сессия
session_start();

// Подключение к БД
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);
if ($mysqli->connect_error) {
    die("Ошибка подключения к MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Создание БД и таблиц если нет
$db_created = false;
$result = $mysqli->query("SHOW DATABASES LIKE '$DB_NAME'");
if (!$result || $result->num_rows == 0) {
    $mysqli->query("CREATE DATABASE `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db_created = true;
}
$mysqli->select_db(DB_NAME);

// Схема БД
$schema = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    level INT DEFAULT 1,
    exp INT DEFAULT 0,
    gold INT DEFAULT 100,
    hp INT DEFAULT 100,
    max_hp INT DEFAULT 100,
    location_id INT DEFAULT 1,
    avatar VARCHAR(255) DEFAULT 'no_avatar.png',
    reg_date INT,
    last_visit INT
);

CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT 'loc_default.png',
    parent_id INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('weapon','armor','potion','misc') DEFAULT 'misc',
    price INT DEFAULT 0,
    image VARCHAR(255) DEFAULT 'item_default.png'
);

CREATE TABLE IF NOT EXISTS user_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    count INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    date INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
";

foreach (explode(';', $schema) as $query) {
    $query = trim($query);
    if (!empty($query)) {
        $mysqli->query($query);
    }
}

// Добавим тестовые локации если пусто
$loc_check = $mysqli->query("SELECT COUNT(*) as c FROM locations");
$row = $loc_check->fetch_assoc();
if ($row['c'] == 0) {
    $mysqli->query("INSERT INTO locations (name, description, image, parent_id) VALUES 
    ('Город', 'Центральный город Виндленда. Здесь безопасно.', 'city_center.png', 0),
    ('Лес', 'Темный лес, полный опасностей.', 'forest.png', 1),
    ('Пещера', 'Мрачная пещера с сокровищами.', 'cave.png', 1),
    ('Таверна', 'Место отдыха путешественников.', 'tavern.png', 1)");
    
    // Добавим тестовые предметы
    $mysqli->query("INSERT INTO items (name, type, price, image) VALUES 
    ('Ржавый меч', 'weapon', 10, 'sword_rust.png'),
    ('Зелье лечения', 'potion', 5, 'potion_hp.png'),
    ('Кожаная броня', 'armor', 20, 'armor_leather.png')");
}

// Функции
function redirect($url) {
    header("Location: $url");
    exit;
}

function get_user($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Обработка действий
$action = $_GET['act'] ?? '';
$message = '';

// Регистрация
if ($action == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $pass = $_POST['pass'];
    $email = trim($_POST['email']);
    
    if (strlen($login) < 3 || strlen($pass) < 3) {
        $message = "Логин и пароль должны быть длиннее 3 символов";
    } else {
        $check = $mysqli->prepare("SELECT id FROM users WHERE login = ?");
        $check->bind_param("s", $login);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $message = "Такой логин уже занят";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $time = time();
            $stmt = $mysqli->prepare("INSERT INTO users (login, password, email, reg_date, last_visit) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $login, $hash, $email, $time, $time);
            if ($stmt->execute()) {
                $message = "Регистрация успешна! Теперь войдите.";
                $action = '';
            } else {
                $message = "Ошибка регистрации: " . $mysqli->error;
            }
        }
    }
}

// Вход
if ($action == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $pass = $_POST['pass'];
    
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $mysqli->query("UPDATE users SET last_visit = " . time() . " WHERE id = " . $user['id']);
        redirect('?page=main');
    } else {
        $message = "Неверный логин или пароль";
    }
}

// Выход
if ($action == 'logout') {
    session_destroy();
    redirect('?');
}

// Отправка сообщения в чат
if ($action == 'chat_send' && isset($_SESSION['user_id'])) {
    $msg = trim($_POST['message']);
    if (!empty($msg)) {
        $uid = (int)$_SESSION['user_id'];
        $time = time();
        $stmt = $mysqli->prepare("INSERT INTO chat (user_id, message, date) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $uid, $msg, $time);
        $stmt->execute();
    }
    redirect('?page=main');
}

// Перемещение
if ($action == 'move' && isset($_SESSION['user_id'])) {
    $loc_id = (int)$_GET['loc'];
    $uid = (int)$_SESSION['user_id'];
    $stmt = $mysqli->prepare("UPDATE users SET location_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $loc_id, $uid);
    $stmt->execute();
    redirect('?page=main');
}

// Получение текущего пользователя
$current_user = null;
if (isset($_SESSION['user_id'])) {
    $current_user = get_user($_SESSION['user_id']);
    if (!$current_user) {
        session_destroy();
        redirect('?');
    }
}

// Рендеринг страницы
$page = $_GET['page'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WindLand - Новая Эра</title>
    <style>
        body { font-family: 'Verdana', sans-serif; background: #1a1a1a; color: #ccc; margin: 0; padding: 0; }
        a { color: #ffd700; text-decoration: none; }
        a:hover { text-decoration: underline; color: #fff; }
        .container { max-width: 900px; margin: 0 auto; background: #2b2b2b; min-height: 100vh; display: flex; flex-direction: column; }
        .header { background: #333; padding: 10px; border-bottom: 2px solid #ffd700; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: bold; color: #ffd700; }
        .content { flex: 1; padding: 20px; display: flex; gap: 20px; }
        .sidebar { width: 200px; background: #222; padding: 10px; border-radius: 5px; }
        .main-area { flex: 1; background: #222; padding: 15px; border-radius: 5px; }
        .chat-box { height: 200px; overflow-y: auto; background: #111; border: 1px solid #444; padding: 10px; margin-top: 10px; }
        .chat-msg { margin-bottom: 5px; border-bottom: 1px solid #333; padding-bottom: 2px; }
        .chat-author { color: #ffd700; font-weight: bold; }
        .chat-date { font-size: 0.8em; color: #666; }
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 8px; margin: 5px 0; background: #333; border: 1px solid #555; color: #fff; box-sizing: border-box; }
        button { background: #ffd700; color: #000; border: none; padding: 8px 15px; cursor: pointer; font-weight: bold; }
        button:hover { background: #ffed4a; }
        .loc-img { max-width: 100%; height: auto; border: 2px solid #444; margin-bottom: 10px; display: block; }
        .nav-links a { display: block; margin: 5px 0; padding: 5px; background: #333; border-radius: 3px; }
        .nav-links a:hover { background: #444; text-decoration: none; }
        .stat-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .hp-bar { width: 100%; background: #444; height: 10px; border-radius: 5px; overflow: hidden; margin-top: 2px; }
        .hp-fill { height: 100%; background: #d00; width: 100%; }
        .form-box { max-width: 400px; margin: 50px auto; background: #333; padding: 20px; border-radius: 8px; border: 1px solid #555; }
        .error { color: #f55; background: #300; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .success { color: #5f5; background: #030; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .inv-item { display: inline-block; margin: 5px; padding: 5px; background: #333; border: 1px solid #555; text-align: center; width: 80px; }
        .inv-item img { width: 32px; height: 32px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">WindLand <span style="font-size:12px;color:#aaa;">Prototype</span></div>
        <div>
            <?php if ($current_user): ?>
                Привет, <b><?= htmlspecialchars($current_user['login']) ?></b> | 
                <a href="?act=logout">Выход</a>
            <?php else: ?>
                <a href="?">Вход</a> | <a href="?page=reg">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <?php if ($current_user): ?>
        <!-- Левая панель (Профиль) -->
        <div class="sidebar">
            <div style="text-align:center; margin-bottom:15px;">
                <img src="public_content/avatars/<?= htmlspecialchars($current_user['avatar']) ?>" 
                     onerror="this.src='public_content/avatars/no_avatar.png'" 
                     style="width:80px; height:80px; border:2px solid #ffd700; border-radius:50%;">
                <div style="margin-top:5px; font-weight:bold;"><?= htmlspecialchars($current_user['login']) ?></div>
                <div style="font-size:12px; color:#aaa;">Уровень <?= $current_user['level'] ?></div>
            </div>
            
            <div class="stat-row"><span>HP:</span> <span><?= $current_user['hp'] ?>/<?= $current_user['max_hp'] ?></span></div>
            <div class="hp-bar"><div class="hp-fill" style="width: <?= ($current_user['hp']/$current_user['max_hp'])*100 ?>%"></div></div>
            
            <div class="stat-row" style="margin-top:10px;"><span>Золото:</span> <span style="color:#ffd700"><?= $current_user['gold'] ?></span></div>
            <div class="stat-row"><span>Опыт:</span> <span><?= $current_user['exp'] ?></span></div>
            
            <hr style="border-color:#444;">
            <div class="nav-links">
                <a href="?page=main">🏠 Главная</a>
                <a href="?page=inventory">🎒 Инвентарь</a>
                <a href="?page=shop">🏪 Лавка</a>
                <a href="?page=profile">⚙️ Профиль</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Основная область -->
        <div class="main-area">
            <?php if ($message): ?>
                <div class="<?= strpos($message, 'Ошибка') === false ? 'success' : 'error' ?>"><?= $message ?></div>
            <?php endif; ?>

            <?php if (!$current_user && $page != 'reg'): ?>
                <!-- Страница входа -->
                <div class="form-box">
                    <h2 style="text-align:center; color:#ffd700;">Вход в игру</h2>
                    <form method="POST" action="?act=login">
                        <label>Логин:</label>
                        <input type="text" name="login" required>
                        <label>Пароль:</label>
                        <input type="password" name="pass" required>
                        <button type="submit" style="width:100%; margin-top:10px;">Войти</button>
                    </form>
                    <div style="text-align:center; margin-top:10px;">
                        Нет аккаунта? <a href="?page=reg">Зарегистрироваться</a>
                    </div>
                </div>

            <?php elseif ($page == 'reg'): ?>
                <!-- Страница регистрации -->
                <div class="form-box">
                    <h2 style="text-align:center; color:#ffd700;">Регистрация</h2>
                    <form method="POST" action="?act=register">
                        <label>Логин:</label>
                        <input type="text" name="login" required>
                        <label>Email:</label>
                        <input type="email" name="email" required>
                        <label>Пароль:</label>
                        <input type="password" name="pass" required>
                        <button type="submit" style="width:100%; margin-top:10px;">Создать персонажа</button>
                    </form>
                    <div style="text-align:center; margin-top:10px;">
                        Уже есть аккаунт? <a href="?">Войти</a>
                    </div>
                </div>

            <?php elseif ($page == 'main' && $current_user): ?>
                <!-- Игровая страница -->
                <?php
                $loc_stmt = $mysqli->prepare("SELECT * FROM locations WHERE id = ?");
                $loc_stmt->bind_param("i", $current_user['location_id']);
                $loc_stmt->execute();
                $location = $loc_stmt->get_result()->fetch_assoc();
                ?>
                
                <h2 style="color:#ffd700; margin-top:0;"><?= htmlspecialchars($location['name']) ?></h2>
                
                <!-- Картинка локации -->
                <img src="public_content/locations/<?= htmlspecialchars($location['image']) ?>" 
                     onerror="this.src='public_content/locations/loc_default.png'" 
                     class="loc-img" alt="Location">
                
                <p><?= nl2br(htmlspecialchars($location['description'])) ?></p>
                
                <h3>Переходы:</h3>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <?php
                    // Показать переходы (родитель и дети)
                    $parent_id = (int)$location['parent_id'];
                    if ($parent_id > 0) {
                        $p_stmt = $mysqli->prepare("SELECT id, name FROM locations WHERE id = ?");
                        $p_stmt->bind_param("i", $parent_id);
                        $p_stmt->execute();
                        $parent = $p_stmt->get_result()->fetch_assoc();
                        if ($parent) echo "<a href='?act=move&loc={$parent['id']}'><button>⬅️ {$parent['name']}</button></a>";
                    }
                    
                    $child_stmt = $mysqli->prepare("SELECT id, name FROM locations WHERE parent_id = ?");
                    $child_stmt->bind_param("i", $location['id']);
                    $child_stmt->execute();
                    $children = $child_stmt->get_result();
                    while ($child = $children->fetch_assoc()) {
                        echo "<a href='?act=move&loc={$child['id']}'><button>➡️ {$child['name']}</button></a>";
                    }
                    ?>
                </div>

                <h3 style="margin-top:20px;">Чат локации</h3>
                <div class="chat-box">
                    <?php
                    $chat_stmt = $mysqli->query("SELECT c.message, c.date, u.login FROM chat c JOIN users u ON c.user_id = u.id ORDER BY c.date DESC LIMIT 20");
                    while ($msg = $chat_stmt->fetch_assoc()): ?>
                        <div class="chat-msg">
                            <span class="chat-date">[<?= date('H:i', $msg['date']) ?>]</span>
                            <span class="chat-author"><?= htmlspecialchars($msg['login']) ?>:</span>
                            <?= htmlspecialchars($msg['message']) ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <form method="POST" action="?act=chat_send" style="margin-top:10px; display:flex;">
                    <input type="text" name="message" placeholder="Сообщение..." required style="flex:1;">
                    <button type="submit" style="margin-left:5px;">Send</button>
                </form>

            <?php elseif ($page == 'inventory' && $current_user): ?>
                <h2 style="color:#ffd700;">Инвентарь</h2>
                <div style="display:flex; flex-wrap:wrap;">
                    <?php
                    $inv_stmt = $mysqli->prepare("SELECT ui.count, i.name, i.image, i.type FROM user_items ui JOIN items i ON ui.item_id = i.id WHERE ui.user_id = ?");
                    $inv_stmt->bind_param("i", $current_user['id']);
                    $inv_stmt->execute();
                    $items = $inv_stmt->get_result();
                    if ($items->num_rows == 0) echo "<p>Ваш инвентарь пуст.</p>";
                    while ($item = $items->fetch_assoc()): ?>
                        <div class="inv-item">
                            <img src="public_content/items/<?= htmlspecialchars($item['image']) ?>" 
                                 onerror="this.src='public_content/items/item_default.png'">
                            <div style="font-size:11px;"><?= htmlspecialchars($item['name']) ?></div>
                            <div style="font-size:10px; color:#aaa;">x<?= $item['count'] ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>

            <?php elseif ($page == 'profile' && $current_user): ?>
                <h2 style="color:#ffd700;">Профиль персонажа</h2>
                <table style="width:100%; border-collapse:collapse;">
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Логин:</td><td><?= htmlspecialchars($current_user['login']) ?></td></tr>
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Email:</td><td><?= htmlspecialchars($current_user['email']) ?></td></tr>
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Уровень:</td><td><?= $current_user['level'] ?></td></tr>
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Опыт:</td><td><?= $current_user['exp'] ?></td></tr>
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Золото:</td><td><?= $current_user['gold'] ?></td></tr>
                    <tr><td style="padding:5px; border-bottom:1px solid #444;">Дата регистрации:</td><td><?= date('d.m.Y H:i', $current_user['reg_date']) ?></td></tr>
                </table>
            
            <?php else: ?>
                <p>Страница не найдена или доступна только авторизованным.</p>
                <a href="?page=main">Вернуться на главную</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div style="background:#222; padding:10px; text-align:center; font-size:12px; color:#666;">
        &copy; <?= date('Y') ?> WindLand Prototype. All rights reserved.
    </div>
</div>
</body>
</html>
