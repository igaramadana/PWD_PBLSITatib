<?php
// Konfigurasi koneksi database menggunakan driver sqlsrv

$serverName = "pop-os"; // Ganti dengan nama server Anda
$connectionOptions = array(
    "Database" => "DBEthicX", // Ganti dengan nama database Anda
    "Uid" => "sa", // Ganti dengan username SQL Server Anda
    "PWD" => "Igaramadana123#" // Ganti dengan password SQL Server Anda
);

// Membuat koneksi ke database menggunakan sqlsrv_connect
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Mengecek apakah koneksi berhasil
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika koneksi gagal
}