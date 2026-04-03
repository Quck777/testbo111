# WindLand v2.0 - Браузерная MMORPG игра

## Описание
WindLand - это многопользовательская ролевая онлайн игра (MMORPG), переписанная на PHP 7.4+ с полной поддержкой UTF-8 и улучшенной базой данных.

## Требования
- PHP 7.4 или выше
- MySQL 5.7 или выше / MariaDB 10.3 или выше
- Веб-сервер (Apache/Nginx)

## Установка

### 1. База данных
1. Создайте базу данных:
```sql
CREATE DATABASE windland_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Импортируйте схему базы данных:
```bash
mysql -u username -p windland_db < database/schema.sql
```

### 2. Настройка конфигурации
Откройте файл `configs/config.php` и измените параметры подключения к БД:

```php
define('SQL_HOST', 'localhost');
define('SQL_PORT', 3306);
define('SQL_USER', 'ваш_пользователь');
define('SQL_PASS', 'ваш_пароль');
define('SQL_BASE', 'windland_db');
define('SQL_CHARSET', 'utf8mb4');
```

### 3. Права доступа
Убедитесь, что веб-сервер имеет права на чтение файлов:
```bash
chmod -R 755 /path/to/WindLand
chmod -R 777 /path/to/WindLand/private_content
```

### 4. Настройка веб-сервера

#### Apache
Создайте файл `.htaccess` в корне проекта:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L]
```

#### Nginx
Пример конфигурации:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/WindLand;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## Структура проекта

```
WindLand/
├── configs/           # Файлы конфигурации
│   └── config.php     # Основные настройки
├── database/          # SQL схемы
│   └── schema.sql     # Структура БД
├── inc/               # Включаемые файлы
│   ├── class/         # Классы (MySQL, Player, etc.)
│   ├── locations/     # Локации игры
│   └── ...
├── public_content/    # Публичные ресурсы
│   ├── css/           # Стили
│   ├── js/            # JavaScript
│   └── images/        # Изображения
├── private_content/   # Приватные данные
├── index.php          # Главная страница
├── game.php           # Вход в игру
├── main.php           # Основной интерфейс
├── reg.php            # Регистрация
└── exit.php           # Выход
```

## Основные возможности

### Версия 2.0
- ✅ PHP 7.4+ с типизацией
- ✅ Полная поддержка UTF-8 (utf8mb4)
- ✅ Использование mysqli вместо устаревшего mysql
- ✅ Подготовленные выражения для безопасности
- ✅ Улучшенная структура базы данных
- ✅ Современный HTML5/CSS3
- ✅ Адаптивный дизайн

### Игровой процесс
- Создание персонажа (выбор расы и пола)
- Прокачка характеристик
- Пошаговая боевая система
- Система кланов
- Инвентарь и экипировка
- Экономика (золото, банк, торговля)
- Профессии (алхимия, рыбалка, добыча)
- Квесты и задания
- PvP сражения
- Чат и сообщения

## Безопасность

В версии 2.0 реализованы следующие меры безопасности:
- Использование подготовленных выражений (prepared statements)
- Экранирование входных данных
- Защита от XSS атак через htmlspecialchars()
- Валидация пользовательского ввода
- Хэширование паролей (md5 - рекомендуется улучшить до password_hash())
- Проверка сессий и куки

## Лицензия

Игра распространяется "как есть" для образовательных целей.

## Контакты

Для вопросов и предложений создавайте issues в репозитории.
