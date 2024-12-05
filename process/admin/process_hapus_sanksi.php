<?php
include "../../config/database.php";

// Mengecek apakah ID sanksi ada di URL
if (isset($_GET['id'])) {
    $sanksiID = $_GET['id'];

    // Query untuk menghapus data sanksi berdasarkan ID
    $sql = "DELETE FROM Sanksi WHERE SanksiID = ?";
    $params = array($sanksiID);

    // Menjalankan query
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Cek apakah penghapusan berhasil
    if ($stmt) {
        // Redirect kembali ke halaman kelola sanksi dengan status berhasil
        header("Location: ../../pages/admin/kelola_sanksi.php?status=deleted");
    } else {
        // Jika gagal, redirect dengan status error
        header("Location: ../../pages/admin/kelola_sanksi.php?status=error");
    }
} else {
    // Jika ID tidak ditemukan, redirect ke halaman kelola sanksi
    header("Location: ../../pages/admin/kelola_sanksi.php");
}
?>
