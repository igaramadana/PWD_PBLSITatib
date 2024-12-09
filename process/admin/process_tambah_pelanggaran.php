<?php
include "../../config/database.php";
include "../../models/Pelanggaran.php"; // pastikan lokasi file benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namaPelanggaran = isset($_POST['namaPelanggaran']) ? $_POST['namaPelanggaran'] : '';
    $tingkatID = isset($_POST['TingkatID']) ? $_POST['TingkatID'] : '';

    // Validasi input
    if (empty($namaPelanggaran) || empty($tingkatID)) {
        // Redirect jika data tidak lengkap
        header("Location: ../admin/kelola_tatatertib.php?status=error&msg=Data tidak lengkap");
        exit;
    }   

    // Buat koneksi database
    $dbConnection = new DatabaseConnection();
    $pelanggaran = new Pelanggaran($dbConnection);

    $isAdded = $pelanggaran->tambahPelanggaran($namaPelanggaran, $tingkatID);

    // Menambah data pelanggaran
    if ($isAdded) {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=success");
    } else {
        header("Location: ../../pages/admin/kelola_tatatertib.php?status=error");
    }
}
