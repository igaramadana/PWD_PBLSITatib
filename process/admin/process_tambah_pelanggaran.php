<?php
include "../../config/database.php";

// Cek apakah data dikirimkan dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPelanggaran = $_POST['NamaPelanggaran'];
    $tingkatID = $_POST['TingkatID'];

    // Query untuk menyimpan data pelanggaran baru
    $sql = "INSERT INTO Pelanggaran (NamaPelanggaran, TingkatID) VALUES (?, ?)";
    $params = array($namaPelanggaran, $tingkatID);

    // Menjalankan query
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Cek apakah data berhasil disimpan
    if ($stmt) {
        // Redirect kembali ke halaman kelola tata tertib dengan status berhasil
        header ("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=success");
    } else {
        // Jika gagal, redirect dengan status error
        header ("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=error");
    }
}
?>
