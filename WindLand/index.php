<?php
/**
 * WindLand - Главная страница
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

define('MICROLOAD', true);

// Подключение конфигурации
include_once($_SERVER['DOCUMENT_ROOT'] . '/configs/config.php');

// Создание подключения к БД
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);

// Обработка реферера
$rid = !empty($_SERVER['QUERY_STRING']) ? abs(intval($_SERVER['QUERY_STRING'])) : false;
if ($rid !== false) {
    setcookie('RefererReg', (string)$rid, time() + 3600, '/');
}
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>WindLand - Онлайн игра</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Expires" content="3">
    <meta name="robots" content="ALL">
    <meta name="keywords" content="онлайн игра, рпг, браузерная игра, mmorpg">
    <meta name="description" content="WindLand - бесплатная браузерная онлайн игра в жанре MMORPG!">
    <meta name="rating" content="General">
    <meta name="distribution" content="GLOBAL">
    <meta name="Classification" content="On-line WindLand">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./css/index_v2.css"/>
    <script type="text/javascript" src="./js/mod/swfobject.js"></script>
    <script type="text/javascript" src="./js/mod/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('div.modal').click(function () {
                var modalid = $(this).attr('rel');
                $('#' + modalid).fadeIn(600);
                $('#fadebody').fadeIn(600);
                var topm = ($('#' + modalid).height() + 10) / 2;
                var leftm = ($('#' + modalid).width() + 10) / 2;
                $('#' + modalid).css({'margin-top': -topm, 'margin-left': -leftm});
                $('#fadebody, .close').click(function () {
                    $('#fadebody , .modalbox').fadeOut(600);
                    return false;
                });
            });

            $("#form_show").click(function () {
                url_open = 'reg.php';
                viewwin = open(url_open, "regWindow", "width=455, height=300, status=yes, toolbar=no, menubar=no, resizable=no, scrollbars=no");
                return false;
            });
        });

        function jgetForm() {
            if ($('#user').val() == '') {
                $('#user').focus();
                return;
            }
            if ($('#pass').val() == '') {
                $('#pass').focus();
                return;
            }
            var obj = document.getElementById('goGame');
            obj.setAttribute("action", "/game.php?");
            obj.setAttribute("method", "post");
            obj.submit();
        }
    </script>
</head>
<body>
<div id="main" class="body-main">
    <div class="wrapper">

        <div class="h-menu">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/info.php">Об игре</a></li>
                <li><a href="#" id="form_show">Регистрация</a></li>
                <li><a href="/speech.php">Правила</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="left-block">
                <div class="news-block">
                    <h2>Новости проекта</h2>
                    <div class="news-item">
                        <span class="date"><?= date('d.m.Y') ?></span>
                        <h3>Добро пожаловать в WindLand!</h3>
                        <p>Версия 2.0 - обновленный движок на PHP 7.4+ с поддержкой UTF-8.</p>
                    </div>
                </div>

                <div class="servers-stat">
                    <h2>Статистика сервера</h2>
                    <?php
                    $online = $db->sqlr("SELECT COUNT(*) FROM `users` WHERE `online` > " . (time() - 300));
                    $total_users = $db->sqlr("SELECT COUNT(*) FROM `users`");
                    ?>
                    <p>Онлайн: <strong><?= (int)$online ?></strong></p>
                    <p>Всего игроков: <strong><?= (int)$total_users ?></strong></p>
                </div>
            </div>

            <div class="right-block">
                <div class="login-form">
                    <h2>Вход в игру</h2>
                    <form id="goGame" action="/game.php?" method="post">
                        <label>Персонаж:</label>
                        <input type="text" name="user" id="user" class="input-text"/>
                        <label>Пароль:</label>
                        <input type="password" name="pass" id="pass" class="input-text"/>
                        <button type="button" onclick="jgetForm()" class="btn-enter">Войти</button>
                    </form>
                    <div class="reg-link">
                        <a href="#" id="form_show2">Нет аккаунта? Зарегистрируйтесь!</a>
                    </div>
                </div>

                <div class="game-info">
                    <h2>О игре</h2>
                    <p>WindLand - это многопользовательская ролевая онлайн игра, где вы можете:</p>
                    <ul>
                        <li>Создать уникального персонажа</li>
                        <li>Участвовать в эпических сражениях</li>
                        <li>Вступать в кланы и заводить друзей</li>
                        <li>Выполнять квесты и исследовать мир</li>
                        <li>Развивать навыки и собирать экипировку</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?= date('Y') ?> WindLand. Все права защищены.</p>
        </div>

    </div>
</div>

<div id="fadebody" class="fadebody"></div>

</body>
</html>
