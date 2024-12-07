<?php
include "../../config/database.php";

// Cek apakah data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namaPelanggaran = isset($_POST['NamaPelanggaran']) ? $_POST['NamaPelanggaran'] : '';
    $tingkatID = isset($_POST['TingkatID']) ? $_POST['TingkatID'] : '';

    // Validasi input
    if (empty($namaPelanggaran) || empty($tingkatID)) {
        // Redirect jika data tidak lengkap
        header("Location: ../admin/kelola_tatatertib.php?status=error&msg=Data tidak lengkap");
        exit;
    }

    // Query untuk memasukkan data pelanggaran
    $query = "INSERT INTO Pelanggaran (NamaPelanggaran, TingkatID) VALUES (?, ?)";

    // Persiapkan query
    $params = array($namaPelanggaran, $tingkatID);
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
