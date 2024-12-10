<?php
include "../../config/database.php";

// Mengecek apakah data dikirimkan melalui POST
if (isset($_POST['NamaSanksi'], $_POST['TingkatID'])) {
    $namaSanksi = $_POST['NamaSanksi'];
    $tingkatID = $_POST['TingkatID'];

    // Query untuk menambahkan sanksi baru
    $query = "INSERT INTO Sanksi (NamaSanksi, TingkatID) VALUES (?, ?)";
    $params = array($namaSanksi, $tingkatID);

    // Menjalankan query
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt) {
        // Jika berhasil, redirect ke halaman kelola sanksi dengan status sukses
        header("Location: ../../pages/admin/kelola_sanksi.php?status=success&msg=Sanksi berhasil ditambahkan.");
    } else {
        // Jika gagal, redirect dengan status error dan pesan kesalahan
        header("Location: ../../pages/admin/kelola_sanksi.php?status=error&msg=Terjadi kesalahan saat menambahkan sanksi.");
    }
} else {
    // Jika data tidak ada, redirect ke halaman kelola sanksi
    header("Location: ../../pages/admin/kelola_sanksi.php");
}
