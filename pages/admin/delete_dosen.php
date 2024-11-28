<?php
include '../../config/database.php';

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $dosenID = $_GET['id'];

    // Mulai transaksi untuk memastikan penghapusan dilakukan secara atomik
    sqlsrv_begin_transaction($conn);

    try {
        // 1. Mengambil UserID yang terkait dengan DosenID
        $getUserIDQuery = "SELECT UserID FROM Dosen WHERE DosenID = ?";
        $getUserIDStmt = sqlsrv_query($conn, $getUserIDQuery, array($dosenID));

        if ($getUserIDStmt === false) {
            throw new Exception("Gagal mengambil UserID dari tabel Dosen: " . print_r(sqlsrv_errors(), true));
        }

        // Ambil UserID dari hasil query
        $userIDRow = sqlsrv_fetch_array($getUserIDStmt, SQLSRV_FETCH_ASSOC);
        if (!$userIDRow) {
            throw new Exception("Dosen dengan DosenID {$dosenID} tidak ditemukan.");
        }

        $userID = $userIDRow['UserID'];

        // 2. Hapus data dosen dari tabel Dosen
        $deleteDosenQuery = "DELETE FROM Dosen WHERE DosenID = ?";
        $deleteDosenStmt = sqlsrv_query($conn, $deleteDosenQuery, array($dosenID));

        if ($deleteDosenStmt === false) {
            throw new Exception("Gagal menghapus data dari tabel Dosen: " . print_r(sqlsrv_errors(), true));
        }

        // 3. Hapus data pengguna (user) terkait dari tabel Users
        $deleteUserQuery = "DELETE FROM Users WHERE UserID = ?";
        $deleteUserStmt = sqlsrv_query($conn, $deleteUserQuery, array($userID));

        if ($deleteUserStmt === false) {
            throw new Exception("Gagal menghapus data dari tabel Users: " . print_r(sqlsrv_errors(), true));
        }

        // Jika semua query berhasil, commit transaksi
        sqlsrv_commit($conn);

        // Redirect ke daftar dosen setelah berhasil menghapus
        header("Location: daftar_dosen.php");
        exit();
    } catch (Exception $e) {
        // Jika terjadi error, rollback transaksi
        sqlsrv_rollback($conn);
        die("Error: " . $e->getMessage());
    }
} else {
    die("Error: DosenID tidak valid.");
}
?>
