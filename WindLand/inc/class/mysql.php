<?php
/**
 * MySQLi Database Class for PHP 7.4+
 * WindLand - Updated with UTF-8 support and prepared statements
 */
class MySQL
{
    public string $host = SQL_HOST;
    private int $port = 3306;
    private $sql = false; // Ресурс запроса
    private $mysqli = null; // mysqli соединение
    public $user = false; // Копия юзера бд, для бекапа
    public $pass = false; // Копия пароля к бд, для бекапа
    public $db_name = false; // Копия имени бд, для бекапа
    public float $tme = 0; // Общее время работы БД
    public int $all = 0; // Количество запросов
    public array $sql_all = []; // Лог запросов
    
    public function __construct(string $user, string $pwd, string $db)
    {
        $this->user = $user;
        $this->pass = $pwd;
        $this->db_name = $db;
        
        // Подключение через mysqli
        $this->mysqli = new mysqli($this->host, $user, $pwd, $db, $this->port);
        
        if ($this->mysqli->connect_error) {
            die('<h1>Ошибка подключения к MySQL: ' . htmlspecialchars($this->mysqli->connect_error, ENT_QUOTES, 'UTF-8') . '</h1>');
        }
        
        // Установка UTF-8 кодировки
        $this->mysqli->set_charset('utf8mb4');
        
        // Установка timezone
        $this->mysqli->query("SET time_zone = '+00:00'");
    }
    
    private function error(string $q, string $file = '', string $line = '', string $func = '', string $class = ''): void
    {
        if ( @$_COOKIE['AdminJoe'] ) {
            echo '<hr><b>MySQL Error:</b> ' . htmlspecialchars($this->mysqli->error, ENT_QUOTES, 'UTF-8') . '<br>
            <b>Запрос:</b> ' . htmlspecialchars($q, ENT_QUOTES, 'UTF-8') . '<br>
            <b>File:</b> ' . htmlspecialchars($file, ENT_QUOTES, 'UTF-8') . '<br>
            <b>Line:</b> ' . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . '<br>
            <b>Function:</b> ' . htmlspecialchars($func, ENT_QUOTES, 'UTF-8') . '<br>
            <b>Class:</b> ' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '<hr>';
        }
    }
    
    /**
     * Выполнение SQL запроса
     */
    public function sql(string $res, string $file = '', string $line = '', string $func = '', string $class = '')
    {
        $t = microtime(true);
        $this->sql = $this->mysqli->query($res);
        $t = microtime(true) - $t;
        
        if ($this->mysqli->error) {
            $this->error($res, $file, $line, $func, $class);
        }
        
        $this->tme += abs($t);
        $this->all++;
        $this->sql_all[] = [$res, $file, $line, $func, $class];
        
        return $this->sql;
    }
    
    /**
     * Выполнение запроса с подготовленными параметрами
     */
    public function prepare(string $sql, string $types = '', ...$params)
    {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            $this->error($sql);
            return false;
        }
        
        if (!empty($types) && !empty($params)) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
        }
        
        return $stmt;
    }
    
    /**
     * Получить ассоциативный массив из результата
     */
    public function sqla(string $res, string $file = '', string $line = '', string $func = '', string $class = ''): ?array
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        if ($result instanceof mysqli_result) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Получить значение из результата
     */
    public function sqlr(string $res, int $count = 0, string $file = '', string $line = '', string $func = '', string $class = '')
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        if ($result instanceof mysqli_result) {
            if ($count === 0) {
                $row = $result->fetch_row();
                return $row[0] ?? null;
            } else {
                $result->data_seek($count);
                $row = $result->fetch_row();
                return $row[0] ?? null;
            }
        }
        return null;
    }
    
    /**
     * Получить нумерованный массив из результата
     */
    public function sqla_id(string $res, string $file = '', string $line = '', string $func = '', string $class = ''): ?array
    {
        $result = $this->sql($res, $file, $line, $func, $class);
        if ($result instanceof mysqli_result) {
            return $result->fetch_row();
        }
        return null;
    }
    
    /**
     * Получить последний inserted ID
     */
    public function insert_id(): int
    {
        return $this->mysqli->insert_id;
    }
    
    /**
     * Получить количество затронутых строк
     */
    public function affected_rows(): int
    {
        return $this->mysqli->affected_rows;
    }
    
    /**
     * Экранирование строки
     */
    public function real_escape_string(string $str): string
    {
        return $this->mysqli->real_escape_string($str);
    }
    
    /**
     * Закрыть соединение
     */
    public function __destruct()
    {
        if ($this->sql instanceof mysqli_result) {
            $this->sql->free();
        }
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
