<?php
require_once '../../config/database.php';  // Pastikan koneksi DB sudah benar

// Query untuk mengambil daftar jenis pelanggaran
$query = "SELECT PelanggaranID AS pelanggaran_id, NamaPelanggaran AS nama_pelanggaran FROM Pelanggaran";

// Eksekusi query
$stmt = sqlsrv_query($conn, $query);

// Mengecek apakah query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$pelanggaran = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $pelanggaran[] = $row;  // Mengambil hasil dalam bentuk array
}

echo json_encode($pelanggaran);  // Mengirim hasil dalam format JSON

sqlsrv_free_stmt($stmt);  // Membersihkan statement
?>