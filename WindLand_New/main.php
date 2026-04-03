<?php
/**
 * WindLand - Главная игровая страница
 * PHP 7.4+ | UTF-8
 */

define('MICROLOAD', true);
require_once __DIR__ . '/configs/config.php';

$db = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_BASE);

// Проверка авторизации
$userId = (int)($_COOKIE['user_id'] ?? 0);
$userLogin = $_COOKIE['user_login'] ?? '';
$userHash = $_COOKIE['user_hash'] ?? '';

if (!$userId || !$userLogin || !$userHash) {
    header('Location: /index.php');
    exit;
}

// Получение данных пользователя
$user = $db->getRow("SELECT * FROM users WHERE id = $userId");

if (!$user || $user['login'] !== $userLogin || md5($user['password'] . 'SALT') !== $userHash) {
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_login', '', time() - 3600, '/');
    setcookie('user_hash', '', time() - 3600, '/');
    header('Location: /index.php');
    exit;
}

// Обновление времени последнего визита
$db->query("UPDATE users SET last_visit = " . time() . " WHERE id = $userId");

// Получение инвентаря
$inventory = $db->getAll("SELECT i.*, it.name as item_name, it.image, it.type 
                          FROM inventory i 
                          JOIN items it ON i.item_id = it.id 
                          WHERE i.user_id = $userId AND i.count > 0");

// Получение локации
$location = $db->getRow("SELECT * FROM locations WHERE name = '" . $db->escape($user['location']) . "'");
if (!$location) {
    $location = $db->getRow("SELECT * FROM locations LIMIT 1");
}

// Получение онлайн игроков
$onlineCount = $db->getOne("SELECT COUNT(*) FROM users WHERE is_online = 1");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WindLand - Игра</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #0a0a15;
            color: #fff;
            min-height: 100vh;
        }
        .game-container {
            display: grid;
            grid-template-columns: 250px 1fr 300px;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 15px 20px;
            border-bottom: 2px solid #ffd700;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #ffd700; font-size: 24px; }
        .header-info { display: flex; gap: 20px; }
        .stat { background: rgba(255,215,0,0.1); padding: 5px 15px; border-radius: 5px; }
        .stat span { color: #ffd700; font-weight: bold; }
        
        /* Left Panel */
        .left-panel {
            background: rgba(0,0,0,0.5);
            padding: 20px;
            border-right: 1px solid #333;
        }
        .avatar {
            width: 150px;
            height: 150px;
            background: #222;
            border: 3px solid #ffd700;
            border-radius: 10px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }
        .char-name { text-align: center; color: #ffd700; font-size: 18px; margin-bottom: 20px; }
        .stats-block { background: rgba(255,255,255,0.05); padding: 15px; border-radius: 5px; }
        .stat-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #333; }
        .stat-row:last-child { border-bottom: none; }
        .stat-label { color: #aaa; }
        .stat-value { color: #fff; font-weight: bold; }
        
        /* Main Content */
        .main-content {
            padding: 20px;
            background: url('/public_content/images/locations/<?= htmlspecialchars($location['image'] ?? 'city.png') ?>') center/cover;
            position: relative;
        }
        .main-content::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
        }
        .content-inner { position: relative; z-index: 1; }
        .location-title { 
            font-size: 28px; 
            color: #ffd700; 
            margin-bottom: 20px; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        .location-desc { 
            background: rgba(0,0,0,0.7); 
            padding: 20px; 
            border-radius: 10px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .action-btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .action-btn:hover { transform: scale(1.05); }
        
        /* Right Panel */
        .right-panel {
            background: rgba(0,0,0,0.5);
            padding: 20px;
            border-left: 1px solid #333;
            overflow-y: auto;
        }
        .panel-title { color: #ffd700; font-size: 18px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #ffd700; }
        .inventory-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        .inv-item {
            width: 50px;
            height: 50px;
            background: #222;
            border: 1px solid #444;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            position: relative;
        }
        .inv-item:hover { border-color: #ffd700; }
        .inv-count {
            position: absolute;
            bottom: 2px;
            right: 2px;
            font-size: 10px;
            color: #ffd700;
        }
        .chat-box {
            margin-top: 20px;
            background: rgba(0,0,0,0.5);
            border-radius: 5px;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }
        .chat-message { padding: 5px 0; border-bottom: 1px solid #333; font-size: 13px; }
        .chat-time { color: #666; font-size: 11px; }
        .chat-input { display: flex; gap: 10px; margin-top: 10px; }
        .chat-input input { flex: 1; padding: 8px; border: 1px solid #444; border-radius: 3px; background: #222; color: #fff; }
        .chat-input button { padding: 8px 15px; background: #ffd700; border: none; border-radius: 3px; cursor: pointer; }
        
        /* Footer */
        .footer {
            grid-column: 1 / -1;
            background: #1a1a2e;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #333;
            color: #666;
        }
        
        .hp-bar, .mana-bar {
            width: 100%;
            height: 20px;
            background: #333;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 5px;
        }
        .hp-fill { height: 100%; background: linear-gradient(90deg, #ff4444, #ff6666); }
        .mana-fill { height: 100%; background: linear-gradient(90deg, #4444ff, #6666ff); }
    </style>
</head>
<body>
    <div class="game-container">
        <!-- Header -->
        <div class="header">
            <h1>🏰 WindLand</h1>
            <div class="header-info">
                <div class="stat">💰 <span><?= number_format($user['gold']) ?></span></div>
                <div class="stat">⭐ <span>Lvl. <?= $user['level'] ?></span></div>
                <div class="stat">👥 <span><?= $onlineCount ?> онлайн</span></div>
                <div class="stat">📍 <span><?= htmlspecialchars($location['name']) ?></span></div>
            </div>
        </div>
        
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="avatar">
                <?= $user['gender'] === 'female' ? '👸' : '🧙' ?>
            </div>
            <div class="char-name"><?= htmlspecialchars($user['login']) ?></div>
            
            <div class="stats-block">
                <div class="stat-row">
                    <span class="stat-label">❤️ Здоровье</span>
                    <span class="stat-value"><?= $user['hp'] ?>/<?= $user['max_hp'] ?></span>
                </div>
                <div class="hp-bar"><div class="hp-fill" style="width: <?= ($user['hp']/$user['max_hp'])*100 ?>%"></div></div>
                
                <div class="stat-row" style="margin-top: 15px;">
                    <span class="stat-label">💙 Мана</span>
                    <span class="stat-value"><?= $user['mana'] ?>/<?= $user['max_mana'] ?></span>
                </div>
                <div class="mana-bar"><div class="mana-fill" style="width: <?= ($user['mana']/$user['max_mana'])*100 ?>%"></div></div>
                
                <div class="stat-row" style="margin-top: 15px;">
                    <span class="stat-label">✨ Опыт</span>
                    <span class="stat-value"><?= number_format($user['exp']) ?></span>
                </div>
                
                <hr style="border-color: #333; margin: 15px 0;">
                
                <div class="stat-row">
                    <span class="stat-label">💪 Сила</span>
                    <span class="stat-value"><?= $user['strength'] ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">🏃 Ловкость</span>
                    <span class="stat-value"><?= $user['agility'] ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">🧠 Интеллект</span>
                    <span class="stat-value"><?= $user['intelligence'] ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">❤️ Жизнеспособность</span>
                    <span class="stat-value"><?= $user['vitality'] ?></span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">🍀 Удача</span>
                    <span class="stat-value"><?= $user['luck'] ?></span>
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <a href="/exit.php" class="action-btn" style="display:block; text-align:center;">🚪 Выход</a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-inner">
                <h2 class="location-title">📍 <?= htmlspecialchars($location['name']) ?></h2>
                <div class="location-desc">
                    <?= nl2br(htmlspecialchars($location['description'])) ?>
                </div>
                
                <div class="actions">
                    <?php if ($location['has_monsters']): ?>
                        <a href="/fight.php" class="action-btn">⚔️ В бой!</a>
                    <?php endif; ?>
                    
                    <?php if ($location['has_shop']): ?>
                        <a href="/shop.php" class="action-btn">🏪 Магазин</a>
                    <?php endif; ?>
                    
                    <?php if ($location['has_bank']): ?>
                        <a href="/bank.php" class="action-btn">🏦 Банк</a>
                    <?php endif; ?>
                    
                    <?php if ($location['has_arena']): ?>
                        <a href="/arena.php" class="action-btn">🏟️ Арена</a>
                    <?php endif; ?>
                    
                    <a href="/map.php" class="action-btn">🗺️ Карта</a>
                    <a href="/profile.php" class="action-btn">👤 Профиль</a>
                    <a href="/msg.php" class="action-btn">✉️ Почта</a>
                </div>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="right-panel">
            <div class="panel-title">🎒 Инвентарь</div>
            <div class="inventory-grid">
                <?php foreach ($inventory as $item): ?>
                    <div class="inv-item" title="<?= htmlspecialchars($item['item_name']) ?>">
                        📦
                        <?php if ($item['count'] > 1): ?>
                            <span class="inv-count"><?= $item['count'] ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php for ($i = count($inventory); $i < 20; $i++): ?>
                    <div class="inv-item"></div>
                <?php endfor; ?>
            </div>
            
            <div class="panel-title" style="margin-top: 30px;">💬 Чат</div>
            <div class="chat-box" id="chatBox">
                <div class="chat-message">
                    <span class="chat-time">[<?= date('H:i') ?>]</span>
                    <span style="color: #ffd700;">Система:</span> Добро пожаловать в WindLand!
                </div>
            </div>
            <div class="chat-input">
                <input type="text" id="chatMsg" placeholder="Сообщение...">
                <button onclick="sendChat()">➤</button>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            &copy; <?= date('Y') ?> WindLand | PHP <?= PHP_VERSION ?> | Онлайн: <?= $onlineCount ?>
        </div>
    </div>
    
    <script>
        function sendChat() {
            const input = document.getElementById('chatMsg');
            if (input.value.trim()) {
                // Здесь будет AJAX отправка
                console.log('Отправка:', input.value);
                input.value = '';
            }
        }
        
        // Автообновление каждые 30 секунд
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
