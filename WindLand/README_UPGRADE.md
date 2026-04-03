# WindLand - Руководство по обновлению до PHP 7.4+

## Что было сделано:

### 1. Обновленные файлы:
- `/configs/config.php` - Конфигурация с UTF-8 поддержкой
- `/inc/class/mysql.php` - Класс базы данных на MySQLi (PHP 7.4+)
- `/index.php` - Главная страница с UTF-8
- `/database/schema.sql` - Новая схема БД с utf8mb4

### 2. Основные изменения:

#### config.php:
- Замена `DEFINE()` на `define()`
- Добавлена поддержка UTF-8 (mb_internal_encoding)
- Изменено имя БД на `windland_db`
- Улучшена фильтрация входных данных с ENT_QUOTES и UTF-8

#### mysql.php:
- Полная переписан на MySQLi вместо устаревшего mysql_*
- Добавлены типизированные свойства (PHP 7.4+)
- Поддержка подготовленных выражений (prepare method)
- UTF-8 кодировка по умолчанию (utf8mb4)
- Новые методы: prepare(), affected_rows(), real_escape_string()

#### index.php:
- HTML5 doctype
- charset=UTF-8
- htmlspecialchars с ENT_QUOTES и UTF-8
- Заменен mysql_fetch_assoc на ->fetch_assoc()

### 3. Новая база данных (schema.sql):
- Кодировка: utf8mb4_unicode_ci
- 14 нормализованных таблиц
- Современные типы данных
- Индексы для оптимизации

## Инструкция по установке:

1. **Импорт базы данных:**
   ```sql
   mysql -u root -p < database/schema.sql
   ```

2. **Настройка config.php:**
   Отредактируйте параметры подключения:
   - SQL_HOST
   - SQL_USER
   - SQL_PASS
   - SQL_BASE

3. **Массовое обновление остальных файлов:**
   
   Для обновления всех PHP файлов проекта используйте поиск и замену:
   
   ```bash
   # Найти все файлы с mysql_fetch_assoc
   grep -r "mysql_fetch_assoc" --include="*.php" .
   
   # Заменить DEFINE на define
   find . -name "*.php" -exec sed -i 's/DEFINE(/define(/g' {} \;
   
   # Заменить Error_Reporting на error_reporting
   find . -name "*.php" -exec sed -i 's/Error_Reporting(/error_reporting(/g' {} \;
   ```

4. **Ручное обновление критических файлов:**
   
   Файлы требующие особого внимания:
   - game.php
   - main.php
   - reg.php
   - inc/battle.php
   - inc/func.php
   - Все файлы в inc/locations/
   - Все файлы в inc/inc/

5. **Проверка синтаксиса:**
   ```bash
   php -l configs/config.php
   php -l inc/class/mysql.php
   php -l index.php
   ```

## Ключевые замены для ручного обновления:

| Старый код | Новый код |
|------------|-----------|
| `mysql_fetch_assoc($result)` | `$result->fetch_assoc()` |
| `mysql_fetch_array($result)` | `$result->fetch_array()` |
| `mysql_num_rows($result)` | `$result->num_rows` |
| `mysql_insert_id()` | `$db->insert_id()` |
| `mysql_real_escape_string()` | `$db->real_escape_string()` |
| `DEFINE('CONST', val)` | `define('CONST', val)` |
| `Error_Reporting(0)` | `error_reporting(0)` |
| `GLOBAL $var` | `global $var` |

## Требования к серверу:
- PHP 7.4 или выше
- MySQL 5.7+ или MariaDB 10.2+
- Расширение mysqli включено
- mbstring включен для UTF-8

## Примечания:
- Пути к картинкам сохранены как в оригинале
- Все пути к public_content остались без изменений
- Структура папок не изменена
