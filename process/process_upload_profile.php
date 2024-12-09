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

// Ambil UserID dan Role dari sesi
$UserID = $_SESSION['user_id'];
$role = $_SESSION['role']; // Pastikan session role ada yang menandakan apakah itu dosen atau mahasiswa

// Cek apakah file telah di-upload
if (isset($_FILES['fotoProfil'])) {
    // Ambil file gambar
    $file = $_FILES['fotoProfil'];
    $fileName = $_FILES['fotoProfil']['name'];
    $fileTmpName = $_FILES['fotoProfil']['tmp_name'];
    $fileSize = $_FILES['fotoProfil']['size'];
    $fileError = $_FILES['fotoProfil']['error'];

    // Tentukan ekstensi file yang diperbolehkan
    $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Cek apakah ekstensi file valid
    if (in_array($fileExt, $allowedExts)) {
        // Cek apakah ada error saat upload
        if ($fileError === 0) {
            // Tentukan lokasi penyimpanan file
            $newFileName = uniqid('', true) . '.' . $fileExt;
            $fileDestination = '../assets/uploads/' . $newFileName;

            // Pindahkan file ke folder yang ditentukan
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Update database dengan nama file baru berdasarkan role
                if ($role == 'dosen') {
                    // Jika user adalah dosen, update tabel Dosen
                    $sql = "UPDATE Dosen SET ProfilDosen = ? WHERE UserID = ?";
                    $params = array($newFileName, $UserID);
                } else if ($role == 'mahasiswa') {
                    // Jika user adalah mahasiswa, update tabel Mahasiswa
                    $sql = "UPDATE Mahasiswa SET FotoProfil = ? WHERE UserID = ?";
                    $params = array($newFileName, $UserID);
                }

                // Eksekusi query untuk update
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                // Redirect kembali ke halaman profil setelah berhasil upload
                if ($role == 'dosen') {
                    header("Location: ../pages/dosen/profile_dosen.php"); // Redirect ke profil dosen
                } else {
                    header("Location: ../pages/mahasiswa/profile.php"); // Redirect ke profil mahasiswa
                }
                exit();
            } else {
                echo "Terjadi kesalahan saat memindahkan file ke server.";
            }
        } else {
            // Menampilkan error upload file
            echo "Error saat mengupload file: " . $fileError;
        }
    } else {
        echo "Ekstensi file tidak diperbolehkan. Hanya file gambar yang diperbolehkan.";
    }
} else {
    echo "Tidak ada file yang diupload.";
}
