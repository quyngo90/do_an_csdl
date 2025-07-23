<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'quanlythuvien';

    private function __construct() {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
    
}
?>
