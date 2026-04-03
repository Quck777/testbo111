-- WindLand Database Schema
-- PHP 7.4+ | UTF-8 (utf8mb4)

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `windland_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `windland_db`;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `login` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `reg_date` INT UNSIGNED DEFAULT 0,
    `last_visit` INT UNSIGNED DEFAULT 0,
    `level` TINYINT UNSIGNED DEFAULT 1,
    `exp` BIGINT UNSIGNED DEFAULT 0,
    `gold` BIGINT UNSIGNED DEFAULT 0,
    `bank_gold` BIGINT UNSIGNED DEFAULT 0,
    `hp` INT UNSIGNED DEFAULT 100,
    `max_hp` INT UNSIGNED DEFAULT 100,
    `mana` INT UNSIGNED DEFAULT 100,
    `max_mana` INT UNSIGNED DEFAULT 100,
    `strength` INT UNSIGNED DEFAULT 10,
    `agility` INT UNSIGNED DEFAULT 10,
    `intelligence` INT UNSIGNED DEFAULT 10,
    `vitality` INT UNSIGNED DEFAULT 10,
    `luck` INT UNSIGNED DEFAULT 10,
    `class` VARCHAR(50) DEFAULT 'newbie',
    `gender` ENUM('male', 'female') DEFAULT 'male',
    `avatar` VARCHAR(255) DEFAULT '/images/no_avatar.png',
    `clan_id` INT UNSIGNED DEFAULT 0,
    `location` VARCHAR(100) DEFAULT 'start',
    `is_online` TINYINT UNSIGNED DEFAULT 0,
    `ip` VARCHAR(45) DEFAULT NULL,
    `ban_until` INT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `login` (`login`),
    KEY `clan_id` (`clan_id`),
    KEY `is_online` (`is_online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица кланов
CREATE TABLE IF NOT EXISTS `clans` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `tag` VARCHAR(20) DEFAULT NULL,
    `leader_id` INT UNSIGNED NOT NULL,
    `description` TEXT DEFAULT NULL,
    `created_at` INT UNSIGNED DEFAULT 0,
    `treasury` BIGINT UNSIGNED DEFAULT 0,
    `level` TINYINT UNSIGNED DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    KEY `leader_id` (`leader_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица предметов
CREATE TABLE IF NOT EXISTS `items` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `type` VARCHAR(50) DEFAULT 'other',
    `subtype` VARCHAR(50) DEFAULT NULL,
    `price` INT UNSIGNED DEFAULT 0,
    `weight` INT UNSIGNED DEFAULT 0,
    `min_level` TINYINT UNSIGNED DEFAULT 1,
    `strength` INT UNSIGNED DEFAULT 0,
    `agility` INT UNSIGNED DEFAULT 0,
    `intelligence` INT UNSIGNED DEFAULT 0,
    `vitality` INT UNSIGNED DEFAULT 0,
    `luck` INT UNSIGNED DEFAULT 0,
    `hp_bonus` INT UNSIGNED DEFAULT 0,
    `mana_bonus` INT UNSIGNED DEFAULT 0,
    `damage_min` INT UNSIGNED DEFAULT 0,
    `damage_max` INT UNSIGNED DEFAULT 0,
    `defense` INT UNSIGNED DEFAULT 0,
    `image` VARCHAR(255) DEFAULT '/public_content/images/items/unknown.png',
    `description` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `type` (`type`),
    KEY `min_level` (`min_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Инвентарь пользователя
CREATE TABLE IF NOT EXISTS `inventory` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `item_id` INT UNSIGNED NOT NULL,
    `count` INT UNSIGNED DEFAULT 1,
    `equipped` TINYINT UNSIGNED DEFAULT 0,
    `durability` INT UNSIGNED DEFAULT 100,
    `enchant_level` TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `item_id` (`item_id`),
    CONSTRAINT `fk_inventory_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inventory_item` FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Сообщения между игроками
CREATE TABLE IF NOT EXISTS `messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `from_user` INT UNSIGNED NOT NULL,
    `to_user` INT UNSIGNED NOT NULL,
    `subject` VARCHAR(255) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `sent_at` INT UNSIGNED DEFAULT 0,
    `is_read` TINYINT UNSIGNED DEFAULT 0,
    `deleted_by_sender` TINYINT UNSIGNED DEFAULT 0,
    `deleted_by_receiver` TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `from_user` (`from_user`),
    KEY `to_user` (`to_user`),
    KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Логи боев
CREATE TABLE IF NOT EXISTS `battle_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `attacker_id` INT UNSIGNED NOT NULL,
    `defender_id` INT UNSIGNED NOT NULL,
    `result` ENUM('win', 'lose', 'draw') DEFAULT NULL,
    `attacker_hp` INT UNSIGNED DEFAULT 0,
    `defender_hp` INT UNSIGNED DEFAULT 0,
    `gold_lost` INT UNSIGNED DEFAULT 0,
    `exp_gained` INT UNSIGNED DEFAULT 0,
    `battle_date` INT UNSIGNED DEFAULT 0,
    `log_data` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `attacker_id` (`attacker_id`),
    KEY `defender_id` (`defender_id`),
    KEY `battle_date` (`battle_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Друзья
CREATE TABLE IF NOT EXISTS `friends` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `friend_id` INT UNSIGNED NOT NULL,
    `status` ENUM('pending', 'accepted', 'blocked') DEFAULT 'pending',
    `added_at` INT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_friend` (`user_id`, `friend_id`),
    KEY `user_id` (`user_id`),
    KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Квесты
CREATE TABLE IF NOT EXISTS `quests` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `min_level` TINYINT UNSIGNED DEFAULT 1,
    `reward_gold` INT UNSIGNED DEFAULT 0,
    `reward_exp` INT UNSIGNED DEFAULT 0,
    `reward_item_id` INT UNSIGNED DEFAULT NULL,
    `is_repeatable` TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `min_level` (`min_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Прогресс квестов
CREATE TABLE IF NOT EXISTS `user_quests` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `quest_id` INT UNSIGNED NOT NULL,
    `status` ENUM('active', 'completed', 'failed') DEFAULT 'active',
    `progress` JSON DEFAULT NULL,
    `started_at` INT UNSIGNED DEFAULT 0,
    `completed_at` INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_quest` (`user_id`, `quest_id`),
    KEY `user_id` (`user_id`),
    KEY `quest_id` (`quest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Локация (карта)
CREATE TABLE IF NOT EXISTS `locations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `parent_id` INT UNSIGNED DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT '/public_content/images/locations/unknown.png',
    `min_level` TINYINT UNSIGNED DEFAULT 1,
    `has_monsters` TINYINT UNSIGNED DEFAULT 0,
    `has_shop` TINYINT UNSIGNED DEFAULT 0,
    `has_bank` TINYINT UNSIGNED DEFAULT 0,
    `has_arena` TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Монстры
CREATE TABLE IF NOT EXISTS `monsters` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `level` TINYINT UNSIGNED DEFAULT 1,
    `hp` INT UNSIGNED DEFAULT 100,
    `max_hp` INT UNSIGNED DEFAULT 100,
    `strength` INT UNSIGNED DEFAULT 10,
    `agility` INT UNSIGNED DEFAULT 10,
    `intelligence` INT UNSIGNED DEFAULT 10,
    `damage_min` INT UNSIGNED DEFAULT 5,
    `damage_max` INT UNSIGNED DEFAULT 15,
    `defense` INT UNSIGNED DEFAULT 5,
    `exp_reward` INT UNSIGNED DEFAULT 10,
    `gold_reward` INT UNSIGNED DEFAULT 5,
    `image` VARCHAR(255) DEFAULT '/public_content/images/monsters/unknown.png',
    `location_id` INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `level` (`level`),
    KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Чат
CREATE TABLE IF NOT EXISTS `chat_messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `message` TEXT NOT NULL,
    `room` VARCHAR(50) DEFAULT 'global',
    `sent_at` INT UNSIGNED DEFAULT 0,
    `ip` VARCHAR(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `room` (`room`),
    KEY `sent_at` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Торговля
CREATE TABLE IF NOT EXISTS `trade_offers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `seller_id` INT UNSIGNED NOT NULL,
    `item_id` INT UNSIGNED NOT NULL,
    `item_count` INT UNSIGNED DEFAULT 1,
    `price` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED DEFAULT 0,
    `is_sold` TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `seller_id` (`seller_id`),
    KEY `item_id` (`item_id`),
    KEY `is_sold` (`is_sold`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Добавим тестового админа (пароль: admin123)
INSERT INTO `users` (`login`, `password`, `email`, `level`, `gold`, `strength`, `agility`, `intelligence`, `vitality`, `class`, `is_online`) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@windland.com', 100, 1000000, 100, 100, 100, 100, 'admin', 1);

-- Добавим стартовые локации
INSERT INTO `locations` (`name`, `description`, `image`, `min_level`, `has_shop`, `has_bank`) VALUES
('Город Новичков', 'Безопасное место для начинающих игроков', '/public_content/images/locations/city.png', 1, 1, 1),
('Лес', 'Тёмный лес полный опасностей', '/public_content/images/locations/forest.png', 1, 0, 0),
('Пещера', 'Мрачная пещера с сокровищами', '/public_content/images/locations/cave.png', 5, 0, 0),
('Арена', 'Место для сражений между игроками', '/public_content/images/locations/arena.png', 10, 0, 0);

-- Добавим базовые предметы
INSERT INTO `items` (`name`, `type`, `price`, `min_level`, `strength`, `damage_min`, `damage_max`, `image`) VALUES
('Ржавый меч', 'weapon', 10, 1, 2, 3, 8, '/public_content/images/items/sword_rusty.png'),
('Стальной меч', 'weapon', 100, 5, 5, 8, 15, '/public_content/images/items/sword_steel.png'),
('Кожаная броня', 'armor', 50, 1, 0, 0, 0, '/public_content/images/items/armor_leather.png', 5),
('Зелье здоровья', 'potion', 20, 1, 0, 0, 0, '/public_content/images/items/potion_hp.png');
