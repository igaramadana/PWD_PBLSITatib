<?php
// Include konfigurasi koneksi
include("../../config/database.php");

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirim melalui form
    $namaSanksi = trim($_POST['NamaSanksi']);
    $tingkatID = (int)$_POST['TingkatID'];

    // Validasi input
    if (empty($namaSanksi) || empty($tingkatID)) {
        // Jika input kosong, tampilkan pesan error
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Query untuk menyimpan data sanksi baru
    $query = "INSERT INTO Sanksi (NamaSanksi, TingkatID) VALUES (?, ?)";

    // Siapkan parameter untuk query
    $params = array($namaSanksi, $tingkatID);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query, $params);

    // Cek apakah query berhasil dijalankan
    if ($stmt === false) {
        // Jika gagal, tampilkan error
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Jika berhasil, alihkan ke halaman kelola sanksi
        echo "<script>alert('Sanksi berhasil ditambahkan!'); window.location.href = '../../pages/admin/kelola_sanksi.php';</script>";
    }
} else {
    // Jika akses bukan dari form POST, alihkan ke halaman kelola sanksi
    header("Location: ../../pages/admin/kelola_sanksi.php");
    exit;
}
?>
