<?php
class DatabaseConnection {
    private $serverName = "pop-os"; 
    private $connectionOptions;
    private $conn;

    public function __construct() {
        $this->connectionOptions = array(
            "Database" => "DBEthicX",
            "Uid" => "sa", 
            "PWD" => "Igaramadana123#" 
        );
        $this->conn = $this->connect();
    }

    private function connect() {
        $conn = sqlsrv_connect($this->serverName, $this->connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika koneksi gagal
        }
        return $conn;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        if ($this->conn) {
            sqlsrv_close($this->conn); // Menutup koneksi setelah selesai
        }
    }
}

$db = new DatabaseConnection();
$conn = $db->getConnection();
?>
s