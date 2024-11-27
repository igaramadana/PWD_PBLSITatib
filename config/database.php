<?php

class Database
{
    private $serverName = "pop-os"; // Sesuaikan dengan server Anda
    private $database = "DBEthicX"; // Nama database Anda
    private $username = "sa"; // Username SQL Server
    private $password = "Igaramadana123#"; // Password SQL Server
    private $connection;

    public function getConnection()
    {
        // Koneksi ke SQL Server menggunakan sqlsrv_connect
        $connectionInfo = array("Database" => $this->database, "Uid" => $this->username, "PWD" => $this->password);
        $this->connection = sqlsrv_connect($this->serverName, $connectionInfo);

        if ($this->connection === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return $this->connection;
    }
}
?>
