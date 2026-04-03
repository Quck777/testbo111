<?php
/**
 * WindLand - Страница информации об игре
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/configs/config.php');
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);

// Получение статистики
$total_users = $db->sqlr("SELECT COUNT(*) FROM `users`");
$online_count = $db->sqlr("SELECT COUNT(*) FROM `users` WHERE `online` > " . (time() - 300));
$total_clans = $db->sqlr("SELECT COUNT(*) FROM `clans`");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>WindLand - Об игре</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/index_v2.css"/>
</head>
<body>
<div class="info-page">
    <div class="info-container">
        <h1>О игре WindLand</h1>

        <div class="info-section">
            <h2>Добро пожаловать в мир WindLand!</h2>
            <p>WindLand - это многопользовательская ролевая онлайн игра (MMORPG), где вы можете погрузиться в увлекательный фэнтезийный мир, полный приключений, сражений и тайн.</p>
        </div>

        <div class="info-section">
            <h2>Возможности игры</h2>
            <ul>
                <li><strong>Создание персонажа:</strong> Выберите расу и пол вашего героя, развивайте его характеристики</li>
                <li><strong>Боевая система:</strong> Участвуйте в пошаговых боях с монстрами и другими игроками</li>
                <li><strong>Кланы:</strong> Объединяйтесь с другими игроками, создавайте свои кланы</li>
                <li><strong>Экономика:</strong> Зарабатывайте золото, торгуйте предметами, покупайте экипировку</li>
                <li><strong>Профессии:</strong> Освойте алхимию, рыбалку, добычу ресурсов</li>
                <li><strong>Квесты:</strong> Выполняйте задания и получайте награды</li>
                <li><strong>PvP:</strong> Сражайтесь на арене с другими игроками</li>
            </ul>
        </div>

        <div class="info-section">
            <h2>Статистика сервера</h2>
            <table class="stats-table">
                <tr>
                    <td>Всего игроков:</td>
                    <td><strong><?= (int)$total_users ?></strong></td>
                </tr>
                <tr>
                    <td>Онлайн:</td>
                    <td><strong><?= (int)$online_count ?></strong></td>
                </tr>
                <tr>
                    <td>Всего кланов:</td>
                    <td><strong><?= (int)$total_clans ?></strong></td>
                </tr>
                <tr>
                    <td>Версия игры:</td>
                    <td><strong>2.0</strong></td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <h2>Техническая информация</h2>
            <p>Игра разработана на PHP 7.4+ с использованием базы данных MySQL и кодировкой UTF-8.</p>
            <p>Поддерживаемые браузеры: Chrome, Firefox, Safari, Edge (последние версии).</p>
        </div>

        <div class="info-links">
            <a href="/index.php" class="btn">На главную</a>
            <a href="/reg.php" class="btn">Регистрация</a>
            <a href="/speech.php" class="btn">Правила</a>
        </div>
    </div>
</div>
</body>
</html>
