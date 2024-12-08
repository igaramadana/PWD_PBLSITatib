<?php
include('../../config/database.php');  // Pastikan koneksi DB sudah benar

$nim = $_GET['nim'];

// Query untuk mengambil data mahasiswa berdasarkan NIM
$query = "SELECT Nama, Kelas, Prodi FROM Mahasiswa WHERE NIM = ?";
$params = array($nim);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt) {
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row) {
        echo json_encode($row); // Mengembalikan data dalam format JSON
    } else {
        echo json_encode(null); // Jika NIM tidak ditemukan
    }
} else {
    echo json_encode(null); // Jika terjadi error dalam query
}

sqlsrv_close($conn);
?>
