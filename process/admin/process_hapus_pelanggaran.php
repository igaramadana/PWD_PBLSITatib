<?php
include "../../config/database.php";

// Cek apakah data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $pelanggaranID = isset($_POST['PelanggaranID']) ? $_POST['PelanggaranID'] : '';

    // Validasi input
    if (empty($pelanggaranID)) {
        // Redirect jika tidak ada ID pelanggaran
        header("Location: ../admin/kelola_tatatertib.php?status=error&msg=ID pelanggaran tidak ditemukan");
        exit;
    }

    // Query untuk menghapus data pelanggaran
    $query = "DELETE FROM Pelanggaran WHERE PelanggaranID = ?";

    // Persiapkan query
    $params = array($pelanggaranID);
    $result = sqlsrv_query($conn, $query, $params);

    // Cek apakah query berhasil
    if ($result) {
        // Redirect ke halaman kelola pelanggaran dengan status sukses
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=success");
    } else {
        // Jika gagal, tampilkan error
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=error");
    }
}