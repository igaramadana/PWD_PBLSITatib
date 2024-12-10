<?php
include "../../config/database.php";
include "../../models/Pelanggaran.php"; // pastikan lokasi file benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelanggaranID = $_POST['editPelanggaranID'] ?? ''; // Pastikan ini sesuai dengan name di form modal
    $namaPelanggaran = $_POST['editNamaPelanggaran'] ?? '';
    $tingkatID = $_POST['editTingkatID'] ?? '';

    if (empty($pelanggaranID) || empty($namaPelanggaran) || empty($tingkatID)) {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=error&msg=Data tidak lengkap");
        exit;
    }

    // Buat koneksi database
    $dbConnection = new DatabaseConnection();
    $pelanggaran = new Pelanggaran($dbConnection);

    // Memperbarui data pelanggaran
    if ($pelanggaran->editPelanggaran($pelanggaranID, $namaPelanggaran, $tingkatID)) {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=success");
    } else {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=error");
    }
}
