<?php
include('../config/database.php');

// Periksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['NIM'];
    $nama = $_POST['Nama'];
    $jurusan = $_POST['Jurusan'];
    $prodi = $_POST['Prodi'];
    $kelas = $_POST['Kelas'];

    if (empty($nim) || empty($nama) || empty($jurusan) || empty($prodi) || empty($kelas)) {
        die("Semua field harus diisi");
    }

    $query = "INSERT INTO Mahasiswa (NIM, Nama, Jurusan, Prodi, Kelas) VALUES (?, ?, ?, ?, ?)";

    $params = array($nim, $nama, $jurusan, $prodi, $kelas);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    echo "Pendaftaran berhasil! Anda telah terdaftar sebagai mahasiswa.";
    echo "<br><a href='page-login.php'>Klik di sini untuk login</a>";
} else {
    echo "Perintah tidak valid";
}
