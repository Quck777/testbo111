<?php
/**
 * WindLand - Основной интерфейс игры
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/configs/config.php');

// Проверка авторизации
if (!isset($_COOKIE['uid']) || !isset($_COOKIE['hashcode'])) {
    header('Location: /game.php');
    exit;
}

$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
$uid = (int)$_COOKIE['uid'];

// Получение данных пользователя
$user = $db->sqla("SELECT * FROM `users` WHERE `uid` = $uid LIMIT 1");

if (!$user) {
    setcookie('uid', '', time() - 3600, '/');
    setcookie('hashcode', '', time() - 3600, '/');
    header('Location: /game.php');
    exit;
}

if (!empty($user['block'])) {
    setcookie('uid', '', time() - 3600, '/');
    setcookie('hashcode', '', time() - 3600, '/');
    die('<h1>Ваш аккаунт заблокирован.</h1><a href="/index.php">На главную</a>');
}

// Обновление статуса онлайн
$online_time = time();
$db->sql("UPDATE `users` SET `online` = $online_time WHERE `uid` = $uid");

// Определение текущей локации
$location_id = (int)($user['mapid'] ?? 1);
$location = $db->sqla("SELECT * FROM `locations` WHERE `id` = $location_id LIMIT 1");

// Получение инвентаря
$inventory = [];
$inv_result = $db->sql("SELECT * FROM `inventory` WHERE `uid` = $uid");
while ($row = $inv_result->fetch_assoc()) {
    $inventory[] = $row;
}

// Статистика
$hp_percent = ($user['max_hp'] > 0) ? round(($user['hp'] / $user['max_hp']) * 100) : 0;
$mp_percent = ($user['max_mp'] > 0) ? round(($user['mp'] / $user['max_mp']) * 100) : 0;
$exp_percent = ($user['next_exp'] > 0) ? round(($user['exp'] / $user['next_exp']) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>WindLand - Игра</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/main_v2.css"/>
    <link rel="stylesheet" type="text/css" href="./css/ch_main_v2.css"/>
    <script type="text/javascript" src="./js/mod/jquery.js"></script>
    <script type="text/javascript" src="./js/game_v2.js"></script>
</head>
<body>
<div id="game-container">
    <!-- Верхняя панель -->
    <div id="top-bar">
        <div class="user-info">
            <span class="username"><?= htmlspecialchars($user['user']) ?></span>
            <span class="level">Уровень: <?= (int)$user['level'] ?></span>
        </div>
        <div class="resources">
            <span>Золото: <strong><?= (int)$user['gold'] ?></strong></span>
            <span>Банк: <strong><?= (int)$user['bank'] ?></strong></span>
        </div>
        <div class="nav-links">
            <a href="/self.php">Персонаж</a> |
            <a href="/inv.php">Инвентарь</a> |
            <a href="/map.php">Карта</a> |
            <a href="/clan.php">Клан</a> |
            <a href="/msg.php">Почта</a> |
            <a href="/exit.php">Выход</a>
        </div>
    </div>

    <!-- Основная область -->
    <div id="main-area">
        <!-- Левая колонка - Статы -->
        <div id="left-panel">
            <div class="stat-block">
                <h3>Здоровье</h3>
                <div class="bar-container">
                    <div class="bar hp-bar" style="width: <?= $hp_percent ?>%"></div>
                </div>
                <span><?= (int)$user['hp'] ?> / <?= (int)$user['max_hp'] ?></span>
            </div>

            <div class="stat-block">
                <h3>Мана</h3>
                <div class="bar-container">
                    <div class="bar mp-bar" style="width: <?= $mp_percent ?>%"></div>
                </div>
                <span><?= (int)$user['mp'] ?> / <?= (int)$user['max_mp'] ?></span>
            </div>

            <div class="stat-block">
                <h3>Опыт</h3>
                <div class="bar-container">
                    <div class="bar exp-bar" style="width: <?= $exp_percent ?>%"></div>
                </div>
                <span><?= (int)$user['exp'] ?> / <?= (int)$user['next_exp'] ?></span>
            </div>

            <div class="stats-details">
                <h3>Характеристики</h3>
                <ul>
                    <li>Сила: <strong><?= (int)$user['str'] ?></strong></li>
                    <li>Ловкость: <strong><?= (int)$user['agi'] ?></strong></li>
                    <li>Интеллект: <strong><?= (int)$user['int'] ?></strong></li>
                    <li>Живучесть: <strong><?= (int)$user['vit'] ?></strong></li>
                    <li>Свободные очки: <strong><?= (int)$user['free_stat'] ?></strong></li>
                </ul>
            </div>
        </div>

        <!-- Центральная область - Локация -->
        <div id="center-panel">
            <div class="location-info">
                <h2><?= htmlspecialchars($location['name'] ?? 'Неизвестная локация') ?></h2>
                <?php if (!empty($location['description'])): ?>
                    <p><?= nl2br(htmlspecialchars($location['description'])) ?></p>
                <?php endif; ?>
            </div>

            <div class="location-actions">
                <h3>Действия</h3>
                <div class="action-buttons">
                    <a href="/fight.php" class="btn">Атаковать</a>
                    <a href="/fish.php" class="btn">Рыбалка</a>
                    <a href="/alh.php" class="btn">Алхимия</a>
                    <a href="/lavka.php" class="btn">Лавка</a>
                    <a href="/taverna.php" class="btn">Таверна</a>
                </div>
            </div>

            <div class="chat-area">
                <h3>Чат</h3>
                <div id="chat-messages"></div>
                <form id="chat-form">
                    <input type="text" id="chat-input" placeholder="Введите сообщение...">
                    <button type="submit">Отправить</button>
                </form>
            </div>
        </div>

        <!-- Правая колонка - Информация -->
        <div id="right-panel">
            <div class="info-block">
                <h3>Онлайн</h3>
                <?php
                $online_count = $db->sqlr("SELECT COUNT(*) FROM `users` WHERE `online` > " . (time() - 300));
                ?>
                <p>Игроков онлайн: <strong><?= (int)$online_count ?></strong></p>
            </div>

            <div class="info-block">
                <h3>Время</h3>
                <p><?= date('d.m.Y H:i:s') ?></p>
            </div>

            <div class="info-block">
                <h3>Новости</h3>
                <ul class="news-list">
                    <li>Добро пожаловать в WindLand!</li>
                    <li>Версия 2.0 с улучшенной производительностью</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Нижняя панель -->
    <div id="bottom-bar">
        <p>&copy; <?= date('Y') ?> WindLand. Все права защищены.</p>
    </div>
</div>

<script>
    // Автообновление времени
    setInterval(function() {
        var now = new Date();
        var timeString = now.toLocaleDateString('ru-RU') + ' ' + now.toLocaleTimeString('ru-RU');
        document.querySelector('#right-panel .info-block:nth-child(2) p').textContent = timeString;
    }, 1000);
</script>
</body>
</html>
