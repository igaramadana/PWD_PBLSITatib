<?php
// Pastikan koneksi ke database sudah dibuat
require_once '../../config/database.php'; // Sesuaikan dengan koneksi database Anda

// Mulai sesi
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Alihkan ke halaman login jika belum login
    exit();
}

// Ambil UserID dari sesi
$UserID = $_SESSION['user_id'];

// Query untuk mengambil data dosen
$sql = "SELECT DosenID, NIP, Nama, JKDosen, PhoneDosen, EmailDosen, ProfilDosen FROM Dosen WHERE UserID = ?";
$params = array($UserID);

// Menyiapkan dan mengeksekusi query
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Mengecek hasil query
if (sqlsrv_has_rows($stmt)) {
    // Ambil data dosen
    $dosen = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    // Jika tidak ada data mahasiswa ditemukan
    echo "Data tidak ditemukan.";
}
?>