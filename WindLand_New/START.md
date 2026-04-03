# 🚀 Быстрый старт WindLand

## 1. Импорт базы данных
```bash
mysql -u root -p < /workspace/WindLand_New/database/schema.sql
```

## 2. Настройка config.php
Откройте `/workspace/WindLand_New/configs/config.php` и укажите ваши данные:
```php
define('SQL_HOST', 'localhost');
define('SQL_USER', 'root');        // Ваш пользователь MySQL
define('SQL_PASS', '');            // Ваш пароль MySQL
define('SQL_BASE', 'windland_db');
```

## 3. Копирование изображений (если есть)
```bash
cp -r /workspace/WindLand/images/* /workspace/WindLand_New/images/
cp -r /workspace/WindLand/public_content/* /workspace/WindLand_New/public_content/
```

## 4. Проверка прав
```bash
chmod -R 755 /workspace/WindLand_New
chmod 644 /workspace/WindLand_New/configs/config.php
```

## 5. Тестовый вход
- Откройте браузер: http://localhost/WindLand_New/
- Логин: **admin**
- Пароль: **admin123**

## 📁 Созданные файлы

### Основные PHP файлы:
1. `index.php` - Главная страница входа
2. `reg.php` - Регистрация нового пользователя
3. `game.php` - Обработка входа в игру
4. `main.php` - Главная игровая страница
5. `exit.php` - Выход из игры

### Конфигурация:
6. `configs/config.php` - Настройки проекта

### База данных:
7. `inc/class/mysql.php` - Класс для работы с MySQL
8. `database/schema.sql` - Схема БД с данными

### Документация:
9. `README.md` - Полная документация
10. `START.md` - Этот файл

### Ресурсы:
- `public_content/` - Изображения, SWF файлы
- `images/` - Дополнительные изображения
- `css/` - Стили
- `js/` - JavaScript файлы

## ✅ Что работает:
- ✅ Регистрация новых пользователей
- ✅ Вход в игру (логин/пароль)
- ✅ Отображение профиля персонажа
- ✅ Инвентарь
- ✅ Карта локаций
- ✅ Чат (визуально)
- ✅ Навигация по игре
- ✅ Выход из игры

## 🔧 Что добавить:
- fight.php - Боевая система
- shop.php - Магазин
- bank.php - Банк
- arena.php - Арена
- map.php - Карта мира
- profile.php - Профиль игрока
- msg.php - Почта
- clan.php - Кланы
- chat.php - AJAX чат

## 💡 Советы:
1. Включите отображение ошибок PHP для отладки
2. Проверьте логи Apache/Nginx при ошибках 500
3. Убедитесь что MySQL запущен
4. Проверьте права доступа к файлам

---
**Версия:** 2.0  
**PHP:** 7.4+  
**MySQL:** 5.7+ с utf8mb4
