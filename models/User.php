<?php
class User
{
    private $connection;
    private $table = 'Users';

    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Fungsi login dengan verifikasi password yang di-hash
    public function login($username, $password)
    {
        // Query untuk mencari user berdasarkan username dan memverifikasi password hash
        $query = "SELECT UserID, Username, Password, Role FROM " . $this->table . " WHERE Username = ? AND Password = CONVERT(VARBINARY, HASHBYTES('SHA2_256', ?))";

        // Menyiapkan query
        $stmt = sqlsrv_prepare($this->connection, $query, array(&$username, &$password));

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Menjalankan query
        $result = sqlsrv_execute($stmt);

        if ($result) {
            // Mengambil data hasil query
            $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($user) {
                return $user; // Jika user ditemukan dan password valid
            }
        }

        return null; // Jika login gagal, kembalikan null
    }
}
