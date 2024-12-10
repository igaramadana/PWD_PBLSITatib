<?php
include "../../config/database.php"; // Menghubungkan ke database

// Mengecek apakah data yang dibutuhkan sudah ada
if (isset($_POST['SanksiID']) && isset($_POST['NamaSanksi']) && isset($_POST['TingkatID'])) {
    // Mengambil data dari form
    $sanksiID = $_POST['SanksiID'];
    $namaSanksi = $_POST['NamaSanksi'];
    $tingkatID = $_POST['TingkatID'];

    // Menyusun query SQL untuk memperbarui data sanksi
    $sql = "UPDATE Sanksi 
            SET NamaSanksi = ?, TingkatID = ? 
            WHERE SanksiID = ?";

    // Menyiapkan parameter untuk query
    $params = array($namaSanksi, $tingkatID, $sanksiID);

    // Menyiapkan statement dan eksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Jika terjadi kesalahan
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirect kembali ke halaman kelola_sanksi.php setelah berhasil
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_sanksi.php?status=success&msg=Sanksi berhasil diperbarui");
        exit();
    }
} else {
    // Jika data tidak ditemukan, redirect dengan status error
    header("Location: /PWD_PBLSITatib/pages/admin/kelola_sanksi.php?status=error&msg=Data tidak lengkap atau tidak ditemukan");
    exit();
}

// Menutup koneksi
sqlsrv_close($conn);
