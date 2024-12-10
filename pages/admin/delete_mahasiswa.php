<?php
include '../../config/database.php';

// Cek apakah parameter ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID mahasiswa tidak ditemukan.");
}

$MhsID = $_GET['id'];

// Mulai transaksi untuk menghapus data mahasiswa
sqlsrv_begin_transaction($conn);

try {
    // Query untuk mengambil UserID berdasarkan MhsID
    $queryUser = "SELECT UserID FROM Mahasiswa WHERE MhsID = ?";
    $stmtUser = sqlsrv_query($conn, $queryUser, array($MhsID));

    if ($stmtUser === false) {
        throw new Exception("Gagal mengambil data UserID: " . print_r(sqlsrv_errors(), true));
    }

    $user = sqlsrv_fetch_array($stmtUser, SQLSRV_FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Mahasiswa tidak ditemukan.");
    }

    $UserID = $user['UserID'];

    // Query untuk menghapus data mahasiswa dari tabel Mahasiswa
    $deleteMahasiswaQuery = "DELETE FROM Mahasiswa WHERE MhsID = ?";
    $stmtMahasiswa = sqlsrv_query($conn, $deleteMahasiswaQuery, array($MhsID));

    if ($stmtMahasiswa === false) {
        throw new Exception("Gagal menghapus data mahasiswa: " . print_r(sqlsrv_errors(), true));
    }

    // Query untuk menghapus data pengguna dari tabel Users
    $deleteUserQuery = "DELETE FROM Users WHERE UserID = ?";
    $stmtUserDelete = sqlsrv_query($conn, $deleteUserQuery, array($UserID));

    if ($stmtUserDelete === false) {
        throw new Exception("Gagal menghapus data pengguna: " . print_r(sqlsrv_errors(), true));
    }

    // Commit transaksi jika semua query berhasil
    sqlsrv_commit($conn);

    // Redirect ke halaman daftar mahasiswa setelah berhasil dihapus
    header("Location: daftar_mahasiswa.php");
    exit;
} catch (Exception $e) {
    // Rollback transaksi jika ada error
    sqlsrv_rollback($conn);
    echo "Terjadi kesalahan saat menghapus data: " . $e->getMessage();
}
?>
