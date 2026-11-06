<?php
class Database {
    private $host = "localhost";
    private $port = "3307"; // change this if your MySQL runs on a different port
    private $db_name = "portfolio_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo json_encode(["status" => "error", "message" => "Connection error: " . $exception->getMessage()]);
            exit();
        }
        return $this->conn;
    }
}
