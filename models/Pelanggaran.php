<?php
class Pelanggaran
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection->getConnection();
    }

    // Create (Tambah Pelanggaran)
    public function tambahPelanggaran($namaPelanggaran, $tingkatID)
    {
        $query = "INSERT INTO Pelanggaran (NamaPelanggaran, TingkatID) VALUES (?, ?)";
        $params = array($namaPelanggaran, $tingkatID);

        $result = sqlsrv_query($this->conn, $query, $params);

        if ($result === false) {
            // Jika ada error, tampilkan pesan error
            die(print_r(sqlsrv_errors(), true));
        }

        return $result ? true : false;
    }


    // Read (Ambil Semua Data Pelanggaran)
    public function getAllPelanggaran($search = "", $perPage = 10, $page = 1)
    {
        $startFrom = ($page - 1) * $perPage;
        $searchParam = "%" . $search . "%";

        $query = "SELECT Pelanggaran.PelanggaranID, Pelanggaran.NamaPelanggaran, TingkatPelanggaran.Tingkat
                FROM Pelanggaran
                JOIN TingkatPelanggaran ON Pelanggaran.TingkatID = TingkatPelanggaran.TingkatID
                WHERE Pelanggaran.NamaPelanggaran LIKE ?
                ORDER BY Pelanggaran.PelanggaranID
                OFFSET $startFrom ROWS FETCH NEXT $perPage ROWS ONLY";

        $params = array($searchParam);
        $result = sqlsrv_query($this->conn, $query, $params);

        return $result ? $result : false;
    }

    // Update (Edit Pelanggaran)
    public function editPelanggaran($pelanggaranID, $namaPelanggaran, $tingkatID)
    {
        $query = "UPDATE Pelanggaran SET NamaPelanggaran = ?, TingkatID = ? WHERE PelanggaranID = ?";
        $params = array($namaPelanggaran, $tingkatID, $pelanggaranID);
        $result = sqlsrv_query($this->conn, $query, $params);

        return $result ? true : false;
    }

    // Delete (Hapus Pelanggaran)
    public function hapusPelanggaran($pelanggaranID)
    {
        $query = "DELETE FROM Pelanggaran WHERE PelanggaranID = ?";
        $params = array($pelanggaranID);
        $result = sqlsrv_query($this->conn, $query, $params);

        return $result ? true : false;
    }

    // Get Total Data (untuk pagination)
    public function getTotalPelanggaran($search = "")
    {
        $searchParam = "%" . $search . "%";
        $query = "SELECT COUNT(*) AS total FROM Pelanggaran WHERE Pelanggaran.NamaPelanggaran LIKE ?";
        $params = array($searchParam);
        $result = sqlsrv_query($this->conn, $query, $params);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        return $row['total'];
    }
}
