<?php
include "../../config/database.php"; // Menghubungkan ke database

// Mengecek apakah data yang dibutuhkan sudah ada
if (isset($_POST['PelanggaranID']) && isset($_POST['NamaPelanggaran']) && isset($_POST['TingkatID'])) {
    // Mengambil data dari form
    $pelanggaranID = $_POST['PelanggaranID'];
    $namaPelanggaran = $_POST['NamaPelanggaran'];
    $tingkatID = $_POST['TingkatID'];

    // Menyusun query SQL untuk memperbarui data pelanggaran
    $sql = "UPDATE Pelanggaran 
            SET NamaPelanggaran = ?, TingkatID = ? 
            WHERE PelanggaranID = ?";

    // Menyiapkan parameter untuk query
    $params = array($namaPelanggaran, $tingkatID, $pelanggaranID);

    // Menyiapkan statement dan eksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Jika terjadi kesalahan
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirect kembali ke halaman utama setelah berhasil
        header ("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=success");
        // header("Location: kelola_pelanggaran.php?status=success");
        exit();
    }
} else {
    // Jika data tidak ditemukan, redirect dengan status error
    header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=error");
    // header("Location: kelola_pelanggaran.php?status=error");
    exit();
}

// Menutup koneksi
sqlsrv_close($conn);
