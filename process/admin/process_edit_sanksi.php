<?php
include "../../config/database.php";

// Mengecek apakah ID sanksi ada di URL
if (isset($_GET['id'])) {
    $sanksiID = $_GET['id'];

    // Mengecek apakah data form telah disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $namaSanksi = $_POST['NamaSanksi'];
        $tingkatID = $_POST['TingkatID'];

        // Query untuk mengupdate data sanksi berdasarkan ID
        $sql = "UPDATE Sanksi SET NamaSanksi = ?, TingkatID = ? WHERE SanksiID = ?";
        $params = array($namaSanksi, $tingkatID, $sanksiID);

        // Menjalankan query
        $stmt = sqlsrv_query($conn, $sql, $params);

        // Cek apakah pengeditan berhasil
        if ($stmt) {
            // Redirect kembali ke halaman kelola sanksi dengan status berhasil
            header("Location: ../../pages/admin/kelola_sanksi.php?status=updated");
        } else {
            // Jika gagal, redirect dengan status error
            header("Location: ../../pages/admin/kelola_sanksi.php?status=error");
        }
    }
} else {
    // Jika ID tidak ditemukan, redirect ke halaman kelola sanksi
    header("Location: ../../pages/admin/kelola_sanksi.php");
}
?>
