<?php
include "../../config/database.php";
include "../../models/Pelanggaran.php"; // pastikan lokasi file benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelanggaranID = $_POST['deletePelanggaranID'] ?? '';

    if (empty($pelanggaranID)) {
        header("Location: ../admin/kelola_tatatertib.php?status=error&msg=ID pelanggaran tidak ditemukan");
        exit;
    }

    // Buat koneksi database
    $dbConnection = new DatabaseConnection();
    $pelanggaran = new Pelanggaran($dbConnection);

    // Menghapus data pelanggaran
    if ($pelanggaran->hapusPelanggaran($pelanggaranID)) {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=success");
    } else {
        header("Location: ../admin/kelola_tatatertib.php?status=error");
    }
}
?>
