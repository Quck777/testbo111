<?php
/**
 * WindLand - Класс для работы с MySQL
 * Версия: 2.0 (PHP 7.4+, UTF-8, mysqli)
 */

class MySQL
{
    public string $host = SQL_HOST;
    private int $port = SQL_PORT;
    private $sql = false; // Ресурс запроса
    private $base = null; // Соединение с БД
    public string $user = ''; // Копия пользователя БД
    public string $pass = ''; // Копия пароля к БД
    public string $db_name = ''; // Копия имени БД
    public float $tme = 0; // Общее время работы БД
    public int $all = 0; // Количество запросов
    public array $sql_all = []; // Лог запросов

    /**
     * Конструктор класса
     * @param string $user
     * @param string $pwd
     * @param string $db
     */
    public function __construct(string $user, string $pwd, string $db)
    {
        $this->user = $user;
        $this->pass = $pwd;
        $this->db_name = $db;

        // Подключение через mysqli
        $this->base = new mysqli($this->host, $user, $pwd, $db, $this->port);

        if ($this->base->connect_error) {
            die('<h1>Ошибка подключения к базе данных (MySQL Off).</h1>');
        }

        // Устанавливаем кодировку UTF-8
        $this->base->set_charset(SQL_CHARSET);
        $this->base->query("SET NAMES '" . SQL_CHARSET . "'");
    }

    /**
     * Вывод ошибки
     * @param string $q
     * @param string $file
     * @param string $line
     * @param string $func
     * @param string $class
     */
    private function error(string $q, string $file = '', string $line = '', string $func = '', string $class = ''): void
    {
        if (@$_COOKIE['AdminJoe']) {
            echo '<hr><b>MySQL Error:</b> ' . $this->base->error . '<br>
            <b>Запрос:</b> ' . htmlspecialchars($q) . '<br>
            <b>File:</b> ' . htmlspecialchars($file) . '<br>
            <b>Line:</b> ' . htmlspecialchars($line) . '<br>
            <b>Function:</b> ' . htmlspecialchars($func) . '<br>
            <b>Class:</b> ' . htmlspecialchars($class) . '<hr>';
        }
    }

    /**
     * Выполнение SQL запроса
     * @param string $res
     * @param string $file
     * @param string $line
     * @param string $func
     * @param string $class
     * @return mysqli_result|bool
     */
    public function sql(string $res, string $file = '', string $line = '', string $func = '', string $class = '')
    {
        $t = microtime(true);
        $this->sql = $this->base->query($res);
        $t = microtime(true) - $t;

        if ($this->base->error) {
            $this->error($res, $file, $line, $func, $class);
        }

        $this->tme += abs($t);
        $this->all++;
        $this->sql_all[] = [$res, $file, $line, $func, $class];

        return $this->sql;
    }

    /**
     * Выполнение запроса и возврат ассоциативного массива
     * @param string $res
     * @param string $file
     * @param string $line
     * @param string $func
     * @param string $class
     * @return array|null
     */
    public function sqla(string $res, string $file = '', string $line = '', string $func = '', string $class = ''): ?array
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Выполнение запроса и возврат результата
     * @param string $res
     * @param int $count
     * @param string $file
     * @param string $line
     * @param string $func
     * @param string $class
     * @return mixed
     */
    public function sqlr(string $res, int $count = 0, string $file = '', string $line = '', string $func = '', string $class = '')
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        if (!$result) {
            return null;
        }

        if ($count === 0) {
            $row = $result->fetch_row();
            return $row[0] ?? null;
        } else {
            $result->data_seek($count);
            $row = $result->fetch_row();
            return $row[0] ?? null;
        }
    }

    /**
     * Выполнение запроса и возврат нумерованного массива
     * @param string $res
     * @param string $file
     * @param string $line
     * @param string $func
     * @param string $class
     * @return array|null
     */
    public function sqla_id(string $res, string $file = '', string $line = '', string $func = '', string $class = ''): ?array
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        return $result ? $result->fetch_row() : null;
    }

    /**
     * Получение последнего вставленного ID
     * @return int|string
     */
    public function insert_id()
    {
        return $this->base->insert_id;
    }

    /**
     * Экранирование строки
     * @param string $str
     * @return string
     */
    public function escape(string $str): string
    {
        return $this->base->real_escape_string($str);
    }

    /**
     * Деструктор класса
     */
    public function __destruct()
    {
        if ($this->base) {
            $this->base->close();
        }
    }
}
