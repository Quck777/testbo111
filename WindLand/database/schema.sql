-- WindLand Database Schema
-- Версия: 2.0 (PHP 7.4+, UTF-8)
-- Кодировка: utf8mb4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Создание базы данных
CREATE DATABASE IF NOT EXISTS `windland_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `windland_db`;

-- --------------------------------------------------------

-- Таблица пользователей
CREATE TABLE `users` (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `smuser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sex` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `race` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `exp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `next_exp` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `gold` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `bank` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `hp` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `max_hp` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `mp` int(11) UNSIGNED NOT NULL DEFAULT 50,
  `max_mp` int(11) UNSIGNED NOT NULL DEFAULT 50,
  `str` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `agi` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `int` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `vit` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `free_stat` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `f_turn` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `cfight` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `action` int(11) NOT NULL DEFAULT 0,
  `mapid` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `x` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `y` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `clan_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `clan_rank` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `online` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `lastom` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `refr` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `referal` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `block` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `admin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reg_date` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `last_visit` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user` (`user`),
  KEY `smuser` (`smuser`),
  KEY `level` (`level`),
  KEY `clan_id` (`clan_id`),
  KEY `online` (`online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица кланов
CREATE TABLE `clans` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `leader_uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `bank` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `exp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `max_members` smallint(5) UNSIGNED NOT NULL DEFAULT 20,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица инвентаря
CREATE TABLE `inventory` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `item_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `item_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `item_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `count` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `wear` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duration` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица предметов
CREATE TABLE `items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица ауры/баффы
CREATE TABLE `p_auras` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `special` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `esttime` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `turn_esttime` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `autocast` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `esttime` (`esttime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица боев
CREATE TABLE `combats` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `place` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `max_level` smallint(5) UNSIGNED NOT NULL DEFAULT 100,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица участников боя
CREATE TABLE `combat_users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `combat_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `team` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `hp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `max_hp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `mp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `max_mp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `turn` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `winner` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `dead` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `combat_id` (`combat_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица логов боев
CREATE TABLE `battle_log` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `combat_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `round` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `combat_id` (`combat_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица чата
CREATE TABLE `chat` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room` (`room`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица локаций/карта
CREATE TABLE `locations` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'city',
  `parent_id` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `x` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `y` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_level` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица квестов
CREATE TABLE `quests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_npc` int(11) UNSIGNED DEFAULT NULL,
  `end_npc` int(11) UNSIGNED DEFAULT NULL,
  `min_level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `reward_gold` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reward_exp` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reward_item` int(11) UNSIGNED DEFAULT NULL,
  `repeatable` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица прогресса квестов
CREATE TABLE `user_quests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `quest_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `progress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `started` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `completed` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `quest_id` (`quest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица рефералов
CREATE TABLE `referals` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `referrer_uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `referred_uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `registered` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `bonus_paid` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `referrer_uid` (`referrer_uid`),
  KEY `referred_uid` (`referred_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица ботов/NPC
CREATE TABLE `bots` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `level` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `hp` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `max_hp` int(11) UNSIGNED NOT NULL DEFAULT 100,
  `mp` int(11) UNSIGNED NOT NULL DEFAULT 50,
  `max_mp` int(11) UNSIGNED NOT NULL DEFAULT 50,
  `str` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `agi` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `int` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `vit` int(11) UNSIGNED NOT NULL DEFAULT 10,
  `exp_reward` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `gold_reward` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `location_id` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `aggressive` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `respawn_time` int(11) UNSIGNED NOT NULL DEFAULT 300,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица сообщений
CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `to_uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `readed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `to_uid` (`to_uid`),
  KEY `from_uid` (`from_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Таблица настроек сервера
CREATE TABLE `server_settings` (
  `key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Начальные настройки сервера
INSERT INTO `server_settings` (`key`, `value`) VALUES
('server_name', 'WindLand'),
('server_version', '2.0'),
('maintenance_mode', '0'),
('registration_enabled', '1'),
('min_level_combat', '1'),
('exp_rate', '1.0'),
('gold_rate', '1.0');

COMMIT;
