<?php
/**
 * WindLand - Класс для работы с базой данных (MySQLi)
 * PHP 7.4+ | UTF-8 | Подготовленные выражения
 */

class MySQL {
    private $mysqli;
    private $result;
    public $queryCount = 0;
    public $totalTime = 0;

    public function __construct(string $host, string $user, string $pass, string $db, int $port = 3306) {
        $this->mysqli = new mysqli($host, $user, $pass, $db, $port);
        
        if ($this->mysqli->connect_error) {
            die("Ошибка подключения к БД: " . htmlspecialchars($this->mysqli->connect_error, ENT_QUOTES, 'UTF-8'));
        }
        
        // Установка UTF-8
        $this->mysqli->set_charset('utf8mb4');
        $this->mysqli->query("SET time_zone = '+00:00'");
    }

    /**
     * Выполнение SQL запроса
     */
    public function query(string $sql) {
        $start = microtime(true);
        $this->result = $this->mysqli->query($sql);
        $this->totalTime += microtime(true) - $start;
        $this->queryCount++;
        
        if ($this->mysqli->error && @$_COOKIE['AdminJoe']) {
            echo "<div style='color:red'>SQL Error: " . htmlspecialchars($this->mysqli->error, ENT_QUOTES, 'UTF-8') . "</div>";
        }
        
        return $this->result;
    }

    /**
     * Получение ассоциативного массива
     */
    public function fetchAssoc($result = null): ?array {
        $res = $result ?? $this->result;
        if ($res instanceof mysqli_result) {
            return $res->fetch_assoc();
        }
        return null;
    }

    /**
     * Получение строки результата
     */
    public function fetchRow($result = null): ?array {
        $res = $result ?? $this->result;
        if ($res instanceof mysqli_result) {
            return $res->fetch_row();
        }
        return null;
    }

    /**
     * Получить одну ячейку
     */
    public function getOne(string $sql) {
        $result = $this->query($sql);
        if ($result instanceof mysqli_result) {
            $row = $result->fetch_row();
            return $row[0] ?? null;
        }
        return null;
    }

    /**
     * Получить первую строку
     */
    public function getRow(string $sql): ?array {
        $result = $this->query($sql);
        if ($result instanceof mysqli_result) {
            return $result->fetch_assoc();
        }
        return null;
    }

    /**
     * Получить все строки
     */
    public function getAll(string $sql): array {
        $result = $this->query($sql);
        $rows = [];
        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * Количество строк в результате
     */
    public function numRows($result = null): int {
        $res = $result ?? $this->result;
        if ($res instanceof mysqli_result) {
            return $res->num_rows;
        }
        return 0;
    }

    /**
     * Последний inserted ID
     */
    public function insertId(): int {
        return $this->mysqli->insert_id;
    }

    /**
     * Количество затронутых строк
     */
    public function affectedRows(): int {
        return $this->mysqli->affected_rows;
    }

    /**
     * Экранирование строки
     */
    public function escape(string $str): string {
        return $this->mysqli->real_escape_string($str);
    }

    /**
     * Запрос с подготовленными параметрами
     */
    public function prepare(string $sql, string $types = '', ...$params) {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) {
            return false;
        }
        if (!empty($types) && !empty($params)) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
        }
        return $stmt;
    }

    /**
     * Закрытие соединения
     */
    public function __destruct() {
        if ($this->result instanceof mysqli_result) {
            $this->result->free();
        }
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
