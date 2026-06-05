<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($this->connection->connect_error) {
                throw new Exception('Database Connection Failed: ' . $this->connection->connect_error);
            }
            $this->connection->set_charset('utf8mb4');
        } catch (Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            die('Database connection error. Please try again later.');
        }
    }

    public function query($query, $params = [], $types = '') {
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->connection->error);
            }
            if (!empty($params)) {
                if (empty($types)) {
                    $types = '';
                    foreach ($params as $param) {
                        $types .= is_int($param) ? 'i' : (is_float($param) ? 'd' : 's');
                    }
                }
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }
            return $stmt->get_result();
        } catch (Exception $e) {
            error_log('Query Error: ' . $e->getMessage());
            return false;
        }
    }

    public function fetchOne($query, $params = [], $types = '') {
        $result = $this->query($query, $params, $types);
        return $result ? $result->fetch_assoc() : null;
    }

    public function fetchAll($query, $params = [], $types = '') {
        $result = $this->query($query, $params, $types);
        if (!$result) return [];
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function insert($query, $params = [], $types = '') {
        $this->query($query, $params, $types);
        return $this->connection->insert_id;
    }

    public function affectedRows() {
        return $this->connection->affected_rows;
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function __destruct() {
        $this->close();
    }
}
?>