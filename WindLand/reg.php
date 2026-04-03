<?php
/**
 * WindLand - Страница регистрации
 * Версия: 2.0 (PHP 7.4+, UTF-8)
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/configs/config.php');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $pass_confirm = $_POST['pass_confirm'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $sex = (int)($_POST['sex'] ?? 0);
    $race = (int)($_POST['race'] ?? 0);
    $referal = (int)($_COOKIE['RefererReg'] ?? 0);

    // Валидация
    if (strlen($user) < 3 || strlen($user) > 20) {
        $errors[] = 'Имя пользователя должно быть от 3 до 20 символов.';
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/u', $user)) {
        $errors[] = 'Имя пользователя может содержать только буквы, цифры и подчеркивание.';
    }

    if (strlen($pass) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов.';
    }

    if ($pass !== $pass_confirm) {
        $errors[] = 'Пароли не совпадают.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email адрес.';
    }

    if (empty($errors)) {
        $db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);

        // Проверка существования пользователя
        $existing = $db->sqla("SELECT `uid` FROM `users` WHERE `user` = ? OR `email` = ?", __FILE__, __LINE__);
        $stmt = $db->base->prepare("SELECT `uid` FROM `users` WHERE `user` = ? OR `email` = ?");
        $stmt->bind_param("ss", $user, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Пользователь с таким именем или email уже существует.';
        } else {
            // Регистрация
            $hashed_pass = md5($pass);
            $smuser = mb_strtolower($user, 'UTF-8');
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $reg_date = time();

            $stmt = $db->base->prepare("
                INSERT INTO `users` 
                (`user`, `pass`, `email`, `smuser`, `sex`, `race`, `hp`, `max_hp`, `mp`, `max_mp`, `str`, `agi`, `int`, `vit`, `ip`, `reg_date`, `lastom`, `online`) 
                VALUES (?, ?, ?, ?, ?, ?, 100, 100, 50, 50, 10, 10, 10, 10, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssiiiisi", $user, $hashed_pass, $email, $smuser, $sex, $race, $ip, $reg_date, $reg_date, $reg_date);

            if ($stmt->execute()) {
                $new_uid = $db->base->insert_id;
                $success = true;

                // Запись реферала
                if ($referal > 0) {
                    $stmt_ref = $db->base->prepare("INSERT INTO `referals` (`referrer_uid`, `referred_uid`, `registered`) VALUES (?, ?, ?)");
                    $stmt_ref->bind_param("iii", $referal, $new_uid, $reg_date);
                    $stmt_ref->execute();

                    // Обновление счетчика рефералов
                    $db->sql("UPDATE `users` SET `referal` = `referal` + 1 WHERE `uid` = $referal");
                }
            } else {
                $errors[] = 'Ошибка при регистрации. Попробуйте позже.';
            }
            $stmt->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>WindLand - Регистрация</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/index_v2.css"/>
    <script type="text/javascript" src="./js/mod/jquery.js"></script>
    <script type="text/javascript" src="./js/reg.js"></script>
</head>
<body>
<div class="reg-page">
    <div class="reg-container">
        <h1>Регистрация нового персонажа</h1>

        <?php if ($success): ?>
            <div class="success-message">
                <h2>Регистрация успешна!</h2>
                <p>Ваш персонаж <?= htmlspecialchars($user) ?> создан.</p>
                <p><a href="/game.php">Войти в игру</a></p>
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="user">Имя персонажа *</label>
                    <input type="text" id="user" name="user" required maxlength="20" value="<?= htmlspecialchars($user ?? '') ?>">
                    <small>От 3 до 20 символов, только буквы, цифры и _</small>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="pass">Пароль *</label>
                    <input type="password" id="pass" name="pass" required minlength="6">
                    <small>Минимум 6 символов</small>
                </div>

                <div class="form-group">
                    <label for="pass_confirm">Подтверждение пароля *</label>
                    <input type="password" id="pass_confirm" name="pass_confirm" required minlength="6">
                </div>

                <div class="form-group">
                    <label>Пол *</label>
                    <label class="radio-label">
                        <input type="radio" name="sex" value="1" <?= !isset($sex) || $sex === 1 ? 'checked' : '' ?>> Мужской
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="sex" value="0" <?= isset($sex) && $sex === 0 ? 'checked' : '' ?>> Женский
                    </label>
                </div>

                <div class="form-group">
                    <label>Раса *</label>
                    <select name="race" required>
                        <option value="0" <?= !isset($race) || $race === 0 ? 'selected' : '' ?>>Человек</option>
                        <option value="1" <?= isset($race) && $race === 1 ? 'selected' : '' ?>>Эльф</option>
                        <option value="2" <?= isset($race) && $race === 2 ? 'selected' : '' ?>>Гном</option>
                        <option value="3" <?= isset($race) && $race === 3 ? 'selected' : '' ?>>Орк</option>
                    </select>
                </div>

                <?php if (!empty($_COOKIE['RefererReg'])): ?>
                    <div class="form-group">
                        <p>Вы были приглашены рефералом #<?= (int)$_COOKIE['RefererReg'] ?></p>
                    </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn-register">Зарегистрироваться</button>
                    <a href="/index.php" class="btn-cancel">Отмена</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
